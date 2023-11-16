@extends('adminlte::page')

@section('title', 'Nueva Nave')

@section('content_header')        
    <h1>Crear Nave</h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            
            {!! Form::open(['route' => 'admin.naves.store']) !!}
                @include('admin.naves.partials.form')                
                {!! Form::submit('Crear Nave', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
            

        </div>
        
    </div>
@stop
