@extends('adminlte::page')

@section('title', 'Editar Personal')

@section('content_header')        
    <h1>Editar Personal</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    <div class="card-body">

        {!! Form::model($persona, ['route' => ['admin.personas.update', $persona], 'method' => 'put']) !!}
                {{-- @include('admin.personas.partials.form')                                --}}
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
                {!! Form::submit('Editar Persona', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
    
    </div>

    
@stop