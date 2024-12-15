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
                            <th class="px-4 py-3">User ID</th>
                            <th class="px-4 py-3">Username</th>
                            <th class="px-4 py-3 text-left">Items</th>
                            <th class="px-5 py-3">Total Price</th>
                            <th class="px-4 py-3">Payment Type</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-center">

                        <?php
                        $stmt = $mysqli->query("SELECT c.checkout_id, c.date, c.user_id, u.username, c.total_harga, p.payment_method, c.status
                        FROM checkout c
                        JOIN users u ON c.user_id = u.user_id
                        JOIN payment p ON c.payment_id = p.payment_id;");
                        while ($row = $stmt->fetch_assoc()) {

                            // checkout data
                            $checkout = [
                                'id' => htmlentities($row['checkout_id']),
                                'date' => htmlentities($row['date']),
                                'user_id' => htmlentities($row['user_id']),
                                'username' => htmlentities($row['username']),
                                'total_harga' => htmlentities($row['total_harga']),
                                'payment_type' => htmlentities($row['payment_method']),
                                'status' => htmlentities($row['status'])
                            ];
                        ?>
                            <!-- display attribut checkout -->
                            <tr class="bg-gray-50 hover:bg-gradient-to-r from-gray-50 to-gray-200 transition-colors duration-300">
                                <td class="px-4 py-3"><?= $checkout['id']; ?></td>
                                <td class="px-4 py-3"><?= $checkout['date']; ?></td>
                                <td class="px-4 py-3"><?= $checkout['user_id']; ?></td>
                                <td class="px-4 py-3 font-semibold text-blue-600"><?= $checkout['username']; ?></td>
                                <td class="px-4 py-3">
                                    <ul class="list-disc pl-5 text-left">

                                        <?php
                                        // item-item yang ada di dalam checkout
                                        $stmt_detail = $mysqli->prepare("SELECT d.detail_id, p.nama_product, d.jumlah_product, p.harga_satuan
                                                 FROM detailcheckout d
                                                 JOIN products p ON d.product_id = p.product_id
                                                 WHERE d.checkout_id = ?");
                                        $stmt_detail->bind_param("i", $checkout['id']);
                                        $stmt_detail->execute();
                                        $result_detail = $stmt_detail->get_result();

                                        // display item nya
                                        while ($row_detail = $result_detail->fetch_assoc()) {
                                            $totalSatuan = $row_detail['jumlah_product'] * $row_detail['harga_satuan'];
                                            echo '<li>' . $row_detail['nama_product'] . ' (' . $row_detail['jumlah_product'] . ' x Rp. ' . number_format($row_detail['harga_satuan'], 0, ',', '.') . ') = Rp. ' . number_format($totalSatuan, 0, ',', '.') . '</li>';
                                        }
                                        ?>

                                    </ul>
                                </td>
                                <td class="px-4 py-3 font-semibold text-green-600">Rp. <?= number_format($checkout['total_harga'], 0, ',', '.'); ?></td>
                                <td class="px-4 py-3"><?= $checkout['payment_type']; ?></td>
                                <td class="px-4 py-3">

                                    <!-- Pending / Completed -->
                                    <?php
                                    if ($checkout['status'] == "Pending") {
                                        echo '<span class="px-2 py-1 bg-yellow-300 text-yellow-700 text-xs font-medium rounded-full">' . $checkout['status'] . '</span>';
                                    } else {
                                        echo '<span class="px-2 py-1 bg-green-300 text-green-700 text-xs font-medium rounded-full">' . $checkout['status'] . '</span>';
                                    }
                                    ?>
                                </td>
                            </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>



        </div>
    </section>

</body>

</html>