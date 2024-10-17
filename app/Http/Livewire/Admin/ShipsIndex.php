<?php

namespace App\Http\Livewire\Admin;

use App\Models\Ship;
use App\Models\ShipTipo;
use Livewire\Component;

class ShipsIndex extends Component
{
    public $tiposNave;
    public $tipoFilter;
    public $naveFilter;
    public $estadoFilter = 1;

    protected $listeners = ['deleteNave'];

    public function mount()
    {
        //$this->tiposNave = ShipTipo::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $this->tiposNave = ShipTipo::orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        //$ships = Ship::where('estado', 1)->get();
        $ships = Ship::query()
            ->where('nombre', '<>', 'En Tierra')
            ->when($this->naveFilter, function ($query) {
                $query->where('nombre', 'LIKE', '%' . $this->naveFilter . '%');
            })
            ->when($this->tipoFilter, function ($query) {
                $query->where('ship_tipo_id', $this->tipoFilter);
            })
            ->when($this->estadoFilter, function ($query) {
                $query->where('estado', $this->estadoFilter);
            })->get();

        //dd($ships);
        return view('livewire.admin.ships-index', compact('ships'));
    }

    public function deleteNave(Ship $ship)
    {
        $ship->delete();        
    }
}
