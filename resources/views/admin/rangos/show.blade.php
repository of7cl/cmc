@extends('adminlte::page')

@section('title', 'Documentos Rango')

@section('content_header')
    {{-- <a class="btn btn-secondary btn-sm float-right" href="{{ route('admin.rangos.asignar-documento', $rango) }}">Asignar
        Documento</a> --}}
    <h1>Lista de Documentos del Rango "{{ $rango->nombre }}"</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            {!! Form::model($rango, ['route' => ['admin.rangos.update', $rango], 'method' => 'put']) !!}
            {!! Form::submit('Asignar', ['class' => 'btn btn-primary float-right mb-2']) !!}
            <table class="table table-striped table-sm">
                <tbody>
                    <?php $count = count($documentos); ?>
                    @foreach ($documentos as $key => $documento)
                        <?php $bo_existe = 0; ?>
                        @foreach ($rango->documentos as $rango_documento)
                            @if($rango_documento->id == $documento->id)
                                <?php $bo_existe = 1; ?>
                            @endif
                        @endforeach
                        {{-- par --}}
                        @if ($key % 2 == 0)
                            <tr style="border-top-style: double; border-bottom-style: double;">
                                <td title="{{ $documento->nombre }}" style="cursor: pointer; border-left-style: double;" class="align-middle text-center">
                                    {{-- {{ $key }} --}}
                                    @if ($bo_existe == 1)
                                        {!! Form::checkbox('documentos[]', $documento->id, null, ['class' => 'mr-2 ml-2', 'checked' => 'checked', 'style' => 'width: 40px; height: 20px;']) !!}
                                    @else
                                        {!! Form::checkbox('documentos[]', $documento->id, null, ['class' => 'mr-2 ml-2', 'style' => 'width: 40px; height: 20px;']) !!}
                                    @endif 
                                </td>
                                <td class="align-middle text-center">                                       
                                    {{ $documento->nr_documento }} 
                                </td>
                                <td class="align-middle text-center">
                                    {{ $documento->codigo_omi }} 
                                </td>
                                <td class="align-middle">
                                    @if($documento->nombre <> '')
                                        {{ $documento->nombre }} 
                                    @else
                                        {{ $documento->name }} 
                                    @endif
                                </td>
                                @if ($count == $key)
                                    </tr>
                                @endif
                        @else
                                <td title="{{ $documento->nombre }}" style="cursor: pointer; border-left-style: double;" class="align-middle text-center">
                                    {{-- {{ $key }} --}}
                                    @if ($bo_existe == 1)
                                        {!! Form::checkbox('documentos[]', $documento->id, null, ['class' => 'mr-2 ml-2', 'checked' => 'checked', 'style' => 'width: 40px; height: 20px;']) !!}
                                    @else
                                        {!! Form::checkbox('documentos[]', $documento->id, null, ['class' => 'mr-2 ml-2', 'style' => 'width: 40px; height: 20px;']) !!}
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    {{ $documento->nr_documento }} 
                                </td>
                                <td class="align-middle text-center">
                                    {{ $documento->codigo_omi }} 
                                </td>
                                <td style="border-right-style: double;" class="align-middle">
                                    {{ $documento->nombre }}                                 
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            {!! Form::hidden('opcion', 'docs') !!}
            {!! Form::submit('Asignar', ['class' => 'btn btn-primary float-right']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    {{-- <div class="card">
        @if ($rango->documentos->count())
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>N° Curso</th>
                            <th>Código OMI</th>
                            <th>Nombre</th>
                            <th>Name</th>
                            <th>¿Obligatorio?</th>
                            <th colspan="1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rango->documentos as $rango_documento)
                            <tr>
                                <td>{{ $rango_documento->id }}</td>
                                <td>{{ $rango_documento->nr_documento }}</td>
                                <td>{{ $rango_documento->codigo_omi }}</td>
                                <td>{{ $rango_documento->nombre }}</td>
                                <td>{{ $rango_documento->name }}</td>
                                <td>
                                    @if ($rango_documento->pivot->obligatorio == 1)
                                        Si
                                    @else
                                        No
                                    @endif
                                </td>
                                <td width="10px">
                                    {!! Form::model($rango, [
                                        'route' => ['admin.rangos.update', $rango],
                                        'class' => 'formulario-eliminar',
                                        'method' => 'put',
                                    ]) !!}
                                    {!! Form::hidden('opcion', 'del_doc') !!}
                                    {!! Form::hidden('doc_id', $rango_documento->id) !!}
                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger btn-sm']) !!}
                                    {!! Form::close() !!}
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
    </div> --}}
@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.formulario-eliminar').submit(function(e) {
            e.preventDefault();

            Swal.fire({
                title: "¿Estás Seguro?",
                text: "",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Si, Eliminar!",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    /* Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                    }); */
                    this.submit();
                }
            });
        })
    </script>
@endsection
