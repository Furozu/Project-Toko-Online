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

    <section>
        <div class="container mx-auto py-6">
            <h1 class="text-center text-2xl font-bold mb-4 text-gray-800">Transaction History</h1>

            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm text-left border border-gray-300 shadow-lg rounded-lg">
                    <thead class="bg-gradient-to-r from-gray-600 to-black text-yellow-400 text-center">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-2 py-3">Date of Payment</th>
                            <th class="px-4 py-3 text-left">Items</th>
                            <th class="px-5 py-3">Total Price</th>
                            <th class="px-4 py-3">Payment Type</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-center">

                        <!-- TEST -->
                        <tr class="bg-gray-50">
                            <td class="px-4 py-3">ID</td>
                            <td class="px-4 py-3">Date</td>
                            <td class="px-4 py-3">
                                <ul class="list-disc pl-5 text-left">
                                    <li>Item C (3 x $8) = $24</li>
                                    <li>Item D (1 x $25) = $25</li>
                                </ul>
                            </td>
                            <td class="px-4 py-3 font-semibold text-green-600">$49</td>
                            <td class="px-4 py-3">PaymentType</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 bg-green-300 text-green-700 text-xs font-medium rounded-full">Completed</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>



        </div>
    </section>

</body>

</html>