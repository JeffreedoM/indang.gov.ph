<?php
//for db connection
include 'includes/dbh.inc.php';
//Hide contents if the barangay is deactivated.
include 'includes/deactivated.inc.php';
$conn = mysqli_connect("localhost", "root", "", "bmis");

$sql = 'SELECT * FROM barangay_configuration WHERE barangay_id = :barangayId';
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
        <img src="./assets/images/<?php echo $municipality_logo ?>" alt="Logo of Indang" class="indang-logo">
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
            <!-- <li class="nav-item"><a href="announcement.php">Announcement</a></li> -->
            <li class="nav-item"><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <main>
        <div class="hero">
            <h1 class="hero__title"><?php echo $barangayName ?></h1>
            <p class="hero__p"><?php echo $barangay_config['history'] ?></p>
            <button class="hero__button">
                <a href="history.php" target="_blank">Read More</a>
            </button>
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

        <!-- ANNOUNCEMENT SECTION -->
       
        <!-- <div clas="announcement-head">
            <br>
            <h1 class="text-3xl font-bold text-center">
                <i class="fa-solid fa-bullhorn"></i> Latest Updates
            </h1>
            <div class="flex items-center justify-center">
                <h2 class="text-2xl font-bold text-center">&#160 &#160 as of &#160</h2>
                <h2 id="currentDate" class="text-2xl font-bold text-center"> </h2>
            </div>
            <br>
        </div> -->
     <?php
    //     $headersql = "SELECT * FROM announcement a 
    //                             INNER JOIN barangay b 
    //                             ON a.brgy_id = b.b_id 
    //                             WHERE b.b_id = $barangayId DESC ";
       
    //    $resultheader = $conn->query($headersql);
    //    if ( $resultheader &&  $resultheader->num_rows > 0) {
    //    while ($rowheader = $resultheader->fetch_assoc()) {
       
    //         }       
    //     }
                                ?> 
         

        <div class="main-announcement-container" >
          
                <div class="section-main-annoucement" style="background-color: #eaefdf;  padding: 20px 20px 20px 20px;">
                    <div class="header-text"  >
                        <div class="sub-header1">
                            <h1>Latest News and Updates</h1>
                            <marquee></marquee>
                            <label for="header"> Stay Informed with the Latest News and Updates of <?php echo $barangayName ?> </label>
                        </div>
                        <div class="sub-header2">
                        <label for="header"> <marquee></marquee></label>
                       </div>
                    </div>
                </div>

                <?php 
                    // Define the SQL query
                    $carouselSql = "SELECT announcement_photo FROM announcement    
                    WHERE brgy_id = $barangayId ORDER BY created_at DESC LIMIT 3";

                    // Execute the query
                    $resultcarousel = $conn->query($carouselSql);

                    // Create an array to store the image URLs
                    $carouselImages = array();

                    // Check if the query was successful and fetch the rows
                    if ($resultcarousel && $resultcarousel->num_rows > 0) {
                        while ($rowcarousel = $resultcarousel->fetch_assoc()) {
                            $carouselImages[] = $rowcarousel['announcement_photo'];
                        }
                    } 
                ?>
                <div class="carousel-container" style = "padding-top:20px;" >
                <div class="carousel-track">
                    <?php foreach ($carouselImages as $image): ?>
                    <div class="carousel-slide">
                        <img src="admin/announcement/uploads/<?php echo $image ?>" alt="Image" style="display: block;
    margin-left: auto;
    margin-right: auto;  width: 1000px; height: 40%; object-fit:contain;">
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="carousel-nav">
                    <button class="carousel-prev">Previous</button>
                    <button class="carousel-next">Next</button>
                </div>
                </div>

                <?php
                    // Define the SQL query
                    $dislaysql = "SELECT * 
                                FROM announcement a 
                                INNER JOIN barangay b 
                                ON a.brgy_id = b.b_id 
                                WHERE b.b_id = $barangayId 
                                ORDER BY a.created_at DESC 
                                LIMIT 4;";

                    // Execute the query
                    $result = $conn->query($dislaysql);

                    // Check if the query was successful and fetch the rows
                    if ($result && $result->num_rows > 0) {
                        $class_num = 1;
                        $class_names = ['card-header1', 'card-header2', 'card-header3', 'card-header4'];
                        ?>

                        <div class="card-container">
                            <?php
                            while ($row2 = $result->fetch_assoc()) {
                                $class = $class_names[$class_num - 1];
                                ?>

                                <div class="<?php echo $class ?>">
                                    <img src="admin/announcement/uploads/<?php echo $row2['announcement_photo'] ?>" alt="" style = "object-fit:cover; " >
                                    <center>
                                        <h1><?php echo $row2['announcement_what'] ?></h1>
                                    </center>
                                    <div class="sub-header-announcement">
                                    <h5 class="mb-2 text-sm font-bold tracking-tight text-green-950 dark:text-white"><i class="fas fa-question-circle"></i> &#160 What: &#160 <?php echo $row2['announcement_what'] ?></h5>
                                    <h5 class="mb-2 text-sm  font-bold tracking-tight text-green-950 dark:text-white"><i class="fas fa-map-marker-alt"></i> &#160 Where: &#160 <?php echo $row2['announcement_where'] ?></h5>
                                    <h5 class="mb-2 text-sm  font-bold tracking-tight text-green-950 dark:text-white"><i class="fas fa-calendar"></i> &#160 When: &#160 <?php echo $row2['announcement_when'] ?></h5>
                                    <h5 class="mb-2 text-sm  font-bold tracking-tight text-green-950 dark:text-white">&#160 &#160 Additional Details:</h5>
                                    <p class="mb-3 text-xs font-normal text-gray-700 dark:text-gray-400">&#160 &nbsp &nbsp &nbsp &nbsp &nbsp<?php echo $row2['announcement_message'] ?></p>
                                    </div>
                                    
                                </div>

                                <?php
                                $class_num++;
                            }
                            ?>
                        </div>

                        <?php
                    } else {
                        // echo "No (" . $row2 . ") Result.";
                    }
                ?>
        
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

    <!-- JS -->
    <script>
                const track = document.querySelector('.carousel-track');
                const slides = Array.from(track.children);
                const slideWidth = slides[0].getBoundingClientRect().width;

                // Arrange slides horizontally
                slides.forEach((slide, index) => {
                slide.style.left = `${slideWidth * index}px`;
                });

                let currentSlide = 0;
                const nextButton = document.querySelector('.carousel-next');
                const prevButton = document.querySelector('.carousel-prev');

                // Function to move to the selected slide
                const moveToSlide = (track, currentSlide, targetSlide) => {
                track.style.transform = `translateX(-${targetSlide.style.left})`;
                currentSlide.classList.remove('active');
                targetSlide.classList.add('active');
                };

                // Function to handle next button click
                const nextSlide = () => {
                const currentSlideElement = slides[currentSlide];
                let targetSlide;
                
                if (currentSlide === slides.length - 1) {
                    targetSlide = slides[0];
                    currentSlide = 0;
                } else {
                    targetSlide = currentSlideElement.nextElementSibling;
                    currentSlide++;
                }
                
                moveToSlide(track, currentSlideElement, targetSlide);
                };

                // Function to handle previous button click
                const prevSlide = () => {
                const currentSlideElement = slides[currentSlide];
                let targetSlide;
                
                if (currentSlide === 0) {
                    targetSlide = slides[slides.length - 1];
                    currentSlide = slides.length - 1;
                } else {
                    targetSlide = currentSlideElement.previousElementSibling;
                    currentSlide--;
                }
                
                moveToSlide(track, currentSlideElement, targetSlide);
                };

                nextButton.addEventListener('click', nextSlide);
                prevButton.addEventListener('click', prevSlide);

                // Automatic slideshow functionality
                const interval = 3000; // Set the interval time in milliseconds (e.g., 3000 for 3 seconds)

                const startSlideshow = () => {
                setInterval(() => {
                    nextSlide();
                }, interval);
                };

                startSlideshow();
                </script>

    <script src="./assets/js/dropdown.js"></script>

</body>

</html>