<?php

namespace App\Livewire\Registrar;

use App\Repositories\SemesterRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class ManageSemesters extends Component
{
    use WithPagination;

    public $isOpen = false;
    public $semesterId, $semester, $year, $registration_start_date, $registration_end_date, $late_registration_start_date, $late_registration_end_date, $is_active;
    public $search = '';
    public $perPage = 10;

    protected $rules = [
        'semester' => 'required|integer|in:1,2,3',
        'year' => 'required|integer|min:2500|max:2600',
        'registration_start_date' => 'required|date',
        'registration_end_date' => 'required|date|after:registration_start_date',
        'late_registration_start_date' => 'required|date|after_or_equal:registration_end_date',
        'late_registration_end_date' => 'required|date|after:late_registration_start_date',
        'is_active' => 'boolean',
    ];

    private SemesterRepositoryInterface $semesterRepository;

    public function boot(SemesterRepositoryInterface $semesterRepository)
    {
        $this->semesterRepository = $semesterRepository;
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

    public function updatedRegistrationEndDate($value)
    {
        if ($value) {
            try {
                $date = \Carbon\Carbon::parse($value);
                $this->late_registration_start_date = $date->addDay()->format('Y-m-d');
            } catch (\Exception $e) {
                // Ignore invalid date formats
            }
        }
    }

    public function render()
    {
        $query = \App\Models\Semester::query()->orderBy('year', 'desc')->orderBy('semester', 'desc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('semester', 'like', '%' . $this->search . '%')
                  ->orWhere('year', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.registrar.manage-semesters', [
            'semesters' => $query->paginate($this->perPage),
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function edit($id)
    {
        $semester = $this->semesterRepository->findById($id);
        $this->semesterId = $id;
        $this->semester = $semester->semester;
        $this->year = $semester->year;
        $this->registration_start_date = $semester->registration_start_date->format('Y-m-d');
        $this->registration_end_date = $semester->registration_end_date->format('Y-m-d');
        $this->late_registration_start_date = $semester->late_registration_start_date ? $semester->late_registration_start_date->format('Y-m-d') : '';
        $this->late_registration_end_date = $semester->late_registration_end_date ? $semester->late_registration_end_date->format('Y-m-d') : '';
        $this->is_active = $semester->is_active;
        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        $data = [
            'semester' => $this->semester,
            'year' => $this->year,
            'registration_start_date' => $this->registration_start_date,
            'registration_end_date' => $this->registration_end_date,
            'late_registration_start_date' => $this->late_registration_start_date,
            'late_registration_end_date' => $this->late_registration_end_date,
            'is_active' => $this->is_active,
        ];

        // If setting this semester as active, deactivate others
        if ($this->is_active) {
            \App\Models\Semester::where('is_active', true)
                ->where('id', '!=', $this->semesterId) // Don't update self if editing
                ->update(['is_active' => false]);
        }

        if ($this->semesterId) {
            $this->semesterRepository->update($this->semesterId, $data);
            $this->dispatch('swal:success', message: 'อัปเดตข้อมูลภาคเรียนสำเร็จ');
        } else {
            $this->semesterRepository->create($data);
            $this->dispatch('swal:success', message: 'เพิ่มข้อมูลภาคเรียนสำเร็จ');
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

        $semester = $this->semesterRepository->findById($id);
        
        if ($semester) {
            $this->dispatch('swal:confirm', 
                id: $id,
                message: "คุณแน่ใจหรือไม่ที่จะลบภาคเรียน: {$semester->semester}/{$semester->year}?"
            );
        } else {
            $this->dispatch('swal:error', message: 'ไม่พบข้อมูลภาคเรียน');
        }
    }

    public function toggleStatus($id)
    {
        $semester = $this->semesterRepository->findById($id);
        
        if ($semester) {
            $newStatus = !$semester->is_active;

            if ($newStatus) {
                // If setting to Active, deactivate all others
                \App\Models\Semester::where('is_active', true)
                    ->update(['is_active' => false]);
            }

            $this->semesterRepository->update($id, ['is_active' => $newStatus]);
            
            $this->dispatch('swal:success', message: $newStatus ? 'เปิดใช้งานภาคเรียนเรียบร้อยแล้ว' : 'ปิดการใช้งานภาคเรียนเรียบร้อยแล้ว');
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
            if ($this->semesterRepository->deleteById($id)) {
                $this->dispatch('swal:success', message: 'ลบข้อมูลภาคเรียนสำเร็จ');
            } else {
                $this->dispatch('swal:error', message: 'ไม่พบข้อมูลภาคเรียนที่ต้องการลบ');
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('ManageSemesters: Deletion failed', ['error' => $e->getMessage()]);
            
            // Check for integrity constraint violation
            if (str_contains($e->getMessage(), 'Integrity constraint violation')) {
                $this->dispatch('swal:error', message: 'ไม่สามารถลบข้อมูลได้เนื่องจากมีการใช้งานอยู่ในส่วนอื่น (เช่น มีการลงทะเบียนในภาคเรียนนี้)');
            } else {
                $this->dispatch('swal:error', message: 'ไม่สามารถลบข้อมูลได้: ' . $e->getMessage());
            }
        }
    }

    private function resetInputFields()
    {
        $this->semesterId = null;
        $this->semester = '';
        $this->year = '';
        $this->registration_start_date = '';
        $this->registration_end_date = '';
        $this->late_registration_start_date = '';
        $this->late_registration_end_date = '';
        $this->is_active = false;
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
