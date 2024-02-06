-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2023 at 07:09 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `id_userlogin` bigint(55) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `nama` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `username` varchar(55) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email_status` varchar(55) DEFAULT NULL,
  `password_expire_date` datetime DEFAULT NULL,
  `password_reset_key` varchar(255) DEFAULT NULL,
  `user_role_id` int(11) NOT NULL,
  `admin_poli` int(11) DEFAULT NULL,
  `login_session_key` varchar(255) DEFAULT NULL,
  `operator` int(11) NOT NULL,
  `setatus` varchar(55) NOT NULL,
  `chat` varchar(55) NOT NULL,
  `device` varchar(55) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL,
  `last_login` varchar(55) NOT NULL,
  `no_ktp` bigint(17) NOT NULL,
  `admin_ranap` int(11) NOT NULL,
  `admin_ranap_perina` int(11) NOT NULL,
  `admin_ranap_anak` int(11) NOT NULL,
  `admin_ranap_bersalin` int(11) NOT NULL,
  `loket` int(2) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`id_userlogin`, `id_dokter`, `nama`, `email`, `username`, `password`, `email_status`, `password_expire_date`, `password_reset_key`, `user_role_id`, `admin_poli`, `login_session_key`, `operator`, `setatus`, `chat`, `device`, `date_created`, `date_updated`, `last_login`, `no_ktp`, `admin_ranap`, `admin_ranap_perina`, `admin_ranap_anak`, `admin_ranap_bersalin`, `loket`, `photo`) VALUES
(0, 0, 'System', '', '', '', '', '0000-00-00 00:00:00', NULL, 1, 0, '', 0, 'Offline', 'Offline', '', '0000-00-00 00:00:00', NULL, '', 0, 0, 0, 0, 0, 0, ''),
(19, 0, 'Medic Admin', 'admin@gmail.com', 'medicadmin', '$2y$10$1KSeh41XeYuA7j/dD.YayOe1lSTDRWWdP1Kegsqc/HvYUhkwXDgFK', 'verified', '2025-10-08 00:00:00', NULL, 1, 0, '0f0320a86bbfb5762e1b2aa445702814', 0, 'Online', 'Online', 'Desktop', '2023-03-13 22:08:03', '2023-05-17 23:26:21', '2023-12-30 07:02:33', 0, 0, 0, 0, 0, 0, ''),
(73, 6, 'DR Agung', 'dragung@rsiategal.com', 'dragung', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 3, NULL, NULL, 19, '', '', '', '2023-09-20 11:58:00', NULL, '', 0, 0, 0, 0, 0, 0, ''),
(74, 5, 'DR Aji', 'draji@rsiategal.com', 'draji', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 3, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-09-20 11:58:00', NULL, '2023-12-29 03:53:41', 0, 0, 0, 0, 0, 0, ''),
(75, 9, 'DR Axel', 'draxel@rsiategal.com', 'draxel', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 3, NULL, NULL, 19, '', '', '', '2023-09-20 11:58:00', NULL, '', 0, 0, 0, 0, 0, 0, ''),
(76, 7, 'DR Zahra', 'drzahra@rsiategal.com', 'drzahra', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 3, NULL, NULL, 19, '', '', '', '2023-09-20 11:58:00', NULL, '', 0, 0, 0, 0, 0, 0, ''),
(77, 8, 'DR Harmanto', 'drhatmanto@rsiategal.com', 'drhatmanto', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 3, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-09-20 11:58:00', NULL, '2023-11-26 15:52:33', 0, 0, 0, 0, 0, 0, ''),
(78, 9, 'DR Zulfa', 'drzulfa@rsiategal.com', 'drzulfa', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 3, NULL, NULL, 19, '', '', '', '2023-09-20 11:58:00', NULL, '', 0, 0, 0, 0, 0, 0, ''),
(79, 0, 'Kasir1', 'kasir1@rsiategal.com', 'kasir1', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 7, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-09-20 11:58:00', NULL, '2023-12-29 14:40:15', 0, 0, 0, 0, 0, 0, ''),
(80, 0, 'Pendaftaran IGD', 'daftarigd@rsiategal.com', 'daftarigd', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 15, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-09-20 11:58:00', NULL, '2023-12-20 20:17:18', 0, 0, 0, 0, 0, 0, ''),
(81, 0, 'Pendaftaran Poli', 'daftarpoli@rsiategal.com', 'daftarpoli', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 12, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-09-20 11:58:00', NULL, '2023-12-29 02:51:28', 0, 0, 0, 0, 0, 0, ''),
(82, 0, 'Farmasi', 'farmasi@rsiategal.com', 'farmasi', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 5, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-09-20 11:58:00', NULL, '2023-12-14 15:27:47', 0, 0, 0, 0, 0, 0, ''),
(83, 0, 'Kasir2', 'kasir2@rsiategal.com', 'kasir2', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 7, NULL, NULL, 19, 'Offline', 'Offline', '', '2023-09-20 11:58:00', NULL, '', 0, 0, 0, 0, 0, 0, ''),
(84, 0, 'Pendaftaran RANAP', 'ranap@rsiategal.com', 'ranap', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 16, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-09-20 11:58:00', NULL, '2023-12-20 20:57:05', 0, 0, 0, 0, 0, 0, ''),
(85, 0, 'Rekam Medis', 'rm@rsiategal.com', 'rm', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 14, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-09-20 11:58:00', NULL, '2023-11-13 12:00:20', 0, 0, 0, 0, 0, 0, ''),
(86, 11, 'DR Silvi', 'drsilvi@rsiategal.com', 'drsilvi', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 3, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-09-20 11:58:00', NULL, '2023-11-26 13:47:21', 0, 0, 0, 0, 0, 0, ''),
(87, 0, 'Pendaftaran', 'pendaftaran@rsiategal.com', 'pendaftaran', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 16, 0, NULL, 19, 'Online', 'Online', 'Desktop', '2023-09-20 11:58:00', '2023-12-20 20:58:32', '2023-12-29 14:57:13', 0, 0, 0, 0, 0, 0, ''),
(88, 0, 'userlab', 'userlab@rsiategal.com', 'userlab', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 18, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-09-20 11:58:00', NULL, '2023-12-29 10:08:35', 0, 0, 0, 0, 0, 0, ''),
(89, 0, 'Pendaftaran Poli 2', 'daftarpoli2@rsiategal.com', 'daftarpoli2', '$2y$10$apWiW6imP4BMuCVbi2y/3uzz1gCKERPjIclN55cAaU3oMv.9wrLcC', 'verified', NULL, NULL, 12, 0, NULL, 19, 'Offline', 'Offline', '', '2023-09-20 11:58:00', '2023-12-05 14:17:16', '', 0, 0, 0, 0, 0, 1, ''),
(90, 0, 'Admin Poli Kandungan', 'admkandungan@rsiategal.com', 'admkandungan', '$2y$10$YlvjxOR39J4Vq.8qULB2v.r8POySWfRhBoz2aZGAGk/5A2gSv3ryK', 'verified', NULL, NULL, 6, 104, NULL, 19, 'Online', 'Online', 'Desktop', '2023-11-01 10:29:42', NULL, '2023-12-29 02:53:54', 0, 0, 0, 0, 0, 0, ''),
(91, 0, 'Admin IGD', 'adminigd@rsiategal.com', 'adminigd', '$2y$10$U8oDUJ7Uu8/sT0JgYazxO.UqXEyompfGZZimV8kfeqtXpIjMbPQPm', 'verified', NULL, NULL, 8, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-11-01 10:34:17', NULL, '2023-12-29 10:16:21', 0, 0, 0, 0, 0, 0, ''),
(92, 0, 'Admin Ranap', 'ranapmawar@rsiategal.com', 'ranapmawar', '$2y$10$HRwDhSXKDg5Ig1w3YHU3qeGJb9jO5AmZtwncxEXOd9tYWMYu5Q8HG', 'verified', NULL, NULL, 13, 0, NULL, 19, 'Online', 'Online', 'Desktop', '2023-11-01 12:54:01', '2023-11-14 00:16:12', '2023-11-14 01:14:30', 0, 200, 0, 0, 0, 0, ''),
(93, 0, 'HRD', 'hrd@rsiategal.com', 'hrd', '$2y$10$3uxZvECEsSQHXP8Ii3gczetMM9f.0/1yQiNcxUbv/zHYaUlyue1eW', NULL, NULL, NULL, 10, NULL, NULL, 19, '', '', '', '2023-11-01 19:45:57', '2023-11-01 20:10:33', '', 0, 0, 0, 0, 0, 0, ''),
(94, 0, 'UMUM', 'umum@rsiategal.com', 'umum', '$2y$10$5t9P4LDVMKEEnMv3.XFrw.X5rqFOhAzzTlO2gRqRo.vbb5A0oHXUm', 'verified', NULL, NULL, 9, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-11-01 20:01:50', NULL, '2023-12-28 15:15:23', 0, 0, 0, 0, 0, 0, ''),
(95, 0, 'Gudang', 'gudang@rsiategal.com', 'gudang', '$2y$10$n/nIuWZnQsxTdbUgGHF4nORazUy/HPaFqGDxhnkRxp0uSofvqixqO', 'verified', NULL, NULL, 20, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-11-04 13:56:09', NULL, '2023-12-28 15:15:43', 0, 0, 0, 0, 0, 0, ''),
(96, 0, 'satpam', 'satpam@rsia.co.id', 'satpam', '$2y$10$ePJhVbue8K1unsiffed2s.0ZY0FoSx/ODr3BR/liVCr5ZJOIzwZzG', 'verified', NULL, NULL, 24, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-12-06 22:54:05', NULL, '2023-12-30 05:20:36', 0, 0, 0, 0, 0, 0, ''),
(97, 0, 'farmasi1', 'farmasi1@test.com', 'farmasi1', '$2y$10$XDUhmYl7oNsLKO1nuOPELuJWHB6iJDZGiS.SlJx7XJBwibhMzFHzO', 'verified', NULL, NULL, 5, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-12-07 12:40:44', NULL, '2023-12-29 14:42:57', 0, 0, 0, 0, 0, 0, ''),
(98, 0, 'farmasi2', 'farmasi2@test.com', 'farmasi2', '$2y$10$mc5vQzeeO2Smp92vrbq/TO2iYCVqTXqOJzpOjGLzASi7EbXEQrrbe', 'verified', NULL, NULL, 5, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-12-07 12:41:20', NULL, '2023-12-07 19:14:37', 0, 0, 0, 0, 0, 0, ''),
(99, 0, 'test3', '', '1111112222222333', '$2y$10$ayjP6H9lrwPEz3DdxYmJ..1fSJPOUMDw2Ts78Y5nO5PbvCsKONxCW', NULL, NULL, NULL, 2, NULL, NULL, 0, '', '', '', '2023-12-20 14:29:57', NULL, '', 1111112222222333, 0, 0, 0, 0, 0, ''),
(100, 0, 'admanak', 'admanak@test.com', 'admanak', '$2y$10$IJKTtEt1uuA1sPCJdi/FweyUT9PlDdFpWzPx4SNmZs1WdpoVTkDwK', 'verified', NULL, NULL, 22, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-12-20 20:34:35', NULL, '2023-12-30 05:16:07', 0, 0, 0, 400, 0, 0, ''),
(101, 0, 'admbersalin', 'admbersalin@test.com', 'admbersalin', '$2y$10$Hs4eDYYDOwzQGkMvgGZaMOoew55zwRkijKieemTK80feJyOzQKV56', 'verified', NULL, NULL, 23, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-12-27 20:01:18', NULL, '2023-12-30 05:15:19', 0, 0, 0, 0, 400, 0, ''),
(102, 0, 'admkasir', 'admkasir@test.com', 'admkasir', '$2y$10$n9giwgt2WC7BrQC.NiIvBeBaJOwntu234uz8APcZdv1c4fR.8w23u', 'verified', NULL, NULL, 11, NULL, NULL, 19, 'Online', 'Online', 'Desktop', '2023-12-29 10:16:13', NULL, '2023-12-29 05:14:07', 0, 0, 0, 0, 0, 0, ''),
(103, 0, 'admpolianak', 'admpolianak@test.com', 'admpolianak', '$2y$10$Ly2a89FJsQL4QOJBHuTwvuBtCrgcwVgrRfrao9GX1MBCsg44S256W', 'verified', NULL, NULL, 6, 103, NULL, 19, 'Online', 'Online', 'Desktop', '2023-12-30 12:50:47', NULL, '2023-12-30 06:52:10', 0, 0, 0, 0, 0, 0, ''),
(104, 0, 'admpoliumum', 'adminumum@test.com', 'admpoliumum', '$2y$10$H1/D39gI2zi0btwH9OTlmO8Ky94vDgcI5aGEaJMHE11/ZyECgfnoG', 'verified', NULL, NULL, 6, 101, NULL, 19, 'Online', 'Online', 'Desktop', '2023-12-30 12:54:39', NULL, '2023-12-30 06:57:19', 0, 0, 0, 0, 0, 0, ''),
(105, 0, 'admdalam', 'admdalam@test.com', 'admdalam', '$2y$10$jqFZyjzSzHCSKUVcBbJnZeOvgLqSM4ih8l0oCUNxZ5A4pUvx9hISO', 'verified', NULL, NULL, 6, 102, NULL, 19, 'Online', 'Online', 'Desktop', '2023-12-30 12:58:47', NULL, '2023-12-30 06:59:31', 0, 0, 0, 0, 0, 0, ''),
(106, 0, 'admgizi', 'admgizi@test.com', 'admgizi', '$2y$10$gLM1JELQ4FRzVaJAChex9.z38Ev.Nd7b9Jc82qsV/wrRl.qYLYdx6', 'verified', NULL, NULL, 6, 105, NULL, 19, '', '', '', '2023-12-30 13:01:03', NULL, '', 0, 0, 0, 0, 0, 0, ''),
(107, 0, 'admandrolog', 'admandrolog@test.com', 'admandrolog', '$2y$10$r6vHTc.qNVKP.a/9oiCRGuSoyLK1xWLo6QsphqCF85dLcyH91vsAy', 'verified', NULL, NULL, 6, 106, NULL, 19, 'Online', 'Online', 'Desktop', '2023-12-30 13:02:33', NULL, '2023-12-30 07:03:10', 0, 0, 0, 0, 0, 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id_userlogin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id_userlogin` bigint(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
