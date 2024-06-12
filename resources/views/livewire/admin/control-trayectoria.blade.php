<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-4">
                {!! Form::label('shipFilter', 'Nave') !!}
                <select wire:model="shipFilter" class="form-control">
                    <option value="">Seleccione Nave...</option>
                    @foreach ($ships as $ship)
                        <option value="{{ $ship->id }}">{{ $ship->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                {!! Form::label('rangoFilter', 'Rango') !!}
                <select wire:model="rangoFilter" class="form-control">
                    <option value="">Seleccione Rango...</option>
                    @foreach ($rangos as $rango)
                        <option value="{{ $rango->id }}">{{ $rango->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                {!! Form::label('nameFilter', 'Nombre') !!}
                <input wire:model="nameFilter" class="form-control" placeholder="Ingrese nombre de dotación">
            </div>
            {{-- <div class="col-4">            
                <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#modalCreatePersona">Nuevo</button>
            </div> --}}

        </div>
    </div>
    
    @if ($personas->count())            
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>                        
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>RUT</th>
                        <th>Rango</th>
                        <th>Nave</th>
                        <th>Fecha Nacimiento</th>
                        <th>Fecha Ingreso</th>
                        {{-- <th>Fecha Baja</th> --}}
                        
                        <th colspan="3"></th>
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
                                @if ($persona->fc_nacimiento)
                                    {{date('d-m-Y', strtotime($persona->fc_nacimiento))}}
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
                            </td>                                                        --}}
                            <td width="10px">
                                <a class="btn btn-success btn-sm" href="{{route('admin.trayectorias.show', $persona->id)}}">Ver</a>
                            </td>                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>        
    @else
        <div class="card-body">
            <strong>No hay ningún registro...</strong>            
        </div>
    @endif    
</div>
