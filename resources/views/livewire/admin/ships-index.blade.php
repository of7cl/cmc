<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    {!! Form::label('naveFilter', 'Nombre Nave') !!}
                    <input wire:model="naveFilter" class="form-control" placeholder="Ingrese nombre de la nave">
                </div>
                <div class="col-3">
                    {!! Form::label('tipoFilter', 'Tipo de Nave') !!}
                    <select wire:model="tipoFilter" class="form-control">
                        <option value="">Todos</option>
                        @foreach ($tiposNave as $tipoNave)
                            <option value="{{ $tipoNave->id }}">{{ $tipoNave->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    {!! Form::label('estadoFilter', 'Estado Nave') !!}
                    <select wire:model="estadoFilter" class="form-control">
                        <option value="">Todos</option>
                        <option value="1">Activos</option>
                        <option value="2">Inactivos</option>
                    </select>
                </div>
            </div>
        </div>
        @if ($ships->count())
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
                            <th>Estado</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ships as $ship)
                            <tr>
                                <td>{{ $ship->id }}</td>
                                <td>{{ $ship->codigo }}</td>
                                <td>{{ $ship->nombre }}</td>
                                <td>
                                    @if ($ship->ship_tipo_id)
                                        {{ $ship->ship_tipo->nombre }}
                                    @endif
                                </td>
                                <td>{{ $ship->imo }}</td>
                                <td>{{ $ship->dwt }}</td>
                                <td>{{ $ship->trg }}</td>
                                <td>{{ $ship->loa }}</td>
                                <td>{{ $ship->manga }}</td>
                                <td>
                                    @if ($ship->estado == 1)
                                        Activo
                                    @else
                                        Inactivo
                                    @endif
                                </td>
                                <td width="10px">
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('admin.ships.edit', $ship) }}">Editar</a>
                                </td>
                                <td width="10px">
                                    {{-- <form action="{{route('admin.ships.destroy', $ship)}}" method="POST" class="formulario-eliminar">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                </form> --}}
                                    @can('mantencion.ships.destroy')
                                        @if ($ship->estado == 2)
                                            {{-- <form action="{{ route('admin.ships.destroy', $ship) }}" method="POST"
                                                class="formulario-eliminar">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                            </form> --}}
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="$emit('delNave', {{ $ship->id }})">Eliminar</button>
                                        @endif
                                    @endcan
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
</div>
