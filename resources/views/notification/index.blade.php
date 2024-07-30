<?php
use App\Models\Persona;
?>

@extends('adminlte::page')
@section('title', 'Notificaciones')
@section('pagina', 'Notificaciones')
@section('content_header')
    <h1>Notificaciones</h1>
@stop
@section('content')
    @livewire('admin.notificaciones-index') 
    {{-- <div class="row">
        <div class="col-md-12">
            @if (count($notifications) > 0)
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('notification.update_unreaded') }}"><i
                                class="far fa-envelope-open mr-3"></i> Marcar todas las notificaciones como leídas</a>
                    </div>
                    <div class="card-body">
                        @foreach ($notifications as $notification)
                            <?php
                            //$persona = Persona::find($notification->codigo);
                            ?>
                            <div class="callout callout-{{ $notification->alert }}">
                                <div class="row justify-content-between">
                                    <div class="col-sm-12 col-md-12 col-lg-8">
                                        <h5><i class="{{ $notification->icon }}"></i> {{ $notification->text }}</h5>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-2">
                                        <p>{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-1">
                                        <span class="badge badge-{{ $notification->readed ? 'success' : 'warning' }}">
                                            {{ $notification->readed ? 'Leída' : 'No leída' }}
                                            @if ($notification->readed)
                                                {{ $notification->updated_at->diffForHumans() }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-1">                                        
                                        <a href="{{ route('admin.personas.show', $persona) }}" class="badge badge-success" role="button" style="text-decoration: none;">Revisar</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{ $notifications->links() }}
                    </div>
                </div>
            @else
                <div class="callout callout-info">
                    <div class="row justify-content-between">
                        <h5>Ninguna notificación encontrada!</h5>
                    </div>
                </div>
            @endif
        </div>
    </div> --}}
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    
    <script>
        Livewire.on('alert_upd_doc', function(message) {
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
                    Livewire.emit('update_doc', 1);
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