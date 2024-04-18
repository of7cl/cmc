<?php

namespace App\Console\Commands;

use App\Models\Persona;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\PersonaDocumentoController;
use App\Models\Notification;

class VencimientoDocumentosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'documento:vencimiento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera notificaciones por documentos de personal por vencer';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $personaDocumento = new PersonaDocumentoController();
        $personasDocumentos = $personaDocumento->getPersonasDocumentos();
        $documentoVencidos = $personaDocumento->getDocumentosVencidos($personasDocumentos);        
        foreach($documentoVencidos as $documentoVencido){                        
            Notification::create([
                'icon'=> $documentoVencido['icon'],
                'text'=> $documentoVencido['text'],
                'alert' => $documentoVencido['alert'],
                'codigo' => $documentoVencido['codigo']
            ]);
        }                
    }
}
