<?php
//for db connection
include 'includes/dbh.inc.php';
//Hide contents if the barangay is deactivated.
include 'includes/deactivated.inc.php';

$sql = 'SELECT mission, vision, objectives FROM barangay_configuration WHERE barangay_id = :barangayId';
$stmt = $pdo->prepare($sql);
$stmt->execute(['barangayId' => $barangayId]);
$barangay_config = $stmt->fetch();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="./assets/css/homepage.css" />
    <title><?php echo $barangayName ?></title>
    <link rel="icon" type="image/x-icon" href="../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">

    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Age Group', 'Percentage'],
                ['Infant', 11],
                ['Children', 2],
                ['Teens', 2],
                ['Adult', 2],
                ['Senior Citizen', 7]
            ]);

            var options = {
                /* title: 'Resident Population Graph', */
                is3D: true,
                fontName: 'Poppins',
                responsive: true,
                titleTextStyle: {
                    fontSize: 30, // 12, 18 whatever you want (don't specify px)
                    bold: true, // true or false
                },
            };


            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
</head>

<body>

    <header>
        <img src="../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>" alt="Logo of <?php echo ucwords($barangay['b_name']) ?>" class="barangay-logo">
        <div>
            <h1 class="barangay-name"><?php echo $barangayName ?></h1>
            <hr>
            <p>Indang, Cavite</p>
        </div>
        <img src="./assets/images/logo.jpg" alt="Logo of Indang" class="indang-logo">
    </header>

    <!-- navigation menu -->
    <nav>
        <ul>
            <li class="nav-item active"><a href="index.php">Home</a></li>
            <div class="nav-item dropdown-btn">About Us
                <div class="nav-item dropdown">
                    <a href="history.php" class="dropdown-item">
                        History
                        <!-- <i class="fa-solid fa-gear"></i> -->
                    </a>
                    <a href="officials.php" class="dropdown-item">
                        Officials
                        <!-- <i class="fa-solid fa-right-from-bracket"></i> -->
                    </a>
                </div>
            </div>
            <li class="nav-item"><a href="announcement.php">Announcement</a></li>
            <li class="nav-item"><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <main>
        <div class="hero">
            <h1 class="hero__title"><?php echo $barangayName ?></h1>
            <p class="hero__p">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eius harum molestiae excepturi incidunt sapiente inventore quis necessitatibus reiciendis fugit dolores dignissimos ullam corporis cumque ut, veritatis eaque alias laborum maiores, quidem mollitia. Fugit inventore quas deserunt minima? Ut non nam, saepe, reprehenderit similique at sequi optio ducimus dignissimos iste vel!</p>
            <button class="hero__button">Read More</button>
        </div>

        <div class="cards">
            <div class="card">
                <h1 class="card__title">Mission</h1>
                <p class="card__body"><?php echo $barangay_config['mission'] ?></p>
            </div>
            <div class="card">
                <h1 class="card__title">Vision</h1>
                <p class="card__body"><?php echo $barangay_config['vision'] ?></p>
            </div>
            <div class="card">
                <h1 class="card__title">Objectives</h1>
                <p class="card__body"><?php echo $barangay_config['objectives'] ?></p>
            </div>
        </div>

        <!-- Resident Population Graph -->
        <div class="graph">
            <h1>Resident Population Graph</h1>
            <div id="piechart" style="width: 900px; height: 500px;"></div>
        </div>

    </main>

    <footer>
        <h1><?php echo $barangayName ?></h1>
        <p class="address"><?php echo $barangay['b_address'] ?></p>
        <p class="contactno">09653889584</p>
    </footer>


    <script src="./assets/js/dropdown.js"></script>

</body>

</html>