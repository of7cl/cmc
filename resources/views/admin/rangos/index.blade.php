@extends('adminlte::page')

@section('title', 'Rangos')

@section('content_header')    
    <a class="btn btn-secondary btn-sm float-right" href="{{route('admin.rangos.create')}}">Nuevo Rango</a>
    <h1>Lista de Rangos</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    <div class="card">
        {{-- <div class="card-header">
            <a class="btn btn-primary" href="{{route('admin.users.create')}}">Agregar Usuario</a>
        </div> --}}
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        {{-- <th>Nombre Completo</th> --}}
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rangos as $rango)
                        <tr>
                            <td>{{$rango->id}}</td>
                            <td>{{$rango->codigo}}</td>
                            <td>{{$rango->nombre}}</td>
                            {{-- <td>{{$rango->nombre_completo}}</td> --}}
                            <td width="10px">
                                <a class="btn btn-primary btn-sm" href="{{route('admin.rangos.edit', $rango)}}">Editar</a>
                            </td>
                            <td width="10px">
                                <form action="{{route('admin.rangos.destroy', $rango)}}" method="POST" class="formulario-eliminar">
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