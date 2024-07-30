<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-9">
                    {!! Form::label('descripcionFilter', 'Descripcion Feriado') !!}
                    <input wire:model="descripcionFilter" class="form-control" placeholder="Ingrese descripción de feriado">
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
        @if ($feriados->count())
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($feriados as $feriado)
                            <tr>
                                <td>{{ $feriado->id }}</td>
                                <td>
                                    @if ($feriado->fc_feriado)
                                        {{ date('d-m-Y', strtotime($feriado->fc_feriado)) }}
                                    @endif
                                </td>
                                <td>{{ $feriado->descripcion }}</td>
                                <td>
                                    @if ($feriado->estado == 1)
                                        Activo
                                    @else
                                        Inactivo
                                    @endif
                                </td>
                                <td width="10px">
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('admin.feriados.edit', $feriado) }}">Editar</a>
                                </td>
                                <td width="10px">
                                    {{-- <form action="{{route('admin.ships.destroy', $ship)}}" method="POST" class="formulario-eliminar">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                </form> --}}
                                    @can('mantencion.ships.destroy')
                                        @if ($feriado->estado == 2)
                                            {{-- <form action="{{ route('admin.ships.destroy', $ship) }}" method="POST"
                                                class="formulario-eliminar">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                            </form> --}}
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="$emit('delFeriado', {{ $feriado->id }})">Eliminar</button>
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
