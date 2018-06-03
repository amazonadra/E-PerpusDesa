-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2016 at 05:25 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `nim` varchar(14) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `alamat` varchar(20) NOT NULL,
  `kota` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `no_telp` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`nim`, `nama`, `pass`, `alamat`, `kota`, `email`, `no_telp`) VALUES
('24010314120012', 'Rizki Mutiara S', 'rizki', 'Kendal', 'Kendal', 'rizki@gmail.com', '087812342345'),
('24010314130078', 'Shiva Twinandilla', 'shiva', 'Cilacap', 'Cilacap', 'shiva@gmail.com', '087814654568'),
('24010314130083', 'Tiara Galuh Prahasiwi', 'tiara', 'Purbalingga', 'Purbalingga', 'tiara@gmail.com', '081234563456'),
('24010314130088', 'Luthfi Ahmad Nasher', 'luthfi', 'Perum Korpri', 'Semarang', 'nasher@gmail.com', '087814674568'),
('24010314140087', 'Fauzanil Zaki', 'fauzanil', 'Bekasi', 'Bekasi', 'fauzanil@gmail.com', '087814674567'),
('24010314140123', 'Amazona Adorada', 'amazona', 'Pekalongan', 'Pekalongan', 'amazona@gmail.com', '087814674569');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` varchar(6) NOT NULL,
  `ISBN` varchar(13) NOT NULL,
  `Judul` varchar(20) NOT NULL,
  `id_kategori` varchar(6) NOT NULL,
  `Pengarang` varchar(20) NOT NULL,
  `Penerbit` varchar(20) NOT NULL,
  `kota_terbit` varchar(20) NOT NULL,
  `editor` varchar(20) NOT NULL,
  `file_gambar` varchar(60) NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `stok` int(3) NOT NULL,
  `stok_tersedia` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `ISBN`, `Judul`, `id_kategori`, `Pengarang`, `Penerbit`, `kota_terbit`, `editor`, `file_gambar`, `tgl_update`, `stok`, `stok_tersedia`) VALUES
('B0001', '1-123-12345-1', 'Sunset Rosie', 'K0001', 'Tere Liye', 'Gramedia', 'Jakarta', 'Gramedia', 'sunset.jpg', '2016-12-15 05:39:01', 9, 8),
('B0002', '1-123-12345-2', 'Struktur Data', 'K0002', 'Dwi Sanjaya', 'ITB', 'Bandung', 'ITB dan Kawan-kawan', 'struktur.jpg', '2016-12-16 09:31:29', 3, 4),
('B0003', '1-123-12345-3', 'Nabi Adam Dilahirkan', 'K0005', 'Agus Mustofa', 'Mizan', 'Jakarta', 'Mizan editor', 'nabi.jpg', '2016-12-15 05:40:17', 4, 2),
('B0005', '1-123-12345-5', 'Percepatan Rezeki', 'K0006', 'Ippho Santosa', 'Islamedia', 'Jakarta', 'Nasher Elimran Dkk', 'percepatan.jpg', '2016-12-15 05:41:37', 7, 7),
('B0006', '1-123-12345-6', 'Ngupil Itu Indah', 'K0001', 'Teuku Ridwan', 'Gramedia', 'Jakarta', 'Press Gramedia', 'upil.jpg', '2016-12-15 05:42:02', 7, 7),
('B0007', '1-123-12345-7', 'Laskar Pelangi', 'K0001', 'Andrea Hirata', 'Gema Press', 'Bogor', 'Gema Press', 'laskar.jpg', '2016-12-15 05:42:14', 6, 6),
('B0008', '1-123-12345-8', 'Bulan terbelah D L A', 'K0001', 'Hanum Salsabila', 'Gramedia P', 'Jakarta', 'Gramedia', 'bulan.jpg', '2016-12-15 05:42:32', 6, 6),
('B0009', '1-123-12345-9', 'My Curly Love', 'K0001', 'Guntur Alam', 'Ice Cube Press', 'Surabaya', 'Guntur Alam', 'curly.jpg', '2016-12-15 05:42:50', 8, 7),
('B0010', '1-123-12346-1', 'Enchantrees', 'K0001', 'James Maxwell', 'Saga Press', 'Amsterdam', 'James Maxwell', 'ench.jpg', '2016-12-15 05:43:01', 3, 2),
('B0011', '1-123-12346-2', 'Web Programming', 'K0002', 'Equity Press', 'Equity Press', 'Yogyakarta', 'Equity Press', 'web.jpg', '2016-12-15 05:43:14', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail_transaksi` int(6) NOT NULL,
  `id_buku` varchar(6) NOT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `id_transaksi` int(6) NOT NULL,
  `denda` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail_transaksi`, `id_buku`, `tgl_kembali`, `id_transaksi`, `denda`) VALUES
(13, 'B0004', '2016-12-16', 5, 0),
(14, 'B0002', '2016-12-16', 5, 0),
(15, 'B0002', NULL, 6, 0),
(16, 'B0003', NULL, 6, 0),
(17, 'B0002', '2016-12-14', 7, 0),
(18, 'B0004', '2016-12-14', 7, 0),
(19, 'B0011', NULL, 8, 0),
(20, 'B0009', NULL, 8, 0),
(21, 'B0002', NULL, 9, NULL),
(22, 'B0004', NULL, 9, NULL),
(23, 'B0004', NULL, 10, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` varchar(6) NOT NULL,
  `nama` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama`) VALUES
('K0001', 'Novel'),
('K0002', 'Pelajaran'),
('K0003', 'Majalah'),
('K0004`', 'Politik'),
('K0005', 'Islam'),
('K0006', 'Motivasi');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_transaksi` int(6) NOT NULL,
  `nim` varchar(14) NOT NULL,
  `tgl_pinjam` timestamp NULL DEFAULT NULL,
  `total_denda` decimal(7,0) DEFAULT NULL,
  `id_petugas` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_transaksi`, `nim`, `tgl_pinjam`, `total_denda`, `id_petugas`) VALUES
(5, '24010314130088', '2016-12-14 09:22:26', '0', 'PT002'),
(6, '24010314140123', '2016-12-14 09:22:38', NULL, 'PT002'),
(7, '24010314130083', '2016-12-14 09:22:47', '0', 'PT002'),
(8, '24010314130083', '2016-12-14 10:36:19', NULL, 'PT002'),
(9, '24010314120012', '2016-12-16 00:16:46', NULL, 'admin'),
(10, '24010314130078', '2016-12-16 03:29:54', NULL, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `idpetugas` varchar(6) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `pas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`idpetugas`, `nama`, `pas`) VALUES
('PT001', 'admin01', 'admin01'),
('PT002', 'admin02', 'admin02'),
('PT003', 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`idpetugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail_transaksi` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_transaksi` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
