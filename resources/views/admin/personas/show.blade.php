

@extends('adminlte::page')

@section('title', 'Documentos Rango')

@section('content_header')
    {{-- <a class="btn btn-secondary btn-sm float-right" href="{{route('admin.rangos.asignar-documento', $persona)}}">Asignar Documento</a> --}}
    <h1>Documentos de "{{ $persona->nombre }}"</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    @livewire('admin.persona-documentos', ['persona' => $persona])
@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.formulario-eliminar').submit(function(e) {
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('alert', function(message) {
            Swal.fire({
                //title: "OK!",
                text: message,
                icon: "success",
                showConfirmButton: true
            });                        
            $('#modalEditDocPersona').modal('hide')          
        })     
        
        Livewire.on('confirmEdit', PersonaId => {
            
            Swal.fire({
                title: "No has ingresado documento. ¿Deseas continuar?",
                text: "",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Si, Editar!",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('update', 1);
                        /* Swal.fire({
                        title: "Eliminada!",
                        text: "Persona ha sido eliminada con exito.",
                        icon: "success"
                        }); */
                    //this.submit();
                }
            });
        })
    </script>

@endsection
