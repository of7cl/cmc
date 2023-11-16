<div class="form-group">
    {!! Form::label('codigo', 'Código') !!}
    {!! Form::text('codigo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese código de nave']) !!}
    @error('codigo')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('nombre', 'Nombre') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Ingrese nombre de nave']) !!}
    @error('nombre')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('imo', 'IMO') !!}
    {!! Form::text('imo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese IMO de nave']) !!}
    @error('imo')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('dwt', 'DWT') !!}
    {!! Form::text('dwt', null, ['class' => 'form-control', 'placeholder' => 'Ingrese DWT de nave']) !!}
    @error('dwt')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('trg', 'TRG') !!}
    {!! Form::text('trg', null, ['class' => 'form-control', 'placeholder' => 'Ingrese TRG de nave']) !!}
    @error('trg')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('loa', 'LOA') !!}
    {!! Form::text('loa', null, ['class' => 'form-control', 'placeholder' => 'Ingrese LOA de nave']) !!}
    @error('loa')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('manga', 'MANGA') !!}
    {!! Form::text('manga', null, ['class' => 'form-control', 'placeholder' => 'Ingrese MANGA de nave']) !!}
    @error('manga')
        <span class="text-danger">{{$message}}</span>
    @enderror
</div>