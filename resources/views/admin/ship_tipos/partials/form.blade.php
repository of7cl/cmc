<div class="form-group">
    {!! Form::label('nombre', 'Nombre') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Ingrese nombre de tipo de nave']) !!}
    @error('nombre')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>