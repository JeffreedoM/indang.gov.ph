<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';
/* For resident statistics*/
$stmt = $pdo->prepare("SELECT * FROM resident WHERE barangay_id = :barangay_id");
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$resident = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Classification */
$total_residents = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM resident WHERE is_alive = 1 AND barangay_id = $barangayId")->fetchColumn();

// Get all ages in years
$ages = $pdo->query("SELECT TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age FROM resident WHERE is_alive = 1 AND barangay_id = $barangayId")->fetchAll(PDO::FETCH_COLUMN);

// Calculate counts for each age group
$infant = count(array_filter($ages, function ($age) {
    return $age >= 0 && $age <= 1;
}));

$children = count(array_filter($ages, function ($age) {
    return $age >= 2 && $age <= 12;
}));

$teens = count(array_filter($ages, function ($age) {
    return $age >= 13 && $age <= 17;
}));

$adult = count(array_filter($ages, function ($age) {
    return $age >= 18 && $age <= 59;
}));

$senior = count(array_filter($ages, function ($age) {
    return $age >= 60;
}));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <!-- all page  styling -->
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <!-- specific page styling -->
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="icon" type="image/x-icon" href="../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Dashboard</title>
</head>

<body>
    <?php
    include '../../partials/nav_sidebar.php';
    ?>

    <main class="main-content">
        <?php
        include '../../partials/nav_header.php';
        ?>

        <!-- Container -->
        <div class="wrapper" style="margin-bottom: 10%;">
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header">
                <h3 class="page-title">Resident Profiling Dashboard</h3>
            </div>

            <!-- Page body -->
            <div class="page-body">
                <div class="card-container">
                    <div class="cards">
                        <div class="card">
                            <h1 class="card-title">Total Residents</h1>
                            <p class="card-body"><?php echo $total_residents ?></p>
                        </div>
                        <div class="card">
                            <h1 class="card-title">Infants</h1>
                            <p class="card-body"><?php echo $infant ?></p>
                        </div>
                        <div class="card">
                            <h1 class="card-title">Children</h1>
                            <p class="card-body"><?php echo $children ?></p>
                        </div>
                    </div>
                    <div class="cards">
                        <div class="card">
                            <h1 class="card-title">Teens</h1>
                            <p class="card-body"><?php echo $teens ?></p>
                        </div>
                        <div class="card">
                            <h1 class="card-title">Adult</h1>
                            <p class="card-body"><?php echo $adult ?></p>
                        </div>
                        <div class="card">
                            <h1 class="card-title">Senior Citizen</h1>
                            <p class="card-body"><?php echo $senior ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-header">
                <h3 class="page-title">Resident Population Graph</h3>
            </div>

            <div class="chart-container">
                <div id="piechart"></div>
                <!-- <canvas id="piechart"></canvas> -->
            </div>

        </div>


    </main>

    <script src="../../assets/js/sidebar.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });

        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Resident Population', 'Total Numbers'],
                ['Infant', <?php echo $infant ?>],
                ['Children', <?php echo $children ?>],
                ['Teens', <?php echo $teens ?>],
                ['Adult', <?php echo $adult ?>],
                ['Senior Citizen', <?php echo $senior ?>]
            ]);

            var options = {
                // title: 'My Daily Activities'
                sliceVisibilityThreshold: 0,
                width: '100%',
                height: '100%',
                legend: {
                    position: 'bottom',
                    alignment: 'center'
                }

            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }

        window.addEventListener('load', drawChart);
        window.addEventListener('resize', drawChart);

        $(document).ready(function() {
            $(window).resize(function() {
                drawChart();
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>