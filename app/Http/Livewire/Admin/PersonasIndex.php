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
    public $sort = 'id';
    public $direction = 'desc';

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {        
        $personas = Persona::where('nombre', 'LIKE', '%'.$this->search.'%')                                
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(10);
        
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
}
