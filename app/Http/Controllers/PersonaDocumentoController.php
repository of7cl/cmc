<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CarbonController;
use App\Models\Notification;
use App\Models\ParameterDoc;
use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaDocumentoController extends Controller
{
    //
    public function getPersonasDocumentos()
    {
        /*$personas = Persona::where('id', 251)->get();
        foreach ($personas as $persona) {
            foreach ($persona->documento as $documento) {
                dd($documento->pivot->fc_fin);
            }
            
        }*/
        $personas = Persona::with('documento')
            //->where('id', 251)
            ->get();
        return $personas;
    }

    public function getDocumentosVencidos($personas)
    {
        /* $parameterdocs = ParameterDoc::all(); */
        /* $flag_red = $parameterdocs[0]->flag_red;
        $flag_orange = $parameterdocs[0]->flag_orange;
        $flag_yellow = $parameterdocs[0]->flag_yellow; */
        $fecha = new CarbonController();
        $vencimientos = [];
        $i = 0;
        foreach ($personas as $persona) {
            foreach ($persona->documento as $documento) {
                $fc_fin = $documento->pivot->fc_fin;
                /* $diff = $fecha->diffFechaActual($fc_fin); */
                $semaforo = $documento->pivot->semaforo;

                $notificacion = Notification::where('persona_id', $persona->id)
                    ->where('documento_id', $documento->id)
                    ->orderBy('created_at', 'desc')
                    ->first();
                //dd($notificacion);
                if ($notificacion) {
                    if ($notificacion->readed == 1) { // leida
                        if ($notificacion->semaforo == $semaforo) {
                            $notificacion->update(['readed' => false]);
                        } else {
                            $notificacion->delete();
                            if ($semaforo == '2') { //red
                                $vencimientos[$i]['icon'] = 'fas fa-user';
                                $vencimientos[$i]['text'] = 'Documento ' . $documento->nr_documento . ' ' . $documento->codigo_omi . ' se encuentra vencido con fecha ' . $fecha->formatodmY($fc_fin) . ', para ' . $persona->nombre;
                                $vencimientos[$i]['alert'] = 'red';
                                $vencimientos[$i]['persona_id'] = $persona->id;
                                $vencimientos[$i]['documento_id'] = $documento->id;
                                $vencimientos[$i]['semaforo'] = $semaforo;
                                $i++;
                            } else if ($semaforo == '3') { //orange
                                $vencimientos[$i]['icon'] = 'fas fa-user';
                                $vencimientos[$i]['text'] = 'Documento ' . $documento->nr_documento . ' ' . $documento->codigo_omi . ' está por vencer con fecha ' . $fecha->formatodmY($fc_fin) . ', para ' . $persona->nombre;
                                $vencimientos[$i]['alert'] = 'orange';
                                $vencimientos[$i]['persona_id'] = $persona->id;
                                $vencimientos[$i]['documento_id'] = $documento->id;
                                $vencimientos[$i]['semaforo'] = $semaforo;
                                $i++;
                            } else if ($semaforo == '4') { //yellow
                                $vencimientos[$i]['icon'] = 'fas fa-user';
                                $vencimientos[$i]['text'] = 'Documento ' . $documento->nr_documento . ' ' . $documento->codigo_omi . ' está por vencer con fecha ' . $fecha->formatodmY($fc_fin) . ', para ' . $persona->nombre;
                                $vencimientos[$i]['alert'] = 'yellow';
                                $vencimientos[$i]['persona_id'] = $persona->id;
                                $vencimientos[$i]['documento_id'] = $documento->id;
                                $vencimientos[$i]['semaforo'] = $semaforo;
                                $i++;
                            }                             
                        }
                    }
                    else
                    {
                        if ($notificacion->semaforo <> $semaforo) {
                            $notificacion->delete();
                            if ($semaforo == '2') { //red
                                $vencimientos[$i]['icon'] = 'fas fa-user';
                                $vencimientos[$i]['text'] = 'Documento ' . $documento->nr_documento . ' ' . $documento->codigo_omi . ' se encuentra vencido con fecha ' . $fecha->formatodmY($fc_fin) . ', para ' . $persona->nombre;
                                $vencimientos[$i]['alert'] = 'red';
                                $vencimientos[$i]['persona_id'] = $persona->id;
                                $vencimientos[$i]['documento_id'] = $documento->id;
                                $vencimientos[$i]['semaforo'] = $semaforo;
                                $i++;
                            } else if ($semaforo == '3') { //orange
                                $vencimientos[$i]['icon'] = 'fas fa-user';
                                $vencimientos[$i]['text'] = 'Documento ' . $documento->nr_documento . ' ' . $documento->codigo_omi . ' está por vencer con fecha ' . $fecha->formatodmY($fc_fin) . ', para ' . $persona->nombre;
                                $vencimientos[$i]['alert'] = 'orange';
                                $vencimientos[$i]['persona_id'] = $persona->id;
                                $vencimientos[$i]['documento_id'] = $documento->id;
                                $vencimientos[$i]['semaforo'] = $semaforo;
                                $i++;
                            } else if ($semaforo == '4') { //yellow
                                $vencimientos[$i]['icon'] = 'fas fa-user';
                                $vencimientos[$i]['text'] = 'Documento ' . $documento->nr_documento . ' ' . $documento->codigo_omi . ' está por vencer con fecha ' . $fecha->formatodmY($fc_fin) . ', para ' . $persona->nombre;
                                $vencimientos[$i]['alert'] = 'yellow';
                                $vencimientos[$i]['persona_id'] = $persona->id;
                                $vencimientos[$i]['documento_id'] = $documento->id;
                                $vencimientos[$i]['semaforo'] = $semaforo;
                                $i++;
                            }                             
                        } 
                    }
                } else {
                    if ($semaforo == '2') { //red
                        $vencimientos[$i]['icon'] = 'fas fa-user';
                        $vencimientos[$i]['text'] = 'Documento ' . $documento->nr_documento . ' ' . $documento->codigo_omi . ' se encuentra vencido con fecha ' . $fecha->formatodmY($fc_fin) . ', para ' . $persona->nombre;
                        $vencimientos[$i]['alert'] = 'red';
                        $vencimientos[$i]['persona_id'] = $persona->id;
                        $vencimientos[$i]['documento_id'] = $documento->id;
                        $vencimientos[$i]['semaforo'] = $semaforo;
                        $i++;
                    } else if ($semaforo == '3') { //orange
                        $vencimientos[$i]['icon'] = 'fas fa-user';
                        $vencimientos[$i]['text'] = 'Documento ' . $documento->nr_documento . ' ' . $documento->codigo_omi . ' está por vencer con fecha ' . $fecha->formatodmY($fc_fin) . ', para ' . $persona->nombre;
                        $vencimientos[$i]['alert'] = 'orange';
                        $vencimientos[$i]['persona_id'] = $persona->id;
                        $vencimientos[$i]['documento_id'] = $documento->id;
                        $vencimientos[$i]['semaforo'] = $semaforo;
                        $i++;
                    } else if ($semaforo == '4') { //yellow
                        $vencimientos[$i]['icon'] = 'fas fa-user';
                        $vencimientos[$i]['text'] = 'Documento ' . $documento->nr_documento . ' ' . $documento->codigo_omi . ' está por vencer con fecha ' . $fecha->formatodmY($fc_fin) . ', para ' . $persona->nombre;
                        $vencimientos[$i]['alert'] = 'yellow';
                        $vencimientos[$i]['persona_id'] = $persona->id;
                        $vencimientos[$i]['documento_id'] = $documento->id;
                        $vencimientos[$i]['semaforo'] = $semaforo;
                        $i++;
                    }
                }
            }
        }
        return $vencimientos;
    }
}
