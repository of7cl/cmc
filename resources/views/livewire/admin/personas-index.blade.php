<div class="card">
    <div class="card-header">
        {{-- <input wire:model="search" class="form-control" placeholder="Ingrese nombre de la persona"> --}}
        <div class="row">
            <div class="col-4">
                {!! Form::label('search', 'Nombre') !!}
                <input wire:model="search" class="form-control" placeholder="Ingrese nombre de la persona">
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
            <div class="col-3">
                {!! Form::label('naveFilter', 'Nave') !!}
                <select wire:model="naveFilter" class="form-control">
                    <option value="">Seleccione Nave...</option>
                    @foreach ($ships as $ship)
                        <option value="{{ $ship->id }}">{{ $ship->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-2">
                {!! Form::label('estadoFilter', 'Estado Persona') !!}
                <select wire:model="estadoFilter" class="form-control">
                    <option value="">Todos</option>
                    <option value="1">Activos</option>
                    <option value="2">Inactivos</option>
                    {{-- @foreach ($rangos as $rango)
                        <option value="{{ $rango->id }}">{{ $rango->nombre }}</option>
                    @endforeach --}}
                </select>
            </div>
        </div>
    </div>

    @if ($personas->count())
        <div class="card-body table-responsive">
            <form>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>RUT</th>
                            <th>Rango</th>
                            <th>Nave</th>
                            <th>Contrato</th>
                            <th>Fecha Ingreso</th>
                            {{-- <th>Fecha Baja</th>
                        <th>Fecha Nacimiento</th> --}}
                            <th>Estado</th>
                            <th colspan="3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($personas as $persona)
                            {{-- <tr ondblclick="alert('dobleclic')" href="{{ route('admin.personas.show', $persona->id) }}"> --}}
                            <tr>
                                <td>{{ $persona->id }}</td>
                                <td>{{ $persona->nombre }}</td>
                                <td>{{ $persona->rut }}</td>
                                <td>
                                    @if ($persona->rango_id)
                                        {{ $persona->rango->nombre }}
                                    @endif
                                </td>
                                <td>
                                    @if ($persona->ship_id)
                                        {{ $persona->ship->nombre }}
                                    @endif
                                </td>
                                <td>
                                    @if ($persona->contrato_tipo_id)
                                        {{ $persona->contratoTipo->name }}
                                    @endif
                                </td>
                                <td>
                                    @if ($persona->fc_ingreso)
                                        {{ date('d-m-Y', strtotime($persona->fc_ingreso)) }}
                                    @endif
                                </td>
                                <td>
                                    @if ($persona->estado == 1)
                                        Activo
                                    @else
                                        Inactivo
                                    @endif
                                </td>
                                {{-- <td>
                                @if ($persona->fc_baja)
                                    {{date('d-m-Y', strtotime($persona->fc_baja))}}
                                @endif                                
                            </td>                            
                            <td>
                                @if ($persona->fc_nacimiento)
                                    {{date('d-m-Y', strtotime($persona->fc_nacimiento))}}
                                @endif                                
                            </td> --}}
                                <td width="10px">
                                    <a class="btn btn-success btn-sm"
                                        href="{{ route('admin.personas.show', $persona->id) }}">Documentos</a>
                                </td>
                                <td width="10px">
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('admin.personas.edit', $persona) }}">Editar</a>
                                </td>

                                <td width="10px">
                                    @can('mantencion.personas.destroy')
                                        @if ($persona->estado == 2)
                                            {{-- <form action="{{ route('admin.personas.destroy', $persona) }}" method="POST"
                                            class="formulario-eliminar">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                        </form> --}}
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="$emit('delPersona', {{ $persona->id }})">Eliminar</button>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
        {{-- <div class="card-footer table-responsive">
            {{ $personas->links() }}
        </div> --}}
    @else
        <div class="card-body">
            <strong>No hay ningún registro...</strong>
        </div>
    @endif
</div>
