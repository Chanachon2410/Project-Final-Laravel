<?php

namespace App\Livewire\Teacher;

use App\Models\Semester;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ViewStudents extends Component
{
    public $students;
    public $activeSemester;

    public function mount()
    {
        $this->activeSemester = Semester::where('is_active', true)->first();

        $teacher = Teacher::where('user_id', Auth::id())->first();

        if ($teacher) {
            $this->students = Student::whereHas('classGroup', function ($query) use ($teacher) {
                $query->where('teacher_advisor_id', $teacher->id);
            })->with(['user', 'classGroup', 'registrations' => function ($query) {
                if ($this->activeSemester) {
                    $query->where('semester', $this->activeSemester->semester)
                          ->where('year', $this->activeSemester->year);
                }
            }])->get();
        } else {
            $this->students = collect();
        }
    }

    public function render()
    {
        return view('livewire.teacher.view-students');
    }
}
