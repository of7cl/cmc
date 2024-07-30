<?php
use App\Http\Controllers\CarbonController;
use App\Http\Controllers\RangoDocumentoController;
use App\Http\Controllers\Admin\ParameterDocController;

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

//dd($docs_rango);
//print_r ( $rangoDocumento->getExisteDocumentoRango($docs_rango, 26, 19) );

?>
@section('content_header')
    {{-- <div class="row">
        <div class="col-4">
            <h1>Control de Documentos</h1>
        </div>
    </div> --}}
    <h1>Control de Documentos</h1>
@stop
<div wire:init="loadDocs">
    @if ($loadDocs)
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12">
                        {{-- <div class="custom-control custom-switch float-right">
                            <input class="custom-control-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                            <label class="custom-control-label" for="flexSwitchCheckDefault">Default switch checkbox
                                input</label>
                        </div> --}}
                        {{-- <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-danger float-right">
                            <input type="checkbox" class="custom-control-input" id="customSwitchRed" wire:model="redFilter">
                            <label class="custom-control-label" for="customSwitchRed">
                                <input wire:model="cn_red" type="button" class="btn btn-sm ml-1" style="background-color: red">
                            </label>
                        </div> --}}                        

                        <input wire:model="cn_red" type="button" class="btn btn-sm ml-1 float-right"
                            style="background-color: red">
                        <input wire:model="cn_orange" type="button" class="btn btn-sm ml-1 float-right"
                            style="background-color: orange">
                        <input wire:model="cn_yellow" type="button" class="btn btn-sm ml-1 float-right"
                            style="background-color: yellow">
                        <input wire:model="cn_green" type="button" class="btn btn-sm ml-1 float-right"
                            style="background-color: green">
                        <input wire:model="cn_pendiente" type="button" class="btn btn-sm ml-1 float-right"
                            style="background-color: black; color: white">

                        <div class="mb-2 mt-2 mr-4 text-red" wire:loading wire:target="semaforoFilter">Procesando...</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
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
                        {!! Form::label('semaforoFilter', 'Estado') !!}
                        <div class="row justify-content-md-center mt-2">
                            <div class="custom-control custom-switch custom-switch-off-dark custom-switch-on-dark" style="padding-left: 1.9rem;">
                                <input type="checkbox" class="custom-control-input" id="customSwitchBlack"
                                    wire:model="blackFilter"
                                    {{-- wire:click="semaforoFilter('pendiente')" --}}>
                                <label class="custom-control-label" for="customSwitchBlack"></label>
                            </div>
                            <div class="custom-control custom-switch custom-switch-off-green custom-switch-on-green" style="padding-left: 1.9rem;">
                                <input type="checkbox" class="custom-control-input" id="customSwitchGreen"
                                    wire:model="greenFilter"
                                    {{-- wire:click="semaforoFilter('green')" --}}>
                                <label class="custom-control-label" for="customSwitchGreen"></label>
                            </div>
                            <div class="custom-control custom-switch custom-switch-off-yellow custom-switch-on-yellow" style="padding-left: 1.9rem;">
                                <input type="checkbox" class="custom-control-input" id="customSwitchYellow"
                                    wire:model="yellowFilter"
                                    {{-- wire:click="semaforoFilter('yellow')" --}}>
                                <label class="custom-control-label" for="customSwitchYellow"></label>
                            </div>
                            <div class="custom-control custom-switch custom-switch-off-orange custom-switch-on-orange" style="padding-left: 1.9rem;">
                                <input type="checkbox" class="custom-control-input" id="customSwitchOrange"
                                    wire:model="orangeFilter"
                                    {{-- wire:click="semaforoFilter('orange')" --}}>
                                <label class="custom-control-label" for="customSwitchOrange"></label>
                            </div> 
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-danger" style="padding-left: 1.9rem;">
                                <input type="checkbox" class="custom-control-input" id="customSwitchRed"
                                    wire:model="redFilter"
                                    {{-- wire:click="semaforoFilter('red')" --}}>
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
                                <tr>
                                    <td class="border border-secondary" style="cursor: pointer">
                                        <button wire:click="edit({{ $persona->id }})" type="button"
                                            class="btn btn-xs btn-light" data-toggle="modal"
                                            data-target="#modalCreatePersona" data-backdrop="static"
                                            data-keyboard="false"><i class="fas fa-edit"></i></button>
                                    </td>
                                    <td class="border border-secondary align-middle text-center">
                                        @if ($persona->ship_id)
                                            {{ $persona->ship->nombre }}
                                        @else
                                            {{ '-' }}
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
                                        {{-- valida si persona tiene documentos asociados --}}
                                        @if ($persona->documento->count())
                                            <?php
                                            $cn = 0;
                                            $bo_existe = 0;
                                            $estado = 0;
                                            $fc_fin = null;
                                            ?>
                                            {{-- recorre documentos de la persona --}}
                                            @foreach ($persona->documento as $doc_persona)
                                                {{-- valida si persona tiene el documento actual --}}
                                                @if ($doc_persona->pivot->documento_id == $documento->id)
                                                    <?php
                                                    $cn++;
                                                    $bo_existe++;
                                                    if ($cn > 0) {
                                                        $estado = $doc_persona->pivot->estado;
                                                        if ($doc_persona->pivot->fc_fin) {
                                                            $fc_fin = $doc_persona->pivot->fc_fin;
                                                            $diff = $fecha->diffFechaActual($fc_fin);
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
                                                    @if ($diff <= $flag_red)
                                                        <td class="border border-secondary align-middle text-center"
                                                            style="background-color: red">
                                                            <a class="btn btn-xs" style="background-color: red"
                                                                wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                                data-toggle="modal" data-target="#modalEditDocPersona"
                                                                data-backdrop="static" data-keyboard="false"
                                                                {{-- href="{{ route('admin.personas.show', $persona) }}" --}}>{{ $fc_fin }}</a>
                                                        </td>
                                                        <?php 
                                                        $cn_red++; 
                                                        array_push($arr_red, $persona->id);
                                                        ?>
                                                    @elseif($diff > $flag_red && $diff < $flag_orange)
                                                        <td class="border border-secondary align-middle text-center"
                                                            style="background-color: orange">
                                                            <a class="btn btn-xs" style="background-color: orange"
                                                                wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                                data-toggle="modal" data-target="#modalEditDocPersona"
                                                                data-backdrop="static" data-keyboard="false"
                                                                {{-- href="{{ route('admin.personas.show', $persona) }}" --}}>{{ $fc_fin }}</a>
                                                        </td>
                                                        <?php 
                                                        $cn_orange++; 
                                                        array_push($arr_orange, $persona->id);
                                                        ?>
                                                    @elseif($diff > $flag_orange && $diff < $flag_yellow)
                                                        <td class="border border-secondary align-middle text-center"
                                                            style="background-color: yellow">
                                                            <a class="btn btn-xs" style="background-color: yellow"
                                                                wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                                data-toggle="modal" data-target="#modalEditDocPersona"
                                                                data-backdrop="static" data-keyboard="false"
                                                                {{-- href="{{ route('admin.personas.show', $persona) }}" --}}>{{ $fc_fin }}</a>
                                                        </td>
                                                        <?php 
                                                        $cn_yellow++; 
                                                        array_push($arr_yellow, $persona->id);
                                                        ?>
                                                    @else
                                                        <td class="border border-secondary align-middle text-center"
                                                            style="background-color: green">
                                                            <a class="btn btn-xs" style="background-color: green"
                                                                wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                                data-toggle="modal" data-target="#modalEditDocPersona"
                                                                data-backdrop="static" data-keyboard="false"
                                                                {{-- href="{{ route('admin.personas.show', $persona) }}" --}}>{{ $fc_fin }}</a>
                                                        </td>
                                                        <?php 
                                                        $cn_green++;                                                         
                                                        array_push($arr_green, $persona->id);
                                                        ?>
                                                    @endif
                                                @else
                                                    <td class="border border-secondary align-middle text-center"
                                                        style="background-color: black">
                                                        <a class="btn btn-xs"
                                                            style="background-color: black; color: white"
                                                            wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                            data-toggle="modal" data-target="#modalEditDocPersona"
                                                            data-backdrop="static" data-keyboard="false"
                                                            {{-- href="{{ route('admin.personas.show', $persona) }}" --}}>
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
                                                {{-- busca si documento en curso pertenece a rango y/o tipo de nave --}}
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
                                                ?>
                                                <td class="border border-secondary align-middle text-center">
                                                    {{-- si documento pertenece a rango y/o tipo de nave --}}
                                                    @if ($arr != [])
                                                        @if ($arr['obligatorio'] == 1)
                                                            {{-- <a class="btn btn-primary btn-xs"
                                                                href="{{ route('admin.personas.show', $persona) }}">+</a> --}}

                                                            <input
                                                                wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                                type="button" value="+"
                                                                class="btn btn-primary btn-xs" data-toggle="modal"
                                                                data-target="#modalEditDocPersona"
                                                                data-backdrop="static" data-keyboard="false">
                                                        @endif
                                                    @endif
                                                </td>
                                            @endif
                                        @else
                                            {{-- busca si documento en curso pertenece a rango y/o tipo de nave --}}
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
                                            ?>
                                            <td class="border border-secondary align-middle text-center">
                                                {{-- si documento pertenece a rango y/o tipo de nave --}}
                                                @if ($arr != [])
                                                    @if ($arr['obligatorio'] == 1)
                                                        {{-- <a class="btn btn-primary btn-xs"
                                                            href="{{ route('admin.personas.show', $persona) }}">+</a> --}}
                                                        <input
                                                            wire:click="edit_doc({{ $documento->id }}, {{ $persona }})"
                                                            type="button" value="+"
                                                            class="btn btn-primary btn-xs" data-toggle="modal"
                                                            data-target="#modalEditDocPersona" data-backdrop="static"
                                                            data-keyboard="false">
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
                    {{-- @livewire('admin.create-persona') --}}
                </div>
            @else
                <div class="card-body">
                    <strong>No hay ningún registro...</strong>
                </div>
            @endif
        </div>
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
                                {{-- <div style="height:620px;"> --}}
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
                                        Cargando...
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
                                                wire:model="nombre" id="nombre_persona_edit">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="nr_curso_edit" class="col-sm-2 col-form-label">N° Curso</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly disabled class="form-control-plaintext"
                                                wire:model="nr_documento" id="nr_curso_edit">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="codigo_omi_edit" class="col-sm-2 col-form-label">Código
                                            OMI</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly disabled class="form-control-plaintext"
                                                wire:model="codigo_omi" id="codigo_omi_edit">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="nombre_edit" class="col-sm-2 col-form-label">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly disabled class="form-control-plaintext"
                                                wire:model="nombre_doc" id="nombre_edit">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <label class="col-sm-4 col-form-label">Fecha Inicio</label>
                                                <div class="col-sm-6">
                                                    <input type="date" name="" id=""
                                                        class="form-control form-control-sm" wire:model="fc_inicio">
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
                                                        class="form-control form-control-sm" wire:model="fc_fin">
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
                                            <input type="checkbox" class="mt-2" wire:model="estado" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Certificado</label>
                                        <div class="col-sm-10 mx-0 my-0">
                                            <input type="file" accept="application/pdf" wire:model="archivo"
                                                id="{{ $identificador }}">
                                            @error('archivo')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="{{ $identificador }}" wire:model="archivo">
                                            <label class="custom-file-label" for="{{ $identificador }}">Choose file</label>
                                            </div> --}}
                                    </div>
                                    <div class="row mx-0">
                                        @if ($archivo)
                                            <embed src="{{ $archivo->temporaryUrl() }}" width="100%"
                                                height="400px" />
                                        @else
                                            @if ($nm_archivo_guardado)
                                                <embed src="{{ asset('storage/' . $nm_archivo_guardado) }}"
                                                    width="100%" height="400px" />
                                            @endif
                                        @endif
                                    </div>

                                    <div class="mb-0 mt-2 text-red" wire:loading wire:target="archivo">Cargando...
                                    </div>
                                    <div class="mb-0 mt-2 text-red" wire:loading wire:target="edit_doc">
                                        Cargando...
                                    </div>
                                    <div class="mb-0 mt-2 text-red" wire:loading wire:target="update_doc">
                                        Procesando...
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
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
            {{-- <i class="fas fa-spinner animate-spin"></i>  --}}
            Procesando...
        </div>
    @endif
</div>
