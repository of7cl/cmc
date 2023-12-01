<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Documento;

class DocumentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:mantencion.documentos.index')->only('index');
        $this->middleware('can:mantencion.documentos.create')->only('create','store');
        $this->middleware('can:mantencion.documentos.edit')->only('edit','update');
        $this->middleware('can:mantencion.documentos.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.documentos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.documentos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* $request->validate([
            'nombre'    =>  'required',
            'rut'     => 'required|unique:personas'                                    
        ]); */
                
        $documento = Documento::create([                    
                    'nr_documento' => $request['nr_documento'],
                    'codigo_omi' => $request['codigo_omi'],
                    'nombre' => $request['nombre'],
                    'name' => $request['name'],
                ]);
                
        return redirect()->route('admin.documentos.edit', compact('documento'))->with('info', 'Documento creado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Documento $documento)
    {
        return view('admin.documentos.show', compact('documento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Documento $documento)
    {
        return view('admin.documentos.edit', compact('documento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documento $documento)
    {        
        if($request->estado)
        {
            $estado = 1;
        }
        else
        {
            $estado = 2;
        }

        Documento::query()
            ->where('id', $documento->id)
            ->update([                
                'nr_documento' => $request['nr_documento'],
                'codigo_omi' => $request['codigo_omi'],
                'nombre' => $request['nombre'],
                'name' => $request['name'],
                'estado' => $estado
        ]);
        return redirect()->route('admin.documentos.edit', compact('documento'))->with('info', 'Documento editado con éxito!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Documento $documento)
    {
        $documento->delete();
        return redirect()->route('admin.documentos.index')->with('info', 'Documento eliminado con éxito!');
    }
}
