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

    public $isOpen = false;
    public $userId;
    public $username, $email, $password, $password_confirmation, $selectedRole;

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

    public function render()
    {
        return view('livewire.admin.user-management', [
            'users' => $this->userRepository->paginate(10, ['*'], ['roles']),
            'roles' => Role::all(),
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
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
