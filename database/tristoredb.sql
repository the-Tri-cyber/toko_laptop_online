-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 10:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tristoredb`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_barang_masuk` int(11) NOT NULL,
  `id_laptop` int(11) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `tanggal_masuk` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_laptop` int(11) NOT NULL,
  `nama_laptop` varchar(100) NOT NULL,
  `processor` varchar(50) NOT NULL,
  `ram` varchar(50) NOT NULL,
  `rom` varchar(50) NOT NULL,
  `gpu` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` double NOT NULL,
  `laptop_terjual` int(11) DEFAULT NULL,
  `stok` int(11) NOT NULL,
  `terakhir_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `foto` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_laptop`, `nama_laptop`, `processor`, `ram`, `rom`, `gpu`, `deskripsi`, `harga`, `laptop_terjual`, `stok`, `terakhir_update`, `foto`) VALUES
(1, 'axioo hype 1', 'Intel Celeron n4020', '4gb DDR4', '256gb SSD', 'Intel Graphics Card UHD 600', 'laptop buatan indonesia baru dengan seri hype 1 yang sangat kuat untuk kegiatan sehari-hari.', 2999000, 4, 7, '2025-04-19 02:49:45', 'https://axiooworld.com/uploads/products/8c068afc-75b1-4b63-ab49-60355433c303.png?h=176&w=286&s=4263dc160566fd8fc1bee87063ccbf87'),
(2, 'axioo hype 3', 'Intel Core i3-1215U', '12GB LPDDR5', '512GB SSD', 'Intel® Iris® Xe Graphics', 'Hype R FHD hadir dengan bodi yang tipis dan ringan yang mudah dibawa ke manapun. Laptop ini dapat menjalankan berbagai aplikasi dan software dengan lancar, serta mampu menangani tugas-tugas berat seperti pengeditan foto atau video ringan.', 5999000, 2, 3, '2025-04-21 07:46:37', 'https://axiooworld.com/uploads/products/b48de343-f9b9-4544-912b-6e8e65cdf6a7.png?h=176&w=286&s=17c5de3b3b73d5be431798d57b486be5'),
(4, 'axio hype 5 AMD x3', 'AMD Ryzen™ 5-3500U', '8GB DDR4', '256GB SSD', 'AMD Radeon VEGA 8 ZEN+', 'Hype 5 AMD X3 menghadirkan performa tinggi dengan prosesor AMD Ryzen 5, dilengkapi desain yang stylish dan fitur yang menawarkan banyak keuntungan untuk pelajar.', 4999000, 4, 9, '2025-04-21 08:11:16', 'https://axiooworld.com/uploads/products/8c068afc-75b1-4b63-ab49-60355433c303.png?h=176&w=286&s=4263dc160566fd8fc1bee87063ccbf87');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_laptop` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_penerima` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` double NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_laptop`, `id_user`, `nama_penerima`, `email`, `telepon`, `alamat`, `jumlah`, `harga`, `metode_pembayaran`, `tanggal`) VALUES
(14, 2, 2, 'ahmad tri fauzi y', 'asdfsadf@adfasf', '08954', 'segug, kedalon, kalikajar, wonosobo', 2, 11998000, 'COD', '2025-04-21 14:46:37');

--
-- Triggers `transaksi`
--
DELIMITER $$
CREATE TRIGGER `after_insert_transaksi` AFTER INSERT ON `transaksi` FOR EACH ROW BEGIN
    UPDATE produk
    SET 
        stok = stok - NEW.jumlah,
        laptop_terjual = laptop_terjual + NEW.jumlah
    WHERE id_laptop = NEW.id_laptop;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tanggal_daftar` datetime DEFAULT current_timestamp(),
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `telepon`, `alamat`, `tanggal_daftar`, `role`) VALUES
(1, 'tri', 'tri@gmail.com', '$2y$10$EJCbDBxov1wLOFo2AiSQKe5fXv4dsT2.AaEDM/toIMM5U1TOrL7nC', '0987', 'adsff', '2025-04-17 10:26:39', 'admin'),
(2, 'fauzi', 'fauzi@gmail.com', '$2y$10$EJCbDBxov1wLOFo2AiSQKe5fXv4dsT2.AaEDM/toIMM5U1TOrL7nC', '0831', 'LARANGAN', '2025-04-17 10:58:12', 'user'),
(3, 'ahmad', 'ahmad@gmail.com', '$2y$10$mIcIeRnzuiz4zA..TYKSyuvOXrXLVheXagox1x5f1itJXVr7OGP7y', '0895', 'segug', '2025-04-18 09:45:45', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`),
  ADD KEY `id_laptop` (`id_laptop`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_laptop`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_laptop` (`id_laptop`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_barang_masuk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_laptop` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `hub_id_laptop` FOREIGN KEY (`id_laptop`) REFERENCES `produk` (`id_laptop`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
