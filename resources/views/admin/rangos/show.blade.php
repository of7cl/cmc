@extends('adminlte::page')

@section('title', 'Documentos Rango')

@section('content_header')
    <a class="btn btn-secondary btn-sm float-right" href="{{route('admin.rangos.asignar-documento', $rango)}}">Asignar Documento</a>
    <h1>Lista de Documentos del Rango "{{$rango->nombre}}"</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    <div class="card">        
        @if ($rango->documentos->count())
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>N° Curso</th>
                            <th>Código OMI</th>                        
                            <th>Nombre</th>                        
                            <th>Name</th>
                            <th>¿Obligatorio?</th>
                            <th colspan="1"></th>
                        </tr>
                    </thead>
                    <tbody>                        
                        @foreach ($rango->documentos as $rango_documento)
                        <tr>
                            <td>{{$rango_documento->id}}</td>
                            <td>{{$rango_documento->nr_documento}}</td>
                            <td>{{$rango_documento->codigo_omi}}</td>                            
                            <td>{{$rango_documento->nombre}}</td>                            
                            <td>{{$rango_documento->name}}</td>                      
                            <td>
                                @if ($rango_documento->pivot->obligatorio==1)
                                    Si
                                @else
                                    No
                                @endif
                            </td>
                            <td width="10px">          
                                {{-- <form action="{{route('admin.rangos.destroy', $rango)}}" method="POST" class="formulario-eliminar">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-success btn-sm" type="submit">Eliminar</button>
                                </form>  --}}                     
                                {!! Form::model($rango, ['route' => ['admin.rangos.update', $rango], 'class' => 'formulario-eliminar','method' => 'put']) !!}
                                    {!! Form::hidden('opcion', 'del_doc') !!}                                    
                                    {!! Form::hidden('doc_id', $rango_documento->id) !!}                                    
                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger btn-sm']) !!}                
                                {!! Form::close() !!}
                            </td> 
                        </tr>
                        @endforeach                                                                
                    </tbody>
                </table>
            </div>
        @else
            <div class="card-body">
                <strong>No hay ningún registro...</strong>            
            </div>                
        @endif
        
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