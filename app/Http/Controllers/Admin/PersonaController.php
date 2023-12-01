<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Rango;
use App\Models\Ship;
use Carbon\Carbon;

class PersonaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:mantencion.personas.index')->only('index');
        $this->middleware('can:mantencion.personas.create')->only('create','store');
        $this->middleware('can:mantencion.personas.edit')->only('edit','update');
        $this->middleware('can:mantencion.personas.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.personas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rangos = Rango::where('estado', 1)->pluck('nombre', 'id');
        $ships = Ship::where('estado', 1)->pluck('nombre', 'id');
        
        /* return view('admin.personas.create', compact('rangos'), compact('ships')); */
        return view('admin.personas.create', compact('rangos', 'ships'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'    =>  'required',
            'rut'     => 'required|unique:personas'                                    
        ]);
                
        $persona = Persona::create([                    
                    'nombre' => $request['nombre'],
                    'rut' => $request['rut'],
                    'rango_id' => $request['rango_id'],
                    'ship_id' => $request['ship_id'],
                    'fc_nacimiento' => $request['fc_nacimiento'],
                    'fc_ingreso' => $request['fc_ingreso'],
                    'fc_baja' => $request['fc_baja'],                    
                ]);
                
        return redirect()->route('admin.personas.edit', compact('persona'))->with('info', 'Persona creada con éxito!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Persona $persona)
    {                
        $rango = Rango::where('id', $persona->rango_id)->first();
        if($rango)       
            $rango_documentos = $rango->documentos;                 
        else
            $rango_documentos = null;
        return view('admin.personas.show', compact('persona', 'rango_documentos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Persona $persona)
    {        
        $rangos = Rango::where('estado', 1)->pluck('nombre', 'id');
        $ships = Ship::where('estado', 1)->pluck('nombre', 'id');
        /* return view('admin.personas.edit', compact('persona'), compact('ships'), compact('rangos')); */
        return view('admin.personas.edit', compact('persona','ships','rangos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Persona $persona)
    {        

        //return $request;        

        if ($request->opcion=='upd_doc') {      
            
            $campos = $request;

            $fc_inicio = $campos['fc_inicio'.$request->documento_id];
            $fc_fin = $campos['fc_fin'.$request->documento_id];

            $rango = Rango::where('id', $persona->rango_id)->first();       
            $rango_documentos = $rango->documentos;
            
            foreach($rango_documentos as $rango_documento){
                if($rango_documento->id==$request->documento_id)
                {
                    $rules['fc_inicio'.$rango_documento->id] = 'required';
                    $rules['fc_fin'.$rango_documento->id] = 'required|after:fc_inicio'.$rango_documento->id;                    
                }
            }

            //return $rules;

            $customMessages = [
                "required" => 'El campo fecha es obligatorio.',
                "after" => 'Fecha fin debe ser mayor a fecha de inicio.'
            ];

            $this->validate($request,$rules,$customMessages);               
            
            //$fc_inicio = $request->'fc_inicio13';

            $docs = [
                $request->documento_id => [
                    "persona_id" => $persona->id,
                    "documento_id" => $request->documento_id,
                    "rango_id" => $persona->rango_id,
                    'fc_inicio' => $fc_inicio,
                    'fc_fin' => $fc_fin,
                ],
            ];            

            foreach($persona->documento as $persona_documento){
                if($persona_documento->pivot->documento_id != $request->documento_id){
                    $doc = [
                        "persona_id" => $persona_documento->pivot->persona_id,
                        "documento_id" => $persona_documento->pivot->documento_id,
                        "rango_id" => $persona_documento->pivot->rango_id,
                        "fc_inicio" => $persona_documento->pivot->fc_inicio,
                        "fc_fin" => $persona_documento->pivot->fc_fin,
                    ];                
                    array_push($docs, $doc);
                }
            }

            //return $request;
            //return $docs;

            $persona->documento()->detach( $persona->documento );            
            
            $persona->documento()->sync( $docs );                         

            return redirect()->route('admin.personas.show', compact('persona', 'rango_documentos'))->with('info', 'Documento actualizado con éxito!');

        } else {
            
            $rangos = Rango::where('estado', 1)->pluck('nombre', 'id');
            $ships = Ship::where('estado', 1)->pluck('nombre', 'id');                                                
            
            $request->validate([
                'nombre'    =>  'required',
                'rut'     => "required|unique:personas,rut,$persona->id"
                
            ]);     
            
            if ($request->estado) {
                $estado = 1;
            } else {
                $estado = 2;
            }
            
            
            $update = Persona::query()
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

            if($request->rango_id != $persona->rango_id){                
                $persona->documento()->detach( $persona->documento );
            }            

            return redirect()->route('admin.personas.edit', compact('persona', 'rangos', 'ships'))->with('info', 'Persona editada con éxito!'); 
        }
            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona)
    {
        $persona->delete();
        return redirect()->route('admin.personas.index')->with('info', 'Persona eliminada con éxito!'); 
    }
}
