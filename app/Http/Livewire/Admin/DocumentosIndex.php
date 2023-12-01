<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Documento;

class DocumentosIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $documentos = Documento::where('documentos.nombre', 'LIKE', '%'.$this->search.'%')                                
                                ->orderBy('documentos.id', 'asc')
                                ->paginate(10);
        
        return view('livewire.admin.documentos-index', compact('documentos'));        
    }
}
