<?php

namespace App\Livewire\Registrar;

use App\Imports\ClassGroupsImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

#[Layout('layouts.app')]
class ImportData extends Component
{
    use WithFileUploads;

    public $file;

    public function cancel()
    {
        $this->reset('file');
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv,txt'
        ]);

        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $originalFilePath = $this->file->getRealPath();
        $extension = strtolower($this->file->getClientOriginalExtension());
        $tempCsvPaths = [];

        // สร้าง Object เดียวเพื่อเก็บยอดรวมจากทุกชีต
        $importer = new ClassGroupsImport();
        $sheetCount = 0;

        try {
            if (in_array($extension, ['xlsx', 'xls'])) {
                // Load Excel file once
                $spreadsheet = IOFactory::load($originalFilePath);
                $sheetCount = $spreadsheet->getSheetCount();

                // Loop through all sheets
                for ($i = 0; $i < $sheetCount; $i++) {
                    $spreadsheet->setActiveSheetIndex($i);
                    $sheetName = $spreadsheet->getActiveSheet()->getTitle();
                    
                    // Create CSV writer for the current sheet
                    $writer = IOFactory::createWriter($spreadsheet, 'Csv');
                    $writer->setDelimiter(',');
                    $writer->setEnclosure('"');
                    $writer->setLineEnding("\r\n");
                    $writer->setSheetIndex($i);
                    $writer->setUseBOM(true);
                    
                    // Unique temp path for this sheet
                    $tempCsvPath = storage_path('app/temp_import_' . time() . '_sheet_' . $i . '.csv');
                    $writer->save($tempCsvPath);
                    $tempCsvPaths[] = $tempCsvPath;

                    // Import this specific sheet's CSV
                    try {
                        Excel::import($importer, $tempCsvPath);
                    } catch (\Exception $e) {
                        // Log error per sheet but continue others if possible, or just log info
                        \Illuminate\Support\Facades\Log::warning("Import warning on sheet {$i} ({$sheetName}): " . $e->getMessage());
                    }
                }
            } else {
                // Handle CSV/TXT directly (single file)
                $sheetCount = 1;
                Excel::import($importer, $originalFilePath);
            }

            // ดึงค่าสรุปออกมา
            $created = $importer->summary['created'];
            $updated = $importer->summary['updated'];

            // แจ้งเตือน
            session()->flash('message', "✅ สำเร็จ! นำเข้าข้อมูลจาก {$sheetCount} ชีต | ข้อมูลใหม่: {$created} รายการ | อัปเดตข้อมูลเดิม: {$updated} รายการ");

            $this->reset('file');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Import Error: ' . $e->getMessage());
            session()->flash('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        } finally {
            // Cleanup all temp files
            foreach ($tempCsvPaths as $path) {
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.registrar.import-data');
    }
}
