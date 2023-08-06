<?php
include 'includes/session.inc.php';
/* For resident statistics*/
$stmt = $pdo->prepare("SELECT * FROM resident");
$stmt->execute();
$resident = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Selectign registered barangays */
$query = "SELECT * FROM barangay";

// Execute the query and fetch the result set
$stmt = $pdo->query($query);
$barangays = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Top 10 Barangays
$query = "SELECT *, COALESCE(COUNT(*), 0) as total_residents
          FROM resident
          JOIN barangay ON resident.barangay_id = barangay.b_id
          GROUP BY barangay_id
          ORDER BY total_residents DESC
          LIMIT 10";

$stmt = $pdo->prepare($query);
$stmt->execute();
$top10Barangays = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Assuming $top10Barangays is the data fetched from the database
$barangayData = array(); // Initialize an empty array

// Add the column headers as the first element of the $barangayData array
$barangayData[] = ['Barangay', 'Total Residents'];

// Loop through the $top10Barangays data and add each row to the $barangayData array
foreach ($top10Barangays as $barangay) {
    // Assuming $barangay['name'] contains the name of the barangay, and $barangay['total_residents'] contains the total residents count
    $barangayData[] = [$barangay['b_name'], (int)$barangay['total_residents']]; // Ensure total_residents is cast to integer (or use floatval() for float)
}

// Convert the $barangayData array to a JSON string for JavaScript
$barangayDataJSON = json_encode($barangayData);



/* Classification */
// Get all ages in years
$ages = $pdo->query("SELECT TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age FROM resident")->fetchAll(PDO::FETCH_COLUMN);

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="./assets/css/main.css" />
    <link rel="stylesheet" href="./assets/css/bs-overwrite.css" />
    <link rel="stylesheet" href="assets/css/dashboard.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin Panel</title>
</head>

<body>
    <?php
    include 'partials/nav_sidebar.php';
    ?>

    <main class="main-content">
        <?php
        include 'partials/nav_header.php';
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


            <div class="w-full md:flex gap-6 mt-28">
                <!-- Registered Barangay -->
                <div class="w-full md:w-1/2 mb-3 bg-white p-10">
                    <h1 class="font-semibold mb-6">Registered Barangay</h1>
                    <table id="barangays-table" class="row-border hover">
                        <thead>
                            <tr>
                                <th class="w-full">Barangay</th>
                                <th class="whitespace-nowrap">Total Residents</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($barangays as $barangay) : ?>

                                <?php
                                $barangayId = $barangay['b_id'];
                                $query = "SELECT COUNT(*) as total_residents FROM resident WHERE barangay_id = :barangay_id";
                                $stmt = $pdo->prepare($query);
                                $stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <tr>
                                    <td class="w-full"><?php echo $barangay['b_name'] ?></td>
                                    <td class="whitespace-nowrap"><?php echo $result['total_residents'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="w-full md:w-1/2 mb-3 bg-white p-10">
                    <h1 class="font-semibold mb-6">Top 10 Barangays by Total Residents</h1>
                    <div id="columnChart" style="height: 500px;"></div>
                </div>

            </div>


    </main>

    <script src="./assets/js/sidebar.js"></script>
    <script src="./assets/js/header.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#barangays-table').DataTable({
                "dom": "frtip"
            });
        });
    </script>
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
    <!-- Top 10 Barangays by total residents -->
    <script>
        // PHP variable containing the JSON-encoded data
        const barangayData = <?php echo $barangayDataJSON; ?>;

        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawColumnChart);

        function drawColumnChart() {
            const data = google.visualization.arrayToDataTable(barangayData);

            const options = {
                title: 'Barangay Statistics - Top 10 Barangays by Total Residents',
                chartArea: {
                    width: '50%'
                },
                hAxis: {
                    title: 'Total Residents',
                    minValue: 0
                },
                vAxis: {
                    title: 'Barangay'
                }
            };

            const chart = new google.visualization.BarChart(document.getElementById('columnChart'));
            chart.draw(data, options);
        }
    </script>
</body>

</html>