<?php

namespace App\Console\Commands;

use App\Models\DetalleTrayectoria;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Persona;
use App\Models\Trayectoria;

class ActualizarEstadoTrayectoriaPersonaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updestadotrayectoria:persona';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el estado de la trayectoria de la persona en base fecha actual vs su detalle de trayectoria';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $actualizados = 0;
        Log::info('Inicio Proceso Actualización Estado Trayectoria del Personal');
        $trayectorias = Trayectoria::all();
        foreach ($trayectorias as $trayectoria) {
            //Log::info($trayectoria->persona->ship_id);
            $trayectoria_id = $trayectoria->id;
            $detalle = DetalleTrayectoria::where('trayectoria_id', $trayectoria_id)
                ->where('fc_desde', '<=', now())
                ->where('fc_hasta', '>=', now())
                ->whereNotIn('estado_id', [18,19,20])
                ->first();
            if ($detalle) {
                if($trayectoria->persona->ship_id != $detalle->ship_id)
                {
                    Persona::query()
                        ->where('id', $trayectoria->persona_id)
                        ->update([
                            'ship_id' => $detalle->ship_id                        
                        ]);
                    Log::info('persona_id => '.$trayectoria->persona_id.' -- ship_id old => '.$trayectoria->persona->ship_id.' -- '.$detalle);
                    $actualizados++;
                }
            }
        }
        Log::info('Personas actualizadas => '.$actualizados);
        Log::info('Termino Proceso Actualización Estado Trayectoria del Personal');
    }
}
