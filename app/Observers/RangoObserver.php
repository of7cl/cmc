<?php

namespace App\Observers;

use App\Models\Rango;

class RangoObserver
{
    /**
     * Handle the Rango "created" event.
     *
     * @param  \App\Models\Rango  $rango
     * @return void
     */
    public function created(Rango $rango)
    {
        //
    }

    /**
     * Handle the Rango "updated" event.
     *
     * @param  \App\Models\Rango  $rango
     * @return void
     */
    public function updated(Rango $rango)
    {
        //
    }

    /**
     * Handle the Rango "deleted" event.
     *
     * @param  \App\Models\Rango  $rango
     * @return void
     */
    public function deleted(Rango $rango)
    {
        //
    }

    public function deleting(Rango $rango)
    {
        /* $documento_rango = $rango->documentos;
        return $documento_rango; */
    }

    /**
     * Handle the Rango "restored" event.
     *
     * @param  \App\Models\Rango  $rango
     * @return void
     */
    public function restored(Rango $rango)
    {
        //
    }

    /**
     * Handle the Rango "force deleted" event.
     *
     * @param  \App\Models\Rango  $rango
     * @return void
     */
    public function forceDeleted(Rango $rango)
    {
        //
    }
}
