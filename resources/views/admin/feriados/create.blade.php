@extends('adminlte::page')

@section('title', 'Nuevo Feriado')

@section('content_header')
    <h1>Crear Feriado</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'admin.feriados.store', 'autocomplete' => 'off']) !!}

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

            <input type="submit" value="Crear Feriado" class="btn btn-primary" onclick="this.disabled=true;this.form.submit();">
            
            {{-- {!! Form::submit('Crear Feriado', ['class' => 'btn btn-primary']) !!} --}}
            {!! Form::close() !!}
        </div>
    </div>

@stop

@section('js')
    
@endsection
