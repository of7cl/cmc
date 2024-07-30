<div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12">
                    @if (session()->has('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    {!! Form::label('rangoFilter', 'Rango') !!}
                    <select wire:model="rangoFilter" wire:change="getDocsRango" class="form-control">
                        <option value="" disabled>Seleccione Rango...</option>
                        @foreach ($rangos as $rango)
                            <option value="{{ $rango->id }}">{{ $rango->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @if ($rangoFilter != '')
            <form wire:submit.prevent="update">
                <div class="card-body">
                    <table class="table table-striped">
                        <tbody>
                    {{-- <h2 class="h5">Listado de documentos</h2> --}}
                            <?php $count = count($documentos); ?>
                            @foreach ($documentos as $key => $documento)
                                @if ($key % 2 == 0)
                                <tr>
                                    <td title="{{ $documento->nombre }}" style="cursor: pointer">
                                            {{-- <label title="{{ $documento->nombre }}" style="cursor: pointer"> --}}
                                                <input type="checkbox" wire:model="selDocs" value="{{ $documento->id }}" />
                                                {{ $documento->nr_documento }} - {{ $documento->codigo_omi }}
                                            {{-- </label> --}}
                                        </td>
                                        @if ($count == $key)
                                            </tr>
                                        @endif
                                @else
                                    <td title="{{ $documento->nombre }}" style="cursor: pointer">
                                        {{-- <label title="{{ $documento->nombre }}" style="cursor: pointer"> --}}
                                            <input type="checkbox" wire:model="selDocs" value="{{ $documento->id }}" />
                                            {{ $documento->nr_documento }} - {{ $documento->codigo_omi }}
                                        {{-- </label> --}}
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Asignar</button>
                </div>
            </form>
        @endif
    {{-- <div class="card-body table-responsive "style="max-height: 680px;">            
            @if ($rangoFilter != '')
                <div>
                    <div class="bg-white shadow rounded-lg mb-2">
                        <form wire:submit.prevent="saveDocumento">
                            <div class="row ml-2 mr-2">
                                <div class="col-3 mt-2">
                                    <label for="">Agregar Documento</label>
                                </div>
                            </div>
                            <div class="row ml-2 mr-2">
                                <div class="col-12 mb-2">
                                    <select class="form-control" wire:model="documento_id">
                                        <option value="" disabled>Seleccionar Documento...</option>
                                        @foreach ($documentos as $documento)
                                            <?php
                                            $nombre = '';
                                            if ($documento->codigo_omi == null && $documento->nombre == null) {
                                                $nombre = '';
                                            } elseif ($documento->codigo_omi == null && $documento->nombre != null) {
                                                $nombre = $documento->nombre;
                                            } elseif ($documento->codigo_omi != null && $documento->nombre == null) {
                                                $nombre = $documento->codigo_omi;
                                            } elseif ($documento->codigo_omi != null && $documento->nombre != null) {
                                                $nombre = $documento->codigo_omi . '-' . $documento->nombre;
                                            }
                                            ?>
                                            <option value="{{ $documento->id }}">{{ $nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('documento_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row ml-2 mr-2">
                                <div class="col-1 mb-2 mr-2">
                                    <input class="btn btn-secondary btn-sm" type="submit" value="Agregar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif            
            @if ($ship_tipo_documentos)
                <div>
                    <form>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>N° Curso</th>
                                    <th>Código OMI</th>
                                    <th>Nombre</th>
                                    <th>Name</th>
                                    <th>¿Obligatorio?</th>
                                    <th colspan="1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ship_tipo_documentos as $ship_tipo_documento)
                                    <tr>
                                        <td>{{ $ship_tipo_documento->id }}</td>
                                        <td>{{ $ship_tipo_documento->nr_documento }}</td>
                                        <td>{{ $ship_tipo_documento->codigo_omi }}</td>
                                        <td>{{ $ship_tipo_documento->nombre }}</td>
                                        <td>{{ $ship_tipo_documento->name }}</td>
                                        <td>
                                            @if ($ship_tipo_documento->pivot->obligatorio == 1)
                                                Si
                                            @else
                                                No
                                            @endif
                                        </td>
                                        <td width="10px">
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="$emit('deleteDoc', {{ $ship_tipo_documento->id }})">Eliminar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>            
            @endif
        </div> --}}
</div>

</div>
