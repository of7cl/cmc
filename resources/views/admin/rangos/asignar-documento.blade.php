@extends('adminlte::page')

@section('title', 'Editar Rango')

@section('content_header')        
    <h1>Asignar Documento a Rango "{{$rango->nombre}}"</h1> 
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    <div class="card">        
        <div class="card-body">
            
            {!! Form::model($rango, ['route' => ['admin.rangos.update', $rango], 'method' => 'put']) !!}
                {!! Form::hidden('opcion', 'docs') !!}
                @include('admin.rangos.partials.form-asignar-documento')                               
                {!! Form::submit('Editar Rango', ['class' => 'btn btn-primary']) !!}                
            {!! Form::close() !!}
            

        </div>

        {{-- <div class="mb-4">
            {{$rangos->links()}}
        </div> --}}
        
    </div>
@stop

