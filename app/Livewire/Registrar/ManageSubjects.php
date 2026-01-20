<?php

namespace App\Livewire\Registrar;

use App\Repositories\SubjectRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class ManageSubjects extends Component
{
    use WithPagination;

    public $isOpen = false;
    public $subjectId, $subject_code, $subject_name, $credit, $hour_theory, $hour_practical;
    public $search = '';
    public $perPage = 10;

    protected $rules = [
        'subject_code' => 'required|string|max:20',
        'subject_name' => 'required|string|max:255',
        'credit' => 'required|numeric',
        'hour_theory' => 'required|integer',
        'hour_practical' => 'required|integer',
    ];

    private SubjectRepositoryInterface $subjectRepository;

    public function boot(SubjectRepositoryInterface $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.registrar.manage-subjects', [
            'subjects' => $this->subjectRepository->search($this->search, $this->perPage),
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function edit($id)
    {
        $subject = $this->subjectRepository->findById($id);
        $this->subjectId = $id;
        $this->subject_code = $subject->subject_code;
        $this->subject_name = $subject->subject_name;
        $this->credit = $subject->credit;
        $this->hour_theory = $subject->hour_theory;
        $this->hour_practical = $subject->hour_practical;
        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        $data = [
            'subject_code' => $this->subject_code,
            'subject_name' => $this->subject_name,
            'credit' => $this->credit,
            'hour_theory' => $this->hour_theory,
            'hour_practical' => $this->hour_practical,
        ];

        if ($this->subjectId) {
            $this->subjectRepository->update($this->subjectId, $data);
            $this->dispatch('swal:success', message: 'Subject updated successfully.');
        } else {
            $this->subjectRepository->create($data);
            $this->dispatch('swal:success', message: 'Subject created successfully.');
        }

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        $this->dispatch('swal:confirm', id: $id, message: 'Are you sure you want to delete this subject?');
    }

    #[On('delete-confirmed')]
    public function confirmDelete($subjectId)
    {
        $this->subjectRepository->deleteById($subjectId);
        $this->dispatch('swal:success', message: 'Subject deleted successfully.');
    }

    private function resetInputFields()
    {
        $this->subjectId = null;
        $this->subject_code = '';
        $this->subject_name = '';
        $this->credit = '';
        $this->hour_theory = '';
        $this->hour_practical = '';
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
