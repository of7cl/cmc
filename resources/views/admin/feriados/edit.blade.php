@extends('adminlte::page')

@section('title', 'Editar Feriado')

@section('content_header')
    <h1>Editar Feriado</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">

        <div class="card-body">

            {!! Form::model($feriado, ['route' => ['admin.feriados.update', $feriado], 'method' => 'put']) !!}
            <div class="form-group">
                {!! Form::label('fc_feriado', 'Fecha de Feriado') !!}
                {{ Form::date('fc_feriado', null, ['class' => 'form-control']) }}
                @error('fc_feriado')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('descripcion', 'Descripción') !!}
                {!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Ingrese descripción de feriado']) !!}
                @error('descripcion')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('estado', '¿Activo?') !!}
                <label class="ml-2">

                    @if ($feriado->estado == 1)
                        {!! Form::checkbox('estado', 1, true) !!}
                    @else
                        {!! Form::checkbox('estado', 2, false) !!}
                    @endif


                </label>
            </div>
            {!! Form::submit('Editar Feriado', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}


        </div>

    </div>
@stop
