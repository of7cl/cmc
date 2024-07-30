<?php

namespace App\Http\Livewire\Admin;

use App\Models\Documento;
use App\Models\Notification;
use App\Models\ParameterDoc;
use App\Models\Persona;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class NotificacionesIndex extends Component
{
    public $persona;
    public $identificador;
    public $archivo;
    public $nm_archivo_guardado;
    public $nm_archivo_original;
    public $id_documento;
    public $nr_documento;
    public $codigo_omi;
    public $nombre_doc;
    public $fc_inicio;
    public $fc_fin;
    public $estado;
    public $nombre;

    protected $listeners = ['update_doc'];

    public function mount()
    {
        $this->identificador = rand();
    }

    public function render()
    {
        $notifications = Notification::whereReaded(false)
                            ->orderBy('created_at', 'desc')
                           ->get();

        return view('livewire.admin.notificaciones-index', compact('notifications'));
    }

    public function edit_doc(Notification $notification, Persona $persona)
    {
        Notification::query()
            ->where('id', $notification->id)
            ->update([
                'readed' => true
            ]);

        $documento_id = $notification->documento_id;
        $this->persona = $persona;
        foreach ($persona->documento as $documento) {
            if ($documento->pivot->documento_id == $documento_id) {
                $this->fc_inicio  = $documento->pivot->fc_inicio;
                $this->fc_fin     = $documento->pivot->fc_fin;
                if ($documento->pivot->estado == 0)
                    $this->estado     = false;
                else
                    $this->estado     = true;
                $this->nm_archivo_guardado = $documento->pivot->nm_archivo_guardado;
                $this->nm_archivo_original = $documento->pivot->nm_archivo_original;
            }
        }

        $documento = Documento::where('id', $documento_id)->first();
        $this->id_documento = $documento_id;
        $this->nr_documento = $documento->nr_documento;
        $this->codigo_omi   = $documento->codigo_omi;
        $this->nombre_doc   = $documento->nombre;
        $this->nombre = $persona->nombre;
    }

    public function update_doc($bo_confirm = 0)
    {
        if ($this->fc_fin && $this->fc_inicio && !$this->archivo && !$this->nm_archivo_guardado)
            $bo_archivo = 1;
        else
            $bo_archivo = 0;

        if ($bo_confirm == 1)
            $bo_archivo = 0;

        if ($bo_archivo == 0) {
            $cn_rules = 0;
            $customMessages = [
                "required" => 'El campo fecha es obligatorio.',
                "after" => 'Fecha Vencimiento debe ser mayor a Fecha Inicio.',
                "mimes" => 'Debe seleccionar solo archivos PDF.'
            ];

            if ($this->fc_fin) {
                $rules['fc_inicio'] = 'required';
                $rules['fc_fin'] = 'required|after:fc_inicio';
                $cn_rules++;
            }

            if ($this->fc_inicio) {
                $rules['fc_fin'] = 'required|after:fc_inicio';
                $cn_rules++;
            }

            if ($this->archivo) {
                if ($this->nm_archivo_guardado) {
                    Storage::delete($this->nm_archivo_guardado);
                }
                $rules['archivo'] = 'mimes:pdf|max:10000';
                $rules['fc_inicio'] = 'required';
                $rules['fc_fin'] = 'required|after:fc_inicio';
                $extension = $this->archivo->getClientOriginalExtension();
                $nm_archivo = 'documento_' . $this->persona->id . '_' . $this->id_documento . '.' . $extension;
                $archivo_url = $this->archivo->storeAs('documentos_persona', $nm_archivo);
                //dd($this->archivo->file());
                //$archivo_url = Storage::put('documentos_persona', $this->archivo->file('archivo'));
                $cn_rules++;
            } else {
                $rules['fc_inicio'] = 'required';
                $rules['fc_fin'] = 'required|after:fc_inicio';
                $archivo_url = $this->nm_archivo_guardado;
                $cn_rules++;
            }

            if ($cn_rules > 0)
                $this->validate($rules, $customMessages);

            if ($this->estado == true)
                $this->estado = "1";
            else
                $this->estado = "0";

            $semaforo = "0";
            if ($this->fc_fin) {
                $parametro = ParameterDoc::all()->first();
                $flag_red = $parametro->flag_red;
                $flag_yellow = $parametro->flag_yellow;
                $flag_orange = $parametro->flag_orange;

                $now = Carbon::now()->timeZone('America/Santiago');
                $diff = $now->diffInDays($this->fc_fin, false);

                if ($diff <= $flag_red) {
                    $semaforo = "2";
                } else if ($diff > $flag_red && $diff <= $flag_orange) {
                    $semaforo = "3";
                } else if ($diff > $flag_orange && $diff <= $flag_yellow) {
                    $semaforo = "4";
                } else {
                    $semaforo = "5";
                }
            }
            //dd($this->estado);
            if ($this->estado == "1") {
                $semaforo = "1";
            }

            $docs = [
                $this->id_documento => [
                    "persona_id" => $this->persona->id,
                    "documento_id" => $this->id_documento,
                    "rango_id" => $this->persona->rango_id,
                    'fc_inicio' => $this->fc_inicio,
                    'fc_fin' => $this->fc_fin,
                    'estado' => $this->estado,
                    'nm_archivo_guardado' => $archivo_url,
                    'nm_archivo_original' => null,
                    'semaforo' => $semaforo
                ],
            ];

            foreach ($this->persona->documento as $persona_documento) {
                if ($persona_documento->pivot->documento_id != $this->id_documento) {
                    $doc = [
                        "persona_id" => $persona_documento->pivot->persona_id,
                        "documento_id" => $persona_documento->pivot->documento_id,
                        "rango_id" => $persona_documento->pivot->rango_id,
                        "fc_inicio" => $persona_documento->pivot->fc_inicio,
                        "fc_fin" => $persona_documento->pivot->fc_fin,
                        "estado" => $persona_documento->pivot->estado,
                        'nm_archivo_guardado' => $persona_documento->pivot->nm_archivo_guardado,
                        'nm_archivo_original' => null,
                        'semaforo' => $persona_documento->pivot->semaforo
                    ];
                    array_push($docs, $doc);
                }
            }
            //dd($docs);
            $this->persona->documento()->detach($this->persona->documento);

            $this->persona->documento()->sync($docs);

            $this->close_doc();
            $this->resetErrorBag();
            $this->emit('render');
            $this->emit('alert_upd_doc', 'Documento editado con exito!');
        } else {
            $this->resetErrorBag();
            $this->emit('confirmEdit', 'arreglar!');
        }
    }

    public function close_doc()
    {
        $this->reset('persona', 'nombre', 'nombre_doc', 'codigo_omi', 'nr_documento', 'id_documento', 'nm_archivo_original', 'nm_archivo_guardado', 'estado', 'fc_fin', 'fc_inicio', 'archivo');
        $this->identificador = rand();
        $this->resetErrorBag();
    }
}
