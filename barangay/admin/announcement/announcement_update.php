<?php
include '../../includes/deactivated.inc.php';
include '../../includes/session.inc.php';

$id = $_GET['announcement_id'];
$sql = "SELECT * FROM announcement WHERE announcement_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
// Fetch the row as an associative array
$announcement = $stmt->fetch();

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
                <h3 class="page-title ml-4 mb-4">Update Announcement</h3>

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
                            <a href="announcement_create.php" class="cursor-pointer inline-flex p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Create Announcement
                            </a>
                        </li>
                        <li class="mr-2">
                            <a href="announcement_update.php" class="cursor-pointer inline-flex p-4 bg-white rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group">
                                Update Announcement
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="page-body">
                <form action="includes/announcement-update.inc.php" method="POST" class="space-y-6" enctype="multipart/form-data">
                    <input type="hidden" name="announcement_id" value="<?php echo $id ?>">
                    <div>
                        <label for="announcement_title" class="font-semibold">Announcement Title</label>
                        <input value="<?php echo $announcement['announcement_title']; ?>" type="text" name="announcement_title" id="announcement_title" required class="w-full rounded-lg border-gray-400">
                    </div>
                    <div>
                        <label for="announcement_what" class="font-semibold">What</label>
                        <input type="text" value="<?php echo $announcement['announcement_what']; ?>" name="announcement_what" id="announcement_what" class="w-full rounded-lg border-gray-400">
                    </div>
                    <div>
                        <label for="announcement_where" class="font-semibold">Where</label>
                        <input type="text" value="<?php echo $announcement['announcement_where']; ?>" name="announcement_where" id="announcement_where" class="w-full rounded-lg border-gray-400">
                    </div>
                    <div>
                        <label for="announcement_when" class="font-semibold">When</label>
                        <input type="date" value="<?php echo $announcement['announcement_when']; ?>" name="announcement_when" id="announcement_when" class="w-full rounded-lg border-gray-400">
                    </div>
                    <div>
                        <label for="announcement_when" class="font-semibold">Receiver</label>
                        <select id="announcement_receiver" name="announcement_receiver" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" disabled>Select Receiver</option>
                            <option value="<?php echo $announcement['receiver']; ?>" selected><?php echo $announcement['receiver']; ?></option>
                            <option value="All Residents">All Residents</option>
                            <option value="All Barangay Officials">All Barangay Officials</option>
                            <option value="All Councilors">All Councilors</option>
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
                    <div>
                        <label for="announcement_message" class="font-semibold">Announcement Message</label>
                        <textarea name="announcement_message" id="announcement_message" rows="5" class="w-full rounded-lg border-gray-400 p-3"><?php echo $announcement['announcement_message']; ?></textarea>
                    </div>
                    <div>
                        <label for="announcement_photo" class="font-semibold">Update Announcement Image</label>
                        <input id="file_input" type="file" name="announcement_photo" class="w-full rounded-lg border border-gray-500" accept=".jpg, .jpeg, .png">
                        <?php if (!empty($announcement['announcement_photo'])) : ?>
                            <img src="uploads/<?php echo $announcement['announcement_photo']; ?>" alt="Uploaded Announcement Image" class="max-w-sm mt-3">
                        <?php endif; ?>
                    </div>

                    <button type="submit" name="update_announcement" class="bg-blue-600 px-5 py-4 rounded-lg text-white hover:bg-blue-700 w-full">Update Announcement</button>
                </form>
            </div>
        </div>
    </main>
    <script src="modalscript.js"></script>
    <script src="ckeditor5/ckeditor.js"></script>
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