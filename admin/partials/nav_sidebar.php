<nav class="sidebar">
    <div class="sidebar__logo">
        <!-- The logo and name of brgy should be backend-->
        <div class="logo-img">
            <img src="./assets/images/logo.jpg" alt="Logo of Indang" width="50px" />
        </div>

        <?php $municipality = $pdo->query("SELECT municipality_name FROM superadmin_config")->fetch(); ?>
        <h1 class="barangay-name">Municipality of <?php echo $municipality['municipality_name'] ?></h1>
    </div>
    <ul class="sidebar__links">
        <li>
            <p>Main</p>
        </li>
        <li>
            <a href="index.php">
                <span class="sidebar__links-icon"><i class="fa-sharp fa-solid fa-chart-line"></i></span>
                <span class="sidebar__links-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="barangay-add.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-folder-plus"></i></span>
                <span class="sidebar__links-text">Add Barangay</span>
            </a>
        </li>
        <li>
            <a href="barangay.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-list-ol"></i></span>
                <span class="sidebar__links-text">List of Barangays</span>
            </a>
        </li>
        <li>
            <a href="barangay.php">
                <span class="sidebar__links-icon"><i class="fa-solid fa-sliders"></i></span>
                <span class="sidebar__links-text">Configuration Settings</span>
            </a>
        </li>
    </ul>
</nav>