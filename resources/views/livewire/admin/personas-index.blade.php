<div class="card">
    <div class="card-header">
        <input wire:model="search" class="form-control" placeholder="Ingrese el nombre de la persona">
    </div>
    
    @if ($personas->count())            
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>RUT</th>
                        <th>Rango</th>
                        <th>Nave</th>
                        <th>Fecha Ingreso</th>
                        {{-- <th>Fecha Baja</th>
                        <th>Fecha Nacimiento</th> --}}
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>                    
                    @foreach ($personas as $persona)
                        <tr>
                            <td>{{$persona->id}}</td>
                            <td>{{$persona->nombre}}</td>
                            <td>{{$persona->rut}}</td>                            
                            <td>
                                @if ($persona->rango_id)
                                    {{$persona->rango->nombre}}
                                @endif                                
                            </td>
                            <td>
                                @if ($persona->ship_id)
                                    {{$persona->ship->nombre}}
                                @endif                                
                            </td>                                
                            <td>
                                @if ($persona->fc_ingreso)
                                    {{date('d-m-Y', strtotime($persona->fc_ingreso))}}                                                                            
                                @endif
                            </td>                            
                            {{-- <td>
                                @if ($persona->fc_baja)
                                    {{date('d-m-Y', strtotime($persona->fc_baja))}}
                                @endif                                
                            </td>                            
                            <td>
                                @if ($persona->fc_nacimiento)
                                    {{date('d-m-Y', strtotime($persona->fc_nacimiento))}}
                                @endif                                
                            </td> --}}
                            <td width="10px">
                                <a class="btn btn-primary btn-sm" href="{{route('admin.personas.edit', $persona)}}">Editar</a>
                            </td>
                            <td width="10px">
                                @can('mantencion.personas.destroy')                                                                    
                                    <form action="{{route('admin.personas.destroy', $persona)}}" method="POST" class="formulario-eliminar">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{$personas->links()}}
        </div>
    @else
        <div class="card-body">
            <strong>No hay ningún registro...</strong>            
        </div>
    @endif
</div>
