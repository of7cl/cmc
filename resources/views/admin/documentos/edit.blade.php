@extends('adminlte::page')

@section('title', 'Nuevo Documento')

@section('content_header')        
    <h1>Editar Documento</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    <div class="card-body">
        
        {!! Form::model($documento, ['route' => ['admin.documentos.update', $documento], 'method' => 'put']) !!}    
            
            @include('admin.documentos.partials.form')            

            {!! Form::submit('Editar Documento', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}

        
    </div>

    
@stop