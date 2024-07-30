<div>
    <div id='calendar'></div>
</div>
@push('js')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {                  
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',              
                timeZone: 'UTC',                                
                headerToolbar: {
                    left: 'today prev,next',
                    center: 'title',
                    right: 'resourceTimelineMonth1,resourceTimelineMonth3,resourceTimelineMonth5'
                },
                locale: 'es',
                buttonText: {
                    today: 'Hoy'
                },                
                initialView: 'resourceTimelineMonth1',                
                aspectRatio: 1.5,
                views: {
                    resourceTimelineMonth1: {
                        type: 'resourceTimelineMonth',
                        duration: { months: 1 },
                        buttonText: '1 Mes',
                        //titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' },
                    },
                    resourceTimelineMonth3: {
                        type: 'resourceTimelineMonth',
                        duration: { months: 3 },
                        buttonText: '3 Meses'
                    },
                    resourceTimelineMonth5: {
                        type: 'resourceTimelineMonth',
                        duration: { months: 5 },
                        buttonText: '5 Meses'
                    }
                }, 
                slotLabelFormat: [
                    { month: 'long', year: 'numeric' }, // top level of text
                    //{ weekday: 'short' } // lower level of text    
                    {
                        day: 'numeric',                        
                    }                
                ],               
                editable: true,              
                resourceAreaWidth: '25%',
                resourceAreaHeaderContent: 'Personal',                
                resources: @json($resources),
                events: @json($events),
                resourceOrder: 'title'         
            });            
            calendar.render();
        });
    </script>    
@endpush
