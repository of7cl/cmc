<?php

namespace App\Http\Livewire\Admin;

use App\Models\Documento;
use App\Models\Persona;
use App\Models\Rango;
use App\Models\Ship;
use Livewire\Component;

class ControlDocumentosIndex extends Component
{
    public $rangos;
    public $ships;
    public $nameFilter;
    public $rangoFilter;
    public $shipFilter;

    public function mount(){
        $this->rangos = Rango::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $this->ships = Ship::where('estado', 1)->orderBy('nombre', 'asc')->get();
    }

    public function render()
    {        
        $personas = Persona::query()
                        ->where('estado', 1)
                        ->when($this->rangoFilter, function($query){
                            $query->where('rango_id', $this->rangoFilter);
                        })
                        ->when($this->shipFilter, function($query){
                            $query->where('ship_id', $this->shipFilter);
                        })
                        ->when($this->nameFilter, function($query){
                            $query->where('nombre', 'LIKE', '%'.$this->nameFilter.'%');
                        })
                        ->orderBy('id', 'desc')->get();
        $documentos = Documento::where('estado', 1)->orderBy('id', 'asc')->get();        
        return view('livewire.admin.control-documentos-index', compact('personas', 'documentos'));
    }
}
