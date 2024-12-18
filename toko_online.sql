-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Des 2024 pada 15.11
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko online`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `checkout`
--

CREATE TABLE `checkout` (
  `checkout_id` int(10) NOT NULL,
  `date` date NOT NULL,
  `total_harga` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `payment_id` int(10) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `checkout`
--

INSERT INTO `checkout` (`checkout_id`, `date`, `total_harga`, `user_id`, `payment_id`, `status`) VALUES
(1, '0000-00-00', 195000, 2, 1, 'Pending'),
(6, '2024-12-18', 618800, 3, 3, 'Completed'),
(7, '2024-12-18', 412500, 3, 0, 'Pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detailcheckout`
--

CREATE TABLE `detailcheckout` (
  `detail_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `checkout_id` int(10) NOT NULL,
  `jumlah_product` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detailcheckout`
--

INSERT INTO `detailcheckout` (`detail_id`, `product_id`, `checkout_id`, `jumlah_product`) VALUES
(1, 1, 1, 2),
(2, 2, 1, 2),
(3, 4, 6, 1),
(4, 5, 6, 1),
(5, 1, 6, 2),
(6, 2, 6, 1),
(7, 3, 6, 1),
(8, 1, 7, 5),
(9, 2, 7, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(10) NOT NULL,
  `nama_kategori` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `nama_kategori`) VALUES
(1, 'Makanan'),
(2, 'Kebersihan'),
(3, 'Alat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `payment_method` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `payment`
--

INSERT INTO `payment` (`payment_id`, `payment_method`) VALUES
(0, '-'),
(1, 'Qris'),
(2, 'Kredit'),
(3, 'Debit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `product_id` int(10) NOT NULL,
  `gambar` text NOT NULL,
  `nama_product` text NOT NULL,
  `harga_satuan` int(10) NOT NULL,
  `deskripsi` text NOT NULL,
  `stock_product` int(10) NOT NULL,
  `kategori_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`product_id`, `gambar`, `nama_product`, `harga_satuan`, `deskripsi`, `stock_product`, `kategori_id`) VALUES
(1, 'https://jasindo.co.id/uploads/media/lvqceq27yqgfrux4qxahhdqor-beraspng', 'Beras 5kg', 72500, 'Beras putih premium 5kg', 18, 1),
(2, 'https://dk4fkkwa4o9l0.cloudfront.net/production/uploads/article/image/1061/Tanpa_judul__1920_x_1080_px___1920_x_1080_px___1080_x_1920_px___1920_x_1080_px___8_.jpg', 'Minyak Goreng 1L', 25000, 'Minyak goreng premium yang melewati proses pemurnian', 77, 1),
(3, 'https://cdn1-production-images-kly.akamaized.net/6owxF4qupsKGTdeWri1-hD-UURc=/1200x675/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/1295184/original/070904600_1469165488-sabun_cuci_piring_2_copy.jpg', 'Sabun Cuci Piring 650ml', 18800, 'Sabun cuci piring / pembersih alat dapur', 39, 2),
(4, 'https://asset.kompas.com/crops/afdljRaqodyDXZ7tHTQCTwmuMvc=/0x0:1000x667/1200x800/data/photo/2024/02/22/65d6e36c6faa2.jpg', 'Wajan', 250000, 'Wajan anti lengket high quality', 9, 3),
(5, 'https://tokokadounik.com/assets/images/produk/spatula_stainless_steel_set_6_in_1_sodet_sutil_alat_masak_dapur_stainless_ec803a228b.jpg', 'Spatula Set 6 in 1', 180000, 'Spatula stainless steel set 6 in 1 peralatan dapur stainless', 14, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `user_telp` int(15) NOT NULL,
  `email` text NOT NULL,
  `alamat` text NOT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `user_telp`, `email`, `alamat`, `isAdmin`) VALUES
(1, 'Admin', 'admin123', 1234567890, 'admin123@email.com', 'Surabaya, Jalan TekWeb 5A', 1),
(2, 'Joseph', '123', 1876543210, 'joseph@email.com', 'Surabaya, Jalan To Iron1', 0),
(3, 'Fendi', '321', 2147483647, 'fendi@email.com', 'Surabaya, Jalan HOH', 0),
(4, 'Sean', '12345', 1783456921, 'sean@email.com', 'Jakarta, Jalan Ketiduran', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`checkout_id`),
  ADD KEY `payment_id_fk` (`payment_id`),
  ADD KEY `user_id_fk` (`user_id`);

--
-- Indeks untuk tabel `detailcheckout`
--
ALTER TABLE `detailcheckout`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `product_id_fk` (`product_id`),
  ADD KEY `checkout_id_fk` (`checkout_id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indeks untuk tabel `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `checkout`
--
ALTER TABLE `checkout`
  MODIFY `checkout_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `detailcheckout`
--
ALTER TABLE `detailcheckout`
  MODIFY `detail_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `payment_id_fk` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`payment_id`),
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `detailcheckout`
--
ALTER TABLE `detailcheckout`
  ADD CONSTRAINT `checkout_id_fk` FOREIGN KEY (`checkout_id`) REFERENCES `checkout` (`checkout_id`),
  ADD CONSTRAINT `product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `kategori_id` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`kategori_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
