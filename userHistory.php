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
    <?php include 'nav.php'; ?>

    <section>
        <div class="container mx-auto py-6">
            <h1 class="text-center text-2xl font-bold mb-4 text-gray-800">User Transaction History</h1>

            <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm text-left border border-gray-300 shadow-lg rounded-lg">
                    <thead class="bg-gradient-to-r from-gray-600 to-black text-yellow-400 text-center">
                        <tr>
                            <th class="px-2 py-3">Date</th>
                            <th class="px-4 py-3 text-left">Items</th>
                            <th class="px-5 py-3">Total Price</th>
                            <th class="px-4 py-3">Payment Type</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-center">

                        <?php
                        // data checkout untuk user ini
                        $stmt = $mysqli->query("SELECT c.checkout_id, c.date, c.total_harga, p.payment_method, c.status
                                                FROM checkout c
                                                JOIN users u ON c.user_id = u.user_id
                                                JOIN payment p ON c.payment_id = p.payment_id
                                                WHERE c.user_id = " . $_SESSION['user_id'] . "
                                                ORDER BY c.date DESC, c.checkout_id DESC ");
                        while ($row = $stmt->fetch_assoc()) {

                            $checkout = [
                                'id' => htmlentities($row['checkout_id']),
                                'date' => htmlentities($row['date']),
                                'total_harga' => htmlentities($row['total_harga']),
                                'payment_type' => htmlentities($row['payment_method']),
                                'status' => htmlentities($row['status'])
                            ];
                        ?>

                            <!-- display attribut checkout -->
                            <tr class="bg-gray-50 hover:bg-gradient-to-r from-gray-50 to-gray-200 transition-colors duration-300">
                                <td class="px-4 py-3"><?= $checkout['date']; ?></td>
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
                                        $haveItem = 0;

                                        // display item info nya
                                        while ($row_detail = $result_detail->fetch_assoc()) {
                                            $haveItem = 1;
                                            $totalSatuan = $row_detail['jumlah_product'] * $row_detail['harga_satuan'];
                                            echo '<li>' . $row_detail['nama_product'] . ' (' . $row_detail['jumlah_product'] . ' x Rp. ' . number_format($row_detail['harga_satuan'], 0, ',', '.') . ') = Rp. ' . number_format($totalSatuan, 0, ',', '.') . '</li>';
                                        }

                                        if ($haveItem == 0) {
                                            echo '-';
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