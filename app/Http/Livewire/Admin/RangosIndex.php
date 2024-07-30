<?php

namespace App\Http\Livewire\Admin;

use App\Models\Rango;
use Livewire\Component;
use Livewire\WithPagination;

class RangosIndex extends Component
{
    /* use WithPagination; */

    /* protected $paginationTheme = "bootstrap"; */

    public $rangoFilter;    
    public $estadoFilter = "1";

    protected $listeners = ['deleteRango'];

    /* public function updatingSearch(){
        $this->resetPage();
    } */

    public function render()
    {           
        $rangos = Rango::query()            
            ->when($this->rangoFilter, function ($query) {
                $query->where('nombre', 'LIKE', '%' . $this->rangoFilter . '%');
            })
            ->when($this->estadoFilter, function ($query) {
                $query->where('estado', $this->estadoFilter);
            })
            ->get();
            //->paginate(10);
        return view('livewire.admin.rangos-index', compact('rangos'));
    }

    public function deleteRango(Rango $rango)
    {
        $rango->delete();
    }
}
