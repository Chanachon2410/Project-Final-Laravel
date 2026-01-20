<?php

namespace App\Livewire\Registrar;

use App\Repositories\MajorRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class ManageMajors extends Component
{
    use WithPagination;

    public $isOpen = false;
        public $majorId, $major_code, $major_name;
        public $search = '';
        public $perPage = 10; // เพิ่ม property นี้
    
        protected $rules = [
    // ... (rules)
        ];
    
        private MajorRepositoryInterface $majorRepository;
    
        public function boot(MajorRepositoryInterface $majorRepository)
        {
            $this->majorRepository = $majorRepository;
        }
    
        public function updatedSearch()
        {
            $this->resetPage();
        }
    
        public function updatedPerPage() // เพิ่ม method นี้
        {
            $this->resetPage();
        }

    public function render()
    {
        $query = \App\Models\Major::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('major_code', 'like', '%' . $this->search . '%')
                  ->orWhere('major_name', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.registrar.manage-majors', [
            'majors' => $query->paginate($this->perPage),
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function edit($id)
    {
        $major = $this->majorRepository->findById($id);
        $this->majorId = $id;
        $this->major_code = $major->major_code;
        $this->major_name = $major->major_name;
        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        $data = [
            'major_code' => $this->major_code,
            'major_name' => $this->major_name,
        ];

        if ($this->majorId) {
            $this->majorRepository->update($this->majorId, $data);
            $this->dispatch('swal:success', message: 'Major updated successfully.');
        } else {
            $this->majorRepository->create($data);
            $this->dispatch('swal:success', message: 'Major created successfully.');
        }

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        $this->dispatch('swal:confirm', id: $id, message: 'Are you sure you want to delete this major?');
    }

    #[On('delete-confirmed')]
    public function confirmDelete($majorId)
    {
        $this->majorRepository->deleteById($majorId);
        $this->dispatch('swal:success', message: 'Major deleted successfully.');
    }

    private function resetInputFields()
    {
        $this->majorId = null;
        $this->major_code = '';
        $this->major_name = '';
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
