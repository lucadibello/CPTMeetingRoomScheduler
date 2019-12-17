<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo APP_NAME?> - Errore</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo URL;?>application/assets/mdb/css/bootstrap.min.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="<?php echo URL;?>application/assets/mdb/css/mdb.min.css" rel="stylesheet">

    <!-- Animate CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

</head>
<body>
    <section style="height: 100vh;">
        <div class="container-fluid">
            <div class="row">
                <div class="col d-table">
                    <div class="text-center d-table-cell align-middle animated slideInDown" style="height: 100vh;">
                        <i class="far fa-angry fa-10x text-danger"></i>
                        <h2 class="font-weight-bold mb-4 my-2">Halt!</h2>

                        <p><?php echo $msg ?></p>
                        <br>
                        <a class="btn btn-danger mt-4" href="<?php echo URL ?>">Torna alla homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>