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
    @livewire('admin.rangos-index')    
@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('delRango', RangoId => {
            
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
                    Livewire.emit('deleteRango', RangoId);
                        Swal.fire({
                        title: "Eliminado!",
                        text: "Rango ha sido eliminado con exito.",
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