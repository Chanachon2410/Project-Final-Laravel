<?php

namespace App\Livewire\Registrar;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class ManageRegistrars extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    // Modal States
    public $isOpen = false;

    // Form Properties
    public $userId;
    public $username, $email, $password, $password_confirmation;

    protected function rules()
    {
        return [
            'username' => 'required|string|max:255|unique:users,username,' . $this->userId,
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->userId,
            'password' => $this->userId ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $registrars = User::role('Registrar')
            ->where(function($query) {
                $query->where('username', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);

        return view('livewire.registrar.manage-registrars', [
            'registrars' => $registrars,
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->password = '';
        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        $data = [
            'username' => $this->username,
            'email' => $this->email,
        ];

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->userId) {
            $user = User::find($this->userId);
            $user->update($data);
            $this->dispatch('swal:success', message: 'แก้ไขข้อมูลเจ้าหน้าที่เรียบร้อยแล้ว');
        } else {
            $user = User::create($data);
            $user->assignRole('Registrar');
            $this->dispatch('swal:success', message: 'เพิ่มเจ้าหน้าที่ทะเบียนใหม่เรียบร้อยแล้ว');
        }

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        $this->dispatch('swal:confirm', id: $id, message: 'คุณแน่ใจหรือไม่ที่จะลบเจ้าหน้าที่รายนี้?');
    }

    #[On('delete-confirmed')]
    public function confirmDelete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            $this->dispatch('swal:success', message: 'ลบข้อมูลเรียบร้อยแล้ว');
        }
    }

    private function resetInputFields()
    {
        $this->userId = null;
        $this->username = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function openModal() { $this->isOpen = true; }
    public function closeModal() { $this->isOpen = false; }
}
