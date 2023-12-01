<div class="form-group">
    {!! Form::label('codigo', 'Código') !!}
    {!! Form::text('codigo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese código de rango', 'readonly']) !!}    
</div>
<div class="form-group">
    {!! Form::label('nombre', 'Nombre') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Ingrese nombre de rango', 'readonly']) !!}    
</div>
<div class="form-group">
    {!! Form::label('documento', 'Documento') !!}
    {!! Form::select('documento', $documentos, null, ['class' => 'form-control', 'placeholder' => 'Seleccionar Documento...']) !!}
    @error('documento')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div> 
<div class="form-group">
    {!! Form::label('obligatorio', '¿Obligatorio?') !!}
    <label class="ml-2">
        {!! Form::checkbox('obligatorio', 1, true) !!}
    </label>
    @error('obligatorio')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div> 