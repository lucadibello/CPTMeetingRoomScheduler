<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap core CSS -->
    <link href="/application/assets/mdb/css/bootstrap.min.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="/application/assets/mdb/css/mdb.min.css" rel="stylesheet">

    <!-- Animate CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

    <!-- Swiper Js Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css">

    <!-- Personal style file -->
    <link href="/application/assets/css/style.css" rel="stylesheet">

    <!-- Page title -->
    <title>CPT MRS - Change password</title>

</head>
<body>
    <div class="container-fluid">
        <br><br>
        <div class="row d-flex justify-content-center">
            <!-- Card -->
            <div class="col-md-6 card">

                <!-- Card body -->
                <div class="card-body">

                    <!-- Material form register -->
                    <form method="post" action=<?php echo RedirectManager::buildUrl("changepassword/verify")?>>
                        <h4 class="h4-responsive text-center py-4">Cambia la password</h4>

                        <?php if(count($GLOBALS["NOTIFIER"]->getNotifications()) != 0): ?>
                            <!-- Write notifications one by one -->
                            <?php foreach ($GLOBALS["NOTIFIER"]->getNotifications() as $notification): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $notification ?>
                                </div>
                            <?php endforeach; ?>
                            <!-- Clear notifications -->
                            <?php $GLOBALS["NOTIFIER"]->clear(); ?>
                            <br>
                        <?php endif; ?>

                        <!-- Material input password -->
                        <div class="md-form">
                            <i class="fa fa-lock prefix grey-text"></i>
                            <input type="password" id="newPassword" name="newPassword" class="form-control">
                            <label for="newPassword" class="font-weight-light">Nuova password</label>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                La tua password deve essere lunga almeno 8 caratteri, contenere lettere e numeri,
                                non deve contenere spazi o emoji.
                            </small>
                        </div>

                        <!-- Material input password -->
                        <div class="md-form">
                            <i class="fa fa-lock prefix grey-text"></i>
                            <input type="password" name="confirmPassword" id="retypePassword" class="form-control">
                            <label for="retypePassword" class="font-weight-light">Conferma password</label>
                        </div>

                        <div class="text-center py-4 mt-3">
                            <button class="btn btn-cyan" type="submit">Cambia password</button>
                        </div>
                    </form>
                    <!-- Material form register -->

                </div>
                <!-- Card body -->

            </div>
            <!-- Card -->
        </div>
    </div>

    <!-- Side Modal Top Right -->

    <!-- To change the direction of the modal animation change .right class -->
    <div class="modal fade right" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <!-- Add class .modal-side and then add class .modal-top-right (or other classes from list above) to set a position to the modal -->
        <div class="modal-dialog modal-side modal-bottom-right" role="document">


            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title w-100" id="myModalLabel">Perchè il cambio password?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Per rimanere al sicuro da possibili accessi non autorizzati all'account devi sostituire la password
                    corrente con una nuova password personale. Tienila al sicuro.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Side Modal Top Right -->

    <!-- JQuery -->
    <script src="/application/assets/js/jquery.min.js"></script>
    <script src="/application/assets/mdb/js/bootstrap.js"></script>
    <script src="/application/assets/mdb/js/mdb.js"></script>
    <script src="/application/assets/mdb/js/popper.min.js"></script>

    <!-- Validation -->
    <script src="/application/assets/js/changepassword/password_validation.js"></script>

    <script>
        $(document).ready(function(){
            $('#infoModal').modal('show');
        });
    </script>
</body>
</html>