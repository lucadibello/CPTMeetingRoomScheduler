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
                                        <button class="btn btn-primary edit-booking-button" data-toggle="tooltip" title="Modifica prenotazione" book-target="<?php echo $booking->getId();?>">
                                            <i class="fas fa-user-edit"></i>
                                        </button>

                                        <!-- Check for permissions -->
                                        <?php if(PermissionManager::getPermissions()->canCancellazionePrenotazioniPrivate()): ?>
                                            <button class="btn btn-danger delete-booking-button" data-toggle="tooltip" title="Elimina prenotazione" book-target="<?php echo $booking->getId();?>">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        <?php endif; ?>
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

<!-- Chart js for the stats section -->
<script src="/application/assets/mdb/js/modules/chart.js"></script>
<script src="/application/assets/mdb/js/addons/datatables.min.js"></script>

<!-- Bootstrap tooltips -->
<script type="text/javascript" src="/application/assets/mdb/js/popper.min.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

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
</script>
