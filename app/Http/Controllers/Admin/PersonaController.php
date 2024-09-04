<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContratoTipo;
use App\Models\Documento;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Rango;
use App\Models\Ship;
use App\Models\Trayectoria;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;

class PersonaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:mantencion.personas.index')->only('index');
        $this->middleware('can:mantencion.personas.create')->only('create', 'store');
        $this->middleware('can:mantencion.personas.edit')->only('edit', 'update');
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
        //$contrato_tipos = ContratoTipo::get()->pluck('name', 'id');        

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
            'rut'     => 'required|unique:personas',
            'file' => 'image|max:1024'
        ]);

        if($request->file('file')){
            $url = Storage::put('foto_perfil', $request->file('file'));
        }else
            $url = null;

        $persona = Persona::create([
            'nombre' => $request['nombre'],
            'rut' => $request['rut'],
            'rango_id' => $request['rango_id'],
            'ship_id' => $request['ship_id'],
            'fc_nacimiento' => $request['fc_nacimiento'],
            'fc_ingreso' => $request['fc_ingreso'],
            'fc_baja' => $request['fc_baja'],
            'foto' => $url,
            'contrato_tipo_id' => $request['contrato_tipo_id']
        ]);

        $trayectoria = Trayectoria::create([
            'persona_id' => $persona->id
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
        if ($rango){
            $rango_documentos = $rango->documentos;                        
        }
        else
        {            
            $rango_documentos = null;                                    
        }
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
        //$contrato_tipos = ContratoTipo::get()->pluck('name', 'id');        
        /* return view('admin.personas.edit', compact('persona'), compact('ships'), compact('rangos')); */
        return view('admin.personas.edit', compact('persona', 'ships', 'rangos'));
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
        if ($request->opcion == 'upd_doc') {
            
            $campos = $request;

            $fc_inicio = $campos['fc_inicio' . $request->documento_id];
            $fc_fin = $campos['fc_fin' . $request->documento_id];
            $estado = $campos['estado' . $request->documento_id];
            $file_id = 'file'.$request->documento_id;
                                    
            if($request->file($file_id)){
                $file_name = $request->file($file_id)->getClientOriginalName();
                $url_file = Storage::put('documentos_persona', $request->file($file_id));
                $rules['file' . $request->documento_id] = 'mimes:pdf|max:10000';
            }
            

            //dd($rules);
            if ($estado) {
                $estado = "1";
            } else {
                $estado = "0";
            }
            //dd($estado);
            $rango = Rango::where('id', $persona->rango_id)->first();
            $rango_documentos = $rango->documentos;

            foreach ($rango_documentos as $rango_documento) {
                if ($rango_documento->id == $request->documento_id) {
                    $rules['fc_inicio' . $rango_documento->id] = 'required';
                    $rules['fc_fin' . $rango_documento->id] = 'required|after:fc_inicio' . $rango_documento->id;
                }
            }

            //return $rules;

            $customMessages = [
                "required" => 'El campo fecha es obligatorio.',
                "after" => 'Fecha fin debe ser mayor a fecha de inicio.',
                "mimes" => 'Debe seleccionar solo archivos PDF.'
            ];

            if($estado==0 || $request->file($file_id))
                $this->validate($request, $rules, $customMessages);            

            //$fc_inicio = $request->'fc_inicio13';

            $docs = [
                $request->documento_id => [
                    "persona_id" => $persona->id,
                    "documento_id" => $request->documento_id,
                    "rango_id" => $persona->rango_id,
                    'fc_inicio' => $fc_inicio,
                    'fc_fin' => $fc_fin,
                    'estado' => $estado
                ],
            ];
            //$docs = [];
            //dd($docs);
            foreach ($persona->documento as $persona_documento) {
                if ($persona_documento->pivot->documento_id != $request->documento_id) {
                    $doc = [
                        "persona_id" => $persona_documento->pivot->persona_id,
                        "documento_id" => $persona_documento->pivot->documento_id,
                        "rango_id" => $persona_documento->pivot->rango_id,
                        "fc_inicio" => $persona_documento->pivot->fc_inicio,
                        "fc_fin" => $persona_documento->pivot->fc_fin,
                        "estado" => $persona_documento->pivot->estado
                    ];
                    array_push($docs, $doc);
                }
            }

            //return $request;
            //return $docs;
            //dd($persona->documento);
            //dd($docs);
            $persona->documento()->detach($persona->documento);

            $persona->documento()->sync($docs);

            return redirect()->route('admin.personas.show', compact('persona', 'rango_documentos'))->with('info', 'Documento actualizado con éxito!');
        } else {
            //return $request->file('file_upd');            
            $request->validate([
                'nombre'    =>  'required',
                'file_upd' => 'image|max:1024',
                'rut'     => "required|unique:personas,rut,$persona->id"              
            ]);

            if ($request->estado) {
                $estado = 1;
            } else {
                $estado = 2;
            }

            // si viene fecha de baja, persona debe quedar inactiva
            if($request['fc_baja'])
            {
                $estado = 2;
            }

            if($request->file('file_upd')){
                $url = Storage::put('foto_perfil', $request->file('file_upd'));

                if($persona->foto){
                    Storage::delete($persona->foto);
                }
            }else{
                if($persona->foto){
                    $url = $persona->foto;
                }else{
                    $url = null;
                }
            }
                        
            if($request->eventual)  // chk true
                $eventual = 2; // eventual
            else
                $eventual = 1; // normal

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
                    'estado' => $estado,
                    'eventual' => $eventual,
                    'foto' => $url,
                    'contrato_tipo_id' => $request['contrato_tipo_id']

                ]);

            // eliminar documentos persona
            /* if ($request->rango_id != $persona->rango_id) {
                $persona->documento()->detach($persona->documento);
            } */
            /* $rangos = Rango::where('estado', 1)->pluck('nombre', 'id');
            $ships = Ship::where('estado', 1)->pluck('nombre', 'id'); */
            return redirect()->route('admin.personas.edit', compact('persona'))->with('info', 'Persona editada con éxito!');
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
        //$persona->delete();
        //$notificaciones = Notification::where('codigo', $persona->id)->delete();
        return redirect()->route('admin.personas.index')->with('info', 'Persona eliminada con éxito!');
    }
}
