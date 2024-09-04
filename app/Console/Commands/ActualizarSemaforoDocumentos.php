<?php

namespace App\Console\Commands;


use App\Models\ParameterDoc;
use App\Models\Persona;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ActualizarSemaforoDocumentos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updsemaforo:documentos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el semaforo de los documentos en cada que se realice una modificación a los parametros';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //$bo_upd_param = ParameterDoc::where('updated_at', '>', Carbon::now()->subHours(1))->count();
        Log::info('Inicio Proceso Actualización Semaforo Documentos');
        $documentos_personas = Persona::has('documento')->get();
        $parametro = ParameterDoc::all()->first();
        $flag_red = $parametro->flag_red;
        $flag_yellow = $parametro->flag_yellow;
        $flag_orange = $parametro->flag_orange;
        $actualizados = 0;
        foreach ($documentos_personas as $docs_persona) {
            foreach ($docs_persona->documento as $doc_persona) {
                //Log::info($doc_persona->pivot->fc_fin);
                $semaforo = 0;                
                if ($doc_persona->pivot->fc_fin) {
                    $now = Carbon::now()->timeZone('America/Santiago');
                    $diff = $now->diffInDays($doc_persona->pivot->fc_fin, false);

                    if ($diff <= $flag_red) {
                        $semaforo = "2";
                    } else if ($diff > $flag_red && $diff <= $flag_orange) {
                        $semaforo = "3";
                    } else if ($diff > $flag_orange && $diff <= $flag_yellow) {
                        $semaforo = "4";
                    } else {
                        $semaforo = "5";
                    }
                    if ($semaforo != $doc_persona->pivot->semaforo) {
                        DB::table('documento_persona')
                            ->where('id', $doc_persona->pivot->id)
                            ->update(['semaforo' => $semaforo]);
                        Log::info('id => '.$doc_persona->pivot->id.' -- semaforo old => ' . $doc_persona->pivot->semaforo . ' -- semaforo new => ' . $semaforo);
                        $actualizados++;
                    }
                }
            }
        }
        Log::info('Documentos actualizados => '.$actualizados);
        Log::info('Termino Proceso Actualización Semaforo Documentos');
    }
}
