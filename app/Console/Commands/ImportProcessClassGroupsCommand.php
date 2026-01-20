<?php

namespace App\Console\Commands;

use App\Models\ClassGroup;
use App\Models\Level;
use App\Models\Major;
use App\Models\Teacher;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportProcessClassGroupsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:process-class-groups {file : The path to the CSV file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import class groups from a given CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        $this->info("Processing class group import for file: {$filePath}");

        if (!file_exists($filePath)) {
            $this->error("File not found at path: {$filePath}");
            return 1;
        }

        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            $this->error("Failed to open file: {$filePath}");
            return 1;
        }

        fgetcsv($handle); // Skip header

        $rowCount = 0;
        $successCount = 0;
        $errorCount = 0;
        
        $levelCache = [];
        $majorCache = [];
        $teacherCache = [];

        while (($row = fgetcsv($handle)) !== false) {
            $rowCount++;
            $courseGroupCode = $row[0] ?? null;
            $courseGroupName = $row[1] ?? null;
            $levelName = $row[2] ?? null;
            $classRoom = $row[3] ?? null;
            $levelYear = $row[4] ?? null;
            $majorName = $row[5] ?? null;
            $advisorTeacherCode = $row[6] ?? null;

            if (!$courseGroupCode || !$courseGroupName || !$levelName || !$levelYear || !$majorName) {
                $this->warn("Skipping row {$rowCount}: Missing required data.");
                $errorCount++;
                continue;
            }

            // --- Lookups ---
            if (!isset($levelCache[$levelName])) {
                $levelCache[$levelName] = Level::where('name', $levelName)->first();
            }
            $level = $levelCache[$levelName];

            if (!$level) {
                $this->warn("Skipping row {$rowCount}: Level '{$levelName}' not found.");
                $errorCount++;
                continue;
            }

            if (!isset($majorCache[$majorName])) {
                $majorCache[$majorName] = Major::where('major_name', $majorName)->first();
            }
            $major = $majorCache[$majorName];

            if (!$major) {
                $this->warn("Skipping row {$rowCount}: Major '{$majorName}' not found.");
                $errorCount++;
                continue;
            }
            
            $teacher = null;
            if ($advisorTeacherCode) {
                if (!isset($teacherCache[$advisorTeacherCode])) {
                    $teacherCache[$advisorTeacherCode] = Teacher::where('teacher_code', $advisorTeacherCode)->first();
                }
                $teacher = $teacherCache[$advisorTeacherCode];
                if (!$teacher) {
                    $this->warn("Skipping row {$rowCount}: Advisor with code '{$advisorTeacherCode}' not found, but proceeding without advisor.");
                }
            }
            
            // --- Process ---
            try {
                ClassGroup::updateOrCreate(
                    ['course_group_code' => $courseGroupCode],
                    [
                        'course_group_name' => $courseGroupName,
                        'level_id' => $level->id,
                        'class_room' => $classRoom,
                        'level_year' => $levelYear,
                        'major_id' => $major->id,
                        'teacher_advisor_id' => $teacher ? $teacher->id : null,
                    ]
                );

                $successCount++;
                $this->line("Processed: {$courseGroupName} ({$courseGroupCode})");

            } catch (\Exception $e) {
                $errorCount++;
                $this->error("Failed to process row {$rowCount} for group code {$courseGroupCode}: " . $e->getMessage());
                Log::error("Class Group Import Failed: " . $e->getMessage(), ['row' => $row]);
            }
        }

        fclose($handle);

        $this->info("\nImport Complete.");
        $this->info("Total Rows: {$rowCount}");
        $this->info("Successfully Imported: {$successCount}");
        $this->error("Failed: {$errorCount}");

        return 0;
    }
}