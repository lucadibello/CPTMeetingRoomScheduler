<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo APP_NAME?> - CPT MRS</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="<?php echo URL;?>application/assets/mdb/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="<?php echo URL;?>application/assets/mdb/css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="<?php echo URL;?>application/assets/css/style.css" rel="stylesheet">


    <!-- Full Calendar CSS -->
    <link href='<?php echo URL;?>application/assets/fullcalendar/packages/core/main.css' rel='stylesheet' />
    <link href='<?php echo URL;?>application/assets/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
    <link href='<?php echo URL;?>application/assets/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
    <link href='<?php echo URL;?>application/assets/fullcalendar/packages/list/main.css' rel='stylesheet' />
    <link href='<?php echo URL;?>application/assets/fullcalendar/packages/bootstrap/main.min.css' rel='stylesheet' />

    <!-- JQuery -->
    <script type="text/javascript" src="<?php echo URL;?>application/assets/mdb/js/jquery-3.4.1.min.js"></script>
</head>

<body class="grey lighten-3">

<!--Main Navigation-->
<header>

    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
        <div class="container-fluid">

            <!-- Brand -->
            <a class="navbar-brand waves-effect" href="/" target="_top">
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
                    <?php if(PermissionManager::getPermissions()->canVisionePrenotazioni()): ?>
                        <li class="nav-item">
                            <a class="nav-link waves-effect active" href="<?php echo URL;?>calendario">
                                Calendario
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link waves-effect" href="<?php echo URL;?>contatti">
                            Contatti
                        </a>
                    </li>
                </ul>

                <!-- Right -->
                <ul class="navbar-nav nav-flex-icons">
                    <?php if(PermissionManager::getPermissions()->canGenerareReport()): ?>
                        <li class="nav-item mr-2">
                            <a href="/report"
                               class="nav-link btn-amber waves-effect"
                               target="_top">
                                Report
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a href="/logout"
                           class="nav-link border border-light rounded waves-effect"
                           target="_top">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar -->
</header>
<!--Main Navigation-->
