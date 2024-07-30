<?php

namespace App\Http\Livewire\Admin;

use App\Models\ShipTipo;
use Livewire\Component;

class ShipTiposIndex extends Component
{    
    public $tipoFilter;    
    public $estadoFilter = "1";

    protected $listeners = ['deleteTipoNave'];

    public function mount()
    {
        //$this->ship_tipos = ShipTipo::orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        $ship_tipos = ShipTipo::query()            
            ->when($this->tipoFilter, function ($query) {
                $query->where('nombre', 'LIKE', '%' . $this->tipoFilter . '%');
            })
            ->when($this->estadoFilter, function ($query) {
                $query->where('estado', $this->estadoFilter);
            })->get();
        return view('livewire.admin.ship-tipos-index', compact('ship_tipos'));
    }

    public function deleteTipoNave(ShipTipo $tipoNave)
    {
        $tipoNave->delete();
    }
}
