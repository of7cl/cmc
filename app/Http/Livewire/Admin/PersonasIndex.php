<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Persona;
use App\Models\Rango;
use App\Models\Ship;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PersonasIndex extends Component
{
    /* use WithPagination; */
    use WithFileUploads;

    /* protected $paginationTheme = "bootstrap"; */

    public $rangos;
    public $ships;
    public $search;
    public $estadoFilter = 1;
    public $rangoFilter;
    public $naveFilter;
    public $sort = 'id';
    public $direction = 'desc';

    protected $listeners = ['deletePersona'];

    /* public function updatingSearch(){
        $this->resetPage();
    } */

    public function mount()
    {        
        $this->rangos = Rango::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $this->ships = Ship::where('estado', 1)->orderBy('nombre', 'asc')->get();
    } 

    public function render()
    {        
        /* $personas = Persona::where('nombre', 'LIKE', '%'.$this->search.'%')                                
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(10); */

        $personas = Persona::query()
                            ->when($this->estadoFilter, function ($query) {
                                $query->where('estado', $this->estadoFilter);
                            })
                            ->when($this->search, function ($query) {
                                $query->where('nombre', 'LIKE', '%' . $this->search . '%');
                            })
                            ->when($this->rangoFilter, function ($query) {
                                $query->where('rango_id', $this->rangoFilter);
                            })
                            ->when($this->naveFilter, function ($query) {
                                $query->where('ship_id', $this->naveFilter);
                            })
                            ->orderBy($this->sort, $this->direction)
                            //->paginate(10);
                            ->get();
        
        return view('livewire.admin.personas-index', compact('personas'));
    }

    public function order($sort){
        
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
            
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
        
    }

    public function deletePersona(Persona $persona)
    {
        $persona->delete();        
    }
}
