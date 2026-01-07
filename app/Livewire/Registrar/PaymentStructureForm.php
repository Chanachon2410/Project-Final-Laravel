<?php

namespace App\Livewire\Registrar;

use App\Models\Level;
use App\Models\Major;
use App\Models\PaymentStructure;
use App\Models\PaymentStructureItem;
use App\Models\Subject;
use App\Models\TuitionFee;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PaymentStructureForm extends Component
{
    public $currentStep = 1;

    // Step 1: Basic Info
    public $semester = 1;
    public $year;
    public $major_id;
    public $level_id;
    public $custom_ref2; // เพิ่มตัวแปร
    public $payment_start_date;
    public $payment_end_date;
    public $late_payment_start_date;
    public $late_payment_end_date;

    // Step 2: Subjects
    public $searchSubject = '';
    public $selectedSubjects = []; 

    // Step 3: Fees
    public $searchFee = '';
    public $fees = []; // [ ['name' => '...', 'amount' => ... ] ]

    public function mount()
    {
        $this->year = date('Y') + 543; // Thai Year default
    }

    // Auto-calculate Late Payment Start Date
    public function updatedPaymentEndDate($value)
    {
        if ($value) {
            try {
                $endDate = \Carbon\Carbon::parse($value);
                $this->late_payment_start_date = $endDate->addDay()->format('Y-m-d');
            } catch (\Exception $e) {
                // Handle invalid date format if necessary
            }
        }
    }

    // เมื่อมีการเลือกสาขาวิชา ให้ดึงรหัสสาขา (major_code) มาใส่ใน custom_ref2 อัตโนมัติ
    public function updatedMajorId($value)
    {
        if ($value) {
            $major = Major::find($value);
            if ($major) {
                $this->custom_ref2 = $major->major_code;
            }
        } else {
            $this->custom_ref2 = '';
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $levels = Level::all();
        $majors = collect(); // Default empty

        if ($this->level_id) {
            $level = Level::find($this->level_id);
            if ($level) {
                // Determine prefix based on level name
                $prefix = (str_contains($level->name, 'ปวส') || str_contains($level->name, 'ชั้นสูง')) ? '3' : '2';
                
                $majors = Major::where('major_code', 'like', $prefix . '%')
                               ->orderBy('major_code')
                               ->get();
            }
        }
        
        // Filter subjects for Step 2
        $subjects = collect();
        if ($this->currentStep == 2) {
            $subjects = Subject::where('subject_name', 'like', '%' . $this->searchSubject . '%')
                        ->orWhere('subject_code', 'like', '%' . $this->searchSubject . '%')
                        ->take(20)
                        ->get();
        }

        // Filter fees for Step 3
        $availableFees = collect();
        if ($this->currentStep == 3) {
            $query = TuitionFee::query();
            
            // Allow searching by name
            if (!empty($this->searchFee)) {
                $query->where('fee_name', 'like', '%' . $this->searchFee . '%');
            }

            // Order by matching year/semester first, then others
            // Note: In raw SQL this is easier, in Eloquent we can just order by year desc, semester desc to show latest.
            // Or we can just show ALL fees for now so the user can see them.
            $availableFees = $query->orderBy('year', 'desc')
                                   ->orderBy('semester', 'desc')
                                   ->get();
        }

        return view('livewire.registrar.payment-structure-form', [
            'majors' => $majors,
            'levels' => $levels,
            'subjects' => $subjects,
            'availableFees' => $availableFees,
        ]);
    }

    // Navigation
    public function nextStep()
    {
        $this->validateStep();
        $this->currentStep++;
    }

    public function prevStep()
    {
        $this->currentStep--;
    }

    public function validateStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'semester' => 'required',
                'year' => 'required',
                'major_id' => 'required',
                'level_id' => 'required',
                'custom_ref2' => 'nullable|string|max:20', // Validate
                'payment_start_date' => 'nullable|date',
                'payment_end_date' => 'nullable|date|after_or_equal:payment_start_date',
            ]);
        }
        // Step 2 validation is optional (can have no subjects?) -> User flow implies selecting subjects.
        // Let's assume at least one subject is needed? No, maybe just fees. Allowing empty.
    }

    // Step 2 Logic
    public function toggleSubject($subjectId)
    {
        $subject = Subject::find($subjectId);
        if (!$subject) return;

        if (isset($this->selectedSubjects[$subjectId])) {
            unset($this->selectedSubjects[$subjectId]);
        }
        else {
            $this->selectedSubjects[$subjectId] = [
                'id' => $subject->id,
                'code' => $subject->subject_code,
                'name' => $subject->subject_name,
                'credit' => $subject->credit,
                'hour_theory' => $subject->hour_theory,
                'hour_practical' => $subject->hour_practical,
            ];
        }
    }

    // Step 3 Logic
    public function addCustomFee()
    {
        $this->fees[] = ['name' => '', 'amount' => 0];
    }

    public function selectFee($feeId)
    {
        $fee = TuitionFee::find($feeId);
        if ($fee) {
            $this->fees[] = [
                'name' => $fee->fee_name,
                'amount' => $fee->rate_money
            ];
        }
    }

    public function removeFee($index)
    {
        unset($this->fees[$index]);
        $this->fees = array_values($this->fees);
    }

    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->fees as $fee) {
            $total += (float)$fee['amount'];
        }
        // Subjects usually don't have individual price in this context unless specified, 
        // usually it's calculated as "Registration Fee" based on total credits.
        // But for now, I'll sum just the explicit fees.
        return $total;
    }
    
    public function getTotalCredits()
    {
        return collect($this->selectedSubjects)->sum('credit');
    }

    public function getBahtText()
    {
        $service = new \App\Services\FeeCalculationService();
        return $service->getThaiBahtText($this->calculateTotal());
    }

    // Final Action
    public function save()
    {
        // 1. Create Structure
        $major = Major::find($this->major_id);
        $level = Level::find($this->level_id);
        $structureName = "ใบแจ้งหนี้ {$major->major_name} {$level->name} {$this->semester}/{$this->year}";

        $structure = PaymentStructure::create([
            'name' => $structureName,
            'semester' => $this->semester,
            'year' => $this->year,
            'major_id' => $this->major_id,
            'level_id' => $this->level_id,
            'company_code' => '81245',
            'custom_ref2' => $this->custom_ref2, // บันทึกค่า
            'payment_start_date' => $this->payment_start_date,
            'payment_end_date' => $this->payment_end_date,
            'late_payment_start_date' => $this->late_payment_start_date,
            'late_payment_end_date' => $this->late_payment_end_date,
        ]);

        // 2. Save Subjects
        $sortOrder = 1;
        foreach ($this->selectedSubjects as $subj) {
            PaymentStructureItem::create([
                'payment_structure_id' => $structure->id,
                'name' => $subj['name'],
                'amount' => 0, // Subjects in Thai Voc usually 0 here, calculated via Credit Fee item
                'is_subject' => true,
                'subject_id' => $subj['id'],
                'credit' => $subj['credit'],
                'theory_hour' => $subj['hour_theory'],
                'practical_hour' => $subj['hour_practical'],
                'sort_order' => $sortOrder++,
            ]);
        }

        // 3. Save Fees
        foreach ($this->fees as $fee) {
            if (!empty($fee['name'])) {
                PaymentStructureItem::create([
                    'payment_structure_id' => $structure->id,
                    'name' => $fee['name'],
                    'amount' => $fee['amount'],
                    'is_subject' => false,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        session()->flash('message', 'สร้างใบแจ้งหนี้สำเร็จ!');
        return redirect()->to('/registrar/dashboard'); // Assuming a dashboard exists, or just reload
    }
}