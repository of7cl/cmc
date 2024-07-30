@extends('adminlte::page')

@section('title', 'Editar Personal')

@section('content_header')
    <h1>Editar Personal</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-body">

            {!! Form::model($persona, ['route' => ['admin.personas.update', $persona], 'files' => true, 'method' => 'put']) !!}
            {{-- @include('admin.personas.partials.form')                                --}}
            <div class="row">
                <div class="col-7">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                {!! Form::label('nombre', 'Nombre') !!}
                                {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Ingrese nombre del personal']) !!}
                                @error('nombre')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                {!! Form::label('rut', 'RUT') !!}
                                {!! Form::text('rut', null, ['class' => 'form-control', 'placeholder' => 'Ingrese RUT del personal']) !!}
                                @error('rut')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                {!! Form::label('rango_id', 'Rango') !!}
                                {!! Form::select('rango_id', $rangos, null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Seleccionar Rango...',
                                ]) !!}
                                @error('rango_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                {!! Form::label('ship_id', 'Nave') !!}
                                {!! Form::select('ship_id', $ships, null, ['class' => 'form-control', 'placeholder' => 'Seleccionar Nave...']) !!}
                                @error('ship_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                {!! Form::label('contrato_tipo_id', 'Tipo de Contrato') !!}
                                {!! Form::select('contrato_tipo_id', $contrato_tipos, null, ['class' => 'form-control', 'placeholder' => 'Seleccionar Tipo de Contrato...']) !!}
                                @error('contrato_tipo_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('estado', '¿Activo?') !!}
                        <label class="ml-2">
        
                            @if ($persona->estado == 1)
                                {!! Form::checkbox('estado', 1, true) !!}
                            @else
                                {!! Form::checkbox('estado', 2, false) !!}
                            @endif
        
        
                        </label>
                    </div>
                </div>
                <div class="col-5">
                    {!! Form::label('file_upd', 'Foto de Perfil') !!}
                    <div class="col">
                        <div style="position: relative; padding-bottom: 5%;">
                            @if ($persona->foto)
                                <img src="{{ asset('storage/' . $persona->foto) }}"
                                    alt="" style="position: relative; object-fit: cover; width: 256px; height: 335px;"
                                    id="picture_upd">
                            @else
                                <img src="https://cdn.pixabay.com/photo/2023/02/18/11/00/icon-7797704_1280.png"
                                    alt="" style="position: relative; object-fit: cover; width: 100%; height: 100%;"
                                    id="picture_upd">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 mx-0 my-0">
                            {!! Form::file('file_upd', ['class' => 'form-control-file', 'accept' => 'image/*']) !!}
                            @error('file_upd')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        {!! Form::label('fc_nacimiento', 'Fecha de Nacimiento') !!}
                        {{ Form::date('fc_nacimiento', null, ['class' => 'form-control']) }}
                        @error('fc_nacimiento')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        {!! Form::label('fc_ingreso', 'Fecha de Ingreso') !!}
                        {{ Form::date('fc_ingreso', null, ['class' => 'form-control']) }}
                        @error('fc_ingreso')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        {!! Form::label('fc_baja', 'Fecha de Baja') !!}
                        {{ Form::date('fc_baja', null, ['class' => 'form-control']) }}
                        @error('fc_baja')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            {!! Form::submit('Editar Persona', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}

        </div>
    </div>

@stop

@section('js')
    <script>
        document.getElementById("file_upd").addEventListener('change', cambiarImagen);

        function cambiarImagen(event) {
            var file = event.target.files[0];

            var reader = new FileReader();
            reader.onload = (event) => {
                document.getElementById("picture_upd").setAttribute('src', event.target.result);
            };

            reader.readAsDataURL(file);
        }
    </script>
@endsection
