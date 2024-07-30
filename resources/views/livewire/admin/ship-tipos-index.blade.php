<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    {!! Form::label('tipoFilter', 'Nombre') !!}
                    <input wire:model="tipoFilter" class="form-control" placeholder="Ingrese nombre de tipo de nave">
                </div>
                <div class="col-4">
                    {!! Form::label('estadoFilter', 'Estado Tipo Nave') !!}
                    <select wire:model="estadoFilter" class="form-control">
                        <option value="">Todos</option>
                        <option value="1">Activos</option>
                        <option value="2">Inactivos</option>
                    </select>
                </div>
            </div>
        </div>
        @if ($ship_tipos->count())
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th colspan="3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ship_tipos as $ship_tipo)
                            <tr>
                                <td>{{ $ship_tipo->id }}</td>
                                <td>{{ $ship_tipo->nombre }}</td>
                                <td>
                                    @if ($ship_tipo->estado == 1)
                                        Activo
                                    @else
                                        Inactivo
                                    @endif
                                </td>
                                <td width="10px">
                                    <a class="btn btn-success btn-sm"
                                        href="{{ route('admin.ship_tipos.show', $ship_tipo) }}">Documentos</a>
                                </td>
                                <td width="10px">
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('admin.ship_tipos.edit', $ship_tipo) }}">Editar</a>
                                </td>
                                <td width="10px">
                                    @can('mantencion.ship_tipos.destroy')
                                        @if ($ship_tipo->estado == 2)
                                            {{-- <form action="{{ route('admin.ship_tipos.destroy', $ship_tipo) }}"
                                                method="POST" class="formulario-eliminar">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                            </form> --}}

                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="$emit('delTipoNave', {{ $ship_tipo->id }})">Eliminar</button>
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
