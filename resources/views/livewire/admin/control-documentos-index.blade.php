<?php 
use App\Http\Controllers\CarbonController;
$fecha = new CarbonController;                                            
?>

<div class="card">     
    <div class="card-header">            
        <div class="row">            
            <div class="col-4">
                {!! Form::label('shipFilter', 'Nave') !!}
                <select wire:model="shipFilter" class="form-control">
                    <option value="">Seleccione Nave...</option>
                        @foreach ($ships as $ship)
                            <option value="{{$ship->id}}">{{$ship->nombre}}</option>
                        @endforeach
                </select>
            </div>  
            <div class="col-4">
                {!! Form::label('rangoFilter', 'Rango') !!}
                <select wire:model="rangoFilter" class="form-control">
                    <option value="">Seleccione Rango...</option>
                        @foreach ($rangos as $rango)
                            <option value="{{$rango->id}}">{{$rango->nombre}}</option>
                        @endforeach
                </select>
            </div>
            <div class="col-4">          
                {!! Form::label('nameFilter', 'Nombre') !!}                              
                <input wire:model="nameFilter" class="form-control" placeholder="Ingrese nombre de dotación">
            </div>              
        </div>        
    </div>   
    @if ($personas->count())
    <div class="card-body table-responsive text-nowrap" style="max-height: 680px; /* padding:0%; */">            
        <table class="table-xsm table-striped table-hover">
            <thead class="table-secondary border border-secondary" {{-- style="position: sticky; top:0;" --}}>
                <tr>
                    <th rowspan="2" class="border border-secondary align-middle text-center">Nave</th>
                    <th rowspan="2" class="border border-secondary align-middle text-center">Rango</th>
                    <th rowspan="2" class="border border-secondary align-middle text-center th-lg">Dotación</th>
                    <th colspan="{{$documentos->count()}}" class="border border-secondary text-center">Documentos</th>                        
                </tr>
                <tr>
                    @foreach ($documentos as $documento)
                        <th class="border border-secondary align-middle text-center">{{$documento->nr_documento}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>                                        
                @foreach ($personas as $persona)
                    <tr>                            
                        <td class="border border-secondary align-middle text-center">
                            @if ($persona->ship_id)
                                {{$persona->ship->nombre}}
                            @else
                                {{"-"}}
                            @endif
                        </td>
                        <td class="border border-secondary align-middle text-center">
                            @if ($persona->rango_id)
                                {{$persona->rango->nombre}}
                            @else
                                {{"-"}}
                            @endif
                        </td>
                        <td class="border border-secondary align-middle text-center">{{$persona->nombre}}</td>   
                        @foreach ($documentos as $documento)
                            @if ($persona->documento->count())                                        
                                <?php $cn = 0; ?>
                                @foreach ($persona->documento as $doc_persona)                                        
                                    @if ($doc_persona->pivot->documento_id == $documento->id)                                                                                               
                                        <?php 
                                            $cn++;
                                            if($cn>0)
                                            {
                                                $fc_fin = $doc_persona->pivot->fc_fin;
                                            }
                                        ?>
                                    @endif
                                @endforeach
                                @if ($cn>0) 
                                    <?php                                            
                                        $diff = $fecha->diffFechaActual($fc_fin);
                                        $fc_fin = $fecha->formatodmY($fc_fin);
                                    ?>
                                    @if ($diff<=90)
                                        <td class="border border-secondary align-middle text-center table-danger">{{ $fc_fin }}</td>
                                    @elseif($diff>90 && $diff<180)
                                        <td class="border border-secondary align-middle text-center table-warning">{{ $fc_fin }}</td>
                                    @else
                                        <td class="border border-secondary align-middle text-center table-success">{{ $fc_fin }}</td>
                                    @endif                                                                                
                                @else
                                    <td class="border border-secondary align-middle text-center"></td> 
                                @endif                                        
                            @else
                                <td class="border border-secondary align-middle text-center"></td>
                            @endif                                                                                                   
                        @endforeach
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