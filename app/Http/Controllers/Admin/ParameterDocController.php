<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParameterDoc;
use Illuminate\Http\Request;

class ParameterDocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameterdocs = ParameterDoc::all();
        return view('admin.parameterdocs.index', compact('parameterdocs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.parameterdocs.create');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ParameterDoc $parameterdoc)
    {
        return view('admin.parameterdocs.show', compact('parameterdoc'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ParameterDoc $parameterdoc)
    {
        return view('admin.parameterdocs.edit', compact('parameterdoc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ParameterDoc $parameterdoc)
    {
        //dd($parameterdoc);
        $request->validate([
            'flag_red'    =>  'required',
            'flag_yellow' =>  'required',
            'flag_green'  =>  'required'
        ]);        
                
        ParameterDoc::query()
            ->where('id', $parameterdoc->id)
            ->update([
                'flag_red' => $request['flag_red'],
                'flag_yellow' => $request['flag_yellow'],
                'flag_green' => $request['flag_green']                
        ]);
        return redirect()->route('admin.parameterdocs.index', compact('parameterdoc'))->with('info', 'Parámetro editado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParameterDoc $parameterdoc)
    {
        //
    }

    public function getParameterDocs()    
    {
        $parameterdocs = ParameterDoc::all();
        //dd( $documentos->documentos );
        return $parameterdocs;
    }
}
