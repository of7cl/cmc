<?php

namespace App\Http\Livewire\Admin;

use App\Models\DetalleTrayectoria;
use App\Models\Estado;
use App\Models\Persona;
use App\Models\Rango;
use App\Models\Ship;
use Livewire\Component;
use App\Http\Controllers\CarbonController;
use App\Models\AjusteTrayectoria;
use App\Models\Feriado;
use App\Models\Motivo;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;

class ControlTrayectoriaShow extends Component
{
    protected $listeners = ['render' => 'render', 'deleteDetalle'];    
    public $persona;
    public $rangos;
    public $ships;
    public $estados;
    public $motivos;

    public $showCabecera = true;
    public $showDetalle = true;
    public $showFormulario = false;

    public $ship_id = '';
    public $estado_id = '';
    public $motivo_id = '';
    public $plaza_id;
    public $fc_desde;
    public $fc_hasta;
    public $ajuste = 0;
    public $observaciones;
    public $feriados;

    public $edit_ship_id = '';
    public $edit_estado_id = '';
    public $edit_motivo_id = '';
    public $edit_plaza_id = '';
    public $edit_fc_desde = '';
    public $edit_fc_hasta = '';
    public $edit_ajuste = 0;
    public $edit_observaciones = '';    
    public $edit_detalle_id;

    public $bo_embarco_1x1 = false;

    public $sobre_embarco_debbug;
    public $no_sobre_embarco_debbug;

    public $boAjuste = false;
    public $boAjusteEdit = false;

    public $detallesTrayectoria;
    
    public $simple = true;    

    public $now;
    public $difAgregarDetalle = 0;
    public $difAgregarDetalleEdit = 0;
    
    public $fc_fin_sistema_antiguo = '2022/03/31';
    public $sistemaAntiguo = ['fc_desde' => null, 'fc_hasta' => null, 'total_dias' => 0, 'factor' => 0, 'total_dias_acumulados' => 0, 'total_dias_consumidos' => 0, 'saldo_dias_pendientes' => 0, 'saldo_proyectado' => 0];
    public $decretoSupremo = ['fc_desde' => '2022-04-01', 'fc_hasta' => null, 'total_dias' => 0, 'factor' => 0, 'total_dias_acumulados' => 0, 'total_dias_consumidos' => 0, 'saldo_dias_pendientes' => 0, 'saldo_proyectado' => 0];
    public $diasProgresivos = ['fc_desde' => null, 'fc_hasta' => null, 'total_dias' => 0, 'factor' => 0, 'total_dias_acumulados' => 0, 'total_dias_consumidos' => 0, 'saldo_dias_pendientes' => 0, 'saldo_proyectado' => 0];
    public $dias1x1 = ['fc_desde' => null, 'fc_hasta' => null, 'total_dias' => 0, 'factor' => 0, 'total_dias_acumulados' => 0, 'total_dias_consumidos' => 0, 'saldo_dias_pendientes' => 0, 'saldo_proyectado' => 0];
    public $descanso = ['fc_desde' => null, 'fc_hasta' => null, 'total_dias' => 0, 'factor' => 0, 'total_dias_acumulados' => 0, 'total_dias_consumidos' => 0, 'saldo_dias_pendientes' => 0, 'saldo_proyectado' => 0];
    public $ajusteInicial = ['vac_legales_lv' => 0, 'vac_legales_ld' => 0, 'embarco_1x1' => 0, 'ajuste_descanso' => 0, 'feriado_progresivo' => 0];

    public $boAjusteInicial = 0;
    public $vac_legales_lv = 0;
    public $vac_legales_ld = 0;
    public $embarco_1x1 = 0;
    public $ajuste_descanso = 0;
    public $feriado_progresivo = 0;

    public $bo_sobreembarco = false;
    public $bo_sobreembarco_edit = false;
    public $mensaje_validacion = '';

    public $max_id_det;

    public $sort = 'id';
    public $direction = 'desc';

    public $fc_desde_ajuste_inicial;

    public function order($sort)
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }            
        } else {
            $this->sort = $sort;
            $this->direction = 'desc';
        }
        //$detalleTrayectoria->descanso_convenio + $detalleTrayectoria->dias_inhabiles_favor
        //$this->detallesTrayectoria = DetalleTrayectoria::select('*')->selectRaw('(descanso_convenio + dias_inhabiles_favor) as generados')->where('trayectoria_id', $this->persona->trayectoria->id)->orderBy($this->sort, $this->direction)->get();
        $this->getDetallesTrayectoria();
    }

    public function estadoChange()
    {
        if ($this->estado_id == 18 || $this->estado_id == 19 || $this->estado_id == 20){
            $this->boAjuste = true;            
            $this->fc_desde = $this->now; //Carbon::parse($this->now)->setTimezone('America/Santiago')->toDateString();            
            $this->fc_hasta = $this->fc_desde;
        }
        else {            
            $this->boAjuste = false;
            $this->ajuste = 0;
            $this->fc_desde = null;
            $this->fc_hasta = null;
            if ($this->persona->trayectoria) {
                $ultimoDetalleTrayectoria = DetalleTrayectoria::selectRaw('date_add(fc_hasta, interval 1 day) fc_hasta_1')
                                        ->where('trayectoria_id', $this->persona->trayectoria->id)
                                        ->whereNotIn('estado_id', [18,19,20])
                                        ->orderBy('id', 'desc')
                                        ->first();
                if($ultimoDetalleTrayectoria){
                    $this->fc_desde = $ultimoDetalleTrayectoria->fc_hasta_1;
                    $this->fc_hasta = $ultimoDetalleTrayectoria->fc_hasta_1;;
                }
            }                        
        }            

        if($this->estado_id == 3){
            $this->bo_embarco_1x1 = true;
            $this->reset('motivo_id');
        }               
        else{
            $this->bo_embarco_1x1 = false;
            $this->reset('motivo_id');
        }

        $this->setDiferencia();
    }

    public function estadoChangeEdit()
    {
        if ($this->edit_estado_id == 18 || $this->edit_estado_id == 19 || $this->edit_estado_id == 20){
            $this->boAjusteEdit = true;            
            //$this->edit_fc_desde = $this->now; //Carbon::parse($this->now)->setTimezone('America/Santiago')->toDateString();            
            //$this->edit_fc_hasta = $this->edit_fc_desde;
        }
        else {
            $this->boAjusteEdit = false;
            $this->edit_ajuste = 0;
            //$this->edit_fc_desde = null;
            //$this->edit_fc_hasta = null;
            /* if ($this->persona->trayectoria) {
                $ultimoDetalleTrayectoria = DetalleTrayectoria::selectRaw('date_add(fc_hasta, interval 1 day) fc_hasta_1')
                                        ->where('trayectoria_id', $this->persona->trayectoria->id)
                                        ->whereNotIn('estado_id', [18,19,20])
                                        ->orderBy('id', 'desc')
                                        ->first();
                if($ultimoDetalleTrayectoria){
                    $this->edit_fc_desde = $ultimoDetalleTrayectoria->fc_hasta_1;
                    $this->edit_fc_hasta = $ultimoDetalleTrayectoria->fc_hasta_1;;
                }
            }  */                       
        }        

        if($this->edit_estado_id == 3){
            $this->bo_embarco_1x1 = true;
            $this->reset('edit_motivo_id');
        }               
        else{
            $this->bo_embarco_1x1 = false;
            $this->reset('edit_motivo_id');
        }
            

        $this->setDiferenciaEdit();
    }

    public function getDetallesTrayectoria()
    {           
        $this->detallesTrayectoria = DetalleTrayectoria::select('*')
                                        ->selectRaw('(descanso_convenio + dias_inhabiles_favor) as generados, (dias_vacaciones_consumidas + dias_inhabiles_consumidos) as consumidos')
                                        ->where('trayectoria_id', $this->persona->trayectoria->id)
                                        ->orderBy($this->sort, $this->direction)
                                        ->get();
        $this->max_id_det = DetalleTrayectoria::
                                        selectRaw('max(id) as max_id_det')
                                        ->where('trayectoria_id', $this->persona->trayectoria->id)
                                        ->groupBy('trayectoria_id')
                                        ->first();  
                                        
                                        //dd($this->max_id_det->max_id_det);
    }

    public function deleteDetalle($detalleId)
    {                 
        $det = DetalleTrayectoria::where('id', $detalleId)->delete();        
    }

    public function mount()
    {
        $this->feriados = Feriado::all()->pluck('fc_feriado', null);
        $this->rangos = Rango::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $this->ships = Ship::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $this->estados = Estado::orderBy('id', 'asc')->get();
        $this->motivos = Motivo::orderBy('nombre', 'asc')->get();
        $this->plaza_id = $this->persona->rango_id;
        $this->boAjusteInicial();
        if ($this->persona->trayectoria) {
            //$this->detallesTrayectoria = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->orderBy($this->sort, $this->direction)->get();
            //$this->detallesTrayectoria = DetalleTrayectoria::select('*')->selectRaw('(descanso_convenio + dias_inhabiles_favor) as generados')->where('trayectoria_id', $this->persona->trayectoria->id)->orderBy($this->sort, $this->direction)->get();
            $this->getDetallesTrayectoria();
        }        
        $this->now = now()->toDateString(); //Carbon::parse($this->now)->setTimezone('America/Santiago')->toDateString();        
    }

    public function setDiferencia()
    {
        if($this->fc_desde && $this->fc_hasta){
            $this->difAgregarDetalle = $this->diffEntreFechas($this->fc_desde, $this->fc_hasta) + 1;
            if ($this->estado_id == 1 || $this->estado_id == 2 || $this->estado_id == 16) {
                if($this->difAgregarDetalle>75)
                {
                    $this->bo_sobreembarco = true;
                }
                else
                {
                    $this->bo_sobreembarco = false;
                }
            }else{
                $this->bo_sobreembarco = false;
            }
        }
        else{
            $this->difAgregarDetalle = 0;
        }
    }

    public function setDiferenciaEdit()
    {
        if($this->edit_fc_desde && $this->edit_fc_hasta){
            $this->difAgregarDetalleEdit = $this->diffEntreFechas($this->edit_fc_desde, $this->edit_fc_hasta) + 1;
            if ($this->edit_estado_id == 1 || $this->edit_estado_id == 2 || $this->edit_estado_id == 16) {
                if($this->difAgregarDetalleEdit>75)
                {
                    $this->bo_sobreembarco_edit = true;
                }
                else
                {
                    $this->bo_sobreembarco_edit = false;
                }
            }else{
                $this->bo_sobreembarco_edit = false;
            }
        }
        else{
            $this->difAgregarDetalleEdit = 0;
        }
    }

    public function setVista($vista)
    {
        if($vista == 1) 
            $this->simple = true;
        else 
            $this->simple = false;
    }

    public function saveDetalle()
    {
        $customMessages = [
            "required" => 'Campo Obligatorio',
            "after" => 'Fecha Hasta debe ser mayor o igual a Fecha Desde.'
        ];

        if($this->estado_id == 1 || $this->estado_id == 2 || $this->estado_id == 3)
        {
            $rules['ship_id'] = 'required';
        }
        else
        {
            if(!$this->ship_id)
                $this->ship_id = null;
        }

        if($this->estado_id == 3)
            $rules['motivo_id'] = 'required';
        
        $rules['plaza_id'] = 'required';
        $rules['estado_id'] = 'required';
        $rules['fc_desde'] = 'required';
        $rules['fc_hasta'] = 'required|after_or_equal:fc_desde';        

        $this->validate($rules, $customMessages);

        //validaciones de logica
        if($this->getValidacionesLogica() == 1)
        {
            $this->emit('validacion', $this->mensaje_validacion);
        }
        else
        {                  
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
                        if($total_dias_calendario > 0)
                        {
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
                        }else{
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

            $this->close();
            //$this->emit('render');
            $this->emit('detalle', 'Detalle agregado con exito!');

            //$this->detallesTrayectoria = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->orderBy('id', 'desc')->get();
            $this->getDetallesTrayectoria();
        }
    }

    public function getValidacionesLogica()
    {
        $bo_validacion = 0;
        // validación fechas solapadas
        $ultimoDetalle = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)
                                            ->whereNotIn('estado_id', [18,19,20])
                                            ->orderBy('id', 'desc')->first();
        if($ultimoDetalle)
        {
            $fc_desde_ult_det = $ultimoDetalle->fc_desde;
            $fc_hasta_ult_det = $ultimoDetalle->fc_hasta;
            $boFcDesdeMenorIgualFcDesdeUltDet = $this->getFechaEsMenorIgualAOtra($this->fc_desde, $fc_hasta_ult_det);
            //dd($boFcDesdeMenorIgualFcDesdeUltDet.' - '.$this->fc_desde.' - '.$fc_hasta_ult_det);
            if($boFcDesdeMenorIgualFcDesdeUltDet == 1)
            {
                $bo_validacion = 1;
                $this->mensaje_validacion = 'Error en fechas ingresadas!';
            }            
            else
            {
                $bo_validacion = 0;
            }
        }
        else
        {
            $bo_validacion = 0;
        }

        // validacion de sobreembarco

        return $bo_validacion;
    }

    public function getValidacionesLogicaEdit()
    {
        $bo_validacion = 0;
        // validación fechas solapadas
        $ultimoDetalle = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)
                                            ->where('id', '<>', $this->edit_detalle_id)
                                            ->whereNotIn('estado_id', [18,19,20])
                                            ->orderBy('id', 'desc')->first();        
        if($ultimoDetalle)
        {
            $fc_desde_ult_det = $ultimoDetalle->fc_desde;
            $fc_hasta_ult_det = $ultimoDetalle->fc_hasta;
            $boFcDesdeMenorIgualFcDesdeUltDet = $this->getFechaEsMenorIgualAOtra($this->edit_fc_desde, $fc_hasta_ult_det);
            //dd($boFcDesdeMenorIgualFcDesdeUltDet.' - '.$this->fc_desde.' - '.$fc_hasta_ult_det);
            if($boFcDesdeMenorIgualFcDesdeUltDet == 1)
            {
                $bo_validacion = 1;
                $this->mensaje_validacion = 'Error en fechas ingresadas!';
            }            
            else
            {
                $bo_validacion = 0;
            }
        }
        else
        {
            $bo_validacion = 0;
        }

        // validacion de sobreembarco

        return $bo_validacion;
    }

    public function close()
    {
        $this->reset('ship_id', 'estado_id', 'plaza_id', 'fc_desde', 'fc_hasta', 'ajuste', 'observaciones', 'difAgregarDetalle', 'bo_sobreembarco');
        $this->plaza_id = $this->persona->rango_id;
        $this->resetErrorBag();
    }

    public function close_edit()
    {
        $this->reset('edit_ship_id', 'edit_estado_id', 'edit_plaza_id', 'edit_fc_desde', 'edit_fc_hasta', 'edit_ajuste', 'edit_observaciones', 'difAgregarDetalleEdit', 'bo_sobreembarco_edit', 'edit_motivo_id', 'bo_embarco_1x1');
        $this->edit_plaza_id = $this->persona->rango_id;
        $this->resetErrorBag();
    }

    public function closeAjuste()
    {
        $this->reset('vac_legales_lv', 'vac_legales_ld', 'embarco_1x1', 'ajuste_descanso', 'feriado_progresivo', 'fc_desde_ajuste_inicial');        
    }

    public function editAjuste()
    {
        $this->getAjusteTrayectoria();
    }

    public function editDetalle($detalleId)
    {
        //$this->getAjusteTrayectoria();
        $this->edit_detalle_id = $detalleId;
        $detalle = DetalleTrayectoria::where('id', $detalleId)->first();        
        $this->edit_ship_id = $detalle->ship_id;
        $this->edit_estado_id = $detalle->estado_id;
        $this->edit_plaza_id = $detalle->plaza_id;
        $this->edit_fc_desde = $detalle->fc_desde;
        $this->edit_fc_hasta = $detalle->fc_hasta;
        $this->edit_ajuste = $detalle->ajuste;
        $this->edit_observaciones = $detalle->observaciones;
        $this->edit_motivo_id = $detalle->motivo_id;
        if($detalle->estado_id == 3)
            $this->bo_embarco_1x1 = true;
        $this->setDiferenciaEdit();
        //dd($detalle);
    }

    public function updateDetalle()
    {
        $customMessages = [
            "required" => 'Campo Obligatorio',
            "after" => 'Fecha Hasta debe ser mayor o igual a Fecha Desde.',
            "after_or_equal" => 'Fecha Hasta debe ser mayor o igual a Fecha Desde.'
        ];

        if($this->edit_estado_id == 1 || $this->edit_estado_id == 2 || $this->edit_estado_id == 3)
        {
            $rules['edit_ship_id'] = 'required';
        }
        else
        {
            if(!$this->edit_ship_id)
                $this->edit_ship_id = null;
        }

        if($this->edit_estado_id == 3)
            $rules['edit_motivo_id'] = 'required';
        
        $rules['edit_plaza_id'] = 'required';
        $rules['edit_estado_id'] = 'required';
        $rules['edit_fc_desde'] = 'required';
        $rules['edit_fc_hasta'] = 'required|after_or_equal:edit_fc_desde';        
        
        $this->validate($rules, $customMessages);
        
        //validaciones de logica
        if($this->getValidacionesLogicaEdit() == 1)
        {
            $this->emit('validacion', $this->mensaje_validacion);
        }
        else
        {                  
            $fecha = new CarbonController();
            $total_dias_calendario = $fecha->diffEntreFechas($this->edit_fc_desde, $this->edit_fc_hasta) + 1;
            
            if ($this->edit_estado_id == 1 || $this->edit_estado_id == 2 || $this->edit_estado_id == 16) {
                $sobre_embarco = (30 / 75) * $total_dias_calendario;
                if ($sobre_embarco >= 30) {
                    $fcDesde = Carbon::parse($this->edit_fc_desde);
                    $fc_hasta = $fcDesde->addDays(74);
                    $this->detalleEdit($this->edit_estado_id, $this->edit_fc_desde, $fc_hasta);
                    $this->edit_fc_desde = $fc_hasta->addDays(1);                
                    $i = 0;
                    do {
                        $total_dias_calendario = $fecha->diffEntreFechas($this->edit_fc_desde, $this->edit_fc_hasta) + 1;
                        if($total_dias_calendario > 0)
                        {
                            $sobre_embarco = (30 / 75) * $total_dias_calendario;
                            if ($sobre_embarco >= 30) {
                                $fcDesde = Carbon::parse($this->edit_fc_desde);
                                $fc_hasta = $fcDesde->addDays(74);
                                $this->generaDetalleEdit(3, $this->edit_fc_desde, $fc_hasta);
                                $this->edit_fc_desde = $fc_hasta->addDays(1);
                                $i = 1;                        
                            } else {                        
                                $this->generaDetalleEdit(3, $this->edit_fc_desde, $this->edit_fc_hasta);
                                $i = 0;
                            }
                        }else{
                            $i = 0;
                        }
                    } while ($i > 0);
                } else {
                    $fc_desde = $this->edit_fc_desde;
                    $fc_hasta = $this->edit_fc_hasta;                
                    $this->generaDetalleEdit($this->edit_estado_id, $fc_desde, $fc_hasta);
                }
            }else{
                //$this->generaDetalleEdit($this->edit_estado_id, $this->edit_fc_desde, $this->edit_fc_hasta);
                $this->detalleEdit($this->edit_estado_id, $this->edit_fc_desde, $this->edit_fc_hasta);
            }

            $this->close_edit();
            //$this->emit('render');
            $this->emit('updateDetalle', 'Detalle editado con exito!');

            //$this->detallesTrayectoria = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->orderBy('id', 'desc')->get();
            $this->getDetallesTrayectoria();
        }
    }

    public function updateAjuste()
    {
        $boExisteAjuste = AjusteTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->count();        
        if($boExisteAjuste == 0)
        {            
            $ajuste = AjusteTrayectoria::create([
                'trayectoria_id' => $this->persona->trayectoria->id,                    
                'vac_legales_lv' => $this->vac_legales_lv,
                'vac_legales_ld' => $this->vac_legales_ld,
                'embarco_1x1' => $this->embarco_1x1,
                'ajuste_descanso' => $this->ajuste_descanso,
                'feriado_progresivo' => $this->feriado_progresivo,
                'fc_desde' => $this->fc_desde_ajuste_inicial
            ]);            
        }
        else{            
            AjusteTrayectoria::query()
            ->where('trayectoria_id', $this->persona->trayectoria->id)
            ->update([
                'vac_legales_lv' => $this->vac_legales_lv,
                'vac_legales_ld' => $this->vac_legales_ld,
                'embarco_1x1' => $this->embarco_1x1,
                'ajuste_descanso' => $this->ajuste_descanso,
                'feriado_progresivo' => $this->feriado_progresivo,
                'fc_desde' => $this->fc_desde_ajuste_inicial
            ]);            
        }   
        if($this->vac_legales_lv != 0 || $this->vac_legales_ld != 0 || $this->embarco_1x1 != 0 || $this->ajuste_descanso != 0 || $this->feriado_progresivo != 0)
            $this->boAjusteInicial = 1;     
        $this->closeAjuste();
        $this->emit('render');
        $this->emit('ajuste', 'Ajuste editado con exito!');
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

        if($this->motivo_id == "")
            $motivo_id = null;
        else
            $motivo_id = $this->motivo_id;

        $detalle = DetalleTrayectoria::create([
            'trayectoria_id' => $this->persona->trayectoria->id,
            'ship_id' => $this->ship_id,
            'plaza_id' => $this->plaza_id,
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
            'motivo_id' => $motivo_id,
            'observaciones' => $observaciones
        ]);

        if($estado_id != 18 && $estado_id != 19 && $estado_id != 20)
            $this->upd_ship_persona($this->ship_id, $fc_desde, $fc_hasta);
        
    }

    public function detalleEdit($estado_id, $fc_desde, $fc_hasta)
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
        $observaciones = $this->edit_observaciones;
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
            $ajuste = $this->edit_ajuste;
        } elseif ($estado_id == 19) { // EXAMEN MÉDICO IST-CMC
            $ajuste = $this->edit_ajuste;
        } elseif ($estado_id == 20) { // EXAMEN MÉDICO IST-CMC
            $ajuste = $this->edit_ajuste;
        }

        $saldo_descanso = $saldo_descanso_anterior + $descanso_convenio;

        if($this->edit_motivo_id == "")
            $motivo_id = null;
        else
            $motivo_id = $this->edit_motivo_id;

        DetalleTrayectoria::query()
        ->where('id', $this->edit_detalle_id)
        ->update([
            //'trayectoria_id' => $this->persona->trayectoria->id,
            'ship_id' => $this->edit_ship_id,
            'plaza_id' => $this->edit_plaza_id,
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
            'motivo_id' => $motivo_id,
            'observaciones' => $observaciones
        ]);

        if($estado_id != 18 && $estado_id != 19 && $estado_id != 20)
            $this->upd_ship_persona($this->edit_ship_id, $fc_desde, $fc_hasta);
        
    }

    public function generaDetalleEdit($estado_id, $fc_desde, $fc_hasta)
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
        $observaciones = $this->edit_observaciones;
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
            $ajuste = $this->edit_ajuste;
        } elseif ($estado_id == 19) { // EXAMEN MÉDICO IST-CMC
            $ajuste = $this->edit_ajuste;
        } elseif ($estado_id == 20) { // EXAMEN MÉDICO IST-CMC
            $ajuste = $this->edit_ajuste;
        }

        $saldo_descanso = $saldo_descanso_anterior + $descanso_convenio;

        if($this->edit_motivo_id == "")
            $motivo_id = null;
        else
            $motivo_id = $this->edit_motivo_id;

        $detalle = DetalleTrayectoria::create([
            'trayectoria_id' => $this->persona->trayectoria->id,
            'ship_id' => $this->edit_ship_id,
            'plaza_id' => $this->edit_plaza_id,
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
            'motivo_id' => $motivo_id,
            'observaciones' => $observaciones
        ]);

        if($estado_id != 18 && $estado_id != 19 && $estado_id != 20)
            $this->upd_ship_persona($this->edit_ship_id, $fc_desde, $fc_hasta);
        
    }

    public function upd_ship_persona($ship_id, $fc_desde, $fc_hasta)
    {
        $fecha = new CarbonController();
        $boMenorIgualFcDesde = $fecha->getFechaEsMenorIgualHoy($fc_desde);
        $boMayorIgualFcHasta = $fecha->getFechaEsMayorIgualHoy($fc_hasta);
        if($boMenorIgualFcDesde == 1 && $boMayorIgualFcHasta) {            
            Persona::query()
            ->where('id', $this->persona->id)
            ->update([
                'ship_id' => $ship_id
            ]); 
        }
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

    public function diffEntreFechas($fc_ini, $fc_fin)
    {
        $fcIni = Carbon::parse($fc_ini);
        $fcFin = Carbon::parse($fc_fin);

        $diff = $fcIni->diffInDays($fcFin, false);
        return $diff;
    }

    public function render()
    {
        $persona = $this->persona;
        $this->getCabecera();   
        $this->getDetallesTrayectoria();
        return view('livewire.admin.control-trayectoria-show', compact('persona'));
    }

    public function boAjusteInicial()
    {        
        $AjusteInicial = AjusteTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->first();
        if($AjusteInicial)
            if($AjusteInicial->vac_legales_lv != 0 || $AjusteInicial->vac_legales_ld != 0 || $AjusteInicial->embarco_1x1 != 0 || $AjusteInicial->ajuste_descanso != 0 || $AjusteInicial->feriado_progresivo != 0)
                $this->boAjusteInicial = 1;
    }

    public function getAjusteTrayectoria()
    {
        $ajusteTrayectoria = AjusteTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->first();
        if($ajusteTrayectoria){
            $this->vac_legales_lv = $ajusteTrayectoria->vac_legales_lv;
            $this->vac_legales_ld = $ajusteTrayectoria->vac_legales_ld;
            $this->embarco_1x1 = $ajusteTrayectoria->embarco_1x1;
            $this->ajuste_descanso = $ajusteTrayectoria->ajuste_descanso;
            $this->feriado_progresivo = $ajusteTrayectoria->feriado_progresivo;
            $this->fc_desde_ajuste_inicial = $ajusteTrayectoria->fc_desde;
        }
    }

    public function getCabecera()
    {        
        $this->getAjusteInicial();
        $boDetalleTrayectoria = $this->getBoDetalleTrayectoria();
        $this->getSistemaAntiguo($boDetalleTrayectoria);
        $this->getDecretoSupremo($boDetalleTrayectoria);
        $this->getDiasProgresivos($boDetalleTrayectoria);
        $this->getDias1x1();
        $this->getDescanso();
        /* if($this->getBoDetalleTrayectoria()>0)
        {
            $this->getSistemaAntiguo();
            $this->getDecretoSupremo();
            $this->getDiasProgresivos();
            $this->getDias1x1();
            $this->getDescanso();
        }
        else{
            $this->decretoSupremo['fc_desde'] = '';
            $this->decretoSupremo['fc_hasta'] = '';
        } */
    }

    public function getBoDetalleTrayectoria()
    {
        return DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->count();        
    }

    public function getSistemaAntiguo($boDetalleTrayectoria)
    {
        $boSistemaAntiguo = $this->boSistemaAntiguo();                
        if($boSistemaAntiguo == 1){        
            $this->sistemaAntiguo['fc_desde'] = $this->persona->fc_ingreso;
            $this->sistemaAntiguo['fc_hasta'] = $this->fc_fin_sistema_antiguo;
            $this->sistemaAntiguo['total_dias'] = $this->diffEntreFechas($this->sistemaAntiguo['fc_desde'], $this->sistemaAntiguo['fc_hasta']) + 1;
            $this->sistemaAntiguo['factor'] = 15/365;
            $this->sistemaAntiguo['total_dias_acumulados'] = $this->sistemaAntiguo['total_dias'] * $this->sistemaAntiguo['factor'];
            $this->sistemaAntiguo['saldo_dias_pendientes'] = $this->sistemaAntiguo['total_dias_acumulados'];

            if($boDetalleTrayectoria > 0)
            {
                $vac_legales_lv = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 6)->get();
                $sum_tdc = 0;
                foreach($vac_legales_lv as $vllv)
                {
                    $boFcDesdeMenorHoy = $this->getFechaEsMenorHoy($vllv->fc_desde);
                    $boFcHastaMenorHoy = $this->getFechaEsMenorHoy($vllv->fc_hasta);
                    if($boFcDesdeMenorHoy == 1 && $boFcHastaMenorHoy == 1) $sum_tdc = $sum_tdc + $vllv->dias_vacaciones_consumidas;
                    $boFcDesdeMenorIgualHoy = $this->getFechaEsMenorIgualHoy($vllv->fc_desde);
                    $boFcHastaMayorHoy = $this->getFechaEsMayorHoy($vllv->fc_hasta);                        
                    if($boFcDesdeMenorIgualHoy == 1 && $boFcHastaMayorHoy == 1) {
                        try {
                            $diff = $this->diffEntreFechas($vllv->fc_desde, $this->now) / $this->diffEntreFechas($vllv->fc_desde, $this->fc_hasta) * $vllv->dias_vacaciones_consumidas;
                        } catch(\Throwable $th)
                        {
                            $diff = 0;
                        }                    
                        $sum_tdc = $sum_tdc + $diff;        
                    }                        
                }        
                $this->sistemaAntiguo['total_dias_consumidos'] = $sum_tdc + $this->ajusteInicial['vac_legales_lv'];
                $this->sistemaAntiguo['saldo_dias_pendientes'] = $this->sistemaAntiguo['total_dias_acumulados'] - $this->sistemaAntiguo['total_dias_consumidos'];     

                $va_le_lv = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 6)->sum('dias_vacaciones_consumidas');
                $this->sistemaAntiguo['saldo_proyectado'] = ($this->sistemaAntiguo['total_dias_acumulados'] - $va_le_lv) - $this->ajusteInicial['vac_legales_lv']; 
            }
        }else{
            $this->sistemaAntiguo = ['fc_desde' => '', 'fc_hasta' => '', 'total_dias' => 0, 'factor' => 0, 'total_dias_acumulados' => 0, 'total_dias_consumidos' => 0, 'saldo_dias_pendientes' => 0, 'saldo_proyectado' => 0];
        }   
    }

    public function getDecretoSupremo($boDetalleTrayectoria)
    {
        if($this->getFechaEsMayorAOtra($this->persona->fc_ingreso, $this->fc_fin_sistema_antiguo) == 1)
        {
            $this->decretoSupremo['fc_desde'] = $this->persona->fc_ingreso;   
        }
        $this->decretoSupremo['fc_hasta'] = Carbon::parse($this->now)->setTimezone('America/Santiago')->toDateString();
        $this->decretoSupremo['total_dias'] = $this->diffEntreFechas($this->decretoSupremo['fc_desde'], $this->decretoSupremo['fc_hasta']) + 1;
        $this->decretoSupremo['factor'] = 0.0833;

        $this->decretoSupremo['total_dias_acumulados'] = ($this->decretoSupremo['total_dias'] * $this->decretoSupremo['factor']);
        $this->decretoSupremo['saldo_dias_pendientes'] = $this->decretoSupremo['total_dias_acumulados'];
        
        if($boDetalleTrayectoria > 0)
        {
            $aju_vac_ld = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 19)->get();
            $sum_avld = 0;
            foreach($aju_vac_ld as $avld)
            {   
                $sum_avld = $sum_avld + $avld->ajuste;
            }            
            $this->decretoSupremo['total_dias_acumulados'] =  $this->decretoSupremo['total_dias_acumulados'] + $sum_avld;

            $vac_legales_ld = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 7)->get();
            $sum_tdc = 0;
            foreach($vac_legales_ld as $vlld)
            {
                $boFcDesdeMenorHoy = $this->getFechaEsMenorHoy($vlld->fc_desde);
                $boFcHastaMenorHoy = $this->getFechaEsMenorHoy($vlld->fc_hasta);
                if($boFcDesdeMenorHoy == 1 && $boFcHastaMenorHoy == 1) $sum_tdc = $sum_tdc + $vlld->dias_vacaciones_consumidas;
                $boFcDesdeMenorIgualHoy = $this->getFechaEsMenorIgualHoy($vlld->fc_desde);
                $boFcHastaMayorHoy = $this->getFechaEsMayorHoy($vlld->fc_hasta);                        
                if($boFcDesdeMenorIgualHoy == 1 && $boFcHastaMayorHoy == 1) {    
                    try {
                        $diff = $this->diffEntreFechas($vlld->fc_desde, $this->now) / $this->diffEntreFechas($vlld->fc_desde, $this->fc_hasta) * $vlld->dias_vacaciones_consumidas;                
                    } catch(\Throwable $th)
                    {
                        $diff = 0;
                    }                            
                    $sum_tdc = $sum_tdc + $diff;        
                }                        
            } 
            $this->decretoSupremo['total_dias_consumidos'] = $sum_tdc + $this->ajusteInicial['vac_legales_ld'];
            $this->decretoSupremo['saldo_dias_pendientes'] = $this->decretoSupremo['total_dias_acumulados'] - $this->decretoSupremo['total_dias_consumidos'];
            
            $max_fc_hasta = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->max('fc_hasta');
            $diff = $this->diffEntreFechas($this->decretoSupremo['fc_desde'], $max_fc_hasta);        
            $sum_a_vac_ld = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 19)->sum('ajuste');
            $sum_d_vac_cons = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 7)->sum('dias_vacaciones_consumidas');                
            $this->decretoSupremo['saldo_proyectado'] = (($diff * $this->decretoSupremo['factor']) + $sum_a_vac_ld - $sum_d_vac_cons) - $this->ajusteInicial['vac_legales_ld'];
        }
    }

    public function getDiasProgresivos($boDetalleTrayectoria)
    {
        $ajusteTrayectoria = AjusteTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->first();
        if($ajusteTrayectoria)            
            $fc_desde_ajuste_inicial = $ajusteTrayectoria->fc_desde;
        else
            $fc_desde_ajuste_inicial = null;        
        $this->diasProgresivos['fc_desde'] = $fc_desde_ajuste_inicial; 
        $this->diasProgresivos['fc_hasta'] = Carbon::parse($this->now)->setTimezone('America/Santiago')->toDateString();
        if($fc_desde_ajuste_inicial)
            $this->diasProgresivos['total_dias'] = ($this->diffEntreFechas($this->diasProgresivos['fc_desde'], $this->diasProgresivos['fc_hasta']) + 1) - 1095;
        else
            $this->diasProgresivos['total_dias'] = 0;
        $vl_proyectado = 0;
    
        if($boDetalleTrayectoria > 0)
        {
            $max_fc_hasta = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->max('fc_hasta');            
            $cn_pro = ($this->diffEntreFechas($this->diasProgresivos['fc_desde'], $max_fc_hasta) + 1) - 1095;            
            if($this->diasProgresivos['total_dias'] <= 0){ 
                $this->diasProgresivos['factor'] = 0;
                $this->diasProgresivos['total_dias_acumulados'] = 0;
                $vl_proyectado = 0;
            }elseif($this->diasProgresivos['total_dias'] <= 1095){
                $this->diasProgresivos['factor'] = 1;
                $this->diasProgresivos['total_dias_acumulados'] = ( $this->diasProgresivos['total_dias'] / ( 365.25 / $this->diasProgresivos['factor'] ) ) + 1;
                try {
                    $vl_proyectado = $cn_pro / (365.25/$this->diasProgresivos['factor']);
                } catch(\Throwable $th)
                {
                    $vl_proyectado = 0;
                }             
            }elseif($this->diasProgresivos['total_dias'] <= 2190){
                $this->diasProgresivos['factor'] = 2;        
                $this->diasProgresivos['total_dias_acumulados'] = 3 + (($this->diasProgresivos['total_dias'] - 731)/(365.25 / $this->diasProgresivos['factor']));
                try {
                    $vl_proyectado = 3 + ($cn_pro - 731) / (365.25/$this->diasProgresivos['factor']);
                } catch(\Throwable $th)
                {
                    $vl_proyectado = 0;
                }            
            }elseif($this->diasProgresivos['total_dias'] <= 3285){
                $this->diasProgresivos['factor'] = 3;
                $this->diasProgresivos['total_dias_acumulados'] = 9 + (($this->diasProgresivos['total_dias'] - 1827)/(365.25 / $this->diasProgresivos['factor']));
                try {
                    $vl_proyectado = 9 + ($cn_pro - 1827) / (365.25/$this->diasProgresivos['factor']);
                } catch(\Throwable $th)
                {
                    $vl_proyectado = 0;
                }                        
            }elseif($this->diasProgresivos['total_dias'] <= 4380){
                $this->diasProgresivos['factor'] = 4;
                $this->diasProgresivos['total_dias_acumulados'] = 18 + (($this->diasProgresivos['total_dias'] - 2924)/(365.25 / $this->diasProgresivos['factor']));
                try {
                    $vl_proyectado = 18 + ($cn_pro - 2924) / (365.25/$this->diasProgresivos['factor']);
                } catch(\Throwable $th)
                {
                    $vl_proyectado = 0;
                }                                    
            }elseif($this->diasProgresivos['total_dias'] <= 5475){
                $this->diasProgresivos['factor'] = 5;
                $this->diasProgresivos['total_dias_acumulados'] = 30 + (($this->diasProgresivos['total_dias'] - 4020)/(365.25 / $this->diasProgresivos['factor']));
                try {
                    $vl_proyectado = 30 + ($cn_pro - 4020) / (365.25/$this->diasProgresivos['factor']);
                } catch(\Throwable $th)
                {
                    $vl_proyectado = 0;
                }             
            }elseif($this->diasProgresivos['total_dias'] <= 6570){
                $this->diasProgresivos['factor'] = 6;
                $this->diasProgresivos['total_dias_acumulados'] = 45 + (($this->diasProgresivos['total_dias'] - 5117)/(365.25 / $this->diasProgresivos['factor']));
                try {
                    $vl_proyectado = 45 + ($cn_pro - 5117) / (365.25/$this->diasProgresivos['factor']);
                } catch(\Throwable $th)
                {
                    $vl_proyectado = 0;
                }            
            }else $this->diasProgresivos['total_dias_acumulados'] = 0;

            $fer_pro = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 8)->get();
            $sum_tdc = 0;
            foreach($fer_pro as $ferpro)
            {
                $boFcDesdeMenorHoy = $this->getFechaEsMenorHoy($ferpro->fc_desde);
                $boFcHastaMenorHoy = $this->getFechaEsMenorHoy($ferpro->fc_hasta);     
                if($boFcDesdeMenorHoy == 1 && $boFcHastaMenorHoy == 1) $sum_tdc = $sum_tdc + $ferpro->dias_vacaciones_consumidas;
                $boFcDesdeMenorIgualHoy = $this->getFechaEsMenorIgualHoy($ferpro->fc_desde);
                $boFcHastaMayorHoy = $this->getFechaEsMayorHoy($ferpro->fc_hasta);                        
                if($boFcDesdeMenorIgualHoy == 1 && $boFcHastaMayorHoy == 1) {   
                    try {
                        $diff = $this->diffEntreFechas($ferpro->fc_desde, $this->now) / $this->diffEntreFechas($ferpro->fc_desde, $this->fc_hasta) * $ferpro->dias_vacaciones_consumidas;                
                    } catch(\Throwable $th)
                    {
                        $diff = 0;
                    }                             
                    $sum_tdc = $sum_tdc + $diff;        
                }                        
            }
            $this->diasProgresivos['total_dias_consumidos'] = $sum_tdc + $this->ajusteInicial['feriado_progresivo'];
            $this->diasProgresivos['saldo_dias_pendientes'] = $this->diasProgresivos['total_dias_acumulados'] - $this->diasProgresivos['total_dias_consumidos'];
            
            $sum_fer_pro = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 8)->where('fc_hasta', '<=', $max_fc_hasta)->sum('dias_vacaciones_consumidas');
            $this->diasProgresivos['saldo_proyectado'] = $vl_proyectado - ($sum_fer_pro + $this->ajusteInicial['feriado_progresivo']);  
        }      
    }

    public function getDias1x1()
    {
        $d_inh_fav_1x1 = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 3)->get();
        $sum_tdc = 0;
        foreach($d_inh_fav_1x1 as $dif1)
        {
            $boFcDesdeMenorHoy = $this->getFechaEsMenorHoy($dif1->fc_desde);
            $boFcHastaMenorHoy = $this->getFechaEsMenorHoy($dif1->fc_hasta);
            if($boFcDesdeMenorHoy == 1 && $boFcHastaMenorHoy == 1) $sum_tdc = $sum_tdc + $dif1->dias_inhabiles_favor;
            $boFcDesdeMenorIgualHoy = $this->getFechaEsMenorIgualHoy($dif1->fc_desde);
            $boFcHastaMayorHoy = $this->getFechaEsMayorHoy($dif1->fc_hasta);                        
            if($boFcDesdeMenorIgualHoy == 1 && $boFcHastaMayorHoy == 1) {  
                try {
                    $diff = $this->diffEntreFechas($dif1->fc_desde, $this->now) / $this->diffEntreFechas($dif1->fc_desde, $this->fc_hasta) * $dif1->dias_inhabiles_favor;                  
                } catch(\Throwable $th)
                {
                    $diff = 0;
                }                               
                $sum_tdc = $sum_tdc + $diff;
            }                        
        } 

        $aju_1x1 = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 18)->get();
        foreach($aju_1x1 as $a11)
        {
            if($a11->ajuste > 0)
            {
                $sum_tdc = $sum_tdc + $a11->ajuste;
            }
        }
        $this->dias1x1['total_dias_acumulados'] = $sum_tdc + $this->ajusteInicial['embarco_1x1'];

        $d_inh_con_des_1x1 = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 5)->get();
        $sum_tdc = 0;
        foreach($d_inh_con_des_1x1 as $dicd1)
        {
            $boFcDesdeMenorHoy = $this->getFechaEsMenorHoy($dicd1->fc_desde);
            $boFcHastaMenorHoy = $this->getFechaEsMenorHoy($dicd1->fc_hasta);
            if($boFcDesdeMenorHoy == 1 && $boFcHastaMenorHoy == 1) $sum_tdc = $sum_tdc + $dicd1->dias_inhabiles_consumidos;
            $boFcDesdeMenorIgualHoy = $this->getFechaEsMenorIgualHoy($dicd1->fc_desde);
            $boFcHastaMayorHoy = $this->getFechaEsMayorHoy($dicd1->fc_hasta);                        
            if($boFcDesdeMenorIgualHoy == 1 && $boFcHastaMayorHoy == 1) {        
                try {
                    $diff = $this->diffEntreFechas($dicd1->fc_desde, $this->now) / $this->diffEntreFechas($dicd1->fc_desde, $this->fc_hasta) * $dicd1->dias_inhabiles_consumidos;                      
                } catch(\Throwable $th)
                {
                    $diff = 0;
                }                        
                $sum_tdc = $sum_tdc + $diff;
            }                        
        } 

        $aju_1x1 = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 18)->get();
        $sum_aju = 0;
        foreach($aju_1x1 as $a11)
        {
            if($a11->ajuste < 0)
            {
                $sum_aju = $sum_aju + $a11->ajuste;
            }
        }
        $sum_tdc = $sum_tdc + ($sum_aju * -1);
        $this->dias1x1['total_dias_consumidos'] = $sum_tdc;
        $this->dias1x1['saldo_dias_pendientes'] = $this->dias1x1['total_dias_acumulados'] - $this->dias1x1['total_dias_consumidos'];     

        $d_inh_fav = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 3)->get();
        $sum_dinhfav = 0;
        foreach($d_inh_fav as $dinhfav)
        {
            $sum_dinhfav = $sum_dinhfav + $dinhfav->dias_inhabiles_favor;                     
        }

        $d_inh_cons = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 5)->get();
        $sum_dinhcons = 0;
        foreach($d_inh_cons as $dinhcons)
        {
            $sum_dinhcons = $sum_dinhcons + $dinhcons->dias_inhabiles_consumidos;                     
        }

        $aju_1x1 = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 18)->get();
        $sum_aju_1x1 = 0;
        foreach($aju_1x1 as $a1x1)
        {            
            $sum_aju_1x1 = $sum_aju_1x1 + $a1x1->ajuste;            
        }

        $this->dias1x1['saldo_proyectado'] = $sum_dinhfav - $sum_dinhcons + $sum_aju_1x1 + $this->ajusteInicial['embarco_1x1'];
    }

    public function getDescanso()
    {        
        $d_con = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('descanso_convenio','>', 0)->get();    
        $sum_tda = 0;
        foreach($d_con as $dcon)
        {
            $boFcDesdeMenorHoy = $this->getFechaEsMenorHoy($dcon->fc_desde);
            $boFcHastaMenorHoy = $this->getFechaEsMenorHoy($dcon->fc_hasta);
            if($boFcDesdeMenorHoy == 1 && $boFcHastaMenorHoy == 1) $sum_tda = $sum_tda + $dcon->descanso_convenio;
            $boFcDesdeMenorIgualHoy = $this->getFechaEsMenorIgualHoy($dcon->fc_desde);
            $boFcHastaMayorHoy = $this->getFechaEsMayorHoy($dcon->fc_hasta);                        
            if($boFcDesdeMenorIgualHoy == 1 && $boFcHastaMayorHoy == 1) {                
                try {
                    $diff = $this->diffEntreFechas($dcon->fc_desde, $this->now) / $this->diffEntreFechas($dcon->fc_desde, $this->fc_hasta) * $dcon->descanso_convenio;                      
                } catch(\Throwable $th)
                {
                    $diff = 0;
                }
                $sum_tda = $sum_tda + $diff;
            }                        
        }

        $aju_des = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 20)->where('ajuste', '>', 0)->get();
        $sum_aju = 0;
        foreach($aju_des as $ades)
        {            
            $sum_aju = $sum_aju + $ades->ajuste;            
        }
        $this->descanso['total_dias_acumulados'] = $sum_tda + $sum_aju + $this->ajusteInicial['ajuste_descanso'];

        $d_con = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('descanso_convenio','<', 0)->get();    
        $sum_tda = 0;
        foreach($d_con as $dcon)
        {
            $boFcDesdeMenorHoy = $this->getFechaEsMenorHoy($dcon->fc_desde);
            $boFcHastaMenorHoy = $this->getFechaEsMenorHoy($dcon->fc_hasta);
            if($boFcDesdeMenorHoy == 1 && $boFcHastaMenorHoy == 1) $sum_tda = $sum_tda + $dcon->descanso_convenio;
            $boFcDesdeMenorIgualHoy = $this->getFechaEsMenorIgualHoy($dcon->fc_desde);
            $boFcHastaMayorHoy = $this->getFechaEsMayorHoy($dcon->fc_hasta);                        
            if($boFcDesdeMenorIgualHoy == 1 && $boFcHastaMayorHoy == 1) {                
                try {
                    $diff = $this->diffEntreFechas($dcon->fc_desde, $this->now) / $this->diffEntreFechas($dcon->fc_desde, $this->fc_hasta) * $dcon->descanso_convenio;                     
                } catch(\Throwable $th)
                {
                    $diff = 0;
                }                
                $sum_tda = $sum_tda + $diff;
            }                        
        }

        $aju_des = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 20)->where('ajuste', '<', 0)->get();
        $sum_aju = 0;
        foreach($aju_des as $ades)
        {            
            $sum_aju = $sum_aju + $ades->ajuste;            
        }
        $this->descanso['total_dias_consumidos'] = ($sum_tda + $sum_aju) * -1;
        $this->descanso['saldo_dias_pendientes'] = $this->descanso['total_dias_acumulados'] - $this->descanso['total_dias_consumidos'];

        $d_conv = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->whereIn('estado_id', array(1, 4))->get();
        $sum_dconv = 0;
        foreach($d_conv as $dconv)
        {
            $sum_dconv = $sum_dconv + $dconv->descanso_convenio;                     
        }

        $aju_des = DetalleTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->where('estado_id', 20)->get();
        $sum_aju = 0;
        foreach($aju_des as $ades)
        {            
            $sum_aju = $sum_aju + $ades->ajuste;            
        }

        $this->descanso['saldo_proyectado'] = $sum_dconv + $sum_aju + $this->ajusteInicial['ajuste_descanso'];
    }

    public function getAjusteInicial()
    {
        $ajuste_inicial = AjusteTrayectoria::where('trayectoria_id', $this->persona->trayectoria->id)->first();
        if($ajuste_inicial)
        {
            $this->ajusteInicial = [
                'vac_legales_lv' => $ajuste_inicial->vac_legales_lv, 
                'vac_legales_ld' => $ajuste_inicial->vac_legales_ld, 
                'embarco_1x1' => $ajuste_inicial->embarco_1x1, 
                'ajuste_descanso' => $ajuste_inicial->ajuste_descanso, 
                'feriado_progresivo' => $ajuste_inicial->feriado_progresivo
            ];
        }
    }

    public function boSistemaAntiguo()
    {
        $boSistemaAntiguo = 0;
        $fcIngreso = Carbon::parse($this->persona->fc_ingreso);
        $fcFinSistemaAntiguo = Carbon::parse($this->fc_fin_sistema_antiguo);
        $boSistemaAntiguo = $fcIngreso->isBefore($fcFinSistemaAntiguo);        
        return $boSistemaAntiguo; // 1=> Pertenece al sistema antiguo 2=> No pertenece al sistema antiguo
    }   
    
    public function getFechaEsMenorHoy($fecha)
    {
        $fc = Carbon::parse($fecha);        
        $hoy = Carbon::parse($this->now);
        return $fc->lessThan($hoy);        
    }

    public function getFechaEsMenorIgualHoy($fecha)
    {
        $fc = Carbon::parse($fecha);
        $hoy = Carbon::parse($this->now);
        return $fc->lessThanOrEqualTo($hoy);        
    }

    public function getFechaEsMayorHoy($fecha)
    {
        $fc = Carbon::parse($fecha);
        $hoy = Carbon::parse($this->now);
        return $fc->greaterThan($hoy);        
    }
    
    public function getFechaEsMayorAOtra($fecha_ini, $fecha_fin)
    {
        $fc_ini = Carbon::parse($fecha_ini);
        $fc_fin = Carbon::parse($fecha_fin);        
        return $fc_ini->greaterThan($fc_fin);        
    }

    public function getFechaEsMayorIgualAOtra($fecha_ini, $fecha_fin)
    {
        $fc_ini = Carbon::parse($fecha_ini);
        $fc_fin = Carbon::parse($fecha_fin);        
        return $fc_ini->greaterThanOrEqualTo($fc_fin);        
    }

    public function getFechaEsMenorAOtra($fecha_ini, $fecha_fin)
    {
        $fc_ini = Carbon::parse($fecha_ini);
        $fc_fin = Carbon::parse($fecha_fin);        
        return $fc_ini->lessThan($fc_fin);        
    }

    public function getFechaEsMenorIgualAOtra($fecha_ini, $fecha_fin)
    {
        $fc_ini = Carbon::parse($fecha_ini);
        $fc_fin = Carbon::parse($fecha_fin);        
        return $fc_ini->lessThanOrEqualTo($fc_fin);        
    }

    /*
    greater Than Or Equal To    => mayor que o igual a
    greater Than                => mayor que
    less Than                   => menor que
    less Than Or Equal To       => menor que o igual a
    */
}
