<?php
//JOIN 
$sql =  "SELECT *
        FROM accounts a
        JOIN officials o ON a.official_id = o.official_id
        JOIN resident r ON r.resident_id = o.resident_id
        WHERE a.username = :username";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $account_data['username'], PDO::PARAM_STR);
$stmt->execute();
$logged_resident = $stmt->fetch();

$logged_resident_fullname = "$logged_resident[firstname] $logged_resident[middlename] $logged_resident[lastname]";
$logged_resident_id = $logged_resident['resident_id'];
?>
<header>
    <div class="burger-menu">
        <i class="fa-solid fa-bars"></i>
    </div>

    <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName" class="flex items-center text-sm font-medium text-gray-900 rounded hover:text-blue-600 dark:hover:text-blue-500 md:mr-0 dark:focus:ring-gray-700 dark:text-white" type="button">
        <span class="sr-only">Open user menu</span>
        <?php $image = $logged_resident['image'] ? "{$barangayURL}admin/resident/assets/images/uploads/{$logged_resident['image']}" : "{$barangayURL}/assets/images/uploads/no-profile.png"; ?>
        <img class="w-8 h-8 mr-2 rounded-full" src="<?php echo $image ?>" alt="user photo">

        <?php echo $logged_resident_fullname ?>
        <svg class="w-4 h-4 mx-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div style="box-shadow: 0px 3px 21px 0px rgb(0 0 0 / 20%)" id="dropdownAvatarName" class="z-10 hidden bg-white divide-y font-normal divide-gray-100 shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
            <div class="font-semibold"><?php echo $logged_resident['position'] ?></div>
            <!-- <div class="truncate">name@flowbite.com</div> -->
        </div>
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
            <li>
                <a href="<?php echo $barangayURL . 'admin/resident/resident-view.php?id=' . $logged_resident_id ?> " class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
            </li>
            <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Account Settings</a>
            </li>
        </ul>
        <div class="py-2">
            <a href="../../logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
        </div>
    </div>



    <div class="burger-menu2">
        <i class="fa-solid fa-bars"></i>
    </div>
</header>