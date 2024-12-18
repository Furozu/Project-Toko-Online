<nav class="navbar navbar-expand-lg navbar-light bg-dark sticky fixed-top gap-2">
    <a class="navbar-brand pl-12 text-yellow-400 hover:text-white hover:font-semibold" href="home.php">Toko Online</a>
    <div class="navbar justify-content-between">
        <ul class="navbar-nav mr-auto gap-3">
            <li class="nav-item">
                <a class="nav-link text-yellow-400 hover:text-white hover:font-semibold" href="profil.php">Profile</a>
            </li>

            <?php
            // User Only
            if ($_SESSION['isAdmin'] == 0) {
                echo '<li class="nav-item">
                        <a class="nav-link text-yellow-500 hover:text-white hover:font-semibold" href="userHistory.php">History</a>
                      </li>';
            }
            ?>

            <?php
            // Admin Only
            if ($_SESSION['isAdmin'] == 1) {
            ?>
                <li class="nav-item">
                    <a class="nav-link text-yellow-500 hover:text-white hover:font-semibold" href="adminPage.php">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-yellow-500 hover:text-white hover:font-semibold" href="adminHistory.php">Admin History</a>
                </li>
            <?php
            }
            ?>

        </ul>
    </div>

</nav>