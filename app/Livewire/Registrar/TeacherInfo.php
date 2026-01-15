<?php

namespace App\Livewire\Registrar;

use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class TeacherInfo extends Component
{
    use WithPagination;

    public $search = '';
    
    // Modal State
    public $isViewModalOpen = false;
    public $selectedTeacher = null;

    public function viewTeacher($id)
    {
        $this->selectedTeacher = Teacher::with([
            'user', 
            'advisedClassGroups.level', // Load Level for advisor info
            'studyPlans.subject',       // Load Subject for teaching info
            'studyPlans.classGroup.level' // Load ClassGroup & Level for teaching info
        ])->find($id);

        $this->isViewModalOpen = true;
    }

    public function closeViewModal()
    {
        $this->isViewModalOpen = false;
        $this->selectedTeacher = null;
    }

    public function render()
    {
        $teachers = Teacher::with(['user', 'advisedClassGroups'])
            ->where(function ($query) {
                $query->where('firstname', 'like', '%' . $this->search . '%')
                      ->orWhere('lastname', 'like', '%' . $this->search . '%')
                      ->orWhere('teacher_code', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.registrar.teacher-info', [
            'teachers' => $teachers,
        ]);
    }
}