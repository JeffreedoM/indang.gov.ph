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
                            <a href="index.php" class="cursor-pointer inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Barangay Announcements
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="announcement_list.php" class="cursor-pointer inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Edit Announcements
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="#" class="cursor-pointer inline-flex p-4 bg-white rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group">
                                Create Announcement
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="page-body">
                <form action="includes/announcement-add.php" method="post" class="index-form" enctype="multipart/form-data">
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
                        <label for="announcement_when" class="font-semibold">Receiver</label>
                        <select id="announcement_receiver" name="announcement_receiver" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" disabled selected>Select Receiver</option>
                            <option value="All Residents">All Residents</option>
                            <option value="All Barangay Officials">All Barangay Officials</option>
                            <option value="All Barangay Officials">All Councilors</option>
                            <option value="Barangay Captain">Barangay Captain</option>
                            <option value="Barangay Secretary">Barangay Secretary</option>
                            <option value="Barangay Treasurer">Barangay Treasurer</option>
                            <option value="Barangay Leaders">Barangay Leaders</option>
                            <option value="Barangay Tanod">Barangay Tanod</option>
                            <option value="Barangay Health Worker">Barangay Health Worker</option>
                            <option value="Committee on Peace and Order">Committee on Peace and Order</option>
                            <option value="Committee on Public Information/Environment">Committee on Public Information/Environment</option>
                            <option value="Committee on Agricultural">Committee on Agricultural</option>
                            <option value="Committee on Health and Sports">Committee on Health and Sports</option>
                            <option value="Committee on Education">Committee on Education</option>
                            <option value="Committee on Budget and Appropriation">Committee on Budget and Appropriation</option>
                            <option value="Committee on Infrastructure">Committee on Infrastructure</option>
                            <option value="Sangguniang Kabataan">Sangguniang Kabataan</option>
                            <option value="Home Owner Association">Home Owner Association</option>
                            <option value="Lupon Tagapamayapa">Lupon Tagapamayapa</option>
                            <option value="Barangay Nutrition Scholars">Barangay Nutrition Scholars</option>
                            <option value="Utility Officers">Utility Officers</option>
                            <option value="Technical Vocational Instructors">Technical Vocational Instructors</option>
                            <option value="Barangay AIDE">Barangay AIDE</option>
                            <option value="Outsider">Outsider</option>
                            <option value="Barangay Chief Tanod">Barangay Chief Tanod</option>
                            <option value="Barangay Deputy Tanod">Barangay Deputy Tanod</option>
                            <option value="BHRAO">BHRAO</option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="announcement_message" class="font-semibold">Announcement Message</label>
                        <textarea name="announcement_message" id="announcement_message" rows="5" class="w-full rounded-lg border-gray-400 p-3"></textarea>
                    </div>
                    <div class="mb-5">
                        <label for="announcement_photo" class="font-semibold">Announcement Image</label required>
                        <input type="file" name="announcement_photo" id="announcement_photo" accept=".jpg, .jpeg, .png" required class="w-full rounded-lg border border-gray-400">
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