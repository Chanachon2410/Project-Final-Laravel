<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class UserProfile extends Component
{
    public $user;
    public $student;
    public $teacher;

    public function mount()
    {
        $this->user = User::with(['roles', 'student.classGroup.level', 'student.classGroup.advisor', 'teacher.advisedClassGroups'])->find(Auth::id());
        $this->student = $this->user->student;
        $this->teacher = $this->user->teacher;
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}