<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';


$sql = "SELECT * 
            FROM announcement a 
            INNER JOIN barangay b 
            ON a.brgy_id = b.b_id 
            WHERE b.b_id = :barangay_id 
            ORDER BY a.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
$stmt->execute();
$announcements = $stmt->fetchAll();

if (isset($_GET['search']) && !empty($_GET['search'])) {
    // Get the search term from the URL and sanitize it
    $searchTerm = htmlspecialchars($_GET['search']);

    $sql = "SELECT * FROM announcement WHERE announcement_title LIKE :search_term OR receiver LIKE :receiver AND brgy_id = :barangay_id ORDER BY created_at DESC";

    // Prepare the SQL statement with the search condition
    $stmt = $pdo->prepare($sql);

    // Bind the parameter values for the :search_term and :barangay_id placeholders
    $params = array(
        ':search_term' => '%' . $searchTerm . '%',
        ':receiver' => '%' . $searchTerm . '%',
        ':barangay_id' => $barangayId // Assuming $barangayId contains the appropriate value
    );

    // Execute the statement with the parameter array
    $stmt->execute($params);

    // Fetch all the rows as an associative array
    $announcementSearch = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $searchCount = count($announcementSearch);

    $announcements = $announcementSearch;
}

if (isset($_GET['filter_announcement'])) {
    unset($_GET['search']);
    $filter_announcement = $_GET['filter_announcement'];

    switch ($filter_announcement) {
        case 'All Residents':
            $sql = "SELECT * FROM announcement WHERE brgy_id = :barangay_id ORDER BY created_at DESC";
            break;
        case 'All Officials':
            $sql = "SELECT * FROM announcement WHERE receiver = 'All Officials' AND brgy_id = :barangay_id ORDER BY created_at DESC";
            break;
        case 'All Committee':
            $sql = "SELECT * FROM announcement WHERE receiver = 'All Councilors' AND brgy_id = :barangay_id ORDER BY created_at DESC";
            break;
        case 'Highlighted Only':
            $sql = "SELECT * FROM announcement WHERE is_highlighted = 1 AND brgy_id = :barangay_id ORDER BY created_at DESC";
            break;

        default:
            # code...
            break;
    }
    // Prepare the SQL statement with the search condition
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':barangay_id', $barangayId, PDO::PARAM_INT);
    $stmt->execute();
    $announcements = $stmt->fetchAll();
}
if (isset($_POST['clear'])) {
    header('Location: announcement_list.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/main.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link rel="stylesheet" href="announcement.css" /> -->
    <link rel="icon" type="image/x-icon" href="../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
    <title>Admin Panel | Announcement</title>

    <style>
        .fa-star {
            text-shadow: -1px 0 #000, 0 1px #000, 1px 0 #000, 0 -1px #000;
        }
    </style>
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
        <div class="wrapper">
            <!-- Page header -->
            <!-- This is where the title of the page is shown -->
            <div class="page-header" style="margin: 0 !important;">
                <h3 class="page-title ml-4 mb-4">Announcement</h3>

                <!-- page tabs -->
                <div class="border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center dark:text-gray-400">
                        <li class="mr-2">
                            <a href="index.php" class="cursor-pointer inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Barangay Announcements
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="#" class="cursor-pointer inline-flex p-4 bg-white rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group">
                                Edit Announcements
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="announcement_create.php" class="cursor-pointer inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Create Announcement
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- navigation menu -->

            <div class="page-body">
                <div class="flex justify-between">
                    <!-- Search Form -->
                    <form action="" method="GET" class="mb-4">
                        <input type="text" name="search" placeholder="Search by title or receiver" class="border rounded-md">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Search</button>
                    </form>
                    <!-- <form action="" method="POST" onsubmit="removeSearchParam()">
                        <?php if (!isset($_POST['highlight'])) : ?>
                            <button type="submit" name="highlight" class=" bg-blue-500 text-white px-4 py-2 rounded-md ml-2">
                                Show Highlighted Only
                            </button>
                        <?php else : ?>
                            <button type="submit" name="clear" class=" bg-blue-500 text-white px-4 py-2 rounded-md ml-2">
                                Show All
                            </button>
                        <?php endif ?>
                    </form> -->
                    <form action="" method="GET">
                        <select name="filter_announcement" class="bg-gray-50 px-4 py-2 rounded-md shadow">
                            <?php
                            $selectedValue = isset($_GET['filter_announcement']) ? $_GET['filter_announcement'] : '';

                            // Define the options
                            $options = array(
                                "Show All" => "Show All",
                                "All Residents" => "All Residents",
                                "All Officials" => "All Officials",
                                "All Committee" => "All Committee",
                                "Highlighted Only" => "Highlighted Only"
                            );

                            // Output the "Show All" or "Filter Announcements" option based on the condition
                            $defaultOptionValue = "";
                            $defaultOptionLabel = "Filter Announcements";

                            if (isset($_GET['filter_announcement'])) {
                                $defaultOptionValue = $_GET['filter_announcement'];
                                $defaultOptionLabel = $_GET['filter_announcement'];
                            }

                            echo "<option value=\"$defaultOptionValue\" disabled selected>$defaultOptionLabel</option>";

                            // Output the remaining options using a foreach loop
                            foreach ($options as $value => $label) {
                                // Skip the "Show All" or "Filter Announcements" option since it's already output
                                if ($value === $defaultOptionValue) continue;

                                echo "<option value=\"$value\" " . ($selectedValue === $value ? "selected" : "") . ">$label</option>";
                            }
                            ?>
                        </select>



                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Filter</button>
                    </form>


                </div>
                <form action="" method="POST">
                    <button type="submit" name="clear" class="mb-3 bg-blue-500 text-white px-4 py-2 rounded-md">Clear Searches</button>
                </form>
                <?php
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    // Check if search has no results
                    if (empty($announcementSearch)) {
                        echo "No announcements found for the search term: \"$searchTerm\"";
                    } else {
                        echo "$searchCount result(s) for the search term: \"$searchTerm\"";
                    }
                } ?>

                <div class="flex gap-6 flex-wrap justify-center">
                    <?php foreach ($announcements as $announcement) : ?>
                        <div class="max-w-sm shadow-xl px-5 py-8">
                            <div class="w-full relative">
                                <img src="uploads/<?php echo $announcement['announcement_photo'] ?>" alt="Announcement Image" class="relative w-96 h-80 object-cover mx-auto rounded-md mb-4">
                                <span class="star-icon absolute bottom-2 right-2 text-2xl cursor-pointer text-white" data-announcement-id="<?php echo $announcement['announcement_id']; ?>">
                                    <i class="fa-regular fa-star fas drop-shadow-lg text-2xl <?php echo $announcement['is_highlighted'] ? 'text-yellow-300' : 'text-white'; ?>"></i>
                                </span>
                            </div>
                            <div class="flex flex-col justify-between">
                                <div>
                                    <h1 class=" font-semibold text-xl mb-5"><?php echo $announcement['announcement_title'] ?></h1>
                                    <p class="mb-4">
                                        <span class="font-semibold block w-10">What: </span>
                                        <span class="block text-sm p-3 bg-gray-100 w-full">
                                            <?php echo $announcement['announcement_what'] ?>
                                        </span>
                                    </p>
                                    <p class="mb-4">
                                        <span class="font-semibold block w-10">When: </span>
                                        <span class="block text-sm p-3 bg-gray-100 w-full">
                                            <?php echo ($announcement['announcement_when'] !== '0000-00-00') ? date('F d, Y', strtotime($announcement['announcement_when'])) : "" ?>
                                        </span>
                                    </p>
                                    <p class="mb-4">
                                        <span class="font-semibold block w-10">Where: </span>
                                        <span class="block text-sm p-3 bg-gray-100 w-full">
                                            <?php echo $announcement['announcement_where'] ?>
                                        </span>
                                    </p>
                                    <p class="mb-4">
                                        <span class="font-semibold block w-10">Message: </span>
                                        <span class="block text-sm p-3 bg-gray-100 w-full">
                                            <?php echo $announcement['announcement_message'] ?>
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <a href="announcement_update.php?announcement_id=<?php echo $announcement['announcement_id'] ?>" class="block w-full text-white text-center rounded-lg  bg-blue-700 px-5 py-3 hover:bg-blue-800">Update</a>
                                    <a href="includes/announcement-delete.inc.php?announcement_id=<?php echo $announcement['announcement_id'] ?>" onclick="return confirm('Are you sure you want to delete this announcement?')" class="block w-full text-white text-center rounded-lg  bg-red-700 px-5 py-3 mt-1 hover:bg-red-800">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    <p><?php echo empty($announcements) ? 'No Announcements Found.' : ''; ?></p>
                </div>

            </div>

        </div>
        <script src="../../assets/js/sidebar.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
        <script>
            function redirectToIndexAnnouncement() {
                window.location.href = "index.php";
            }

            function removeSearchParam() {
                var url = new URL(window.location.href);
                url.searchParams.delete('search');
                window.history.replaceState({}, document.title, url);
            }
        </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- For highglight announcements -->
        <script>
            $(document).ready(function() {
                // Click event handler for the star icon
                $('.star-icon').click(function() {
                    var announcementId = $(this).data('announcement-id');
                    var starIcon = $(this).find('i');


                    $.ajax({
                        url: 'includes/toggle-highlight.inc.php',
                        type: 'POST',
                        data: {
                            announcementId: announcementId
                        },
                        success: function(response) {

                            // Toggle the 'fa-star' and 'fa-star-o' classes for Font Awesome icons
                            starIcon.toggleClass('text-yellow-300');
                        },
                        error: function(xhr, status, error) {
                            // Handle errors if any
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>




</body>

</html>