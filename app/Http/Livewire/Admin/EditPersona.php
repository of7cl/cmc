<?php

namespace App\Http\Livewire\Admin;

use App\Models\Persona;
use Livewire\Component;

class EditPersona extends Component
{
    public $persona;
    //public $open = false;
    
    //public $nombre;
    //public $rut;
    //public $rango_id, $ship_id, $fc_nacimiento, $fc_ingreso, $fc_baja;
    protected $rules = [
        'persona.nombre' => 'required',
        'persona.rut' => 'required|unique:personas'
    ];

    public function mount(Persona $persona){
        $this->persona = $persona;        
    }

    public function update(){      
        dd($this->persona->id);
        /*$this->validate();
        Persona::create([                    
            'nombre' => $this->nombre,
            'rut' => $this->rut,
            'rango_id' => $this->rango_id,
            'ship_id' => $this->ship_id,
            'fc_nacimiento' => $this->fc_nacimiento,
            'fc_ingreso' => $this->fc_ingreso,
            'fc_baja' => $this->fc_baja
        ]);

        Persona::query()
                ->where('id', $persona->id)
                ->update([                
                    'nombre' => $request['nombre'],
                    'rut' => $request['rut'],
                    'rango_id' => $request['rango_id'],
                    'ship_id' => $request['ship_id'],
                    'fc_nacimiento' => $request['fc_nacimiento'],
                    'fc_ingreso' => $request['fc_ingreso'],
                    'fc_baja' => $request['fc_baja'],
                    'estado' => $estado
                    
            ]);
        
        $this->reset();
        $this->emit('render');
        $this->emit('alert', 'Persona editada con exito!');*/
    }

    public function close(){
        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.edit-persona');
    }
}
