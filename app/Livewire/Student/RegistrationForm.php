<?php

namespace App\Livewire\Student;

use App\Models\PaymentStructure;
use App\Models\Student;
use App\Models\Major;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RegistrationForm extends Component
{
    public $student;
    public $paymentStructure;
    public $showPreview = false;

    public function mount()
    {
        $this->student = Student::with(['classGroup.major', 'classGroup.level', 'level'])
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

    public function selectStructure($id)
    {
        $this->paymentStructure = PaymentStructure::with(['items.subject', 'major', 'level'])->where('is_active', true)->find($id);
        
        if ($this->paymentStructure) {
            $this->showPreview = true;
            // ส่งสัญญาณให้ JavaScript สั่งพิมพ์
            $this->dispatch('print-requested');
        }
    }

    public function closePreview()
    {
        $this->showPreview = false;
        $this->paymentStructure = null;
    }

    public function downloadPdf()
    {
        if (!$this->paymentStructure) return;

        // เตรียมข้อมูล Fees (แยกรายการที่ไม่ใช่วิชาเรียน)
        $fees = $this->paymentStructure->items->where('is_subject', false)->map(function($item) {
            return [
                'name' => $item->name,
                'amount' => $item->amount
            ];
        })->values()->toArray();

        // คำนวณยอดรวมและบาทtext
        $totalAmount = $this->paymentStructure->total_amount;
        $bahtText = $this->bahtText($totalAmount);

        // เตรียมข้อมูล Subjects (เฉพาะที่มี subject_id เชื่อมโยง)
        $subjects = $this->paymentStructure->items->whereNotNull('subject_id')->map(function($item) {
            // ดึง object subject ออกมาเพื่อความสะดวก
            $subj = $item->subject;
            
            return [
                // ตรวจสอบชื่อฟิลด์ที่เป็นไปได้หลายแบบ
                'code' => $subj->code ?? $subj->subject_code ?? '-',
                'name' => $subj->name ?? $subj->subject_name ?? $item->name,
                
                // แปลงเป็น int เพื่อความชัวร์
                'hour_theory' => (int)($subj->theory_hours ?? $subj->hour_theory ?? 0),
                'hour_practical' => (int)($subj->practice_hours ?? $subj->hour_practical ?? 0),
                'credit' => (int)($subj->credits ?? $subj->credit ?? 0),
            ];
        })->values()->toArray();

        // อ่านไฟล์ฟอนต์ (เผื่อไว้ แต่ใน Layout เราใช้ public_path ได้ถ้า config dompdf อนุญาต)
        // แต่การส่งตัวแปร isPdf = true จะไป trigger เงื่อนไขใน view

        $data = [
            'isPdf' => true,
            'level_name' => $this->student->level->name ?? '-',
            'semester' => $this->paymentStructure->semester,
            'year' => $this->paymentStructure->year,
            'fees' => $fees,
            'total_amount' => $totalAmount,
            'baht_text' => $bahtText,
            'title' => $this->student->title,
            'student_name' => $this->student->first_name . ' ' . $this->student->last_name,
            'student_code' => $this->student->student_code,
            'group_code' => $this->paymentStructure->custom_ref2 ?? ($this->student->classGroup->name ?? '-'),
            'major_name' => $this->student->classGroup->major->name ?? '-',
            'subjects' => $subjects,
            'payment_start_date' => $this->paymentStructure->payment_start_date ? \Carbon\Carbon::parse($this->paymentStructure->payment_start_date)->addYears(543)->format('d/m/Y') : '...',
            'payment_end_date' => $this->paymentStructure->payment_end_date ? \Carbon\Carbon::parse($this->paymentStructure->payment_end_date)->addYears(543)->format('d/m/Y') : '...',
        ];

        // เรียกใช้ View ใหม่: livewire.pdf.invoice-main
        $pdf = Pdf::loadView('livewire.pdf.invoice-main', $data)
            ->setPaper('a4', 'portrait');
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'ใบแจ้งชำระเงิน_' . $this->student->student_code . '.pdf');
    }

    private function bahtText($amount)
    {
        if ($amount <= 0) {
            return 'ศูนย์บาทถ้วน';
        }
        
        $number_str = number_format($amount, 2, '.', '');
        $parts = explode('.', $number_str);
        $baht = (int)$parts[0];
        $satang = (int)$parts[1];

        $text = $this->readNumber($baht);
        $text .= 'บาท';

        if ($satang > 0) {
            $text .= $this->readNumber($satang) . 'สตางค์';
        } else {
            $text .= 'ถ้วน';
        }

        return $text;
    }

    private function readNumber($number)
    {
        $read_number = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
        $read_digit = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
        
        $text = '';
        $len = strlen($number);
        
        for ($i = 0; $i < $len; $i++) {
            $digit = substr($number, $i, 1);
            $pos = $len - $i - 1;
            
            if ($digit != 0) {
                if ($pos == 1 && $digit == 1) {
                    $text .= ''; 
                } elseif ($pos == 1 && $digit == 2) {
                    $text .= 'ยี่';
                } elseif ($pos == 0 && $digit == 1 && $len > 1) {
                    $text .= 'เอ็ด';
                } else {
                    $text .= $read_number[$digit];
                }
                
                $text .= $read_digit[$pos];
            }
        }
        
        if ($text == 'สิบ') $text = 'หนึ่งสิบ';
        if ($text == '') $text = 'ศูนย์';
        
        if (strpos($text, 'หนึ่งสิบ') === 0) {
            $text = 'สิบ' . substr($text, 24); // 'หนึ่งสิบ' (UTF-8 bytes varies, safer to replace string)
        }
        $text = str_replace('หนึ่งสิบ', 'สิบ', $text);

        return $text;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $structures = PaymentStructure::where('major_id', $this->student->classGroup->major_id)
            ->where('level_id', $this->student->level_id)
            ->where('is_active', true)
            ->orderBy('id', 'desc')
            ->get();

        // ดึงข้อมูลสาขาวิชาเพื่อแสดงในตารางตัวอย่าง Ref.2
        $levelName = $this->student->level->name ?? '';
        $prefix = (str_contains($levelName, 'ปวส') || str_contains($levelName, 'ชั้นสูง')) ? '3' : '2';

        $allMajors = Major::where('major_code', 'like', $prefix . '%')
                          ->orderBy('major_code')
                          ->get();

        return view('livewire.student.registration-form', [
            'structures' => $structures,
            'allMajors' => $allMajors
        ]);
    }
}
