<main class="pt-5 mx-lg-5">
    <div id="container" class="container-fluid mt-5">
        <!-- Heading -->
        <div class="card mb-4 wow fadeIn">

            <!--Card content-->
            <div class="card-body d-sm-flex justify-content-between">

                <h4 class="mb-2 mb-sm-0 pt-1">
                    <span class="blue-text font-weight-bold"><?php echo APP_NAME; ?></span>
                    <span>/</span>
                    <span>Report</span>
                </h4>
            </div>

        </div>
        <!-- Heading -->

        <!-- How to use + pros -->
        <div class="container my-5 py-5 z-depth-1 white">
            <div class="col-md-12">
                <!--Section: Content-->
                <section class="mx-md-5 dark-grey-text text-center">
                    <!--Grid row-->
                    <div class="row justify-content-center">
                        <!--Grid column-->
                        <div class="col-lg-8">
                            <!--Grid row-->
                            <div class="row">
                                <!--First column-->
                                <div class="col-md-3 col-6 mb-4">
                                    <i class="fas fa-gem fa-3x blue-text"></i>
                                </div>
                                <!--/First column-->

                                <!--Second column-->
                                <div class="col-md-3 col-6 mb-4">
                                    <i class="fas fa-chart-area fa-3x teal-text"></i>
                                </div>
                                <!--/Second column-->

                                <!--Third column-->
                                <div class="col-md-3 col-6 mb-4">
                                    <i class="fas fa-cogs fa-3x indigo-text"></i>
                                </div>
                                <!--/Third column-->

                                <!--Fourth column-->
                                <div class="col-md-3 col-6 mb-4">
                                    <i class="fas fa-cloud-upload-alt fa-3x deep-purple-text"></i>
                                </div>
                                <!--/Fourth column-->
                            </div>
                            <!--/Grid row-->
                            <p>I report ti permettono di avere una panoramica di chi e come viene utilizzato il servizio:
                                mostrano tutte le prenotazioni effettutate/prenotate in un determinato arco di tempo. Esso è selezionabile tramite il campo <span class="font-weight-bold">Tipo di report</span>. Per generare un report basta selezionare le opzioni nel modulo sottostante e cliccare su <span class="font-weight-bold">Genera report</span></span></p>
                        </div>
                        <!--Grid column-->
                    </div>
                    <!--Grid row-->
                </section>
                <!--Section: Content-->
            </div>
        </div>

        <div class="row wow fadeIn mb-5">
            <div class="col-md-12">
                <br>
                <div class="card" id="report-container">
                    <div class="card-header"><h3 class="h3-responsive">Generazione report</h3></div>
                    <div class="card-body">
                        <form action="<?php echo URL;?>report/generate" method="post">
                            <!-- Subject -->
                            <label>Tipo di report</label>
                            <select class="browser-default custom-select mb-4" name="type">
                                <?php foreach ($types as $name => $type_id): ?>
                                    <option value="<?php echo $type_id; ?>" selected><?php echo $name; ?></option>
                                <?php endforeach; ?>
                            </select>

                            <!-- Copy -->
                            <div class="custom-control custom-checkbox mb-4">
                                <input type="checkbox" class="custom-control-input" id="defaultContactFormCopy"
                                       name="all">
                                <label class="custom-control-label" for="defaultContactFormCopy">Mostra anche
                                    appuntamenti vecchi</label>
                                <i class="fas fa-info-circle" data-toggle="tooltip"
                                   title="Se abilitato nel report generato verranno mostrate anche le prenotazioni vecchie"></i>
                            </div>

                            <p class="font-small grey-text d-flex justify-content-end"><i
                                        class="fas fa-exclamation-triangle red-text mr-2 align-text-bottom"></i> Il
                                documento generato non viene salvato automaticamente nel sistema.
                                Se si vuole mantenere una copia bisogna salvare il report sul proprio dispositivo</p>

                            <!-- Send button -->
                            <button class="btn btn-info btn-block" type="submit">Genera report</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>