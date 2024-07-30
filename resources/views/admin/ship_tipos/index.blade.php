@extends('adminlte::page')

@section('title', 'Tipos de Nave')

@section('content_header')
    <a class="btn btn-secondary btn-sm float-right" href="{{ route('admin.ship_tipos.create') }}">Nuevo Tipo</a>
    <h1>Lista de Tipos de Naves</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    @livewire('admin.ship-tipos-index')
    
@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('delTipoNave', ShipTipoId => {
            
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
                    Livewire.emit('deleteTipoNave', ShipTipoId);
                        Swal.fire({
                        title: "Eliminada!",
                        text: "Tipo de Nave ha sido eliminada con exito.",
                        icon: "success"
                        });
                    //this.submit();
                }
            });
        })
        /* $('.formulario-eliminar').submit(function(e) {
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
