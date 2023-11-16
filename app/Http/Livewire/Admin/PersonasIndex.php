<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Persona;
use App\Models\Rango;
use App\Models\Ship;
use Livewire\WithPagination;

class PersonasIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {        
        $personas = Persona::where('personas.estado', 1)
                                /* ->innerJoin('rangos', 'personas.rango_id', '=', 'rangos.id') */
                                /* ->crossJoin('rangos') */
                                ->where('personas.nombre', 'LIKE', '%'.$this->search.'%')                                
                                ->orderBy('personas.id', 'desc')
                                ->paginate(10);
        
        return view('livewire.admin.personas-index', compact('personas'));
    }
}
