<?php

namespace App\Imports;

use App\Models\ClassGroup;
use App\Models\Level;
use App\Models\Major;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ClassGroupsImport implements ToCollection, WithStartRow
{
    private $levels;
    private $majors;
    private $teachers;

    public $summary = [
        'created' => 0,
        'updated' => 0,
    ];

    public function __construct()
    {
        // ปลดล็อกเวลา Timeout (สำคัญมากสำหรับ 119 ชีต)
        ini_set('max_execution_time', 0);
        set_time_limit(0);

        $this->levels = Level::all()->keyBy('name');
        $this->majors = Major::all();
        $this->teachers = Teacher::with('user')->get()->keyBy(function ($teacher) {
            return strtolower(trim($teacher->firstname) . ' ' . trim($teacher->lastname));
        });
    }

    public function startRow(): int
    {
        return 1;
    }

    public function collection(Collection $rows)
    {
        // เช็ค Header
        if (!isset($rows[6]) || !isset($rows[7])) {
            return;
        }

        $courseGroupCode = trim($rows[6][2] ?? '');
        $majorString     = trim($rows[6][4] ?? '');
        $classInfoString = trim($rows[7][2] ?? '');
        $teacherFullName = trim($rows[7][4] ?? '');

        if (!$courseGroupCode) return;

        try {
            // --- Prepare Metadata ---
            $level = $this->getOrCreateLevel($classInfoString);

            // ค้นหา Major (แก้ไข Logic แล้ว)
            $major = $this->getExistingMajorOrTemp($majorString, $classInfoString);

            $teacher = $this->getOrCreateTeacher($teacherFullName);

            // --- Class Group ---
            $classGroup = ClassGroup::updateOrCreate(
                ['course_group_code' => $courseGroupCode],
                [
                    'course_group_name'  => $majorString,
                    'level_id'           => $level->id,
                    'level_year'         => $this->extractLevelYear($level->name),
                    'class_room'         => $this->extractClassRoom($classInfoString),
                    'major_id'           => $major->id,
                    'teacher_advisor_id' => $teacher ? $teacher->id : null,
                ]
            );

            // --- Students ---
            $studentRows = $rows->slice(10);
            foreach ($studentRows as $row) {
                $studentCode = trim($row[2] ?? '');
                $fullName    = trim($row[3] ?? '');

                if (!$studentCode || !$fullName) continue;

                $citizenId = isset($row[1]) ? str_replace([' ', '-'], '', $row[1]) : null;
                $nameParts = $this->parseName($fullName);

                // 1. User
                $user = User::updateOrCreate(
                    ['username' => $studentCode],
                    [
                        'email'    => $studentCode . '@student.example.com',
                        'password' => Hash::make($citizenId),
                    ]
                );

                if (!$user->hasRole('student')) {
                    $user->assignRole('student');
                }

                // 2. Student
                $student = Student::updateOrCreate(
                    ['student_code' => $studentCode],
                    [
                        'title'          => $nameParts['title'],
                        'firstname'      => $nameParts['firstname'],
                        'lastname'       => $nameParts['lastname'],
                        'citizen_id'     => $citizenId,
                        'class_group_id' => $classGroup->id,
                        'level_id'       => $level->id,
                        'user_id'        => $user->id,
                    ]
                );

                if ($student->wasRecentlyCreated) {
                    $this->summary['created']++;
                } else {
                    $this->summary['updated']++;
                }
            }
        } catch (\Exception $e) {
            // Log Error แต่ไม่ throw เพื่อให้ชีตถัดไปทำงานต่อได้
            Log::error("❌ ข้ามชีต {$courseGroupCode} เนื่องจาก: " . $e->getMessage());
        }
    }

    // --- Helper Methods (แก้ตรงนี้!) ---

    private function getExistingMajorOrTemp($majorString, $classInfoString)
    {
        // ❌ ลบอันเก่าที่ทำให้ 'เ' หายออกไป
        // ✅ ใช้แค่ trim ปกติพอ
        $inputName = trim($majorString);

        // 2. Determine Target Prefix
        $targetPrefix = '';
        $isPwsOrBachelor = false;

        if (str_contains($classInfoString, 'ปวช')) {
            $targetPrefix = '2';
        } elseif (str_contains($classInfoString, 'ปวส')) {
            $targetPrefix = '3';
            $isPwsOrBachelor = true;
        } elseif (str_contains($classInfoString, 'ป.ตรี') || str_contains($classInfoString, 'ปริญญาตรี')) {
            $targetPrefix = '4';
            $isPwsOrBachelor = true;
        }

        // 3. Resolve Name Mappings
        $resolvedName = $this->resolveMajorName($inputName, $isPwsOrBachelor);

        // 4. Find in Database
        $foundMajor = $this->majors->first(function ($item) use ($resolvedName, $targetPrefix) {
            $nameMatch = $item->major_name === $resolvedName;
            $codeMatch = $targetPrefix ? str_starts_with($item->major_code, $targetPrefix) : true;
            return $nameMatch && $codeMatch;
        });

        // Priority 2: Name Only
        if (!$foundMajor) {
            $foundMajor = $this->majors->first(function ($item) use ($resolvedName) {
                return $item->major_name === $resolvedName;
            });
        }

        if ($foundMajor) {
            return $foundMajor;
        }

        throw new \Exception("ไม่พบสาขาวิชา: '{$majorString}' (แปลงเป็น: '{$resolvedName}')");
    }

    private function resolveMajorName($name, $isPwsOrBachelor)
    {
        // ✅ เพิ่ม 'u' flag ท้าย Regex เพื่อรองรับ UTF-8 (ภาษาไทย)
        // ลบตัวเลขท้ายคำ เช่น "การบัญชี 1" -> "การบัญชี"
        $cleanName = trim(preg_replace('/\s+\d+$/u', '', $name));

        // Mapping ชื่อเฉพาะ
        if (str_contains($name, 'ธุรกิจค้าปลีกสมัยใหม่')) {
            return $isPwsOrBachelor ? 'การจัดการธุรกิจค้าปลีก' : 'ธุรกิจค้าปลีก';
        }
        if (str_contains($name, 'ภาษาต่างประเทศ')) {
            return 'ภาษาต่างประเทศธุรกิจบริการ';
        }
        if (str_contains($name, 'คอมพิวเตอร์ธุรกิจ')) {
            return 'เทคโนโลยีธุรกิจดิจิทัล';
        }
        if (str_contains($name, 'ธุรกิจอาหารและบริการ')) {
            return 'อาหารและโภชนาการ';
        }
        if (str_contains($name, 'คอมพิวเตอร์กราฟิก')) {
            return 'ดิจิทัลกราฟิก';
        }
        if (str_contains($name, 'แฟชั่นดีไซน์') || str_contains($name, 'เทคโนโลยีแฟชั่นและเครื่องแต่งกาย')) {
            return $isPwsOrBachelor ? 'เทคโนโลยีออกแบบแฟชั่นและเครื่องแต่งกาย' : 'แฟชั่นและสิ่งทอ';
        }
        if (str_contains($name, 'คหกรรมเพื่อการโรงแรม')) {
            return $isPwsOrBachelor ? 'การบริหารงานคหกรรมศาสตร์' : 'คหกรรมศาสตร์';
        }
        if (str_contains($name, 'การออกแบบ')) {
            return $isPwsOrBachelor ? 'ออกแบบนิเทศศิลป์' : 'การออกแบบ';
        }
        // เพิ่ม Case นี้ให้ครับ เผื่อมันมาเป็น "เทคโนโลยีสารสนเทศ 1"
        if (str_contains($name, 'เทคโนโลยีสารสนเทศ')) {
            return $isPwsOrBachelor ? 'เทคโนโลยีสารสนเทศ' : 'เทคโนโลยีสารสนเทศ'; // ชื่อเหมือนกันทั้ง ปวช/ปวส แต่รหัสต่างกัน (Logic prefix จะจัดการเอง)
        }
        // เพิ่ม Case สำหรับ "เทคโนโลยีธุรกิจดิจิทัล" 
        if (str_contains($name, 'เทคโนโลยีธุรกิจดิจิทัล')) {
            return $isPwsOrBachelor ? 'เทคโนโลยีธุรกิจดิจิทัล' : 'เทคโนโลยีธุรกิจดิจิทัล';
        }

        return $cleanName;
    }

    // --- ส่วนอื่นเหมือนเดิม ---
    private function parseName(string $fullName): array
    {
        $fullName = trim(preg_replace('/\s+/', ' ', $fullName));
        $prefixes = ['ว่าที่ร้อยตรี', 'นางสาว', 'นาย', 'นาง', 'ด.ช.', 'ด.ญ.', 'Mr.', 'Mrs.', 'Ms.', 'Miss'];
        $title = '';
        foreach ($prefixes as $prefix) {
            if (str_starts_with($fullName, $prefix)) {
                $title = $prefix;
                $fullName = Str::replaceFirst($prefix, '', $fullName);
                break;
            }
        }
        $fullName = trim($fullName);
        $parts = explode(' ', $fullName);
        return ['title' => $title, 'firstname' => $parts[0] ?? '', 'lastname' => implode(' ', array_slice($parts, 1))];
    }
    private function getOrCreateLevel($name)
    {
        $cleanName = trim(explode('/', $name)[0] ?? $name);
        return $this->levels->get($cleanName) ?? $this->levels->get($name) ?? Level::create(['name' => $cleanName]);
    }
    private function getOrCreateTeacher($fullName)
    {
        if (!$fullName) return null;
        $parts = $this->parseName($fullName);
        $key = strtolower($parts['firstname'] . ' ' . $parts['lastname']);
        if ($found = $this->teachers->get($key)) return $found;
        $u = User::create(['username' => 't_' . Str::random(5), 'email' => Str::random(5) . '@t.com', 'password' => Hash::make('123')]);
        if (!$u->hasRole('teacher')) {
            $u->assignRole('teacher');
        }
        $t = Teacher::create(['user_id' => $u->id, 'firstname' => $parts['firstname'], 'lastname' => $parts['lastname'], 'title' => $parts['title']]);
        $this->teachers->put($key, $t);
        return $t;
    }
    private function extractLevelYear($name)
    {
        preg_match('/(\d+)/', $name, $m);
        return $m[1] ?? 1;
    }
    private function extractClassRoom($name)
    {
        $p = explode('/', $name);
        return trim($p[1] ?? '1');
    }
}
