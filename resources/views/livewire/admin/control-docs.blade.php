<?php
use App\Http\Controllers\CarbonController;
use App\Http\Controllers\RangoDocumentoController;
use App\Http\Controllers\Admin\ParameterDocController;
use App\Models\DetalleTrayectoria;

$fecha = new CarbonController();
$rangoDocumento = new RangoDocumentoController();
$parameterdocs = new ParameterDocController();

$parameters = $parameterdocs->getParameterDocs();
$rangos = $rangoDocumento->getRangos();

$flag_red = $parameters[0]['flag_red'];
$flag_orange = $parameters[0]['flag_orange'];
$flag_yellow = $parameters[0]['flag_yellow'];
$flag_green = $parameters[0]['flag_green'];
$arr_red = [];
$arr_orange = [];
$arr_yellow = [];
$arr_green = [];
$arr_pendiente = [];
$docs_rango = [];
foreach ($rangos as $rango) {
    foreach ($rango->documentos as $docs) {
        $doc = [
            'rango_id' => $rango->id,
            'documento_id' => $docs->pivot->documento_id,
            'obligatorio' => $docs->pivot->obligatorio,
        ];
        array_push($docs_rango, $doc);
    }
}

?>
@section('content_header')
    <h1>Control de Documentos</h1>
@stop
<div wire:init="loadDocs">
    @if ($loadDocs)
        <div class="card">
            <div class="ml-2 mb-2 mt-2 mr-4 text-red" wire:loading>Procesando...</div>
            <div class="card-header">
                <div class="row">
                    <div class="col-12 mb-2">                             
                        <input id="btn_cn_red" wire:model="cn_red" type="button" class="btn btn-sm ml-1 float-right" style="background-color: red">
                        <input id="btn_cn_orange" wire:model="cn_orange" type="button" class="btn btn-sm ml-1 float-right" style="background-color: orange">
                        <input id="btn_cn_yellow" wire:model="cn_yellow" type="button" class="btn btn-sm ml-1 float-right" style="background-color: yellow">
                        <input id="btn_cn_green" wire:model="cn_green" type="button" class="btn btn-sm ml-1 float-right" style="background-color: green">
                        <input id="btn_cn_pendiente" wire:model="cn_pendiente" type="button" class="btn btn-sm ml-1 float-right" style="background-color: black; color: white">

                        <input type="hidden" id="hd_cn_red" value="{{$flag_red}}">
                        <input type="hidden" id="hd_cn_orange" value="{{$flag_orange}}">
                        <input type="hidden" id="hd_cn_yellow" value="{{$flag_yellow}}">
                        <input type="hidden" id="hd_cn_green" value="{{$flag_green}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        {!! Form::label('recordsPage', 'Mostrar') !!}
                        <select wire:model="recordsPage" class="form-control">                            
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>                                                                
                        </select>
                    </div>
                    <div class="col-2">
                        {!! Form::label('shipFilter', 'Nave') !!}
                        <select wire:model="shipFilter" class="form-control">
                            <option value="">Seleccione Nave...</option>
                            @foreach ($ships as $ship)
                                <option value="{{ $ship->id }}">{{ $ship->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        {!! Form::label('rangoFilter', 'Rango') !!}
                        <select wire:model="rangoFilter" class="form-control">
                            <option value="">Seleccione Rango...</option>
                            @foreach ($rangos as $rango)
                                <option value="{{ $rango->id }}">{{ $rango->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        {!! Form::label('nameFilter', 'Nombre') !!}
                        <input wire:model="nameFilter" class="form-control" placeholder="Ingrese nombre de dotación">
                    </div>
                    <div class="col-2">
                        {{-- {!! Form::label('semaforoFilter', 'Estado') !!} --}}
                        <label id="leyenda">Estado</label>
                        <div class="row justify-content-md-center mt-2">
                            <div class="custom-control custom-switch custom-switch-off-dark custom-switch-on-dark"
                                style="padding-left: 1.9rem;" id="div_cn_pendiente">
                                <input type="checkbox" class="custom-control-input" id="customSwitchBlack"
                                    wire:model="blackFilter" {{-- wire:click="semaforoFilter('pendiente')" --}}>
                                <label class="custom-control-label" for="customSwitchBlack"></label>
                            </div>
                            <div class="custom-control custom-switch custom-switch-off-green custom-switch-on-green"
                                style="padding-left: 1.9rem;" id="div_cn_green">
                                <input type="checkbox" class="custom-control-input" id="customSwitchGreen"
                                    wire:model="greenFilter" {{-- wire:click="semaforoFilter('green')" --}}>
                                <label class="custom-control-label" for="customSwitchGreen"></label>
                            </div>
                            <div class="custom-control custom-switch custom-switch-off-yellow custom-switch-on-yellow"
                                style="padding-left: 1.9rem;" id="div_cn_yellow">
                                <input type="checkbox" class="custom-control-input" id="customSwitchYellow"
                                    wire:model="yellowFilter" {{-- wire:click="semaforoFilter('yellow')" --}}>
                                <label class="custom-control-label" for="customSwitchYellow"></label>
                            </div>
                            <div class="custom-control custom-switch custom-switch-off-orange custom-switch-on-orange"
                                style="padding-left: 1.9rem;" id="div_cn_orange">
                                <input type="checkbox" class="custom-control-input" id="customSwitchOrange"
                                    wire:model="orangeFilter" {{-- wire:click="semaforoFilter('orange')" --}}>
                                <label class="custom-control-label" for="customSwitchOrange"></label>
                            </div>
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-danger"
                                style="padding-left: 1.9rem;" id="div_cn_red">
                                <input type="checkbox" class="custom-control-input" id="customSwitchRed"
                                    wire:model="redFilter" {{-- wire:click="semaforoFilter('red')" --}}>
                                <label class="custom-control-label" for="customSwitchRed"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            @if ($personas->count())
                <div class="card-body table-responsive text-nowrap" style="max-height: 650px; padding:0%;">
                    <table class="table-xsm table-striped table-hover" style="border-collapse: separate;">
                        <thead class="table-secondary border border-secondary" style="position: sticky; top:0;">
                            <tr>
                                <th rowspan="1" colspan="2"
                                    class="border border-secondary align-middle text-center">
                                    Nave
                                </th>
                                <th rowspan="1" class="border border-secondary align-middle text-center">Rango</th>
                                <th rowspan="1" class="border border-secondary align-middle text-center th-lg">
                                    Dotación
                                </th>
                                @foreach ($documentos as $documento)
                                    <th class="border border-secondary align-middle text-center">
                                        {{ $documento->nr_documento }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($personas as $persona)                                   
                                @if ($persona->eventual == 2)
                                <tr style="background-color: rgb(252, 211, 151); cursor: pointer;" title="Personal Eventual">
                                @else
                                <tr>
                                @endif                                
                                    <td class="border border-secondary" style="cursor: pointer">
                                        <button wire:click="edit({{ $persona->id }})" type="button"
                                            class="btn btn-xs btn-light" data-toggle="modal"
                                            data-target="#modalCreatePersona" data-backdrop="static"
                                            data-keyboard="false"><i class="fas fa-edit"></i></button>
                                    </td>
                                    <td class="border border-secondary align-middle text-center" >
                                        @if ($persona->ship_id)
                                            {{ $persona->ship->nombre }}
                                        @else
                                            <?php
                                            $nm_estado = null;
                                            if($persona->trayectoria)
                                            {
                                                $detalle = detalleTrayectoria::where('trayectoria_id', $persona->trayectoria->id)
                                                ->where('fc_desde', '<=', now())
                                                ->where('fc_hasta', '>=', now())
                                                ->whereNotIn('estado_id', [18,19,20])
                                                ->first();
                                                if($detalle)
                                                {
                                                    $nm_estado = 'En Tierra';
                                                }
                                                else {
                                                    $nm_estado = 'En Tierra';
                                                }
                                            }
                                            else {
                                                $nm_estado = 'En Tierra';
                                            }
                                            ?>
                                            {{ $nm_estado }}
                                        @endif
                                    </td>
                                    <td class="border border-secondary align-middle text-center">
                                        @if ($persona->rango_id)
                                            {{ $persona->rango->nombre }}
                                        @else
                                            {{ '-' }}
                                        @endif
                                    </td>
                                    <td class="border border-secondary">
                                        {{ $persona->id }} - {{ $persona->nombre }}
                                    </td>
                                    @foreach ($documentos as $documento)
                                        <?php
                                        if ($persona->ship_id) {
                                            if ($persona->ship->ship_tipo) {
                                                $arr = $rangoDocumento->getExisteDocumentoRango($docs_rango, $persona->ship->ship_tipo->documentos, $documento->id, $persona->rango_id);
                                            } else {
                                                $arr = $rangoDocumento->getExisteDocumentoRango($docs_rango, null, $documento->id, $persona->rango_id);
                                            }
                                        } else {
                                            $arr = $rangoDocumento->getExisteDocumentoRango($docs_rango, null, $documento->id, $persona->rango_id);
                                        }
                                        $cell_border = '';
                                        if ($arr != [])
                                        {
                                            if($arr['origen'] == 'rango')
                                            {
                                                $cell_border = 'border-left-color: #0069d9; border-left-style: solid; border-left-width: 0.2cm;';
                                            }
                                            else {
                                                $cell_border = 'border-left-color: #28a745; border-left-style: solid; border-left-width: 0.2cm;';
                                            }
                                        }
                                        ?>
                                        {{-- valida si persona tiene documentos asociados --}}
                                        @if ($persona->documento->count())
                                            <?php
                                            $cn = 0;                                            
                                            $estado = 0;
                                            $fc_fin = null;
                                            ?>
                                            {{-- recorre documentos de la persona --}}
                                            @foreach ($persona->documento as $doc_persona)
                                                {{-- valida si persona tiene el documento actual --}}
                                                @if ($doc_persona->pivot->documento_id == $documento->id)
                                                    <?php
                                                    $cn++;                                                    
                                                    if ($cn > 0) {
                                                        $estado = $doc_persona->pivot->estado;
                                                        $semaforo = $doc_persona->pivot->semaforo;
                                                        if ($doc_persona->pivot->fc_fin) {
                                                            $fc_fin = $doc_persona->pivot->fc_fin;                                                            
                                                            $fc_fin = $fecha->formatodmY($fc_fin);
                                                        } else {
                                                            if ($estado == 0) {
                                                                $cn = 0;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                @endif
                                            @endforeach
                                            {{-- muestra fecha --}}
                                            {{-- si persona tiene documento asociado y tiene fechas ingresadas --}}
                                            @if ($cn > 0)
                                                @if ($estado == 0)                                                    
                                                    @if ($semaforo == '2')
                                                        <td class="align-middle text-center"
                                                            style="background-color: red; {{$cell_border}}">
                                                            <a class="btn btn-xs" style="background-color: red"
                                                                wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                                data-toggle="modal" data-target="#modalEditDocPersona"
                                                                data-backdrop="static" data-keyboard="false"
                                                                >{{ $fc_fin }}</a>
                                                        </td>
                                                        <?php
                                                        $cn_red++;
                                                        array_push($arr_red, $persona->id);
                                                        ?>                                                        
                                                    @elseif ($semaforo == '3')
                                                        <td class="align-middle text-center"
                                                            style="background-color: orange; {{$cell_border}}">
                                                            <a class="btn btn-xs" style="background-color: orange"
                                                                wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                                data-toggle="modal" data-target="#modalEditDocPersona"
                                                                data-backdrop="static" data-keyboard="false"
                                                                >{{ $fc_fin }}</a>
                                                        </td>
                                                        <?php
                                                        $cn_orange++;
                                                        array_push($arr_orange, $persona->id);
                                                        ?>                                                        
                                                    @elseif ($semaforo == '4')
                                                        <td class="align-middle text-center"
                                                            style="background-color: yellow; {{$cell_border}}">
                                                            <a class="btn btn-xs" style="background-color: yellow"
                                                                wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                                data-toggle="modal" data-target="#modalEditDocPersona"
                                                                data-backdrop="static" data-keyboard="false"
                                                                >{{ $fc_fin }}</a>
                                                        </td>
                                                        <?php
                                                        $cn_yellow++;
                                                        array_push($arr_yellow, $persona->id);
                                                        ?>
                                                    @else
                                                        <td class="align-middle text-center"
                                                            style="background-color: green; {{$cell_border}}">
                                                            <a class="btn btn-xs" style="background-color: green"
                                                                wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                                data-toggle="modal" data-target="#modalEditDocPersona"
                                                                data-backdrop="static" data-keyboard="false"
                                                                >{{ $fc_fin }}</a>
                                                        </td>
                                                        <?php
                                                        $cn_green++;
                                                        array_push($arr_green, $persona->id);
                                                        ?>
                                                    @endif
                                                @else
                                                    <td class="align-middle text-center"
                                                        style="background-color: black; {{$cell_border}}">
                                                        <a class="btn btn-xs"
                                                            style="background-color: black; color: white"
                                                            wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                            data-toggle="modal" data-target="#modalEditDocPersona"
                                                            data-backdrop="static" data-keyboard="false"
                                                            >
                                                            @if ($fc_fin == null)
                                                                Pendiente
                                                            @else
                                                                {{ $fc_fin }}
                                                            @endif
                                                        </a>
                                                    </td>
                                                    <?php
                                                    $cn_pendiente++;
                                                    array_push($arr_pendiente, $persona->id);
                                                    ?>
                                                @endif
                                            @else                                                
                                                <td class="border border-secondary align-middle text-center">
                                                    {{-- si documento pertenece a rango y/o tipo de nave --}}
                                                    @if ($arr != [])
                                                        @if ($arr['obligatorio'] == 1)                                                            
                                                            @if ($arr['origen'] == 'rango')
                                                                <input
                                                                    wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                                    type="button" value="+"
                                                                    class="btn btn-primary btn-xs" data-toggle="modal"
                                                                    data-target="#modalEditDocPersona"
                                                                    data-backdrop="static" data-keyboard="false">
                                                            @else
                                                                <input
                                                                    wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                                    type="button" value="+"
                                                                    class="btn btn-success btn-xs" data-toggle="modal"
                                                                    data-target="#modalEditDocPersona"
                                                                    data-backdrop="static" data-keyboard="false">
                                                            @endif
                                                        @endif
                                                    @endif
                                                </td>
                                            @endif
                                        @else                                            
                                            <td class="border border-secondary align-middle text-center">
                                                {{-- si documento pertenece a rango y/o tipo de nave --}}
                                                @if ($arr != [])
                                                    @if ($arr['obligatorio'] == 1)                                                        
                                                        @if ($arr['origen'] == 'rango')
                                                            <input
                                                                wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                                type="button" value="+"
                                                                class="btn btn-primary btn-xs" data-toggle="modal"
                                                                data-target="#modalEditDocPersona"
                                                                data-backdrop="static" data-keyboard="false">
                                                        @else
                                                            <input
                                                                wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                                type="button" value="+"
                                                                class="btn btn-success btn-xs" data-toggle="modal"
                                                                data-target="#modalEditDocPersona"
                                                                data-backdrop="static" data-keyboard="false">
                                                        @endif                                                        
                                                    @endif
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                            <?php
                            $this->cn_red = $cn_red;
                            $this->cn_orange = $cn_orange;
                            $this->cn_yellow = $cn_yellow;
                            $this->cn_green = $cn_green;
                            $this->cn_pendiente = $cn_pendiente;
                            $this->arr_pendiente = $arr_pendiente;
                            $this->arr_red = $arr_red;
                            $this->arr_orange = $arr_orange;
                            $this->arr_yellow = $arr_yellow;
                            $this->arr_green = $arr_green;
                            $this->bo_arr = true;
                            ?>
                            
                        </tbody>
                    </table>                                          
                </div>
                @if($personas->hasPages())
                    <div class="card-footer">
                        <div class="row">                            
                            <div>
                                {{ $personas->links() }}
                            </div>
                        </div>                        
                    </div>
                @endif
            @else
                <div class="card-body">
                    <strong>No hay ningún registro...</strong>
                </div>
            @endif            
        </div>
        {{-- modalCreatePersona --}}
        <div>
            <form>
                <div wire:ignore.self class="modal fade" id="modalCreatePersona" tabindex="-1" role="dialog"
                    aria-labelledby="modalCreatePersonaTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCreatePersonaTitle">Editar Personal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">                                
                                <div>
                                    <div class="form-group">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input wire:model="nombre" type="text" class="form-control"
                                            placeholder="Ingrese nombre del personal">
                                        @error('nombre')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="rut" class="form-label">RUT</label>
                                        <input wire:model="rut" type="text" class="form-control"
                                            placeholder="Ingrese RUT del personal">
                                        @error('rut')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="rango_id" class="form-label">Rango</label>
                                        @if ($rango_id == null)
                                            <select wire:model="rango_id" class="form-control"
                                                placeholder="Seleccionar Rango...">
                                                <option selected>Seleccionar Rango...</option>
                                                @foreach ($rangos as $rango)
                                                    <option value="{{ $rango->id }}">
                                                        {{ $rango->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <select wire:model="rango_id" class="form-control"
                                                placeholder="Seleccionar Rango...">
                                                @foreach ($rangos as $rango)
                                                    @if ($rango->id == $rango_id)
                                                        <option value="{{ $rango->id }}" selected>
                                                            {{ $rango->nombre }}</option>
                                                    @else
                                                        <option value="{{ $rango->id }}">
                                                            {{ $rango->nombre }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @endif

                                        @error('rango_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="ship_id" class="form-label">Nave</label>
                                        @if ($ship_id == null)
                                            <select wire:model="ship_id" class="form-control"
                                                placeholder="Seleccionar Nave...">
                                                <option selected>Seleccionar Nave...</option>
                                                @foreach ($ships as $ship)
                                                    <option value="{{ $ship->id }}">
                                                        {{ $ship->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <select wire:model="ship_id" class="form-control"
                                                placeholder="Seleccionar Nave...">
                                                @foreach ($ships as $ship)
                                                    @if ($ship->id == $ship_id)
                                                        <option value="{{ $ship->id }}" selected>
                                                            {{ $ship->nombre }}</option>
                                                    @else
                                                        <option value="{{ $ship->id }}">
                                                            {{ $ship->nombre }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @endif
                                        @error('ship_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="fc_nacimiento" class="form-label">Fecha de
                                            Nacimiento</label>
                                        <input wire:model="fc_nacimiento" type="date" class="form-control">
                                        @error('fc_nacimiento')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="fc_ingreso" class="form-label">Fecha de
                                            Ingreso</label>
                                        <input wire:model="fc_ingreso" type="date" class="form-control">
                                        @error('fc_ingreso')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="fc_baja" class="form-label">Fecha de Baja</label>
                                        <input wire:model="fc_baja" type="date" class="form-control">
                                        @error('fc_baja')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-1 text-red" wire:loading wire:target="edit">
                                        Procesando...
                                    </div>
                                    <div class="mb-1 text-red" wire:loading wire:target="update">
                                        Procesando...
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button wire:click="close" type="button" class="btn btn-danger"
                                    data-dismiss="modal">Cancelar</button>
                                <button wire:click="update" type="button" class="btn btn-primary"
                                    wire:loading.attr="disabled">Editar</button>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        {{-- modalEditDocPersona --}}
        <div>
            <form wire:submit.prevent="update_doc">
                <div wire:ignore.self class="modal fade" id="modalEditDocPersona" tabindex="-1" role="dialog"
                    aria-labelledby="modalEditDocPersonaTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditDocPersonaTitle">Editar Documento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    wire:click="close_doc">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <div class="row">
                                        <label for="nombre_persona_edit"
                                            class="col-sm-2 col-form-label">Persona</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly disabled class="form-control-plaintext"
                                                wire:model.defer="nombre" id="nombre_persona_edit">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="nr_curso_edit" class="col-sm-2 col-form-label">N° Curso</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly disabled class="form-control-plaintext"
                                                wire:model.defer="nr_documento" id="nr_curso_edit">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="codigo_omi_edit" class="col-sm-2 col-form-label">Código
                                            OMI</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly disabled class="form-control-plaintext"
                                                wire:model.defer="codigo_omi" id="codigo_omi_edit">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="nombre_edit" class="col-sm-2 col-form-label">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly disabled class="form-control-plaintext"
                                                wire:model.defer="nombre_doc" id="nombre_edit">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Fecha Inicio</label>
                                                <div class="col-sm-6">
                                                    <input type="date" name="" id=""
                                                        class="form-control form-control-sm"
                                                        wire:model.defer="fc_inicio">
                                                    @error('fc_inicio')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <label class="col-sm-6 col-form-label">Fecha Vencimiento</label>
                                                <div class="col-sm-6">
                                                    <input type="date" name="" id=""
                                                        class="form-control form-control-sm"
                                                        wire:model.defer="fc_fin">
                                                    @error('fc_fin')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="estado_edit" class="col-sm-2 col-form-label">¿Pendiente?</label>
                                        <div class="col-sm-10 mt-2">
                                            <input type="checkbox" class="mt-2" wire:model.defer="estado" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Certificado</label>
                                        <div class="col-sm-10 mx-0 my-0">
                                            <input type="file" accept="application/pdf" wire:model.defer="archivo"
                                                id="{{ $identificador }}">
                                            @error('archivo')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>                                        
                                    </div>
                                    <div class="row mx-0">
                                        @if ($archivo)
                                            <embed src="{{ $archivo->temporaryUrl() }}" width="100%"
                                                height="400px" />
                                        @else                                            
                                            @if ($nm_archivo_guardado)
                                                <embed src="{{ asset('storage/' . $nm_archivo_guardado) }}"
                                                    width="100%" height="400px" />
                                                {{-- <a href="mailto:someone@example.com">someone@example.com</a> --}}
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="mb-0 mt-2 text-red float-left" wire:loading wire:target="edit_doc">
                                    Procesando...</div>
                                <div class="mb-0 mt-2 text-red float-left" wire:loading wire:target="update_doc">
                                    Procesando...</div>
                                <div class="mb-0 mt-2 text-red float-left" wire:loading wire:target="archivo">
                                    Procesando...</div>
                                <button wire:click="close_doc" type="button" class="btn btn-danger"
                                    wire:loading.attr="disabled" wire:target="update_doc"
                                    data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary"
                                    wire:loading.attr="disabled">Editar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @else
        <div class="text-3xl text-red">            
            Procesando...
        </div>
    @endif
</div>
@push('js')
    <script>
        $(document).ready(function(){
            //$('[data-toggle="tooltip"]').tooltip();               
            if (typeof window.Livewire !== 'undefined') {
                window.Livewire.hook('message.processed', (message, component) => {
                    //$('[data-toggle="tooltip"]').tooltip('dispose').tooltip();
                    hd_red = $('#hd_cn_red').val();
                    hd_orange = $('#hd_cn_orange').val();
                    hd_yellow = $('#hd_cn_yellow').val();
                    hd_green = $('#hd_cn_green').val();

                    lbl_red = 'Vencimiento Menor a ' + hd_red + ' Días';
                    lbl_orange = 'Vencimiento Entre ' + hd_red + ' y ' + hd_orange + ' Días';
                    lbl_yellow = 'Vencimiento Entre ' + hd_orange + ' y ' + hd_yellow + ' Días';
                    lbl_green = 'Vencimiento Mayor ' + hd_yellow + ' Días';
                    
                    //$('#leyenda').tooltip({title: "<h1><strong>HTML</strong> inside <code>the</code> <em>tooltip</em></h1>", html: true, placement: "right"}); 
                    //$('#leyenda').tooltip({title: lbl_leyenda, html: true, placement: "right"}); 
                    $('#btn_cn_pendiente').tooltip({title: "Pendientes", html: false, placement: "top"}); 
                    $('#btn_cn_green').tooltip({title: lbl_green, html: false, placement: "top"}); 
                    $('#btn_cn_red').tooltip({title: lbl_red, html: false, placement: "top"}); 
                    $('#btn_cn_yellow').tooltip({title: lbl_yellow, html: false, placement: "top"}); 
                    $('#btn_cn_orange').tooltip({title: lbl_orange, html: false, placement: "top"}); 

                    $('#div_cn_pendiente').tooltip({title: "Pendientes", html: false, placement: "top"}); 
                    $('#div_cn_green').tooltip({title: lbl_green, html: false, placement: "top"}); 
                    $('#div_cn_red').tooltip({title: lbl_red, html: false, placement: "top"}); 
                    $('#div_cn_yellow').tooltip({title: lbl_yellow, html: false, placement: "top"}); 
                    $('#div_cn_orange').tooltip({title: lbl_orange, html: false, placement: "top"});
                    
                });
            }            
        });
    </script>
@endpush