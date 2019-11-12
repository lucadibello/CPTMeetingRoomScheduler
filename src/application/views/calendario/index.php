<main class="pt-5 mx-lg-5">
    <div id="container" class="container-fluid mt-5">
        <!-- Heading -->
        <div class="card mb-4 wow fadeIn">

            <!--Card content-->
            <div class="card-body d-sm-flex justify-content-between">

                <h4 class="mb-2 mb-sm-0 pt-1">
                    <span class="blue-text font-weight-bold"><?php echo APP_NAME;?></span>
                    <span>/</span>
                    <span>Calendario</span>
                </h4>
            </div>

        </div>
        <!-- Heading -->

        <div class="row wow fadeIn">
            <div class="col-md-12">
                <br>
                <div class="card" id="ultime-aggiunte">
                    <div class="card-header"><h3 class="h3-responsive">Ultime aggiunte</h3></div>
                    <div class="card-body">
                        <h1>[Username] ha aggiunto una prenotazione per il xx-xx-xx dall'ora xx-xx alle xx-xx</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-12">
                <br>
                <div class="card" id="aggiungi-categoria">
                    <div class="card-header"><h3 class="h3-responsive">Calendario</h3></div>
                    <div class="card-body">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modals -->

<!-- Event click modal -->
<!-- Central Modal Medium Info -->
<div class="modal fade" id="eventInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-notify modal-info" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">Informazioni evento</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2">
                        <i class="far fa-calendar-check fa-4x mb-3 animated rotateIn"></i>
                    </div>
                    <div class="col-md-10">
                        <h3 class="h3-responsive">Data: <span id="event-date"></span></h3>
                        <h3 class="h3-responsive">Orario: <span id="event-time-start"></span> - <span id="event-time-end"></span></h3>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="h3-responsive">Professore</h3>
                        </div>
                        <div class="col-md-8">
                            <h3 class="h3-responsive" id="event_professor"></h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="h3-responsive">Osservazioni</h3>
                        </div>
                        <div class="col-md-8">
                            <h3 class="h3-responsive" id="event_note"></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <a type="button" class="btn btn-primary">Get it now <i class="far fa-gem ml-1 text-white"></i></a>
                <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">No, thanks</a>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<!-- Central Modal Medium Info-->


<!-- FullCalendar Libs -->
<script src='/application/assets/fullcalendar/packages/core/main.min.js'></script>
<script src='/application/assets/fullcalendar/packages/interaction/main.min.js'></script>
<script src='/application/assets/fullcalendar/packages/daygrid/main.min.js'></script>
<script src='/application/assets/fullcalendar/packages/timegrid/main.min.js'></script>
<script src='/application/assets/fullcalendar/packages/list/main.min.js'></script>
<script src='/application/assets/fullcalendar/packages/bootstrap/main.min.js'></script>
<script src='/application/assets/fullcalendar/packages/core/locales-all.min.js'></script>
<script src='/application/assets/fullcalendar/packages/moment/main.min.js'></script>

<!-- Moment js -->
<script src="/application/assets/js/moment.min.js"></script>

<script>
    $(document).ready(function () {
        // Load calendar JS
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'bootstrap', 'dayGrid', 'timeGrid', 'list', 'momentPlugin'],
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            }, // Handles the onClick event generated by clicking on a specific event
            eventClick: function(info) {
                let event = info.event;
                let extra_data = info.event.extendedProps;

                // Date and time (start time - end time)
                $('#event-date').text(moment(event.start).format("DD/MM/YYYY"));
                $('#event-time-start').text(moment(event.start).format('HH:mm'));
                $('#event-time-end').text(moment(event.end).format('HH:mm'));

                // Additional data (notes, professor, ...)
                $('#event_professor').text(extra_data.professor.name + " " + extra_data.professor.surname);
                $('#event_note').text(extra_data.note);

                // TODO: Show modal with options
                $('#eventInfo').modal('show');
            },
            locale: 'it',
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            themeSystem: 'bootstrap', // use mdboostrap syle
            editable: true,
            bootstrapFontAwesome: { // Use fontawesome icons
                close: 'fa-times',
                prev: 'fa-chevron-left',
                next: 'fa-chevron-right',
                prevYear: 'fa-angle-double-left',
                nextYear: 'fa-angle-double-right'
            },
            eventSources: [
                {
                    url: '/api/calendar',
                    method: 'POST',
                    dataType: 'json',
                    extraParams: {
                        token: "<?PHP echo API_TOKEN;?>"
                    },
                    failure: function () {
                        alert('there was an error while fetching events!');
                    },
                },
                {
                    events: function(start, end, callback) {
                        $.ajax({
                            // Calls the calendar api
                            url: '/api/calendar',
                            method: 'POST',
                            dataType: 'json',
                            data: {
                                token: "<?php echo API_TOKEN; ?>" // Setup API authentication code
                            },
                            success: function(doc) {
                                let events = [];

                                $.map(doc, function (r) {
                                    // Add event to list
                                    let name = r.professor.name;
                                    let surname = r.professor.surname;

                                    events.push({
                                        // Build dict
                                        id: r.id,
                                        title: r.title,
                                        start: r.start,
                                        end: r.end,
                                        extendedProps: {
                                            note: r.note,
                                            professor_name: name,
                                            professor_surname: surname,
                                        }
                                    })
                                });

                                // Return events
                                callback(events);
                            }
                        });
                    }
                }
            ],
        });

        calendar.render();
    })
</script>
