<?php

namespace App\Http\Livewire\Admin;

use App\Models\DetalleTrayectoria;
use App\Models\EmbarcoProgramacion;
use App\Models\Persona;
use App\Models\Rango;
use App\Models\Ship;
use Carbon\Carbon;
use Livewire\Component;

class ProgramacionEmbarcos extends Component
{
    protected $listeners = ['render' => 'render'];
    public $cn_mostrar = 12;
    public $rangos;
    public $ships;
    public $personas;

    public $shipFilter = '';
    public $rangoFilter = [3];
    public $nameFilter = '';

    public $nr_semanas = 1;
    public $plaza_id = '';
    public $ship_id = '';
    public $id_estado = '';
    public $persona_id;
    public $nr_semana;        
    public $nr_mes;
    public $nr_anio;
    public $str_color = [
        'sin color', 
        '#FFCC99', 
        '#FFFF00', 
        '#333300', 
        '#FF0000', 
        '#00FFFF', 
        '#FF9900', 
        '#00FF00'
    ];
    
    public $titulo_agregar;

    public function mount()
    {        
        $this->rangos = Rango::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $this->ships = Ship::where('estado', 1)->orderBy('nombre', 'asc')->get();
        //$this->reset('cn_red','cn_orange','cn_yellow','cn_green','cn_pendiente');    
    }

    public function render()
    {
        //$personas = Persona::orderBy('id', 'asc')->get();
        $this->personas = Persona::query()
            ->where('estado', 1)
            ->when($this->rangoFilter, function ($query) {
                $query->whereIn('rango_id', $this->rangoFilter);
            })
            ->when($this->shipFilter, function ($query) {
                $query->where('ship_id', $this->shipFilter);
            })
            ->when($this->nameFilter, function ($query) {
                $query->where('nombre', 'LIKE', '%' . $this->nameFilter . '%');
            })            
            ->orderBy('rango_id', 'asc')
            ->orderBy('nombre', 'asc')
            ->get();
        $rango_seleccionado = $this->getRangoSeleccionado();
        $meses_seleccionados = $this->getMesesSeleccionados($rango_seleccionado);   

        $arr_personas = [];
        foreach($this->personas as $persona)
        {            
            $arr_personas[] = [$persona->id];
        }
        
        /* $events = EmbarcoProgramacion::query()
            ->whereIn('persona_id', $arr_personas)
            ->get(); */
        
        //dd($events);
        $events = [];
        foreach($meses_seleccionados as $mes_seleccionado)
        {
            $eventos = EmbarcoProgramacion::query()
                ->whereIn('persona_id', $arr_personas)
                ->where('nr_mes', $mes_seleccionado['nr_mes'])
                ->where('nr_anio', $mes_seleccionado['nr_anio'])
                ->get();
            
            if($eventos){
                foreach($eventos as $evento){
                    $events[] = [
                        'id_persona'=> $evento->persona_id,
                        'nr_semana' => $evento->nr_semana,
                        'nr_mes'    => $evento->nr_mes,
                        'nr_anio'   => $evento->nr_anio,
                        'str_color'   => $evento->str_color,
                        'id_celda'   => $evento->id_celda
                    ];
                }
            }            
        }                   

        return view('livewire.admin.programacion-embarcos', compact('rango_seleccionado', 'meses_seleccionados', 'events'));
    }

    public function getRangoSeleccionado()
    {
        $cn_meses = $this->cn_mostrar;
        $cn_meses_mitad = $cn_meses / 2;        
        $hoy = Carbon::now();
        $first_day_desde = Carbon::parse('first day of this month');
        $first_day_hasta = Carbon::parse('first day of this month');        
        $fc_desde = $first_day_desde->subMonth($cn_meses_mitad);
        $fechas['fc_desde'] = $fc_desde->toDateString();
        $fc_hasta = $first_day_hasta->addMonth($cn_meses_mitad);
        $fechas['fc_hasta'] = $fc_hasta->toDateString();
        return $fechas;
    }

    public function getMesesSeleccionados($rango_seleccionado)
    {
        $arr_meses = [];
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($rango_seleccionado['fc_desde']);
        for($i=0; $i<$this->cn_mostrar; $i++)
        {                     
            if($i==0)
            {
                $mes = $meses[($fecha->format('n')) - 1].' '.$fecha->format('Y'); 
                $nr_mes = $fecha->format('n'); 
                $nr_anio = $fecha->format('Y'); 
                array_push($arr_meses, ['nm_mes' => $mes, 'nr_mes' => $nr_mes, 'nr_anio' => $nr_anio]);
            }
            else{
                $fecha = $fecha->addMonth();
                $mes = $meses[($fecha->format('n')) - 1].' '.$fecha->format('Y'); 
                $nr_mes = $fecha->format('n'); 
                $nr_anio = $fecha->format('Y'); 
                array_push($arr_meses, ['nm_mes' => $mes, 'nr_mes' => $nr_mes, 'nr_anio' => $nr_anio]);
            }
        }
        //dd($arr_meses);
        return ( $arr_meses );
    }

    public function close_agregar_prog()
    {
        $this->reset('plaza_id', 'ship_id', 'nr_semanas', 'id_estado', 'persona_id');        
    }

    public function getMesAnioValidacion($nr_semanas, $nr_semana_ini, $nr_mes_ini, $nr_anio_ini)
    {        
        $a = '';
        $nr_semana = 0;
        $nr_mes = 0;
        $nr_anio = 0;
        //$events[] = [];
        for ($i=0; $i < $nr_semanas; $i++) { 
            $a = $a.$i.'-';
            if($i == 0){
                $nr_semana = $nr_semana_ini;
                $nr_mes = $nr_mes_ini;
                $nr_anio = $nr_anio_ini;
            }else{
                $nr_semana = $nr_semana;
                $nr_mes = $nr_mes;
                $nr_anio = $nr_anio;
            }

            $semanas[] = [
                'nr_semana' => $nr_semana,
                'nr_mes'    => $nr_mes,
                'nr_anio'   => $nr_anio
            ];

            $nr_semana++;
            if($nr_semana > 4){
                $nr_semana = 1;
                $nr_mes++;
                if($nr_mes > 12){
                    $nr_mes = 1;
                    $nr_anio++;
                }
            }                        
        } 
        
        return $semanas;
        //dd($events);
        //dd($nr_semanas, $nr_semana_ini, $nr_mes_ini, $nr_anio_ini);
    }

    public function saveProgramacion()
    {
        //dd($this->str_color, $this->id_estado);
        //dd($this->str_color[$this->id_estado]);
        //dd($this->nr_semanas);        
        $semanas = $this->getMesAnioValidacion($this->nr_semanas, $this->nr_semana, $this->nr_mes, $this->nr_anio);
        $id_programacion = $this->persona_id.$this->nr_semana.$this->nr_mes.$this->nr_anio;        
        foreach($semanas as $semana)
        {
            //dd($semana['nr_semana']);
            $programacion = EmbarcoProgramacion::create([
                'id_programacion' => $id_programacion,                    
                'persona_id' => $this->persona_id,
                'ship_id' => $this->ship_id,
                'rango_id' => $this->plaza_id,
                'nr_semana' => $semana['nr_semana'],
                'nr_mes' => $semana['nr_mes'],
                'nr_anio' => $semana['nr_anio'],
                'id_estado' => $this->id_estado,
                'str_color' => $this->str_color[$this->id_estado],
                'id_celda' => $this->persona_id.'_'.$semana['nr_semana'].'_'.$semana['nr_mes'].'_'.$semana['nr_anio']
            ]); 
        }     
        $this->close_agregar_prog();
        $this->emit('render');           
        $this->emit('agregarProgramacion', 'Programación agregada con exito!');
    }

    public function setModalSemanaInicialAgregar($nm_persona, $persona_id, $nr_semana, $nm_mes, $nr_mes, $nr_anio)
    {
        //dd($nm_persona, $persona_id, $nr_semana, $nm_mes, $nr_anio);
        $this->titulo_agregar = $nm_persona.' - '.$nm_mes.' Semana: '.$nr_semana;
        $this->persona_id = $persona_id;
        $this->nr_semana = $nr_semana;
        $this->nr_mes = $nr_mes;
        $this->nr_anio = $nr_anio;
    }
}
