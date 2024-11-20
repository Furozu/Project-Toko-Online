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
            <form class="grid grid-rows-4 gap-3">
                <div>
                    <p class="text-5xl font-bold">Log In</p>
                </div>

                <div class="form-group">
                    <label class="pb-1" for="usernameInput">Username</label>
                    <input class="form-control" id="usernameInput" placeholder="Enter Username">
                </div>

                <div class="form-group">
                    <label class="pb-1" for="passwordInput">Password</label>
                    <input type="password" class="form-control" id="passwordInput" placeholder="Password">
                </div>

                <div>
                    <div>
                        <button type="submit" class="size-full btn btn-primary">LOG IN</button>
                    </div>

                    <p class="mt-1">Create <a class="link-underline text-blue-600" href="">New Account?</a></p>
                </div>
            </form>
        </div>
    </section>

    <section class="container mx-auto my-10">
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

    <!-- TODO: Test login function -->
    <?php
    $login = 0;
    $isAdmin = 0;
    $name = "";
    $isiNama = "";

    $result = $mysqli->query("SELECT id,username,password,isAdmin FROM users");
    // Untuk check semua pasangan username dan password
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {         

        // check pasangan username dan password
        if (isset($_POST['username'])) {
            if ($_POST['username'] == $row['username'] && $_POST['password'] == $row['password']) {
                $name = $_POST['username'];
                $_SESSION['username'] = $name;
                $login = 1;

                if ($row['isAdmin'] == '1') {
                    $isAdmin = 1;
                }
                break;
            }
        }
    }
    ?>

</body>

</html>