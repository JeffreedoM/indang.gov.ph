<?php
//for db connection
include 'includes/dbh.inc.php';
//Hide contents if the barangay is deactivated.
include 'includes/deactivated.inc.php';

$sql = 'SELECT * FROM barangay_configuration WHERE barangay_id = :barangayId';
$stmt = $pdo->prepare($sql);
$stmt->execute(['barangayId' => $barangayId]);
$barangay_config = $stmt->fetch();

/* getting all announcements in specific barangay */
$sql = "SELECT * FROM announcement WHERE brgy_id = :barangayId AND is_highlighted = 1 ORDER BY created_at";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':barangayId', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$announcements = $stmt->fetchAll();

/* getting all recent announcements in specific barangay */
$sql = "SELECT * FROM announcement WHERE brgy_id = :barangayId ORDER BY created_at DESC LIMIT 4";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':barangayId', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$recent_announcements = $stmt->fetchAll();


/* Classification */
$total_residents = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM resident WHERE barangay_id = $barangayId")->fetchColumn();
$infant = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM resident WHERE age >= 0 AND age <= 1")->fetchColumn();
$children = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM resident WHERE barangay_id = $barangayId AND age >= 2 AND age <= 12")->fetchColumn();
$teens = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM resident WHERE barangay_id = $barangayId AND age >= 13 AND age <= 17")->fetchColumn();
$adult = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM resident WHERE barangay_id = $barangayId AND age >= 18 AND age <= 59")->fetchColumn();
$senior = $pdo->query("SELECT COALESCE(COUNT(*), 0) FROM resident WHERE barangay_id = $barangayId AND age >= 60 ")->fetchColumn();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/homepage.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css" rel="stylesheet" />

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
                ['Resident Population', 'Total Numbers'],
                ['Infant', <?php echo $infant ?>],
                ['Children', <?php echo $children ?>],
                ['Teens', <?php echo $teens ?>],
                ['Adult', <?php echo $adult ?>],
                ['Senior Citizen', <?php echo $senior ?>]
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


        <!-- Announcement Section -->
        <section class="block shadow-sm pb-5 bg-white" id="announcement">
            <div class="w-full max-w-[1450px] mx-auto md:flex gap-[5%]">

                <?php foreach ($announcements as $announcement) : ?>
                <?php endforeach ?>
                <div class="w-full md:w-1/2 bg-slate-500 p-8 rounded-md h-max">
                    <?php if (count($announcements) === 1) : ?>
                        <!-- Display the image directly without the carousel if there's only one image -->
                        <div class="relative h-56 overflow-hidden rounded-lg md:h-[70vh]">
                            <img src="admin/announcement/uploads/<?php echo $announcement['announcement_photo'] ?>" class="rounded-lg block w-full" alt="...">
                            <div class="absolute bg-black opacity-60 p-5 z-50 bottom-20 left-10 right-10">
                                <span class="  text-white line-clamp-2"><?php echo $announcement['announcement_message'] ?></span>
                                <!-- Modal toggle -->
                                <p data-modal-target="<?php echo $announcement['announcement_id'] ?>" data-modal-toggle="<?php echo $announcement['announcement_id'] ?>" class="block cursor-pointer underline underline-offset-4 text-white">
                                    See more...
                                </p>
                            </div>
                        </div>
                    <?php else : ?>

                        <div id="default-carousel" class="relative max-w-2xl mx-auto" data-carousel="slide">
                            <!-- Carousel wrapper -->
                            <div class="relative h-56 overflow-hidden rounded-lg md:h-[70vh]">
                                <?php foreach ($announcements as $index => $announcement) : ?>
                                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                        <img src="admin/announcement/uploads/<?php echo $announcement['announcement_photo'] ?>" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                                        <div class="absolute bg-black opacity-60 p-5 z-50 bottom-20 left-10 right-10">
                                            <span class="  text-white line-clamp-2"><?php echo $announcement['announcement_message'] ?></span>
                                        </div>
                                    </div>

                                <?php endforeach ?>
                            </div>
                            <!-- Slider indicators -->
                            <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                                <?php foreach ($announcements as $index => $announcement) : ?>
                                    <button type="button" class="w-3 h-3 rounded-full" aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $index + 1; ?>" data-carousel-slide-to="<?php echo $index; ?>"></button>
                                <?php endforeach ?>
                            </div>
                            <!-- Slider controls -->
                            <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                                    </svg>
                                    <span class="sr-only">Previous</span>
                                </span>
                            </button>
                            <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span class="sr-only">Next</span>
                                </span>
                            </button>
                        </div>
                    <?php endif ?>
                </div>

                <!-- For recent announcements -->

                <div class="w-full md:w-1/2">
                    <h1 class="font-semibold mb-3">Recent Announcements:</h1>
                    <div class=" md:flex flex-wrap gap-5 justify-around">
                        <?php foreach ($recent_announcements as $announcement) : ?>
                            <div class="shadow-xl px-5 py-4 h-max md:w-5/12">
                                <div class="w-full">
                                    <img src="admin/announcement/uploads/<?php echo $announcement['announcement_photo'] ?>" alt="Announcement Image" class="w-full object-cover h-52 mx-auto rounded-md mb-3">
                                </div>
                                <div class="">
                                    <p class="mb-4">
                                        <span class="font-semibold block w-10">What: </span>
                                        <span class="block text-sm p-2 bg-gray-100 w-full">
                                            <?php echo $announcement['announcement_what'] ?>
                                        </span>
                                    </p>
                                    <p class="mb-4">
                                        <span class="font-semibold block w-10">When: </span>
                                        <span class="block text-sm p-2 bg-gray-100 w-full">
                                            <?php echo $announcement['announcement_when'] ?>
                                        </span>
                                    </p>
                                    <p class="mb-4">
                                        <span class="font-semibold block w-10">Where: </span>
                                        <span class="block text-sm p-2 bg-gray-100 w-full">
                                            <?php echo $announcement['announcement_where'] ?>
                                        </span>
                                    </p>
                                    <!-- Modal toggle -->
                                    <p data-modal-target="<?php echo $announcement['announcement_id'] ?>" data-modal-toggle="<?php echo $announcement['announcement_id'] ?>" class="block cursor-pointer underline underline-offset-4 text-blue-600">
                                        See more...
                                    </p>
                                </div>
                            </div>

                            <!-- Modals for announcements -->
                            <!-- Main modal -->
                            <div id="<?php echo $announcement['announcement_id'] ?>" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-full max-w-2xl max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                <?php echo $announcement['announcement_title'] ?>
                                            </h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="<?php echo $announcement['announcement_id'] ?>">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-6 space-y-6">
                                            <div class="w-full">
                                                <img src="admin/announcement/uploads/<?php echo $announcement['announcement_photo'] ?>" alt="Announcement Image" class="w-full object-cover h-72 mx-auto rounded-md mb-3">
                                            </div>
                                            <div class="">
                                                <p class="mb-4">
                                                    <span class="font-semibold block w-10">What: </span>
                                                    <span class="block text-sm p-2 bg-gray-100 w-full">
                                                        <?php echo $announcement['announcement_what'] ?>
                                                    </span>
                                                </p>
                                                <p class="mb-4">
                                                    <span class="font-semibold block w-10">When: </span>
                                                    <span class="block text-sm p-2 bg-gray-100 w-full">
                                                        <?php echo $announcement['announcement_when'] ?>
                                                    </span>
                                                </p>
                                                <p class="mb-4">
                                                    <span class="font-semibold block w-10">Where: </span>
                                                    <span class="block text-sm p-2 bg-gray-100 w-full">
                                                        <?php echo $announcement['announcement_where'] ?>
                                                    </span>
                                                </p>
                                                <p class="mb-4">
                                                    <span class="font-semibold block w-10">Message: </span>
                                                    <span class="block text-sm p-2 bg-gray-100 w-full">
                                                        <?php echo $announcement['announcement_message'] ?>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>



        </section>



    </main>
    <div id="gwt-standard-footer"></div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
    <script type="text/javascript">
        (function(d, s, id) {
            var js, gjs = d.getElementById('gwt-standard-footer');

            js = d.createElement(s);
            js.id = id;
            js.src = "//gwhs.i.gov.ph/gwt-footer/footer.js";
            gjs.parentNode.insertBefore(js, gjs);
        }(document, 'script', 'gwt-footer-jsdk'));
    </script>
    </script>
    <script src="./assets/js/dropdown.js"></script>

</body>

</html>