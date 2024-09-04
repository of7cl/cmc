@extends('adminlte::page')

@section('title', 'Documentos Tipo Nave')

@section('content_header')
    {{-- <a class="btn btn-secondary btn-sm float-right" href="{{route('admin.rangos.asignar-documento', $persona)}}">Asignar Documento</a> --}}
    <h1>Documentos de Tipo Nave "{{ $ship_tipo->nombre }}"</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    @livewire('admin.ship-tipo-documentos', ['ship_tipo' => $ship_tipo])
@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('deleteDoc', docId => {

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
                    Livewire.emit('deleteDocumento', docId);
                    Swal.fire({
                    title: "Eliminado!",
                    text: "Documento ha sido eliminado con exito.",
                    icon: "success"
                    });
                }
            });
        })
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('alert', function(message) {
            Swal.fire({
                //title: message,
                text: message,
                icon: "success",
                showConfirmButton: true
            });                        
            $('#modalAsignarRango').modal('hide')          
        })        
    </script>

@endsection
