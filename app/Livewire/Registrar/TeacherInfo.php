<?php

namespace App\Livewire\Registrar;

use App\Models\Teacher;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class TeacherInfo extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';

    public $allColumns = [
        'teacher_info' => 'Teacher Info',
        'advisor_for' => 'Advisor For',
        'contact' => 'Contact',
    ];

    public $selectedColumns = [];

    public function mount()
    {
        $this->selectedColumns = array_keys($this->allColumns);
    }

    // Modal State
    public $isViewModalOpen = false;
    public $isStudentListModalOpen = false;
    public $selectedTeacher = null;
    public $studentsInGroup = [];

    public function updating($property)
    {
        if ($property === 'perPage' || $property === 'search') {
            $this->resetPage();
        }
    }

    public function viewTeacher($id)
    {
        $this->selectedTeacher = Teacher::with([
            'user', 
            'advisedClassGroups.level', 
            'advisedClassGroups.major',
            'advisedClassGroups.students' // Eager-load students
        ])->find($id);
        $this->isViewModalOpen = true;
    }

    public function openStudentListModal($classGroupId)
    {
        $group = $this->selectedTeacher->advisedClassGroups->find($classGroupId);
        $this->studentsInGroup = $group ? $group->students : [];
        $this->isStudentListModalOpen = true;
    }

    public function closeStudentListModal()
    {
        $this->isStudentListModalOpen = false;
        $this->studentsInGroup = [];
    }

    public function closeViewModal()
    {
        $this->isViewModalOpen = false;
        $this->selectedTeacher = null;
        $this->closeStudentListModal(); // Ensure nested modal is also closed
    }

    public function render()
    {
        $searchTerm = $this->search;
        $teachers = Teacher::with(['user', 'advisedClassGroups.level', 'advisedClassGroups.major'])
            ->where(function ($query) use ($searchTerm) {
                $query->where('firstname', 'like', '%' . $searchTerm . '%')
                      ->orWhere('lastname', 'like', '%' . $searchTerm . '%')
                      ->orWhereHas('user', function ($q) use ($searchTerm) {
                          $q->where('username', 'like', '%' . $searchTerm . '%');
                      });
            })
            ->paginate($this->perPage);

        return view('livewire.registrar.teacher-info', [
            'teachers' => $teachers,
        ]);
    }
}
