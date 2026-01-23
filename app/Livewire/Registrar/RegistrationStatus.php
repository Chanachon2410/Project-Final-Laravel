<?php

namespace App\Livewire\Registrar;

use App\Models\Registration;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class RegistrationStatus extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $statusFilter = '';

    // Modal properties
    public $isShowProofModalOpen = false;
    public $selectedRegistration = null;
    public $selectedStudent = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }
    
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function paginationView()
    {
        return 'vendor.pagination.custom-white';
    }

    public function viewProof($studentId)
    {
        $this->selectedStudent = Student::with(['registrations' => function($q) {
            $q->latest();
        }, 'classGroup', 'level'])->find($studentId);

        if ($this->selectedStudent) {
            $this->selectedRegistration = $this->selectedStudent->registrations->first();
            $this->isShowProofModalOpen = true;
        }
    }

    public function closeProofModal()
    {
        $this->isShowProofModalOpen = false;
        $this->selectedRegistration = null;
        $this->selectedStudent = null;
    }

    public function approveRegistration($registrationId)
    {
        $this->updateStatus($registrationId, 'approved');
        // $this->isShowProofModalOpen = false; // Keep open or close depending on UX, usually close
    }

    public function rejectRegistration($registrationId)
    {
        $this->updateStatus($registrationId, 'rejected');
    }

    public function updateStatus($registrationId, $status, $studentId = null)
    {
        $registration = null;

        if ($registrationId) {
            $registration = Registration::find($registrationId);
        } elseif ($studentId) {
            // Create new registration if not exists
            $student = Student::find($studentId);
            if ($student) {
                // Check if already exists to prevent duplicates via race condition
                $registration = Registration::where('student_id', $studentId)->latest()->first();
                if (!$registration) {
                    // Find active semester to get semester and year
                    $activeSemester = \App\Models\Semester::where('is_active', true)->first();
                    
                    if (!$activeSemester) {
                        $this->dispatch('swal:error', message: 'ไม่สามารถดำเนินการได้ เนื่องจากยังไม่ได้ตั้งค่าภาคเรียนปัจจุบัน');
                        return;
                    }

                    $registration = new Registration();
                    $registration->student_id = $studentId;
                    $registration->semester = $activeSemester->semester;
                    $registration->year = $activeSemester->year;
                }
            }
        }

        if ($registration) {
            $data = ['status' => $status];
            
            if ($status === 'approved') {
                $user = auth()->user();
                $approverName = 'ฝ่ายทะเบียน (' . ($user->username ?? $user->name) . ')';
                $data['approved_by'] = $approverName;
            } elseif ($status === 'pending' || $status === 'rejected') {
                $data['approved_by'] = null;
            }

            $registration->fill($data);
            $registration->save();
            
            // Refresh modal data if open
            if ($this->isShowProofModalOpen && $this->selectedRegistration && $this->selectedRegistration->id == $registration->id) {
                $this->selectedRegistration = $registration->fresh();
            }

            $this->dispatch('swal:success', message: 'อัปเดตสถานะการลงทะเบียนเรียบร้อยแล้ว');
        }
    }

    public function render()
    {
        $query = Student::with(['classGroup', 'level', 'registrations' => function($q) {
            $q->latest();
        }]);

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('firstname', 'like', '%' . $this->search . '%')
                  ->orWhere('lastname', 'like', '%' . $this->search . '%')
                  ->orWhere('student_code', 'like', '%' . $this->search . '%');
            });
        }

        // Status Filter
        if ($this->statusFilter) {
            if ($this->statusFilter === 'unregistered') {
                $query->doesntHave('registrations');
            } else {
                $query->whereHas('registrations', function ($q) {
                    $q->where('status', $this->statusFilter);
                });
            }
        }

        // Sort by Student Code
        $students = $query->orderBy('student_code', 'asc')
                          ->paginate($this->perPage);

        return view('livewire.registrar.registration-status', [
            'students' => $students
        ]);
    }
}