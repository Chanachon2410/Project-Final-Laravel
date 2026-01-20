<?php

namespace App\Console\Commands;

use App\Imports\FullDataImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ProcessExcelFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:all-sheets {file : The path to the Excel file in storage}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports all sheets from a given Excel file, creating class groups and students.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        $this->info("Starting master import from file: {$filePath}");
        $this->info("This may take a while...");

        try {
            Excel::import(new FullDataImport(), $filePath, 'local');
            $this->info("Successfully processed the Excel file.");
        } catch (\Exception $e) {
            $this->error("An error occurred during the import process: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}