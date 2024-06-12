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
                        <input wire:model="cn_red" type="button" class="btn btn-sm ml-1 float-right"
                            style="background-color: red">
                        <input wire:model="cn_orange" type="button" class="btn btn-sm ml-1 float-right"
                            style="background-color: orange">
                        <input wire:model="cn_yellow" type="button" class="btn btn-sm ml-1 float-right"
                            style="background-color: yellow">
                        <input wire:model="cn_green" type="button" class="btn btn-sm ml-1 float-right"
                            style="background-color: green">
                            <input wire:model="cn_pendiente" type="button" class="btn btn-sm ml-1 float-right "
                            style="background-color: black; color: white">
                    </div>
                </div>
                {{-- </div>
            <div class="card-header"> --}}
                <div class="row">
                    <div class="col-4">
                        {!! Form::label('shipFilter', 'Nave') !!}
                        <select wire:model="shipFilter" class="form-control">
                            <option value="">Seleccione Nave...</option>
                            @foreach ($ships as $ship)
                                <option value="{{ $ship->id }}">{{ $ship->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
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
                    {{-- <div class="col-4">            
                <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#modalCreatePersona">Nuevo</button>
            </div> --}}

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
                                {{-- <th colspan="{{$documentos->count()}}" class="border border-secondary text-center">Documentos</th> --}}
                                {{-- </tr>
                <tr> --}}
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
                                        {{-- @livewire('admin.edit-persona', ['persona' => $persona], key($persona->id))      {{$persona->id}} --}}
                                        <button wire:click="edit({{ $persona->id }})" type="button"
                                            class="btn btn-xs btn-light" data-toggle="modal"
                                            data-target="#modalCreatePersona"><i class="fas fa-edit"></i></button>

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
                                        {{ $persona->nombre }}
                                    </td>
                                    @foreach ($documentos as $documento)
                                        {{-- valida si persona tiene documentos asociados --}}
                                        @if ($persona->documento->count())
                                            <?php $cn = 0;
                                            $estado = 0; ?>
                                            {{-- recorre documentos de la persona --}}
                                            @foreach ($persona->documento as $doc_persona)
                                                {{-- valida si persona tiene el documento actual --}}
                                                @if ($doc_persona->pivot->documento_id == $documento->id)
                                                    <?php
                                                    $cn++;
                                                    if ($cn > 0) {
                                                        $fc_fin = $doc_persona->pivot->fc_fin;
                                                        $estado = $doc_persona->pivot->estado;
                                                    }
                                                    ?>
                                                @endif
                                            @endforeach
                                            {{-- muestra fecha --}}
                                            @if ($cn > 0)
                                                @if ($estado == 0)
                                                    <?php
                                                    $diff = $fecha->diffFechaActual($fc_fin);
                                                    $fc_fin = $fecha->formatodmY($fc_fin);
                                                    ?>
                                                    @if ($diff <= $flag_red)
                                                        <td class="border border-secondary align-middle text-center"
                                                            style="background-color: red">
                                                            <a class="btn btn-xs" style="background-color: red"
                                                                href="{{ route('admin.personas.show', $persona) }}">{{ $fc_fin }}</a>
                                                        </td>
                                                        <?php $cn_red++; ?>
                                                    @elseif($diff > $flag_red && $diff < $flag_orange)
                                                        <td class="border border-secondary align-middle text-center"
                                                            style="background-color: orange">
                                                            <a class="btn btn-xs" style="background-color: orange"
                                                                href="{{ route('admin.personas.show', $persona) }}">{{ $fc_fin }}</a>
                                                        </td>
                                                        <?php $cn_orange++; ?>
                                                    @elseif($diff > $flag_orange && $diff < $flag_yellow)
                                                        <td class="border border-secondary align-middle text-center"
                                                            style="background-color: yellow">
                                                            <a class="btn btn-xs" style="background-color: yellow"
                                                                href="{{ route('admin.personas.show', $persona) }}">{{ $fc_fin }}</a>
                                                        </td>
                                                        <?php $cn_yellow++; ?>
                                                    @else
                                                        <td class="border border-secondary align-middle text-center"
                                                            style="background-color: green">
                                                            <a class="btn btn-xs" style="background-color: green"
                                                                href="{{ route('admin.personas.show', $persona) }}">{{ $fc_fin }}</a>
                                                        </td>
                                                        <?php $cn_green++; ?>
                                                    @endif
                                                @else
                                                    <td class="border border-secondary align-middle text-center"
                                                        style="background-color: black">
                                                        <a class="btn btn-xs"
                                                            style="background-color: black; color: white"
                                                            href="{{ route('admin.personas.show', $persona) }}">
                                                            @if ($fc_fin == null)
                                                                Pendiente    
                                                            @else
                                                                {{$fc_fin}}
                                                            @endif
                                                            </a>
                                                    </td>
                                                    <?php $cn_pendiente++; ?>
                                                @endif
                                            @else
                                                <?php $arr = $rangoDocumento->getExisteDocumentoRango($docs_rango, $documento->id, $persona->rango_id); ?>
                                                <td class="border border-secondary align-middle text-center">
                                                    @if ($arr != [])
                                                        @if ($arr['obligatorio'] == 1)
                                                            <a class="btn btn-primary btn-xs"
                                                                href="{{ route('admin.personas.show', $persona) }}">+</a>
                                                            {{-- @else
                                            op --}}
                                                        @endif
                                                    @endif
                                                </td>
                                            @endif
                                        @else
                                            <?php $arr = $rangoDocumento->getExisteDocumentoRango($docs_rango, $documento->id, $persona->rango_id); ?>
                                            <td class="border border-secondary align-middle text-center">
                                                @if ($arr != [])
                                                    @if ($arr['obligatorio'] == 1)
                                                        <a class="btn btn-primary btn-xs"
                                                            href="{{ route('admin.personas.show', $persona) }}">+</a>
                                                        {{-- @else
                                        op --}}
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
                            ?>
                        </tbody>
                    </table>
                    {{-- @livewire('admin.create-persona') --}}
                    <div>
                        <div wire:ignore.self class="modal fade" id="modalCreatePersona" tabindex="-1" role="dialog"
                            aria-labelledby="modalCreatePersonaTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <form>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalCreatePersonaTitle">Editar Personal</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div style="height:620px;">



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
                                                    <input wire:model="fc_nacimiento" type="date"
                                                        class="form-control">
                                                    @error('fc_nacimiento')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="fc_ingreso" class="form-label">Fecha de
                                                        Ingreso</label>
                                                    <input wire:model="fc_ingreso" type="date"
                                                        class="form-control">
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
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card-body">
                    <strong>No hay ningún registro...</strong>
                </div>
            @endif
        </div>
    @else
        <div class="text-3xl text-red">
            {{-- <i class="fas fa-spinner animate-spin"></i>  --}}
            Procesando...
        </div>
    @endif
</div>
