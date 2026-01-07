<?php

namespace App\Livewire\Registrar;

use App\Repositories\SemesterRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class ManageSemesters extends Component
{
    use WithPagination;

    public $isOpen = false;
    public $semesterId, $semester, $year, $registration_start_date, $registration_end_date, $late_fee_rate, $is_active;

    protected $rules = [
        'semester' => 'required|integer|in:1,2,3',
        'year' => 'required|integer',
        'registration_start_date' => 'required|date',
        'registration_end_date' => 'required|date|after:registration_start_date',
        'late_fee_rate' => 'required|numeric',
        'is_active' => 'boolean',
    ];

    private SemesterRepositoryInterface $semesterRepository;

    public function boot(SemesterRepositoryInterface $semesterRepository)
    {
        $this->semesterRepository = $semesterRepository;
    }

    public function render()
    {
        return view('livewire.registrar.manage-semesters', [
            'semesters' => $this->semesterRepository->paginate(10),
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function edit($id)
    {
        $semester = $this->semesterRepository->findById($id);
        $this->semesterId = $id;
        $this->semester = $semester->semester;
        $this->year = $semester->year;
        $this->registration_start_date = $semester->registration_start_date->format('Y-m-d');
        $this->registration_end_date = $semester->registration_end_date->format('Y-m-d');
        $this->late_fee_rate = $semester->late_fee_rate;
        $this->is_active = $semester->is_active;
        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        $data = [
            'semester' => $this->semester,
            'year' => $this->year,
            'registration_start_date' => $this->registration_start_date,
            'registration_end_date' => $this->registration_end_date,
            'late_fee_rate' => $this->late_fee_rate,
            'is_active' => $this->is_active,
        ];

        if ($this->is_active) {
            $this->semesterRepository->all()->each(function ($sem) {
                $sem->update(['is_active' => false]);
            });
        }

        if ($this->semesterId) {
            $this->semesterRepository->update($this->semesterId, $data);
            $this->dispatch('swal:success', message: 'Semester updated successfully.');
        } else {
            $this->semesterRepository->create($data);
            $this->dispatch('swal:success', message: 'Semester created successfully.');
        }

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        $this->dispatch('swal:confirm', id: $id, message: 'Are you sure you want to delete this semester?');
    }

    #[On('delete-confirmed')]
    public function confirmDelete($semesterId)
    {
        $this->semesterRepository->deleteById($semesterId);
        $this->dispatch('swal:success', message: 'Semester deleted successfully.');
    }

    private function resetInputFields()
    {
        $this->semesterId = null;
        $this->semester = '';
        $this->year = '';
        $this->registration_start_date = '';
        $this->registration_end_date = '';
        $this->late_fee_rate = '';
        $this->is_active = false;
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }
}
