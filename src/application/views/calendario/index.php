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

        <!-- Calendar -->
        <div class="row mb-5">
            <div class="col-md-12">
                <br>
                <div class="card" id="aggiungi-categoria">
                    <div class="card-header"><h3 class="h3-responsive">Calendario</h3></div>
                    <div class="card-body">
                        <div id='calendar' style="overflow: visible"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Calendar -->
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
                <form class="text-center p-1" action="<?php echo URL;?>api/booking/add" method="post">

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
<script src='<?php echo URL;?>application/assets/fullcalendar/packages/core/main.min.js'></script>
<script src='<?php echo URL;?>application/assets/fullcalendar/packages/interaction/main.min.js'></script>
<script src='<?php echo URL;?>application/assets/fullcalendar/packages/daygrid/main.min.js'></script>
<script src='<?php echo URL;?>application/assets/fullcalendar/packages/timegrid/main.min.js'></script>
<script src='<?php echo URL;?>application/assets/fullcalendar/packages/list/main.min.js'></script>
<script src='<?php echo URL;?>application/assets/fullcalendar/packages/bootstrap/main.min.js'></script>
<script src='<?php echo URL;?>application/assets/fullcalendar/packages/core/locales-all.min.js'></script>
<script src='<?php echo URL;?>application/assets/fullcalendar/packages/moment/main.min.js'></script>

<!-- Moment js -->
<script src="<?php echo URL;?>application/assets/js/moment.min.js"></script>

<!-- Notify JS -->
<script src="<?php echo URL;?>application/assets/js/notify.min.js"></script>

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
            eventOverlap: false,
            aspectRatio: 3,
            locale: 'it',
            navLinks: true, // can click day/week names to navigate views
            themeSystem: 'bootstrap', // use mdboostrap syle
            editable: true,
            slotDuration: '00:15:00',
            slotMinutes: 15,
            nowIndicator: true,
            hiddenDays: <?php echo "[" . implode(",", BOOKING_HIDDEN_DAYS) . "]" ?>,
            businessHours: {
                // days of week. an array of zero-based day of week integers
                daysOfWeek: <?php echo "[" . implode(",", CALENDAR_BUSINESS_DAYS) . "]" ?>,
                startTime: '<?php echo CALENDAR_BUSINESS_TIME_START; ?>', // a start time
                endTime: '<?php echo CALENDAR_BUSINESS_TIME_END; ?>', // an end time
            },
            selectConstraint: "businessHours",
            bootstrapFontAwesome: { // Use fontawesome icons
                close: 'fa-times',
                prev: 'fa-chevron-left',
                next: 'fa-chevron-right',
                prevYear: 'fa-angle-double-left',
                nextYear: 'fa-angle-double-right'
            },
            eventSources: [
                {
                    url: '<?php echo URL;?>api/calendar',
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
                            url: '<?php echo URL;?>/api/calendar',
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
            eventClick: function (info) {
                let event = info.event;
                let extra_data = info.event.extendedProps;

                // Date and time (start time - end time)
                $('#event-date').text(moment(event.start).format("DD/MM/YYYY"));
                $('#event-time-start').text(moment(event.start).format('HH:mm'));
                $('#event-time-end').text(moment(event.end).format('HH:mm'));

                // Additional data (notes, professor, ...)
                $('#event_professor').text(extra_data.professor);

                if (extra_data.note != null) {
                    // Set additional notes input text
                    $('#event_note').val(extra_data.note).trigger('change');
                }

                // Show modal
                $('#eventInfo').modal('show');

                // add listener for delete
                $('.delete-event-button').on('click', function () {
                    console.log("[!] Sending delete request to apis");
                    $.ajax({
                        type: "POST",
                        url: "<?php echo URL;?>api/booking/delete/" + event.id,
                        success: function (result) {
                            if (result["success"]) {
                                console.log("[!] event deleted");

                                // Remove click handler after insert

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

                });

                // add lister for update
                $('.update-event-button').on('click', function () {
                    console.log("[!] Update action detected");

                    // Show modal
                    let modal = $("#eventInfo");

                    // Get data
                    let date = moment(modal.find("#event-date").text(), "DD/MM/YYYY");
                    let startTime = modal.find('#event-time-start').text();
                    let endTime = modal.find('#event-time-end').text();
                    let osservazioni = modal.find("#event_note").val();

                    console.log(date.format("DD/MM/YYYY") + " " + startTime + " - " + endTime);

                    // Make requests
                    $.ajax({
                        type: "POST",
                        url: "<?php echo URL;?>api/booking/update/" + event.id,
                        data: {
                            "data": date.format('DD/MM/YYYY'),
                            "ora_inizio": startTime,
                            "ora_fine": endTime,
                            "osservazioni": osservazioni,
                        },
                        success: function (result) {
                            console.log(result);

                            if (result["success"]) {
                                console.log("[!] event updated");

                                calendar.refetchEvents();
                                $('#eventInfo').modal('hide');

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


                });
            },
            dateClick: function (info) {
                // process data
                var now = moment();
                var date = moment(info.dateStr);

                if (date.diff(now) < 0) {
                    // Show error
                    $.notify("La data desirata è già passata", "warn");
                } else {
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
                        let date_str = date.format('DD/MM/YYYY');

                        $.ajax({
                            type: "POST",
                            url: "<?php echo URL;?>api/booking/add",
                            data: {
                                "data": date_str,
                                "ora_inizio": startTime,
                                "ora_fine": endTime,
                                "osservazioni": osservazioni,
                            },
                            success: function (result) {
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
                    });
                }
            },
            eventDrop: function (info) {
                let new_event = info.event;

                let date = moment(new_event.start).format("DD/MM/YYYY");

                let start = moment(new_event.start).format("HH:mm");
                let end = moment(new_event.end).format("HH:mm");
                let osservazioni = new_event.extendedProps.osservazioni;

                $.ajax({
                    type: "POST",
                    url: "<?php echo URL;?>api/booking/update/" + new_event.id,
                    data: {
                        "data": date,
                        "ora_inizio": start,
                        "ora_fine": end,
                        "osservazioni": osservazioni,
                    },
                    success: function (result) {
                        if (result["success"]) {
                            console.log("[!] event moved");

                            calendar.refetchEvents();

                            // Notify success
                            $.notify("Evento mosso con successo", "success");
                        } else {
                            console.log(result["errors"]);

                            result["errors"].forEach(function (item, index, arr) {
                                $.notify(item, "warn");
                            });

                            // Reset event to previous location
                            info.revert();
                        }
                    },
                    dataType: "json"
                });

            },
            eventResize: function (info) {
                let new_event = info.event;

                let date = moment(new_event.start).format("DD/MM/YYYY");

                let start = moment(new_event.start).format("HH:mm");
                let end = moment(new_event.end).format("HH:mm");
                let osservazioni = new_event.extendedProps.osservazioni;

                console.log("[!] Sending resize request");
                $.ajax({
                    type: "POST",
                    url: "<?php echo URL;?>api/booking/update/" + new_event.id,
                    data: {
                        "data": date,
                        "ora_inizio": start,
                        "ora_fine": end,
                        "osservazioni": osservazioni,
                    },
                    success: function (result) {
                        if (result["success"]) {
                            console.log("[!] event schedule changed");

                            calendar.refetchEvents();

                            // Notify success
                            $.notify("Orario modificato con successo", "success");
                        } else {
                            console.log(result["errors"]);

                            result["errors"].forEach(function (item, index, arr) {
                                $.notify(item, "warn");
                            });

                            // Reset event to previous location
                            info.revert();
                        }
                    },
                    dataType: "json"
                });

                console.log(start + " - " + end);
            },
            windowResize: function(view){
                console.log("[!] Detected window resize");

                // Check if is mobile or not
                if ($(window).width() < 1000) {
                    // Mobile screen
                    this.setOption('height', 700);
                }
                else{
                    // Larger screen: height calculated from aspectRatio value
                    this.setOption('height', 'auto');
                }
            }
        });
        calendar.render();

        $("#eventInfo").on('hide.bs.modal', function () {
            console.log("[!] Information modal now hidden");
            $('.update-event-button').off("click");
            $('.delete-event-button').off("click");

            // Clear note
            $('#event_note').val("");
        });

        $("#eventInsert").on('hide.bs.modal', function () {
            console.log("[!] Insert modal now hidden");
            $('#event-insert-submit').off('click');

            // Clear note
            $('#eventInsert').find("#event-osservazioni").val("");

        });

        /**
         * This function is used to refresh/refetch all the events of the calendar
         */
        function refreshCalendar() {
            calendar.refetchEvents();
            console.log("[!] Calendar refreshed");
        }

        setInterval(refreshCalendar, 1000 * 60 * 2); // Update every 2 mins
    });
</script>
