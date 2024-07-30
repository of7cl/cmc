<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Rango;
use Illuminate\Http\Request;

class RangoDocumentoController extends Controller
{
    public function getDocumentosRango($rango_id)    
    {
        $documentos = Rango::find($rango_id);
        //dd( $documentos->documentos );
        return $documentos->documentos;
    }

    // metodo que retorna registro por id documento e id rango
    // para saber si persona debe tenerlo o no
    public function getDocRango($rango_id, $doc_id)
    {
        //$documentos = Rango::find($rango_id)->get();
        $documentos = Rango::find($rango_id)->documentos()->get();
        foreach($documentos as $documento)
        {
            //echo $doc_id . '--' . $documento->pivot->documento_id . '<br>';
            //dd($documento);
            //echo $doc_id . '--' . $documento->pivot->documento_id . '<br>';
            if($documento->pivot->documento_id==$doc_id){
                //echo $documento->id .'<br>';  
                return $documento;
            }
            //echo $documento->id .'<br>';
        }
        //exit();
        //return $documentos->documentos->find($doc_id);
    }

    public function getDocumentos()
    {
        $documentos = Documento::all();
        return $documentos;
    }

    public function getRangos()
    {
        $rangos = Rango::all();
        return $rangos;
    }

    public function getExisteDocumentoRango($documentosRangos, $docsPersonaShipTipo, $documento_id, $rango_id)
    {        
        $arr = [];
        $bo_doc_rango = 0;
        $bo_doc_tipo_nave = 0;

        foreach ($documentosRangos as $key => $value) {
            //echo $key.'=>'.$value['documento_id']. '--' . $value['rango_id'] . '<br>';
            if($value['rango_id']==$rango_id && $value['documento_id']==$documento_id)
            {
                //echo $key.'=>'.$value['documento_id']. '--' . $value['rango_id'] . '<br>';
                $arr = ['existe'=>1, 'obligatorio'=>$value['obligatorio'], 'origen'=>'rango'];
                return $arr;
            }
        }
        if($docsPersonaShipTipo){
            foreach($docsPersonaShipTipo as $docShipTipo)        
            {
                if($docShipTipo->pivot->rango_id == $rango_id && $docShipTipo->pivot->documento_id == $documento_id){
                    $arr = ['existe'=>1, 'obligatorio'=>$value['obligatorio'], 'origen'=>'tipo_nave'];
                    return $arr;
                }                
            }
        }
        return $arr;
    }
}
