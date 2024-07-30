<?php

namespace App\Http\Livewire\Admin;

use App\Models\Documento;
use App\Models\Rango;
use App\Models\ShipTipo;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ShipTipoDocumentos extends Component
{
    public $ship_tipo;
    public $documento_id = '';
    public $rangoFilter = '';
    public $rangos, $documentos;
    public $selDocs = [];
    public $ship_tipo_documentos;

    protected $listeners = ['render', 'deleteDocumento'];

    public function mount()
    {
        $this->rangos = Rango::all();
        $this->documentos = Documento::all();
    }
    public function render()
    {
        //$rangos = Rango::all();
        //$documentos = Documento::all();
        $ship_tipo_documentos = ShipTipo::find($this->ship_tipo->id)
            ->documentos()
            ->orderBy('id')
            ->where('rango_id', $this->rangoFilter)
            ->get();        
        //return view('livewire.admin.ship-tipo-documentos', compact(/* 'rangos', 'documentos',  */'ship_tipo_documentos'));
        return view('livewire.admin.ship-tipo-documentos');
    }

    public function getDocsRango()
    {
        $this->ship_tipo_documentos = ShipTipo::find($this->ship_tipo->id)
            ->documentos()
            ->orderBy('id')
            ->where('rango_id', $this->rangoFilter)
            ->get();
        $this->selDocs = $this->ship_tipo_documentos->pluck('id')->toArray();
        //dd($this->selDocs);
        //dd($this->rangoFilter);
    }

    public function update()
    {
        $groupIds = $this->ship_tipo->documentos()->where('rango_id', $this->rangoFilter)->get()->pluck('id');        
        $this->ship_tipo->documentos()->detach($groupIds);
        $this->ship_tipo->documentos()->attach($this->selDocs, ['rango_id' => $this->rangoFilter]);                
        session()->flash('info', 'Documentos asignados con éxito!');        
    }

    public function saveDocumento()
    {
        $cn = 0;
        $customMessages = [
            "required" => 'Debe seleccionar documento!'
        ];
        $rules['documento_id'] = 'required';
        $this->validate($rules, $customMessages);
        //dd($this->ship_tipo->documentos);
        foreach($this->ship_tipo->documentos as $shipTipoDoc)
        {
            if($shipTipoDoc->pivot->rango_id == $this->rangoFilter){
                if($shipTipoDoc->id == $this->documento_id){
                    $cn++;
                }            
            }            
        }
        if($cn == 0){
            $this->ship_tipo->documentos()->attach($this->documento_id, ['rango_id' => $this->rangoFilter]);
            $this->emit('alert', 'Documento agregado con exito!', 'success');
        }
        else{
            $this->emit('alert', 'Documento ya se encuentra asociado!','error');
        }        
    }

    public function deleteDocumento($docId)
    {
        $this->ship_tipo->documentos()->wherePivot('rango_id', $this->rangoFilter)->detach($docId);        
    }
}
