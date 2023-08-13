<nav class="sidebar">
    <a class="sidebar__logo" href="<?php echo $barangayURL ?>" target="_blank" title="Visit Link">
        <!-- The logo and name of brgy should be backend-->
        <div>
            <div class="logo-img">
                <img src="<?php echo $provinceURL ?>admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>" alt="Logo of Indang" />
            </div>
        </div>
        <h1 class="barangay-name font-semibold"><?php echo $barangayName ?></h1>
    </a>

    <ul class="sidebar__links">
        <li>
            <p>Main</p>
        </li>
        <li>
            <a href="<?php echo $barangayURL ?>admin/dashboard/index.php">
                <span class="sidebar__links-icon"><i class="fa-sharp fa-solid fa-chart-line"></i></span>
                <span class="sidebar__links-text">Dashboard</span>
            </a>
        </li>
        <?php
        $accountId = $account_data['account_id'];
        $query = "SELECT * FROM accounts
          JOIN officials ON accounts.official_id = officials.official_id
          WHERE account_id = :accountId";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':accountId', $accountId);
        $statement->execute();
        // Fetch the data of the logged in user
        $loggedInUser = $statement->fetchAll();
        // Get the allowed module access of the current logged in user
        $allowed_modules = json_decode($loggedInUser[0]['allowed_modules']);
        // To know if the current logged in user is Secretary
        $sec = $loggedInUser[0]['position'] === 'Barangay Secretary';

        if ($sec) {
            $allowed_modules = [];
        }
        ?>
        <li <?php echo (in_array("resident", $allowed_modules) && !$sec) || $sec ? '' : 'style="display:none;"' ?>>
            <a href="<?php echo $barangayURL ?>admin/resident/resident-profiling.php">
                <span class="sidebar__links-icon">
                    <i class="fa-regular fa-id-card"></i></span>
                <p class="sidebar__links-text">Resident Profile</p>
            </a>
        </li>
        <li <?php echo (in_array("officials", $allowed_modules) && !$sec) || $sec ? '' : 'style="display:none;"' ?>>
            <a href="<?php echo $barangayURL ?>admin/officials/officials.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-people-group"></i></span>
                <p class="sidebar__links-text">Brgy. Officials</p>
            </a>
        </li>
        <li <?php echo (in_array("peace_and_order", $allowed_modules) && !$sec) || $sec ? '' : 'style="display:none;"' ?>>
            <a href="<?php echo $barangayURL ?>admin/peace_and_order/list_incident.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-user-shield"></i></span>
                <p class="sidebar__links-text">Peace and Order</p>
            </a>
        </li>
        <!-- <li>
            <a href="<?php echo $barangayURL ?>admin/health_and_sanitation/index.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-pills"></i></span>
                <p class="sidebar__links-text">Health and Sanitation</p>
            </a>
        </li> -->
        <li class="sidebar__links-submenu" <?php echo (in_array("health_and_sanitation", $allowed_modules) && !$sec) || $sec  ? '' : 'style="display:none;"' ?>>
            <a href="#dropdown" class="dropdown-button">
                <span class="sidebar__links-icon"><i class="fa-solid fa-sliders"></i></span>
                <span class="sidebar__links-text">Health Sanitation</span>
                <span class="dropdown-arrow"><i class="fa-solid fa-caret-down"></i></span>
            </a>
            <ul class="sub-menu">
                <li class="sub-menu-item">
                    <a href="<?php echo $barangayURL ?>admin/health_and_sanitation/index.php">
                        <i class="fa-solid fa-arrow-right"></i>
                        <p class="sidebar__links-text">Medicine Inventory</p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="<?php echo $barangayURL ?>admin/health_and_sanitation/medicine-distribution.php">
                        <i class="fa-solid fa-arrow-right"></i>
                        <p class="sidebar__links-text">Medicine Distribution</p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="<?php echo $barangayURL ?>admin/health_and_sanitation/vaccination-inventory.php">
                        <i class="fa-solid fa-arrow-right"></i>
                        <p class="sidebar__links-text">Vaccination Inventory</p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="<?php echo $barangayURL ?>admin/health_and_sanitation/vaccination.php">
                        <i class="fa-solid fa-arrow-right"></i>
                        <p class="sidebar__links-text">Vaccination</p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="<?php echo $barangayURL ?>admin/health_and_sanitation/newborn.php">
                        <i class="fa-solid fa-arrow-right"></i>
                        <p class="sidebar__links-text">Newborn</p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="<?php echo $barangayURL ?>admin/health_and_sanitation/pregnant.php">
                        <i class="fa-solid fa-arrow-right"></i>
                        <p class="sidebar__links-text">Pregnant</p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="<?php echo $barangayURL ?>admin/health_and_sanitation/death.php">
                        <i class="fa-solid fa-arrow-right"></i>
                        <p class="sidebar__links-text">Death</p>
                    </a>
                </li>
            </ul>
        </li>
        <li <?php echo (in_array("finance", $allowed_modules) && !$sec) || $sec ? '' : 'style="display:none;"' ?>>
            <a href="<?php echo $barangayURL ?>admin/finance/index.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-hand-holding-dollar"></i></span>
                <p class="sidebar__links-text">Finance</p>
            </a>
        </li>
        <li <?php echo (in_array("clearance_and_forms", $allowed_modules) && !$sec) || $sec ? '' : 'style="display:none;"' ?>>
            <a href="<?php echo $barangayURL ?>admin/clearance_and_forms/index.php">
                <span class="sidebar__links-icon"><i class="fa-brands fa-wpforms"></i></span>
                <p class="sidebar__links-text">Clearances and Forms</p>
            </a>
        </li>
        <li <?php echo (in_array("reports", $allowed_modules) && !$sec) || $sec ? '' : 'style="display:none;"' ?>>
            <a href="<?php echo $barangayURL ?>admin/reports/index.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-clipboard-list"></i></span>
                <p class="sidebar__links-text">Report</p>
            </a>
        </li>
        <li <?php echo (in_array("special_projects", $allowed_modules) && !$sec) || $sec ? '' : 'style="display:none;"' ?>>
            <a href="<?php echo $barangayURL ?>admin/special_projects/index.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-list-check"></i></span>
                <p class="sidebar__links-text">Special Projects</p>
            </a>
        </li>
        <li <?php echo (in_array("announcement", $allowed_modules) && !$sec) || $sec ? '' : 'style="display:none;"' ?>>
            <a href="<?php echo $barangayURL ?>admin/announcement/index.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-bullhorn"></i></span>
                <p class="sidebar__links-text">Announcement</p>
            </a>
        </li>
        <!-- <li class="sidebar__links-submenu" <?php echo (in_array("announcement", $allowed_modules) && !$sec) || $sec  ? '' : 'style="display:none;"' ?>>
            <a href="#dropdown" class="dropdown-button">
                <span class="sidebar__links-icon"><i class="fa-solid fa-sliders"></i></span>
                <span class="sidebar__links-text">Announcement</span>
                <span class="dropdown-arrow"><i class="fa-solid fa-caret-down"></i></span>
            </a>
            <ul class="sub-menu">
                <li class="sub-menu-item">
                    <a href="<?php echo $barangayURL ?>admin/announcement/index.php">
                        <i class="fa-solid fa-arrow-right"></i>
                        <p class="sidebar__links-text">Homepage Announcement</p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="<?php echo $barangayURL ?>admin/health_and_sanitation/index.php">
                        <i class="fa-solid fa-arrow-right"></i>
                        <p class="sidebar__links-text">Barangay Officials Announcement</p>
                    </a>
                </li>
            </ul>
        </li> -->
        <!-- <li class="sidebar__links-submenu">
            <a href="#dropdown" class="dropdown-button">
                <span class="sidebar__links-icon"><i class="fa-solid fa-sliders"></i></span>
                <span class="sidebar__links-text">Sample Dropdown</span>
                <span class="dropdown-arrow"><i class="fa-solid fa-caret-down"></i></span>
            </a>
            <ul class="sub-menu">
                <li class="sub-menu-item">
                    <a href="#">
                        <i class="fa-solid fa-arrow-right"></i>
                        <p class="sidebar__links-text">Change me 1</p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#">
                        <i class="fa-solid fa-arrow-right"></i>
                        <p class="sidebar__links-text">Change me 2</p>
                    </a>
                </li>
            </ul>
        </li> -->
        <li <?php echo (in_array("announcement", $allowed_modules) && !$sec) || $sec ? '' : 'style="display:none;"' ?>>
            <a href="<?php echo $barangayURL ?>admin/account/index.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-users-gear"></i></span>
                <p class="sidebar__links-text">Account</p>
            </a>
        </li>
        <li <?php echo (in_array("announcement", $allowed_modules) && !$sec) || $sec ? '' : 'style="display:none;"' ?>>
            <a href="<?php echo $barangayURL ?>admin/site_configuration/change-logo.php" id="dropdown-button">
                <span class="sidebar__links-icon"><i class="fa-solid fa-sliders"></i></span>
                <span class="sidebar__links-text">Site Configuration</span>
            </a>
        </li>
    </ul>
</nav>