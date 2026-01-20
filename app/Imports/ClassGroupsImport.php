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

    // 🟢 เพิ่มตัวแปรเก็บยอดสรุป (Public เพื่อให้ Livewire ดึงไปใช้ได้)
    public $summary = [
        'created' => 0,
        'updated' => 0,
    ];

    public function __construct()
    {
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
        Log::info("--- เริ่มต้น Import ---");

        if (!isset($rows[6]) || !isset($rows[7])) {
            return;
        }

        $courseGroupCode = trim($rows[6][2] ?? '');
        $majorString     = trim($rows[6][4] ?? '');
        $classInfoString = trim($rows[7][2] ?? '');
        $teacherFullName = trim($rows[7][4] ?? '');

        if (!$courseGroupCode) return;

        // --- Prepare Metadata ---
        $level = $this->getOrCreateLevel($classInfoString);
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

        $studentRows = $rows->slice(10);
        foreach ($studentRows as $row) {
            $studentCode = trim($row[2] ?? '');
            $fullName    = trim($row[3] ?? '');
            if (!$studentCode || !$fullName) continue;

            $citizenId = isset($row[1]) ? str_replace([' ', '-'], '', $row[1]) : null;
            $nameParts = $this->parseName($fullName);

            // 1. User: เปลี่ยนเป็น updateOrCreate เพื่อให้ Password อัปเดตตาม Excel เสมอ
            $user = User::updateOrCreate(
                ['username' => $studentCode],
                [
                    'email'      => $studentCode . '@student.example.com',
                    'password'   => Hash::make($citizenId), // อัปเดตพาสเวิร์ดตามบัตร ปชช ล่าสุด
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

            // 🟢 เช็คว่า "สร้างใหม่" หรือ "อัปเดต"
            if ($student->wasRecentlyCreated) {
                $this->summary['created']++;
            } else {
                $this->summary['updated']++;
            }
        }
    }

    // --- Helper Methods (เหมือนเดิมเป๊ะ ไม่ต้องแก้) ---
    private function getExistingMajorOrTemp($majorString, $classInfoString)
    {
        $inputName = trim($majorString);
        $exactMatch = $this->majors->firstWhere('major_name', $inputName);
        if ($exactMatch) return $exactMatch;
        $targetPrefix = '';
        if (str_contains($classInfoString, 'ปวช')) {
            $targetPrefix = '2';
        } elseif (str_contains($classInfoString, 'ปวส')) {
            $targetPrefix = '3';
        }
        $keyword = trim(preg_replace('/[0-9]+/', '', $inputName));
        $foundMajor = $this->majors->first(function ($item) use ($keyword, $targetPrefix) {
            $nameMatch = str_contains($item->major_name, $keyword);
            $codeMatch = true;
            if ($targetPrefix) {
                $codeMatch = str_starts_with($item->major_code, $targetPrefix);
            }
            return $nameMatch && $codeMatch;
        });
        if ($foundMajor) return $foundMajor;
        $newMajor = Major::create(['major_name' => $inputName, 'major_code' => 'TEMP-' . strtoupper(Str::random(6))]);
        $this->majors->push($newMajor);
        return $newMajor;
    }
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
