<?php 
/* use App\Http\Controllers\CarbonController;
$fecha = new CarbonController;       */                                      
?>

@extends('adminlte::page')

@section('title', 'Control Documentos')

@section('content_header')        
    <h1>Control de Documentos</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    @livewire('admin.control-documentos-index')
    {{-- <div class="card">     
        <div class="card-header">            
            <div class="row">
                <div class="col-5">
                    {!! Form::label('rango_id', 'Rango') !!}
                    {!! Form::select('rango_id', $rangos, null, ['class' => 'form-control', 'placeholder' => 'Seleccionar Rango...']) !!}                
                </div>
                <div class="col-5">
                    {!! Form::label('ship_id', 'Nave') !!}
                    {!! Form::select('ship_id', $ships, null, ['class' => 'form-control', 'placeholder' => 'Seleccionar Nave...']) !!} 
                </div>  
                <div class="col">                                        
                    <a class="btn btn-primary btn-md" href="{{route('admin.control.index')}}">Consultar</a>
                </div>              
            </div>
        </div>   
        @if ($personas->count())
        <div class="card-body table-responsive" style="max-height: 720px">            
            <table class="table-sm table-striped">
                <thead class="table-secondary border border-secondary">
                    <tr>
                        <th rowspan="2" class="border border-secondary align-middle text-center">Nave</th>
                        <th rowspan="2" class="border border-secondary align-middle text-center">Rango</th>
                        <th rowspan="2" class="border border-secondary align-middle text-center">Dotación</th>
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
    </div> --}}
@stop


@section('js')    
@endsection