<div>
    {{-- Do your work, then step back. --}}
    <a data-toggle="modal" data-target="#modalEditPersona">
        <i class="fas fa-edit"></i>
    </a>
    
    <div>
        <div wire:model="open" class="modal fade" id="modalEditPersona" tabindex="-1" role="dialog"
            aria-labelledby="modalEditPersonaTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditPersonaTitle">Editar Personal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="height:500px;">
                            <form>
                                <div class="form-group">
                                    {!! Form::label('name', 'Nombre') !!}
                                    {!! Form::text('name', $persona->nombre, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Ingrese nombre de usuario',
                                    ]) !!}
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    {!! Form::label('rut', 'RUT') !!}
                                    {!! Form::text('rut', $persona->rut, ['class' => 'form-control', 'placeholder' => 'Ingrese nombre de usuario']) !!}
                                    @error('rut')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input wire:model="persona.nombre" type="text" class="form-control"
                                        placeholder="Ingrese nombre del personal">
                                    @error('nombre')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="rut" class="form-label">RUT</label>
                                    <input wire:model="persona.rut" type="text" class="form-control"
                                        placeholder="Ingrese RUT del personal">
                                    @error('rut')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                            data-dismiss="modal">Cancelar</button>
                        <button wire:click="update" type="button" class="btn btn-primary">Editar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
