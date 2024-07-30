<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShipTipo;
use Illuminate\Http\Request;

class ShipTipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ship_tipos = ShipTipo::all();        
        return view('admin.ship_tipos.index', compact('ship_tipos'));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.ship_tipos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([            
            'nombre'     => 'required'            
        ]);
                
        $ship_tipo = ShipTipo::create([                    
                    'nombre' => $request['nombre']                    
                ]);
        return redirect()->route('admin.ship_tipos.edit', compact('ship_tipo'))->with('info', 'Tipo de Nave creada con éxito!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShipTipo $ship_tipo)
    {
        //
        return view('admin.ship_tipos.show', compact('ship_tipo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ShipTipo $ship_tipo)
    {
        //
        return view('admin.ship_tipos.edit', compact('ship_tipo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShipTipo $ship_tipo)
    {
        //
        $request->validate([            
            'nombre'     => 'required'            
        ]);   
        
        if ($request->estado) {
            $estado = 1;
        } else {
            $estado = 2;
        }
                
        ShipTipo::query()
            ->where('id', $ship_tipo->id)
            ->update([
                'nombre' => $request['nombre'],
                'estado' => $estado
        ]);
        return redirect()->route('admin.ship_tipos.edit', compact('ship_tipo'))->with('info', 'Tipo de Nave editada con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShipTipo $ship_tipo)
    {
        //
        $ship_tipo->delete();        
        return redirect()->route('admin.ship_tipos.index')->with('info', 'Tipo de Nave eliminada con éxito!'); 
    }
}
