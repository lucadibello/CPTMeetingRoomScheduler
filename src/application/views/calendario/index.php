<main class="pt-5 mx-lg-5">
    <div id="container" class="container-fluid mt-5">
        <!-- Heading -->
        <div class="card mb-4 wow fadeIn">

            <!--Card content-->
            <div class="card-body d-sm-flex justify-content-between">

                <h4 class="mb-2 mb-sm-0 pt-1">
                    <span class="blue-text font-weight-bold"><?php echo APP_NAME; ?></span>
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

<!-- Modal event view/edit -->
<div class="modal fade" id="eventInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-notify modal-info" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">Informazioni prenotazione</p>
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
                    <div class="cgeol-md-10">
                        <h3 class="h3-responsive">Data: <span id="event-date"></span> <i class="fas fa-info-circle"
                                                                                         data-toggle="tooltip"
                                                                                         title="La data può essere cambiata trascinando con il mouse la prenotazione su un giorno del calendario"></i>
                        </h3>
                        <h3 class="h3-responsive">Orario: <span id="event-time-start"></span> - <span
                                    id="event-time-end"></span></h3>
                        <h3 class="h3-responsive">Professore: <span id="event_professor"></span></h3>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="md-form">
                            <i class="fas fa-pencil-alt prefix"></i>
                            <textarea class="md-textarea form-control" rows="3" id="event_note"></textarea>
                            <label for="event_note">Osservazioni</label>
                        </div>
                    </div>
                </div>
            </div>

            <!--Footer-->
            <div class="modal-footer">
                <!-- Update -->
                <a type="button" class="btn btn-dark-green update-event-button" data-toggle="tooltip"
                   title="Applica modifiche"><span></span><i class="fas fa-check text-white"></i></a>

                <!-- Delete -->
                <a type="button" class="btn btn-danger waves-button delete-event-button" data-toggle="tooltip"
                   title="Elimina prenotazione"><span></span><i class="fas fa-trash-alt text-white"></i></a>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<!-- Modal event view/edit -->

<!-- Modal event insert -->
<div class="modal fade" id="eventInsert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-notify modal-info" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">Aggiungi prenotazione</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">

                <!-- Default form register -->
                <form class="text-center p-1" action="/api/booking/add" method="post">

                    <div class="form-row mb-4">
                        <div class="col">
                            <label class="h5-responsive black-text" for="event-date">Data</label>
                        </div>
                        <div class="col">
                            <!-- Material input -->
                            <div class="md-form">
                                <input type="text" id="event-date" name="data" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- Time -->
                    <div class="form-row mb-4">
                        <div class="col">
                            <!-- First name -->
                            <input type="time" id="event-time-start" name="ora_inizio" class="form-control">
                            <label for="event-time-start"> Tempo di inzio</label>
                        </div>
                        <div class="col">
                            <!-- Last name -->
                            <input type="time" id="event-time-end" name="ora_fine" class="form-control">
                            <label for="event-time-end"> Tempo di fine</label>
                        </div>
                    </div>

                    <!-- Osservazioni -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="md-form">
                                <textarea class="md-textarea form-control" name="osservazioni" rows="3"
                                          id="event-osservazioni"></textarea>
                                <label for="event-osservazioni">Osservazioni</label>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Default form register -->
            </div>

            <!--Footer-->
            <div class="modal-footer">
                <button class="btn btn-dark-green" id="event-insert-submit">Aggiungi prenotazione</button>
                <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Annulla</a>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<!-- Modal event insert -->


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

<!-- Notify JS -->
<script src="/application/assets/js/notify.min.js"></script>

<script>
    $(document).ready(function () {
        // Load calendar JS
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['interaction', 'bootstrap', 'dayGrid', 'timeGrid', 'list'],
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            }, // Handles the onClick event generated by clicking on a specific event
            eventClick: function (info) {
                let event = info.event;
                let extra_data = info.event.extendedProps;

                // Date and time (start time - end time)
                $('#event-date').text(moment(event.start).format("DD/MM/YYYY"));
                $('#event-time-start').text(moment(event.start).format('HH:mm'));
                $('#event-time-end').text(moment(event.end).format('HH:mm'));

                // Additional data (notes, professor, ...)
                $('#event_professor').text(extra_data.professor.name + " " + extra_data.professor.surname);

                if (extra_data.note != null) {
                    $('#event_note').text(extra_data.note).trigger('change');
                }

                // Show modal
                $('#eventInfo').modal('show');

                // add listener for delete
                $('.delete-event-button').on('click', function () {

                    console.log("[!] Sending delete request to apis");

                    $.ajax({
                        type: "POST",
                        url: "/api/booking/delete/" + event.id,
                        success: function (result) {
                            if (result["success"]) {
                                console.log("[!] event deleted");

                                calendar.refetchEvents();
                                $('#eventInfo').modal('hide');

                                // Notify success
                                $.notify("Evento eliminato con successo", "success");
                            } else {
                                console.log(result["errors"]);

                                result["errors"].forEach(function (item, index, arr) {
                                    $.notify(item, "warn");
                                });

                                $('#eventInfo').modal('hide');
                            }
                        },
                        dataType: "json"
                    });

                    // Remove click handler after insert
                    $(this).off();
                });

                // add lister for update
                $('.update-event-button').on('click', function () {
                    console.log("[!] Update action detected");

                    let modal = $("#eventInfo");

                    let date = moment(modal.find("#event-date"));
                    let startTime = modal.find('#event-time-start').text();
                    let endTime = modal.find('#event-time-end').text();
                    let osservazioni = modal.find("#event-osservazioni").val();

                    $.ajax({
                        type: "POST",
                        url: "/api/booking/update/" + event.id,
                        data: {
                            "data": date.format('DD/MM/YYYY'),
                            "ora_inizio": startTime,
                            "ora_fine": endTime,
                            "osservazioni": osservazioni,
                        },
                        success: function (result) {
                            console.log("");
                            if (result["success"]) {
                                console.log("[!] event updated");

                                calendar.refetchEvents();
                                $('#eventInsert').modal('hide');

                                // Notify success
                                $.notify("Evento modificato con successo", "success");
                            } else {
                                console.log(result["errors"]);

                                result["errors"].forEach(function (item, index, arr) {
                                    $.notify(item, "warn");
                                });

                                $('#eventInfo').modal('hide');
                            }

                        },
                        dataType: "json"
                    });

                    // Remove click handler after insert
                    $(this).off();
                });
            },
            eventDrop: function (info) {
                let new_event = info.event;
                // Reset to previous day: info.revert();
            },
            locale: 'it',
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            themeSystem: 'bootstrap', // use mdboostrap syle
            editable: true,
            slotDuration: '00:15:00',
            slotMinutes: 15,
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
                    events: function (start, end, callback) {
                        $.ajax({
                            // Calls the calendar api
                            url: '/api/calendar',
                            method: 'POST',
                            dataType: 'json',
                            data: {
                                token: "<?php echo API_TOKEN; ?>" // Setup API authentication code
                            },
                            success: function (doc) {
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
            dateClick: function (info) { // CREATE EVENT
                // process data
                var date = moment(info.dateStr);

                console.log("date: " + date.format("DD/MM/YYYY"));

                let startTime = date.format("HH:mm");
                let endTime = date.add(15, 'minutes').format("HH:mm");

                //modal
                var modal = $('#eventInsert');

                // insert data into modal
                modal.find('#event-date').val(date.format('DD/MM/YYYY'));
                modal.find('#event-time-start').val(startTime);
                modal.find('#event-time-end').val(endTime);

                $("#eventInsert").modal('show');

                $('#event-insert-submit').on("click", function () {
                    startTime = modal.find('#event-time-start').val();
                    endTime = modal.find('#event-time-end').val();
                    let osservazioni = modal.find("#event-osservazioni").val();

                    $.ajax({
                        type: "POST",
                        url: "/api/booking/add",
                        data: {
                            "data": date.format('DD/MM/YYYY'),
                            "ora_inizio": startTime,
                            "ora_fine": endTime,
                            "osservazioni": osservazioni,
                        },
                        success: function (result) {
                            console.log("ciao yoloshallo");
                            if (result["success"]) {
                                console.log("[!] event created");

                                calendar.refetchEvents();
                                $('#eventInsert').modal('hide');

                                // Notify success
                                $.notify("Evento creato con successo", "success");
                            } else {
                                console.log(result["errors"]);

                                result["errors"].forEach(function (item, index, arr) {
                                    $.notify(item, "warn");
                                });

                                $('#eventInfo').modal('hide');
                            }

                        },
                        dataType: "json"
                    });

                    // Remove click handler after insert
                    $(this).off();
                })
            },
        });
        calendar.render();


        setInterval(refreshCalendar, 1000 * 60 * 10); // Update every 10 mins

        // TODO: FINISH THIS 'refreshMethod'
        /**
         * This function is used to refresh/refetch all the events of the calendar
         */
        function refreshCalendar() {
            calendar.refetchEvents();
            console.log("[!] Calendar refreshed");
        }
    })
</script>
