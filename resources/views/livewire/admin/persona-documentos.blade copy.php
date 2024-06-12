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
    
    ?>
    <div class="card">
        @if ($rango_documentos)
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
                            <th>¿Obligatorio?</th>
                            {{-- <th>Fecha Inicio</th> --}}
                            <th>Fecha Vencimiento</th>
                            <th>Archivo</th>
                            <th>¿Pendiente?</th>
                            <th colspan="1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rango_documentos as $rango_documento)
                            <tr>
                                {{-- {!! Form::model($persona, ['route' => ['admin.personas.update', $persona], 'method' => 'put', 'files' => true]) !!} --}}
                                <form>
                                    <td class="align-middle text-center">{{ $rango_documento->id }}</td>
                                    <td class="align-middle text-center">{{ $rango_documento->nr_documento }}</td>
                                    <td class="align-middle text-center">{{ $rango_documento->codigo_omi }}</td>
                                    <td>{{ $rango_documento->nombre }}</td>
                                    {{-- <td>{{$rango_documento->name}}</td> --}}
                                    <td class="align-middle text-center">
                                        @if ($rango_documento->pivot->obligatorio == 1)
                                            Si
                                        @else
                                            No
                                        @endif
                                    </td>
                                    {{-- <td class="align-middle text-center">
                                    <?php //$fc_inicio = null;
                                    ?>
                                    @foreach ($persona->documento as $documento)
                                        @if ($documento->pivot->documento_id == $rango_documento->id)
                                            <?php //$fc_inicio = $documento->pivot->fc_inicio;
                                            ?>
                                        @endif
                                    @endforeach --}}
                                    {{-- {{ Form::date('fc_inicio' . $rango_documento->id, $fc_inicio, ['class' => 'form-control callout']) }} --}}
                                    {{-- @error('fc_inicio' . $rango_documento->id)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror --}}
                                    {{-- {{$fc_inicio}} --}}
                                    {{-- {{ Form::date('fc_inicio' . $rango_documento->id, $fc_inicio, ['class' => 'form-control', 'readonly' ]) }} --}}
                                    <?php //$fc_inicio = $fecha->formatodmY($fc_inicio);
                                    ?>
                                    {{-- <input type="text" name="" id="" style="width:120px" class="form-control callout" value="{{$fc_inicio}}" disabled> --}}
                                    {{-- {{ Form::text('fc_inicio' . $rango_documento->id, $fc_inicio, ['class' => 'form-control', 'style' => 'width:100px', 'disabled']) }} --}}
                                    {{-- </td> --}}
                                    <td class="align-middle text-center">
                                        <?php $fc_fin = null; ?>
                                        <?php $estado = false; ?>
                                        @foreach ($persona->documento as $documento)
                                            @if ($documento->pivot->documento_id == $rango_documento->id)
                                                <?php
                                                $fc_fin = $documento->pivot->fc_fin;
                                                $diff = $fecha->diffFechaActual($fc_fin);
                                                $estado = $documento->pivot->estado;
                                                ?>
                                            @endif
                                        @endforeach
                                        {{-- @if ($estado == 0)
                                        @if ($fc_fin != null)
                                            @if ($diff <= $flag_red)
                                                {{ Form::date('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control callout', 'style' => 'border-left-color: red']) }}
                                            @elseif($diff > $flag_red && $diff < $flag_orange)
                                                {{ Form::date('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control callout', 'style' => 'border-left-color: orange']) }}
                                            @elseif($diff > $flag_orange && $diff < $flag_yellow)
                                                {{ Form::date('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control callout', 'style' => 'border-left-color: yellow']) }}
                                            @else
                                                {{ Form::date('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control callout', 'style' => 'border-left-color: green']) }}
                                            @endif
                                        @else
                                            {{ Form::date('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control callout']) }}
                                        @endif
                                    @else
                                        {{ Form::date('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control callout', 'style' => 'border-left-color: black']) }}
                                    @endif --}}
                                        {{-- @error('fc_fin' . $rango_documento->id)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror --}}
                                        <?php $fc_fin = $fecha->formatodmY($fc_fin); ?>
                                        {{-- <input type="text" name="" id="" style="width:120px" class="form-control callout" value="{{$fc_inicio}}" disabled> --}}
                                        {{ Form::text('fc_fin' . $rango_documento->id, $fc_fin, ['class' => 'form-control', 'style' => 'width:110px; border-left-color: red; border-left-width: thick;', 'disabled']) }}
                                    </td>
                                    <td class="align-middle text-center">
                                        {{-- {{ Form::file('file' . $rango_documento->id, ['accept' => 'application/pdf']) }}
                                    @error('file' . $rango_documento->id)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror --}}
                                    </td>
                                    <td class="align-middle text-center">
                                        @if ($estado == 0)
                                            {{-- {{ Form::checkbox('estado' . $rango_documento->id, null, false) }} --}}
                                            No
                                        @else
                                            {{-- {{ Form::checkbox('estado' . $rango_documento->id, null, true) }} --}}
                                            Si
                                        @endif

                                        {{-- @error('estado' . $rango_documento->id)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror  --}}
                                    </td>
                                    {{-- <td width="10px" class="align-middle text-center">
                                    {{ csrf_field() }}
                                    {!! Form::hidden('opcion', 'upd_doc') !!}                                    
                                    {!! Form::submit('Actualizar', ['class' => 'btn btn-success btn-sm']) !!}
                                    <input type="hidden" value="{{ $rango_documento->id }}" id="documento_id"
                                        name="documento_id" />

                                    

                                </td> --}}
                                    <td class="align-middle text-center">
                                        <input wire:click="edit({{ $persona->id }})" type="button" value="Editar"
                                            class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#modalEditDocPersona">
                                    </td>
                                    {{-- {!! Form::close() !!} --}}
                                </form>
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
        <div wire:ignore.self class="modal fade" id="modalEditDocPersona" tabindex="-1" role="dialog"
            aria-labelledby="modalEditDocPersonaTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditDocPersonaTitle">Editar Documento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="height:620px;">
                                <div class="form-group">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input wire:model="nombre" type="text" class="form-control"
                                        placeholder="Ingrese nombre del personal">
                                    @error('nombre')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="rut" class="form-label">RUT</label>
                                    <input wire:model="rut" type="text" class="form-control"
                                        placeholder="Ingrese RUT del personal">
                                    @error('rut')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-1 text-red" wire:loading wire:target="edit">
                                    Procesando...
                                </div>
                                <div class="mb-1 text-red" wire:loading wire:target="update">
                                    Procesando...
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">

                            <button wire:click="close" type="button" class="btn btn-danger"
                                data-dismiss="modal">Cancelar</button>
                            <button wire:click="update" type="button" class="btn btn-primary"
                                wire:loading.attr="disabled">Editar</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
