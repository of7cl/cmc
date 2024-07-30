<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    {!! Form::label('rangoFilter', 'Nombre') !!}
                    <input wire:model="rangoFilter" class="form-control" placeholder="Ingrese nombre de rango">
                </div>
                <div class="col-4">
                    {!! Form::label('estadoFilter', 'Estado Rango') !!}
                    <select wire:model="estadoFilter" class="form-control">
                        <option value="">Todos</option>
                        <option value="1">Activos</option>
                        <option value="2">Inactivos</option>
                    </select>
                </div>
            </div>
        </div>
        @if ($rangos->count())
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th># Documentos</th>
                            <th colspan="3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rangos as $rango)
                            <tr>
                                <td>{{ $rango->id }}</td>
                                <td>{{ $rango->codigo }}</td>
                                <td>{{ $rango->nombre }}</td>
                                @if ($rango->estado == 1)
                                    <td>Activo</td>
                                @else
                                    <td>Inactivo</td>
                                @endif
                                <td class="text-align: center">({{ $rango->documentos->count() }})</td>
                                <td width="10px">
                                    <a class="btn btn-success btn-sm"
                                        href="{{ route('admin.rangos.show', $rango) }}">Documentos</a>
                                </td>
                                <td width="10px">
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('admin.rangos.edit', $rango) }}">Editar</a>
                                </td>
                                <td width="10px">
                                    @can('mantencion.rangos.destroy')
                                        @if ($rango->estado == 2)
                                            {{-- <form action="{{route('admin.rangos.destroy', $rango)}}" method="POST" class="formulario-eliminar">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                </form> --}}
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="$emit('delRango', {{ $rango->id }})">Eliminar</button>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- <div class="card-footer table-responsive">
                {{ $rangos->links() }}
            </div> --}}
        @else
            <div class="card-body">
                <strong>No hay ningún registro...</strong>
            </div>
        @endif
    </div>
</div>
