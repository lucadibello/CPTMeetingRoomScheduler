<!-- Footer -->
<footer class="page-footer font-small blue">
    <!-- Copyright -->
    <div class="text-center">© <?php echo date("Y");?> Copyright:
        <a class="text-white font-weight-bold" href="<?php echo URL;?>"><?php echo APP_NAME ?></a>
    </div>
    <!-- Copyright -->

    <div class="text-center">
        Sviluppatore: <a class="text-white font-weight-bold" href="contatti">Luca Di Bello I4AC</a>
    </div>
</footer>
<!-- Footer -->

<!-- SCRIPTS -->

<!-- Bootstrap tooltips -->
<script type="text/javascript" src="<?php echo URL;?>application/assets/mdb/js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?php echo URL;?>application/assets/mdb/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="<?php echo URL;?>application/assets/mdb/js/mdb.min.js"></script>

<!-- Initializations -->
<script type="text/javascript">
    // Animations initialization
    new WOW().init();

    // Load tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>

</body>
</html>