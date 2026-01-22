<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class UserManagement extends Component
{
    use WithPagination;

    // Search & Pagination controls
    public $search = '';
    public $perPage = 10;

    // Modal States
    public $isOpen = false;
    public $isViewOpen = false;

    // Form Properties
    public $userId;
    public $username, $email, $password, $password_confirmation, $selectedRole;

    // View Profile Property
    public $viewingUser = null;

    protected $rules = [
        'username' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'password' => 'nullable|string|min:8|confirmed',
        'selectedRole' => 'required|string|exists:roles,name',
    ];

    private UserRepositoryInterface $userRepository;

    public function boot(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::with(['roles'])
            ->where(function($query) {
                $query->where('username', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);

        return view('livewire.admin.user-management', [
            'users' => $users,
            'roles' => Role::all(),
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function view($id)
    {
        $this->viewingUser = User::with(['roles', 'student.classGroup.level', 'teacher'])->find($id);
        $this->isViewOpen = true;
    }

    public function closeViewModal()
    {
        $this->isViewOpen = false;
        $this->viewingUser = null;
    }

    public function edit($id)
    {
        $user = $this->userRepository->findById($id, relations: ['roles']);
        $this->userId = $id;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->password = ''; // Do not show existing password
        $this->selectedRole = $user->roles->first()->name ?? '';

        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        $userData = [
            'username' => $this->username,
            'email' => $this->email,
        ];

        if (!empty($this->password)) {
            $userData['password'] = Hash::make($this->password);
        }

        if ($this->userId) {
            $user = $this->userRepository->update($this->userId, $userData);
            $user->syncRoles($this->selectedRole);
            $this->dispatch('swal:success', message: 'User updated successfully.');
        } else {
            $user = $this->userRepository->create($userData);
            $user->assignRole($this->selectedRole);
            $this->dispatch('swal:success', message: 'User created successfully.');
        }

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        $this->dispatch('swal:confirm', id: $id, message: 'Are you sure you want to delete this user?');
    }

    #[On('delete-confirmed')]
    public function confirmDelete($userId)
    {
        $this->userRepository->deleteById($userId);
        $this->dispatch('swal:success', message: 'User deleted successfully.');
    }

    private function resetInputFields()
    {
        $this->userId = null;
        $this->username = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->selectedRole = '';
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
