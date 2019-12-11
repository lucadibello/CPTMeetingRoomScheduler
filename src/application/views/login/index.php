<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap core CSS -->
    <link href="./application/assets/mdb/css/bootstrap.min.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="./application/assets/mdb/css/mdb.min.css" rel="stylesheet">

    <!-- Animate CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

    <!-- Personal style file -->
    <link href="./application/assets/css/style.css" rel="stylesheet">

    <!-- Page title -->
    <title>CPT MRS - Login</title>

</head>

<body>
    <div id="main" class="container-fluid">
        <div class="row">
            <div id="left-column" class="col-lg-7 vh-100 z-depth-5">
                <p></p>

                <!-- Check if there are notifications -->
                <?php if(count($GLOBALS["NOTIFIER"]->getNotifications()) != 0): ?>
                    <!-- Write notifications one by one -->
                    <?php foreach ($GLOBALS["NOTIFIER"]->getNotifications() as $notification): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $notification ?>
                        </div>
                    <?php endforeach; ?>
                    <!-- Clear notifications -->
                    <?php $GLOBALS["NOTIFIER"]->clear(); ?>
                <?php endif; ?>

                <?php var_dump($_SESSION) ?>

                <!-- Default form login -->
                <form class="text-center p-5" action="login/auth" method="post">

                    <p class="h1 mb-4 light-title">Accedi</p>
                    <br class="h4">

                    <!-- Email -->
                    <input type="text" name="username" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="E-mail">

                    <!-- Password -->
                    <input type="password" name="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Password">

                    <!-- Sign in button -->
                    <button class="btn btn-info btn-block my-4 button-login" type="submit">Accedi</button>
                </form>
                <!-- Default form login -->

            </div>

            <div id="background-column" class="col-lg-5 vh-100">
                <div id="scene">
                    <h1 id="app_name" data-depth="0.1"><?php echo APP_NAME ?></h1>
                </div>
            </div>
        </div>
    </div>

    <!-- To change the direction of the modal animation change .right class -->
    <div class="modal fade right" id="pswChangedSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <!-- Add class .modal-side and then add class .modal-top-right (or other classes from list above) to set a position to the modal -->
        <div class="modal-dialog modal-side modal-bottom-right" role="document">


            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title w-100" id="myModalLabel">Cambio password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Hai cambiato la tua password. Esegui nuovamente l'accesso utilizzando
                    le nuove credenziali per utilizzare il sistema!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Ho capito</button>
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

    <script>
        <?php if(isset($_COOKIE["password_changed_successfully"]) && $_COOKIE["password_changed_successfully"] == '1'): ?>
            /* Password changed correctly */
            $('#pswChangedSuccess').modal("show");
        <?php else: ?>
            console.log('[!] Cannot access cookies.');
        <?php endif; ?>
    </script>
</body>
</html>