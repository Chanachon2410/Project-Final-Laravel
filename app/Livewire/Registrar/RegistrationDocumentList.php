<?php

namespace App\Livewire\Registrar;

use App\Models\RegistrationDocument;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class RegistrationDocumentList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function delete($id)
    {
        $document = RegistrationDocument::find($id);
        if ($document) {
            $name = $document->name;
            $document->delete();
            session()->flash('message', "ลบเอกสาร \"{$name}\" เรียบร้อยแล้ว");
        }
    }

    public function toggleStatus($id)
    {
        $document = RegistrationDocument::find($id);
        if ($document) {
            $document->is_active = !$document->is_active;
            $document->save();
            
            $status = $document->is_active ? 'เปิดใช้งาน' : 'ปิดใช้งาน';
            $this->dispatch('swal:success', message: "เปลี่ยนสถานะ \"{$document->name}\" เป็น{$status}เรียบร้อยแล้ว");
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
        $documents = RegistrationDocument::with(['major', 'level'])
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

        return view('livewire.registrar.registration-document-list', [
            'documents' => $documents
        ]);
    }
}