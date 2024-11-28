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

    <!-- Search Item TODO: belum ada function (template tok) -->
    <div class="m-3">
        <form class="flex items-center bg-gray-100 rounded-lg shadow-md px-4 py-2 space-x-3" method="post">
            <!-- Category Dropdown -->
            <div class="flex items-center space-x-2 pr-3">
                <label class="font-medium text-gray-600" for="kategori">Kategori: </label>
                <select class="border-none bg-transparent rounded-lg focus:outline-none text-gray-700" id="kategori">
                    <option selected>All</option>
                    <option value="1">Electronics</option>
                    <option value="2">Clothing</option>
                    <option value="3">Accessories</option>
                </select>
            </div>

            <!-- Vertical Line (Partial Height) -->
            <div class="h-8 border-r-2 border-gray-300 mx-3"></div>

            <!-- Search Bar -->
            <input class="flex-grow bg-transparent rounded-lg focus:outline-none placeholder-gray-400 text-gray-700" type="search" placeholder="Search for items..." aria-label="Search">

            <!-- Search Button -->
            <button class="bg-yellow-400 font-bold text-black px-5 py-2 rounded-lg" type="submit">
                <p class="hover:text-white hover:font-bold">Search</p>
            </button>
        </form>
    </div>


    <!-- item list TODO: belum ada function (template tok) -->
    <div class=" m-3 grid grid-cols-4 gap-3">

        <!-- item -->
        <a href="" data-bs-toggle="modal" data-bs-target="#itemModal">
            <div class="card shadow-md hover:shadow-2xl">
                <img class="card-img-top" src="https://jasindo.co.id/uploads/media/lvqceq27yqgfrux4qxahhdqor-beraspng" alt="Card image cap">
                <div class="card-body p-4 rounded-md bg-white">
                    <h5 class="card-title text-lg font-semibold text-gray-800">Nama Product</h5>
                    <p class="card-text font-bold text-lg text-green-600">Rp. 0</p>
                </div>
            </div>
        </a>

        <!-- item Modal -->
        <div class="modal fade " id="itemModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
                <div class="modal-content rounded-md shadow-lg ">
                    <div class="modal-header border-b">
                        <h5 class="modal-title text-xl font-bold text-gray-800">Product Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                        <!-- Image Section -->
                        <div class="flex justify-center">
                            <img class="rounded-lg shadow-md size-fit" src="https://jasindo.co.id/uploads/media/lvqceq27yqgfrux4qxahhdqor-beraspng" alt="Product image">
                        </div>
                        <!-- Details Section -->
                        <div class="space-y-3">
                            <p class="text-lg font-semibold text-gray-800">Product Name</p>
                            <p class="text-lg text-green-500 font-bold">Rp. 0</p>
                            <p class="py-2 text-sm text-black text-justify">Beras putih premium 5kg</p>
                            <p class="text-sm text-black font-medium">Stock: </p>
                        </div>
                    </div>
                    <div class="modal-footer border-t flex justify-between items-center px-4 py-3">
                        <!-- Quantity Control -->
                        <div class=" grid grid-cols-3 items-center">
                            <a id="minus" class="btn btn-danger text-center size-10">-</a>
                            <p id="quantity" class="text-center">0</p>
                            <a id="add" class="btn btn-success text-center size-10">+</a>
                        </div>

                        <!-- Add to Cart Button -->
                        <button type="button" class="btn btn-primary px-5 py-2 rounded-lg text-sm">Add To Cart</button>
                    </div>
                </div>
            </div>
        </div>


    </div>

</body>

</html>