@extends('adminlte::page')

@section('title', 'Nuevo Personal')

@section('content_header')        
    <h1>Crear Personal</h1>
@stop

@section('content')
    <div class="card-body">

        {!! Form::open(['route' => 'admin.personas.store']) !!}            
            
            {{-- @include('admin.personas.partials.form') --}}
            <div class="form-group">
                {!! Form::label('nombre', 'Nombre') !!}
                {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Ingrese nombre del personal']) !!}
                @error('nombre')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('rut', 'RUT') !!}
                {!! Form::text('rut', null, ['class' => 'form-control', 'placeholder' => 'Ingrese RUT del personal']) !!}
                @error('rut')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('rango_id', 'Rango') !!}
                {!! Form::select('rango_id', $rangos, null, ['class' => 'form-control', 'placeholder' => 'Ingresar Rango...']) !!}
                @error('rango_id')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('ship_id', 'Nave') !!}
                {!! Form::select('ship_id', $ships, null, ['class' => 'form-control', 'placeholder' => 'Ingresar Nave...']) !!}
                @error('ship_id')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>            
            <div class="form-group">
                {!! Form::label('fc_nacimiento', 'Fecha de Nacimiento') !!}
                {{ Form::date('fc_nacimiento', null, ['class' => 'form-control']) }}
                @error('fc_nacimiento')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('fc_ingreso', 'Fecha de Ingreso') !!}
                {{ Form::date('fc_ingreso', null, ['class' => 'form-control']) }}
                @error('fc_ingreso')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('fc_baja', 'Fecha de Baja') !!}
                {{ Form::date('fc_baja', null, ['class' => 'form-control']) }}
                @error('fc_baja')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            {!! Form::submit('Crear Personal', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}

        
    </div>

    
@stop