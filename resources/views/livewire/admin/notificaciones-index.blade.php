<?php
use App\Models\Persona;
?>
<div>
    {{-- <div class="card">
        <div class="card-body">
            <div class="row">
                @if ($notifications->count())
                    <div class="card-body table-responsive">
                        <table class="table-xsm table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Tiempo</th>
                                    <th>Estado</th>
                                    <th colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                    <tr>
                                        <td>
                                            <i class="{{ $notification->icon }}"></i> {{ $notification->text }}
                                        </td>
                                        <td>
                                            {{ $notification->created_at->diffForHumans() }}
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
    </div> --}}

    <div class="row">
        <div class="col-md-12">
            @if (count($notifications) > 0)
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('notification.update_unreaded') }}"><i
                                class="far fa-envelope-open mr-3"></i> Marcar todas las notificaciones como leídas</a>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            @foreach ($notifications as $notification)
                                <?php
                                $persona = Persona::find($notification->persona_id);
                                $style = '';
                                if ($notification->alert == 'red') {
                                    $style .= "border-left-color: red; border-left-width: thick; margin-bottom: 0.1rem;' ";
                                } elseif ($notification->alert == 'orange') {
                                    $style .= "border-left-color: orange; border-left-width: thick; margin-bottom: 0.1rem;' ";
                                } elseif ($notification->alert == 'yellow') {
                                    $style .= "border-left-color: yellow; border-left-width: thick; margin-bottom: 0.1rem;' ";
                                } else {
                                    $style .= "border-left-color: white; border-left-width: thick; margin-bottom: 0.1rem;' ";
                                }
                                ?>
                                <div class="callout" style="{{ $style }}">
                                    <div class="row justify-content-between">
                                        <div class="col-sm-12 col-md-12 col-lg-7">
                                            <i class="{{ $notification->icon }}"></i> {{ $notification->text }}
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-2">
                                            <p>{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-2 align-middle text-center">
                                            <span
                                                class="badge badge-{{ $notification->readed ? 'success' : 'warning' }}">
                                                {{ $notification->readed ? 'Leída' : 'No leída' }}
                                                @if ($notification->readed)
                                                    {{ $notification->updated_at->diffForHumans() }}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-1">
                                            <a {{-- href="{{ route('admin.personas.show', $persona) }}" --}}
                                                wire:click="edit_doc({{ $notification }}, {{ $persona }})"
                                                data-toggle="modal" data-target="#modalEditDocPersona"
                                                data-backdrop="static" data-keyboard="false"
                                                class="badge badge-success" role="button"
                                                style="text-decoration: none;">Revisar</a>
                                            {{-- <input wire:click="edit_doc({{ $notification->documento_id }}, {{ $persona }})"
                                                type="button" value="+" class="btn btn-primary btn-xs"
                                                data-toggle="modal" data-target="#modalEditDocPersona"
                                                data-backdrop="static" data-keyboard="false"> --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- <div>
                            {{ $notifications->links() }}
                        </div> --}}
                    </div>
                    {{-- <div class="card-footer">
                        {{ $notifications->links() }}
                    </div> --}}
                </div>
            @else
                <div class="callout callout-info">
                    <div class="row justify-content-between">
                        <h5>Ninguna notificación sin leer!</h5>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div>
        <form wire:submit.prevent="update_doc">
            <div wire:ignore.self class="modal fade" id="modalEditDocPersona" tabindex="-1" role="dialog"
                aria-labelledby="modalEditDocPersonaTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditDocPersonaTitle">Editar Documento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                wire:click="close_doc">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <div class="row">
                                    <label for="nombre_persona_edit" class="col-sm-2 col-form-label">Persona</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly disabled class="form-control-plaintext"
                                            wire:model.defer="nombre" id="nombre_persona_edit">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="nr_curso_edit" class="col-sm-2 col-form-label">N° Curso</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly disabled class="form-control-plaintext"
                                            wire:model.defer="nr_documento" id="nr_curso_edit">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="codigo_omi_edit" class="col-sm-2 col-form-label">Código
                                        OMI</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly disabled class="form-control-plaintext"
                                            wire:model.defer="codigo_omi" id="codigo_omi_edit">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="nombre_edit" class="col-sm-2 col-form-label">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly disabled class="form-control-plaintext"
                                            wire:model.defer="nombre_doc" id="nombre_edit">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <label class="col-sm-4 col-form-label">Fecha Inicio</label>
                                            <div class="col-sm-6">
                                                <input type="date" name="" id=""
                                                    class="form-control form-control-sm" wire:model.defer="fc_inicio">
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
                                                    class="form-control form-control-sm" wire:model.defer="fc_fin">
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
                                        <input type="checkbox" class="mt-2" wire:model.defer="estado" />
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Certificado</label>
                                    <div class="col-sm-10 mx-0 my-0">
                                        <input type="file" accept="application/pdf" wire:model.defer="archivo"
                                            id="{{ $identificador }}">
                                        @error('archivo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="{{ $identificador }}" wire:model="archivo">
                                        <label class="custom-file-label" for="{{ $identificador }}">Choose file</label>
                                        </div> --}}
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
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="mb-0 mt-2 text-red float-left" wire:loading wire:target="edit_doc">
                                Procesando...</div>
                            <div class="mb-0 mt-2 text-red float-left" wire:loading wire:target="update_doc">
                                Procesando...</div>
                            <div class="mb-0 mt-2 text-red float-left" wire:loading wire:target="archivo">
                                Procesando...</div>
                            <button wire:click="close_doc" type="button" class="btn btn-danger"
                                wire:loading.attr="disabled" wire:target="update_doc"
                                data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary"
                                wire:loading.attr="disabled">Editar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
