<?php
use App\Models\Rango;
use App\Models\DetalleTrayectoria;
?>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-3">
                {!! Form::label('shipFilter', 'Nave') !!}
                <select wire:model="shipFilter" class="form-control">
                    <option value="">Seleccione Nave...</option>
                    @foreach ($ships as $ship)
                        <option value="{{ $ship->id }}">{{ $ship->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
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
            <div class="col-2">
                {!! Form::label('estadoFilter', 'Estado Persona') !!}
                <select wire:model="estadoFilter" class="form-control">
                    <option value="">Todos</option>
                    <option value="1">Activos</option>
                    <option value="2">Inactivos</option>                    
                </select>
            </div>

        </div>
    </div>
    
    @if ($personas->count())            
        <div class="card-body table-responsive">
            <table class="table table-sm table-hover">
                <thead>
                    <tr>                        
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>RUT</th>
                        <th>Rango</th>
                        <th>Estado</th>
                        <th>Hasta</th>
                        <th>Nave</th>                        
                        {{-- <th>Contrato</th>
                        <th>Fecha Nacimiento</th>
                        <th>Fecha Ingreso</th> --}}                        
                    </tr>
                </thead>
                <tbody>                    
                    @foreach ($personas as $persona)
                        <?php
                        $nm_estado = null;
                        $fc_hasta = '';
                        if($persona->trayectoria)
                        {
                            $detalle = detalleTrayectoria::where('trayectoria_id', $persona->trayectoria->id)
                            ->where('fc_desde', '<=', now())
                            ->where('fc_hasta', '>=', now())
                            ->whereNotIn('estado_id', [18,19,20])
                            ->first();
                            if($detalle)
                            {
                                $nm_estado = $detalle->estado->nombre;
                                $fc_hasta = $detalle->fc_hasta;
                            }
                            else {
                                $nm_estado = 'SIN PROGRAMACIÓN';
                            }
                        }
                        else {
                            $nm_estado = 'SIN PROGRAMACIÓN';
                        }
                        ?>
                        @if($persona->eventual == 2)
                        <tr onclick="window.location='{{ route('admin.trayectorias.show', $persona->id) }}'" title="Ver control de trayectoria (Personal Eventual)" style="cursor: pointer; background-color: rgb(252, 211, 151)">                            
                        @else
                        <tr onclick="window.location='{{ route('admin.trayectorias.show', $persona->id) }}'" title="Ver control de trayectoria" style="cursor: pointer;">
                        @endif
                            <td>{{$persona->id}}</td>
                            {{-- <td>{{$persona->trayectoria->id}}</td> --}}
                            <td>{{$persona->nombre}}</td>
                            <td>{{$persona->rut}}</td>                            
                            <td>
                                @if ($persona->rango_id)
                                    {{$persona->rango->nombre}}
                                @endif                                
                            </td>
                            <td>
                                {{$nm_estado}}
                            </td>
                            <td>@if($fc_hasta) {{ date('d/m/Y', strtotime($fc_hasta)) }} @endif</td>
                            <td>
                                @if ($persona->ship_id)
                                    {{$persona->ship->nombre}}
                                @else
                                    En Tierra
                                @endif                                
                            </td>                            
                            {{-- <td>
                                @if ($persona->contrato_tipo_id)
                                    {{ Rango::where('id', $persona->contrato_tipo_id)->first()->nombre; }}
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
                            </td>   --}}                                                                              
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
