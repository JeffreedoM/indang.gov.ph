<nav class="sidebar">
    <div class="sidebar__logo">
        <!-- The logo and name of brgy should be backend-->
        <div class="logo-img">
            <img src="<?php echo $provinceURL ?>admin/assets/images/uploads/barangay-logos/<?php echo $barangay['b_logo'] ?>" alt="Logo of Indang" width="80px" />
        </div>

        <h1 class="barangay-name font-semibold"><?php echo $barangayName ?></h1>
    </div>
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
        <li>
            <a href="<?php echo $barangayURL ?>admin/resident/resident-profiling.php">
                <span class="sidebar__links-icon">
                    <i class="fa-regular fa-id-card"></i></span>
                <p class="sidebar__links-text">Resident Profile</p>
            </a>
        </li>
        <li>
            <a href="<?php echo $barangayURL ?>admin/officials/officials.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-people-group"></i></span>
                <p class="sidebar__links-text">Brgy. Officials</p>
            </a>
        </li>
        <li>
            <a href="<?php echo $barangayURL ?>admin/peace_and_order/list_incident.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-user-shield"></i></span>
                <p class="sidebar__links-text">Peace and Order</p>
            </a>
        </li>
        <li>
            <a href="<?php echo $barangayURL ?>admin/health_and_sanitation/index.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-pills"></i></span>
                <p class="sidebar__links-text">Health and Sanitation</p>
            </a>
        </li>
        <li>
            <a href="<?php echo $barangayURL ?>admin/finance/index.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-hand-holding-dollar"></i></span>
                <p class="sidebar__links-text">Finance</p>
            </a>
        </li>
        <li>
            <a href="<?php echo $barangayURL ?>admin/clearance_and_forms/index.php">
                <span class="sidebar__links-icon"><i class="fa-brands fa-wpforms"></i></span>
                <p class="sidebar__links-text">Clearances and Forms</p>
            </a>
        </li>
        <li>
            <a href="<?php echo $barangayURL ?>admin/reports/index.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-clipboard-list"></i></span>
                <p class="sidebar__links-text">Report</p>
            </a>
        </li>
        <li>
            <a href="<?php echo $barangayURL ?>admin/special_projects/index.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-list-check"></i></span>
                <p class="sidebar__links-text">Special Projects</p>
            </a>
        </li>
        <li>
            <a href="<?php echo $barangayURL ?>admin/announcement/index.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-bullhorn"></i></span>
                <p class="sidebar__links-text">Announcement</p>
            </a>
        </li>
        <li class="sidebar__links-submenu">
            <a href="<?php echo $barangayURL ?>admin/site_configuration/change-logo.php" id="dropdown-button">
                <span class="sidebar__links-icon"><i class="fa-solid fa-sliders"></i></span>
                <span class="sidebar__links-text">Site Configuration</span>
                <!-- <span class="dropdown-arrow"><i class="fa-solid fa-caret-down"></i></span> -->
            </a>
            <!-- <ul class="sub-menu">
                <li class="sub-menu-item">
                    <a href="#">
                        <i class="fa-solid fa-arrow-right"></i>
                        <p class="sidebar__links-text">Change Logo</p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#">
                        <i class="fa-solid fa-arrow-right"></i>
                        <p class="sidebar__links-text">Mission, Vision, Objectives</p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#">
                        <i class="fa-solid fa-arrow-right"></i>
                        <p class="sidebar__links-text">History</p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#">
                        <i class="fa-solid fa-arrow-right"></i>
                        <p class="sidebar__links-text">Contact</p>
                    </a>
                </li>
            </ul> -->
        </li>
    </ul>
</nav>