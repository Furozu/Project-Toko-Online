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