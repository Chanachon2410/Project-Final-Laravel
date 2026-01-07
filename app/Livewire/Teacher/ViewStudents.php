<?php

namespace App\Livewire\Teacher;

use App\Repositories\StudentRepositoryInterface;
use App\Repositories\TeacherRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ViewStudents extends Component
{
    public $students;

    private TeacherRepositoryInterface $teacherRepository;
    private StudentRepositoryInterface $studentRepository;

    public function boot(TeacherRepositoryInterface $teacherRepository, StudentRepositoryInterface $studentRepository)
    {
        $this->teacherRepository = $teacherRepository;
        $this->studentRepository = $studentRepository;
    }

    public function mount()
    {
        $teacher = $this->teacherRepository->findByColumn('user_id', Auth::id());
        $this->students = $this->studentRepository->all()->where('class_group.teacher_advisor_id', $teacher->id);
    }

    public function render()
    {
        return view('livewire.teacher.view-students');
    }
}
