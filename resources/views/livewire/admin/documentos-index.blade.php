<div class="card">
    {{-- <div class="card-header">
        <input wire:model="search" class="form-control" placeholder="Ingrese nombre del documento">
    </div> --}}

    <div class="card-header">
        <div class="row">
            <div class="col-8">
                {!! Form::label('documentoFilter', 'Nombre') !!}
                <input wire:model="documentoFilter" class="form-control" placeholder="Ingrese nombre de documento">
            </div>
            <div class="col-4">
                {!! Form::label('estadoFilter', 'Estado Documento') !!}
                <select wire:model="estadoFilter" class="form-control">
                    <option value="">Todos</option>
                    <option value="1">Activos</option>
                    <option value="2">Inactivos</option>
                </select>
            </div>
        </div>
    </div>

    @if ($documentos->count())
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>N° Curso</th>
                        <th>Código OMI</th>
                        <th>Nombre</th>
                        <th>Name</th>
                        <th>Estado</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documentos as $documento)
                        <tr>
                            <td>{{ $documento->id }}</td>
                            <td>{{ $documento->nr_documento }}</td>
                            <td>{{ $documento->codigo_omi }}</td>
                            <td>{{ $documento->nombre }}</td>
                            <td>{{ $documento->name }}</td>
                            @if ($documento->estado == 1)
                                <td>Activo</td>
                            @else
                                <td>Inactivo</td>
                            @endif
                            <td width="10px">
                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('admin.documentos.edit', $documento) }}">Editar</a>
                            </td>
                            <td width="10px">
                                @can('mantencion.documentos.destroy')
                                    @if ($documento->estado == 2){{-- 
                                        <form action="{{ route('admin.documentos.destroy', $documento) }}" method="POST"
                                            class="formulario-eliminar">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                        </form> --}}
                                        <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="$emit('delDocumento', {{ $documento->id }})">Eliminar</button>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- <div class="card-footer">
            {{$documentos->links()}}
        </div> --}}
    @else
        <div class="card-body">
            <strong>No hay ningún registro...</strong>
        </div>
    @endif
</div>
