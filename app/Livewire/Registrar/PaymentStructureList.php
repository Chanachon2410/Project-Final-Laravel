<?php

namespace App\Livewire\Registrar;

use App\Models\PaymentStructure;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentStructureList extends Component
{
    use WithPagination;

    public function delete($id)
    {
        $structure = PaymentStructure::find($id);
        if ($structure) {
            $structure->delete();
            session()->flash('message', 'ลบใบแจ้งหนี้เรียบร้อยแล้ว');
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $structures = PaymentStructure::with(['major', 'level'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.registrar.payment-structure-list', [
            'structures' => $structures
        ]);
    }
}