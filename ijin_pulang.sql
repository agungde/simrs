-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Des 2023 pada 06.10
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simrs`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ijin_pulang`
--

CREATE TABLE `ijin_pulang` (
  `id` int(11) NOT NULL,
  `id_daftar` bigint(55) NOT NULL,
  `id_transaksi` bigint(55) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `nama_pasien` varchar(255) NOT NULL,
  `no_rekam_medis` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `dokter` varchar(155) NOT NULL,
  `keterangan` longtext NOT NULL,
  `ttd` varchar(255) NOT NULL,
  `kamar_kelas` varchar(55) NOT NULL,
  `nama_kamar` varchar(155) NOT NULL,
  `no_kamar` varchar(55) NOT NULL,
  `no_ranjang` varchar(55) NOT NULL,
  `kontrol` varchar(55) NOT NULL,
  `tanggal_kontrol` date DEFAULT NULL,
  `poli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ijin_pulang`
--
ALTER TABLE `ijin_pulang`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `ijin_pulang`
--
ALTER TABLE `ijin_pulang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
