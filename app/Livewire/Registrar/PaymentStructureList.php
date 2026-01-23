<?php

namespace App\Livewire\Registrar;

use App\Models\PaymentStructure;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentStructureList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function delete($id)
    {
        $structure = PaymentStructure::find($id);
        if ($structure) {
            $structure->delete();
            session()->flash('message', 'ลบใบแจ้งหนี้เรียบร้อยแล้ว');
        }
    }

    public function toggleStatus($id)
    {
        $structure = PaymentStructure::find($id);
        if ($structure) {
            $structure->is_active = !$structure->is_active;
            $structure->save();
        }
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

    #[Layout('layouts.app')]
    public function render()
    {
        $structures = PaymentStructure::with(['major', 'level'])
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('major', function ($q) {
                          $q->where('major_name', 'like', '%' . $this->search . '%');
                      })
                      ->orWhereHas('level', function ($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.registrar.payment-structure-list', [
            'structures' => $structures
        ]);
    }
}