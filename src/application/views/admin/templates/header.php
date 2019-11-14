<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo APP_NAME?> - Admin Panel</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="/application/assets/mdb/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="/application/assets/mdb/css/mdb.min.css" rel="stylesheet">
    <!-- datatables css -->
    <link href="/application/assets/mdb/css/addons/datatables.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="/application/assets/mdb/css/style.min.css" rel="stylesheet">

    <!-- JQuery -->
    <script type="text/javascript" src="/application/assets/mdb/js/jquery-3.4.1.min.js"></script>
</head>

<body class="grey lighten-3">

<!--Main Navigation-->
<header>

    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
        <div class="container-fluid">

            <!-- Brand -->
            <a class="navbar-brand waves-effect" href="https://mdbootstrap.com/docs/jquery/" target="_blank">
                <strong class="blue-text"><?php echo APP_NAME ?></strong>
            </a>

            <!-- Collapse -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Left -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link waves-effect" href="/admin/dashboard">Dashboard
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>

                    <?php if($_SESSION["permissions"]->canUserAction()): ?>
                    <li class="nav-item">
                        <a class="nav-link waves-effect" href="/admin/utenti">
                            Gestione utenti
                        </a>
                    </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link waves-effect"
                           href="https://mdbootstrap.com/docs/jquery/getting-started/download/">
                            Gestione prenotazioni
                        </a>
                    </li>
                </ul>

                <!-- Right -->
                <ul class="navbar-nav nav-flex-icons">
                    <li class="nav-item">
                        <a href="https://github.com/lucadibello/CPTMeetingRoomScheduler"
                           class="nav-link border border-light rounded waves-effect"
                           target="_blank">
                            <i class="fab fa-github mr-2"></i>GitHub Repository
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar -->
</header>
<!--Main Navigation-->
