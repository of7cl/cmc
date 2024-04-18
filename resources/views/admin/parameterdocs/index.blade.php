@extends('adminlte::page')

@section('title', 'Parámetros')

@section('content_header')    
    {{-- <a class="btn btn-secondary btn-sm float-right" href="{{route('admin.rangos.create')}}">Nuevo Rango</a> --}}
    <h1>Lista de Parámetros Control Documentos</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    <div class="card">        
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Flag Rojo</th>
                        <th>Flag Amarillo</th>
                        <th>Flag Verde</th>                        
                        <th colspan="3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parameterdocs as $parameterdoc)
                        <tr>
                            <td>{{$parameterdoc->id}}</td>
                            <td>{{$parameterdoc->flag_red}} Días</td>
                            <td>{{$parameterdoc->flag_yellow}} Días</td>
                            <td>{{$parameterdoc->flag_green}} Días</td>                                                       
                            <td width="10px">
                                <a class="btn btn-primary btn-sm" href="{{route('admin.parameterdocs.edit', $parameterdoc)}}">Editar</a>
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