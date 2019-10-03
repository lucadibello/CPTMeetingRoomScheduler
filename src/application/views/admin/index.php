<!--Main layout-->
<main class="pt-5 mx-lg-5">
    <div id="container" class="container-fluid mt-5">

        <!-- Heading -->
        <div class="card mb-4 wow fadeIn">

            <!--Card content-->
            <div class="card-body d-sm-flex justify-content-between">

                <h4 class="mb-2 mb-sm-0 pt-1">
                    <span class="blue-text font-weight-bold">Admin Panel</span>
                    <span>/</span>
                    <span>Dashboard</span>
                </h4>

                <form class="d-flex justify-content-center">
                    <!-- Default input -->
                    <input type="search" placeholder="Type your query" aria-label="Search" class="form-control">
                    <button class="btn btn-primary btn-sm my-0 p" type="submit">
                        <i class="fas fa-search"></i>
                    </button>

                </form>

            </div>

        </div>
        <!-- Heading -->

        <!--Grid row-->
        <div class="row wow fadeIn">

            <!--Grid column-->
            <div class="col-md-9 mb-4">

                <!--Card-->
                <div class="card">

                    <!--Card content-->
                    <div class="card-body">

                        <canvas id="myChart"></canvas>

                    </div>

                </div>
                <!--/.Card-->

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-3 mb-4">

                <!--Card-->
                <div class="card mb-4">

                    <!-- Card header -->
                    <div class="card-header text-center">
                        Pie chart
                    </div>

                    <!--Card content-->
                    <div class="card-body">

                        <canvas id="pieChart"></canvas>

                    </div>

                </div>
                <!--/.Card-->
            </div>
            <!--Grid row-->

        </div>
        <!-- Social icons -->

        <footer>
            <!--Copyright-->
            <div class="footer-copyright py-3">
                © 2019 Copyright:
                <a href="" target="_blank"><?php echo APP_NAME ?></a>
            </div>
            <!--/.Copyright-->

        </footer>
        <!--/.Footer-->
    </div>
</main>

<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="/application/assets/mdb/js/jquery-3.4.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="/application/assets/mdb/js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="/application/assets/mdb/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="/application/assets/mdb/js/mdb.min.js"></script>

<!-- Initializations -->
<script type="text/javascript">
    // Animations initialization
    new WOW().init();
</script>

<!-- Charts -->
<script>
    // Line
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    //pie
    var ctxP = document.getElementById("pieChart").getContext('2d');
    var myPieChart = new Chart(ctxP, {
        type: 'pie',
        data: {
            labels: ["Red", "Green", "Yellow", "Grey", "Dark Grey"],
            datasets: [{
                data: [300, 50, 100, 40, 120],
                backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"],
                hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
            }]
        },
        options: {
            responsive: true,
            legend: false
        }
    });
</script>

</body>
</html>
