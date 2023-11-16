<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rango;

class RangoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rangos = Rango::where('estado', 1)->get();
        return view('admin.rangos.index', compact('rangos'));        
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
        return view('admin.rangos.show', compact('rango'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Rango $rango)
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
        $request->validate([
            'codigo'    =>  "required|unique:rangos,codigo,$rango->id",
            'nombre'     => 'required'            
        ]);        

        $nombre_completo = $request['codigo']." ".$request['nombre'];
        Rango::query()
            ->where('id', $rango->id)
            ->update([
                'codigo' => $request['codigo'],
                'nombre' => $request['nombre'],
                'nombre_completo' => $nombre_completo,
        ]);
        return redirect()->route('admin.rangos.edit', compact('rango'))->with('info', 'Rango editado con éxito!'); 
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
