<div>
    <div class="card">

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
                            {{-- <th>ID</th> --}}
                            <th>N° Curso</th>
                            <th>Código OMI</th>
                            <th>Nombre</th>
                            <th>Name</th>
                            <th>Estado</th>
                            <th class="align-middle text-center">Rangos Asignados</th>
                            <th colspan="1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documentos as $documento)
                            <tr>
                                {{-- <td>{{ $documento->id }}</td> --}}
                                <td class="align-middle text-center">{{ $documento->nr_documento }}</td>
                                <td class="align-middle text-center">{{ $documento->codigo_omi }}</td>
                                <td class="align-middle">{{ $documento->nombre }}</td>
                                <td class="align-middle">{{ $documento->name }}</td>
                                @if ($documento->estado == 1)
                                    <td class="align-middle text-center">Activo</td>
                                @else
                                    <td class="align-middle text-center">Inactivo</td>
                                @endif
                                <td class="align-middle text-center">{{ $this->getCountRangosByIdDocumento($documento->id) }}</td>
                                <td class="align-middle text-center">
                                    <input wire:click="asignarRango({{ $documento->id }})" type="button"
                                        value="Asignar" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#modalAsignarRango" data-backdrop="static" data-keyboard="false">
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

    <div>
        <form wire:submit.prevent="update">
            <div wire:ignore.self class="modal fade" id="modalAsignarRango" tabindex="-1" role="dialog"
                aria-labelledby="modalAsignarRangoTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAsignarRangoTitle">Asignar Rangos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                wire:click="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- <div style="height:620px;"> --}}
                            {{-- <form wire:submit.prevent="update"> --}}
                            <div>                                
                                <table class="table table-striped table-sm">
                                    <tbody>
                                        <?php $count = count($rangos); ?>
                                        @foreach ($rangos as $key => $rango)                                            
                                            @if ($key % 2 == 0)
                                                <tr style="border-top-style: double; border-bottom-style: double;">
                                                    <td 
                                                        style="cursor: pointer; border-left-style: double;"
                                                        class="align-middle text-center">                                                        
                                                        <input type="checkbox" wire:model="selRangos" value="{{ $rango->id }}" style="accent-color: green; width: 40px; height: 20px;"/>                                                      
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        {{ $rango->nombre }}
                                                    </td>
                                                    
                                                    @if ($count == $key)
                                                        </tr>
                                                    @endif
                                            @else
                                                <td
                                                    style="cursor: pointer; border-left-style: double;"
                                                    class="align-middle text-center">                                                    
                                                    <input type="checkbox" wire:model="selRangos" value="{{ $rango->id }}"  style="accent-color: green; width: 40px; height: 20px;"/>
                                                </td>
                                                <td class="align-middle text-center" style="border-right-style: double;">
                                                    {{ $rango->nombre }}
                                                </td>
                                                
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- </form> --}}
                        </div>
                        <div class="modal-footer">
                            <button wire:click="close" type="button" class="btn btn-danger"
                                data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Asignar</button>                            
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
