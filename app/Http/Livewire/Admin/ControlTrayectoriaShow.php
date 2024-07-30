<?php

namespace App\Http\Livewire\Admin;

use App\Models\DetalleTrayectoria;
use App\Models\Estado;
use App\Models\Persona;
use App\Models\Rango;
use App\Models\Ship;
use Livewire\Component;
use App\Http\Controllers\CarbonController;
use App\Models\Feriado;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;

class ControlTrayectoriaShow extends Component
{
    protected $listeners = ['render' => 'render'];
    public $persona;
    public $rangos;
    public $ships;
    public $estados;

    public $showCabecera = true;
    public $showDetalle = true;
    public $showFormulario = true;

    public $ship_id = '';
    public $estado_id = '';
    public $fc_desde;
    public $fc_hasta;
    public $ajuste = 0;
    public $observaciones;
    public $feriados;

    public $sobre_embarco_debbug;
    public $no_sobre_embarco_debbug;

    public $boAjuste = false;

    public $detallesTrayectoria;

    public function boAjuste()
    {
        if ($this->estado_id == 18 || $this->estado_id == 19 || $this->estado_id == 20)
            $this->boAjuste = true;
        else {
            $this->boAjuste = false;
            $this->ajuste = 0;
        }
    }

    public function mount()
    {
        $this->feriados = Feriado::all()->pluck('fc_feriado', null);
        $this->rangos = Rango::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $this->ships = Ship::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $this->estados = Estado::orderBy('id', 'asc')->get();
        if ($this->persona->trayectoria) {
            $this->detallesTrayectoria = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->orderBy('id', 'desc')->get();
        }
    }

    public function saveDetalle()
    {
        $customMessages = [
            "required" => 'Campo Obligatorio',
            "after" => 'Fecha Hasta debe ser mayor o igual a Fecha Desde.'
        ];

        $rules['ship_id'] = 'required';
        $rules['estado_id'] = 'required';
        $rules['fc_desde'] = 'required';
        $rules['fc_hasta'] = 'required|after_or_equal:fc_desde';

        $this->validate($rules, $customMessages);

        $fecha = new CarbonController();
        $total_dias_calendario = $fecha->diffEntreFechas($this->fc_desde, $this->fc_hasta) + 1;

        if ($this->estado_id == 1 || $this->estado_id == 2 || $this->estado_id == 16) {
            $sobre_embarco = (30 / 75) * $total_dias_calendario;
            if ($sobre_embarco >= 30) {
                $fcDesde = Carbon::parse($this->fc_desde);
                $fc_hasta = $fcDesde->addDays(74);
                $this->generaDetalle($this->estado_id, $this->fc_desde, $fc_hasta);
                $this->fc_desde = $fc_hasta->addDays(1);                
                $i = 0;
                do {
                    $total_dias_calendario = $fecha->diffEntreFechas($this->fc_desde, $this->fc_hasta) + 1;
                    $sobre_embarco = (30 / 75) * $total_dias_calendario;
                    if ($sobre_embarco >= 30) {
                        $fcDesde = Carbon::parse($this->fc_desde);
                        $fc_hasta = $fcDesde->addDays(74);
                        $this->generaDetalle(3, $this->fc_desde, $fc_hasta);
                        $this->fc_desde = $fc_hasta->addDays(1);
                        $i = 1;                        
                    } else {                        
                        $this->generaDetalle(3, $this->fc_desde, $this->fc_hasta);
                        $i = 0;
                    }
                } while ($i > 0);
            } else {
                $fc_desde = $this->fc_desde;
                $fc_hasta = $this->fc_hasta;                
                $this->generaDetalle($this->estado_id, $fc_desde, $fc_hasta);
            }
        }else{
            $this->generaDetalle($this->estado_id, $this->fc_desde, $this->fc_hasta);
        }

        $this->reset('ship_id', 'estado_id', 'fc_desde', 'fc_hasta', 'ajuste', 'observaciones');

        $this->detallesTrayectoria = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->orderBy('id', 'desc')->get();
    }

    public function generaDetalle($estado_id, $fc_desde, $fc_hasta)
    {
        $detalleAnterior = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->orderBy('id', 'desc')->first();

        $fecha = new CarbonController();
        $total_dias_calendario = $fecha->diffEntreFechas($fc_desde, $fc_hasta) + 1;
        $descanso_convenio = 0;
        $saldo_descanso = 0;
        $dias_vacaciones_consumidas = 0;
        $dias_inhabiles_generados = 0;
        $dias_inhabiles_favor = 0;
        $dias_inhabiles_consumidos = 0;
        $ajuste = 0;
        $observaciones = $this->observaciones;
        $saldo_descanso_anterior = 0;
        $sobre_embarco = 0;

        if ($detalleAnterior) {
            $saldo_descanso_anterior = $detalleAnterior->saldo_descanso;
        }

        if ($estado_id == 1) // EMBARCO
        {
            $descanso_convenio = (30 / 75) * $total_dias_calendario;
        } elseif ($estado_id == 2) { // EMBARCO TRAINEE
            $descanso_convenio = (30 / 75) * $total_dias_calendario;
        } elseif ($estado_id == 3) { // EMBARCO 1X1
            $dias_inhabiles_generados = $this->diasInhabilesGeneradosDomingos($fc_desde, $fc_hasta);
            $dias_inhabiles_favor = $total_dias_calendario + $dias_inhabiles_generados;
        } elseif ($estado_id == 4) { // DESCANSO
            $descanso_convenio = $total_dias_calendario * -1;
        } elseif ($estado_id == 5) { // DESCANSO 1X1
            $dias_inhabiles_generados = $this->diasInhabilesGeneradosSabadosDomingos($fc_desde, $fc_hasta);
            $dias_inhabiles_consumidos = $total_dias_calendario - $dias_inhabiles_generados;
        } elseif ($estado_id == 6) { // VAC. LEGALES L-V
            $dias_inhabiles_generados = $this->diasInhabilesGeneradosSabadosDomingos($fc_desde, $fc_hasta);
            $dias_vacaciones_consumidas = $total_dias_calendario - $dias_inhabiles_generados;
        } elseif ($estado_id == 7) { // VAC. LEGALES L-D
            $dias_vacaciones_consumidas = $total_dias_calendario;
        } elseif ($estado_id == 8) { // FERIADO PROGRESIVO
            $dias_inhabiles_generados = $this->diasInhabilesGeneradosSabadosDomingos($fc_desde, $fc_hasta);
            $dias_vacaciones_consumidas = $total_dias_calendario - $dias_inhabiles_generados;
        } elseif ($estado_id == 16) { // CAMBIO DE NAVE
            $descanso_convenio = (30 / 75) * $total_dias_calendario;
        } elseif ($estado_id == 18) { // EXAMEN MÉDICO IST-CMC
            $ajuste = $this->ajuste;
        } elseif ($estado_id == 19) { // EXAMEN MÉDICO IST-CMC
            $ajuste = $this->ajuste;
        } elseif ($estado_id == 20) { // EXAMEN MÉDICO IST-CMC
            $ajuste = $this->ajuste;
        }

        $saldo_descanso = $saldo_descanso_anterior + $descanso_convenio;

        $detalle = DetalleTrayectoria::create([
            'trayectoria_id' => $this->persona->trayectoria->id,
            'ship_id' => $this->ship_id,
            'estado_id' => $estado_id,
            'fc_desde' => $fc_desde,
            'fc_hasta' => $fc_hasta,
            'total_dias_calendario' => $total_dias_calendario,
            'descanso_convenio' => $descanso_convenio,
            'saldo_descanso' => $saldo_descanso,
            'dias_vacaciones_consumidas' => $dias_vacaciones_consumidas,
            'dias_inhabiles_generados' => $dias_inhabiles_generados,
            'dias_inhabiles_favor' => $dias_inhabiles_favor,
            'dias_inhabiles_consumidos' => $dias_inhabiles_consumidos,
            'ajuste' => $ajuste,
            'observaciones' => $observaciones
        ]);
    }

    public function diasInhabilesGeneradosDomingos($fc_ini, $fc_fin)
    {

        $fcIni = Carbon::parse($fc_ini);
        $fcFin = Carbon::parse($fc_fin);

        //de lo contrario, se excluye la fecha de finalización (¿error?)
        $fcFin->modify('+1 day');

        $interval = $fcFin->diff($fcIni);

        // total dias
        //$days = $interval->days;

        // crea un período de fecha iterable (P1D equivale a 1 día)
        $period = new DatePeriod($fcIni, new DateInterval('P1D'), $fcFin);

        $feriados = Feriado::whereBetween('fc_feriado', [$fcIni, $fcFin])->get();

        $days = 0;
        foreach ($period as $dt) {
            $curr = $dt->format('D');
            // obtiene si es Domingo
            if ($curr == 'Sun') {
                $days++;
            }
        }

        foreach ($feriados as $feriado) {
            $fc_feriado = Carbon::parse($feriado->fc_feriado);
            $curr = $fc_feriado->format('D');
            if ($curr <> 'Sun') {
                $days++;
            }
        }

        return $days;
    }

    public function diasInhabilesGeneradosSabadosDomingos($fc_ini, $fc_fin)
    {

        $fcIni = Carbon::parse($fc_ini);
        $fcFin = Carbon::parse($fc_fin);

        //de lo contrario, se excluye la fecha de finalización (¿error?)
        $fcFin->modify('+1 day');

        $interval = $fcFin->diff($fcIni);

        // total dias
        //$days = $interval->days;

        // crea un período de fecha iterable (P1D equivale a 1 día)
        $period = new DatePeriod($fcIni, new DateInterval('P1D'), $fcFin);

        $feriados = Feriado::whereBetween('fc_feriado', [$fcIni, $fcFin])->get();

        $days = 0;
        foreach ($period as $dt) {
            $curr = $dt->format('D');
            // obtiene si es Domingo
            if ($curr == 'Sun' || $curr == 'Sat') {
                $days++;
            }
        }

        foreach ($feriados as $feriado) {
            $fc_feriado = Carbon::parse($feriado->fc_feriado);
            $curr = $fc_feriado->format('D');
            if ($curr <> 'Sun' && $curr <> 'Sat') {
                $days++;
            }
        }

        return $days;
    }

    public function render()
    {
        $persona = $this->persona;
        return view('livewire.admin.control-trayectoria-show', compact('persona'));
    }

    // public $count = 0;

    // public function decrement($cn)
    // {
    //     $this->count -= $cn;
    // }

    // public function increment($cn)
    // {
    //     $this->count += $cn;
    // }

    // public $paises = [
    //     'Chile',
    //     'Perú',
    //     'Colombia'
    // ];

    // public $pais;

    // public function save(){
    //     array_push($this->paises, $this->pais);
    //     $this->reset('pais');
    // }

    // public function delete($key){
    //     unset($this->paises[$key]);
    // }

    // public $active;

    // public function changeActive($pais){
    //     $this->active = $pais;
    // }

    // public function incrementar()
    // {
    //     $this->count++;
    // }

}
