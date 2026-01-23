<?php

namespace App\Livewire\Student;

use App\Models\Registration;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class RegistrationUpload extends Component
{
    use WithFileUploads;

    public $registration_card_file;
    public $slip_file_name;
    public $registrations;
    public $activeSemester;
    
    // For viewing evidence
    public $selectedRegistration = null;
    public $isViewModalOpen = false;

    protected $rules = [
        'registration_card_file' => 'required|file|mimes:pdf,jpg,png|max:5120',
        'slip_file_name' => 'required|file|mimes:pdf,jpg,png|max:5120',
    ];

    public function mount()
    {
        $this->loadRegistrations();
        $this->activeSemester = Semester::where('is_active', true)->first();
    }

    public function viewEvidence($id)
    {
        $this->selectedRegistration = Registration::find($id);
        if ($this->selectedRegistration) {
            $this->isViewModalOpen = true;
        }
    }

    public function closeViewModal()
    {
        $this->isViewModalOpen = false;
        $this->selectedRegistration = null;
    }

    public function render()
    {
        return view('livewire.student.registration-upload');
    }

    public function saveRegistration()
    {
        \Illuminate\Support\Facades\Log::info('saveRegistration started');
        
        try {
            $this->validate();
            \Illuminate\Support\Facades\Log::info('Validation passed');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Validation failed: ' . $e->getMessage());
            throw $e;
        }

        if (!$this->activeSemester) {
            \Illuminate\Support\Facades\Log::warning('No active semester');
            $this->dispatch('swal:error', message: 'ไม่พบภาคเรียนที่เปิดใช้งานในขณะนี้');
            return;
        }

        $student = Student::where('user_id', Auth::id())->first();
        
        if (!$student) {
            \Illuminate\Support\Facades\Log::error('Student not found for user ID: ' . Auth::id());
            $this->dispatch('swal:error', message: 'ไม่พบข้อมูลนักเรียนในระบบ');
            return;
        }

        \Illuminate\Support\Facades\Log::info('Processing registration for student: ' . $student->id);

        // Check if already registered for this semester
        $existing = Registration::where('student_id', $student->id)
            ->where('semester', $this->activeSemester->semester)
            ->where('year', $this->activeSemester->year)
            ->first();

        if ($existing && $existing->status === 'approved') {
            \Illuminate\Support\Facades\Log::info('Registration already approved');
            $this->dispatch('swal:error', message: 'คุณได้ลงทะเบียนและได้รับการอนุมัติสำหรับภาคเรียนนี้แล้ว');
            return;
        }

        try {
            $registrationCardPath = $this->registration_card_file->store('registration_cards', 'public');
            $slipPath = $this->slip_file_name->store('slips', 'public');
            
            \Illuminate\Support\Facades\Log::info('Files stored: ' . $registrationCardPath . ' and ' . $slipPath);

            if ($existing) {
                $existing->update([
                    'status' => 'pending',
                    'registration_card_file' => $registrationCardPath,
                    'slip_file_name' => $slipPath,
                ]);
                \Illuminate\Support\Facades\Log::info('Updated existing registration ID: ' . $existing->id);
            } else {
                $newReg = Registration::create([
                    'student_id' => $student->id,
                    'semester' => $this->activeSemester->semester,
                    'year' => $this->activeSemester->year,
                    'status' => 'pending',
                    'registration_card_file' => $registrationCardPath,
                    'slip_file_name' => $slipPath,
                ]);
                \Illuminate\Support\Facades\Log::info('Created new registration ID: ' . $newReg->id);
            }

            $this->dispatch('swal:success', message: 'อัปโหลดหลักฐานการลงทะเบียนสำเร็จ');
            $this->reset(['registration_card_file', 'slip_file_name']);
            $this->loadRegistrations();
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error saving registration: ' . $e->getMessage());
            $this->dispatch('swal:error', message: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $e->getMessage());
        }
    }

    public function downloadPdf($id)
    {
        return redirect()->route('pdf.download.registration', ['registrationId' => $id]);
    }

    private function loadRegistrations()
    {
        $student = Student::where('user_id', Auth::id())->first();
        if ($student) {
            $this->registrations = Registration::where('student_id', $student->id)
                ->orderByDesc('year')
                ->orderByDesc('semester')
                ->get();
        } else {
            $this->registrations = collect();
        }
    }
}