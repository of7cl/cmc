@extends('adminlte::page')

@section('title', 'Control de Trayectoria')

@section('content_header')
    <h1>Control de Trayectoria</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    @livewire('admin.control-trayectoria-show', ['persona' => $persona])
    {{-- <livewire:admin.control-trayectoria-show :persona="$persona"> --}}

@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('alert', function(message) {
            Swal.fire({
                //title: "OK!",
                text: message,
                icon: "success",
                showConfirmButton: true
            });
            $('#modalCreatePersona').modal('hide')
        })
    
        Livewire.on('detalle', function(message) {
            Swal.fire({
                //title: "OK!",
                text: message,
                icon: "success",
                showConfirmButton: true
            });
            $('#modalAgregarDetalle').modal('hide')
        })

        Livewire.on('updateDetalle', function(message) {
            Swal.fire({
                //title: "OK!",
                text: message,
                icon: "success",
                showConfirmButton: true
            });
            $('#modalEditDetalle').modal('hide')
        })

        Livewire.on('ajuste', function(message) {
            Swal.fire({
                //title: "OK!",
                text: message,
                icon: "success",
                showConfirmButton: true
            });
            $('#modalAjusteInicial').modal('hide')
        })

        Livewire.on('validacion', function(message) {
            Swal.fire({
                //title: "OK!",
                text: message,
                icon: "warning",
                showConfirmButton: true
            });
            //$('#modalAgregarDetalle').modal('hide')
        })

        Livewire.on('delDetalle', DetalleId => {
            
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
                    Livewire.emit('deleteDetalle', DetalleId);
                        Swal.fire({
                        title: "Eliminado!",
                        text: "Detalle ha sido eliminado con exito.",
                        icon: "success"
                        });
                    //this.submit();
                }
            });
        })
    </script>

    {{-- <script type="text/javascript">
        var mostrarDetalle = true;
        $(document).ready(function() {
            $('#btnDetalle').on('click', function() {
                if (mostrarDetalle == true) {
                    $('#divDetalle').hide();
                    mostrarDetalle = false;
                } else {
                    $('#divDetalle').show();
                    mostrarDetalle = true;
                }
            })
        });

        var mostrarCabecera = true;
        $(document).ready(function() {
            $('#btnCabecera').on('click', function() {
                if (mostrarCabecera == true) {
                    $('#divCabecera').hide();                        
                    mostrarCabecera = false;
                } else {
                    $('#divCabecera').show();
                    mostrarCabecera = true;
                }
            })
        });
    </script> --}}
@endsection
