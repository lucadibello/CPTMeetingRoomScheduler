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

    <style>



    </style>
</head>

<body>
    <div id="main" class="container-fluid">
        <div class="row">
            <div id="left-column" class="col-lg-7 vh-100 z-depth-5">
                <p></p>
                <!-- Default form login -->
                <form class="text-center p-5" action="#!">

                    <p class="h1 mb-4 light-title">Accedi</p>
                    <br class="h4">

                    <!-- Email -->
                    <input type="email" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="E-mail">

                    <!-- Password -->
                    <input type="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Password">

                    <!-- Sign in button -->
                    <button class="btn btn-info btn-block my-4 button-login" type="submit">Accedi</button>
                </form>
                <!-- Default form login -->

            </div>

            <div id="background-column" class="col-lg-5 vh-100">
                <div id="scene">
                    <h1 id="app_name" data-depth="0.1">CPT Meeting Room Scheduler</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- JQuery -->
    <script type="text/javascript" src="./application/assets/mdb/js/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js"></script>

    <script>
        var parallaxInstance = new Parallax($('#scene').get(0),{
            relativeInput: true,
        });

    </script>
</body>
</html>