@extends('adminlte::page')

@section('title', 'Editar Tipo de Nave')

@section('content_header')
    <h1>Editar Tipo de Nave</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-body">

            {!! Form::model($ship_tipo, ['route' => ['admin.ship_tipos.update', $ship_tipo], 'method' => 'put']) !!}
            <div class="form-group">
                {!! Form::label('nombre', 'Nombre') !!}
                {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Ingrese nombre de tipo de nave']) !!}
                @error('nombre')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('estado', '¿Activo?') !!}
                <label class="ml-2">

                    @if ($ship_tipo->estado == 1)
                        {!! Form::checkbox('estado', 1, true) !!}
                    @else
                        {!! Form::checkbox('estado', 2, false) !!}
                    @endif


                </label>
            </div>
            {!! Form::submit('Editar Tipo de Nave', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}


        </div>

        {{-- <div class="mb-4">
            {{$rangos->links()}}
        </div> --}}

    </div>
@stop
