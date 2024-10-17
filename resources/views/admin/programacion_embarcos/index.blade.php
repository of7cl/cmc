@extends('adminlte::page')

@section('title', 'Programación de Embarcos')

@section('content_header')
    <h1>Programación de Embarcos</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    @livewire('admin.programacion-embarcos')
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
    
        Livewire.on('position', function(message) {
                 
        })    

        Livewire.on('agregarProgramacion', function(message) {
            Swal.fire({
                //title: "OK!",
                text: message,
                icon: "success",
                showConfirmButton: true
            });
            $('#modalAgregarProgramacion').modal('hide')
        })
           
    </script>
@endsection
