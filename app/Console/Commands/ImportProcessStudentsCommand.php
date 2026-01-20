<?php

namespace App\Console\Commands;

use App\Models\ClassGroup;
use App\Models\Level;
use App\Models\Major;
use App\Models\Student;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ImportProcessStudentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:process-students {file : The path to the CSV file} {--level=} {--room=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import students from a given CSV file for a specific level and room';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        $levelName = $this->option('level');
        $room = $this->option('room');

        if (!$levelName || !$room) {
            $this->error("This command requires a --level and --room option.");
            return 1;
        }

        $this->info("Processing student import for Level='{$levelName}', Room='{$room}' from file: {$filePath}");

        // Find the Level first
        $level = Level::where('name', $levelName)->first();
        if (!$level) {
            $this->error("FATAL: Level '{$levelName}' not found in the database. Aborting sheet processing.");
            return 1;
        }

        // --- File Processing ---
        if (!file_exists($filePath)) {
            $this->error("File not found at path: {$filePath}");
            return 1;
        }

        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            $this->error("Failed to open file: {$filePath}");
            return 1;
        }
        
        $rowCount = 0;
        $successCount = 0;
        $errorCount = 0;
        $classGroupCache = [];
        $defaultMajor = Major::first(); // Get a default major to satisfy foreign key constraint

        if(!$defaultMajor) {
            $this->error("FATAL: No Majors found in the database. Cannot create default Class Groups. Please seed Majors first.");
            return 1;
        }

        // --- Find or Create Class Group once for the entire sheet ---
        $classGroup = ClassGroup::where('level_id', $level->id)->where('class_room', $room)->first();
        
        if (!$classGroup) {
            $this->warn("Class Group for Level '{$levelName}'/Room '{$room}' not found. Creating it with default values...");
            
            preg_match('/(\d+)/', $levelName, $yearMatches);
            $levelYear = $yearMatches[0] ?? 1;

            $classGroup = ClassGroup::create([
                'level_id' => $level->id,
                'class_room' => $room,
                'course_group_name' => $levelName . '/' . $room,
                'course_group_code' => $level->id . '-' . $room . '-' . time(), // Add timestamp to ensure uniqueness
                'level_year' => (int)$levelYear,
                'major_id' => $defaultMajor->id,
            ]);
            $this->info("Created new Class Group '{$classGroup->course_group_name}' with ID: {$classGroup->id}");
        }
        $classGroupCache[$level->id . '-' . $room] = $classGroup; // Cache it for this sheet

        // Skip header row
        fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            $rowCount++;
            // Skip header/garbage rows based on the first column not being a simple number
            if (empty($row[0]) || !is_numeric($row[0])) {
                continue;
            }

            // --- Column Mapping based on Screenshot ---
            $citizenId = $row[1] ?? null;
            $studentCode = $row[2] ?? null;
            $fullName = $row[3] ?? null;

            if (!$studentCode || !$fullName) {
                $this->warn("Skipping row {$rowCount}: Missing Student Code or Full Name.");
                $errorCount++;
                continue;
            }

            // --- Parse Full Name ---
            $nameParts = preg_split('/\s+/', $fullName, 3);
            $title = $nameParts[0] ?? '';
             if (!str_contains($fullName, ' ')) { // Simple check if there's a space for actual parsing
                 $firstname = $title; // Assume the whole thing is a firstname if no space
                 $title = '-'; // Default title if no space
                 $lastname = '-'; // Default lastname if no space
            } else {
                 $firstname = $nameParts[1] ?? '';
                 $lastname = $nameParts[2] ?? '-';
            }

            // --- Process Data ---
            DB::beginTransaction();
            try {
                $user = User::updateOrCreate(
                    ['username' => $studentCode],
                    [
                        'email' => $studentCode . '@school.ac.th',
                        'password' => Hash::make(substr($citizenId, -6, 6)),
                    ]
                );
                $user->assignRole('Student');

                Student::updateOrCreate(
                    ['student_code' => $studentCode],
                    [
                        'user_id' => $user->id,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'level_id' => $level->id,
                        'citizen_id' => $citizenId,
                        'class_group_id' => $classGroup->id, // Use the found/created classGroup
                    ]
                );
                
                DB::commit();
                $successCount++;
                
            } catch (
Exception $e) {
                DB::rollBack();
                $errorCount++;
                $this->error("Failed to process row {$rowCount} for student code {$studentCode}: " . $e->getMessage());
                Log::error("Student Import Failed: " . $e->getMessage(), ['row' => $row]);
            }
        }

        fclose($handle);

        $this->info("\nSheet Import Complete.");
        $totalProcessedRows = $errorCount + $successCount;
        $this->info("Total Data Rows Analyzed: {$totalProcessedRows}");
        $this->info("Successfully Imported: {$successCount}");
        $this->error("Failed: {$errorCount}");

        return 0;
    }
}