<main class="pt-5 mx-lg-5">
    <div id="container" class="container-fluid mt-5">
        <!-- Heading -->
        <div class="card mb-4 wow fadeIn">

            <!--Card content-->
            <div class="card-body d-sm-flex justify-content-between">

                <h4 class="mb-2 mb-sm-0 pt-1">
                    <span class="blue-text font-weight-bold"><?php echo APP_NAME;?></span>
                    <span>/</span>
                    <span>Prenotazioni</span>
                </h4>
            </div>

        </div>
        <!-- Heading -->

        <!-- TODO: REMOVE THIS IN PRODUCTION -->
        <div class="row wow fadeIn">
            <div class="col-md-12">
                <br>
                <div class="card" id="aggiungi-categoria">
                    <div class="card-header"><h3 class="h3-responsive">Informazioni sulla sessione</h3></div>
                    <div class="card-body">
                        <?php var_dump($_SESSION); ?>
                        <?php echo CalendarModel::fromBookingsToJson($bookings); ?>
                        <?php var_dump($bookings); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar chart: Numero colloqui fatti - colloqui da fare
        <div class="row wow fadeIn">
            <div class="col-md-12">
                <br>
                <div class="card" id="aggiungi-categoria">
                    <div class="card-header"><h3 class="h3-responsive">Statistiche</h3></div>
                    <div class="card-body">
                        <canvas id="horizontalBar"></canvas>
                    </div>
                </div>
            </div>
        </div>
        -->

        <div class="row wow fadeIn">
            <div class="col-md-12">
                <br>
                <div class="card" id="aggiungi-categoria">
                    <div class="card-header"><h3 class="h3-responsive">Prenotazioni personali</h3></div>
                    <div class="card-body">
                        <table id="bookingTable" class="table-responsive-xl table-striped" cellspacing="0"
                               width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">Data</th>
                                    <th scope="col">Ora inizio</th>
                                    <th scope="col">Ora fine</th>
                                    <th scope="col">Osservazioni</th>
                                    <th scope="col">Opzioni</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td><?php echo $booking->getDataInizio()->format(BOOKING_DATE_FORMAT); ?></td>
                                    <td><?php echo $booking->getDataInizio()->format(BOOKING_TIME_FORMAT); ?></td>
                                    <td><?php echo $booking->getDataFine()->format(BOOKING_TIME_FORMAT); ?></td>

                                    <td class="osservazioni">
                                        <?php if(empty($booking->getOsservazioni())): ?>
                                            -
                                        <?php else: ?>
                                            <button class="btn btn-brown">Mostra osservazioni</button>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <button class="btn btn-primary">Azioni da finire</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
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
</main>

<!-- Chart js for the "statistiche" section -->
<script src="/application/assets/mdb/js/modules/chart.js"></script>
<script src="/application/assets/mdb/js/addons/datatables.min.js"></script>

<!-- FullCalendar Libs -->
<script src='/application/assets/fullcalendar/packages/core/main.js'></script>
<script src='/application/assets/fullcalendar/packages/interaction/main.js'></script>
<script src='/application/assets/fullcalendar/packages/daygrid/main.js'></script>
<script src='/application/assets/fullcalendar/packages/timegrid/main.js'></script>
<script src='/application/assets/fullcalendar/packages/list/main.js'></script>
<script src='/application/assets/fullcalendar/packages/bootstrap/main.min.js'></script>
<script src='/application/assets/fullcalendar/packages/core/locales-all.min.js'></script>

<script>
    /*
    new Chart(document.getElementById("horizontalBar"), {
        "type": "horizontalBar",
        "data": {
            "labels": ["Colloqui fatti", "Colloqui da fare"],
            "datasets": [{
                "label": "My First Dataset",
                "data": [22, 33, 55, 12, 86, 23, 14],
                "fill": false,
                "backgroundColor": ["rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)"],
                "borderColor": ["rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)"],
                "borderWidth": 1
            }]
        },
        "options": {
            "scales": {
                "xAxes": [{
                    "ticks": {
                        "beginAtZero": true
                    }
                }]
            },
        }
    });
    */

    $(document).ready(function () {
        // Load datatable
        $('#bookingTable').dataTable({
            "responsive": true,
            "scrollX": false,
            "searching": false,
            "language": {
                "lengthMenu": "Mostro _MENU_ prenotazioni per pagina",
                "zeroRecords": "Non hai effettuato nessuna prenotazione.",
                "info": "Pagina _PAGE_ di _PAGES_",
                "infoEmpty": "Non ci sono prenotazioni disponibili",
                "infoFiltered": "(Ricerca effettuata tra _MAX_ prenotazioni)"
            }
        });
        $('.dataTables_length').addClass('bs-select');

        // Load calendar JS
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'bootstrap', 'dayGrid', 'timeGrid', 'list' ],
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            eventClick: function(info) {
                var eventObj = info.event;

                if (eventObj.url) {
                    alert(
                        'Clicked ' + eventObj.title + '.\n' +
                        'Will open ' + eventObj.url + ' in a new tab'
                    );

                    window.open(eventObj.url);

                    info.jsEvent.preventDefault(); // prevents browser from following link in current tab.
                } else {
                    alert('Clicked ' + eventObj.title);
                }
            },
            locale: 'it',
            defaultDate: '2019-08-12',
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
            events: [
                {
                    title: 'Business Lunch',
                    start: '2019-08-03T13:00:00',
                    constraint: 'businessHours'
                },
                {
                    title: 'Meeting',
                    start: '2019-08-13T11:00:00',
                    constraint: 'availableForMeeting', // defined below
                    color: '#257e4a'
                },
                {
                    title: 'Conference',
                    start: '2019-08-18',
                    end: '2019-08-20'
                },
                {
                    title: 'Party',
                    start: '2019-08-29T20:00:00'
                },

                // areas where "Meeting" must be dropped
                {
                    groupId: 'availableForMeeting',
                    start: '2019-08-11T10:00:00',
                    end: '2019-08-11T16:00:00',
                    rendering: 'background'
                },
                {
                    groupId: 'availableForMeeting',
                    start: '2019-08-13T10:00:00',
                    end: '2019-08-13T16:00:00',
                    rendering: 'background'
                },

                // red areas where no events can be dropped
                {
                    start: '2019-08-24',
                    end: '2019-08-28',
                    overlap: false,
                    rendering: 'background',
                    color: '#ff9f89'
                },
                {
                    start: '2019-08-06',
                    end: '2019-08-08',
                    overlap: false,
                    rendering: 'background',
                    color: '#ff9f89'
                }
            ]
        });

        calendar.render();
    })
</script>
