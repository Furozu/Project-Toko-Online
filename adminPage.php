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
    <!-- navbar -->
    <nav class="gap-4 navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand pl-12 text-warning" href="#">Toko Online</a>
        <div class="navbar justify-content-between">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link text-warning" href="#">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="#">History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-white fw-bold" href="#">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="#">Admin History</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- buttons -->
    <section class="container-full">
        <br><br>
        <div class="row justify-items-between">
            <div class="col-lg-3 justify-items-center"></div>
            <div class="col-lg-3 justify-items-center p-8">
                <p class="h4 p-10 bg-warning rounded fw-bold">CREATE NEW PRODUCT</p>
            </div>
            <div class="col-lg-3 justify-items-center p-8">
                <p class="h4 p-10 bg-warning text-white rounded fw-bold">CREATE NEW PRODUCT</p>
            </div>
            <div class="col-lg-3 justify-items-center "></div>

        </div>
        <div class="row justify-items-between">
            <div class="col-lg-3 justify-items-center"></div>
            <div class="col-lg-3 justify-items-center p-8">
                <p class="h4 p-10 bg-warning text-white rounded fw-bold">CREATE NEW PRODUCT</p>
            </div>
            <div class="col-lg-3 justify-items-center p-8">
                <p class="h4 p-10 bg-warning rounded fw-bold">CREATE NEW PRODUCT</p>
            </div>
            <div class="col-lg-3 justify-items-center"></div>
        </div>
    </section>
    <!-- pop up create product -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>

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
</body>

</html>