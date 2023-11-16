<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Rango;
use App\Models\Ship;

class PersonaController extends Controller
{
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
    public function show(Persona $persona)
    {
        return view('admin.personas.show', compact('persona'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Persona $persona)
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

        $rangos = Rango::where('estado', 1)->pluck('nombre', 'id');
        $ships = Ship::where('estado', 1)->pluck('nombre', 'id');

        $request->validate([
            'nombre'    =>  'required',
            'rut'     => "required|unique:personas,rut,$persona->id"
            
        ]);        
        
        Persona::query()
            ->where('id', $persona->id)
            ->update([                
                'nombre' => $request['nombre'],
                'rut' => $request['rut'],
                'rango_id' => $request['rango_id'],
                'ship_id' => $request['ship_id'],
                'fc_nacimiento' => $request['fc_nacimiento'],
                'fc_ingreso' => $request['fc_ingreso'],
                'fc_baja' => $request['fc_baja'],
                
        ]);
        return redirect()->route('admin.personas.edit', compact('persona', 'rangos', 'ships'))->with('info', 'Persona editada con éxito!'); 
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
