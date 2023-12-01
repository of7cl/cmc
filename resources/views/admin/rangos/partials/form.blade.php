<div class="form-group">
    {!! Form::label('codigo', 'Código') !!}
    {!! Form::text('codigo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese código de rango']) !!}
    @error('codigo')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('nombre', 'Nombre') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Ingrese nombre de rango']) !!}
    @error('nombre')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('estado', '¿Activo?') !!}
    <label class="ml-2">
        @if (isset($rango))
            @if ($rango->estado==1)
                {!! Form::checkbox('estado', 1, true) !!}    
            @else
                {!! Form::checkbox('estado', 2, false) !!}    
            @endif            
        @else
            {!! Form::checkbox('estado', 1, true) !!}
        @endif
        
    </label>    
</div> 