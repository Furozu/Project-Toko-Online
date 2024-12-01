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

    <!-- Inisialisasi JQuary -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>


    <!-- untuk JavaScript di dalam file html -->
    <script>
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

                var quantity = parseInt(quantityElement.text());
                if (quantity > 0) {
                    quantity -= 1; // anti negatif
                }

                quantityElement.text(quantity); // Update
            });

            // Quantity Add
            $(document).on('click', '.add-btn', function() {
                // sebagai pembeda quantity di modal item lain
                var productId = $(this).data('id');
                var quantityElement = $('#quantity-' + productId);

                var quantity = parseInt(quantityElement.text());
                quantity += 1;
                quantityElement.text(quantity); // Update
            });

            // Add to Cart
            $(document).on('click', '.addCart-btn', function() {
                // sebagai pembeda quantity di modal item lain
                var productId = $(this).data('id');
                var quantityElement = $('#quantity-' + productId);

                // TODO: function masukin ke cart nya
                // .............................................

                // reset (disable for now)
                var quantity = parseInt(quantityElement.text());
                // quantity = 0;
                quantityElement.text(quantity); // Update
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

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-dark sticky fixed-top gap-2">
        <a class="navbar-brand pl-12 text-yellow-400 hover:text-white hover:font-semibold" href="home.php">Toko Online</a>
        <div class="navbar justify-content-between">
            <ul class="navbar-nav mr-auto gap-3">
                <li class="nav-item"><!-- TODO: belum connect -->
                    <a class="nav-link text-yellow-400 hover:text-white hover:font-semibold" href="">Profile</a>
                </li>
                <li class="nav-item"><!-- TODO: belum connect -->
                    <a class="nav-link text-yellow-500 hover:text-white hover:font-semibold" href="history.php">History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-yellow-500 hover:text-white hover:font-semibold" href="adminPage.php">Admin</a>
                </li>
                <li class="nav-item"><!-- TODO: belum connect -->
                    <a class="nav-link text-yellow-500 hover:text-white hover:font-semibold" href="">Admin History</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Kategori + Search Bar  -->
    <div class="m-3">
        <form id="filter" class="flex items-center bg-gray-100 rounded-lg shadow-md px-4 py-2 space-x-3" method="post">
            <!-- Category Dropdown -->
            <div class="flex items-center space-x-2 pr-3">
                <label class="font-medium text-gray-600" for="kategori">Kategori: </label>
                <select id="kategori" name="kategori" class="border-none bg-transparent rounded-lg focus:outline-none text-gray-700">
                    <option value="All">All</option>

                    <?php
                    $stmt = $mysqli->query("SELECT kategori_id, nama_kategori FROM kategori");
                    while ($row = $stmt->fetch_assoc()) {
                        $selected = ($_POST['kategori'] == $row['kategori_id']) ? 'selected' : ''; // agar tidak reset
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
        $where = '';
        $setKategori = '';
        $and = '';
        $setSearch = '';


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Kategori output
            if ($_POST['kategori'] != "All") {
                $setKategori = "kategori_id = " . $_POST['kategori'];
            } else {
                $setKategori = '';
            }

            // Search Bar output
            if ($_POST['searchBar'] != "") {
                $setSearch = "nama_product LIKE '%" . $_POST['searchBar'] . "%'";
            } else {
                $setSearch = '';
            }

            // WHERE
            if ($setKategori != '' || $setSearch != '') {
                $where = " WHERE ";
            }

            // AND
            if ($setKategori != '' && $setSearch != '') {
                $and = " AND ";
            }
        }

        $stmt = $mysqli->query("SELECT product_id, gambar, nama_product, harga_satuan, deskripsi, stock_product FROM products " . $where .  $setKategori . $and . $setSearch);
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
                        <div class="modal-footer border-t flex justify-between items-center px-4 py-3">
                            <!-- Quantity Control -->
                            <div class="grid grid-cols-3 items-center">
                                <a href="javascript:void(0);" class="btn btn-danger text-center size-10 minus-btn" data-id="<?= $product['id']; ?>">-</a>
                                <p id="quantity-<?= $product['id']; ?>" class="text-center quantity-display">0</p>
                                <a href="javascript:void(0);" class="btn btn-success text-center size-10 add-btn" data-id="<?= $product['id']; ?>">+</a>
                            </div>

                            <!-- Add to Cart Button -->
                            <button type="button" class="btn btn-primary px-5 py-2 rounded-lg text-sm addCart-btn">Add To Cart</button>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        }
        ?>

    </div>

</body>

</html>