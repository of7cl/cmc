<?php

namespace App\Http\Livewire\Admin;

use App\Models\DetalleTrayectoria;
use App\Models\Estado;
use App\Models\Persona;
use App\Models\Rango;
use App\Models\Ship;
use Livewire\Component;

class ControlTrayectoriaShow extends Component
{
    protected $listeners = ['render' => 'render'];
    public $persona;
    public $rangos;
    public $ships;    
    public $estados;

    public $showCabecera = true;
    public $showDetalle = true;
    public $showFormulario = true;    

    public $ship_id = '';
    public $estado_id = '';
    public $fc_desde;
    public $fc_hasta;

    public $detallesTrayectoria;

    public function mount()
    {
        $this->rangos = Rango::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $this->ships = Ship::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $this->estados = Estado::orderBy('nombre', 'asc')->get();
        if($this->persona->trayectoria){
            $this->detallesTrayectoria = DetalleTrayectoria::where('trayectoria_id',$this->persona->trayectoria->id)->orderBy('id', 'asc')->get();
        }
        
    }

    public function saveDetalle(){        
        //dd($this->persona->trayectoria->id);
        $detalle = DetalleTrayectoria::create([
            'trayectoria_id' => $this->persona->trayectoria->id,
            'ship_id' => $this->ship_id,
            'estado_id' => $this->estado_id,
            'fc_desde' => $this->fc_desde,
            'fc_hasta' => $this->fc_hasta,
        ]);

        $this->reset('ship_id', 'estado_id','fc_desde', 'fc_hasta');

        $this->detallesTrayectoria = DetalleTrayectoria::where('trayectoria_id',$this->persona->trayectoria->id)->orderBy('id', 'asc')->get();
    }

    public function render()
    {
        $persona = $this->persona;
        return view('livewire.admin.control-trayectoria-show', compact('persona'));
    }

    // public $count = 0;

    // public function decrement($cn)
    // {
    //     $this->count -= $cn;
    // }

    // public function increment($cn)
    // {
    //     $this->count += $cn;
    // }

    // public $paises = [
    //     'Chile',
    //     'Perú',
    //     'Colombia'
    // ];

    // public $pais;

    // public function save(){
    //     array_push($this->paises, $this->pais);
    //     $this->reset('pais');
    // }

    // public function delete($key){
    //     unset($this->paises[$key]);
    // }

    // public $active;

    // public function changeActive($pais){
    //     $this->active = $pais;
    // }

    // public function incrementar()
    // {
    //     $this->count++;
    // }
    
}
