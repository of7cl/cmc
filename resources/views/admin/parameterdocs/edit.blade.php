@extends('adminlte::page')

@section('title', 'Editar Parámetros')

@section('content_header')
    <h1>Editar Parámetros Control Documentos</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-body">

            {!! Form::model($parameterdoc, ['route' => ['admin.parameterdocs.update', $parameterdoc], 'method' => 'put']) !!}
            <div class="form-group">
                {!! Form::label('flag_red', 'Flag Rojo (# Días)') !!}
                {!! Form::text('flag_red', null, ['class' => 'form-control', 'placeholder' => 'Ingrese parámetro para Flag Rojo']) !!}
                @error('flag_red')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('flag_orange', 'Flag Naranjo (# Días)') !!}
                {!! Form::text('flag_orange', null, ['class' => 'form-control', 'placeholder' => 'Ingrese parámetro para Flag Naranjo']) !!}
                @error('flag_orange')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('flag_yellow', 'Flag Amarillo (# Días)') !!}
                {!! Form::text('flag_yellow', null, ['class' => 'form-control', 'placeholder' => 'Ingrese parámetro para Flag Amarillo']) !!}
                @error('flag_yellow')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('flag_green', 'Flag Verde (# Días)') !!}
                {!! Form::text('flag_green', null, ['class' => 'form-control', 'placeholder' => 'Ingrese parámetro para Flag Verde']) !!}
                @error('flag_green')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>                   
            {!! Form::submit('Editar Parámetros', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}


        </div>

        {{-- <div class="mb-4">
            {{$rangos->links()}}
        </div> --}}

    </div>
@stop
