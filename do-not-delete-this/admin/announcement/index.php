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
              <a onclick="redirectToIndexAnnouncement()" class="cursor-pointer inline-flex p-4 bg-white rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group">
                Create Homepage Announcement
              </a>
            </li>
            <li class="mr-2">
              <a onclick="redirectToAnnouncementList()" class="cursor-pointer inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                Announcement List
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="page-body">
        <form action="submit_announcement.php" method="post" class="index-form" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="announcement_title" class="font-semibold">Announcement Title</label>
            <input type="text" name="announcement_title" id="announcement_title" required class="w-full rounded-lg border-gray-400">
          </div>
          <div class="mb-5">
            <label for="announcement_what" class="font-semibold">What</label>
            <input type="text" name="announcement_what" id="announcement_what" class="w-full rounded-lg border-gray-400">
          </div>
          <div class="mb-5">
            <label for="announcement_where" class="font-semibold">Where</label>
            <input type="text" name="announcement_where" id="announcement_where" class="w-full rounded-lg border-gray-400">
          </div>
          <div class="mb-5">
            <label for="announcement_when" class="font-semibold">When</label>
            <input type="date" name="announcement_when" id="announcement_when" class="w-full rounded-lg border-gray-400">
          </div>
          <div class="mb-5">
            <label for="announcement_message" class="font-semibold">Announcement Message</label>
            <textarea name="announcement_message" id="announcement_message" rows="5" class="w-full rounded-lg border-gray-400 p-3"></textarea>
          </div>
          <div class="mb-5">
            <label for="announcement_photo" class="font-semibold">Announcement Image</label required>
            <input type="file" name="announcement_photo" id="announcement_photo" accept="image/*" required class="w-full rounded-lg border border-gray-400">
          </div>
          <button type="submit" class="bg-blue-600 px-5 py-4 rounded-lg text-white hover:bg-blue-700 w-full md:w-auto">Create Announcement</button>
        </form>
      </div>

    </div>

  </main>
  <script src="modalscript.js"></script>
  <script src="../../assets/js/sidebar.js"></script>
  <script src="../../assets/js/header.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
  <script>
    function redirectToIndexAnnouncement() {
      window.location.href = "index.php";
    }

    function redirectToAnnouncementList() {
      window.location.href = "announcement_list.php";
    }
  </script>

</body>

</html>