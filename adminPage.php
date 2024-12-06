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
    <nav class="navbar navbar-expand-lg navbar-light bg-dark sticky fixed-top gap-2">
        <a class="navbar-brand pl-12 text-yellow-400 hover:text-white hover:font-semibold" href="home.php">Toko Online</a>
        <div class="navbar justify-content-between">
            <ul class="navbar-nav mr-auto gap-3">
                <li class="nav-item"><!-- TODO: belum connect -->
                    <a class="nav-link text-yellow-400 hover:text-white hover:font-semibold" href="">Profile</a>
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

    <!-- buttons -->
    <section class="container-full">
        <br><br>
        <div class="row justify-items-between">

            <div class="col-lg-3 justify-items-center p-8">
                <a class="text-center" href="#" data-bs-toggle="modal" data-bs-target="#createproductmodal">
                    <p class="h4 p-10 bg-warning rounded fw-bold hover:text-white" onclick="create()"> CREATE NEW PRODUCT</p>
                </a>
            </div>
            <div class="col-lg-3 justify-items-center p-8">
                <a class="text-center" href="#">
                    <p class="h4 p-10 bg-warning rounded fw-bold hover:text-white" onclick="update()"> UPDATE PRODUCT</p>
                </a>
            </div>
            <div class="col-lg-3 justify-items-center p-8">
                <a class="text-center" href="#">
                    <p class="h4 p-10 bg-warning rounded fw-bold hover:text-white" onclick="editAdmin()"> SHOW USERS</p>
                </a>
            </div>
            <div class="col-lg-3 justify-items-center p-8">
                <a class="text-center" href="#">
                    <p class="h4 p-10 bg-warning rounded fw-bold hover:text-white" onclick="listItem()"> SHOW PRODUCTS</p>
                </a>
            </div>
        </div>
        <script>
            function create() {
                var x = document.getElementById("createProduct");
                var y = document.getElementById("updateProduct");
                var z = document.getElementById("editAdmin");
                var a = document.getElementById("listItem");
                if (x.style.display === "none") {
                    x.style.display = "block";
                    y.style.display = "none";
                    z.style.display = "none";
                    a.style.display = "none";
                } else {
                    x.style.display = "none";
                }
            }

            function update() {
                var x = document.getElementById("createProduct");
                var y = document.getElementById("updateProduct");
                var z = document.getElementById("editAdmin");
                var a = document.getElementById("listItem");
                if (y.style.display === "none") {
                    y.style.display = "block";
                    x.style.display = "none";
                    z.style.display = "none";
                    a.style.display = "none";
                } else {
                    y.style.display = "none";
                }
            }

            function editAdmin() {
                var x = document.getElementById("createProduct");
                var y = document.getElementById("updateProduct");
                var z = document.getElementById("editAdmin");
                var a = document.getElementById("listItem");
                if (z.style.display === "none") {
                    z.style.display = "block";
                    y.style.display = "none";
                    x.style.display = "none";
                    a.style.display = "none";
                } else {
                    z.style.display = "none";
                }
            }

            function listItem() {
                var x = document.getElementById("createProduct");
                var y = document.getElementById("updateProduct");
                var z = document.getElementById("editAdmin");
                var a = document.getElementById("listItem");
                if (a.style.display === "none") {
                    a.style.display = "block";
                    y.style.display = "none";
                    x.style.display = "none";
                    z.style.display = "none";
                } else {
                    a.style.display = "none";
                }
            }
        </script>

        <section id="createProduct" style="display: none;">
            <!-- pop up create product -->
            <div class="modal fade bd-example-modal-lg" id="createproductmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">Daftar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal2" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Form for creating a new account -->
                            <form method="post">
                                <div class="form-group mb-3">
                                    <label for="newImage">Gambar</label>
                                    <input type="text" class="form-control" id="newImage" name="newImage" placeholder="Enter ImageAddress" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="newBarang">Nama barang</label>
                                    <input type="text" class="form-control" id="newBarang" name="newBarang" placeholder="Enter Nama Barang" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="newHarga">Harga Satuan</label>
                                    <input type="text" class="form-control" id="newHarga" name="newHarga" placeholder="Enter Harga Satuan" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="newDeskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="newDeskripsi" name="newDeskripsi" rows="3" placeholder="Enter Deskripsi" required></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="newStock">Stock</label>
                                    <input type="text" class="form-control" id="newStock" name="newStock" placeholder="Enter Stock" required>
                                </div>
                                <button type="submit" class="btn btn-warning">Add Product</button>
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
        </section>
        <section id="updateProduct" style="display: none;">
            <form method="post">
                <div class="form-group mb-3">
                    <label for="newImage">ini update Gambar</label>
                    <input type="text" class="form-control" id="newImage" name="newImage" placeholder="Enter ImageAddress" required>
                </div>
                <div class="form-group mb-3">
                    <label for="newBarang">Nama barang</label>
                    <input type="text" class="form-control" id="newBarang" name="newBarang" placeholder="Enter Nama Barang" required>
                </div>
                <div class="form-group mb-3">
                    <label for="newHarga">Harga Satuan</label>
                    <input type="text" class="form-control" id="newHarga" name="newHarga" placeholder="Enter Harga Satuan" required>
                </div>
                <div class="form-group mb-3">
                    <label for="newDeskripsi">Deskripsi</label>
                    <textarea class="form-control" id="newDeskripsi" name="newDeskripsi" rows="3" placeholder="Enter Deskripsi" required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="newStock">Stock</label>
                    <input type="text" class="form-control" id="newStock" name="newStock" placeholder="Enter Stock" required>
                </div>
                <button type="submit" class="btn btn-warning">Add Product</button>
            </form>
        </section>

        <section id="editAdmin" style="display: none;" class="container mx-auto my-10">
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
            echo '<th class="border border-gray-300 px-4 py-2 text-center">edit</th>';
            echo '<th class="border border-gray-300 px-4 py-2 text-center">delete</th>';
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
                echo '<td class="border border-gray-300 px-4 py-2 text-center">
                <button class="btn btn-warning" onclick="">Edit</button>
                </td>';
                echo '<td class="border border-gray-300 px-4 py-2 text-center">
                <button class="btn btn-danger" onclick="">Delete</button>
                </td>';
            }
            echo '</tbody>';
            echo '</table>';
            ?>
        </section>

        <section id="listItem" style="display: none;">
            <div class=" m-3 grid grid-cols-4 gap-3">

                <?php
                $stmt = $mysqli->query("SELECT product_id, gambar, nama_product, harga_satuan, deskripsi, stock_product FROM products ");
                while ($row = $stmt->fetch_assoc()) {

                    // product element
                    $product = [
                        'id' => htmlentities($row['product_id']),
                        'image' => htmlentities($row['gambar']),
                        'name' => htmlentities($row['nama_product']),
                        'price' => htmlentities($row['harga_satuan']),
                        'description' => htmlentities($row['deskripsi']),
                        'stock' => htmlentities($row['stock_product'])
                    ];
                ?>
                    <a href="" data-bs-toggle="modal" data-bs-target="#<?= $modalId; ?>">
                        <div class="card shadow-md hover:shadow-2xl">
                            <img class="card-img-top min-h-48" src="<?= $product['image']; ?>" alt="Card image cap"
                                style="height: 48px; object-fit: cover; object-position: center;">
                            <div class="card-body p-4 rounded-md bg-white">
                                <h5 class="card-title text-lg font-semibold text-gray-800"><?= $product['name']; ?></h5>
                                <p class="card-text font-bold text-lg text-green-600">Rp. <?= number_format($product['price'], 0, ',', '.'); ?></p>
                            </div>
                        </div>
                    </a>

                <?php
                }
                ?>
        </section>

        <br><br><br><br><br><br><br><br><br><br>
</body>

</html>