@extends('adminlte::page')

@section('title', 'Nuevo Documento')

@section('content_header')        
    <h1>Crear Documento</h1>
@stop

@section('content')
    <div class="card-body">

        {!! Form::open(['route' => 'admin.documentos.store']) !!}            
            
            @include('admin.documentos.partials.form')            

            {!! Form::submit('Crear Documento', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}

        
    </div>

    
@stop