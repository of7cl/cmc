@extends('adminlte::page')

@section('title', 'Naves')

@section('content_header')    
    <a class="btn btn-secondary btn-sm float-right" href="{{route('admin.ships.create')}}">Nueva Nave</a>
    <h1>Lista de Naves</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    @livewire('admin.ships-index')
    {{-- <div class="card">        
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>IMO</th>
                        <th>DWT</th>
                        <th>TRG</th>
                        <th>LOA</th>
                        <th>MANGA</th>                        
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ships as $ship)
                        <tr>
                            <td>{{$ship->id}}</td>
                            <td>{{$ship->codigo}}</td>
                            <td>{{$ship->nombre}}</td>
                            <td>
                                @if ($ship->ship_tipo_id)
                                    {{$ship->ship_tipo->nombre}}
                                @endif                                
                            </td>
                            <td>{{$ship->imo}}</td>
                            <td>{{$ship->dwt}}</td>
                            <td>{{$ship->trg}}</td>
                            <td>{{$ship->loa}}</td>
                            <td>{{$ship->manga}}</td>                            
                            <td width="10px">
                                <a class="btn btn-primary btn-sm" href="{{route('admin.ships.edit', $ship)}}">Editar</a>
                            </td>
                            <td width="10px">
                                @can('mantencion.ships.destroy')
                                    @if ($ship->estado == 2)
                                        <form action="{{ route('admin.ships.destroy', $ship) }}" method="POST"
                                            class="formulario-eliminar">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                        </form>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach  
                </tbody>
            </table>

            

        </div>
        
    </div> --}}
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

    Livewire.on('delNave', ShipId => {
            
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
                Livewire.emit('deleteNave', ShipId);
                    Swal.fire({
                    title: "Eliminada!",
                    text: "Nave ha sido eliminada con exito.",
                    icon: "success"
                    });
                //this.submit();
            }
        });
    })
    
     
    </script>
@endsection

{{-- @section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        $('.formulario-eliminar').submit(function(e){            
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
        })

        
    </script>
@endsection --}}

