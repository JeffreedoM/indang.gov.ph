<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../../assets/css/main.css" />
  <link rel="icon" type="image/x-icon" href="../../../admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>">
  <title>Admin Panel | Announcement</title>

</head>

<body>
  <?php
  include '../../partials/nav_sidebar.php';
  ?>

  <main class="main-content">
    <?php
    include '../../partials/nav_header.php';

    /* If logged_resident_position is Secretary, display all announcements */
    if ($logged_resident_position == "Barangay Secretary") {
      $sql = "SELECT * FROM announcement WHERE brgy_id = $barangayId";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $announcements = $stmt->fetchAll();
    } else {
      /* Announcement for the current logged in official */
      $sql = "SELECT * FROM announcement WHERE receiver = :logged_resident_position AND brgy_id = $barangayId";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':logged_resident_position', $logged_resident_position, PDO::PARAM_STR);
      $stmt->execute();
      $position_announcements = $stmt->fetchAll();

      // Announcement for all officials
      $sql = "SELECT * FROM announcement WHERE receiver IN (:all_officials, :all_residents) AND brgy_id = $barangayId";
      $stmt = $pdo->prepare($sql);
      $all_officials = 'All Barangay Officials';
      $all_residents = 'All Residents';
      $stmt->bindParam(':all_officials', $all_officials, PDO::PARAM_STR);
      $stmt->bindParam(':all_residents', $all_residents, PDO::PARAM_STR);
      $stmt->execute();
      $all_announcements = $stmt->fetchAll();

      // Announcement for all Committees
      // Check if $logged_resident_position contains "Committee"
      if (strpos($logged_resident_position, "Committee") !== false) {
        // The position contains 'Committee', so select announcements where the receiver includes "Committee"
        $sql = "SELECT * FROM announcement WHERE receiver = 'All Councilors' AND brgy_id = $barangayId";
      } else {
        // The position does not contain 'Committee', so select announcements for other cases (if needed)
        $sql = "SELECT * FROM announcement WHERE 1 = 0"; // Empty query for demonstration
      }
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $committee_announcements = $stmt->fetchAll();

      $announcements = array_merge($all_announcements, $position_announcements, $committee_announcements);
    }
    ?>

    <!-- Container -->
    <div class="wrapper">
      <!-- Page header -->
      <!-- This is where the title of the page is shown -->
      <div class="page-header" style="margin: 0 !important;">
        <h3 class="page-title m-4">Announcement</h3>

        <!-- page tabs -->
        <div class="border-gray-200 dark:border-gray-700">
          <ul class="flex flex-wrap -mb-px text-sm font-medium text-center dark:text-gray-400">
            <li class="mr-2">
              <a href="#" class="cursor-pointer inline-flex p-4 bg-white rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group">
                Barangay Announcements
              </a>
            </li>
            <li class="mr-2" <?php echo (in_array("announcement", $allowed_modules) && !$sec) || $sec ? '' : 'style="display:none;"' ?>>
              <a href="announcement_list.php" class="cursor-pointer inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                Edit Announcements
              </a>
            </li>
            <li class="mr-2" <?php echo (in_array("announcement", $allowed_modules) && !$sec) || $sec ? '' : 'style="display:none;"' ?>>
              <a href="announcement_create.php" class="cursor-pointer inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                Create Announcement
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="page-body">
        <div class="flex gap-6 flex-wrap justify-center">
          <?php foreach ($announcements as $announcement) : ?>
            <div class="max-w-sm shadow-xl px-5 py-8">
              <div class="w-full relative">
                <img src="uploads/<?php echo $announcement['announcement_photo'] ?>" alt="Announcement Image" class="relative w-96 h-80 object-cover mx-auto rounded-md mb-4">
                <!-- <span class="star-icon absolute bottom-2 right-2 text-2xl cursor-pointer text-white" data-announcement-id="<?php echo $announcement['announcement_id']; ?>">
                  <i class="fa-regular fa-star fas drop-shadow-lg text-2xl <?php echo $announcement['is_highlighted'] ? 'text-yellow-300' : 'text-white'; ?>"></i>
                </span> -->
              </div>
              <div class="">
                <h1 class=" font-semibold text-xl mb-5"><?php echo $announcement['announcement_title'] ?></h1>
                <p class="mb-4">
                  <span class="font-semibold block w-10">Receiver: </span>
                  <span class="block text-sm p-3 bg-gray-100 w-full">
                    <?php echo $announcement['receiver'] ?>
                  </span>
                </p>
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
                <!-- <a href="announcement_update.php?announcement_id=<?php echo $announcement['announcement_id'] ?>" class="block w-full text-white text-center rounded-lg  bg-blue-700 px-5 py-3 hover:bg-blue-800">Update</a>
                <a href="includes/announcement-delete.inc.php?announcement_id=<?php echo $announcement['announcement_id'] ?>" onclick="return confirm('Are you sure you want to delete this announcement?')" class="block w-full text-white text-center rounded-lg  bg-red-700 px-5 py-3 mt-1 hover:bg-red-800">Delete</a> -->

              </div>
            </div>
          <?php endforeach ?>
          <p><?php echo empty($announcements) ? 'No Announcements Found.' : ''; ?></p>
        </div>
      </div>

    </div>

  </main>
  <script src="modalscript.js"></script>
  <script src="../../assets/js/sidebar.js"></script>
  <script src="../../assets/js/header.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>

</body>

</html>