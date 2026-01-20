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

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv,txt'
        ]);

        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $filePath = $this->file->getRealPath();
        $extension = strtolower($this->file->getClientOriginalExtension());
        $tempCsvPath = null;

        try {
            // (Step 1: แปลงไฟล์เป็น CSV เหมือนเดิม... ไม่ต้องแก้ส่วนนี้)
            if (in_array($extension, ['xlsx', 'xls'])) {
                $spreadsheet = IOFactory::load($filePath);
                $spreadsheet->setActiveSheetIndex(0);
                $writer = IOFactory::createWriter($spreadsheet, 'Csv');
                $writer->setDelimiter(',');
                $writer->setEnclosure('"');
                $writer->setLineEnding("\r\n");
                $writer->setSheetIndex(0);
                $writer->setUseBOM(true);
                $tempCsvPath = storage_path('app/temp_import_' . time() . '.csv');
                $writer->save($tempCsvPath);
                $filePath = $tempCsvPath;
            }

            // ---------------------------------------------------------
            // 🟢 Step 2: Import และดึงยอดสรุป (แก้ตรงนี้)
            // ---------------------------------------------------------

            // สร้าง Object ขึ้นมาก่อน เพื่อให้เราเข้าถึงตัวแปร $summary ทีหลังได้
            $importer = new ClassGroupsImport();

            // สั่ง Import โดยใช้ Object ตัวเดิม
            Excel::import($importer, $filePath);

            // ดึงค่าสรุปออกมา
            $created = $importer->summary['created'];
            $updated = $importer->summary['updated'];

            // แจ้งเตือนแบบละเอียด
            session()->flash('message', "✅ สำเร็จ! ข้อมูลใหม่: {$created} รายการ | อัปเดตข้อมูลเดิม: {$updated} รายการ");

            $this->reset('file');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Import Error: ' . $e->getMessage());
            session()->flash('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        } finally {
            if ($tempCsvPath && file_exists($tempCsvPath)) {
                unlink($tempCsvPath);
            }
        }
    }

    public function render()
    {
        return view('livewire.registrar.import-data');
    }
}
