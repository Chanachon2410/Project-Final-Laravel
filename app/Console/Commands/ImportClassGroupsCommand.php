<?php

namespace App\Console\Commands;

use App\Imports\ClassGroupsImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class ImportClassGroupsCommand extends Command
{
    /**
     * The name and signature of the console command.
     * The {file} argument will capture the path to the Excel file.
     *
     * @var string
     */
    protected $signature = 'import:class-groups {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import class groups, teachers, and students from a structured Excel file.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("File not found at path: {$filePath}");
            return 1; // Failure
        }
        
        // Add a check to ensure the file is readable
        if (!is_readable($filePath)) {
            $this->error("File is not readable. Check permissions for: {$filePath}");
            return 1;
        }

        $this->info("🚀 Starting import process for: " . basename($filePath));

        try {
            // Here we delegate the entire complex logic to our dedicated importer class.
            // We pass the command's output instance to the importer so it can log messages back to the console.
            Excel::import(new ClassGroupsImport($this->getOutput()), $filePath);

            $this->info("✅ Import process completed successfully.");

        } catch (Exception $e) {
            $this->error("❌ An error occurred during the import process: " . $e->getMessage());
            $this->error("Check the log file for more details (storage/logs/laravel.log)");
            // Log the full exception for debugging
            logger()->error($e);
            return 1; // Failure
        }

        return 0; // Success
    }
}
