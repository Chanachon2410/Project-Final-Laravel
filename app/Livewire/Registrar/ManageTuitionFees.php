<?php

namespace App\Livewire\Registrar;

use App\Repositories\TuitionFeeRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class ManageTuitionFees extends Component
{
    use WithPagination;

    public $isOpen = false;
    public $tuitionFeeId;
    public $semester;
    public $year;
    public $fee_name;
    public $rate_money;
    public $search = '';
    public $perPage = 10;

    protected $rules = [
        'semester' => 'required|integer|min:1|max:3',
        'year' => 'required|integer|min:2500|max:2600',
        'fee_name' => 'required|string|max:100',
        'rate_money' => 'required|numeric|min:0',
    ];

    private TuitionFeeRepositoryInterface $tuitionFeeRepository;

    public function boot(TuitionFeeRepositoryInterface $tuitionFeeRepository)
    {
        $this->tuitionFeeRepository = $tuitionFeeRepository;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function paginationView()
    {
        return 'vendor.pagination.custom-white';
    }

    public function render()
    {
        $query = \App\Models\TuitionFee::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('fee_name', 'like', '%' . $this->search . '%')
                  ->orWhere('semester', 'like', '%' . $this->search . '%')
                  ->orWhere('year', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.registrar.manage-tuition-fees', [
            'tuitionFees' => $query->paginate($this->perPage),
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function edit($id)
    {
        $tuitionFee = $this->tuitionFeeRepository->findById($id);
        $this->tuitionFeeId = $id;
        $this->semester = $tuitionFee->semester;
        $this->year = $tuitionFee->year;
        $this->fee_name = $tuitionFee->fee_name;
        $this->rate_money = $tuitionFee->rate_money;
        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        $data = [
            'semester' => $this->semester,
            'year' => $this->year,
            'fee_name' => $this->fee_name,
            'rate_money' => $this->rate_money,
        ];

        if ($this->tuitionFeeId) {
            $this->tuitionFeeRepository->update($this->tuitionFeeId, $data);
            $this->dispatch('swal:success', message: 'อัปเดตข้อมูลค่าธรรมเนียมเรียบร้อยแล้ว');
        } else {
            $this->tuitionFeeRepository->create($data);
            $this->dispatch('swal:success', message: 'เพิ่มข้อมูลค่าธรรมเนียมเรียบร้อยแล้ว');
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

        $tuitionFee = $this->tuitionFeeRepository->findById($id);
        
        if ($tuitionFee) {
            $this->dispatch('swal:confirm', 
                id: $id,
                message: "คุณแน่ใจหรือไม่ที่จะลบค่าเทอม: {$tuitionFee->fee_name} (ภาคเรียน {$tuitionFee->semester}/{$tuitionFee->year})?"
            );
        } else {
            $this->dispatch('swal:error', message: 'ไม่พบข้อมูลค่าเทอม');
        }
    }

    #[On('delete-confirmed')]
    public function confirmDelete($id = null)
    {
        // Extract ID if it's an array (handling Livewire's dispatch behavior)
        if (is_array($id)) {
            $id = $id['id'] ?? $id[0] ?? null;
        }

        if (!$id) {
            $this->dispatch('swal:error', message: 'เกิดข้อผิดพลาด: ไม่พบรหัสข้อมูล');
            return;
        }
        
        try {
            if ($this->tuitionFeeRepository->deleteById($id)) {
                $this->dispatch('swal:success', message: 'ลบข้อมูลค่าเทอมเรียบร้อยแล้ว');
            } else {
                $this->dispatch('swal:error', message: 'ไม่พบข้อมูลค่าเทอมที่ต้องการลบ');
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('ManageTuitionFees: Deletion failed', ['error' => $e->getMessage()]);
            
            // Check for integrity constraint violation
            if (str_contains($e->getMessage(), 'Integrity constraint violation')) {
                $this->dispatch('swal:error', message: 'ไม่สามารถลบข้อมูลได้เนื่องจากมีการใช้งานอยู่ในส่วนอื่น (เช่น ประวัติการชำระเงิน)');
            } else {
                $this->dispatch('swal:error', message: 'ไม่สามารถลบข้อมูลได้: ' . $e->getMessage());
            }
        }
    }

    private function resetInputFields()
    {
        $this->tuitionFeeId = null;
        $this->semester = '';
        $this->year = '';
        $this->fee_name = '';
        $this->rate_money = '';
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
