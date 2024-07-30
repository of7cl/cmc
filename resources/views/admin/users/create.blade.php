@extends('adminlte::page')

@section('title', 'Agregar Usuario')

@section('content_header')
    <h1>Agregar Usuario</h1>
@stop

@section('content')
    
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'admin.users.store']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Nombre') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese nombre de usuario']) !!}
                    @error('name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Correo') !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese correo electrónico']) !!}
                    @error('email')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('password', 'Contraseña') !!}
                    {!! Form::password('password',  ['class' => 'form-control', 'placeholder' => 'Ingrese contraseña']) !!}
                    @error('password')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Confirmar Contraseña') !!}
                    {!! Form::password('password_confirmation',  ['class' => 'form-control', 'placeholder' => 'Repita contraseña']) !!}
                    @error('password_confirmation')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                @foreach ($roles as $role)
                    <div>
                        <label>
                            {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'mr-1']) !!}
                            {{$role->name}}
                        </label>
                    </div>
                @endforeach
                {!! Form::submit('Agregar Usuario', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop