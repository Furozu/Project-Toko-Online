-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2025 at 07:36 AM
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
(1, '2024-12-19', 142300, 2, 3, 'Completed'),
(14, '2024-12-19', 322500, 2, 2, 'Completed'),
(15, '2024-12-19', 0, 2, 0, 'Pending'),
(16, '2024-12-19', 62500, 3, 3, 'Completed'),
(17, '2024-12-19', 0, 3, 0, 'Pending'),
(20, '2024-12-19', 6000, 35, 1, 'Completed'),
(21, '2024-12-19', 188500, 35, 2, 'Completed'),
(22, '2024-12-19', 224500, 35, 2, 'Completed'),
(23, '2025-01-03', 72500, 35, 1, 'Completed'),
(24, '2025-01-03', 40000, 35, 1, 'Completed'),
(25, '2025-01-03', 0, 35, 0, 'Pending');

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
(3, 24, 1, 2),
(4, 23, 1, 4),
(6, 3, 1, 1),
(7, 2, 1, 1),
(9, 1, 1, 1),
(13, 1, 14, 1),
(14, 4, 14, 1),
(15, 25, 16, 5),
(16, 2, 16, 2),
(35, 24, 20, 3),
(36, 5, 21, 1),
(37, 23, 21, 1),
(38, 24, 21, 1),
(39, 5, 22, 1),
(40, 23, 22, 1),
(41, 24, 22, 19),
(44, 1, 23, 1),
(46, 24, 24, 20);

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
(0, '-'),
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
(1, 'https://jasindo.co.id/uploads/media/lvqceq27yqgfrux4qxahhdqor-beraspng', 'Beras 5kg', 72500, 'Beras putih premium 5kg', 999998, 1),
(2, 'https://dk4fkkwa4o9l0.cloudfront.net/production/uploads/article/image/1061/Tanpa_judul__1920_x_1080_px___1920_x_1080_px___1080_x_1920_px___1920_x_1080_px___8_.jpg', 'Minyak Goreng 1L', 25000, 'Minyak goreng premium yang melewati proses pemurnian', 99999, 1),
(3, 'https://cdn1-production-images-kly.akamaized.net/6owxF4qupsKGTdeWri1-hD-UURc=/1200x675/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/1295184/original/070904600_1469165488-sabun_cuci_piring_2_copy.jpg', 'Sabun Cuci Piring 650ml', 0, 'Sabun cuci piring / pembersih alat dapur', 0, 2),
(4, 'https://asset.kompas.com/crops/afdljRaqodyDXZ7tHTQCTwmuMvc=/0x0:1000x667/1200x800/data/photo/2024/02/22/65d6e36c6faa2.jpg', 'Wajan', 250000, 'Wajan anti lengket high quality', 0, 3),
(5, 'https://tokokadounik.com/assets/images/produk/spatula_stainless_steel_set_6_in_1_sodet_sutil_alat_masak_dapur_stainless_ec803a228b.jpg', 'Spatula Set 6 in 1', 180000, 'Spatula stainless steel set 6 in 1 peralatan dapur stainless', 21, 3),
(23, 'https://awsimages.detik.net.id/community/media/visual/2022/01/27/mie-telur-1.jpeg?w=687', 'Mie Telor Asli', 6500, 'mie telor asli', 12, 1),
(24, 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxITEhUTEhMWFhUVGBcXFRYVFRgYFhUVFhcWGBYYFxUYHSggGBolGxcTITEhJykrLi4uGB8zODMtNygtLisBCgoKDg0OGhAQGy0gHx0tLS0tMi0tKy0uLS0tLS0tLS0tLS0tLS0tLS0tLS0tKy0tLS0rLS0tLTUtLS0tLS4tLf/AABEIAOEA4QMBIgACEQEDEQH/xAAcAAEAAQUBAQAAAAAAAAAAAAAAAgEDBQYHBAj/xAA2EAACAQIEBAQEBQQCAwAAAAAAAQIDEQQFITFBUWFxBhKB8CKRobEHEzLB4UJS0fFiojNygv/EABoBAQACAwEAAAAAAAAAAAAAAAABAgMEBQb/xAApEQEAAgICAgECBQUAAAAAAAAAAQIDEQQhEjEFQXETIlFhgSMyQqHB/9oADAMBAAIRAxEAPwDuIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFqviIwi5TlGMVu5NJL1YF0pc5/4k/FfB4fzRo3r1Ft5f/HfrPj6HKPE3jvGY1/HU8kOFOm3GPrrdstFWK2Wseu30vcqfL+S+LMXhpXpVpLg0/iTV9rSTR0nIPxdg0o4mnJyvrOHlSS0t8L3e48f0VrnrPvp1cGMyjPsNiVehVjPmk/iXeL1RkrlWaJifSoACQAAAAAAAAAAAAAAAAAAAAAAZ48wzSjQi51qkIRSu3KSWnbdhEzp7Dy5hmFKhB1K1SNOC3lNpL67s5b4q/GGKThgI+Z6r86orJdYQ3l627HKs1zfEYmXmr1Z1H/ybsu0dl6F4r+rDbNEenXfEP4xUoXjg6TqS4TqfDT46pJ+Z/Q5b4h8UYrGTcq9RyWloJ2hHtH9zEJkvL2J9emva8z7W022S8qJSQi13Cm1Yx5WJxRSKJxj1JV2u4fFVIO8Jyi+Di2mjePDX4lYnDu1VutB/0z0kuqla/ozQo9Wt/kXIxfPQfdHlMdxLuuU/ihhatlKE4Sb0XwtW73XyNvy/NaNZJ0qkZXV7Jq67rdHy5F7dOB78BmdWk706koPnF2ZHjEsscm8e+31AmVOG5J+JGLoq05fmq+qml5rX2T04c7nQ8i/EDC19JP8AJellNrW/JorNZbFOTS3vpt4LVKtGSvFprmndFwqzxO1QAEgAAAAAAAAAAHjzPM6OHg6lepGnBf1SdlfkubPYab+K2USxOX1FH9VOUKi7Rfxf9WxH7otvXTUPFn4t+aMqeATjw/Omtf8A4h+7+RyXG4upVm51ZyqSf9U5Nvnx23JSi4txkrP/AF/kjUpcTJExrppWtO/zLSfQlfmU48SsYBSU3FFVw+5FS2+pPz/z2CqcbcSVkQjL6fySJVlJIla5TT/JLv6BVSy99CsFzFv9IqokiTXuxJdiijstP3LkVdhXZGV+Bcg2uJCS+ZWPzCNs3lPiLE0Gvy6jja/Z33unubvk34nyStXh59viTUWr76bNI5em+vcuU5W99P4C9b2r6l9CZb4qwlZXjVS1taTSd3sZqMr7HzJTrd/exm8q8WYmg7wqu1reV6x5J+V+hXwhs05Vv8ofQQOcZJ+J0JRtXg/Mv6qdrWtyb3N4yzN6NdJ0qkZXV7J/Eu8d0Vmsw2aZqW9PeACrKAAAAABbxFJSjKL2kmn2asUr4iMFeTsaznHjClTTUdWByvxBk8HUnTkr2lJX46PgzVMfktSndw+OK4f1G6ZlmCq1ZTX9TLMbM5E8i+G8xHpmthreO3P3Z2XHrw9BbizcsyyanVV/0y/uW77mrYvBVaLtNXjb9SXw/wCzo4OXTJ92hl49qPP5en1JJc/oThFPZ8rfuQa66fQ22qmlbt3JxS6dizB24rf7kpS36hEwvun19L2KKlbjw7/IhTnrwXT+eZVy626rclTtWF9U9e/YlJ23srFU+Sfe5KHKWln6P2whJ1FZffiJ6rS5SKS05+mpJd7emr+QQo6jW6W2li9CWlwpLr9/vsG+O+/buFZVUl74ko+nBq3Dci4rp9ysGrry9glJy57FVb3qRcmtLFVO3BoJhOMrHswmNnTalTbi1qmnZp8zwqXHX37Z6KFO9uA3paIdV8BeKsRXnGlV+PTWTS8ysr3bXDht6nQkaF+GWRTpKVeomvMvLCL38t7uTtz00N+MPlW3dXSw1tFfzAADKFus3bQuADQ/Es6rvuc7zSnO7udwzDL4zWxpOdeH97L6FbbTDlsJyi9T30MSZDMMqavoYarh3F6HOz4dztsUsy9OpcnOmmmmk1tqYihiWtzI0cRc51q2pLL1LDZp4dbl56MlHi420bVtvoYPEUakHarFr/lbn2N+jUIYnCRnHyySaf2NzDzr06t21MvFrbuHP6dNWbTXf7fcJ3tf6cjM5nkMqd6lHZauHTpz1uYiMk1dq3D3fY6+LPTJG4c3JhtSe0fLxV/V6FyMdPT3+xDy2tq3fr66Eox7X6++hmhilcSu+/X3biUpytqtLrXzXLNWD4PXnq7di5TXC93wY2jS9CfVfcldbLj16FlR5JLXV9GX1Tj298yVJjSu19b24Rb9sk9tF793IQjbS3r8v4LiSvZ/f3YKynCouP8Av9yr5JbFqmlrz3/zv6lyUvfC2nPjqE6Sb3T+d/ehKC9u9+AjJO/Hjbr05now9C68z/Txfbgglbw9HjfTT6nQfCfhhtxrV01b9NNpbp6Sl9dCPhTw4p2q1oaRd6UJbf8AtJcX0fU6Dg6OqR5v5L5ObW/Awz76mXX4vE8Y/EyfxDK4SnaKRfKIqdrFSKUisfSFpnc7AAZEAAAFjEYZSWqL4A1HOMiTu0jSc0yhxvodinBMw2Z5QpLRFLUiVolxLF4G3A8cZSj2Oh5vkbV9DVsZl9uBp5MMSy1u8eHxVz306tzC1sM4vQlQxVnZnPy4JjuGWLbZ9NGPzDKKdVK+lm/02WrVuCJ4fEnshNMwVvbHO4TasWjtp+PyapSd4LzQ34XXS3yMZ+V5ls7322+V+p0Rw9++5jM0yaFVO2k7aS6u2/P+TpYPkfpdoZuHvurT1T10+XDuQm9+XVnrxWBrUv1Qur2ve8bLbVa/PqWpQT2533s7dzrUyVvG4lzrUtSdWQ8uuml9tvuXItvjsttNF3ZD8vZ306bIqm97X2t1/cttSV6Fra8NOFm7Elfh69N/4LDm7a6dePy5E93bzX3739Cdo0vNt8V9uHBcivlT0tftr77FmNPZa8uevtHrwtFt3ellfrbn0GzSVKC31SjZu3pbvfY6D4Z8M+ZxrV4bawg+F9nJc7a27ch4R8MpJVaqu3ZxjfRJx0bX93zRvFGFjy/yvy3vFin7y7PD4fj+e/v6LlGnZHvy63mfRHiim35Yq7ZmcLh1BWW+7fNmp8Rwb5ckZreo/wBtrPeIjS+AD1zTAAAAAAAACjRUAeLGYGM1sajnGR72RvZarUVJakTESOM5hlbXAwOKwh2PNslTTsjS8zydq+hgviZIs0WMpR7Huw+KuenF4C3AxlSg1sc/LgiWat2bpVrl5SMDQxTTSehkqGIuaF8c1ZInb1VaSas1dcbmCzPw7dudLSWra4O1kklw2+hn4TLiVxj5F8U7iVL4a3jUuf1oShdVYNb2fldnr8ufve1Uu9dbaO64G+47LoVVacdO7XLin2NXzPI6tNuVP44p33s0lrqulvU7PH+Qrk6t1LmZuHNe6sLRtdxbu+F1px6bk7p6aO1+OxJpSlZ3i3bfT198y/8Ak8XbRay00S9pHR207dSrg6UvNu7cbrRO2lvm/qdE8JeHvM/zqkbR3p05LhfScr7vS6XqeTwf4c/M8tWrFflrWnGSfxXdvNLbSyVls7379EoU+R5v5b5XxicOKfvP/HV4XD1/Uv8AwnSh79+hdWr8sdW+BRb2Wr5GYwGDUFd/qe/+Dk/G8C3Kv5W/tj238uTxj90sDhFBc5Pd/suh6gge0pStKxWsaiGhMzPcgALoAAAAAAAAAAAAAFJRuYrMMrUlsZYAc5zbJbX0NWx2XW4HZsThFJbGr5tku9kYr49rRLlGJwh5otx7G45jlbXAwOKwbRpZMO2WtlvDYy5kKVcwVSi1sXaGLadmc7Lx5hnrZscXcueW/v5GNw2JMlQnc0bxNWWI2xuZ+H6db4rKM/7tr9+um/3L/hfwlr5q135ZLyLa/laan8L2ur26djNUIXNgwFOyQt8hlpjmkSxzxsc28ph6KNK1uC+rLjlbRbvQhUqW/wALd9EZfKsA4/HP9T2X9q/ya3B4F+Xk3Pr6yvkyRSF3LsF5VeX6n9Oh70Ae2xYq4qRSkaiHOtabTuQAGRAAAAAAAAAAAAAAAAAAABCpTT3JgDA5nlClfQ0/M8oa4HTWjw4zL1LgVtWJWiXHsVl7MVXwh07M8k30NYxuWNcDVviZa2alByizKYHFoYjBu543h2tt0c/Nx/JnrfTbsvqJmyxnaK9+9zQ8oxtpJSZ03JMuvarUXWMX9G0cynx98uXx+n1Zr5a1rtfynL3pUqLX+mPLq+v2MwED1ODBTDSKUjqHNvabTuQAGZUAAAAAAAAAAAAAAAAAAAAAAAAAAFqrQUjC5hlKeyM+UaImNpiXOsdk/QxE8pb4HUa+BUjywyeN7tFJxRK3m1Pw74TUpRnUWiaaXNra50FEaVJRVkiZatYr6VmdgALIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAB//9k=', 'spons cuci piring', 2000, 'spons cuci piring', 0, 2),
(25, 'data:image/jpeg;base64,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', 'Telur Ayam Kampung', 2500, 'Telur ayam kampung fresh', 20, 1),
(29, 'data:image/jpeg;base64,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', 'gula 1kg', 17000, 'gula putih kristal murni', 20, 1);

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
(2, 'Joseph', '123', 1876543210, 'joseph@email.com', 'Surabaya, Jalan To Iron', 0),
(3, 'Fendii', '4321', 2134543234, 'fendii@email.com', 'Surabaya, jalan HOH 2', 0),
(4, 'Sean', '12345', 1783456921, 'sean@email.com', 'Jakarta, Jalan Ketiduran', 0),
(35, 'Nathan', '1234', 1122334455, 'nathan@email.com', 'xczc', 0);

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
  MODIFY `checkout_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `detailcheckout`
--
ALTER TABLE `detailcheckout`
  MODIFY `detail_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `payment_id_fk` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`payment_id`),
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

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
