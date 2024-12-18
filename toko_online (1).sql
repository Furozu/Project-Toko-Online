-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 01:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `checkout`
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
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`checkout_id`, `date`, `total_harga`, `user_id`, `payment_id`, `status`) VALUES
(1, '0000-00-00', 195000, 2, 1, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `detailcheckout`
--

CREATE TABLE `detailcheckout` (
  `detail_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `checkout_id` int(10) NOT NULL,
  `jumlah_product` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detailcheckout`
--

INSERT INTO `detailcheckout` (`detail_id`, `product_id`, `checkout_id`, `jumlah_product`) VALUES
(1, 1, 1, 2),
(2, 2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(10) NOT NULL,
  `nama_kategori` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `nama_kategori`) VALUES
(1, 'Makanan'),
(2, 'Kebersihan'),
(3, 'Alat');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `payment_method` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `payment_method`) VALUES
(1, 'Qris'),
(2, 'Kredit'),
(3, 'Debit');

-- --------------------------------------------------------

--
-- Table structure for table `products`
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
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `gambar`, `nama_product`, `harga_satuan`, `deskripsi`, `stock_product`, `kategori_id`) VALUES
(1, 'https://jasindo.co.id/uploads/media/lvqceq27yqgfrux4qxahhdqor-beraspng', 'Beras 5kg', 72500, 'Beras putih premium 5kg', 25, 1),
(2, 'https://dk4fkkwa4o9l0.cloudfront.net/production/uploads/article/image/1061/Tanpa_judul__1920_x_1080_px___1920_x_1080_px___1080_x_1920_px___1920_x_1080_px___8_.jpg', 'Minyak Goreng 1L', 25000, 'Minyak goreng premium yang melewati proses pemurnian', 80, 1),
(3, 'https://cdn1-production-images-kly.akamaized.net/6owxF4qupsKGTdeWri1-hD-UURc=/1200x675/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/1295184/original/070904600_1469165488-sabun_cuci_piring_2_copy.jpg', 'Sabun Cuci Piring 650ml', 18800, 'Sabun cuci piring / pembersih alat dapur', 40, 2),
(4, 'https://asset.kompas.com/crops/afdljRaqodyDXZ7tHTQCTwmuMvc=/0x0:1000x667/1200x800/data/photo/2024/02/22/65d6e36c6faa2.jpg', 'Wajan', 250000, 'Wajan anti lengket high quality', 10, 3),
(5, 'https://tokokadounik.com/assets/images/produk/spatula_stainless_steel_set_6_in_1_sodet_sutil_alat_masak_dapur_stainless_ec803a228b.jpg', 'Spatula Set 6 in 1', 180000, 'Spatula stainless steel set 6 in 1 peralatan dapur stainless', 15, 3),
(23, 'https://awsimages.detik.net.id/community/media/visual/2022/01/27/mie-telur-1.jpeg?w=687', 'Mie Telor Asli', 5500, 'mie telor asli', 10, 1),
(24, 'data:image/jpeg;base64,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', 'spons cuci piring', 2000, 'spons cuci piring', 21, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
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
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`checkout_id`),
  ADD KEY `payment_id_fk` (`payment_id`),
  ADD KEY `user_id_fk` (`user_id`);

--
-- Indexes for table `detailcheckout`
--
ALTER TABLE `detailcheckout`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `product_id_fk` (`product_id`),
  ADD KEY `checkout_id_fk` (`checkout_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `checkout_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detailcheckout`
--
ALTER TABLE `detailcheckout`
  MODIFY `detail_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `payment_id_fk` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`payment_id`),
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `detailcheckout`
--
ALTER TABLE `detailcheckout`
  ADD CONSTRAINT `checkout_id_fk` FOREIGN KEY (`checkout_id`) REFERENCES `checkout` (`checkout_id`),
  ADD CONSTRAINT `product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `kategori_id` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`kategori_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
