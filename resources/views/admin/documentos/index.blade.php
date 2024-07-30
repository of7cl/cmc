@extends('adminlte::page')

@section('title', 'Documentos')

@section('content_header') 
    @can('mantencion.documentos.create')
        <a class="btn btn-secondary btn-sm float-right" href="{{route('admin.documentos.create')}}">Nuevo Documento</a>    
    @endcan       
    <h1>Lista de Documentos</h1>
@stop

@section('content')    
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    @livewire('admin.documentos-index')
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('delDocumento', DocumentoId => {
            
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
                    Livewire.emit('deleteDocumento', DocumentoId);
                        Swal.fire({
                        title: "Eliminado!",
                        text: "Documento ha sido eliminado con exito.",
                        icon: "success"
                        });
                    //this.submit();
                }
            });
        })
        /* $('.formulario-eliminar').submit(function(e){            
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
                    this.submit();
                }
            });
        }) */

        
    </script>
@endsection