<header>
    <div class="burger-menu">
        <i class="fa-solid fa-bars"></i>
    </div>

    <div class="admin">
        <div class="admin__name"><?php echo $user_data['fullname']; ?>
        </div>
        <div class="admin__name-dropdown">
            <a href="account-settings.php" class="dropdown-item">
                Account<i class="fa-solid fa-gear"></i></a>
            <a href="../logout.php" class="dropdown-item">
                Logout<i class="fa-solid fa-right-from-bracket"></i></a>
        </div>

    </div>

    <div class="burger-menu2">
        <i class="fa-solid fa-bars"></i>
    </div>
</header>