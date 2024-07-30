<?php

namespace App\Http\Livewire\Admin;

use App\Models\Feriado;
use Livewire\Component;

class FeriadosIndex extends Component
{
    //public $feriados;
    public $descripcionFilter;
    public $estadoFilter = 1;

    protected $listeners = ['deleteFeriado'];

    public function mount()
    {
        //$this->feriados = Feriado::orderBy('fc_feriado', 'desc')->get();
    }

    public function render()
    {        
        $feriados = Feriado::query()
            ->when($this->descripcionFilter, function ($query) {
                $query->where('descripcion', 'LIKE', '%' . $this->descripcionFilter . '%');
            })            
            ->when($this->estadoFilter, function ($query) {
                $query->where('estado', $this->estadoFilter);
            })
            ->orderBy('fc_feriado', 'desc')
            ->get();

        return view('livewire.admin.feriados-index', compact('feriados'));
    }

    public function deleteFeriado(Feriado $feriado)
    {
        $feriado->delete();   
        //$this->feriados = Feriado::orderBy('fc_feriado', 'desc')->get();                 
    }
}
