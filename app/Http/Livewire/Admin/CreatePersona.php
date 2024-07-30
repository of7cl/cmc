<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
//use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use App\Models\Persona;

class CreatePersona extends Component
{
    #public $formtitle = 'Crear Personal';
    #public $editform = false;
    #public $open = false;    
    public $persona;
    //public $nombre;
    //public $rut;
    public $rango_id, $ship_id, $fc_nacimiento, $fc_ingreso, $fc_baja;
    protected $rules = [
        'nombre' => 'required',
        'rut' => 'required|unique:personas'
    ];

    /*public function save(){        
        $this->validate();
        Persona::create([                    
            'nombre' => $this->nombre,
            'rut' => $this->rut,
            'rango_id' => $this->rango_id,
            'ship_id' => $this->ship_id,
            'fc_nacimiento' => $this->fc_nacimiento,
            'fc_ingreso' => $this->fc_ingreso,
            'fc_baja' => $this->fc_baja
        ]);
        
        $this->reset();
        $this->emit('render');
        $this->emit('alert', 'Persona editada con exito!');
    }*/

    public function edit($id){
        dd($id);
    }

    public function close(){
        $this->reset();
    }
            
    public function render()
    {
        return view('livewire.admin.create-persona');
    }

    public function test(){
        //dd("test");
        //$this->open = true;
        //dd($this->open);
    }
}
