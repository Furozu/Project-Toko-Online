<nav class="navbar navbar-expand-lg navbar-light bg-dark sticky fixed-top gap-2">
    <a class="navbar-brand pl-12 text-yellow-400 hover:text-white hover:font-semibold" href="home.php">Toko Online</a>
    <div class="navbar justify-content-between">
        <ul class="navbar-nav mr-auto gap-3">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link text-yellow-400 hover:text-white hover:font-semibold" href="profil.php">Profile</a>
                </li>
                <?php if ($_SESSION['isAdmin'] == 0): ?>
                    <li class="nav-item">
                        <a class="nav-link text-yellow-500 hover:text-white hover:font-semibold" href="userHistory.php">History</a>
                    </li>
                <?php elseif ($_SESSION['isAdmin'] == 1): ?>
                    <li class="nav-item">
                        <a class="nav-link text-yellow-500 hover:text-white hover:font-semibold" href="adminPage.php">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-yellow-500 hover:text-white hover:font-semibold" href="adminHistory.php">Admin History</a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
    </div>
    <?php
    if (isset($_SESSION['user_id'])) {
        echo '<form method="POST" class="d-inline ml-auto mr-14">
                <button type="submit" name="logout" class="btn btn-danger font-semibold px-5 py-2 rounded-lg text-sm text-white">Logout</button>
              </form>';
    }
    ?>
</nav>

<?php
// Handle logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
?>