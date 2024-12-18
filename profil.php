<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}
require_once 'connect.php';
$user_id = $_SESSION['user_id'];
$query = "SELECT username, password, user_telp, email, alamat, isAdmin FROM Users WHERE user_id = ?";
$stmt = $mysqli->prepare($query);
if (!$stmt) {
    die("Failed to prepare statement: " . $mysqli->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
// Get the result
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
if (!$user_data) {
    die("User not found.");
}
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php'); // Redirect after logout
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Toko Online</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark sticky fixed-top gap-2">
        <a class="navbar-brand pl-12 text-yellow-400 hover:text-white hover:font-semibold" href="home.php">Toko Online</a>
        <div class="navbar justify-content-between">
            <ul class="navbar-nav mr-auto gap-3">
                <li class="nav-item">
                    <a class="nav-link text-yellow-400 hover:text-white hover:font-semibold" href="profil.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-yellow-500 hover:text-white hover:font-semibold" href="userHistory.php">History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-yellow-500 hover:text-white hover:font-semibold" href="adminPage.php">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-yellow-500 hover:text-white hover:font-semibold" href="adminHistory.php">Admin History</a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="container py-5">
        <h1 class="text-center text-2xl font-bold mb-4 text-gray-800">Profil Pengguna</h1>
        <div class="card p-4 shadow">
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div><strong>Username:</strong> <?php echo htmlspecialchars($user_data['username']); ?></div>
                <a href="edit.php?field=username" class="btn btn-outline-primary btn-sm">Edit</a>
            </div>
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div><strong>Password:</strong> <?php echo htmlspecialchars($user_data['password']); ?></div>
                <a href="edit.php?field=password" class="btn btn-outline-primary btn-sm">Edit</a>
            </div>
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div><strong>Nomor Telepon:</strong> <?php echo htmlspecialchars($user_data['user_telp']); ?></div>
                <a href="edit.php?field=user_telp" class="btn btn-outline-primary btn-sm">Edit</a>
            </div>
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></div>
                <a href="edit.php?field=email" class="btn btn-outline-primary btn-sm">Edit</a>
            </div>
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div><strong>Alamat:</strong> <?php echo htmlspecialchars($user_data['alamat']); ?></div>
                <a href="edit.php?field=alamat" class="btn btn-outline-primary btn-sm">Edit</a>
            </div>

            <form method="POST" class="text-center mt-4">
                <button type="submit" name="logout" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </section>
</body>

</html>

