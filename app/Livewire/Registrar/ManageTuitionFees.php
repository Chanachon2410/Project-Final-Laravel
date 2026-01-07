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

    protected $rules = [
        'semester' => 'required|integer|min:1|max:3',
        'year' => 'required|integer|min:2000|max:2100',
        'fee_name' => 'required|string|max:100',
        'rate_money' => 'required|numeric|min:0',
    ];

    private TuitionFeeRepositoryInterface $tuitionFeeRepository;

    public function boot(TuitionFeeRepositoryInterface $tuitionFeeRepository)
    {
        $this->tuitionFeeRepository = $tuitionFeeRepository;
    }

    public function render()
    {
        return view('livewire.registrar.manage-tuition-fees', [
            'tuitionFees' => $this->tuitionFeeRepository->paginate(10),
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
            $this->dispatch('swal:success', message: 'Tuition Fee updated successfully.');
        } else {
            $this->tuitionFeeRepository->create($data);
            $this->dispatch('swal:success', message: 'Tuition Fee created successfully.');
        }

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        $this->dispatch('swal:confirm', id: $id, message: 'Are you sure you want to delete this tuition fee?');
    }

    #[On('delete-confirmed')]
    public function confirmDelete($id)
    {
        $this->tuitionFeeRepository->deleteById($id);
        $this->dispatch('swal:success', message: 'Tuition Fee deleted successfully.');
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
