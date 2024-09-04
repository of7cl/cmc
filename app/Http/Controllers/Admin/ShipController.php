<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ship;
use App\Models\ShipTipo;
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
        //dd($ships);
        return view('admin.ships.index', compact('ships'));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $ship_tipos = ShipTipo::pluck('nombre', 'id');
        return view('admin.ships.create', compact('ship_tipos'));
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
            'codigo'    =>  'required|unique:ships',
            'nombre'     => 'required',  
            'ship_tipo_id' => 'required',
            'imo'     => 'required',
            'dwt'     => 'required',
            'trg'     => 'required',
            'loa'     => 'required',
            'manga'     => 'required'            
        ]);
                
        $ship = Ship::create([
                    'codigo' => $request['codigo'],
                    'nombre' => $request['nombre'],
                    'ship_tipo_id' => $request['ship_tipo_id'],
                    'imo' => $request['imo'],
                    'dwt' => $request['dwt'],
                    'trg' => $request['trg'],
                    'loa' => $request['loa'],
                    'manga' => $request['manga'],
                    'descripcion' => "descripción de prueba",                    
                ]);
        
        return redirect()->route('admin.ships.edit', compact('ship'))->with('info', 'Nave creada con éxito!');
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
        $ship_tipos = ShipTipo::pluck('nombre', 'id');
        return view('admin.ships.edit', compact('ship', 'ship_tipos'));        
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
            'codigo'     => "required|unique:ships,codigo,$ship->id",
            'nombre'     => 'required', 
            'ship_tipo_id' => 'required',           
            'imo'     => 'required',
            'dwt'     => 'required',
            'trg'     => 'required',
            'loa'     => 'required',
            'manga'     => 'required'            
        ]);        
        
        if ($request->estado) {
            $estado = 1;
        } else {
            $estado = 2;
        }

        Ship::query()
            ->where('id', $ship->id)
            ->update([
                'codigo' => $request['codigo'],
                'nombre' => $request['nombre'],
                'ship_tipo_id' => $request['ship_tipo_id'],
                'imo' => $request['imo'],
                'dwt' => $request['dwt'],
                'trg' => $request['trg'],
                'loa' => $request['loa'],
                'manga' => $request['manga'],
                'estado' => $estado
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
