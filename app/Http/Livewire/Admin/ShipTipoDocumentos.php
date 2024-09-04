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
    public $documentoFilter = '';
    public $estadoFilter = 1;
    public $rangos;
    public $selRangos = [];    
    public $ship_tipo_documentos;
    public $ship_tipo_docs;    
    public $arr_rango_doc = [];

    protected $listeners = ['render', 'deleteDocumento'];

    public function mount()
    {
        $this->rangos = Rango::all();  
        $this->ship_tipo_docs = ShipTipo::find($this->ship_tipo->id)
            ->documentos()
            ->orderBy('id')               
            ->get();              
        //$this->documentos = Documento::all();
    }
    public function render()
    {        
        $this->ship_tipo_documentos = ShipTipo::find($this->ship_tipo->id)
            ->documentos()
            ->orderBy('id')   
            ->where('documento_id', $this->documento_id)         
            ->get();
        $documentos = Documento::query()
                                ->when($this->documentoFilter, function ($query) {
                                    $query->where('nombre', 'LIKE', '%' . $this->documentoFilter . '%');
                                })
                                ->when($this->estadoFilter, function ($query) {
                                    $query->where('estado', $this->estadoFilter);
                                })
                                ->orderBy('id', 'asc')
                                ->get();
        return view('livewire.admin.ship-tipo-documentos', compact('documentos'));
    }

    public function getCountRangosByIdDocumento($id_doc)
    {
        $ship_tipo_rangos_doc = ShipTipo::find($this->ship_tipo->id)
            ->documentos()
            ->orderBy('id')
            ->wherePivot('documento_id', $id_doc)
            ->get();

        return $ship_tipo_rangos_doc->count();
    }

    public function close()
    {
        $this->reset('selRangos', 'arr_rango_doc', 'documento_id');
    }

    public function asignarRango($documento_id){
        $this->documento_id = $documento_id;        
        $this->getDocsRango();
    }

    public function getDocsRango()
    {
        $ship_tipo_rangos_doc = ShipTipo::find($this->ship_tipo->id)
            ->documentos()
            ->orderBy('id')
            ->wherePivot('documento_id', $this->documento_id)
            ->get();
        
        foreach($ship_tipo_rangos_doc as $key => $rango_doc)
        {
            $this->arr_rango_doc[$key] = $rango_doc->pivot->rango_id;            
        }
        $this->selRangos = $this->arr_rango_doc;        
    }

    public function update()
    {        
        $groupIds = $this->ship_tipo->documentos()->where('documento_id', $this->documento_id)->get()->pluck('id');
        $this->ship_tipo->documentos()->detach($groupIds);                
        foreach($this->selRangos as $rango_doc)
        {
            $this->ship_tipo->documentos()->attach($this->documento_id, ['rango_id' => $rango_doc]);
        }
        $this->getDocsRango();        
        $this->close();
        $this->emit('alert', 'Rangos asignados con exito!');   

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
