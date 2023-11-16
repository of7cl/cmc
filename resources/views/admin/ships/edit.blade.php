@extends('adminlte::page')

@section('title', 'Editar Nave')

@section('content_header')        
    <h1>Editar Nave</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    <div class="card">
        
        <div class="card-body">
            
            {!! Form::model($ship, ['route' => ['admin.ships.update', $ship], 'method' => 'put']) !!}
                @include('admin.ships.partials.form')                               
                {!! Form::submit('Editar Nave', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
            

        </div>
        
    </div>
@stop