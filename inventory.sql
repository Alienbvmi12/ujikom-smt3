-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Des 2022 pada 14.16
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `kode_barang` int(4) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `kode_kategori` varchar(5) NOT NULL,
  `stok` int(4) NOT NULL,
  `tanggal_diubah` varchar(35) NOT NULL,
  `merk` varchar(35) NOT NULL,
  `sumber` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`kode_barang`, `nama_barang`, `kode_kategori`, `stok`, `tanggal_diubah`, `merk`, `sumber`) VALUES
(1, 'Pemotong PCB', 'ALT02', 3, '30 November 2022 01:34:15 PM', 'Tomcat', 'Partai Perindo'),
(2, 'Solder pump', 'ALT01', 21, '30 November 2022 07:35:28 PM', 'Us army', 'Toko elektronik katapang'),
(4, 'Resistor', 'ALT01', 23, '30 November 2022 07:29:25 PM', 'Analog', 'Cherry lampu'),
(5, 'Penyedot timah', 'ALT01', 30, '30 November 2022 07:34:02 PM', 'Sony', 'Toko perkakas LD'),
(6, 'Cutter', 'ALT01', 50, '30 November 2022 07:35:14 PM', 'Joyko', 'Mr Fotokopi'),
(7, 'Tang jepit', 'ALT01', 42, '30 November 2022 07:44:41 PM', 'Camel', 'Toserba borma'),
(8, 'Mata bor', 'ALT01', 30, '1 December 2022 02:09:33 PM', 'Ikea', 'Ikea store'),
(9, 'Terminal', 'ALT01', 40, '1 December 2022 02:10:49 PM', 'KO', 'Kelistrikan mas'),
(11, 'Tang potong', 'ALT01', 45, '1 December 2022 06:35:15 PM', 'vssv', 'Perkakas makmur jaya'),
(12, 'Stop Kontak', 'ALT01', 67, 'Thu Dec 01 14:16:52 WIB 2022', 'Philips', 'Banu elektronika'),
(13, 'Obeng', 'ALT01', 70, 'Thu Dec 01 14:17:57 WIB 2022', 'Camel', 'Toserba borma'),
(14, 'AVO', 'ALT01', 36, 'Thu Dec 01 14:18:40 WIB 2022', 'US Army', 'Cherry lampu'),
(15, 'Adaptor', 'ALT01', 56, 'Thu Dec 01 14:19:27 WIB 2022', 'Joyko', 'PT Pindad'),
(16, 'Solder', 'ALT01', 20, '1 December 2022 07:39:01 PM', 'Metal work', 'Toserba borma'),
(17, 'Las', 'ALT02', 41, 'Thu Dec 01 14:22:41 WIB 2022', '7Eleven', 'Toserba samudra'),
(18, 'Compressor', 'ALT02', 14, '1 December 2022 08:04:02 PM', 'Quincy', 'PT Pindad'),
(19, 'Pneumatik', 'ALT02', 6, 'Thu Dec 01 14:24:58 WIB 2022', 'Len', 'Atlas logistic'),
(22, 'Mesin bor', 'ALT01', 5, 'Thu Dec 01 17:33:57 WIB 2022', 'Hanura', 'Tulungagung mech'),
(23, 'Mesin bubut', 'ALT02', 2, 'Thu Dec 01 17:33:57 WIB 2022', 'Bansos', 'PT. Pindad');

-- --------------------------------------------------------

--
-- Struktur dari tabel `histori`
--

CREATE TABLE `histori` (
  `no_histori` int(4) NOT NULL,
  `tanggal` varchar(35) NOT NULL,
  `tindakan` varchar(25) NOT NULL,
  `deskripsi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `no` int(3) NOT NULL,
  `kode_kategori` varchar(5) NOT NULL,
  `jenis_kategori` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`no`, `kode_kategori`, `jenis_kategori`) VALUES
(1, 'ALT01', 'Alat Ringan'),
(2, 'ALT02', 'Alat Berat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status`
--

CREATE TABLE `status` (
  `no_aksi` int(4) NOT NULL,
  `username` varchar(25) NOT NULL,
  `barang` int(5) NOT NULL,
  `quantity` int(4) NOT NULL,
  `tanggal` varchar(35) NOT NULL,
  `status` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `status`
--

INSERT INTO `status` (`no_aksi`, `username`, `barang`, `quantity`, `tanggal`, `status`) VALUES
(63, 'Siswa', 7, 1, '1 December 2022 08:02:13 PM', 'Sudah kembali');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(5) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(40) NOT NULL,
  `role` varchar(6) NOT NULL,
  `pp` varchar(100) NOT NULL,
  `email` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `pp`, `email`) VALUES
(1, 'Admin', 'e9fd363bedc114628fe2cdce1493db15', 'admin', 'pp/6388a5630f9c4.jpg', 'email@example.nekat'),
(2, 'Siswa', '5b531aeba7f0d44d95c8e552774acf66', 'user', 'pp/6388a65903202.jpg', 'email@example.nekat'),
(6, 'Admin', 'admin java', 'admin', 'pp/6388a5630f9c4.jpg', 'email@example.nekat'),
(7, 'siswa2', '5b531aeba7f0d44d95c8e552774acf66', 'user', 'pp/basic.png', 'elektro1ktp@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode_barang`),
  ADD KEY `kode_kategori` (`kode_kategori`);

--
-- Indeks untuk tabel `histori`
--
ALTER TABLE `histori`
  ADD PRIMARY KEY (`no_histori`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`no`),
  ADD UNIQUE KEY `kode_kategori` (`kode_kategori`);

--
-- Indeks untuk tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`no_aksi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `kode_barang` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `histori`
--
ALTER TABLE `histori`
  MODIFY `no_histori` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `no` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `status`
--
ALTER TABLE `status`
  MODIFY `no_aksi` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`kode_kategori`) REFERENCES `kategori` (`kode_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
