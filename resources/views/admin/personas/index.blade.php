@extends('adminlte::page')

@section('title', 'Personal')

@section('content_header') 
    @can('mantencion.personas.create')
        <a class="btn btn-secondary btn-sm float-right" href="{{route('admin.personas.create')}}">Nuevo Personal</a>    
    @endcan       
    <h1>Lista del Personal</h1>
@stop

@section('content')    
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    @livewire('admin.personas-index')
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

    Livewire.on('delPersona', PersonaId => {
            
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
                Livewire.emit('deletePersona', PersonaId);
                    Swal.fire({
                    title: "Eliminada!",
                    text: "Persona ha sido eliminada con exito.",
                    icon: "success"
                    });
                //this.submit();
            }
        });
    })
    
     
    </script>
@endsection