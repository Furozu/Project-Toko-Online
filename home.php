<?php
require_once "connect.php";
session_start();


$where = '';
$setKategori = '';
$and = '';
$setSearch = '';

// Check apakah user punya checkout pending
if (isset($_SESSION['user_id']) and $_SESSION['isAdmin'] != 1) {
    $userID = $_SESSION['user_id'];
    $date = date("y-m-d");

    // Check apakah user punya cheout pending
    $sql = "SELECT user_id, checkout_id FROM checkout WHERE status = 'Pending' AND user_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        // Kalo ada
        $_SESSION['checkout_id'] = $row['checkout_id'];
    } else {
        // Kalo tidak ada, bikin baru
        $sql = "INSERT INTO checkout (date, total_harga, user_id, payment_id, status) VALUES (?, 0, ?, 0, 'Pending')";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $date, $userID);
        $stmt->execute();

        // Pakai checkout_id yang baru untuk cart
        $_SESSION['checkout_id'] = $stmt->insert_id;
    }
}
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

    <!-- Inisialisasi JQuary -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>


    <!-- untuk JavaScript di dalam file html -->
    <script>
        // refresh supaya data display dengan benar
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.modal').forEach(function(modal) {
                modal.addEventListener('hidden.bs.modal', function() {
                    // refresh page
                    location.reload();
                });
            });
        });

        // No Selected Payment Alert Animation
        setTimeout(() => {
            const element = document.getElementById("payment-warning");
            element.classList.add("-translate-y-full"); // slide-out ke atas
            element.classList.add("opacity-0"); // fade out
            setTimeout(() => {
                element.classList.add("hidden");
            }, 500); // 500ms sebelum hidden
        }, 2000); // 3000ms = total waktu animasi


        // jQuery starter function
        $(document).ready(function() {
            // "." = isi class
            // "#" = isi id

            // untuk fix posisi typing setelah auto submit
            $("#searchBar").focus();
            var currentValue = $("#searchBar").val();
            $("#searchBar").val("");
            $("#searchBar").val(currentValue);

            // Quantity Minus
            $(document).on('click', '.minus-btn', function() {
                // sebagai pembeda quantity di modal item lain
                var productId = $(this).data('id');
                var quantityElement = $('#quantity-' + productId);
                var hiddenInput = $('#hidden-quantity-' + productId);

                var quantity = parseInt(quantityElement.text());
                if (quantity > 0) {
                    quantity -= 1; // anti negatif
                }

                quantityElement.text(quantity); // Update
                hiddenInput.val(quantity);
            });

            // Quantity Add
            $(document).on('click', '.add-btn', function() {
                // sebagai pembeda quantity di modal item lain
                var productId = $(this).data('id');
                var stock = $(this).data('stock');
                var quantityElement = $('#quantity-' + productId);
                var quantity = parseInt(quantityElement.text());
                var hiddenInput = $('#hidden-quantity-' + productId);


                // stock checker
                if (stock > quantity) {
                    quantity += 1;
                    quantityElement.text(quantity); // Update
                    hiddenInput.val(quantity);
                }
            });

            // Auto Sumbit Filter
            $('#kategori').change(function() {
                $('#filter').submit();
            });

            // Auto Submit Search Bar
            $('#searchBar').on('input', function() {
                $(this).closest('form').submit();

            });
        });
    </script>
</head>

<?php

// Search Bar
if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['actionName'])) {
    $action = $_POST['actionName'];

    if ($action == 'searchBar' and isset($_POST['kategori']) and isset($_POST['searchBar'])) {

        // Kategori output
        if ($_POST['kategori'] != "All") {
            $setKategori = " AND kategori_id = " . $_POST['kategori'];
        } else {
            $setKategori = '';
        }

        // Search Bar output
        if ($_POST['searchBar'] != "") {
            $setSearch = " AND nama_product LIKE '%" . $_POST['searchBar'] . "%'";
        } else {
            $setSearch = '';
        }
    }
}

// add item ke cart user
if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['actionName']) and $_POST['actionName'] == "addToCart" and isset($_POST['product_id'])) {

    if (isset($_POST['hidden-quantity-' . $_POST['product_id']]) and $_POST['hidden-quantity-' . $_POST['product_id']] != null) {
        $quantity = (int)$_POST['hidden-quantity-' . $_POST['product_id']];

        // Check if the product already exists in the cart (detailcheckout)
        $checkCart = $mysqli->prepare("SELECT d.detail_id, d.jumlah_product, p.stock_product 
                                            FROM detailcheckout d 
                                            JOIN products p ON d.product_id = p.product_id 
                                            WHERE d.checkout_id = ? AND d.product_id = ?");
        $checkCart->bind_param("ii", $_SESSION['checkout_id'], $_POST['product_id']);
        $checkCart->execute();
        $checkResult = $checkCart->get_result();

        if ($row = $checkResult->fetch_assoc()) {
            // Kalo product sudah ada di checkout user
            $quantityBef = $row['jumlah_product'];

            // quantity sebelum dan sekarang tidak boleh sama
            if ($quantity != null and $quantity != $quantityBef) {
                if ($quantity > 0) {
                    // quantity bukan 0 
                    $updateCart = $mysqli->prepare("UPDATE detailcheckout SET jumlah_product = ? WHERE detail_id = ?");
                    $updateCart->bind_param("ii", $quantity, $row['detail_id']);
                    $updateCart->execute();
                }
            }

            if ($quantity == 0 and $quantity != $quantityBef) {
                // kalo 0 hilang dari cart
                $deleteQuery2 = $mysqli->prepare("DELETE FROM detailCheckout WHERE detail_id = ?");
                $deleteQuery2->bind_param("i", $row['detail_id']);
                $deleteQuery2->execute();
            }
        } else if ($quantity != 0) {
            // Kalo product blm ada di checkout user
            $insertStmt = $mysqli->prepare("INSERT INTO detailcheckout (checkout_id, product_id, jumlah_product) VALUES (?, ?, ?)");
            $insertStmt->bind_param("iii", $_SESSION['checkout_id'], $_POST['product_id'], $quantity);
            $insertStmt->execute();
        }

        // refresh page
        echo '<meta http-equiv="refresh" content="0">';
    }
}

// delete item dari checkout
if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['actionName'])) {
    $action = $_POST['actionName'];

    if ($action == "delete") {
        // delete item dari cart
        $deleteQuery = $mysqli->prepare("DELETE FROM detailCheckout WHERE detail_id = ?");
        $deleteQuery->bind_param("i", $_POST['detailID']);
        $deleteQuery->execute();

        // update stock (not used)
        // $stockNow = $_POST['jumProduct'] + $_POST['stock'];
        // $updateStock2 = $mysqli->prepare("UPDATE products SET stock_product = ? WHERE product_id = ?");
        // $updateStock2->bind_param("ii", $stockNow, $_POST['productID']);
        // $updateStock2->execute();

        // refresh page
        echo '<meta http-equiv="refresh" content="0">';
    }
}

// Checkout function (completed transaction)
if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['actionName']) and $_POST['actionName'] == 'checkout' and isset($_POST['payment']) and isset($_POST['haveItem'])) {

    // No Selected Payment Method Alert Setter
    if ($_SESSION['noPayment'] == 0 and $_POST['payment'] == 0 and $_POST['haveItem'] == TRUE and $_POST['availability'] == TRUE) {
        $_SESSION['noPayment'] = 1;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if ($_POST['payment'] != 0 and $_POST['haveItem'] == TRUE and $_POST['availability'] == TRUE) {

        // get the checkout item
        $stmt = $mysqli->prepare("SELECT d.detail_id, p.product_id, d.jumlah_product, p.stock_product
                                    FROM detailcheckout d 
                                    JOIN products p ON d.product_id = p.product_id 
                                    WHERE d.checkout_id = ?");
        $stmt->bind_param("i",  $_SESSION['checkout_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            // Update Stock product
            $updateStock = $mysqli->prepare("UPDATE products SET stock_product = ? WHERE product_id = ?");
            $newStock = $row['stock_product'] - $row['jumlah_product'];
            $updateStock->bind_param("ii", $newStock, $row['product_id']);
            $updateStock->execute();
        }

        // status Completed maker
        $sql = "UPDATE checkout SET date = ?, payment_id = ?, status = 'Completed' WHERE checkout_id = ?";
        $checkoutQuery = $mysqli->prepare($sql);
        $payment_id = $_POST['payment'];
        $checkoutQuery->bind_param("sii", $date, $payment_id, $_SESSION['checkout_id']);
        $checkoutQuery->execute();

        // refresh page
        echo '<meta http-equiv="refresh" content="0">';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

?>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-dark sticky fixed-top gap-2">
        <a class="navbar-brand pl-12 text-yellow-400 hover:text-white hover:font-semibold" href="home.php">Toko Online</a>
        <div class="navbar justify-content-between">
            <ul class="navbar-nav mr-auto gap-3">

                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<li class="nav-item">
                            <a class="nav-link text-yellow-400 hover:text-white hover:font-semibold" href="profil.php">Profile</a>
                          </li>';

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
                }
                ?>

            </ul>
        </div>

        <?php
        // No Login User
        if (!isset($_SESSION['user_id'])) {
            echo '<a href="login.php" type="button" class="hover:text-white btn btn-primary  font-semibold  px-5 py-2 rounded-lg text-sm ml-auto mr-14">Login</a>';
        }

        // User Only
        if (isset($_SESSION['user_id']) and $_SESSION['isAdmin'] == 0) {
            echo '<button type="button" class="hover:text-white bg-yellow-400  font-semibold  px-5 py-2 rounded-lg text-sm ml-auto mr-14" data-bs-toggle="modal" data-bs-target="#checkout">Cart</button>';
        }

        // Admin Only 
        if (isset($_SESSION['user_id']) and $_SESSION['isAdmin'] == 1) {
            echo   '<form method="POST" class="d-inline ml-auto mr-14">
                        <button type="submit" name="logout" class="btn btn-danger font-semibold px-5 py-2 rounded-lg text-sm text-white">Logout</button>
                    </form>';
        }
        ?>

    </nav>



    <!-- Checkout Modal -->
    <div class="modal fade" id="checkout" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-md shadow-lg">
                <div class="modal-header border-b">
                    <h5 class="modal-title text-xl font-bold text-gray-800">Checkout Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body gap-6 p-4 pb-0">

                    <!-- Details Section -->
                    <?php
                    $stmt = $mysqli->prepare("SELECT d.detail_id, p.product_id, p.nama_product, d.jumlah_product, p.stock_product, p.harga_satuan
                                        FROM detailcheckout d
                                        JOIN products p ON d.product_id = p.product_id
                                        WHERE d.checkout_id = ?");
                    $stmt->bind_param("i",  $_SESSION['checkout_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // kalau tidak ada item
                    $haveItem = FALSE;
                    $available = TRUE;

                    // kalo ada item
                    while ($row = $result->fetch_assoc()) {
                        $haveItem = TRUE;
                    ?>
                        <div class="bg-gray-100 rounded-lg p-2 m-2 shadow-md">
                            <div class="grid grid-cols-3 items-center pl-2">
                                <!-- Product Name -->
                                <p class="text-gray-800 font-semibold text-lg"><?= $row['nama_product']; ?></p>

                                <!-- Quantity and Availability -->
                                <div class="flex justify-between">
                                    <p class="text-gray-600 font-medium">Quantity: <?= $row['jumlah_product']; ?></p>
                                    <?php if ($row['stock_product'] < $row['jumlah_product']): ?>
                                        <p class="text-red-500 font-semibold">Not Available!</p>
                                        <?php $available = FALSE; ?>
                                    <?php endif; ?>
                                </div>

                                <!-- Close Button -->
                                <form method="POST" class="ml-auto">
                                    <input type="hidden" name="actionName" value="delete">
                                    <input type="hidden" name="detailID" value="<?= $row['detail_id'] ?>">
                                    <input type="hidden" name="stock" value="<?= $row['stock_product'] ?>">
                                    <input type="hidden" name="jumProduct" value="<?= $row['jumlah_product'] ?>">
                                    <input type="hidden" name="productID" value="<?= $row['product_id'] ?>">
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded shadow">Remove</button>
                                </form>
                            </div>
                        </div>

                    <?php
                    }

                    if (!$haveItem) {
                        echo '<p class="text-xl text-center font-semibold text-black">No Item in Cart</p>';
                    }

                    $getTotal = $mysqli->prepare("SELECT * FROM checkout WHERE checkout_id = ?");
                    $getTotal->bind_param('i', $_SESSION['checkout_id']);
                    $getTotal->execute();
                    $result = $getTotal->get_result();
                    if ($haveItem and $row = $result->fetch_assoc()) {
                        echo '<div class="px-2 flex justify-between items-center">
                                <p class="font-medium text-black">Total Harga Cart : </p>
                                <p class="font-semibold text-xl text-green-600">Rp. ' . number_format($row['total_harga'], 0, ',', '.') . '</p>
                              </div>';
                    }
                    ?>

                    <form method="POST">
                        <input type="hidden" name="actionName" value="checkout">
                        <input type="hidden" name="haveItem" value="<?= $haveItem ?>">
                        <input type="hidden" name="availability" value="<?= $available ?>">

                        <!-- Payment Method Selection -->
                        <div class="flex items-center space-x-2 mt-2 mb-3 mx-2">
                            <label class="font-medium text-black" for="payment">Select Payment Method : </label>
                            <select id="payment" name="payment" class="border-none bg-transparent rounded-lg focus:outline-none text-black">
                                <?php

                                // pilihan opsi payment method dari database
                                $stmt = $mysqli->query("SELECT payment_id, payment_method FROM payment");
                                while ($row = $stmt->fetch_assoc()) {
                                    $selected = (isset($_POST['payment']) && $_POST['payment'] == $row['payment_id']) ? 'selected' : '';
                                    echo '<option value="' . htmlentities($row['payment_id']) . '" ' . $selected . '>' . htmlentities($row['payment_method']) . '</option>';
                                }
                                ?>

                            </select>
                        </div>

                        <!-- Checkout Button -->
                        <div class="modal-footer border-t px-4 py-3">

                            <?php
                            // ada yg diluar stock / no item in cart
                            if ($available == FALSE or $haveItem == FALSE) { ?>
                                <div class="bg-yellow-100 border-l-4 px-3 py-2 border-yellow-500 text-yellow-700 rounded-lg">
                                    <p class="text-sm font-semibold">
                                        <?= $available == FALSE ? 'Ada Item Melebihi Stock' : 'No Item in Cart'; ?>
                                    </p>
                                </div>
                                <button type="submit" class="btn btn-primary px-5 py-2 rounded-lg text-sm disabled">Checkout</button>

                            <?php } else { ?>
                                <!-- tidak ada masalah -->
                                <button type="submit" class="btn btn-primary px-5 py-2 rounded-lg text-sm">Checkout</button>
                            <?php }  ?>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <?php
    // No Selected Payment Method Alert Display
    if (isset($_SESSION['noPayment']) and $_SESSION['noPayment'] == 1) {
        echo    '<div id="payment-warning" class="m-3 bg-yellow-400 text-black text-lg font-medium rounded-md shadow-md transition-all duration-1000 ease-in-out">
                    <p class="px-4 py-2 text-center">⚠️ No Selected Payment Method ⚠️</p>
                </div>';
        $_SESSION['noPayment'] = 0;
    }
    ?>

    <!-- Kategori + Search Bar  -->
    <div class="m-3">

        <form id="filter" class="flex items-center bg-gray-100 rounded-lg shadow-md px-4 py-2 space-x-3" method="POST">
            <input type="hidden" name="actionName" value="searchBar">

            <!-- Category Dropdown -->
            <div class="flex items-center space-x-2 pr-3">
                <label class="font-medium text-gray-600" for="kategori">Kategori: </label>
                <select id="kategori" name="kategori" class="border-none bg-transparent rounded-lg focus:outline-none text-gray-700">
                    <option value="All">All</option>

                    <?php
                    // untuk opsi kategori lain dari database
                    $stmt = $mysqli->query("SELECT kategori_id, nama_kategori FROM kategori");
                    while ($row = $stmt->fetch_assoc()) {
                        $selected = ($_POST['kategori'] == $row['kategori_id']) ? 'selected' : ''; // agar tidak reset saat refresh
                        echo '<option value="' . htmlentities($row['kategori_id']) . '" ' . $selected . '>' . htmlentities($row['nama_kategori']) . '</option>';
                    }
                    ?>

                </select>
            </div>

            <!-- Vertical Line (Partial Height) -->
            <div class="h-8 border-r-2 border-gray-300 mx-3"></div>

            <!-- Search Bar -->
            <input id="searchBar" name="searchBar" class="flex-grow bg-transparent rounded-lg focus:outline-none placeholder-gray-400 text-gray-700" type="search" placeholder="Search for items..." aria-label="Search"
                <?php
                // untuk return value sebelum auto submit
                if (isset($_POST['searchBar'])) {
                    echo 'value="' . htmlspecialchars($_POST['searchBar']) . '"';
                }
                ?>>
        </form>
    </div>


    <!-- item list  -->
    <div class=" m-3 grid grid-cols-4 gap-3">
        <?php
        $result = $mysqli->query("SELECT product_id, gambar, nama_product, harga_satuan, deskripsi, stock_product 
                                FROM products WHERE stock_product != 0" .  $setKategori . $setSearch);
        while ($row = $result->fetch_assoc()) {

            // product element
            $product = [
                'id' => htmlentities($row['product_id']),
                'image' => htmlentities($row['gambar']),
                'name' => htmlentities($row['nama_product']),
                'price' => htmlentities($row['harga_satuan']),
                'description' => htmlentities($row['deskripsi']),
                'stock' => htmlentities($row['stock_product'])
            ];

            // penghubung modal 
            $modalId = "itemModal" . $product['id'];
        ?>

            <!-- item -->
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

            <!-- item Modal -->
            <div class="modal fade" id="<?= $modalId; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content rounded-md shadow-lg">
                        <div class="modal-header border-b">
                            <h5 class="modal-title text-xl font-bold text-gray-800">Product Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                            <!-- Image Section -->
                            <div class="flex justify-center">
                                <img class="rounded-lg shadow-md size-fit" src="<?= $product['image']; ?>" alt="Product image">
                            </div>
                            <!-- Details Section -->
                            <div class="space-y-3">
                                <p class="text-lg font-semibold text-gray-800"><?= $product['name']; ?></p>
                                <p class="text-lg text-green-500 font-bold">Rp. <?= number_format($product['price'], 0, ',', '.'); ?></p>
                                <p class="py-2 text-sm text-black text-justify"><?= $product['description']; ?></p>
                                <p class="text-sm text-black font-medium">Stock: <?= $product['stock']; ?></p>
                            </div>
                        </div>

                        <form method="POST">
                            <input type="hidden" name="actionName" value="addToCart">
                            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                            <div class="modal-footer border-t flex justify-between items-center px-4 py-3">
                                <!-- Quantity Control -->
                                <div class="grid grid-cols-3 items-center">

                                    <!-- "-" Button , "javascript:void(0);" supaya page nya tidak refresh -->
                                    <a href="javascript:void(0);" class="btn btn-danger text-center size-10 minus-btn <?= (!isset($_SESSION['user_id']) || (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)) ? 'disabled' : '' ?>" <?= (!isset($_SESSION['user_id']) || (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)) ? 'disabled' : '' ?> data-id="<?= $product['id'] ?>">-</a>


                                    <?php
                                    // untuk display angka quantity
                                    $checkQuatity = $mysqli->prepare("SELECT detail_id, jumlah_product FROM detailcheckout WHERE checkout_id = ? AND product_id = ?");
                                    $checkQuatity->bind_param("ii", $_SESSION['checkout_id'], $product['id']);
                                    $checkQuatity->execute();
                                    $checkResult = $checkQuatity->get_result();
                                    if ($row = $checkResult->fetch_assoc() and isset($_SESSION['checkout_id'])) {
                                        // kalo ada item di cart
                                        echo '<p id="quantity-' . $product['id'] . '" name="quantity-' . $product['id'] . '" class="text-center quantity-display">' . $row['jumlah_product'] . '</p>';
                                    } else {
                                        // kalo tidak ada di cart
                                        echo '<p id="quantity-' . $product['id'] . '" name="quantity-' . $product['id'] . '" class="text-center quantity-display">0</p>';
                                    }
                                    ?>

                                    <!-- "+" Button -->
                                    <a href="javascript:void(0);" class="btn btn-success text-center size-10 add-btn <?= (!isset($_SESSION['user_id']) || (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)) ? 'disabled' : '' ?>" <?= (!isset($_SESSION['user_id']) || (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)) ? 'disabled' : '' ?>" data-id="<?= $product['id']; ?>" data-stock="<?= $product['stock']; ?>">+</a>
                                </div>

                                <?php if (!isset($_SESSION['user_id'])): ?>
                                    <div class="bg-yellow-100 border-l-4 px-3 py-2 border-yellow-500 text-yellow-700 rounded-lg">
                                        <p class="text-sm font-semibold">Login untuk menambahkan barang ke keranjang</p>
                                    </div>
                                <?php endif; ?>

                                <!-- Hidden input untuk kirim quantity ke php -->
                                <input type="hidden" id="hidden-quantity-<?= $product['id']; ?>" name="hidden-quantity-<?= $product['id']; ?>">

                                <!-- Add to Cart Button -->
                                <button type="submit" class="btn btn-primary px-5 py-2 rounded-lg text-sm <?= (!isset($_SESSION['user_id']) || (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)) ? 'disabled' : '' ?>" <?= (!isset($_SESSION['user_id']) || (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)) ? 'disabled' : '' ?>>Add To Cart </button>
                        </form>

                    </div>
                </div>
            </div>
    </div>

<?php
        }

        if (isset($_SESSION['user_id'])) {
            // Hitung total_harga
            $checkSum = $mysqli->prepare("SELECT SUM(d.jumlah_product * p.harga_satuan) AS total_price
                                    FROM detailcheckout d
                                    JOIN products p ON d.product_id = p.product_id
                                    WHERE d.checkout_id = ?");
            $checkSum->bind_param("i", $_SESSION['checkout_id']);
            $checkSum->execute();
            $checkResult = $checkSum->get_result();

            if ($row = $checkResult->fetch_assoc()) {
                // Update total_harga
                $priceUpdate = $mysqli->prepare("UPDATE checkout SET total_harga = ? WHERE checkout_id = ?");
                $priceUpdate->bind_param("ii", $row['total_price'], $_SESSION['checkout_id']);
                $priceUpdate->execute();
            }
        }

?>
</body>

</html>