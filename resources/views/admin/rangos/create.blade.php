@extends('adminlte::page')

@section('title', 'Nuevo Rango')

@section('content_header')        
    <h1>Crear Rango</h1>
@stop

@section('content')
    <div class="card">
        {{-- <div class="card-header">
            <a class="btn btn-primary" href="{{route('admin.users.create')}}">Agregar Usuario</a>
        </div> --}}
        <div class="card-body">
            
            {!! Form::open(['route' => 'admin.rangos.store']) !!}
                @include('admin.rangos.partials.form')                
                {{-- {!! Form::submit('Crear Rango', ['class' => 'btn btn-primary']) !!} --}}
                <input type="submit" value="Crear Rango" class="btn btn-primary" onclick="this.disabled=true;this.form.submit();">
            {!! Form::close() !!}
            

        </div>

        {{-- <div class="mb-4">
            {{$rangos->links()}}
        </div> --}}
        
    </div>
@stop

