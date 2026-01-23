<?php

namespace App\Livewire\Registrar;

use App\Models\ClassGroup;
use App\Models\Level;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class ManageStudents extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';

    public $allColumns = [
        'citizen_id' => 'Citizen ID',
        'student_code' => 'Student Code',
        'name' => 'Name',
        'level' => 'Level',
        'room' => 'Room',
        'class_group' => 'Class Group',
    ];

    public $selectedColumns = [];

    public function mount()
    {
        $this->selectedColumns = array_keys($this->allColumns);
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function paginationView()
    {
        return 'vendor.pagination.custom-white';
    }

    public $isModalOpen = false;
    public $confirmingDeletion = false;
    public $studentIdToDelete;

    // Form fields
    public $student_id;
    public $student_code;
    public $title;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $level_id;
    public $class_group_id;
    public $citizen_id;

    public function render()
    {
        $students = Student::with(['user', 'classGroup', 'level'])
            ->where(function ($query) {
                $query->where('firstname', 'like', '%' . $this->search . '%')
                      ->orWhere('lastname', 'like', '%' . $this->search . '%')
                      ->orWhere('student_code', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.registrar.manage-students', [
            'students' => $students,
            'levels' => Level::all(),
            'classGroups' => ClassGroup::all(),
        ]);
    }



    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate([
            'student_code' => 'required|string|unique:students,student_code',
            'title' => 'nullable|string|max:50',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'level_id' => 'required|exists:levels,id',
            'class_group_id' => 'nullable|exists:class_groups,id',
            'citizen_id' => 'nullable|string|max:13',
        ]);

        // Create User
        $user = User::create([
            'username' => $this->student_code, // Use student code as username
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        $user->assignRole('Student');

        // Create Student
        Student::create([
            'user_id' => $user->id,
            'student_code' => $this->student_code,
            'title' => $this->title,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'level_id' => $this->level_id,
            'class_group_id' => $this->class_group_id,
            'citizen_id' => $this->citizen_id,
        ]);

        $this->dispatch('swal:success', message: 'เพิ่มข้อมูลนักเรียนเรียบร้อยแล้ว');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $student = Student::with('user')->findOrFail($id);
        $this->student_id = $id;
        $this->student_code = $student->student_code;
        $this->title = $student->title;
        $this->firstname = $student->firstname;
        $this->lastname = $student->lastname;
        $this->email = $student->user->email;
        $this->level_id = $student->level_id;
        $this->class_group_id = $student->class_group_id;
        $this->citizen_id = $student->citizen_id;
        
        $this->isModalOpen = true;
    }

    public function update()
    {
        $student = Student::findOrFail($this->student_id);
        $user = $student->user;

        $this->validate([
            'student_code' => 'required|string|unique:students,student_code,' . $this->student_id,
            'title' => 'nullable|string|max:50',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'level_id' => 'required|exists:levels,id',
            'class_group_id' => 'nullable|exists:class_groups,id',
            'citizen_id' => 'nullable|string|max:13',
        ]);

        $user->update([
            'username' => $this->student_code, // Sync username
            'email' => $this->email,
        ]);
        
        if (!empty($this->password)) {
            $user->update(['password' => Hash::make($this->password)]);
        }

        $student->update([
            'student_code' => $this->student_code,
            'title' => $this->title,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'level_id' => $this->level_id,
            'class_group_id' => $this->class_group_id,
            'citizen_id' => $this->citizen_id,
        ]);

        $this->dispatch('swal:success', message: 'อัปเดตข้อมูลนักเรียนเรียบร้อยแล้ว');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id = null)
    {
        if (!$id) {
            $this->dispatch('swal:error', message: 'ไม่พบรหัสข้อมูล');
            return;
        }

        $student = Student::find($id);
        if ($student) {
            $this->dispatch('swal:confirm', 
                id: $id,
                message: "คุณแน่ใจหรือไม่ที่จะลบข้อมูลของ {$student->firstname} {$student->lastname}?"
            );
        } else {
            $this->dispatch('swal:error', message: 'ไม่พบข้อมูลนักเรียน');
        }
    }

    #[On('delete-confirmed')]
    public function confirmDelete($id = null)
    {
        // Extract ID if it's an array (handling Livewire's dispatch behavior)
        if (is_array($id)) {
            $id = $id['id'] ?? $id[0] ?? null;
        }

        \Illuminate\Support\Facades\Log::info('ManageStudents: Attempting deletion', ['id' => $id]);

        if (!$id) {
             $this->dispatch('swal:error', message: 'เกิดข้อผิดพลาด: ไม่พบรหัสข้อมูล');
             return;
        }

        try {
            $student = Student::find($id);
            if ($student) {
                $user = $student->user;
                
                // Delete student first (child)
                $student->delete();
                
                // Delete user if exists (parent)
                if ($user) {
                    $user->delete();
                }

                $this->dispatch('swal:success', message: 'ลบข้อมูลนักเรียนและบัญชีผู้ใช้เรียบร้อยแล้ว');
            } else {
                $this->dispatch('swal:error', message: 'ไม่พบข้อมูลนักเรียนที่ต้องการลบ');
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('ManageStudents: Deletion failed', ['error' => $e->getMessage()]);
            
             // Check for integrity constraint violation
            if (str_contains($e->getMessage(), 'Integrity constraint violation')) {
                $this->dispatch('swal:error', message: 'ไม่สามารถลบข้อมูลได้เนื่องจากมีการใช้งานอยู่ในส่วนอื่น (เช่น การลงทะเบียน)');
            } else {
                $this->dispatch('swal:error', message: 'ไม่สามารถลบข้อมูลได้: ' . $e->getMessage());
            }
        }
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    public function closeDeleteModal()
    {
        $this->confirmingDeletion = false;
        $this->studentIdToDelete = null;
    }

    private function resetInputFields()
    {
        $this->student_id = null;
        $this->student_code = '';
        $this->title = '';
        $this->firstname = '';
        $this->lastname = '';
        $this->email = '';
        $this->password = '';
        $this->level_id = '';
        $this->class_group_id = '';
        $this->citizen_id = '';
    }
}