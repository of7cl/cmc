@extends('adminlte::page')

@section('title', 'Control Documentos')

{{-- @section('content_header')
    <h1>Control de Documentos</h1>
@stop --}}

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    {{-- @livewire('admin.control-documentos-index') --}}
    @livewire('admin.control-docs')
    {{-- <livewire:admin.control-docs lazy/> --}}

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
@endsection
