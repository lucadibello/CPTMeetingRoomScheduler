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

    <!-- Swiper Js Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css">

    <!-- Personal style file -->
    <link href="./application/assets/css/style.css" rel="stylesheet">

    <!-- Page title -->
    <title>CPT MRS - Change password</title>

</head>
<body>
    <div class="container-fluid text-center align-content-center">
        <h1>Cambia la tua password</h1>
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6 col-sm-offset-3">
                <p class="text-center">Il sistema ha rilevato che hai eseguito il tuo primo accesso. Utilizza questo modulo per sostiture la tua password con una personale.</p>
                <form method="post" id="passwordForm">
                    <input type="password" class="input-lg form-control" name="password_input" id="password1" placeholder="New Password" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-6">
                            <i id="8char" class="fa fa-times" style="color:#FF0004;"></i>  8 Characters Long<br>
                            <i id="ucase" class="fa fa-times" style="color:#FF0004;"></i> One Uppercase Letter
                        </div>
                        <div class="col-sm-6">
                            <i id="lcase" class="fa fa-times" style="color:#FF0004;"></i> One Lowercase Letter<br>
                            <i id="num" class="fa fa-times" style="color:#FF0004;"></i> One Number<br>
                        </div>
                    </div>
                    <input type="password" class="input-lg form-control" name="password2" id="password2" placeholder="Repeat Password" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-12">
                            <span id="pwmatch" class="fa fa-times" style="color:#FF0004;"></span> Passwords Match
                        </div>
                    </div>
                    <input type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg" data-loading-text="Changing Password..." value="Change Password">
                </form>
            </div><!--/col-sm-6-->
        </div><!--/row-->
    </div>

    <!-- JQuery -->
    <script src="./application/assets/js/jquery.min.js"></script>
    <!-- Password validation -->
    <script src="./application/assets/js/changepassword/password_validation.js"></script>
</body>
</html>