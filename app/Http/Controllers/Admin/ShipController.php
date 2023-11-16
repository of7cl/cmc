<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ship;
use Illuminate\Http\Request;

class ShipController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:mantencion.ships.index')->only('index');
        $this->middleware('can:mantencion.ships.create')->only('create','store');
        $this->middleware('can:mantencion.ships.edit')->only('edit','update');
        $this->middleware('can:mantencion.ships.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ships = Ship::where('estado', 1)->get();
        return view('admin.ships.index', compact('ships'));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ships.create');
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
                
        $ship = Ship::create([
                    'codigo' => $request['codigo'],
                    'nombre' => $request['nombre'],
                    'imo' => $request['imo'],
                    'dwt' => $request['dwt'],
                    'trg' => $request['trg'],
                    'loa' => $request['loa'],
                    'manga' => $request['manga'],
                    'descripcion' => "descripción de prueba",                    
                ]);
        
        return redirect()->route('admin.ships.edit', compact('ship'))->with('info', 'Nave creada con éxito!');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ship $ship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Ship $ship)
    {
        return view('admin.ships.edit', compact('ship'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ship $ship)
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
        
        Ship::query()
            ->where('id', $ship->id)
            ->update([
                'codigo' => $request['codigo'],
                'nombre' => $request['nombre'],
                'imo' => $request['imo'],
                'dwt' => $request['dwt'],
                'trg' => $request['trg'],
                'loa' => $request['loa'],
                'manga' => $request['manga'],
                /* 'descripcion' => "descripción de prueba", */
        ]);
        return redirect()->route('admin.ships.edit', compact('ship'))->with('info', 'Nave editada con éxito!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ship $ship)
    {
        $ship->delete();
        return redirect()->route('admin.ships.index')->with('info', 'Nave eliminada con éxito!'); 
    }
}
