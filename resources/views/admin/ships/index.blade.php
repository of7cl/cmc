@extends('adminlte::page')

@section('title', 'Naves')

@section('content_header')    
    <a class="btn btn-secondary btn-sm float-right" href="{{route('admin.ships.create')}}">Nueva Nave</a>
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
                    @foreach ($ships as $ship)
                        <tr>
                            <td>{{$ship->id}}</td>
                            <td>{{$ship->codigo}}</td>
                            <td>{{$ship->nombre}}</td>
                            <td>{{$ship->imo}}</td>
                            <td>{{$ship->dwt}}</td>
                            <td>{{$ship->trg}}</td>
                            <td>{{$ship->loa}}</td>
                            <td>{{$ship->manga}}</td>
                            {{-- <td>{{$nave->descripcion}}</td> --}}
                            <td width="10px">
                                <a class="btn btn-primary btn-sm" href="{{route('admin.ships.edit', $ship)}}">Editar</a>
                            </td>
                            <td width="10px">
                                <form action="{{route('admin.ships.destroy', $ship)}}" method="POST" class="formulario-eliminar">
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
        
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        $('.formulario-eliminar').submit(function(e){            
            e.preventDefault();  
            
            Swal.fire({
            title: "¿Estás Seguro?",
            text: "",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "¡Si, Eliminar!",
            cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    /* Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                    }); */
                    this.submit();
                }
            });
        })

        
    </script>
@endsection