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
    public $isManageModalOpen = false;
    public $isDeleteModalOpen = false;
    
    public $selectedTeacher = null;
    public $studentsInGroup = [];
    public $teacherIdToDelete = null;

    // Form Fields
    public $teacherId;
    public $title;
    public $firstname;
    public $lastname;
    public $teacher_code;
    public $email;
    public $username;
    public $password;

    public function updating($property)
    {
        if ($property === 'perPage' || $property === 'search') {
            $this->resetPage();
        }
    }

    public function paginationView()
    {
        return 'vendor.pagination.custom-white';
    }

    public function resetForm()
    {
        $this->teacherId = null;
        $this->title = '';
        $this->firstname = '';
        $this->lastname = '';
        $this->teacher_code = '';
        $this->email = '';
        $this->username = '';
        $this->password = '';
        $this->resetErrorBag();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isManageModalOpen = true;
    }

    public function openEditModal($id)
    {
        $this->resetForm();
        $teacher = Teacher::with('user')->findOrFail($id);
        $this->teacherId = $teacher->id;
        $this->title = $teacher->title;
        $this->firstname = $teacher->firstname;
        $this->lastname = $teacher->lastname;
        $this->teacher_code = $teacher->teacher_code;
        
        if ($teacher->user) {
            $this->email = $teacher->user->email;
            $this->username = $teacher->user->username;
        }

        $this->isManageModalOpen = true;
    }

    public function closeManageModal()
    {
        $this->isManageModalOpen = false;
        $this->resetForm();
    }

    public function saveTeacher()
    {
        $isEdit = !empty($this->teacherId);

        $rules = [
            'title' => 'required|string|max:50',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'teacher_code' => 'nullable|string|max:50|unique:teachers,teacher_code,' . ($this->teacherId ?? 'NULL'),
        ];

        if ($isEdit) {
            $teacher = Teacher::findOrFail($this->teacherId);
            $userId = $teacher->user_id;
            
            $rules['email'] = 'required|email|unique:users,email,' . $userId;
            $rules['username'] = 'required|string|unique:users,username,' . $userId;
            $rules['password'] = 'nullable|string|min:6';
        } else {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['username'] = 'required|string|unique:users,username';
            $rules['password'] = 'required|string|min:6';
        }

        $this->validate($rules);

        \Illuminate\Support\Facades\DB::transaction(function () use ($isEdit) {
            if ($isEdit) {
                $teacher = Teacher::findOrFail($this->teacherId);
                $user = $teacher->user;
                
                if ($user) {
                    $userData = [
                        'email' => $this->email,
                        'username' => $this->username,
                    ];
                    if (!empty($this->password)) {
                        $userData['password'] = \Illuminate\Support\Facades\Hash::make($this->password);
                    }
                    $user->update($userData);
                } else {
                    // Create user if missing (edge case)
                    $user = \App\Models\User::create([
                        'username' => $this->username,
                        'email' => $this->email,
                        'password' => \Illuminate\Support\Facades\Hash::make($this->password ?? 'password'), 
                    ]);
                    $teacher->user_id = $user->id;
                }

                $teacher->update([
                    'title' => $this->title,
                    'firstname' => $this->firstname,
                    'lastname' => $this->lastname,
                    'teacher_code' => $this->teacher_code,
                ]);

            } else {
                $user = \App\Models\User::create([
                    'username' => $this->username,
                    'email' => $this->email,
                    'password' => \Illuminate\Support\Facades\Hash::make($this->password),
                ]);

                // Assign role if needed, e.g., $user->assignRole('Teacher');
                // Assuming RoleSeeder exists or basic logic. For now just create user.

                Teacher::create([
                    'user_id' => $user->id,
                    'title' => $this->title,
                    'firstname' => $this->firstname,
                    'lastname' => $this->lastname,
                    'teacher_code' => $this->teacher_code,
                ]);
            }
        });

        $this->closeManageModal();
        $this->dispatch('alert', type: 'success', message: $isEdit ? 'แก้ไขข้อมูลสำเร็จ' : 'เพิ่มข้อมูลสำเร็จ');
    }

    public function confirmDelete($id)
    {
        $this->teacherIdToDelete = $id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
        $this->teacherIdToDelete = null;
    }

    public function deleteTeacher()
    {
        if ($this->teacherIdToDelete) {
            $teacher = Teacher::find($this->teacherIdToDelete);
            if ($teacher) {
                // Optional: Delete associated user?
                // $teacher->user->delete(); 
                $teacher->delete();
            }
        }
        $this->closeDeleteModal();
        $this->dispatch('alert', type: 'success', message: 'ลบข้อมูลสำเร็จ');
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
