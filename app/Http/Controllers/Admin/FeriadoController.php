<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feriado;
use Illuminate\Http\Request;

class FeriadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.feriados.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.feriados.create');
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
            'fc_feriado'    =>  'required|unique:feriados'
        ]);

        $feriado = Feriado::create([
            'fc_feriado' => $request['fc_feriado'],
            'descripcion' => $request['descripcion']                              
        ]);

        return redirect()->route('admin.feriados.edit', compact('feriado'))->with('info', 'Feriado creado con éxito!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Feriado $feriado)
    {
        return view('admin.feriados.edit', compact('feriado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feriado $feriado)
    {
        if ($request->estado) {
            $estado = 1;
        } else {
            $estado = 2;
        }

        $request->validate([
            'fc_feriado'    =>  "required|unique:feriados,fc_feriado,$feriado->id"
        ]);

        Feriado::query()
            ->where('id', $feriado->id)
            ->update([
                //'fc_feriado' => $request['fc_feriado'],
                'descripcion' => $request['descripcion'],                
                'estado' => $estado
                /* 'descripcion' => "descripción de prueba", */
        ]);
        return redirect()->route('admin.feriados.edit', compact('feriado'))->with('info', 'Feriado editado con éxito!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
