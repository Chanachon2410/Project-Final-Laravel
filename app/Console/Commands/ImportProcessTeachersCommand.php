<?php

namespace App\Console\Commands;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImportProcessTeachersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:process-teachers {file : The path to the CSV file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import teachers from a given CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        $this->info("Processing teacher import for file: {$filePath}");

        if (!file_exists($filePath)) {
            $this->error("File not found at path: {$filePath}");
            return 1;
        }

        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            $this->error("Failed to open file: {$filePath}");
            return 1;
        }

        // Skip header row
        fgetcsv($handle);

        $rowCount = 0;
        $successCount = 0;
        $errorCount = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $rowCount++;
            $teacherCode = $row[0] ?? null;
            $title = $row[1] ?? null;
            $firstname = $row[2] ?? null;
            $lastname = $row[3] ?? null;
            $email = $row[4] ?? ($teacherCode . '@example.com'); // Default email if not provided
            $citizenId = $row[5] ?? '0000000000000'; // Default citizen ID

            if (!$teacherCode || !$firstname || !$lastname) {
                $this->warn("Skipping row {$rowCount}: Missing required data (teacher code, firstname, or lastname).");
                $errorCount++;
                continue;
            }

            DB::beginTransaction();
            try {
                // Find or create the user
                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'username' => $teacherCode,
                        'password' => Hash::make('password'), // Default password
                    ]
                );

                // Assign 'Teacher' role
                $user->assignRole('Teacher');

                // Find or create the teacher
                Teacher::updateOrCreate(
                    ['teacher_code' => $teacherCode],
                    [
                        'title' => $title,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'citizen_id' => $citizenId,
                        'user_id' => $user->id,
                    ]
                );
                
                DB::commit();
                $successCount++;
                $this->line("Processed: {$firstname} {$lastname} ({$teacherCode})");

            } catch (\Exception $e) {
                DB::rollBack();
                $errorCount++;
                $this->error("Failed to process row {$rowCount} for teacher code {$teacherCode}: " . $e->getMessage());
                Log::error("Teacher Import Failed: " . $e->getMessage(), ['row' => $row]);
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