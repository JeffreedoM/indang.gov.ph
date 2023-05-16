<?php
//for db connection
include 'includes/dbh.inc.php';
//Hide contents if the barangay is deactivated.
include 'includes/deactivated.inc.php';
$conn = mysqli_connect("localhost", "root", "", "bmis");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/homepage.css" />
    <title><?php echo $barangayName ?></title>
    <link rel="icon" type="image/x-icon" href="../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <li class="nav-item "><a href="index.php">Home</a></li>
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
            <li class="nav-item active"><a href="announcement.php">Announcement</a></li>
            <li class="nav-item"><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <main>
        <!-- Body -->
        <div clas="announcement-head">
            <br>
            <h1 class="text-3xl font-bold text-center">
                <i class="fa-solid fa-bullhorn"></i> &#160 <?php echo $barangayName ?>
            </h1>
            <div class="flex items-center justify-center">
                <h2 class="text-2xl font-bold text-center">&#160 &#160 as of &#160</h2>
                <h2 id="currentDate" class="text-2xl font-bold text-center"> </h2>
            </div>
            <br>
        </div>

        <div class="main-announcement-container">
            <?php
            // Define the SQL query
            $dislaysql = "SELECT * 
                      FROM announcement a 
                      INNER JOIN barangay b 
                      ON a.brgy_id = b.b_id 
                      WHERE b.b_id = $barangayId 
                      ORDER BY a.created_at DESC 
                      LIMIT 1;";

            // Execute the query
            $result2 = $conn->query($dislaysql);

            // Check if the query was successful and fetch the row
            if ($result2 && $result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
            ?>

                <div class="max-w-full  border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mx-auto">
                    <a href="#">
                        <img id="upload" class="rounded-t-lg mx-auto" src="admin/announcement/uploads/<?php echo $row['announcement_photo'] ?>" alt="" style="object-fit: contain; object-position: center center; ">
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5 class="mb-2 text-4xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $row['announcement_title'] ?></h5>
                        </a>
                        <h5 class="mb-2 text-l font-bold tracking-tight text-green-950 dark:text-white"><i class="fas fa-question-circle"></i> &#160 What: &#160 <?php echo $row['announcement_what'] ?></h5>
                        <h5 class="mb-2 text-l font-bold tracking-tight text-green-950 dark:text-white"><i class="fas fa-map-marker-alt"></i> &#160 Where: &#160 <?php echo $row['announcement_where'] ?></h5>
                        <h5 class="mb-2 text-l font-bold tracking-tight text-green-950 dark:text-white"><i class="fas fa-calendar"></i> &#160 When: &#160 <?php echo $row['announcement_when'] ?></h5>
                        <h5 class="mb-2 text-l font-bold tracking-tight text-green-950 dark:text-white">&#160 &#160 Additional Details:</h5>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">&#160 &nbsp &nbsp &nbsp &nbsp &nbsp<?php echo $row['announcement_message'] ?></p>
                    </div>
                </div>



            <?php
            }
            ?>

        </div>

        <hr class="border-t border-gray-500 my-4 w-300">
        <br> <br>
        <div class="main-announcement-container-2">
            <?php
            // Define the SQL query
            $dislaysql = "SELECT * 
                      FROM announcement a 
                      INNER JOIN barangay b 
                      ON a.brgy_id = b.b_id 
                      WHERE b.b_id = $barangayId 
                      ORDER BY a.created_at DESC 
                      LIMIT 1, 3;"; // Fetch 2nd and 3rd announcements

            // Execute the query
            $result = $conn->query($dislaysql);

            // Check if the query was successful and fetch the rows
            if ($result && $result->num_rows > 0) {
            ?>
                <div class="flex justify-center">
                    <?php
                    while ($row2 = $result->fetch_assoc()) {
                    ?>
                        <div class="max-w-xs bg-9cf0f8 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mx-2">
                            <a href="#">
                                <img id="/upload" class="rounded-t-lg mx-300" src="admin/announcement/uploads/<?php echo $row2['announcement_photo'] ?>" alt="ss" style="padding-top: 10px; width: 200px; height: 200px; object-fit: contain; object-position: center center;" />
                            </a>

                        </div>

                        <div class="p-5">
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $row2['announcement_title'] ?></h5>
                            </a>
                            <h5 class="mb-2 text-sm font-bold tracking-tight text-green-950 dark:text-white"><i class="fas fa-question-circle"></i> &#160 What: &#160 <?php echo $row2['announcement_what'] ?></h5>
                            <h5 class="mb-2 text-sm  font-bold tracking-tight text-green-950 dark:text-white"><i class="fas fa-map-marker-alt"></i> &#160 Where: &#160 <?php echo $row2['announcement_where'] ?></h5>
                            <h5 class="mb-2 text-sm  font-bold tracking-tight text-green-950 dark:text-white"><i class="fas fa-calendar"></i> &#160 When: &#160 <?php echo $row2['announcement_when'] ?></h5>
                            <h5 class="mb-2 text-sm  font-bold tracking-tight text-green-950 dark:text-white">&#160 &#160 Additional Details:</h5>
                            <p class="mb-3 text-xs font-normal text-gray-700 dark:text-gray-400">&#160 &nbsp &nbsp &nbsp &nbsp &nbsp<?php echo $row2['announcement_message'] ?></p>
                        </div>
                    <?php
                    }

                    ?>
                </div>

            <?php
            } else {
                echo "No (" . $row2 . ") Result.";
            }
            ?>
        </div>



    </main>
    <div id="gwt-standard-footer"></div>
    <script type="text/javascript">
        (function(d, s, id) {
            var js, gjs = d.getElementById('gwt-standard-footer');

            js = d.createElement(s);
            js.id = id;
            js.src = "//gwhs.i.gov.ph/gwt-footer/footer.js";
            gjs.parentNode.insertBefore(js, gjs);
        }(document, 'script', 'gwt-footer-jsdk'));
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script>
        $(document).ready(function() {
            bsCustomFileInput.init();
        });
    </script>
    <script src="./assets/js/dropdown.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>

    <script>
        var months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        var currentDate = new Date();
        var month = months[currentDate.getMonth()];
        var day = currentDate.getDate();
        var year = currentDate.getFullYear();

        var formattedDate = month + " " + day + ", " + year;

        document.getElementById("currentDate").textContent = formattedDate;
    </script>
</body>

</html>