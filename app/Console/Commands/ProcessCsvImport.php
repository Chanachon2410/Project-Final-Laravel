<?php

namespace App\Console\Commands;

use App\Models\ClassGroup;
use App\Models\Level;
use App\Models\Major;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ProcessCsvImport extends Command
{
    protected $signature = 'import:process-csv {file}';
    protected $description = 'Process a single CSV file exported from a class group sheet.';

    private $teacherRole;
    private $studentRole;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->teacherRole = Role::firstOrCreate(['name' => 'Teacher', 'guard_name' => 'web']);
        $this->studentRole = Role::firstOrCreate(['name' => 'Student', 'guard_name' => 'web']);

        $filePath = $this->argument('file');
        $this->line("\n<fg=cyan>--- Processing CSV File: " . basename($filePath) . " ---</>");

        try {
            $csvData = array_map('str_getcsv', file($filePath));

            $headerData = $this->extractHeaderData($csvData);
            if (!$headerData) {
                $this->error("Skipping file: Could not find all required header information.");
                return 1;
            }
            
            $this->info("Processing Class Group: '{$headerData['classGroupName']}' ({$headerData['classGroupCode']})");

            DB::transaction(function () use ($csvData, $headerData) {
                $teacher = $this->findOrCreateTeacher($headerData['advisorFullName']);
                $level = $this->findOrCreateLevel($headerData['levelYearString']);
                $major = $this->findOrCreateMajor($headerData['classGroupName']);
                $levelYear = $this->parseLevelYear($headerData['levelYearString']);
                $classRoom = $this->parseClassRoom($headerData['levelYearString']); // Parse class room

                $classGroup = ClassGroup::firstOrCreate(
                    ['course_group_code' => $headerData['classGroupCode']],
                    [
                        'course_group_name' => $headerData['classGroupName'],
                        'level_id' => $level->id,
                        'major_id' => $major->id,
                        'teacher_advisor_id' => $teacher->id,
                        'level_year' => $levelYear,
                        'class_room' => $classRoom, // Add class room to creation data
                    ]
                );
                $this->line("  <fg=green>✓</> Class Group '{$classGroup->course_group_name}' (Room: {$classRoom}) processed.");

                $studentDataRows = $this->extractStudentDataRows($csvData);
                foreach ($studentDataRows as $row) {
                    $citizenId = $row[1] ?? null;
                    $studentCode = $row[2] ?? null;
                    $studentFullName = $row[3] ?? null;

                    if (!empty($studentCode) && !empty($studentFullName)) {
                        $this->findOrCreateStudent($studentCode, $studentFullName, $citizenId, $classGroup, $level);
                    }
                }
            });

            $this->info("<fg=green>Successfully imported all data for this CSV.</>");
            return 0;

        } catch (Exception $e) {
            $this->error("An error occurred: " . $e->getMessage());
            return 1;
        }
    }
    
    private function extractHeaderData(array $csvData): ?array
    {
        $data = [];
        $data['classGroupCode'] = trim($csvData[6][2] ?? null);
        $data['classGroupName'] = trim($csvData[6][4] ?? null);
        $data['levelYearString'] = trim($csvData[7][2] ?? null);
        $data['advisorFullName'] = trim($csvData[7][4] ?? null);

        if (!empty($data['classGroupCode']) && !empty($data['classGroupName']) && !empty($data['levelYearString']) && !empty($data['advisorFullName'])) {
            return $data;
        }
        return null;
    }

    private function extractStudentDataRows(array $csvData): array
    {
        $startRow = 0;
        foreach ($csvData as $rowIndex => $row) {
            if (isset($row[0]) && $row[0] === 'ลำดับ' && isset($row[3]) && str_contains($row[3], 'ชื่อ - สกุล')) {
                $startRow = $rowIndex + 1;
                break;
            }
        }
        return ($startRow > 0) ? array_slice($csvData, $startRow) : [];
    }

    private function findOrCreateTeacher(string $fullName): Teacher
    {
        $nameParts = $this->parseNameParts($fullName);
        
        $teacher = Teacher::where('firstname', $nameParts['firstName'])->where('lastname', $nameParts['lastName'])->first();
        if ($teacher) {
            $this->line("  <fg=yellow>Found existing teacher:</> {$fullName}");
            return $teacher;
        }

        $this->line("  <fg=green>Creating new teacher:</> {$fullName}");
        $username = 't' . str_pad(User::count() + 1, 5, '0', STR_PAD_LEFT);
        
        $user = User::create(['username' => $username, 'email' => $username.'@example.com', 'password' => Hash::make($username)]);
        $user->assignRole($this->teacherRole);

        return Teacher::create([
            'user_id' => $user->id, 'teacher_code' => $username, 'title' => $nameParts['title'],
            'firstname' => $nameParts['firstName'], 'lastname' => $nameParts['lastName'], 'citizen_id' => '0000000000000'
        ]);
    }

    private function findOrCreateStudent(string $studentCode, string $fullName, ?string $citizenId, ClassGroup $classGroup, Level $level): void
    {
        if (Student::where('student_code', $studentCode)->exists()) {
            return;
        }

        $this->line("    <fg=green>Creating new student:</> {$fullName} ({$studentCode})");
        $nameParts = $this->parseNameParts($fullName);
        
        if (empty($nameParts['firstName']) && empty($nameParts['lastName'])) {
            $this->line("    <fg=red>Skipping invalid student name:</> {$fullName}");
            return;
        }

        $user = User::create(['username' => $studentCode, 'email' => $studentCode.'@example.com', 'password' => Hash::make($studentCode)]);
        $user->assignRole($this->studentRole);

        Student::create([
            'user_id' => $user->id, 'student_code' => $studentCode, 'firstname' => $nameParts['firstName'],
            'lastname' => $nameParts['lastName'], 'citizen_id' => $citizenId ?? '0000000000000',
            'level_id' => $level->id, 'class_group_id' => $classGroup->id
        ]);
    }

    private function findOrCreateLevel(string $levelYearString): Level
    {
        preg_match('/(ปวช\.\s*\d+|ปวส\.\s*\d+|ปริญญาตรี\s*ปีที่\s*\d+)/u', $levelYearString, $matches);
        $levelName = trim($matches[0] ?? '');
        if (empty($levelName)) throw new Exception("Could not find level in '{$levelYearString}'");
        return Level::firstOrCreate(['name' => $levelName]);
    }
    
    private function parseLevelYear(string $levelYearString): int
    {
        preg_match('/(\d+)\/\d+/', $levelYearString, $matches);
        return $matches[1] ?? 1;
    }
    
    private function parseClassRoom(string $levelYearString): ?string
    {
        if (str_contains($levelYearString, '/')) {
            $parts = explode('/', $levelYearString);
            return $parts[1] ?? null;
        }
        return null;
    }

    private function findOrCreateMajor(string $classGroupName): Major
    {
        $majorName = trim(preg_replace('/\s*\d+$/', '', $classGroupName));
        if (empty($majorName)) throw new Exception("Could not find major in '{$classGroupName}'");
        return Major::firstOrCreate(['major_name' => $majorName], ['major_code' => 'GEN' . rand(1000, 9999)]);
    }

    private function parseNameParts(string $fullName): array
    {
        $parts = preg_split('/\s+/u', trim($fullName));
        $title = ''; $firstName = ''; $lastName = '';
        $titles = ['นาย', 'นาง', 'นางสาว', 'น.ส.', 'ดร.'];

        if (count($parts) > 0 && in_array($parts[0], $titles)) {
            $title = array_shift($parts);
        }

        if (count($parts) > 1) {
            $lastName = array_pop($parts);
            $firstName = implode(' ', $parts);
        } elseif (count($parts) > 0) {
            $firstName = $parts[0];
        }
        
        return compact('title', 'firstName', 'lastName');
    }
}
