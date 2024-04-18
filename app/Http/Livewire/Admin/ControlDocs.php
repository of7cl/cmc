<?php

namespace App\Http\Livewire\Admin;

use App\Models\Documento;
use App\Models\Persona;
use App\Models\Rango;
use App\Models\Ship;
use Livewire\Component;
//use App\Http\Livewire\Admin\CreatePersona;


class ControlDocs extends Component
{
    public $rangos;
    public $ships;
    public $nameFilter;
    public $rangoFilter;
    public $shipFilter;

    public $persona;
    //public $personas;

    public $nombre;
    public $rut;
    public $rango_id;
    public $ship_id;
    public $fc_nacimiento;
    public $fc_ingreso;
    public $fc_baja;
    public $id_persona;

    protected $listeners = ['render' => 'render'];

    protected $rules = [
        'nombre' => 'required',
        'rut' => 'required'
    ];

    public function mount()
    {
        /*$this->personas = Persona::query()
            ->where('estado', 1)
            ->when($this->rangoFilter, function ($query) {
                $query->where('rango_id', $this->rangoFilter);
            })
            ->when($this->shipFilter, function ($query) {
                $query->where('ship_id', $this->shipFilter);
            })
            ->when($this->nameFilter, function ($query) {
                $query->where('nombre', 'LIKE', '%' . $this->nameFilter . '%');
            })
            // ->when($this->id, function ($query) {
            //     $query->where('id', $this->id_persona);
            // })
            ->orderBy('id', 'desc')->get();*/
        $this->rangos = Rango::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $this->ships = Ship::where('estado', 1)->orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        $personas = Persona::query()
            ->where('estado', 1)
            ->when($this->rangoFilter, function ($query) {
                $query->where('rango_id', $this->rangoFilter);
            })
            ->when($this->shipFilter, function ($query) {
                $query->where('ship_id', $this->shipFilter);
            })
            ->when($this->nameFilter, function ($query) {
                $query->where('nombre', 'LIKE', '%' . $this->nameFilter . '%');
            })
            ->orderBy('id', 'desc')->get();
        $documentos = Documento::where('estado', 1)->orderBy('id', 'asc')->get();
        return view('livewire.admin.control-docs', compact('personas', 'documentos'));
    }

    public function edit($id)
    {
        //dd($id);
        $this->close();
        $this->id_persona = $id;        
        $this->persona = Persona::findOrfail($id);        
        $this->nombre = $this->persona->nombre;
        $this->rut = $this->persona->rut;
        $this->rango_id = $this->persona->rango_id;
        $this->ship_id = $this->persona->ship_id;
        $this->fc_nacimiento = $this->persona->fc_nacimiento;
        $this->fc_ingreso = $this->persona->fc_ingreso;
        $this->fc_baja = $this->persona->fc_baja;
        //dd($this->rango_id);
    }

    public function update()
    {
        $this->validate();
        Persona::query()
            ->where('id', $this->id_persona)
            ->update([
                'nombre' => $this->nombre,
                'rut' => $this->rut,
                'rango_id' => $this->rango_id,
                'ship_id' => $this->ship_id,
                'fc_nacimiento' => $this->fc_nacimiento,
                'fc_ingreso' => $this->fc_ingreso,
                'fc_baja' => $this->fc_baja,
                'estado' => 1
            ]);
        $this->close();
        $this->emit('render');
        $this->emit('alert', 'Persona editada con exito!');
        //dd($this->rango_id);
    }

    public function close()
    {
        $this->reset('nombre','rut','rango_id','ship_id','fc_nacimiento','fc_ingreso','fc_baja');
    }
}
