<?php
require_once "connect.php";
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- judul yang terdisplay di bar atas -->
    <title>Toko Online</title>

    <!-- Inisialisasi Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Inisialisasi Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <section class="p-10 grid grid-cols-2 gap-10 place-items-center">
        <div>
            <p class="text-9xl font-bold">Toko Online</p>
        </div>

        <div class="size-full">
            <form class="grid grid-rows-4 gap-3" method="post">
                <div>
                    <p class="text-5xl font-bold">Log In</p>
                </div>

                <?php
                $login = 0;
                $isAdmin = 0;

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['name']) && !empty($_POST['pass'])) {

                    $result = $mysqli->query("SELECT user_id,username,password,isAdmin FROM users");
                    // Untuk check semua pasangan username dan password
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                        // check pasangan username dan password
                        if ($_POST['name'] == $row['username'] && $_POST['pass'] == $row['password']) {
                            $login = 1;

                            if ($row['isAdmin'] == '1') {
                                $isAdmin = 1;
                            }
                            break;
                        }
                    }

                    if ($login == 0) {
                        echo '<div class="alert alert-danger">Login Failed</div>';
                    } else if ($isAdmin == 1) {
                        echo '<div class="alert alert-success">Welcome Admin</div>';
                        // header('Location: admin.php');
                    } else if ($login == 1) {
                        echo '<div class="alert alert-success">Login Success</div>';
                        // header('Location: home.php');
                    }
                }
                ?>

                <!-- Login Username -->
                <div class="form-group">
                    <label class="pb-1" for="usernameInput">Username</label>
                    <input class="form-control" name="name" id="usernameInput" placeholder="Enter Username">
                </div>


                <div class="form-group">
                    <label class="pb-1" for="passwordInput">Password</label>
                    <input type="password" class="form-control" name="pass" id="passwordInput" placeholder="Enter Password">
                </div>

                <div>
                    <div>
                        <button type="submit" class="size-full btn btn-primary">LOG IN</button>
                    </div>
            </form>

            <!-- Create new account MODAL -->
            <p class="mt-1">Create <a class="link-underline text-blue-600" href="#" data-bs-toggle="modal" data-bs-target="#createAccountModal">New Account?</a></p>

            <!-- MODAL -->
            <div class="modal fade bd-example-modal-lg" id="createAccountModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">Daftar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Form for creating a new account -->
                            <form method="post">
                                <div class="form-group mb-3">
                                    <label for="newUsername">Username</label>
                                    <input type="text" class="form-control" id="newUsername" name="newUsername" placeholder="Enter Username" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="newPassword">Password</label>
                                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter Password" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="newTelpon">Nomer Telpon</label>
                                    <input type="text" class="form-control" id="newTelpon" name="newTelpon" placeholder="Enter Nomer Telpon" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="newEmail">Email</label>
                                    <input type="email" class="form-control" id="newEmail" name="newEmail" placeholder="Enter Email" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="newAlamat">Alamat</label>
                                    <textarea class="form-control" id="newAlamat" name="newAlamat" rows="3" placeholder="Enter Alamat" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Create Account</button>
                            </form>
                        </div>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['newUsername']) && isset($_POST['newPassword']) && isset($_POST['newTelpon']) && isset($_POST['newEmail']) && isset($_POST['newAlamat'])) {
                            $nName = $_POST['newUsername'];
                            $nPass = $_POST['newPassword'];
                            $nTelp = $_POST['newTelpon'];
                            $nEmail = $_POST['newEmail'];
                            $nAlamat = $_POST['newAlamat'];

                            $sql = "INSERT INTO users (username,password,user_telp,email,alamat,isAdmin) VALUES (?,?,?,?,?,0)";
                            $stmt = $mysqli->prepare($sql);
                            $stmt->bind_param("sssss", $nName, $nPass, $nTelp, $nEmail, $nAlamat);

                            if ($stmt->execute()) {
                                // header('Location: home.php');
                                exit();
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mx-auto my-10">
        <h1>Tabel Users utk Testing</h1>
        <?php
        echo '<table class="table-auto w-full border-collapse border border-gray-300">';
        echo '<thead>';
        echo '<tr class="bg-gray-200">';
        echo '<th class="border border-gray-300 px-4 py-2 text-left">Username</th>';
        echo '<th class="border border-gray-300 px-4 py-2 text-left">Password</th>';
        echo '<th class="border border-gray-300 px-4 py-2 text-left">Telp</th>';
        echo '<th class="border border-gray-300 px-4 py-2 text-left">Email</th>';
        echo '<th class="border border-gray-300 px-4 py-2 text-left">Alamat</th>';
        echo '<th class="border border-gray-300 px-4 py-2 text-left">isAdmin</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $stmt = $mysqli->query("SELECT user_id, username, password, user_telp, email, alamat, isAdmin FROM users");
        while ($row = $stmt->fetch_assoc()) {
            echo '<tr class="hover:bg-gray-100">';
            echo '<td class="border border-gray-300 px-4 py-2">' . htmlentities($row['username']) . '</td>';
            echo '<td class="border border-gray-300 px-4 py-2">' . htmlentities($row['password']) . '</td>';
            echo '<td class="border border-gray-300 px-4 py-2">' . htmlentities($row['user_telp']) . '</td>';
            echo '<td class="border border-gray-300 px-4 py-2">' . htmlentities($row['email']) . '</td>';
            echo '<td class="border border-gray-300 px-4 py-2">' . htmlentities($row['alamat']) . '</td>';
            echo '<td class="border border-gray-300 px-4 py-2">' . htmlentities($row['isAdmin']) . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        ?>
    </section>

</body>

</html>