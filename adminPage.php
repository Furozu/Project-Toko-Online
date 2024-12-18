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

    <!-- buttons menu -->
    <section class="container-full">
        <div class="grid gap-8 grid-cols-3 px-3 pt-4 justify-items-between">

            <a class="text-center" href="#" data-bs-toggle="modal" data-bs-target="#createproductmodal">
                <p class="h4 p-10 bg-warning rounded fw-bold hover:text-white" onclick="create()"> CREATE NEW PRODUCT</p>
            </a>

            <a class="text-center" href="#">
                <p class="h4 p-10 bg-warning rounded fw-bold hover:text-white" onclick="editAdmin()"> SHOW USERS</p>
            </a>

            <a class="text-center" href="#">
                <p class="h4 p-10 bg-warning rounded fw-bold hover:text-white" onclick="listItem()"> SHOW PRODUCTS</p>
            </a>

        </div>
        <!--function toggle show/hide-->
        <script>
            function editAdmin() {
                var z = document.getElementById("editAdmin");
                var a = document.getElementById("listItem");
                if (z.style.display === "none") {
                    z.style.display = "block";
                } else {
                    z.style.display = "none";
                }
            }

            function listItem() {
                var z = document.getElementById("editAdmin");
                var a = document.getElementById("listItem");
                if (a.style.display === "none") {
                    a.style.display = "block";
                } else {
                    a.style.display = "none";
                }
            }
        </script>

        <section id="createProduct">
            <!-- pop up create product -->
            <div class="modal fade bd-example-modal-lg" id="createproductmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-xl font-bold text-gray-800" id="myLargeModalLabel">Add Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Form for creating a new account -->
                            <form method="post">
                                <div class="form-group mb-3">
                                    <label for="newImage">Link Gambar</label>
                                    <input type="text" class="form-control" id="newImage" name="newImage" placeholder="Enter Image Address" required>
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
                                <div class="flex items-center pr-3 mb-3">
                                    <label class="font-medium text-gray-600 mr-4" for="kategori">Kategori : </label>
                                    <select id="newKategori" name="newKategori" class="border-none bg-transparent rounded-lg focus:outline-none text-gray-700">
                                        <?php
                                        $stmt = $mysqli->query("SELECT kategori_id, nama_kategori FROM kategori");
                                        while ($row = $stmt->fetch_assoc()) {
                                            $selected = (isset($_POST['newKategori']) && $_POST['newKategori'] == $row['kategori_id']) ? 'selected' : '';
                                            echo '<option value="' . htmlentities($row['kategori_id']) . '" ' . $selected . '>' . htmlentities($row['nama_kategori']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="btn btn-warning font-semibold">Add Product</button>
                                </div>
                            </form>
                        </div>

                        <?php
                        # add item ke database
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['newImage']) && isset($_POST['newBarang']) && isset($_POST['newHarga']) && isset($_POST['newDeskripsi']) && isset($_POST['newStock']) && isset($_POST['newKategori'])) {
                            $nImg = $_POST['newImage'];
                            $nBarang = $_POST['newBarang'];
                            $nHarga = $_POST['newHarga'];
                            $nDesk = $_POST['newDeskripsi'];
                            $nStock = $_POST['newStock'];
                            $nKategori = $_POST['newKategori'];

                            $sql = "INSERT INTO products (gambar,nama_product,harga_satuan,deskripsi,stock_product,kategori_id) VALUES (?,?,?,?,?,?)";
                            $stmt = $mysqli->prepare($sql);
                            $stmt->bind_param("ssisii", $nImg, $nBarang, $nHarga, $nDesk, $nStock, $nKategori);
                            if ($stmt->execute()) {
                                echo "<script>alert('Product Added successfully!');</script>";
                            } else {
                                echo "Error: " . $stmt->error;
                            }
                            $stmt->close();
                            echo '<meta http-equiv="refresh" content="0">';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <section id="editAdmin" style="display: none;" class="my-8 mx-3">
            <?php
            // set user yang akan di delete
            if (isset($_GET['deleteUser'])) {
                $userId = $_GET['deleteUser'];

                // Delete user 
                $stmt = $mysqli->prepare("DELETE FROM users WHERE user_id = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
            }

            // updating user ke database
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
                $userId = $_POST['user_id'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $userTelp = $_POST['user_telp'];
                $email = $_POST['email'];
                $alamat = $_POST['alamat'];
                $isAdmin = $_POST['isAdmin'];

                // Prepare query
                $stmt = $mysqli->prepare("UPDATE users SET username = ?, password = ?, user_telp = ?, email = ?, alamat = ?, isAdmin = ? WHERE user_id = ?");
                $stmt->bind_param("sssssii", $username, $password, $userTelp, $email, $alamat, $isAdmin, $userId);

                // cek query
                if ($stmt->execute()) {
                    echo "<script>alert('User updated successfully!');</script>";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
                echo '<meta http-equiv="refresh" content="0">';
            }

            // Display users di tabel
            echo '<table class="table-auto w-full border-collapse border border-gray-300">';
            echo '<thead>';
            echo '<tr class="bg-gray-200">';
            echo '<th class="border border-gray-300 px-4 py-2 text-left">Username</th>';
            echo '<th class="border border-gray-300 px-4 py-2 text-left">Password</th>';
            echo '<th class="border border-gray-300 px-4 py-2 text-left">Telp</th>';
            echo '<th class="border border-gray-300 px-4 py-2 text-left">Email</th>';
            echo '<th class="border border-gray-300 px-4 py-2 text-left">Alamat</th>';
            echo '<th class="border border-gray-300 px-4 py-2 text-left">isAdmin</th>';
            echo '<th class="border border-gray-300 px-4 py-2 text-center"></th>';
            echo '<th class="border border-gray-300 px-4 py-2 text-center"></th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Fetch user list
            $stmt = $mysqli->query("SELECT user_id, username, password, user_telp, email, alamat, isAdmin FROM users");
            while ($row = $stmt->fetch_assoc()) {
                $modalId = "usermodal" . $row['user_id'];

                echo '<tr class="hover:bg-gray-100">';
                echo '<td class="border border-gray-300 px-4 py-2">' . htmlentities($row['username']) . '</td>';
                echo '<td class="border border-gray-300 px-4 py-2">' . htmlentities($row['password']) . '</td>';
                echo '<td class="border border-gray-300 px-4 py-2">' . htmlentities($row['user_telp']) . '</td>';
                echo '<td class="border border-gray-300 px-4 py-2">' . htmlentities($row['email']) . '</td>';
                echo '<td class="border border-gray-300 px-4 py-2">' . htmlentities($row['alamat']) . '</td>';
                echo '<td class="border border-gray-300 px-4 py-2">' . htmlentities($row['isAdmin']) . '</td>';
                echo '<td class="border border-gray-300 py-2 text-center">
            <button class="btn btn-warning font-semibold" data-bs-toggle="modal" data-bs-target="#' . $modalId . '">Edit</button>
        </td>';
                echo '<td class="border border-gray-300 py-2 text-center">
            <button class="btn btn-danger font-semibold" onclick="deleteUser(' . $row['user_id'] . ')">Delete</button>
        </td>';
                echo '</tr>';

                // Modal edit user
                echo '<div class="modal fade" id="' . $modalId . '" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content rounded-md shadow-lg">
                        <div class="modal-header border-b">
                            <h5 class="modal-title text-xl font-bold text-gray-800">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body gap-6 px-4 pb-4">
                            <!-- User Details Section -->
                            <div class="">
                                <form action="adminPage.php" method="POST">
                                    <input type="hidden" name="user_id" value="' . $row['user_id'] . '">
                                    <label>Username</label><input class="pl-4 mb-4 form-control" type="text" name="username" value="' . htmlentities($row['username']) . '">
                                    <label>Password</label><input  class="pl-4 mb-4 form-control" type="text" name="password" value="' . htmlentities($row['password']) . '">
                                    <label>Telp</label><input  class="pl-4 mb-4 form-control" type="text" name="user_telp" value="' . htmlentities($row['user_telp']) . '">
                                    <label>Email</label><input class="pl-4 mb-4 form-control" type="email" name="email" value="' . htmlentities($row['email']) . '">
                                    <label>Alamat</label><input class="pl-4 mb-4 form-control" type="text" name="alamat" value="' . htmlentities($row['alamat']) . '">
                                    <label>IsAdmin</label><input class="pl-4 mb-4 form-control" type="text" name="isAdmin" value="' . htmlentities($row['isAdmin']) . '">
                                    <div class="flex justify-end">
                                    <input type="submit" class="btn btn-primary" value="Update User">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            }
            echo '</tbody>';
            echo '</table>';
            ?>

            <script>
                function deleteUser(userId) {
                    // alert sebelum delete
                    if (confirm("Are you sure you want to delete this user?")) {
                        window.location.href = "adminPage.php?deleteUser=" + userId;
                    }
                }
            </script>
        </section>

        <section id="listItem" style="display: none;">
            <div class="mx-3 grid grid-cols-4 gap-3 my-10">
                <?php
                // Fetch all products
                $stmt = $mysqli->query("SELECT product_id, gambar, nama_product, harga_satuan, deskripsi, stock_product, kategori_id FROM products");

                // Check if the query returned results
                if ($stmt === false) {
                    echo "Error in query: " . $mysqli->error;
                } else {
                    // Check if there are products
                    if ($stmt->num_rows > 0) {
                        while ($row = $stmt->fetch_assoc()) {
                            // Prepare product data
                            $product = [
                                'id' => htmlentities($row['product_id']),
                                'image' => htmlentities($row['gambar']),
                                'name' => htmlentities($row['nama_product']),
                                'price' => htmlentities($row['harga_satuan']),
                                'description' => htmlentities($row['deskripsi']),
                                'stock' => htmlentities($row['stock_product']),
                                'kategori_id' => htmlentities($row['kategori_id'])
                            ];

                            // Modal ID
                            $modalId = "itemModal" . $product['id'];
                ?>

                            <!-- Product Card -->
                            <div class="card shadow-md hover:shadow-2xl">
                                <img class="card-img-top min-h-48" src="<?= $product['image']; ?>" alt="Card image cap" style="height: 48px; object-fit: cover; object-position: center;">
                                <div class="card-body p-4 rounded-md bg-white">
                                    <h5 class="card-title text-lg font-semibold text-gray-800"><?= $product['name']; ?></h5>
                                    <p class="card-text font-bold text-lg text-green-600">Rp. <?= number_format($product['price'], 0, ',', '.'); ?></p>
                                </div>
                                <div class="grid grid-cols-2">
                                    <!-- Delete Form -->
                                    <form method="post">
                                        <input type="hidden" name="delete_product_id" value="<?= $product['id']; ?>">
                                        <button type="submit" class="btn btn-danger mb-4 mr-auto ml-5 hover:text-white font-semibold">Delete</button>
                                    </form>

                                    <!-- Edit Button -->
                                    <button class="btn btn-warning mb-4 ml-auto mr-5 px-4 hover:text-white font-semibold" data-bs-toggle="modal" data-bs-target="#<?= $modalId; ?>">Edit</button>
                                </div>
                            </div>

                            <!-- Product Modal -->
                            <div class="modal fade" id="<?= $modalId; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content rounded-md shadow-lg">
                                        <div class="modal-header border-b">
                                            <h5 class="modal-title text-xl font-bold text-gray-800">Update Product</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="adminPage.php" method="POST">
                                            <div class="modal-body grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                                                <!-- Image Section -->
                                                <div class="justify-center">
                                                    <img class="rounded-lg shadow-md" src="<?= $product['image']; ?>" alt="Product image">
                                                    <div class="pt-4">
                                                        <label>Link Gambar</label>
                                                        <textarea class="pl-4 form-control" type="text" rows="5" name="gambar"><?= htmlspecialchars($product['image']) ?></textarea>
                                                    </div>
                                                </div>

                                                <!-- Details Section -->
                                                <div class="">
                                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                                                    <label>Nama Product</label>
                                                    <input class="pl-4 form-control" type="text" name="nama_product" value="<?= $product['name'] ?>"><br>

                                                    <label>Harga Satuan</label>
                                                    <input class="pl-4 form-control" type="text" name="harga_satuan" value="<?= $product['price'] ?>"><br>

                                                    <label>Deskripsi Product</label>
                                                    <input class="pl-4 form-control" type="text" name="deskripsi" value="<?= $product['description'] ?>"><br>

                                                    <label>Stock Product</label>
                                                    <input class="pl-4 form-control" type="text" name="stock_product" value="<?= $product['stock'] ?>"><br>

                                                    <!-- Category Dropdown -->
                                                    <div class="flex items-center pr-3 mb-3">
                                                        <label class="font-medium text-gray-600 mr-4" for="kategori">Kategori: </label>
                                                        <select id="aaa" name="aaa" class="border-none bg-transparent rounded-lg focus:outline-none text-gray-700">
                                                            <?php
                                                            $kategoriStmt = $mysqli->query("SELECT kategori_id, nama_kategori FROM kategori");
                                                            while ($row = $kategoriStmt->fetch_assoc()) {
                                                                $selected = ($product['kategori_id'] == $row['kategori_id']) ? 'selected' : '';
                                                                echo '<option value="' . htmlentities($row['kategori_id']) . '" ' . $selected . '>' . htmlentities($row['nama_kategori']) . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="flex justify-end">
                                                        <input type="submit" class="btn btn-primary" value="Update Product">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                <?php
                        }
                    } else {
                        // No products found
                        echo "No products available.";
                    }
                }

                // Update Product in the database
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && !isset($_POST['delete_product_id'])) {
                    $id = $_POST['product_id'];
                    $gambar = $_POST['gambar'];
                    $nama_product = $_POST['nama_product'];
                    $harga_satuan = $_POST['harga_satuan'];
                    $deskripsi = $_POST['deskripsi'];
                    $stock_product = $_POST['stock_product'];
                    $kategori_id = $_POST['aaa'];

                    // Prepare query to update product
                    $sql = "UPDATE products SET gambar=?, nama_product=?, harga_satuan=?, deskripsi=?, stock_product=?, kategori_id=? WHERE product_id=?";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("ssisiii", $gambar, $nama_product, $harga_satuan, $deskripsi, $stock_product, $kategori_id, $id);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<script>alert('Product updated successfully!');</script>";
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                    $stmt->close();
                    echo '<meta http-equiv="refresh" content="0">';
                }

                // Delete Product
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product_id'])) {
                    $productId = $_POST['delete_product_id'];

                    // Prepare and execute the delete query
                    $stmt = $mysqli->prepare("DELETE FROM products WHERE product_id = ?");
                    $stmt->bind_param("i", $productId);
                    if ($stmt->execute()) {
                        echo "<script>alert('Product deleted successfully!');</script>";
                    } else {
                        echo "Error deleting product: " . $stmt->error;
                    }
                    $stmt->close();
                    echo '<meta http-equiv="refresh" content="0">';
                }
                ?>
            </div>
        </section>

        <br><br><br><br><br><br><br><br><br><br><br>
</body>

</html>