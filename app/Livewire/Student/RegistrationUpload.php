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

    protected $rules = [
        'registration_card_file' => 'required|file|mimes:pdf,jpg,png|max:2048',
        'slip_file_name' => 'required|file|mimes:pdf,jpg,png|max:2048',
    ];

    public function mount()
    {
        $this->loadRegistrations();
        $this->activeSemester = Semester::where('is_active', true)->first();
    }

    public function render()
    {
        return view('livewire.student.registration-upload');
    }

    public function upload()
    {
        $this->validate();

        if (!$this->activeSemester) {
            $this->dispatch('swal:error', message: 'No active semester found.');
            return;
        }

        $student = Student::where('user_id', Auth::id())->firstOrFail();

        // Check if already registered for this semester
        $existing = Registration::where('student_id', $student->id)
            ->where('semester', $this->activeSemester->semester)
            ->where('year', $this->activeSemester->year)
            ->first();

        if ($existing && $existing->status === 'approved') {
            $this->dispatch('swal:error', message: 'You have already registered for this semester.');
            return;
        }

        $registrationCardPath = $this->registration_card_file->store('registration_cards', 'public');
        $slipPath = $this->slip_file_name->store('slips', 'public');

        if ($existing) {
            // Update existing if rejected or pending
            $existing->update([
                'status' => 'pending',
                'registration_card_file' => $registrationCardPath,
                'slip_file_name' => $slipPath,
            ]);
        } else {
            Registration::create([
                'student_id' => $student->id,
                'semester' => $this->activeSemester->semester,
                'year' => $this->activeSemester->year,
                'status' => 'pending',
                'registration_card_file' => $registrationCardPath,
                'slip_file_name' => $slipPath,
            ]);
        }

        $this->dispatch('swal:success', message: 'Documents uploaded successfully.');
        $this->reset(['registration_card_file', 'slip_file_name']);
        $this->loadRegistrations();
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
