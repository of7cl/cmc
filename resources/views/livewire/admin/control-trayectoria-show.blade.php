<div>
    <div class="card">
        <div class="card-header">
            <div class="row">
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
                    {{ $persona->fc_ingreso }}
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label for="">RUT:</label>
                    {{ $persona->rut }}
                </div>
                <div class="col-4">
                    <label for="">Nacimiento:</label>
                    {{ $persona->fc_nacimiento }}
                </div>
                <div class="col-4">
                    <label for="">Tipo de Contrato:</label>
                    {{ $persona->rango->nombre }}
                </div>
            </div>
        </div>
        <div class="card-body table-responsive "style="max-height: 680px;">
            {{-- cabecera --}}
            <div>
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
                                    <th class="border border-secondary align-middle text-center text-sm">Total (Días)
                                    </th>
                                    <th class="border border-secondary align-middle text-center text-sm">Factor</th>
                                    <th colspan="2" class="border border-secondary align-middle text-center text-sm">
                                        Total de
                                        días
                                        acumulados</th>
                                    <th colspan="2" class="border border-secondary align-middle text-center text-sm">
                                        Total de
                                        días
                                        consumidos</th>
                                    <th colspan="2" class="border border-secondary align-middle text-center text-sm">
                                        Total de
                                        días
                                        pendientes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2" class="border border-secondary text-xs">Sistema Antiguo</td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td colspan="2"
                                        class="border border-secondary text-sm align-middle text-center text-xs">
                                    </td>
                                    <td colspan="2"
                                        class="border border-secondary text-sm align-middle text-center text-xs">
                                    </td>
                                    <td colspan="2"
                                        class="border border-secondary text-sm align-middle text-center text-xs">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border border-secondary text-xs">Decreto Supremo 26
                                        (Actual)
                                    </td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td colspan="2"
                                        class="border border-secondary text-sm align-middle text-center text-xs">
                                    </td>
                                    <td colspan="2"
                                        class="border border-secondary text-sm align-middle text-center text-xs">
                                    </td>
                                    <td colspan="2"
                                        class="border border-secondary text-sm align-middle text-center text-xs">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border border-secondary text-xs">Días Progresivos</td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td colspan="2"
                                        class="border border-secondary text-sm align-middle text-center text-xs">
                                    </td>
                                    <td colspan="2"
                                        class="border border-secondary text-sm align-middle text-center text-xs">
                                    </td>
                                    <td colspan="2"
                                        class="border border-secondary text-sm align-middle text-center text-xs">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border border-secondary text-xs">Días 1x1</td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td colspan="2"
                                        class="border border-secondary text-sm align-middle text-center text-xs">
                                    </td>
                                    <td colspan="2"
                                        class="border border-secondary text-sm align-middle text-center text-xs">
                                    </td>
                                    <td colspan="2"
                                        class="border border-secondary text-sm align-middle text-center text-xs">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border border-secondary text-xs">Descanso</td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td class="border border-secondary text-sm align-middle text-center text-xs"></td>
                                    <td colspan="2"
                                        class="border border-secondary text-sm align-middle text-center text-xs">
                                    </td>
                                    <td colspan="2"
                                        class="border border-secondary text-sm align-middle text-center text-xs">
                                    </td>
                                    <td colspan="2"
                                        class="border border-secondary text-sm align-middle text-center text-xs">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>

            {{-- formulario --}}
            <div>
                <div class="mx-1 d-flex flex-row-reverse">
                    <button wire:click="$toggle('showFormulario')" id="btnFormulario" type="button"
                        class="btn btn-outline-secondary btn-xs">
                        @if ($showFormulario)
                            Ocultar Formulario
                        @else
                            Mostrar Formulario
                        @endif
                    </button>
                </div>
                @if ($showFormulario)
                    <div class="bg-white shadow rounded-lg mb-2">
                        <form wire:submit.prevent="saveDetalle">
                            <div class="row ml-2 mr-2">
                                <div class="col-3 mt-2">
                                    <label for="">Agregar Detalle</label>
                                </div>
                            </div>
                            <div class="row ml-2 mr-2">
                                <div class="col-3">
                                    <label for="">Nave</label>
                                </div>
                                <div class="col-3">
                                    <label for="">Estado</label>
                                </div>
                                <div class="col-3">
                                    <label for="">Desde</label>
                                </div>
                                <div class="col-3">
                                    <label for="">Hasta</label>
                                </div>
                            </div>
                            <div class="row ml-2 mr-2">
                                <div class="col-3 mb-2">
                                    <select class="form-control" wire:model="ship_id">
                                        <option value="" disabled>Seleccionar Nave...</option>
                                        @foreach ($ships as $ship)
                                            <option value="{{ $ship->id }}">{{ $ship->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <select class="form-control" wire:model="estado_id">
                                        <option value="" disabled>Seleccionar Estado...</option>
                                        @foreach ($estados as $estado)
                                            <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" wire:model="fc_desde">
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" wire:model="fc_hasta">
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
                    </div>
                    @if ($showDetalle)
                        <div id="divDetalle" class="bg-white shadow rounded-lg  table-responsive"
                            style="max-height: 560px; padding:0%;">
                            <table class="table table-sm" style="border-collapse: separate;">
                                <thead class="table-secondary border border-secondary"
                                    style="position: sticky; top:0;">
                                    <tr>
                                        <th colspan="1"
                                            class="border border-secondary align-middle text-center text-xs">
                                            Nave</th>
                                        <th colspan="1"
                                            class="border border-secondary align-middle text-center text-xs">
                                            Estado</th>
                                        <th colspan="1"
                                            class="border border-secondary align-middle text-center text-xs">
                                            Desde</th>
                                        <th colspan="1"
                                            class="border border-secondary align-middle text-center text-xs">
                                            Hasta</th>
                                        <th colspan="1"
                                            class="border border-secondary align-middle text-center text-xs">
                                            Total Días Calendario</th>
                                        <th colspan="1"
                                            class="border border-secondary align-middle text-center text-xs">
                                            Descanso Generado Según Convenio</th>
                                        <th colspan="1"
                                            class="border border-secondary align-middle text-center text-xs">
                                            Saldo Descanso</th>
                                        <th colspan="1"
                                            class="border border-secondary align-middle text-center text-xs">
                                            Días Vacaciones Consumidas</th>
                                        <th colspan="1"
                                            class="border border-secondary align-middle text-center text-xs">
                                            Días Inhábiles Generados</th>
                                        <th colspan="1"
                                            class="border border-secondary align-middle text-center text-xs">
                                            Días Inhábiles a Favor (1x1)</th>
                                        <th colspan="1"
                                            class="border border-secondary align-middle text-center text-xs">
                                            Días Inhábiles Consumidos (1x1)</th>
                                        <th colspan="1"
                                            class="border border-secondary align-middle text-center text-xs">
                                            Ajuste</th>
                                        <th colspan="1"
                                            class="border border-secondary align-middle text-center text-xs">
                                            Observaciones</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- {{$detallesTrayectoria}} --}}
                                    @if ($detallesTrayectoria)

                                        @foreach ($detallesTrayectoria as $detalleTrayectoria)
                                            <tr>
                                                <td colspan="1"
                                                    class="border border-secondary text-sm align-middle text-center">
                                                    {{ $detalleTrayectoria->ship->nombre }}
                                                </td>
                                                <td colspan="1"
                                                    class="border border-secondary text-sm align-middle text-center">
                                                    {{ $detalleTrayectoria->estado->nombre }}
                                                </td>
                                                <td colspan="1"
                                                    class="border border-secondary text-sm align-middle text-center">
                                                    {{ $detalleTrayectoria->fc_desde }}
                                                </td>
                                                <td colspan="1"
                                                    class="border border-secondary text-sm align-middle text-center">
                                                    {{ $detalleTrayectoria->fc_hasta }}
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
                        </div>
                    @endif                
                @endif
            </div>

        </div>

    </div>
</div>
