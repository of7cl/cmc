@extends('adminlte::page')

@section('title', 'Crear Tipo de Nave')

@section('content_header')        
    <h1>Crear Tipo de Nave</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    <div class="card">        
        <div class="card-body">
            
            {!! Form::open(['route' => 'admin.ship_tipos.store']) !!}
                @include('admin.ship_tipos.partials.form')                
                {{-- {!! Form::submit('Crear Tipo de Nave', ['class' => 'btn btn-primary']) !!} --}}
                <input type="submit" value="Crear Tipo de Nave" class="btn btn-primary" onclick="this.disabled=true;this.form.submit();">
            {!! Form::close() !!}
            

        </div>

        {{-- <div class="mb-4">
            {{$rangos->links()}}
        </div> --}}
        
    </div>
@stop

