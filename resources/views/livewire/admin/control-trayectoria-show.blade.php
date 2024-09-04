<?php
use App\Http\Controllers\CarbonController;
use App\Models\Rango;
$fecha = new CarbonController();
//$boSistemaAntiguo = $fecha->boSistemaAntiguo($persona->fc_ingreso);
?>
<div>
    <div class="card">
        @if($persona->eventual == 2)
        <div class="card-header" style="background-color: rgb(252, 211, 151); cursor: pointer;" title="Personal Eventual">
        @else
        <div class="card-header">
        @endif
            <div class="row">
                <div class="col-11 text-sm">
                    <div class="row">{{--  style="margin-bottom: -2%; margin-top: 0%;"> --}}
                        <div class="col-4">
                            <label for="">Nombre:</label>
                            {{ $persona->nombre }}
                        </div>
                        <div class="col-4">
                            <label for="">Rango:</label>
                            {{ $persona->rango->nombre }}
                        </div>
                        <div class="col-4">
                            <label for="">Fecha Contrato Vigente:</label>
                            {{ $fecha->formatodmY($persona->fc_ingreso) }}
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-4">
                            <label for="">RUT:</label>
                            {{ $persona->rut }}
                        </div>
                        <div class="col-4">
                            <label for="">Nacimiento:</label>
                            {{ $fecha->formatodmY($persona->fc_nacimiento) }}
                        </div>
                        <div class="col-4">
                            <label for="">Tipo de Contrato:</label>
                            @if ($persona->contrato_tipo_id)
                                {{ Rango::where('id', $persona->contrato_tipo_id)->first()->nombre; }}
                            @endif
                        </div>
                    </div>                    
                </div>
                <div class="col-1">
                    <div class="row">
                        <div class="col-12">
                            <div style="position: relative; padding-bottom: 5%; cursor: pointer;" {{-- title="Editar Persona"
                                onclick="window.location='{{ route('admin.personas.edit', $persona) }}'" --}}>
                                @if ($persona->foto)
                                    <img src="{{ asset('storage/' . $persona->foto) }}" alt=""
                                        style="position: relative; object-fit: cover; width: 100%; height: 100%;"
                                        id="picture_upd">
                                @else
                                    <img src="https://cdn.pixabay.com/photo/2023/02/18/11/00/icon-7797704_1280.png"
                                        alt=""
                                        style="position: relative; object-fit: cover; width: 100%; height: 100%;"
                                        id="picture_upd">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
            {{-- <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger align-middle text-center">
                        <strong>Adventencia: Persona sin Programación!!</strong>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="card-body table-responsive "style="max-height: 680px;">
            {{-- cabecera --}}
            <div>
                <div class="mx-1 d-flex flex-row">
                    <button type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal"
                    data-target="#modalAgregarDetalle" data-backdrop="static"
                    data-keyboard="false">Agregar Detalle</button>
                    &nbsp;
                    @if ($boAjusteInicial == 0)
                        <button wire:click="editAjuste" type="button" class="btn btn-outline-primary btn-xs" data-toggle="modal"
                        data-target="#modalAjusteInicial" data-backdrop="static"
                        data-keyboard="false">Editar Ajustes</button>
                    @else
                        <button wire:click="editAjuste" type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                        data-target="#modalAjusteInicial" data-backdrop="static"
                        data-keyboard="false">Editar Ajustes</button>
                    @endif
                </div>
                <div class="mx-1 d-flex flex-row-reverse">                    
                    <button wire:click="$toggle('showCabecera')" id="btnCabecera" type="button"
                        class="btn btn-outline-secondary btn-xs">
                        @if ($showCabecera)
                            Ocultar Cabecera
                        @else
                            Mostrar Cabecera
                        @endif
                    </button>
                </div>
                @if ($showCabecera)
                    <div id="divCabecera" class="bg-white shadow rounded-lg mb-2">
                        <table class="table table-sm" style="border-collapse: separate;">
                            <thead class="table-secondary border border-secondary">
                                <tr>
                                    <th colspan="2" class="border border-secondary align-middle text-center text-sm">
                                        Condición
                                    </th>
                                    <th class="border border-secondary align-middle text-center text-sm">Desde</th>
                                    <th class="border border-secondary align-middle text-center text-sm">Hasta</th>
                                    <th class="border border-secondary align-middle text-center text-sm">Total (Días)</th>
                                    <th class="border border-secondary align-middle text-center text-sm">Factor</th>
                                    <th colspan="2" class="border border-secondary align-middle text-center text-sm">Total de días acumulados</th>
                                    <th colspan="2" class="border border-secondary align-middle text-center text-sm">Total de días consumidos</th>
                                    <th colspan="2" class="border border-secondary align-middle text-center text-sm">Saldo de días pendientes</th>
                                    <th colspan="2" class="border border-secondary align-middle text-center text-sm" style="background-color: rgba(255, 242, 204, 0.842)">Saldo Proyectado</th>
                                </tr>
                            </thead>
                            <tbody>                                   
                                <tr>
                                    <td colspan="2" class="border border-secondary text-xs">Sistema Antiguo</td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs">@if($sistemaAntiguo['fc_desde']=='') {{ '' }} @else {{ date('d/m/Y', strtotime($sistemaAntiguo['fc_desde'])) }} @endif</td>                                    
                                    <td class="border border-secondary text-sm align-middle text-center text-xs">@if($sistemaAntiguo['fc_hasta']=='') {{ '' }} @else {{ date('d/m/Y', strtotime($sistemaAntiguo['fc_hasta'])) }} @endif</td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs" @if($sistemaAntiguo['total_dias'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ $sistemaAntiguo['total_dias'] }}</td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs" @if($sistemaAntiguo['factor'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>@if($sistemaAntiguo['factor']==0) {{ 0 }} @else {{ number_format($sistemaAntiguo['factor'], 4, ',', '.') }} @endif</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($sistemaAntiguo['total_dias_acumulados'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($sistemaAntiguo['total_dias_acumulados'], 0, ',', '.') }}</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($sistemaAntiguo['total_dias_consumidos'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($sistemaAntiguo['total_dias_consumidos'], 0, ',', '.') }}</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($sistemaAntiguo['saldo_dias_pendientes'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($sistemaAntiguo['saldo_dias_pendientes'], 0, ',', '.') }}</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($sistemaAntiguo['saldo_proyectado'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($sistemaAntiguo['saldo_proyectado'], 0, ',', '.') }}</td>
                                </tr>                                
                                <tr>
                                    <td colspan="2" class="border border-secondary text-xs">Decreto Supremo 26 (Actual)</td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs">@if($decretoSupremo['fc_desde']=='') {{ '' }} @else {{ date('d/m/Y', strtotime($decretoSupremo['fc_desde'])) }} @endif</td>                                    
                                    <td class="border border-secondary text-sm align-middle text-center text-xs">@if($decretoSupremo['fc_hasta']=='') {{ '' }} @else {{ date('d/m/Y', strtotime($decretoSupremo['fc_hasta'])) }} @endif</td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs" @if($decretoSupremo['total_dias'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ $decretoSupremo['total_dias'] }}</td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs" @if($decretoSupremo['factor'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>@if($decretoSupremo['factor']==0) {{ 0 }} @else {{ number_format($decretoSupremo['factor'], 4, ',', '.') }} @endif</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($decretoSupremo['total_dias_acumulados'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($decretoSupremo['total_dias_acumulados'], 0, ',', '.') }}</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($decretoSupremo['total_dias_consumidos'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($decretoSupremo['total_dias_consumidos'], 0, ',', '.') }}</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($decretoSupremo['saldo_dias_pendientes'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($decretoSupremo['saldo_dias_pendientes'], 0, ',', '.') }}</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($decretoSupremo['saldo_proyectado'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($decretoSupremo['saldo_proyectado'], 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border border-secondary text-xs">Días Progresivos</td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs">@if($diasProgresivos['fc_desde']=='') {{ '' }} @else {{ date('d/m/Y', strtotime($diasProgresivos['fc_desde'])) }} @endif</td>                                    
                                    <td class="border border-secondary text-sm align-middle text-center text-xs">@if($diasProgresivos['fc_hasta']=='') {{ '' }} @else {{ date('d/m/Y', strtotime($diasProgresivos['fc_hasta'])) }} @endif</td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs" @if($diasProgresivos['total_dias'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ $diasProgresivos['total_dias'] }}</td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs" @if($diasProgresivos['factor'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>@if($diasProgresivos['factor']==0) {{ 0 }} @else {{ number_format($diasProgresivos['factor'], 0, ',', '.') }} @endif</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($diasProgresivos['total_dias_acumulados'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($diasProgresivos['total_dias_acumulados'], 0, ',', '.') }}</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($diasProgresivos['total_dias_consumidos'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($diasProgresivos['total_dias_consumidos'], 0, ',', '.') }}</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($diasProgresivos['saldo_dias_pendientes'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($diasProgresivos['saldo_dias_pendientes'], 0, ',', '.') }}</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($diasProgresivos['saldo_proyectado'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($diasProgresivos['saldo_proyectado'], 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border border-secondary text-xs">Días 1x1</td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($dias1x1['total_dias_acumulados'] < -0.5) {{"style='background-color: rgb(245, 130, 130)'"}} @endif>{{ number_format($dias1x1['total_dias_acumulados'], 0, ',', '.') }}</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($dias1x1['total_dias_consumidos'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($dias1x1['total_dias_consumidos'], 0, ',', '.') }}</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($dias1x1['saldo_dias_pendientes'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($dias1x1['saldo_dias_pendientes'], 0, ',', '.') }}</td>                                    
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($dias1x1['saldo_proyectado'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($dias1x1['saldo_proyectado'], 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border border-secondary text-xs">Descanso</td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($descanso['total_dias_acumulados'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($descanso['total_dias_acumulados'], 0, ',', '.') }}</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($descanso['total_dias_consumidos'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($descanso['total_dias_consumidos'], 0, ',', '.') }}</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($descanso['saldo_dias_pendientes'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($descanso['saldo_dias_pendientes'], 0, ',', '.') }}</td>
                                    <td colspan="2" class="border border-secondary text-sm align-middle text-center text-xs" @if($descanso['saldo_proyectado'] < -0.5) {!!'style="background-color: rgb(245, 130, 130)"'!!} @endif>{{ number_format($descanso['saldo_proyectado'], 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>

            {{-- formulario --}}
            <div>
                {{-- <div class="mx-1 d-flex flex-row-reverse">
                    <button wire:click="$toggle('showFormulario')" id="btnFormulario" type="button"
                        class="btn btn-outline-secondary btn-xs">
                        @if ($showFormulario)
                            Ocultar Formulario
                        @else
                            Mostrar Formulario
                        @endif
                    </button>
                </div> --}}                
                @if ($showFormulario)
                    <div class="bg-white shadow rounded-lg mb-2">
                        <form wire:submit.prevent="saveDetalle">
                            <div class="row ml-2 mr-2">
                                <div class="col-3 mt-2">
                                    <label for="">Agregar Detalle</label>
                                </div>
                            </div>
                            <div class="row ml-2 mr-2">
                                <div class="col-2">
                                    <label for="">Nave</label>
                                </div>
                                <div class="col-2">
                                    <label for="">Estado</label>
                                </div>
                                <div class="col-2">
                                    <label for="">Desde</label>
                                </div>
                                <div class="col-2">
                                    <label for="">Hasta</label>
                                </div>
                                <div class="col-1">
                                    <label for="">Ajuste</label>
                                </div>
                                <div class="col-3">
                                    <label for="">Observaciones</label>
                                </div>
                            </div>
                            <div class="row ml-2 mr-2">
                                <div class="col-2 mb-2">
                                    <select class="form-control" wire:model="ship_id">
                                        <option value="" disabled>Seleccionar Nave...</option>
                                        @foreach ($ships as $ship)
                                            <option value="{{ $ship->id }}">{{ $ship->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('ship_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <select class="form-control" wire:model="estado_id" wire:change="estadoChange">
                                        <option value="" disabled>Seleccionar Estado...</option>
                                        @foreach ($estados as $estado)
                                            <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('estado_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="date" class="form-control" wire:model="fc_desde">
                                    @error('fc_desde')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="date" class="form-control" wire:model="fc_hasta">
                                    @error('fc_hasta')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-1">
                                    @if ($boAjuste == true)
                                        <input type="text" class="form-control" wire:model="ajuste">
                                    @else
                                        <input type="text" class="form-control" wire:model="ajuste" disabled>
                                    @endif
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" wire:model="observaciones">
                                </div>
                            </div>
                            <div class="row ml-2 mr-2">
                                <div class="col-1 mb-2 mr-2">
                                    {{-- <button class="btn btn-secondary btn-sm">Agregar</button> --}}
                                    <input class="btn btn-secondary btn-sm" type="submit" value="Agregar">
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            {{-- detalle --}}
            {{-- <div class="card-body table-responsive" style="max-height: 100%; padding:0%;"> --}}
            <div>
                @if ($detallesTrayectoria)
                    <div class="mx-1 d-flex flex-row-reverse">
                        <button wire:click="$toggle('showDetalle')" id="btnDetalle" type="button"
                            class="btn btn-outline-secondary btn-xs">
                            @if ($showDetalle)
                                Ocultar Detalle
                            @else
                                Mostrar Detalle
                            @endif
                        </button> 
                        @if ($showDetalle)                       
                            @if($simple)
                                &nbsp;
                                <button wire:click="setVista(2)" type="button" class="btn btn-outline-primary btn-xs">Avanzada</button>
                                &nbsp;
                                <button wire:click="setVista(1)" type="button" class="btn btn-primary btn-xs">Simple</button>
                            @else
                                &nbsp;
                                <button wire:click="setVista(2)" type="button" class="btn btn-primary btn-xs">Avanzada</button>
                                &nbsp;
                                <button wire:click="setVista(1)" type="button" class="btn btn-outline-primary btn-xs">Simple</button>
                            @endif
                        @endif                        
                    </div>
                    @if ($showDetalle)
                        <div id="divDetalle" class="bg-white shadow rounded-lg  table-responsive"
                            style="max-height: 560px; padding:0%;">
                            @if($simple)
                                <table class="table table-sm" style="border-collapse: separate;">
                                    <thead class="table-secondary border border-secondary"
                                        style="position: sticky; top:0;">
                                        <tr>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('ship_id')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Nave
                                                {{-- Sort --}}
                                                @if ($sort == 'ship_id')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif                                                
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('plaza_id')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Plaza
                                                {{-- Sort --}}
                                                @if ($sort == 'plaza_id')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif                                                
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('estado_id')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Estado
                                                {{-- Sort --}}
                                                @if ($sort == 'estado_id')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif                                                
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('fc_desde')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Desde
                                                {{-- Sort --}}
                                                @if ($sort == 'fc_desde')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif                                                
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('fc_hasta')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Hasta
                                                {{-- Sort --}}
                                                @if ($sort == 'fc_hasta')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif                                                
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('total_dias_calendario')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Días
                                                {{-- Sort --}}
                                                @if ($sort == 'total_dias_calendario')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('generados')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Generados
                                                {{-- Sort --}}
                                                @if ($sort == 'generados')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('consumidos')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Consumidos
                                                {{-- Sort --}}
                                                @if ($sort == 'consumidos')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif
                                            </th>                                            
                                            <th colspan="1" style="cursor: pointer" wire:click="order('ajuste')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Ajuste
                                                {{-- Sort --}}
                                                @if ($sort == 'ajuste')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('observaciones')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Observaciones
                                                {{-- Sort --}}
                                                @if ($sort == 'observaciones')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif
                                            </th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- {{$detallesTrayectoria}} --}}
                                        @if ($detallesTrayectoria)
                                            @foreach ($detallesTrayectoria as $detalleTrayectoria)
                                                @if($detalleTrayectoria->estado_id != 18 && $detalleTrayectoria->estado_id != 19 && $detalleTrayectoria->estado_id != 20)
                                                    <?php 
                                                        $boMenorIgualFcDesde = $fecha->getFechaEsMenorIgualHoy($detalleTrayectoria->fc_desde);
                                                        $boMayorIgualFcHasta = $fecha->getFechaEsMayorIgualHoy($detalleTrayectoria->fc_hasta);
                                                        if($boMenorIgualFcDesde == 1 && $boMayorIgualFcHasta) $boMarcaFila = 1; else $boMarcaFila = 0;
                                                    ?>
                                                    @if($boMarcaFila==1)
                                                    <tr style="background-color: rgb(252, 211, 151)">
                                                    @else
                                                    <tr>
                                                    @endif
                                                @else
                                                    <tr>
                                                @endif
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm text-nowrap align-middle text-center">
                                                        @if ($detalleTrayectoria->ship_id)
                                                            {{ $detalleTrayectoria->ship->nombre }}    
                                                        @else
                                                            @if ($detalleTrayectoria->estado_id == 18 || $detalleTrayectoria->estado_id == 19 || $detalleTrayectoria->estado_id == 20)
                                                                    
                                                            @else
                                                                En Tierra
                                                            @endif
                                                        @endif                                                        
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm text-nowrap align-middle text-center">
                                                        @if ($detalleTrayectoria->plaza_id)
                                                            {{ Rango::where('id', $detalleTrayectoria->plaza_id)->first()->nombre; }}
                                                        @endif
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm text-nowrap align-middle text-center">
                                                        {{ $detalleTrayectoria->estado->nombre }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{ date('d/m/Y', strtotime($detalleTrayectoria->fc_desde)) }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{ date('d/m/Y', strtotime($detalleTrayectoria->fc_hasta)) }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">                                                        
                                                        {{ $detalleTrayectoria->total_dias_calendario }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{-- {{ $detalleTrayectoria->descanso_convenio + $detalleTrayectoria->dias_inhabiles_favor }}                                                         --}}
                                                        {{ $detalleTrayectoria->generados }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{-- {{ $detalleTrayectoria->dias_vacaciones_consumidas + $detalleTrayectoria->dias_inhabiles_consumidos }} --}} 
                                                        {{ $detalleTrayectoria->consumidos }}                                                       
                                                    </td>                                                    
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{ $detalleTrayectoria->ajuste }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{ $detalleTrayectoria->observaciones }}
                                                    </td>                                                    
                                                </tr>
                                            @endforeach

                                        @endif
                                    </tbody>
                                </table>
                            @else
                                <table class="table table-sm" style="border-collapse: separate;">
                                    <thead class="table-secondary border border-secondary"
                                        style="position: sticky; top:0;">
                                        <tr>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('ship_id')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Nave
                                                {{-- Sort --}}
                                                @if ($sort == 'ship_id')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif                                                
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('plaza_id')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Plaza
                                                {{-- Sort --}}
                                                @if ($sort == 'plaza_id')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif                                                
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('estado_id')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Estado
                                                {{-- Sort --}}
                                                @if ($sort == 'estado_id')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif                                                
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('fc_desde')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Desde
                                                {{-- Sort --}}
                                                @if ($sort == 'fc_desde')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif                                                
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('fc_hasta')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Hasta
                                                {{-- Sort --}}
                                                @if ($sort == 'fc_hasta')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif                                                
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('total_dias_calendario')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Total Días Calendario
                                                {{-- Sort --}}
                                                @if ($sort == 'total_dias_calendario')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif 
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('descanso_convenio')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Descanso Generado Según Convenio
                                                {{-- Sort --}}
                                                @if ($sort == 'descanso_convenio')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif 
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('saldo_descanso')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Saldo Descanso
                                                {{-- Sort --}}
                                                @if ($sort == 'saldo_descanso')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif 
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('dias_vacaciones_consumidas')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Días Vacaciones Consumidas
                                                {{-- Sort --}}
                                                @if ($sort == 'dias_vacaciones_consumidas')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif 
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('dias_inhabiles_generados')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Días Inhábiles Generados
                                                {{-- Sort --}}
                                                @if ($sort == 'dias_inhabiles_generados')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif 
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('dias_inhabiles_favor')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Días Inhábiles a Favor (1x1)
                                                {{-- Sort --}}
                                                @if ($sort == 'dias_inhabiles_favor')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif 
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('dias_inhabiles_consumidos')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Días Inhábiles Consumidos (1x1)
                                                {{-- Sort --}}
                                                @if ($sort == 'dias_inhabiles_consumidos')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif 
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('ajuste')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Ajuste
                                                {{-- Sort --}}
                                                @if ($sort == 'ajuste')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif 
                                            </th>
                                            <th colspan="1" style="cursor: pointer" wire:click="order('observaciones')"
                                                class="border border-secondary align-middle text-center text-xs">
                                                Observaciones
                                                {{-- Sort --}}
                                                @if ($sort == 'observaciones')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>    
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>    
                                                    @endif                                                    
                                                @else
                                                    <i class="fas fa-sort float-right mt-1"></i>
                                                @endif 
                                            </th>
                                            {{-- <th colspan="2"
                                                class="border border-secondary align-middle text-center text-xs">
                                            </th> --}}

                                        </tr>
                                    </thead>
                                    <tbody>                                    
                                        @if ($detallesTrayectoria)
                                            @foreach ($detallesTrayectoria as $detalleTrayectoria)
                                                @if($detalleTrayectoria->estado_id != 18 && $detalleTrayectoria->estado_id != 19 && $detalleTrayectoria->estado_id != 20)
                                                    <?php 
                                                        $boMenorIgualFcDesde = $fecha->getFechaEsMenorIgualHoy($detalleTrayectoria->fc_desde);
                                                        $boMayorIgualFcHasta = $fecha->getFechaEsMayorIgualHoy($detalleTrayectoria->fc_hasta);
                                                        if($boMenorIgualFcDesde == 1 && $boMayorIgualFcHasta) $boMarcaFila = 1; else $boMarcaFila = 0;
                                                    ?>
                                                    @if($boMarcaFila==1)
                                                    <tr style="background-color: rgb(252, 211, 151)">
                                                    @else
                                                    <tr>
                                                    @endif
                                                @else
                                                    <tr>
                                                @endif
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm text-nowrap align-middle text-center">
                                                        @if ($detalleTrayectoria->ship_id)
                                                            {{ $detalleTrayectoria->ship->nombre }}    
                                                        @else
                                                            @if ($detalleTrayectoria->estado_id == 18 || $detalleTrayectoria->estado_id == 19 || $detalleTrayectoria->estado_id == 20)
                                                                
                                                            @else
                                                                En Tierra
                                                            @endif                                                            
                                                        @endif
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm text-nowrap align-middle text-center">
                                                        @if ($detalleTrayectoria->plaza_id)
                                                            {{ Rango::where('id', $detalleTrayectoria->plaza_id)->first()->nombre; }}
                                                        @endif
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm text-nowrap align-middle text-center">
                                                        {{ $detalleTrayectoria->estado->nombre }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{ date('d/m/Y', strtotime($detalleTrayectoria->fc_desde)) }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{ date('d/m/Y', strtotime($detalleTrayectoria->fc_hasta)) }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{ $detalleTrayectoria->total_dias_calendario }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{ $detalleTrayectoria->descanso_convenio }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{ $detalleTrayectoria->saldo_descanso }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{ $detalleTrayectoria->dias_vacaciones_consumidas }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{ $detalleTrayectoria->dias_inhabiles_generados }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{ $detalleTrayectoria->dias_inhabiles_favor }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{ $detalleTrayectoria->dias_inhabiles_consumidos }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{ $detalleTrayectoria->ajuste }}
                                                    </td>
                                                    <td colspan="1"
                                                        class="border border-secondary text-sm align-middle text-center">
                                                        {{ $detalleTrayectoria->observaciones }}
                                                    </td>                                                
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    @endif
                @endif
            </div>

            {{-- modal Agregar detalle --}}
            <div>
                <form wire:submit.prevent="saveDetalle">
                    <div wire:ignore.self class="modal fade" id="modalAgregarDetalle" tabindex="-1" role="dialog"
                        aria-labelledby="modalAgregarDetalleTitle" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalAgregarDetalleTitle">Agregar Detalle</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                        wire:click="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">   
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {!! Form::label('estado_id', 'Estado') !!}
                                                        <select class="form-control" wire:model="estado_id" wire:change="estadoChange">
                                                            <option value="" disabled>Seleccionar Estado...</option>
                                                            @foreach ($estados as $estado)
                                                                <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('estado_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {!! Form::label('ship_id', 'Nave') !!}
                                                        <select class="form-control" wire:model="ship_id">
                                                            <option value="" disabled>Seleccionar Nave...</option>
                                                            @foreach ($ships as $ship)
                                                                <option value="{{ $ship->id }}">{{ $ship->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('ship_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        {!! Form::label('plaza_id', 'Plaza') !!}
                                                        <select class="form-control" wire:model="plaza_id">
                                                            <option value="" disabled>Seleccionar Plaza...</option>
                                                            @foreach ($rangos as $rango)
                                                                <option value="{{ $rango->id }}">{{ $rango->nombre }}</option>
                                                                {{-- @if($persona->rango_id == $rango->id)
                                                                    <option value="{{ $rango->id }}">{{ $rango->nombre }}</option>                                                                    
                                                                @else
                                                                    <option value="{{ $rango->id }}" selected>{{ $rango->nombre }}</option>
                                                                @endif --}}
                                                            @endforeach
                                                        </select>
                                                        @error('plaza_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                                                        
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">Desde</label>
                                                        <input type="date" class="form-control" wire:model="fc_desde" wire:change="setDiferencia">
                                                        @error('fc_desde')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">Hasta</label>
                                                        <input type="date" class="form-control" wire:model="fc_hasta" wire:change="setDiferencia">
                                                        @error('fc_hasta')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for=""># Días</label>
                                                        <input wire:model="difAgregarDetalle" type="button" class="form-control" style="background-color: white">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                @if ($bo_sobreembarco)
                                                    <div class="alert alert-danger align-middle text-center">
                                                        <strong>Adventencia: Se generará un sobre embarco!!</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">Ajuste</label>
                                                        @if ($boAjuste == true)
                                                            <input type="number" class="form-control" wire:model="ajuste">
                                                        @else
                                                            <input type="number" class="form-control" wire:model="ajuste" disabled>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-10">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">Observaciones</label>
                                                        <input type="text" class="form-control" wire:model="observaciones">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                                                                                                   
                                </div>
                                <div class="modal-footer">
                                    <button wire:click="close" type="button" class="btn btn-danger"
                                        data-dismiss="modal">Cancelar</button>                                    
                                    <input class="btn btn-primary" type="submit" value="Agregar" wire:loading.attr="disabled">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


            {{-- modal ajuste inicial --}}
            <div>
                <form wire:submit.prevent="updateAjuste">
                    <div wire:ignore.self class="modal fade" id="modalAjusteInicial" tabindex="-1" role="dialog"
                        aria-labelledby="modalAjusteInicialTitle" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalAjusteInicialTitle">Editar Ajuste Inicial</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                        wire:click="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">                                    
                                    <div id="divAjusteInciial" class="bg-white shadow rounded-lg mb-2">
                                        <table class="table table-sm" style="border-collapse: separate;">
                                            <thead class="table-secondary border border-secondary">
                                                <tr>
                                                    <th colspan="2" class="border border-secondary align-middle text-center text-sm">Estado</th>
                                                    <th class="border border-secondary align-middle text-center text-sm">Total Días Calendario</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>                                   
                                                <tr>
                                                    <td colspan="2" class="border border-secondary text-xs align-middle">VAC. LEGALES L-V</td>
                                                    <td colspan="2" class="border border-secondary text-xs text-center">
                                                        <input type="number" min="-100" max="100" wire:model="vac_legales_lv"/>
                                                    </td>                                                    
                                                </tr> 
                                                <tr>
                                                    <td colspan="2" class="border border-secondary text-xs align-middle">VAC. LEGALES L-D</td>
                                                    <td colspan="2" class="border border-secondary text-xs text-center">
                                                        <input type="number" min="-100" max="100" wire:model="vac_legales_ld"/>
                                                    </td>                                                    
                                                </tr> 
                                                <tr>
                                                    <td colspan="2" class="border border-secondary text-xs align-middle">EMBARCO 1X1</td>
                                                    <td colspan="2" class="border border-secondary text-xs text-center">
                                                        <input type="number" min="-100" max="100" wire:model="embarco_1x1"/>
                                                    </td>                                                                                                   
                                                </tr> 
                                                <tr>
                                                    <td colspan="2" class="border border-secondary text-xs align-middle">AJUSTE DESCANSO</td>
                                                    <td colspan="2" class="border border-secondary text-xs text-center">
                                                        <input type="number" min="-100" max="100" wire:model="ajuste_descanso"/>
                                                    </td>                                                    
                                                </tr> 
                                                <tr>
                                                    <td colspan="2" class="border border-secondary text-xs align-middle">FERIADO PROGRESIVO</td>
                                                    <td colspan="2" class="border border-secondary text-xs text-center">
                                                        <input type="number" min="-100" max="100" wire:model="feriado_progresivo"/>
                                                    </td>                                                    
                                                </tr>                                                                                
                                            </tbody>
                                        </table>
                                    </div>                                                                              
                                </div>
                                <div class="modal-footer">
                                    <button wire:click="closeAjuste" type="button" class="btn btn-danger"
                                        data-dismiss="modal">Cancelar</button>                                    
                                    <input class="btn btn-primary" type="submit" value="Editar" wire:loading.attr="disabled">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
