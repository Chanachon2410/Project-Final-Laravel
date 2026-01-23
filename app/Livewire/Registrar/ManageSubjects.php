<?php

namespace App\Livewire\Registrar;

use App\Repositories\SubjectRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class ManageSubjects extends Component
{
    use WithPagination;

    public $isOpen = false;
    public $subjectId, $subject_code, $subject_name, $credit, $hour_theory, $hour_practical;
    public $search = '';
    public $perPage = 10;

    protected $rules = [
        'subject_code' => 'required|string|max:20',
        'subject_name' => 'required|string|max:255',
        'credit' => 'required|numeric',
        'hour_theory' => 'required|integer',
        'hour_practical' => 'required|integer',
    ];

    private SubjectRepositoryInterface $subjectRepository;

    public function boot(SubjectRepositoryInterface $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
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
        return view('livewire.registrar.manage-subjects', [
            'subjects' => $this->subjectRepository->search($this->search, $this->perPage),
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function edit($id)
    {
        $subject = $this->subjectRepository->findById($id);
        $this->subjectId = $id;
        $this->subject_code = $subject->subject_code;
        $this->subject_name = $subject->subject_name;
        $this->credit = $subject->credit;
        $this->hour_theory = $subject->hour_theory;
        $this->hour_practical = $subject->hour_practical;
        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        $data = [
            'subject_code' => $this->subject_code,
            'subject_name' => $this->subject_name,
            'credit' => $this->credit,
            'hour_theory' => $this->hour_theory,
            'hour_practical' => $this->hour_practical,
        ];

        if ($this->subjectId) {
            $this->subjectRepository->update($this->subjectId, $data);
            $this->dispatch('swal:success', message: 'อัปเดตข้อมูลรายวิชาเรียบร้อยแล้ว');
        } else {
            $this->subjectRepository->create($data);
            $this->dispatch('swal:success', message: 'เพิ่มข้อมูลรายวิชาเรียบร้อยแล้ว');
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

        $subject = $this->subjectRepository->findById($id);
        
        if ($subject) {
            $this->dispatch('swal:confirm', 
                id: $id,
                message: "คุณแน่ใจหรือไม่ที่จะลบรายวิชา: {$subject->subject_name} ({$subject->subject_code})?"
            );
        } else {
            $this->dispatch('swal:error', message: 'ไม่พบข้อมูลรายวิชา');
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
            if ($this->subjectRepository->deleteById($id)) {
                $this->dispatch('swal:success', message: 'ลบข้อมูลรายวิชาเรียบร้อยแล้ว');
            } else {
                $this->dispatch('swal:error', message: 'ไม่พบข้อมูลรายวิชาที่ต้องการลบ');
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('ManageSubjects: Deletion failed', ['error' => $e->getMessage()]);
            
            // Check for integrity constraint violation
            if (str_contains($e->getMessage(), 'Integrity constraint violation')) {
                $this->dispatch('swal:error', message: 'ไม่สามารถลบข้อมูลได้เนื่องจากมีการใช้งานอยู่ในส่วนอื่น (เช่น แผนการเรียน หรือการลงทะเบียน)');
            } else {
                $this->dispatch('swal:error', message: 'ไม่สามารถลบข้อมูลได้: ' . $e->getMessage());
            }
        }
    }

    private function resetInputFields()
    {
        $this->subjectId = null;
        $this->subject_code = '';
        $this->subject_name = '';
        $this->credit = '';
        $this->hour_theory = '';
        $this->hour_practical = '';
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
