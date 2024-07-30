@extends('adminlte::page')

@section('title', 'Editar Nave')

@section('content_header')
    <h1>Editar Nave</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">

        <div class="card-body">

            {!! Form::model($ship, ['route' => ['admin.ships.update', $ship], 'method' => 'put']) !!}
            <div class="form-group">
                {!! Form::label('codigo', 'Código') !!}
                {!! Form::text('codigo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese código de nave']) !!}
                @error('codigo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('nombre', 'Nombre') !!}
                {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Ingrese nombre de nave']) !!}
                @error('nombre')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('ship_tipo_id', 'Tipo') !!}
                {!! Form::select('ship_tipo_id', $ship_tipos, null, [
                    'class' => 'form-control',
                    'placeholder' => 'Seleccionar Tipo...',
                ]) !!}
                @error('ship_tipo_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('imo', 'IMO') !!}
                {!! Form::text('imo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese IMO de nave']) !!}
                @error('imo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('dwt', 'DWT') !!}
                {!! Form::text('dwt', null, ['class' => 'form-control', 'placeholder' => 'Ingrese DWT de nave']) !!}
                @error('dwt')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('trg', 'TRG') !!}
                {!! Form::text('trg', null, ['class' => 'form-control', 'placeholder' => 'Ingrese TRG de nave']) !!}
                @error('trg')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('loa', 'LOA') !!}
                {!! Form::text('loa', null, ['class' => 'form-control', 'placeholder' => 'Ingrese LOA de nave']) !!}
                @error('loa')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('manga', 'MANGA') !!}
                {!! Form::text('manga', null, ['class' => 'form-control', 'placeholder' => 'Ingrese MANGA de nave']) !!}
                @error('manga')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('estado', '¿Activo?') !!}
                <label class="ml-2">

                    @if ($ship->estado == 1)
                        {!! Form::checkbox('estado', 1, true) !!}
                    @else
                        {!! Form::checkbox('estado', 2, false) !!}
                    @endif


                </label>
            </div>
            {!! Form::submit('Editar Nave', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}


        </div>

    </div>
@stop
