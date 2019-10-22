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
</main>

<!-- Chart js for the "statistiche" section -->
<script src="/application/assets/mdb/js/modules/chart.js"></script>
<script src="/application/assets/mdb/js/addons/datatables.min.js"></script>

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
    })
</script>
