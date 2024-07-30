<div>
    {{-- The Master doesn't talk, he acts. --}}
    <?php
    use App\Http\Controllers\CarbonController;
    use App\Http\Controllers\Admin\ParameterDocController;
    
    $fecha = new CarbonController();
    
    $parameterdocs = new ParameterDocController();
    $parameters = $parameterdocs->getParameterDocs();
    $flag_red = $parameters[0]['flag_red'];
    $flag_orange = $parameters[0]['flag_orange'];
    $flag_yellow = $parameters[0]['flag_yellow'];
    $flag_green = $parameters[0]['flag_green'];
    $docs_persona = [];
    
    ?>
    <div class="card">
        @if ($rango_documentos->count() || $persona->documento->count())
            <div class="card-body table-responsive" style="max-height: 780px; padding:0%;">

                {{-- {{$rango_documentos}} --}}
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>N° Curso</th>
                            <th>Código OMI</th>
                            <th>Nombre</th>
                            {{-- <th>Name</th> --}}
                            {{-- <th>¿Obligatorio?</th> --}}
                            {{-- <th>Fecha Inicio</th> --}}
                            <th>Fecha Vencimiento</th>
                            <th>Archivo</th>
                            <th>¿Pendiente?</th>
                            <th colspan="1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- documentos por rango --}}
                        @foreach ($rango_documentos as $rango_documento)
                            <tr>
                                <form>
                                    <td class="align-middle text-center">{{ $rango_documento->id }}</td>
                                    <td class="align-middle text-center">{{ $rango_documento->nr_documento }}</td>
                                    <td class="align-middle text-center">{{ $rango_documento->codigo_omi }}</td>
                                    <td>{{ $rango_documento->nombre }}</td>
                                    <td class="align-middle text-center">
                                        <?php $fc_fin = null;
                                        $estado = false;
                                        $archivo_guardado = null; ?>
                                        @foreach ($persona->documento as $documento)
                                            @if ($documento->pivot->documento_id == $rango_documento->id)
                                                <?php
                                                array_push($docs_persona, $documento);
                                                if ($documento->pivot->fc_fin) {
                                                    $fc_fin = $documento->pivot->fc_fin;
                                                    $diff = $fecha->diffFechaActual($fc_fin);
                                                    $fc_fin = $fecha->formatodmY($fc_fin);
                                                }
                                                $estado = $documento->pivot->estado;
                                                $semaforo = $documento->pivot->semaforo;
                                                $archivo_guardado = $documento->pivot->nm_archivo_guardado;
                                                ?>
                                            @endif
                                        @endforeach
                                        {{-- {{ Form::text('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: red; border-left-width: thick;', 'disabled']) }} --}}
                                        @if ($estado == 0)
                                            @if ($fc_fin != null)
                                                {{-- @if ($diff <= $flag_red) --}}
                                                @if ($semaforo == "2")
                                                    {{ Form::text('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: red; border-left-width: thick;', 'disabled']) }}
                                                {{-- @elseif($diff > $flag_red && $diff < $flag_orange) --}}
                                                @elseif ($semaforo == "3")
                                                    {{ Form::text('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: orange; border-left-width: thick;', 'disabled']) }}
                                                {{-- @elseif($diff > $flag_orange && $diff < $flag_yellow) --}}
                                                @elseif ($semaforo == "4")
                                                    {{ Form::text('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: yellow; border-left-width: thick;', 'disabled']) }}
                                                @else
                                                    {{ Form::text('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: green; border-left-width: thick;', 'disabled']) }}
                                                @endif
                                            @else
                                                --
                                            @endif
                                        @else
                                            @if ($fc_fin != null)
                                                {{ Form::text('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: black; border-left-width: thick;', 'disabled']) }}
                                            @else
                                                --
                                            @endif
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if ($archivo_guardado)
                                            Si
                                        @else
                                            No
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if ($estado == 0)
                                            No
                                        @else
                                            Si
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <input wire:click="edit({{ $rango_documento->id }})" type="button"
                                            value="Editar" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#modalEditDocPersona" data-backdrop="static"
                                            data-keyboard="false">
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                        {{-- documentos asociados al tipo de nave por rango --}}
                        {{-- se deben mostrar solo los documentos que no se encontraban asociados al rango --}}
                        {{-- valida si persona tiene documentos ingresados --}}
                        {{-- @if ($persona->ship->ship_tipo->documentos->count()) --}}
                        {{-- recorre todos los documentos asociados al tipo de nave --}}
                        @if ($persona->ship_id)
                            @if ($persona->ship->ship_tipo)
                                @foreach ($persona->ship->ship_tipo->documentos as $docsTipoNave)
                                    <?php $cn = 0; ?>
                                    {{-- valida si el documento corresponde al rango de la persona --}}
                                    @if ($docsTipoNave->pivot->rango_id == $persona->rango_id)
                                        {{-- recorre los documentos asociados al rango y valida que no se repita en los asociados al tipo de nave --}}
                                        @foreach ($rango_documentos as $rango_documento)
                                            @if ($docsTipoNave->id == $rango_documento->id)
                                                <?php $cn++; ?>
                                            @endif
                                        @endforeach
                                        @if ($cn == 0)
                                            <tr>
                                                <form>
                                                    <td class="align-middle text-center">{{ $docsTipoNave->id }}</td>
                                                    <td class="align-middle text-center">
                                                        {{ $docsTipoNave->nr_documento }}
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        {{ $docsTipoNave->codigo_omi }}
                                                    </td>
                                                    <td>{{ $docsTipoNave->nombre }}</td>
                                                    <td class="align-middle text-center">
                                                        <?php $fc_fin = null;
                                                        $estado = false;
                                                        $archivo_guardado = null; ?>
                                                        @foreach ($persona->documento as $documento)
                                                            @if ($documento->pivot->documento_id == $docsTipoNave->id)
                                                                <?php
                                                                array_push($docs_persona, $documento);
                                                                if ($documento->pivot->fc_fin) {
                                                                    $fc_fin = $documento->pivot->fc_fin;
                                                                    //$diff = $fecha->diffFechaActual($fc_fin);
                                                                    $fc_fin = $fecha->formatodmY($fc_fin);
                                                                }
                                                                $estado = $documento->pivot->estado;
                                                                $semaforo = $documento->pivot->semaforo;
                                                                $archivo_guardado = $documento->pivot->nm_archivo_guardado;
                                                                ?>
                                                            @endif
                                                        @endforeach
                                                        <?php echo $semaforo; ?>
                                                        @if ($estado == 0)
                                                            @if ($fc_fin != null)
                                                                {{-- @if ($diff <= $flag_red) --}}
                                                                @if ($semaforo == "2")
                                                                    {{ Form::text('fc_fin' . $docsTipoNave->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: red; border-left-width: thick;', 'disabled']) }}
                                                                {{-- @elseif($diff > $flag_red && $diff < $flag_orange) --}}
                                                                @elseif ($semaforo == "3")
                                                                    {{ Form::text('fc_fin' . $docsTipoNave->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: orange; border-left-width: thick;', 'disabled']) }}
                                                                {{-- @elseif($diff > $flag_orange && $diff < $flag_yellow) --}}
                                                                @elseif ($semaforo == "4")
                                                                    {{ Form::text('fc_fin' . $docsTipoNave->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: yellow; border-left-width: thick;', 'disabled']) }}
                                                                @else
                                                                    {{ Form::text('fc_fin' . $docsTipoNave->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: green; border-left-width: thick;', 'disabled']) }}
                                                                @endif
                                                            @else
                                                                --
                                                            @endif
                                                        @else
                                                            @if ($fc_fin != null)
                                                                {{ Form::text('fc_fin' . $docsTipoNave->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: black; border-left-width: thick;', 'disabled']) }}
                                                            @else
                                                                --
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        @if ($archivo_guardado)
                                                            Si
                                                        @else
                                                            No
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        @if ($estado == 0)
                                                            No
                                                        @else
                                                            Si
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <input wire:click="edit({{ $docsTipoNave->id }})"
                                                            type="button" value="Editar" class="btn btn-primary btn-sm"
                                                            data-toggle="modal" data-target="#modalEditDocPersona"
                                                            data-backdrop="static" data-keyboard="false">
                                                    </td>
                                                </form>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        @endif
                        {{-- @endif --}}
                        {{-- documentos de la persona no asociados al rango (cambio de rango mantiene documentos de la persona) --}}
                        @foreach ($persona->documento as $documento)
                            <?php $cn = 0; ?>
                            @if ($docs_persona)
                                @foreach ($docs_persona as $doc_persona)
                                    @if ($doc_persona->pivot->documento_id == $documento->id)
                                        <?php $cn++; ?>
                                    @endif
                                @endforeach
                            @endif
                            @if ($cn == 0)
                                <tr>
                                    <form>
                                        <td class="align-middle text-center">{{ $documento->id }}</td>
                                        <td class="align-middle text-center">{{ $documento->nr_documento }}</td>
                                        <td class="align-middle text-center">{{ $documento->codigo_omi }}</td>
                                        <td>{{ $documento->nombre }}</td>
                                        <td class="align-middle text-center">
                                            <?php $fc_fin = null;
                                            $estado = false;
                                            $archivo_guardado = null;
                                            if ($documento->pivot->fc_fin) {
                                                $fc_fin = $documento->pivot->fc_fin;
                                                $diff = $fecha->diffFechaActual($fc_fin);
                                                $fc_fin = $fecha->formatodmY($fc_fin);
                                            }
                                            $estado = $documento->pivot->estado;
                                            $semaforo = $documento->pivot->semaforo;
                                            $archivo_guardado = $documento->pivot->nm_archivo_guardado;
                                            ?>
                                            <?php echo $semaforo; ?>
                                            @if ($estado == 0)
                                                @if ($fc_fin != null)
                                                    {{-- @if ($diff <= $flag_red) --}}                                                    
                                                    @if($semaforo == '2')
                                                        {{ Form::text('fc_fin' . $documento->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: red; border-left-width: thick;', 'disabled']) }}
                                                    {{-- @elseif($diff > $flag_red && $diff < $flag_orange) --}}
                                                    @elseif($semaforo == '3')
                                                        {{ Form::text('fc_fin' . $documento->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: orange; border-left-width: thick;', 'disabled']) }}
                                                    {{-- @elseif($diff > $flag_orange && $diff < $flag_yellow) --}}
                                                    @elseif($semaforo == '4')
                                                        {{ Form::text('fc_fin' . $documento->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: yellow; border-left-width: thick;', 'disabled']) }}
                                                    @else
                                                        {{ Form::text('fc_fin' . $documento->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: green; border-left-width: thick;', 'disabled']) }}
                                                    @endif
                                                @else
                                                    --
                                                @endif
                                            @else
                                                @if ($fc_fin != null)
                                                    {{ Form::text('fc_fin' . $documento->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: black; border-left-width: thick;', 'disabled']) }}
                                                @else
                                                    --
                                                @endif
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($archivo_guardado)
                                                Si
                                            @else
                                                No
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($estado == 0)
                                                No
                                            @else
                                                Si
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <input wire:click="edit({{ $documento->id }})" type="button"
                                                value="Editar" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#modalEditDocPersona" data-backdrop="static"
                                                data-keyboard="false">
                                        </td>
                                    </form>
                                </tr>
                            @endif
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
            <div wire:ignore.self class="modal fade" id="modalEditDocPersona" tabindex="-1" role="dialog"
                aria-labelledby="modalEditDocPersonaTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditDocPersonaTitle">Editar Documento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                wire:click="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- <div style="height:620px;"> --}}
                            {{-- <form wire:submit.prevent="update"> --}}
                            <div>
                                <div class="row">
                                    <label for="nr_curso_edit" class="col-sm-2 col-form-label">N° Curso</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly disabled class="form-control-plaintext"
                                            wire:model="nr_documento" id="nr_curso_edit">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="codigo_omi_edit" class="col-sm-2 col-form-label">Código OMI</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly disabled class="form-control-plaintext"
                                            wire:model="codigo_omi" id="codigo_omi_edit">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="nombre_edit" class="col-sm-2 col-form-label">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly disabled class="form-control-plaintext"
                                            wire:model="nombre" id="nombre_edit">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label">Fecha Inicio</label>
                                            <div class="col-sm-6">
                                                <input type="date" name="" id=""
                                                    class="form-control form-control-sm" wire:model="fc_inicio">
                                                @error('fc_inicio')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <label class="col-sm-6 col-form-label">Fecha Vencimiento</label>
                                            <div class="col-sm-6">
                                                <input type="date" name="" id=""
                                                    class="form-control form-control-sm" wire:model="fc_fin">
                                                @error('fc_fin')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="estado_edit" class="col-sm-2 col-form-label">¿Pendiente?</label>
                                    <div class="col-sm-10 mt-2">
                                        <input type="checkbox" class="mt-2" wire:model="estado" />
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Certificado</label>
                                    <div class="col-sm-10 mx-0 my-0">
                                        <input type="file" accept="application/pdf" wire:model="archivo"
                                            id="{{ $identificador }}">
                                        @error('archivo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mx-0">
                                    @if ($archivo)
                                        <embed src="{{ $archivo->temporaryUrl() }}" width="100%" height="400px" />
                                    @else
                                        @if ($nm_archivo_guardado)
                                            <embed src="{{ asset('storage/' . $nm_archivo_guardado) }}"
                                                width="100%" height="400px" />
                                        @endif
                                    @endif
                                </div>

                                <div class="mb-0 mt-2 text-red" wire:loading wire:target="archivo">Cargando...</div>

                                <div class="mb-0 mt-2 text-red" wire:loading wire:target="edit">
                                    Procesando...
                                </div>
                                <div class="mb-0 mt-2 text-red" wire:loading wire:target="update">
                                    Procesando...
                                </div>
                            </div>
                            {{-- </form> --}}
                        </div>
                        <div class="modal-footer">
                            <button wire:click="close" type="button" class="btn btn-danger"
                                data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary"
                                wire:loading.attr="disabled">Editar</button>

                            {{-- <button type="submit">Save Photo</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
