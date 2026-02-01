<?php

namespace App\Livewire\Registrar;

use App\Models\Level;
use App\Models\Major;
use App\Models\RegistrationDocument;
use App\Models\RegistrationDocumentItem;
use App\Models\Subject;
use App\Models\TuitionFee;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RegistrationDocumentForm extends Component
{
    public $currentStep = 1;
    public ?RegistrationDocument $editingDocument = null;

    // Step 1: Basic Info
    public $semester_id; // Added to link with semesters table
    public $semester = 1;
    public $year;
    public $major_id;
    public $level_id;
    public $custom_ref2;
    public $payment_start_date;
    public $payment_end_date;
    public $late_payment_start_date;
    public $late_payment_end_date;

    // Late Fee Config
    public $late_fee_type = 'flat';
    public $late_fee_amount = 0;
    public $late_fee_max_days = null;
    
    // Calculator Properties
    public $calculate_days;
    public $late_fee_max_amount;

    // Step 2: Subjects & Credit Calculation
    public $searchSubject = '';
    public $selectedSubjects = []; 
    public $totalTheoryCredits = 0;
    public $totalPracticalCredits = 0;
    public $theoryRate = 100;    // Default rate
    public $practicalRate = 100; // Default rate

    // Step 3: Fees
    public $searchFee = '';
    public $fees = [];

    public function mount($document = null)
    {
        // Handle case where $document is passed as an ID (from route parameter without implicit binding)
        if ($document && !($document instanceof RegistrationDocument)) {
            $document = RegistrationDocument::find($document);
        }

        if ($document && $document instanceof RegistrationDocument && $document->exists) {
            $this->editingDocument = $document;
            $this->populateForEdit();
        } else {
            // Try to find currently active semester
            $activeSemester = \App\Models\Semester::where('is_active', true)->first();
            if ($activeSemester) {
                $this->semester_id = $activeSemester->id;
                $this->populateFromSemester($activeSemester);
            } else {
                $this->year = date('Y') + 543;
            }
        }
    }

    public function populateForEdit()
    {
        $doc = $this->editingDocument;
        $this->semester = $doc->semester;
        $this->year = $doc->year;
        
        $semester = \App\Models\Semester::where('semester', $doc->semester)
                                      ->where('year', $doc->year)
                                      ->first();
        if ($semester) {
            $this->semester_id = $semester->id;
        }

        $this->major_id = $doc->major_id;
        $this->level_id = $doc->level_id;
        $this->custom_ref2 = $doc->custom_ref2;
        $this->payment_start_date = $doc->payment_start_date ? $doc->payment_start_date->format('Y-m-d') : null;
        $this->payment_end_date = $doc->payment_end_date ? $doc->payment_end_date->format('Y-m-d') : null;
        $this->late_payment_start_date = $doc->late_payment_start_date ? $doc->late_payment_start_date->format('Y-m-d') : null;
        $this->late_payment_end_date = $doc->late_payment_end_date ? $doc->late_payment_end_date->format('Y-m-d') : null;
        $this->late_fee_type = $doc->late_fee_type;
        $this->late_fee_amount = $doc->late_fee_amount;
        $this->late_fee_max_days = $doc->late_fee_max_days;
        
        $this->calculate_days = $doc->late_fee_max_days;
        $this->calculateMaxFee();

        foreach ($doc->items as $item) {
            if ($item->is_subject) {
                // Try to get subject details to ensure we have the code
                $subject = Subject::find($item->subject_id);
                $code = $subject ? $subject->subject_code : ''; // Fallback if subject deleted
                
                $this->selectedSubjects[$item->subject_id] = [
                    'id' => $item->subject_id,
                    'code' => $code,
                    'name' => $item->name,
                    'credit' => $item->credit,
                    'hour_theory' => $item->theory_hour,
                    'hour_practical' => $item->practical_hour,
                ];
            } else {
                $this->fees[] = [
                    'id' => null,
                    'name' => $item->name,
                    'amount' => (float)$item->amount,
                ];
            }
        }
        
        $this->calculateCredits();
    }

    public function updatedSemesterId($value)
    {
        if ($value) {
            $semester = \App\Models\Semester::find($value);
            if ($semester) {
                $this->populateFromSemester($semester);
            }
        }
    }

    private function populateFromSemester($semester)
    {
        $this->semester = $semester->semester;
        $this->year = $semester->year;
        $this->payment_start_date = $semester->registration_start_date->format('Y-m-d');
        $this->payment_end_date = $semester->registration_end_date->format('Y-m-d');
        
        $this->late_payment_start_date = $semester->late_registration_start_date ? $semester->late_registration_start_date->format('Y-m-d') : '';
        $this->late_payment_end_date = $semester->late_registration_end_date ? $semester->late_registration_end_date->format('Y-m-d') : '';
    }
    
    public function updatedCalculateDays($value)
    {
        $this->late_fee_max_days = $value;
        $this->calculateMaxFee();
    }
    
    public function updatedLateFeeAmount($value)
    {
        $this->calculateMaxFee();
    }
    
    public function calculateMaxFee()
    {
        if (is_numeric($this->late_fee_amount) && is_numeric($this->calculate_days)) {
            $this->late_fee_max_amount = (float)$this->late_fee_amount * (float)$this->calculate_days;
        }
    }

    public function updatedPaymentEndDate($value)
    {
        if ($value) {
            try {
                $endDate = \Carbon\Carbon::parse($value);
                $this->late_payment_start_date = $endDate->addDay()->format('Y-m-d');
            } catch (\Exception $e) {}
        }
    }

    public function updatedLevelId($value)
    {
        // Only clear major if changing level manually and not during initial edit load (handled by mount)
        // But livewire calls this on every update. 
        // We can check if major_id is already set and compatible? 
        // Simpler: If user changes level, major usually becomes invalid.
        // But during mount, we set level_id, which might trigger this?
        // No, updatedLevelId is only called on user interaction (frontend update).
        
        if (!$value) {
            $this->major_id = null;
            $this->custom_ref2 = '';
        } else {
            // Check if current major is valid for this level?
            // For now, just reset major if it doesn't match? 
            // Let's just keep it simple as before.
            $this->major_id = null;
            $this->custom_ref2 = '';
        }
    }

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
        $semesters = \App\Models\Semester::orderBy('year', 'desc')->orderBy('semester', 'desc')->get();
        $majors = collect();

        if ($this->level_id) {
            $level = Level::find($this->level_id);
            if ($level) {
                if (str_contains($level->name, 'ปวส') || str_contains($level->name, 'ชั้นสูง')) {
                    $prefix = '3';
                } elseif (str_contains($level->name, 'ตรี') || str_contains($level->name, 'Bachelor')) {
                    $prefix = '4';
                } else {
                    $prefix = '2';
                }
                
                $majors = Major::where('major_code', 'like', $prefix . '%')
                               ->orderBy('major_code')
                               ->get();
            }
        }
        
        $subjects = collect();
        if ($this->currentStep == 2) {
            $subjects = Subject::where('subject_name', 'like', '%' . $this->searchSubject . '%')
                        ->orWhere('subject_code', 'like', '%' . $this->searchSubject . '%')
                        ->take(20)
                        ->get();
        }

        $availableFees = collect();
        if ($this->currentStep == 3) {
            $query = TuitionFee::query();
            if (!empty($this->searchFee)) {
                $query->where('fee_name', 'like', '%' . $this->searchFee . '%');
            }
            $availableFees = $query->orderBy('year', 'desc')
                                   ->orderBy('semester', 'desc')
                                   ->get();
        }

        return view('livewire.registrar.registration-document-form', [
            'majors' => $majors,
            'levels' => $levels,
            'semesters' => $semesters,
            'subjects' => $subjects,
            'availableFees' => $availableFees,
        ]);
    }

    public function nextStep()
    {
        $this->validateStep();
        
        if ($this->currentStep == 2) {
            $this->calculateTuitionFees();
        }

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
                'custom_ref2' => 'nullable|string|max:20',
                'payment_start_date' => 'nullable|date',
                'payment_end_date' => 'nullable|date|after_or_equal:payment_start_date',
                'late_fee_type' => 'required|in:flat,daily',
                'late_fee_amount' => 'required|numeric|min:0',
                'late_fee_max_days' => 'nullable|required_if:late_fee_type,daily|integer|min:1',
            ]);
        }
    }

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
        $this->calculateCredits();
    }

    public function calculateCredits()
    {
        $this->totalTheoryCredits = 0;
        $this->totalPracticalCredits = 0;

        foreach ($this->selectedSubjects as $subj) {
            $t = (int)$subj['hour_theory']; 
            $p = (float)$subj['credit'] - $t; 
            
            $this->totalTheoryCredits += $t;
            $this->totalPracticalCredits += max(0, $p);
        }
    }

    public function calculateTuitionFees()
    {
        $this->fees = array_filter($this->fees, function($item) {
            return !str_contains($item['name'], 'หน่วยกิตละ');
        });

        $level = Level::find($this->level_id);
        if ($level && str_contains($level->name, 'ปวช')) {
            $this->fees = array_values($this->fees);
            return;
        }

        if ($this->totalTheoryCredits > 0) {
            $amount = $this->totalTheoryCredits * $this->theoryRate;
            if ($amount > 0) {
                $this->fees[] = [
                    'id' => null,
                    'name' => "ค่าลงทะเบียน (ทฤษฎี) หน่วยกิตละ {$this->theoryRate} บาท ({$this->totalTheoryCredits} หน่วยกิต)",
                    'amount' => $amount
                ];
            }
        }

        if ($this->totalPracticalCredits > 0) {
            $amount = $this->totalPracticalCredits * $this->practicalRate;
            if ($amount > 0) {
                $this->fees[] = [
                    'id' => null,
                    'name' => "ค่าลงทะเบียน (ปฏิบัติ) หน่วยกิตละ {$this->practicalRate} บาท ({$this->totalPracticalCredits} หน่วยกิต)",
                    'amount' => $amount
                ];
            }
        }
        
        $this->fees = array_values($this->fees);
    }

    public function removeFee($index)
    {
        unset($this->fees[$index]);
        $this->fees = array_values($this->fees);
    }

    public function selectFee($feeId)
    {
        $fee = TuitionFee::find($feeId);
        if ($fee) {
            $this->fees[] = [
                'id' => $fee->id,
                'name' => $fee->fee_name,
                'amount' => (float)$fee->rate_money
            ];
        }
    }

    public function addCustomFee()
    {
        $this->fees[] = [
            'id' => null,
            'name' => '',
            'amount' => 0.00
        ];
    }

    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->fees as $fee) {
            $total += (float)$fee['amount'];
        }
        return $total;
    }
    
    public function getBahtText()
    {
        return '-'; 
    }

    public function save()
    {
        $major = Major::find($this->major_id);
        $level = Level::find($this->level_id);
        $documentName = "เอกสารลงทะเบียน {$major->major_name} {$level->name} {$this->semester}/{$this->year}";

        $data = [
            'name' => $documentName,
            'semester' => $this->semester,
            'year' => $this->year,
            'major_id' => $this->major_id,
            'level_id' => $this->level_id,
            'custom_ref2' => $this->custom_ref2,
            'payment_start_date' => $this->payment_start_date,
            'payment_end_date' => $this->payment_end_date,
            'late_payment_start_date' => $this->late_payment_start_date,
            'late_payment_end_date' => $this->late_payment_end_date,
            'late_fee_type' => $this->late_fee_type,
            'late_fee_amount' => $this->late_fee_amount,
            'late_fee_max_days' => $this->late_fee_type == 'daily' ? $this->late_fee_max_days : null,
        ];

        if ($this->editingDocument) {
            $this->editingDocument->update($data);
            $document = $this->editingDocument;
            $document->items()->delete();
            $message = "แก้ไขเอกสาร \"{$document->name}\" สำเร็จ!";
        } else {
            $document = RegistrationDocument::create($data);
            $message = "สร้างเอกสาร \"{$document->name}\" สำเร็จ!";
        }

        $sortOrder = 1;

        // Save subjects ONLY if NOT PWC (ปวช.)
        if (!str_contains($level->name, 'ปวช')) {
            foreach ($this->selectedSubjects as $subj) {
                RegistrationDocumentItem::create([
                    'registration_document_id' => $document->id,
                    'name' => $subj['name'],
                    'amount' => 0, 
                    'is_subject' => true,
                    'subject_id' => $subj['id'],
                    'credit' => $subj['credit'],
                    'theory_hour' => $subj['hour_theory'],
                    'practical_hour' => $subj['hour_practical'],
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        foreach ($this->fees as $fee) {
            if (!empty($fee['name'])) {
                RegistrationDocumentItem::create([
                    'registration_document_id' => $document->id,
                    'name' => $fee['name'],
                    'amount' => $fee['amount'],
                    'is_subject' => false,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        session()->flash('message', $message);
        return redirect()->route('registrar.registration-documents.index');
    }
}