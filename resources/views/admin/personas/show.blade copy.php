<?php
use App\Http\Controllers\CarbonController;
use App\Http\Controllers\Admin\ParameterDocController;

$fecha = new CarbonController();

$parameterdocs = new ParameterDocController();
$parameters = $parameterdocs->getParameterDocs();
$flag_red = $parameters[0]['flag_red'];
$flag_orange = $parameters[0]['flag_orange'];
$flag_yellow = $parameters[0]['flag_yellow'];
$flag_green = $parameters[0]['flag_green'];

?>

@extends('adminlte::page')

@section('title', 'Documentos Rango')

@section('content_header')
    {{-- <a class="btn btn-secondary btn-sm float-right" href="{{route('admin.rangos.asignar-documento', $persona)}}">Asignar Documento</a> --}}
    <h1>Documentos de "{{ $persona->nombre }}"</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">
        @if ($rango_documentos)
            <div class="card-body table-responsive">

                {{-- {{$rango_documentos}} --}}
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>N° Curso</th>
                            <th>Código OMI</th>
                            <th>Nombre</th>
                            {{-- <th>Name</th> --}}
                            <th>¿Obligatorio?</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th colspan="1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rango_documentos as $rango_documento)
                            <tr>
                                {!! Form::model($persona, ['route' => ['admin.personas.update', $persona], 'method' => 'put']) !!}
                                <td>
                                    {{ $rango_documento->id }}
                                </td>
                                <td>{{ $rango_documento->nr_documento }}</td>
                                <td>{{ $rango_documento->codigo_omi }}</td>
                                <td>{{ $rango_documento->nombre }}</td>
                                {{-- <td>{{$rango_documento->name}}</td> --}}
                                <td>
                                    @if ($rango_documento->pivot->obligatorio == 1)
                                        Si
                                    @else
                                        No
                                    @endif
                                </td>
                                <td>
                                    <?php $fc_inicio = null; ?>
                                    @foreach ($persona->documento as $documento)
                                        @if ($documento->pivot->documento_id == $rango_documento->id)
                                            <?php $fc_inicio = $documento->pivot->fc_inicio; ?>
                                        @endif
                                    @endforeach
                                    {{ Form::date('fc_inicio' . $rango_documento->id, $fc_inicio, ['class' => 'form-control']) }}
                                    @error('fc_inicio' . $rango_documento->id)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <?php
                                    $fc_fin = null;
                                    ?>
                                    @foreach ($persona->documento as $documento)
                                        @if ($documento->pivot->documento_id == $rango_documento->id)
                                            <?php
                                            $fc_fin = $documento->pivot->fc_fin;
                                            $diff = $fecha->diffFechaActual($fc_fin);
                                            ?>
                                        @endif
                                    @endforeach
                                    @if ($fc_fin != null)
                                        @if ($diff <= $flag_red)
                                            {{ Form::date('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control callout', 'style' => 'border-left-color: red']) }}
                                        @elseif($diff > $flag_red && $diff < $flag_orange)
                                            {{ Form::date('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control callout', 'style' => 'border-left-color: orange']) }}
                                        @elseif($diff > $flag_orange && $diff < $flag_yellow)
                                            {{ Form::date('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control callout', 'style' => 'border-left-color: yellow']) }}
                                        @else
                                            {{ Form::date('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control callout', 'style' => 'border-left-color: green']) }}
                                        @endif
                                    @else
                                        {{ Form::date('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control']) }}
                                    @endif
                                    @error('fc_fin' . $rango_documento->id)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td width="10px">
                                    {{ csrf_field() }}
                                    {!! Form::hidden('opcion', 'upd_doc') !!}
                                    {{-- {!! Form::hidden('upd_doc_'.$rango_documento->id, $rango_documento->id) !!}                                     --}}
                                    {!! Form::submit('Actualizar', ['class' => 'btn btn-success btn-sm']) !!}
                                    <input type="hidden" value="{{ $rango_documento->id }}" id="documento_id"
                                        name="documento_id" />

                                </td>
                                {!! Form::close() !!}
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        @else
            <div class="card-body">
                <strong>No hay ningún registro...</strong>
            </div>
        @endif
    </div>
@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.formulario-eliminar').submit(function(e) {
            e.preventDefault();

            Swal.fire({
                title: "¿Estás Seguro?",
                text: "",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Si, Eliminar!",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    /* Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                    }); */
                    this.submit();
                }
            });
        })
    </script>
@endsection
