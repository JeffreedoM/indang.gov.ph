<?php
//for db connection
include 'includes/dbh.inc.php';
//Hide contents if the barangay is deactivated.
include 'includes/deactivated.inc.php';

$sql = 'SELECT history FROM barangay_configuration WHERE barangay_id = :barangayId';
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
    <link rel="stylesheet" href="./assets/css/history.css" />
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
            <li class="nav-item"><a href="index.php">Home</a></li>
            <div class="nav-item active dropdown-btn">About Us
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

    <main class="history">
        <div class="container">
            <h1>Barangay History</h1>
            <?php if (empty($barangay_config['history'])) : ?>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit laboriosam nostrum dolores? Aliquam inventore minima ducimus placeat laborum ad nesciunt atque! Quia dignissimos cupiditate tenetur fugit voluptatum quidem qui, voluptatem necessitatibus facilis natus doloribus tempora quibusdam ipsum eligendi, nulla ipsam. Nobis optio natus dignissimos voluptate iusto perspiciatis ea. Aut, nihil excepturi mollitia dolores amet cumque ullam doloribus accusantium quaerat inventore in odit hic facilis reiciendis sunt ab veniam pariatur. Atque accusantium temporibus voluptatibus nihil, reprehenderit reiciendis corrupti accusamus quaerat inventore dolorem esse suscipit quisquam excepturi rem ab totam cupiditate quis velit, unde cum ipsum sunt sit voluptas. Facere, at aut. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Vel possimus cum numquam laboriosam nihil beatae delectus autem iusto soluta eum.</p>
            <?php else : ?>
                <p><?php echo $barangay_config['history'] ?></p>
            <?php endif; ?>
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