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
    public $perPage = 10;

    protected $rules = [
        'major_code' => 'required|string|max:20',
        'major_name' => 'required|string|max:255',
    ];

    private MajorRepositoryInterface $majorRepository;

    public function boot(MajorRepositoryInterface $majorRepository)
    {
        $this->majorRepository = $majorRepository;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function paginationView()
    {
        return 'vendor.pagination.custom-white';
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
            $this->dispatch('swal:success', message: 'อัปเดตข้อมูลสาขาวิชาเรียบร้อยแล้ว');
        } else {
            $this->majorRepository->create($data);
            $this->dispatch('swal:success', message: 'เพิ่มข้อมูลสาขาวิชาเรียบร้อยแล้ว');
        }

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id = null)
    {
        if (!$id) {
            $this->dispatch('swal:error', message: 'ไม่พบรหัสข้อมูล');
            return;
        }

        $major = $this->majorRepository->findById($id);
        
        if ($major) {
            $this->dispatch('swal:confirm', 
                id: $id,
                message: "คุณแน่ใจหรือไม่ที่จะลบสาขาวิชา: {$major->major_name}?"
            );
        } else {
            $this->dispatch('swal:error', message: 'ไม่พบข้อมูลสาขาวิชา');
        }
    }

    #[On('delete-confirmed')]
    public function confirmDelete($id = null)
    {
        // Livewire 3 passes the value directly if sent as a single argument
        if (is_array($id)) {
            $id = $id['id'] ?? $id[0] ?? null;
        }

        if (!$id) {
            $this->dispatch('swal:error', message: 'เกิดข้อผิดพลาด: ไม่พบรหัสข้อมูล');
            return;
        }
        
        try {
            if ($this->majorRepository->deleteById($id)) {
                $this->dispatch('swal:success', message: 'ลบข้อมูลสาขาวิชาเรียบร้อยแล้ว');
            } else {
                $this->dispatch('swal:error', message: 'ไม่พบข้อมูลสาขาวิชาที่ต้องการลบ');
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('ManageMajors: Deletion failed', ['error' => $e->getMessage()]);
            
            // Check for integrity constraint violation
            if (str_contains($e->getMessage(), 'Integrity constraint violation')) {
                $this->dispatch('swal:error', message: 'ไม่สามารถลบข้อมูลได้เนื่องจากมีการใช้งานอยู่ในส่วนอื่น');
            } else {
                $this->dispatch('swal:error', message: 'ไม่สามารถลบข้อมูลได้: ' . $e->getMessage());
            }
        }
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
