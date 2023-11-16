<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nave;

class NaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $naves = Nave::where('estado', 1)->get();
        return view('admin.naves.index', compact('naves'));      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.naves.create');
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
            'codigo'    =>  'required|unique:naves',
            'nombre'     => 'required',            
            'imo'     => 'required',
            'dwt'     => 'required',
            'trg'     => 'required',
            'loa'     => 'required',
            'manga'     => 'required'            
        ]);
                
        $nave = Nave::create([
                    'codigo' => $request['codigo'],
                    'nombre' => $request['nombre'],
                    'imo' => $request['imo'],
                    'dwt' => $request['dwt'],
                    'trg' => $request['trg'],
                    'loa' => $request['loa'],
                    'manga' => $request['manga'],
                    'descripcion' => "descripción de prueba",                    
                ]);
        //return $nave;
        return redirect()->route('admin.naves.edit', compact('nave'));
        
        //return redirect()->route('admin.naves.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Nave $nave)
    {
        return view('admin.naves.show', compact('nave'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Nave $nave)
    {
        return view('admin.naves.edit', compact('nave'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nave $nave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nave $nave)
    {
        //
    }
}
