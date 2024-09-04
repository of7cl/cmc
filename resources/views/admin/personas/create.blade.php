@extends('adminlte::page')

@section('title', 'Nuevo Personal')

@section('content_header')
    <h1>Crear Personal</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'admin.personas.store', 'autocomplete' => 'off', 'files' => true]) !!}
            {{-- @include('admin.personas.partials.form') --}}
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
                                {!! Form::select('contrato_tipo_id', $rangos, null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Seleccionar Tipo de Contrato...',
                                ]) !!}
                                @error('contrato_tipo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    {!! Form::label('file', 'Foto de Perfil') !!}
                    <div class="col">
                        <div style="position: relative; padding-bottom: 5%;">
                            <img src="https://cdn.pixabay.com/photo/2023/02/18/11/00/icon-7797704_1280.png" alt=""
                                style="position: relative; object-fit: cover; width: 100%; height: 100%;" id="picture">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 mx-0 my-0">
                            {!! Form::file('file', ['class' => 'form-control-file', 'accept' => 'image/*']) !!}
                            @error('file')
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
            {{-- {!! Form::submit('Crear Personal', ['class' => 'btn btn-primary']) !!} --}}
            <input type="submit" value="Crear Personal" class="btn btn-primary" onclick="this.disabled=true;this.form.submit();">
            {!! Form::close() !!}
        </div>
    </div>

@stop

@section('js')
    <script>
        document.getElementById("file").addEventListener('change', cambiarImagen);

        function cambiarImagen(event) {
            var file = event.target.files[0];

            var reader = new FileReader();
            reader.onload = (event) => {
                document.getElementById("picture").setAttribute('src', event.target.result);
            };

            reader.readAsDataURL(file);
        }

        document.getElementById('rango_id').addEventListener('change', function() {            
            var selectedElement = this.options[this.selectedIndex].text;
            const selectElement = document.getElementById('contrato_tipo_id');
            const allOptions = selectElement.options;                        
            var existe = 0;
            for (let i = 0; i < allOptions.length; i++) {            
                if (allOptions[i].text == selectedElement) {
                    selectElement.selectedIndex = i;
                    existe++;
                    break;
                }
            }
            if(existe == 0)
            {
                selectElement.selectedIndex = 0;
            }
        });
    </script>
@endsection
