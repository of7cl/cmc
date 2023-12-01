<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use App\Models\Persona;
use Illuminate\Http\Request;
use App\Models\Rango;

class RangoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:mantencion.rangos.index')->only('index');
        $this->middleware('can:mantencion.rangos.create')->only('create','store');
        $this->middleware('can:mantencion.rangos.edit')->only('edit','update');
        $this->middleware('can:mantencion.rangos.destroy')->only('destroy');
        $this->middleware('can:mantencion.rangos.show')->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $rangos = Rango::where('estado', 1)->get(); */
        $rangos = Rango::all();
        return view('admin.rangos.index', compact('rangos'));        
        //$rangos_documentos = Rango::with('documentos')->get();
        /* return $rangos_documentos; */
        //return view('admin.rangos.index', compact('rangos', 'rangos_documentos'));        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        return view('admin.rangos.create');
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
            'codigo'    =>  'required|unique:rangos',
            'nombre'     => 'required'            
        ]);
        
        $nombre_completo = $request['codigo']." ".$request['nombre'];
        $rango = Rango::create([
                    'codigo' => $request['codigo'],
                    'nombre' => $request['nombre'],
                    'nombre_completo' => $nombre_completo,
                ]);
        return redirect()->route('admin.rangos.edit', compact('rango'))->with('info', 'Rango creado con éxito!');        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Rango $rango)
    {        
        /* $rango_documentos = $rango->documentos;
        return $rango_documentos; */
        //return $rango->documentos;
        //return $rango;
        return view('admin.rangos.show', compact('rango'));
    }

     /**
     * Permite ver, agregar y quitar documentos asociados a un rango
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function documento(Rango $rango)
    {      
        $rango_documentos = $rango->documentos;
        /* return $rango_documentos; */
        return view('admin.rangos.documentos', compact('rango', 'rango_documentos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Rango $rango)
    {                
        return view('admin.rangos.edit', compact('rango'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rango $rango)
    {      
        
        //return $request;
        
        if ($request->opcion == 'docs') {   
            
            $request->validate([
                'documento'    =>  "required",                
            ]);        
            
            if($request->obligatorio){
                $obligatorio = 1;
            }else{
                $obligatorio = 2;
            }
            
            $rango->documentos()->detach($request->documento);

            $docs = [
                        $request->documento => ['obligatorio' => $obligatorio],                        
                ];
            foreach($rango->documentos as $rango_documento){
                array_push($docs, $rango_documento->id);
            }            

            $rango->documentos()->sync( $docs );

            return redirect()->route('admin.rangos.show', compact('rango'))->with('info', 'Documento asignado con éxito!');
            
        } elseif($request->opcion == 'del_doc'){


            $rango->documentos()->detach($request->doc_id);

            return redirect()->route('admin.rangos.show', compact('rango'))->with('info', 'Documento eliminado con éxito!');

        } else{
            $request->validate([
                'codigo'    =>  "required|unique:rangos,codigo,$rango->id",
                'nombre'     => 'required'            
            ]);        

            if($request->estado)
            {
                $estado = 1;
            }
            else
            {
                $estado = 2;
            }
    
            $nombre_completo = $request['codigo']." ".$request['nombre'];
            Rango::query()
                ->where('id', $rango->id)
                ->update([
                    'codigo' => $request['codigo'],
                    'nombre' => $request['nombre'],
                    'nombre_completo' => $nombre_completo,
                    'estado' => $estado
            ]);
            return redirect()->route('admin.rangos.edit', compact('rango'))->with('info', 'Rango editado con éxito!');
        }
        

         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rango $rango)
    {        
        $rango->delete();        
        return redirect()->route('admin.rangos.index')->with('info', 'Rango eliminado con éxito!'); 
    }
   
}
