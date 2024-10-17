<div>
    <div id='calendar'></div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-3">
                    {!! Form::label('rangoFilter', 'Rango') !!}
                    <select wire:model="rangoFilter" multiple class="custom-select" size="4">
                        {{-- <option value="">Seleccione Rango...</option> --}}
                        @foreach ($rangos as $rango)
                            <option value="{{ $rango->id }}">{{ $rango->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    {!! Form::label('shipFilter', 'Nave') !!}
                    <select wire:model="shipFilter" class="form-control">
                        <option value="">Seleccione Nave...</option>
                        @foreach ($ships as $ship)
                            <option value="{{ $ship->id }}">{{ $ship->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-5">
                    {!! Form::label('nameFilter', 'Nombre') !!}
                    <input wire:model="nameFilter" class="form-control" placeholder="Ingrese nombre de dotación">
                </div>
                <div class="col-2">
                    {!! Form::label('cn_mostrar', 'Mostrar') !!}
                    <select wire:model="cn_mostrar" class="form-control">                            
                        <option value="6">6 Meses</option>
                        <option value="12">1 Año</option>
                        <option value="24">2 Años</option>                        
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-body table-responsive text-nowrap" style="max-height: 560px; padding:0%;" id="div_table">
                <table class="table-xsm table-striped table-hover" style="border-collapse: separate;">
                    <thead class="table-secondary border border-secondary" style="position: sticky; top:0;">                        
                        <tr>
                            <th rowspan="2" class="border border-secondary align-middle text-center">Plaza</th>
                            <th rowspan="2" class="border border-secondary align-middle text-center">Dotación</th> 
                            @php
                                $mes_hoy = date('m');
                                $anio_hoy = date('Y');
                            @endphp
                            @foreach($meses_seleccionados as $mes_seleccionado)
                                @if ($mes_hoy == $mes_seleccionado['nr_mes'] && $anio_hoy == $mes_seleccionado['nr_anio'])
                                    <th colspan="4" class="border border-secondary align-middle text-center" id="mesHoy">{{$mes_seleccionado['nm_mes']}}</th>
                                @else
                                    <th colspan="4" class="border border-secondary align-middle text-center">{{$mes_seleccionado['nm_mes']}}</th>
                                @endif                            
                            @endforeach
                        </tr>
                        <tr>
                            @foreach($meses_seleccionados as $mes_seleccionado)
                            <th class="border border-secondary align-middle text-center">1° SEM</th>
                            <th class="border border-secondary align-middle text-center">2° SEM</th>
                            <th class="border border-secondary align-middle text-center">3° SEM</th>
                            <th class="border border-secondary align-middle text-center">4° SEM</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>  
                        @php
                            $rango = 0;
                        @endphp
                        @foreach($personas as $persona)                     
                            @if ($persona->rango_id != $rango && $rango != 0)
                                <tr>
                                    <td class="border border-secondary">&nbsp;</td>
                                    <td class="border border-secondary"></td>
                                    @foreach($meses_seleccionados as $mes_seleccionado)
                                        <td class="border border-secondary"></td>
                                        <td class="border border-secondary"></td>
                                        <td class="border border-secondary"></td>
                                        <td class="border border-secondary"></td>    
                                    @endforeach           
                                </tr>
                            @endif 
                            <tr>                                                                                       
                                {{-- <td class="border border-secondary" style="cursor: pointer">@if ($persona->ship_id) {{$persona->ship->nombre}} @else En Tierra @endif</td> --}}
                                <td class="border border-secondary" style="cursor: pointer">@if ($persona->rango_id) {{$persona->rango->nombre}} @endif</td>
                                <td class="border border-secondary">{{$persona->nombre}}</td>
                                @foreach($meses_seleccionados as $mes_seleccionado)
                                    <td class="border border-secondary" style="cursor:pointer" id="{{$persona->id}}_1_{{$mes_seleccionado['nr_mes']}}_{{$mes_seleccionado['nr_anio']}}" 
                                        wire:click="setModalSemanaInicialAgregar('{{$persona->nombre}}',{{$persona->id}},1,'{{$mes_seleccionado['nm_mes']}}',{{$mes_seleccionado['nr_mes']}},{{$mes_seleccionado['nr_anio']}})" 
                                        data-toggle="modal" data-target="#modalAgregarProgramacion" data-backdrop="static" data-keyboard="false">
                                    </td>
                                    <td class="border border-secondary" style="cursor:pointer" id="{{$persona->id}}_2_{{$mes_seleccionado['nr_mes']}}_{{$mes_seleccionado['nr_anio']}}"
                                        wire:click="setModalSemanaInicialAgregar('{{$persona->nombre}}',{{$persona->id}},2,'{{$mes_seleccionado['nm_mes']}}',{{$mes_seleccionado['nr_mes']}},{{$mes_seleccionado['nr_anio']}})" 
                                        data-toggle="modal" data-target="#modalAgregarProgramacion" data-backdrop="static" data-keyboard="false">
                                    </td>
                                    <td class="border border-secondary" style="cursor:pointer" id="{{$persona->id}}_3_{{$mes_seleccionado['nr_mes']}}_{{$mes_seleccionado['nr_anio']}}"
                                        wire:click="setModalSemanaInicialAgregar('{{$persona->nombre}}',{{$persona->id}},3,'{{$mes_seleccionado['nm_mes']}}',{{$mes_seleccionado['nr_mes']}},{{$mes_seleccionado['nr_anio']}})" 
                                        data-toggle="modal" data-target="#modalAgregarProgramacion" data-backdrop="static" data-keyboard="false">
                                    </td>
                                    <td class="border border-secondary" style="cursor:pointer" id="{{$persona->id}}_4_{{$mes_seleccionado['nr_mes']}}_{{$mes_seleccionado['nr_anio']}}"
                                        wire:click="setModalSemanaInicialAgregar('{{$persona->nombre}}',{{$persona->id}},4,'{{$mes_seleccionado['nm_mes']}}',{{$mes_seleccionado['nr_mes']}},{{$mes_seleccionado['nr_anio']}})" 
                                        data-toggle="modal" data-target="#modalAgregarProgramacion" data-backdrop="static" data-keyboard="false">
                                    </td>
                                @endforeach                                 
                            </tr>
                            @php
                                $rango = $persona->rango_id;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- modal Agregar programación --}}
            <div>
                <form wire:submit.prevent="saveProgramacion">
                    <div wire:ignore.self class="modal fade" id="modalAgregarProgramacion" tabindex="-1" role="dialog"
                        aria-labelledby="modalAgregarProgramacionTitle" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalAgregarProgramacionTitle">Agregar Programación</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                        wire:click="close_agregar_prog">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>                                
                                <div class="modal-body">  
                                    <div class="row">
                                        <div class="col-12 mb-3">                                    
                                            <h7 class="modal-title" id="modalAgregarProgramacionTitle">{{$titulo_agregar}}</h5>                                    
                                        </div>
                                    </div>                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        {!! Form::label('plaza_id', 'Plaza') !!}
                                                        <select class="form-control" wire:model="plaza_id">
                                                            <option value="" disabled>Seleccionar Plaza...</option>
                                                            @foreach ($rangos as $rango)
                                                                <option value="{{ $rango->id }}">{{ $rango->nombre }}</option>                                                                
                                                            @endforeach
                                                        </select>
                                                        @error('plaza_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        {!! Form::label('ship_id', 'Nave') !!}
                                                        <select class="form-control" wire:model="ship_id">
                                                            <option value="" disabled>Seleccionar Nave...</option>
                                                            @foreach ($ships as $ship)
                                                                <option value="{{ $ship->id }}">{{ $ship->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('ship_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        {!! Form::label('nr_semanas', 'Cantidad de Semanas') !!}
                                                        <input type="number" min="1" max="100" wire:model="nr_semanas" class="form-control"/>
                                                        @error('nr_semanas')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        {!! Form::label('id_estado', 'Estado') !!}
                                                        <select wire:model="id_estado" class="form-control">
                                                            <option value="" disabled>Seleccionar Estado...</option>                            
                                                            <option value="1">Instrucción</option>
                                                            <option value="2">Dotación</option>
                                                            <option value="3">Franquias/Vaca</option>                        
                                                            <option value="4">Disponibilidad</option>
                                                            <option value="5">Curso/Lic/Otro</option>
                                                            <option value="6">Exceso de Embarco</option>
                                                            <option value="7">Event./Otra Plaza</option>
                                                        </select>
                                                        @error('id_estado')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                                                                                                                                                                                                                                                                                     
                                </div>
                                <div class="modal-footer">
                                    <button wire:click="close_agregar_prog" type="button" class="btn btn-danger"
                                        data-dismiss="modal">Cancelar</button>                                    
                                    <input class="btn btn-primary" type="submit" value="Agregar" wire:loading.attr="disabled">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card-footer">
        </div>
    </div>
</div>
@push('js')
    {{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {                  
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',              
                timeZone: 'UTC',                                
                headerToolbar: {
                    left: 'today prev,next',
                    center: 'title',
                    right: 'resourceTimelineMonth1,resourceTimelineMonth3,resourceTimelineMonth5,resourceTimelineYear'
                },
                locale: 'es',
                buttonText: {
                    today: 'Hoy'
                },                
                initialView: 'resourceTimelineMonth1',                
                aspectRatio: 1.5,
                views: {
                    resourceTimelineMonth1: {
                        type: 'resourceTimeline',
                        duration: { months: 4 },
                        buttonText: '4 Mes',
                        //titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' },
                    },
                    resourceTimelineMonth3: {
                        type: 'resourceTimelineYear',
                        duration: { months: 8 },
                        buttonText: '8 Meses'
                    },
                    resourceTimelineMonth5: {
                        type: 'resourceTimelineYear',
                        duration: { months: 12 },
                        buttonText: '12 Meses'
                    },
                    resourceTimelineYear: {
                        type: 'resourceTimelineYear',
                    }
                }, 
                slotLabelFormat: [ { month: 'long' } ],
                slotDuration: { week: 4 },
                /*slotLabelFormat: [
                    { month: 'long', year: 'numeric' }, // top level of text
                    //{ weekday: 'short' } // lower level of text    
                    {
                        week: 'numeric',                        
                    }                
                ],*/               
                editable: true,              
                resourceAreaWidth: '25%',
                resourceAreaHeaderContent: 'Personal',                
                resources: @json($resources),
                events: @json($events),
                resourceOrder: 'title'         
            });            
            calendar.render();
        });
    </script>  --}}   

    <script>
        $( document ).ready(function() {
            //alert($("#div_table").width());
            //$("#div_table").scrollLeft( $("#div_table").width() );
            /* var div = document.getElementById('mesHoy');
            div.scrollLeft = '9999'; */
            //document.location.href="#mesHoy";
            //$('#search2').focus();//Descomenta esto si ademas queres que se posicione el cursor automaticamente sobre el input.   
            //$('#div_table').hide();
            //$('#9_1_4_2024').css("background-color","#000000");
            //$('#div_table').show();

            //console.log(@json($events));

            /* eventos = @json($events);
            eventos.forEach(function(element){                
                id = '#' + element.id_persona + '_' + element.nr_semana + '_' + element.nr_mes + '_' + element.nr_anio;
                console.log(id);
                $(id).css("background-color","#ea1010");
                $(id).html('<a onclick="alert()">link</a>');
            }) */

            

        });
    </script>

    <script>
        document.addEventListener('livewire:load', function () {
            // Function to initialize the charts
            function initEvents() {                
                eventos = @json($events);
                console.log(eventos);
                eventos.forEach(function(element){                
                    //id = '#' + element.id_persona + '_' + element.nr_semana + '_' + element.nr_mes + '_' + element.nr_anio;
                    //console.log(element.id_celda);
                    $('#'+element.id_celda).css("background-color",element.str_color);
                    //$(id).html('<a onclick="alert()">link</a>');
                })
            }

            // Initialize the events on page load
            initEvents();

            // Reinitialize the events after Livewire updates
            Livewire.hook('message.processed', (message, component) => {
                initEvents();
            });
        });
        
    </script>
    {{-- <script>
        Livewire.on('scrollLeft', function(message) {
            console.log('asd');
            document.location.href="#mesHoy";           
        })        
    </script> --}}
    
@endpush
