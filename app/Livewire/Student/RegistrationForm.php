<?php

namespace App\Livewire\Student;

use App\Models\RegistrationDocument;
use App\Models\Student;
use App\Models\Major;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Carbon\Carbon;

class RegistrationForm extends Component
{
    public $student;
    public $registrationDocument;
    public $showPreview = false;

    public function mount()
    {
        $this->student = Student::with(['classGroup.major', 'classGroup.level', 'level'])
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

    public function selectDocument($id)
    {
        $this->registrationDocument = RegistrationDocument::with(['items.subject', 'major', 'level'])
            ->where('is_active', true)
            ->find($id);

        if ($this->registrationDocument) {
            $this->showPreview = true;
            $this->dispatch('print-requested');
        }
    }

    public function closePreview()
    {
        $this->showPreview = false;
        $this->registrationDocument = null;
    }

    public function downloadPdf()
    {
        if (!$this->registrationDocument) return;

        // ดึงข้อมูลล่าสุดจาก DB
        $document = RegistrationDocument::find($this->registrationDocument->id);
        if (!$document) return;

        $data = $this->preparePdfData($document);

        // โหลด View PDF
        $pdf = Pdf::loadView('livewire.pdf.registration-document.main', $data)->setPaper('a4', 'portrait');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'ใบแจ้งชำระเงิน_' . $this->student->student_code . '.pdf');
    }

    private function preparePdfData($document)
    {
        // 1. Fees
        $fees = $document->items->where('is_subject', false)->map(function ($item) {
            return [
                'name' => $item->name,
                'amount' => $item->amount
            ];
        })->values()->toArray();

        // คำนวณยอดรวมค่าลงทะเบียนแยกต่างหาก (สำหรับไปโชว์ในช่อง "อื่นๆ" ของหน้า 2)
        $totalTuitionAmount = 0;
        foreach ($fees as $fee) {
            if (str_starts_with($fee['name'], 'ค่าลงทะเบียน')) {
                $totalTuitionAmount += (float)$fee['amount'];
            }
        }

        // 2. Total
        $totalAmount = $document->total_amount;
        $bahtText = $this->bahtText($totalAmount);

        // 3. Subjects
        $subjects = $document->items->whereNotNull('subject_id')->map(function ($item) {
            $subj = $item->subject;
            return [
                'code' => $subj->code ?? $subj->subject_code ?? '-',
                'name' => $subj->name ?? $subj->subject_name ?? $item->name,
                'hour_theory' => (int)($subj->theory_hours ?? $subj->hour_theory ?? 0),
                'hour_practical' => (int)($subj->practice_hours ?? $subj->hour_practical ?? 0),
                'credit' => (int)($subj->credits ?? $subj->credit ?? 0),
            ];
        })->values()->toArray();

        // 4. Late Fee Logic
        $levelName = $this->student->level->name ?? '';
        $isBachelor = str_contains($levelName, 'ตรี') || str_contains($levelName, 'Bachelor');

        $lateFeeType = $isBachelor ? 'daily' : ($document->late_fee_type ?? 'flat');
        $lateFeeAmount = (float)($document->late_fee_amount ?? 0);
        $startDate = $document->late_payment_start_date; 
        $maxDays = ($document->late_fee_max_days && $document->late_fee_max_days > 0) ? $document->late_fee_max_days : 15;

        // Helper สำหรับแปลงวันที่ไทย
        $thaiMonths = [
            1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
            5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
            9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม',
        ];
        
        $formatThaiDate = function ($d) use ($thaiMonths) {
            if (!$d) return '...';
            try {
                $d = Carbon::parse($d);
                return $d->day . ' ' . $thaiMonths[$d->month] . ' ' . ($d->year + 543);
            } catch (\Exception $e) { return '-'; }
        };

        // Prepare Data for View
        $lateFeeProps = [
            'show' => ($startDate || $lateFeeAmount > 0),
            'type' => $lateFeeType,
            'header_date' => $formatThaiDate($startDate),
            'amount_flat' => number_format($lateFeeAmount, 0),
            'schedule' => []
        ];

        // Generate Schedule if Daily
        if ($lateFeeType === 'daily' && $startDate && $lateFeeAmount > 0) {
            $startObj = Carbon::parse($startDate);
            for ($i = 1; $i <= $maxDays; $i++) {
                $currDate = $startObj->copy()->addDays($i - 1);
                $fineVal = $lateFeeAmount * $i;
                
                $lateFeeProps['schedule'][] = [
                    'date_full' => $currDate->day . ' ' . $thaiMonths[$currDate->month] . ' ' . ($currDate->year + 543),
                    'amount' => number_format($fineVal, 0),
                    'is_last' => ($i === $maxDays)
                ];
            }
        }

        // Calculate Grand Total (Base + Late Fee)
        $grandTotal = $totalAmount;
        if ($lateFeeProps['show'] && $lateFeeType !== 'daily') {
             $grandTotal += $lateFeeAmount;
        }
        
        $grandBahtText = $this->bahtText($grandTotal);
        
        // Date Range String for Table Header & Footer
        $lateFeeRange = '-';
        if ($startDate) {
             $s = Carbon::parse($startDate);
             $e = $document->late_payment_end_date ? Carbon::parse($document->late_payment_end_date) : null;
             
             if ($e) {
                 if ($s->month == $e->month) {
                     $lateFeeRange = $s->day . " - " . $e->day . " " . $thaiMonths[$s->month] . " " . ($s->year + 543);
                 } else {
                     $lateFeeRange = $s->day . " " . $thaiMonths[$s->month] . " - " . $e->day . " " . $thaiMonths[$e->month] . " " . ($s->year + 543);
                 }
             } else {
                 $lateFeeRange = $s->day . " " . $thaiMonths[$s->month] . " " . ($s->year + 543) . " เป็นต้นไป";
             }
        }

        // วันที่ชำระปกติ (แบบภาษาไทย)
        $payStartText = '-';
        $payEndText = '-';
        if ($document->payment_start_date && $document->payment_end_date) {
            $ps = Carbon::parse($document->payment_start_date);
            $pe = Carbon::parse($document->payment_end_date);
            if ($ps->month == $pe->month) {
                $payNormalRange = $ps->day . " - " . $pe->day . " " . $thaiMonths[$ps->month] . " " . ($ps->year + 543);
            } else {
                $payNormalRange = $ps->day . " " . $thaiMonths[$ps->month] . " - " . $pe->day . " " . $thaiMonths[$pe->month] . " " . ($ps->year + 543);
            }
        } else {
            $payNormalRange = '-';
        }

        // Re-fetch all majors (Logic duplicated from render because PDF generation is separate request context sometimes)
        if (str_contains($levelName, 'ปวส') || str_contains($levelName, 'ชั้นสูง')) $prefix = '3';
        elseif (str_contains($levelName, 'ตรี') || str_contains($levelName, 'Bachelor')) $prefix = '4';
        else $prefix = '2';
        $allMajors = Major::where('major_code', 'like', $prefix . '%')->orderBy('major_code')->get();

        return [
            'isPdf' => true,
            'level_name' => $this->student->level->name ?? '-',
            'semester' => $document->semester,
            'year' => $document->year,
            'fees' => $fees,
            'total_amount' => $totalAmount,
            'baht_text' => $bahtText,
            'title' => $this->student->title,
            'student_name' => $this->student->first_name . ' ' . $this->student->last_name,
            'student_code' => $this->student->student_code,
            'group_code' => $document->custom_ref2 ?? ($this->student->classGroup->name ?? '-'),
            'major_name' => $this->student->classGroup->major->name ?? '-',
            'subjects' => $subjects,
            'payment_normal_range' => $payNormalRange, // ส่งค่าช่วงเวลาปกติแบบภาษาไทย
            'late_fee_props' => $lateFeeProps,
            'grand_total' => $grandTotal,
            'grand_baht_text' => $grandBahtText,
            'late_fee_range' => $lateFeeRange,
            'all_majors' => $allMajors,
            'total_tuition_amount' => $totalTuitionAmount, 
        ];
    }
    
    private function bahtText($amount)
    {
        if ($amount <= 0) return 'ศูนย์บาทถ้วน';
        $number_str = number_format($amount, 2, '.', '');
        $parts = explode('.', $number_str);
        $baht = (int)$parts[0];
        $satang = (int)$parts[1];
        $text = $this->readNumber($baht) . 'บาท';
        $text .= ($satang > 0) ? $this->readNumber($satang) . 'สตางค์' : 'ถ้วน';
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
                if ($pos == 1 && $digit == 1) $text .= '';
                elseif ($pos == 1 && $digit == 2) $text .= 'ยี่';
                elseif ($pos == 0 && $digit == 1 && $len > 1) $text .= 'เอ็ด';
                else $text .= $read_number[$digit];
                $text .= $read_digit[$pos];
            }
        }
        if ($text == 'สิบ') $text = 'หนึ่งสิบ';
        if ($text == '') $text = 'ศูนย์';
        if (strpos($text, 'หนึ่งสิบ') === 0) $text = 'สิบ' . substr($text, 24);
        $text = str_replace('หนึ่งสิบ', 'สิบ', $text);
        return $text;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $documents = RegistrationDocument::where('major_id', $this->student->classGroup->major_id)
            ->where('level_id', $this->student->level_id)
            ->where('is_active', true)
            ->orderBy('id', 'desc')
            ->get();

        $levelName = $this->student->level->name ?? '';
        if (str_contains($levelName, 'ปวส') || str_contains($levelName, 'ชั้นสูง')) $prefix = '3';
        elseif (str_contains($levelName, 'ตรี') || str_contains($levelName, 'Bachelor')) $prefix = '4';
        else $prefix = '2';

        $allMajors = Major::where('major_code', 'like', $prefix . '%')->orderBy('major_code')->get();

        return view('livewire.student.registration-form', [
            'documents' => $documents,
            'allMajors' => $allMajors
        ]);
    }
}