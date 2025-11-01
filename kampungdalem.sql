-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2025 at 07:20 AM
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
-- Database: `kampungdalem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `pass`) VALUES
(1, 'admin', '$2y$10$ErMBfTOapfS1BazB4qbFhuB7uLPQGxIp0KKwJalulHDyiNdJ1df6q');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_penduduk`
--

CREATE TABLE `data_penduduk` (
  `id` int(11) NOT NULL,
  `total_penduduk` int(11) NOT NULL,
  `total_balita` int(11) NOT NULL,
  `total_lansia` int(11) NOT NULL,
  `total_ibu_hamil` int(11) NOT NULL,
  `total_laki` int(11) NOT NULL,
  `total_perempuan` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `data_tahun` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_penduduk`
--

INSERT INTO `data_penduduk` (`id`, `total_penduduk`, `total_balita`, `total_lansia`, `total_ibu_hamil`, `total_laki`, `total_perempuan`, `updated_at`, `data_tahun`) VALUES
(1, 3000, 296, 0, 32, 1446, 1401, '2025-02-18 00:39:41', '2023'),
(2, 2850, 296, 2, 33, 1447, 1402, '2025-02-15 04:42:32', '2024'),
(3, 0, 0, 0, 0, 0, 0, '2025-02-15 04:30:53', '2025');

-- --------------------------------------------------------

--
-- Table structure for table `demografi`
--

CREATE TABLE `demografi` (
  `id` int(11) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `laki_laki` int(11) NOT NULL DEFAULT 0,
  `perempuan` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL DEFAULT 0,
  `kepala_keluarga` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `demografi`
--

INSERT INTO `demografi` (`id`, `kategori`, `jumlah`, `laki_laki`, `perempuan`, `total`, `kepala_keluarga`) VALUES
(1, NULL, NULL, 1442, 121, 121, 121);

-- --------------------------------------------------------

--
-- Table structure for table `ekonomi_masyarakat`
--

CREATE TABLE `ekonomi_masyarakat` (
  `id` int(11) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ekonomi_masyarakat`
--

INSERT INTO `ekonomi_masyarakat` (`id`, `kategori`, `jumlah`) VALUES
(1, 'Pengangguran', 12),
(2, 'Prasejahtera', 183),
(3, 'Sejahtera 1', 358),
(4, 'Sejahtera 2', 243),
(5, 'Sejahtera 3 Plus', 58);

-- --------------------------------------------------------

--
-- Table structure for table `isian`
--

CREATE TABLE `isian` (
  `id_isian` int(11) NOT NULL,
  `id_berita` int(11) NOT NULL,
  `judul_isian` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kader_posyandu`
--

CREATE TABLE `kader_posyandu` (
  `id` int(11) NOT NULL,
  `posyandu_id` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `no_wa` varchar(15) DEFAULT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `karang_taruna`
--

CREATE TABLE `karang_taruna` (
  `id` int(11) NOT NULL,
  `lkk_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `linmas`
--

CREATE TABLE `linmas` (
  `id` int(11) NOT NULL,
  `lkk_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lkk`
--

CREATE TABLE `lkk` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lkk`
--

INSERT INTO `lkk` (`id`, `nama`, `foto`) VALUES
(1, 'LPMK', 'lpmk.png'),
(2, 'RT', 'rt.png'),
(3, 'RW', 'rw.png'),
(4, 'PKK', 'pkk.png'),
(5, 'Posyandu', 'posyandu.png'),
(6, 'Karang Taruna', 'Karang_Taruna.png'),
(7, 'LINMAS', 'linmas.png');

-- --------------------------------------------------------

--
-- Table structure for table `lpmk`
--

CREATE TABLE `lpmk` (
  `id` int(11) NOT NULL,
  `lkk_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lpmk`
--

INSERT INTO `lpmk` (`id`, `lkk_id`, `nama`, `alamat`, `jabatan`, `no_hp`, `foto`) VALUES
(1, 1, 'coba lpmk', 'asda', 'coba', '1232', 'Avanza-2017.webp');

-- --------------------------------------------------------

--
-- Table structure for table `pejabat`
--

CREATE TABLE `pejabat` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `jabatan` varchar(50) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pejabat`
--

INSERT INTO `pejabat` (`id`, `nama`, `deskripsi`, `jabatan`, `foto`) VALUES
(1, 'Bapak Ika Ardiyanto, SE, MSA', 'Kepala Kelurahan Kampungdalem', 'Lurah', 'b aja.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `perangkat`
--

CREATE TABLE `perangkat` (
  `id` int(11) NOT NULL,
  `foto` varchar(99) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `no_hp` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perangkat`
--

INSERT INTO `perangkat` (`id`, `foto`, `nama`, `alamat`, `jabatan`, `no_hp`) VALUES
(1, '2.jpg', 'bpk yusuf', 'da', 'sds', 2147483647),
(4, '6.jpg', 'asdasd', 'adasdas', 'adada', 98765432);

-- --------------------------------------------------------

--
-- Table structure for table `pkk`
--

CREATE TABLE `pkk` (
  `id` int(11) NOT NULL,
  `lkk_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posyandu`
--

CREATE TABLE `posyandu` (
  `id` int(11) NOT NULL,
  `nama_posyandu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posyandu`
--

INSERT INTO `posyandu` (`id`, `nama_posyandu`) VALUES
(1, 'Tomat'),
(2, 'Anggrek'),
(3, 'Kesemek'),
(4, 'Srigading');

-- --------------------------------------------------------

--
-- Table structure for table `posyandubr`
--

CREATE TABLE `posyandubr` (
  `id` int(11) NOT NULL,
  `lkk_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt`
--

CREATE TABLE `rt` (
  `id` int(11) NOT NULL,
  `lkk_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rw`
--

CREATE TABLE `rw` (
  `id` int(11) NOT NULL,
  `lkk_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `data_penduduk`
--
ALTER TABLE `data_penduduk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demografi`
--
ALTER TABLE `demografi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ekonomi_masyarakat`
--
ALTER TABLE `ekonomi_masyarakat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `isian`
--
ALTER TABLE `isian`
  ADD PRIMARY KEY (`id_isian`),
  ADD KEY `id_berita` (`id_berita`);

--
-- Indexes for table `kader_posyandu`
--
ALTER TABLE `kader_posyandu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posyandu_id` (`posyandu_id`);

--
-- Indexes for table `karang_taruna`
--
ALTER TABLE `karang_taruna`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lkk_id` (`lkk_id`);

--
-- Indexes for table `linmas`
--
ALTER TABLE `linmas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lkk_id` (`lkk_id`);

--
-- Indexes for table `lkk`
--
ALTER TABLE `lkk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lpmk`
--
ALTER TABLE `lpmk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lkk_id` (`lkk_id`);

--
-- Indexes for table `pejabat`
--
ALTER TABLE `pejabat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perangkat`
--
ALTER TABLE `perangkat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pkk`
--
ALTER TABLE `pkk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lkk_id` (`lkk_id`);

--
-- Indexes for table `posyandu`
--
ALTER TABLE `posyandu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posyandubr`
--
ALTER TABLE `posyandubr`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lkk_id` (`lkk_id`);

--
-- Indexes for table `rt`
--
ALTER TABLE `rt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lkk_id` (`lkk_id`);

--
-- Indexes for table `rw`
--
ALTER TABLE `rw`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lkk_id` (`lkk_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_penduduk`
--
ALTER TABLE `data_penduduk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `demografi`
--
ALTER TABLE `demografi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ekonomi_masyarakat`
--
ALTER TABLE `ekonomi_masyarakat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `isian`
--
ALTER TABLE `isian`
  MODIFY `id_isian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kader_posyandu`
--
ALTER TABLE `kader_posyandu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karang_taruna`
--
ALTER TABLE `karang_taruna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `linmas`
--
ALTER TABLE `linmas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lkk`
--
ALTER TABLE `lkk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lpmk`
--
ALTER TABLE `lpmk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pejabat`
--
ALTER TABLE `pejabat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `perangkat`
--
ALTER TABLE `perangkat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pkk`
--
ALTER TABLE `pkk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posyandu`
--
ALTER TABLE `posyandu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posyandubr`
--
ALTER TABLE `posyandubr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt`
--
ALTER TABLE `rt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rw`
--
ALTER TABLE `rw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `isian`
--
ALTER TABLE `isian`
  ADD CONSTRAINT `isian_ibfk_1` FOREIGN KEY (`id_berita`) REFERENCES `berita` (`id_berita`) ON DELETE CASCADE;

--
-- Constraints for table `kader_posyandu`
--
ALTER TABLE `kader_posyandu`
  ADD CONSTRAINT `kader_posyandu_ibfk_1` FOREIGN KEY (`posyandu_id`) REFERENCES `posyandu` (`id`);

--
-- Constraints for table `lpmk`
--
ALTER TABLE `lpmk`
  ADD CONSTRAINT `lpmk_ibfk_1` FOREIGN KEY (`lkk_id`) REFERENCES `lkk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rw`
--
ALTER TABLE `rw`
  ADD CONSTRAINT `rw_ibfk_1` FOREIGN KEY (`lkk_id`) REFERENCES `lkk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
