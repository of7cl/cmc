@extends('adminlte::page')

@section('title', 'Naves')

@section('content_header')    
    <a class="btn btn-secondary btn-sm float-right" href="{{route('admin.naves.create')}}">Nueva Nave</a>
    <h1>Lista de Naves</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    <div class="card">        
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>IMO</th>
                        <th>DWT</th>
                        <th>TRG</th>
                        <th>LOA</th>
                        <th>MANGA</th>
                        {{-- <th>Descripción</th> --}}
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($naves as $nave)
                        <tr>
                            <td>{{$nave->id}}</td>
                            <td>{{$nave->codigo}}</td>
                            <td>{{$nave->nombre}}</td>
                            <td>{{$nave->imo}}</td>
                            <td>{{$nave->dwt}}</td>
                            <td>{{$nave->trg}}</td>
                            <td>{{$nave->loa}}</td>
                            <td>{{$nave->manga}}</td>
                            {{-- <td>{{$nave->descripcion}}</td> --}}
                            <td width="10px">
                                <a class="btn btn-primary btn-sm" href="{{route('admin.naves.edit', $nave)}}">Editar</a>
                            </td>
                            <td width="10px">
                                <form action="{{route('admin.naves.destroy', $nave)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach  
                </tbody>
            </table>

            

        </div>

        {{-- <div class="mb-4">
            {{$rangos->links()}}
        </div> --}}
        
    </div>
@stop

