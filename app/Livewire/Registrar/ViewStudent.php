<?php

namespace App\Livewire\Registrar;

use App\Models\Student;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ViewStudent extends Component
{
    public Student $student;

    public function mount(Student $student)
    {
        $this->student = $student->load(['user', 'classGroup.level', 'classGroup.major', 'classGroup.advisor.user']);
    }

    public function render()
    {
        return view('livewire.registrar.view-student');
    }
}