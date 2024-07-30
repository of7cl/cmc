<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Documento;

class DocumentosIndex extends Component
{
    /* use WithPagination;

    protected $paginationTheme = "bootstrap"; */

    public $documentoFilter;
    public $estadoFilter = 1;

    protected $listeners = ['deleteDocumento'];

    /* public function updatingSearch(){
        $this->resetPage();
    } */

    public function render()
    {
        /* $documentos = Documento::where('documentos.nombre', 'LIKE', '%'.$this->documentoFilter.'%')                                
                                ->orderBy('documentos.id', 'asc')
                                ->paginate(10); */
        $documentos = Documento::query()
                                ->when($this->documentoFilter, function ($query) {
                                    $query->where('nombre', 'LIKE', '%' . $this->documentoFilter . '%');
                                })
                                ->when($this->estadoFilter, function ($query) {
                                    $query->where('estado', $this->estadoFilter);
                                })
                                ->orderBy('id', 'asc')
                                ->get();
                                //->paginate(10);

        return view('livewire.admin.documentos-index', compact('documentos'));        
    }

    public function deleteDocumento(Documento $documento)
    {
        $documento->delete();
    }
}
