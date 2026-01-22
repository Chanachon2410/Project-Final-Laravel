<?php

namespace App\Livewire\Registrar;

use App\Models\Registration;
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

    public function viewProof($registrationId)
    {
        $this->selectedRegistration = Registration::with('student')->find($registrationId);
        
        if ($this->selectedRegistration) {
            $this->selectedStudent = $this->selectedRegistration->student;
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
        $this->isShowProofModalOpen = false;
    }

    public function rejectRegistration($registrationId)
    {
        $this->updateStatus($registrationId, 'rejected');
        $this->isShowProofModalOpen = false;
    }

    public function updateStatus($registrationId, $status)
    {
        $registration = Registration::find($registrationId);
        if ($registration) {
            $data = ['status' => $status];
            
            if ($status === 'approved') {
                $user = auth()->user();
                // Use username or name depending on what's available. Registrar doesn't have a specific profile model yet.
                $approverName = 'ฝ่ายทะเบียน (' . $user->username . ')';
                $data['approved_by'] = $approverName;
            } elseif ($status === 'pending' || $status === 'rejected') {
                $data['approved_by'] = null;
            }

            $registration->update($data);
        }
    }

    public function render()
    {
        $registrations = Registration::with(['student.level', 'student.classGroup'])
            ->whereHas('student', function ($query) {
                $query->where('firstname', 'like', '%' . $this->search . '%')
                    ->orWhere('lastname', 'like', '%' . $this->search . '%')
                    ->orWhere('student_code', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.registrar.registration-status', [
            'registrations' => $registrations
        ]);
    }
}