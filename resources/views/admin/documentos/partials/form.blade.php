<div class="form-group">
    {!! Form::label('nr_documento', 'N° Curso') !!}
    {!! Form::text('nr_documento', null, ['class' => 'form-control', 'placeholder' => 'Ingrese n° de curso']) !!}
    @error('nr_documento')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('codigo_omi', 'Código OMI') !!}
    {!! Form::text('codigo_omi', null, ['class' => 'form-control', 'placeholder' => 'Ingrese código OMI']) !!}
    @error('codigo_omi')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('nombre', 'Nombre') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Ingrese nombre']) !!}
    @error('nombre')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese name']) !!}
    @error('name')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('estado', '¿Activo?') !!}
    <label class="ml-2">
        @if (isset($documento))
            @if ($documento->estado==1)
                {!! Form::checkbox('estado', 1, true) !!}    
            @else
                {!! Form::checkbox('estado', 2, false) !!}    
            @endif            
        @else
            {!! Form::checkbox('estado', 1, true) !!}
        @endif
        
    </label>    
</div> 