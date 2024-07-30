<?php

namespace App\Http\Livewire\Admin;

use App\Models\DetalleTrayectoria;
use App\Models\Persona;
use Livewire\Component;

class ProgramacionEmbarcos extends Component
{
    public function render()
    {
        $personas = Persona::orderBy('id', 'desc')->get();
        $resources = [];
        foreach($personas as $persona)
        {
            $resources[] = [
                'id' => $persona->id,
                'title' => $persona->nombre
            ];
        }
        $detalleTrayectorias = DetalleTrayectoria::all();
        $events = [];
        foreach($detalleTrayectorias as $detalleTrayectoria)
        {
            $events[] = [
                'id' => $detalleTrayectoria->id,
                'resourceId' => $detalleTrayectoria->trayectoria->persona_id,
                'title' => $detalleTrayectoria->estado->nombre.' '.$detalleTrayectoria->fc_desde.' '.$detalleTrayectoria->fc_hasta,
                'start' => $detalleTrayectoria->fc_desde,
                'end' => $detalleTrayectoria->fc_hasta
            ];
            //resourceId: 'a', title: 'Embarco', start: '2024-07-18', end: '2024-07-31'
        }        
        return view('livewire.admin.programacion-embarcos', compact('resources', 'events'));
    }
}
