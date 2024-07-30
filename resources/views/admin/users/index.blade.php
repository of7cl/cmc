@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <a class="btn btn-secondary btn-sm float-right" href="{{ route('admin.users.create') }}">Agregar Usuario</a>
    <h1>Lista de Usuarios</h1>
@stop

@section('content')
    <div class="card">
        {{-- <div class="card-header">
            <a class="btn btn-primary" href="{{route('admin.users.create')}}">Agregar Usuario</a>
        </div> --}}
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th colspan="2"></th>
                        {{-- <th colspan="2"></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td width="110px">
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.users.edit', $user) }}">Editar</a>
                            </td>
                            <td width="200px">
                                @if (!$user->hasRole('Administrador') || $user->id == auth()->user()->id)                                    
                                    <a class="btn btn-success btn-sm"
                                        href="{{ route('admin.users.change_password', $user) }}">Cambiar Contraseña</a>
                                @endif                                
                            </td>
                            {{-- <td width="10px">
                                <form action="{{route('admin.users.destroy', $user)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@stop
