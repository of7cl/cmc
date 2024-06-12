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
