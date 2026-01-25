<?php

namespace App\Livewire\Registrar;

use App\Models\Student;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class ViewStudent extends Component
{
    public Student $student;

    public function mount(Student $student)
    {
        $this->student = $student->load(['user', 'classGroup.level', 'classGroup.major', 'classGroup.advisor.user', 'registrations']);
    }

    public function deleteStudent()
    {
        $this->dispatch('swal:confirm', 
            id: $this->student->id,
            message: "คุณแน่ใจหรือไม่ที่จะลบข้อมูลของ {$this->student->firstname} {$this->student->lastname}?"
        );
    }

    #[On('delete-confirmed')]
    public function confirmDelete($id = null)
    {
        // Handle both direct ID and array from event
        if (is_array($id)) {
            $id = $id['id'] ?? $id[0] ?? null;
        }

        if (!$id || $id != $this->student->id) return;

        try {
            $user = $this->student->user;
            $this->student->delete();
            if ($user) $user->delete();

            session()->flash('message', 'ลบข้อมูลนักเรียนเรียบร้อยแล้ว');
            return redirect()->route('registrar.students.index');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', message: 'ไม่สามารถลบข้อมูลได้เนื่องจากมีการใช้งานอยู่ในส่วนอื่น');
        }
    }

    public function render()
    {
        return view('livewire.registrar.view-student');
    }
}