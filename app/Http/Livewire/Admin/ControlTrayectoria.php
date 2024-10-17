<?php

namespace App\Http\Livewire\Admin;

use App\Models\Documento;
use App\Models\Persona;
use App\Models\Rango;
use App\Models\Ship;
use Livewire\Component;

class ControlTrayectoria extends Component
{    
    public $rangos;
    public $ships;
    public $nameFilter;
    public $rangoFilter;
    public $shipFilter;
    public $estadoFilter = 1;    

    protected $listeners = ['render' => 'render'];

    public function mount()
    {        
        $this->rangos = Rango::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $this->ships = Ship::where('estado', 1)->orderBy('nombre', 'asc')->get();
    }

    public function render()
    {        
        $nave = Ship::where('id', $this->shipFilter)->first();
        $nm_nave = 'sin nave';
        if($nave)
            $nm_nave = $nave->nombre;    
        $personas = Persona::query()
            //->where('estado', 1)
            ->when($this->estadoFilter, function ($query) {
                $query->where('estado', $this->estadoFilter);
            })
            ->when($this->rangoFilter, function ($query) {
                $query->where('rango_id', $this->rangoFilter);
            })
            /* ->when($this->shipFilter, function ($query) {
                $query->where('ship_id', $this->shipFilter);
            }) */
            ->when($nm_nave == 'En Tierra', function ($query) {
                $query->where('ship_id', null);
            })
            ->when($nm_nave != 'En Tierra' && $this->shipFilter, function ($query) {
                $query->where('ship_id', $this->shipFilter);
            })
            ->when($this->nameFilter, function ($query) {
                $query->where('nombre', 'LIKE', '%' . $this->nameFilter . '%');
            })
            ->orderBy('id', 'desc')
            ->get();        
        
        return view('livewire.admin.control-trayectoria', compact('personas'));        
    }
}
