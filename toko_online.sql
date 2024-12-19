-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2024 at 07:22 AM
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
(17, '2024-12-19', 0, 3, 0, 'Pending');

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
(16, 2, 16, 2);

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
(1, 'https://jasindo.co.id/uploads/media/lvqceq27yqgfrux4qxahhdqor-beraspng', 'Beras 5kg', 72500, 'Beras putih premium 5kg', 15, 1),
(2, 'https://dk4fkkwa4o9l0.cloudfront.net/production/uploads/article/image/1061/Tanpa_judul__1920_x_1080_px___1920_x_1080_px___1080_x_1920_px___1920_x_1080_px___8_.jpg', 'Minyak Goreng 1L', 25000, 'Minyak goreng premium yang melewati proses pemurnian', 19, 1),
(3, 'https://cdn1-production-images-kly.akamaized.net/6owxF4qupsKGTdeWri1-hD-UURc=/1200x675/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/1295184/original/070904600_1469165488-sabun_cuci_piring_2_copy.jpg', 'Sabun Cuci Piring 650ml', 18800, 'Sabun cuci piring / pembersih alat dapur', 100, 2),
(4, 'https://asset.kompas.com/crops/afdljRaqodyDXZ7tHTQCTwmuMvc=/0x0:1000x667/1200x800/data/photo/2024/02/22/65d6e36c6faa2.jpg', 'Wajan', 250000, 'Wajan anti lengket high quality', 9, 3),
(5, 'https://tokokadounik.com/assets/images/produk/spatula_stainless_steel_set_6_in_1_sodet_sutil_alat_masak_dapur_stainless_ec803a228b.jpg', 'Spatula Set 6 in 1', 180000, 'Spatula stainless steel set 6 in 1 peralatan dapur stainless', 15, 3),
(23, 'https://awsimages.detik.net.id/community/media/visual/2022/01/27/mie-telur-1.jpeg?w=687', 'Mie Telor Asli', 6500, 'mie telor asli', 6, 1),
(24, 'data:image/jpeg;base64,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', 'spons cuci piring', 2000, 'spons cuci piring', 19, 2),
(25, 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxISEhUTEhMWFRUXFxUVFhcYGBUVFxUVFRUWFxUXFRUYHSggGBolGxUVITEhJSkrLi4uFx8zODMsNygtLisBCgoKDg0OGxAQGy0fICYrLS0tNSstLS0tLS0tLS0tLS0tLS0tLi0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0vLf/AABEIALcBEwMBIgACEQEDEQH/xAAbAAEAAgIDAAAAAAAAAAAAAAAAAwQFBgECB//EAEAQAAIBAgMEBwUDDAEFAAAAAAABAgMRBCExBQYSQRNRYXGBkaEiMkKxwVJykhQVIzNDYoKistHh8AcWU3PC8f/EABoBAQADAQEBAAAAAAAAAAAAAAABAgUDBAb/xAAlEQACAwACAgEEAwEAAAAAAAAAAQIDEQQhEjETIkFRYQUUMnH/2gAMAwEAAhEDEQA/APcQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAcNlDE7YpQ+K5hd49su7pwemvearVqtngv5ig8iaHH4XmvKRvS3jpXLuH2nTnpI804iSliZR0Zxhz5fdHef8AHxzpnqaZyadsXeFpqM3dG3Uqikk07pmjXbGa1GbbTKt4zuADocgAQ1sVCOrIbS9kpN+iYGPe16fWS0toU5aMqrIv7lnXJfYtg4TOS5QAAAAAAAAAAAAAAAAAAAEWIrKEXJ8iG87YS0V8RGCu2Y6rthLRGJxWJlNtsqSZm2cyTf0mjXxI59RnPz0T0trrmjVpzOkKzbsrtvRLN+RWPLmdHxIYb3RxEZaMlNZwWGqqzk1Dvd35Iy/5V7NuLPrt9Lnvhbq+pYeCyrH9L0nxOLhDV+Bjqm3Y5pa2k/JN/Qx+P2fOecasX2NOPqrmtVlUpVLTTWUlfVO8Wsmsjy28myL9dHrp41cl71kMcTxSberbOJsxMMRmWFXMfybNnwz0W0zs4lWNUswmdIFJIik7G2bo7Yu+jk9dO81KqzphcU6c1Jcmd6rXXNM43Uq2DR7ACvgMQqlOM18ST/uS1qnDFt8k35G4nq0+fax4YvbW1VT9lP2vkariMdKT1MbitpOrVk2+bJFIxuRyHOTS9G1Rx1XFb7JulfWcxxEloyJM7umcYtnZpGa2Rt5xaUs0bbSqKSTTumeYTVjZN1NqO/RyeT07z38bkPfGR4OVxlnnE24AGiZoAAAAAAAAAAAAAAAMTvFUtTS638jLGL3hp3pp9T+Zxv343h1oz5FprnS5FatXsda07GJxld6LV6d5hNs3IR0vYdyrT4YZfak9Ir/eRmqdanQVoa85c34/Qx2Fp9FBQWus31y5+C0IqrZ0U/jXXsrKPm/0XKm0ZPmR/lsuspo78JCtkyfjii7DHsrY6qpqzzIGiKcy7teYyI1pPUartKTpTs9Hmn2f3OlLGXJ9643pX5xaa8XZ/P0NSo4t3tz0S632HKFXktR63Zns3CGJRco4gx2zdhYuaT6JwT+2+H+V5ryMqt28UtFB9il/dIuqpIo7Ifk4q17labOMTh6tJ2qwlHqusn3S0ZC6hSSe9l4410eo7iYjjwqT+GUo/X6mS2/U4cNVfVBnnu7e3JUKTUXlxN/Iy+I3oVejUpStecJRT0s3FpPzsatXIj4KL94Y93En8rkl1pomCxN3czdKtc0zBV7PPIz2HxJjTfZsuOozkJl2nPIwlOsWqdcvXLDhOBZrEdCo4yTWTTR1dS4R0T71Fc6w9PwlXjhGXWkyYx278r0Idz+bMibsXsUz5+ayTQABYqAAAAAAAAAAAACLEUVOLi+aJQQ1oTw8+2pRcG4vVGJwavWjfleX4U2vWxum+NGHRp2k6jfDCMIynKfX7MU3Za30XiecbJ2lF4mMb68cPFxaXrZGRbQ4T/Rs0XecP2bLRqCrJFZOzOXI8TbPUkSwLMY5FGEybp8jrBpIiSYqlOvI71axidpYzhi3fRM5y7fR0riYbeHEOf6KGc55Jepnt1NmUsKuPhUqzWdRq9utQXwr1fPs1HdyTrVZVnzbjHuWv+9hvmGirHRydf0oiSUlparbSkQfnOa5kdVEdOncqrJt+x4Rz0ZKntfiTjUSlF6ppNNeJre3NmuMlLDq8JOzi3+rfa+cfUvV6ViHpWi8rW1kiI1+L2JZ2Ps6EYpVVxLmruKu9c1n6mwU6GESyw9PxjxPzldmCo10WY1ya7HE5WR8nrZzjdiYSbbVKKb+yuHPvjYxGJ2Ao/q5Ndjd156mY6X0/wAeZy2RLJeyYylH7mpznKm+Gat8n3EtPFmbx2HjUjwyX+DTsbejUdOT7U+uL0ZRQ/B2+RP2Z2GLLFHGx5uxgMPieLJFvDbJlUk1Vl0ULNptq8pZZKOtrXzOsK22c7JxitZ7RsWnw0Ka/dT/ABZ/UvGvblO1Hg6TpHG13ZrK1lrrozYTbh/lHz8/9MAAsVAAAAAAAAAAAAAAANS/5HVdYWc6GUnCVOTV1JRm4uXC1pfhtfLU8+3c3QoL8nnHETUJKTqNJq1VP2OjUoXsmrPm9dD2ypBNNNXTyaejRou8G6cqbdXDSaj8UNVZfu816nntjL2uz0VTWZ6Ke0qSjJpSjLmnF5NPmvXyKDqkcsS1lUgpLL2lrpn3dyZSxGGhPOnXnT61JKSXXrmn4syrK9eo1KrkljLVfGRjqyrLaaehWeAknfo41f3uN1G+1wbgo+CYliFHKVKnHvhb5zKqll/7EfwdqmOyzZq+8+1bx6OLzlr2I2Go6c/2cZfdck/KE38jEYrYOFm+JutTb/ei15VIp+p1qqUZbIid+rEd93IqEIpckjbaOIyNdw2ChBezV/FFx9VdGRpUZtZOLt9l3b7kcbK5OTZ0VsM9mUdVHanVSepgq9Zx96NRdrhKK/FaxDHaMev+aJMaZIh3wNixFZMx1aoipTxafK/jcljFSWcJp9n+UWdEmwuRBEuHrlynWMV01GHvSkuxtfREdTbOHWkvORb4ZFHdFmxUqpZ4l1mubIxUqz4opKnpx3bvbXh0v36GzUMXTp+7FX+08358vAKKXTY7faRG8NUl7sJNd1l5sx20t054hxc/Z4bpWlFOzte+T6jIYjbc3zKktpTvqIzri9RLrskvwR4XdSpSdqcF2zc4uWnL7K7k2yfdzZ1atWVPonRXvVHJNT4L8287vS17Zkf50mnk2X9nb0VKb1yO0La97ONlFmddno2EwsKUVCEVGK0SJjG7G2tDERvF+0tV/YyRqRaa1GRKLi8fsAAkqAAAAAAAAAAAAAAADg5ABoe9e6s5ucoOSUrtSh70G9VKPxx7LM0LF4erCpB1YvhSs6kU3C0eOTu45xu400792Z7ya5vPsF1IyqUElVWdvd6TsutJdTd119a8tlOdxPRC77SPLsPsnFS6RxlxunO1RJRqRT1vFx9pQa0locVK1eCzjJrX2W2vLM4rbwyw9R36SlN+xK6UZR7JWcW1fvRHRxa/Zwt2LiS/DeS9Dyzj9z1QlnsxuJ2tSv7cHdfuwb9cyShtaNS6pttrW/Hku13t4EmO27RWWIpq378Kn/tBLyEZ4RZRXR3z9mVuXU2uWYS69FnIjnjLO3DFvnklJ9bbja3y73kTQrvJ8Li+XtSat2OcXEo8GCas8Q83d/pKbu/myWhgcLHONWp4SX0iW9ELsyNHHTXu9M88+CdGfpHhsSPHOSzdZ/epRn8pFWnGj11Zd74vmidyl8HH3Nxfo3ZByYSRVxOJpL9ZHxlh7GP/ADzhdIyp3/8AHOPyRk57SxMdMPKXdKKv4QkQ1tuTt7eGqR71GS/mTLLQ2ipHG/o3Ny1zybSs27WXckY7ZaliqzjKP6NZyu28uSTT1f0ZW2jtNTeVO38EI/0pGe3PhanxWs5Nvydl8vUpbJwg2XpSnNI2uhGySSskkklkklokiRwK8atjs65m6aOHE0dFkHUI+Ij0XO6jciq0y1QYrpF0uhvZ12NtWdCpGSeSefauZ7BhMQqkIzjpJJrxPEKiPUdwKzlhEn8MpR8Mn9TQ4Fj1xZm/yVSxTRsgANMxwAAAAAAAAAAAAAAAAAAAADA70buU8VB/DUS9mVotO3KUZZNduq6zxzaeCrYZtdEpK/KOS8IpWfdme+YqgqkJQlfhlFxdnZ2as7NaHmm2tw/yXDynSnUrcLcnGVnK1rWhd+Z57ofdI71T+zPPltx5xkqkfvJ8D7LTTt4srzxNGXvxinnrTgr36mpNO5fhhlO0lT4G9WvZta+U41EvDVdhBUwVZPWlw99n4OLcX6Hn2J6OzGVKmFX7K61vGjxItYWvRkrQuuzoXFeby9SS6TtKcV1Z28uJ+iuKNON7dKnL7MmvRLhLPMC0iqzjHPoG+28Uv5eIqzx9d/qqUZfx1JW8lAydbC1l+rhSf438lKxHCnXSl0s4J8owvf8Aiadv91IT/wCEtGJlV2i88qS7XBL+dtlStUxXxV4y+6lL1jAs4vEvif6N5fHp5Z/QxmJrd/q352R2W/o5No7Vela9599pI2rc6s+i4ZO8otp53ybuvn6GjOa/+3+pe2JtN0KvE23B5SWvc1bmv7lbqnOGHSi5QnrPT3UOqqFGjik0nFppq6a5o7dKZDgzZjJNFx1DmMyrx8jiNQq4l00ZCFQ7TqFFVB0pIJpM9V3Kwrp4SF9ZXn4PT0SNB3V2HLFVVdNU4tOb7OpdrPWoQSSSVklZLqSNLhVNfUzJ/kbk8gjsADRMoAAAAAAAAAAAAAAAAAAAAAGD2nKU/ZlZLqT+ZmK07JsxFSNysiUa/iNiUp+9GLfck/MxON3MoT14v6v6rm5cB1cTl4I6KbNDe5CXu1Zrs9lrysdHudNaVpeVvk0jfnSRx0SI+Nfgn5ZHndXdKs8nWk11f7IqPcmrnarU5/E7dnM9PcOw44F1EqCQ+RnkVfcCo3d1JN99yjW/4+n1t+J7S6COrw66i2EeZ4dLcWa+EilulKPwnujwq6iOWBi+SHZPkjxTC7Oq0cle3Vy8OouSqNapo9ZnsmD+FeRVr7uUpawRynUpezvVyHD0eWwxavkzu8Ub9iNzqEr3poqf9DYf/to5f1ketc39Gq7Po1qztSpzqfdjKXm0rI3fd/cGrJqWJfRx+wmpTfe1lH1LOyt3lR/VylD7smvkbZg8XOKtJ8Xfr5l4caCes43c2bWR6MhgsHCjBQpxUYrRL5vrZYI6VZS0JD1pZ6M5tt9gAEkAAAAAAAAAAAAAAAAAAA61Jpaic7Ip1Z8T7ADrXrORWcSebR0sVBDwjhJrAAh4TjoyawsCSLgHASgAi4UccCJbCwIIuA54TuIgHCgOAksLEFyLo0cdCiYWAIlSR2UDuADmnKzujI0qnErmNLGCnnYsiGXQASVAAAAAAAAAAAAAAAAAAKmIqXdkQsAgHU4AIBydQABYWABIsAADhiwAIOGEwADuDgAsDg5AJOLnIABw2TYT3kACDIAAsVAAAAAAP//Z', 'Telur Ayam Kampung', 2500, 'Telur ayam kampung fresh', 25, 1);

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
  MODIFY `checkout_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `detailcheckout`
--
ALTER TABLE `detailcheckout`
  MODIFY `detail_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
