-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2023 at 10:57 AM
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
-- Database: `classroom`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `AssignmentID` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `SubmissionDate` date DEFAULT NULL,
  `UserID` int(11) NOT NULL,
  `assigment` int(11) NOT NULL,
  `Course` int(11) DEFAULT NULL,
  `Grade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`AssignmentID`, `deskripsi`, `file_path`, `SubmissionDate`, `UserID`, `assigment`, `Course`, `Grade`) VALUES
(1, '2*2=4', 'uploads/[SILABUS] Mobile.pdf', NULL, 1, 1, 1, 79),
(14, 'aboaogoagoa', 'uploads/file_1700780360.pdf', '2023-11-24', 1, 15, 1, NULL),
(15, 'uiui', NULL, '2023-11-24', 1, 17, 1, NULL),
(16, 'abcguu\r\n', 'uploads/file_1700780382.pdf', '2023-11-24', 1, 19, 1, NULL),
(17, 'ababab', NULL, '2023-11-24', 1, 18, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `CourseID` int(11) NOT NULL,
  `CourseName` int(11) DEFAULT NULL,
  `StudyLevelID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`CourseID`, `CourseName`, `StudyLevelID`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 1, 2),
(8, 2, 2),
(9, 3, 2),
(10, 4, 2),
(11, 5, 2),
(12, 6, 2),
(13, 1, 3),
(14, 2, 3),
(15, 3, 3),
(16, 4, 3),
(17, 5, 3),
(18, 6, 3),
(19, 1, 4),
(20, 2, 4),
(21, 3, 4),
(22, 4, 4),
(23, 5, 4),
(24, 6, 4),
(25, 1, 5),
(26, 2, 5),
(27, 3, 5),
(28, 4, 5),
(29, 5, 5),
(30, 6, 5),
(31, 1, 6),
(32, 2, 6),
(33, 3, 6),
(34, 4, 6),
(35, 5, 6),
(36, 6, 6),
(37, 1, 7),
(38, 2, 7),
(39, 3, 7),
(40, 4, 7),
(41, 5, 7),
(42, 6, 7),
(43, 7, 7),
(44, 1, 8),
(45, 2, 8),
(46, 3, 8),
(47, 4, 8),
(48, 5, 8),
(49, 6, 8),
(50, 7, 8),
(51, 1, 9),
(52, 2, 9),
(53, 3, 9),
(54, 4, 9),
(55, 5, 9),
(56, 6, 9),
(57, 7, 9);

-- --------------------------------------------------------

--
-- Table structure for table `course_master`
--

CREATE TABLE `course_master` (
  `id_nameCourse` int(11) NOT NULL,
  `Name_Course` text NOT NULL,
  `Course_BG` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_master`
--

INSERT INTO `course_master` (`id_nameCourse`, `Name_Course`, `Course_BG`) VALUES
(1, 'Bahasa Indonesia', 'assets/indo.jpg'),
(2, 'Matematika', 'assets/math.jpg'),
(3, 'IPA', 'assets/ipa.jpg'),
(4, 'IPS', 'assets/ips.jpg'),
(5, 'PKN', 'assets/pkn.jpg'),
(6, 'PJOK', 'assets/pjok.jpg'),
(7, 'Bahasa Inggris', 'assets/english.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `MaterialID` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `CourseID` int(11) DEFAULT NULL,
  `url_video` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`MaterialID`, `Title`, `Content`, `file_path`, `CourseID`, `url_video`) VALUES
(1, 'Kosakata ', '<div>uui</div>', NULL, 1, 'https://youtu.be/v77De2n1rTI?si=1HAkYazdFmPGcSif'),
(2, 'Membaca', '<div>fjaklllllllllllllllllllll</div>', NULL, 1, 'https://youtu.be/DkWaRe3BZYQ?si=zXD6kcUVl01NQ0uf'),
(3, 'Menulis', 'Belajar menulis ', NULL, 1, 'https://youtu.be/B7x7OLFMEzg?si=jIXtp4_Y-Vg6Dbrx'),
(4, 'Sastra', '', NULL, 1, 'https://youtu.be/HtXvvPTjtzc?si=G14vQuPiQ2VA3wpA'),
(5, 'Bilangan', 'Belajar Bilangan', NULL, 2, 'https://youtu.be/dHmaQtbPEtM?si=ZkdOc-qv6Ib1dHoE'),
(6, 'Waktu', 'Belajar Waktu', NULL, 2, 'https://youtu.be/TmmZBWrammQ?si=WZHaq5EjPhmplOzI'),
(7, 'Berat', 'Belajar Berat', NULL, 2, 'https://youtu.be/ybEU-6U7s8k?si=TnZFqoAnSTY2WsH9'),
(8, 'Bangun Datar', 'Bangun Datar', NULL, 2, 'https://youtu.be/1v1zVQm3LiY?si=IVTo5X84GnRDyZ-E'),
(9, 'Mengenal anggota tubuhku', 'Video mengenal anggota tubuh', NULL, 3, 'https://youtu.be/Bbfp4Y_9AQ8?si=YxGZfkIfczbpot7p'),
(10, 'Kebutuhan tubuhku', 'Video kebutuhan tubuh', NULL, 3, 'https://youtu.be/g1aD_LAz2Tg?si=a7-GHQDSKDthyesv'),
(11, 'Melestarikan lingkungan', 'Video melestarikan lingkungan', NULL, 3, 'https://youtu.be/HbU0PMjVZnc?si=BA64n0kr6UQSGBvl'),
(12, 'Benda dan sifatnya', 'Video benda dan sifatnya', NULL, 3, 'https://youtu.be/LNKMtlCuOvU?si=B6Uy5Vw446gm1Xtb'),
(13, 'Mengenal diri sendiri', 'Video mengenal diri sendiri', NULL, 4, 'https://youtu.be/WfV063nlAIU?si=HleUAgx-TNG6LX8M'),
(14, 'Mengenal keluarga', 'Video mengenal keluarga', NULL, 4, 'https://youtu.be/dycCLd3RK9A?si=Tf7ebzHn_BYu9KUs'),
(15, 'Mengenal negaraku', 'Video mengenal negaraku', NULL, 4, 'https://youtu.be/H7Zuk49O9hk?si=KuPxaw6OgZ88U1RB'),
(16, 'Aku cinta Pancasila', 'Video aku cinta Pancasila', NULL, 5, 'https://youtu.be/jCgSY4UqZ-U?si=kVtkUZdxd1XVSkPa'),
(17, 'Hidup rukun', 'Video hidup rukun', NULL, 5, 'https://youtu.be/L3TqzjST9D8?si=lWkQ9hlu0xDCe7iz'),
(18, 'Peduli Lingkungan', 'Video peduli lingkungan', NULL, 5, 'https://youtu.be/bw1ilUXSEq8?si=RQOyqSa0cbDzqADV'),
(19, 'Aktifitas gerak dasar', 'Video aktivitas gerak dasar', NULL, 6, 'https://youtu.be/W2Lp4AAjZuQ?si=vSNn87LivyypzTe5'),
(20, 'Permainan sederhana', 'Video permainan sederhana', NULL, 6, 'https://youtu.be/HnGak7I-nto?si=99Fb7lOgaukxnwlT'),
(21, 'Kosakata', 'belajar ', NULL, 7, 'https://youtu.be/Be34WlFdCIo?si=kImRM0Nyu1nG_6rQ'),
(22, 'Membaca', 'belajar ', NULL, 7, 'https://youtu.be/e46p--cKwWo?si=VCZ7ldZKtNkXKFvu'),
(23, 'Menulis', 'belajar ', NULL, 7, 'https://youtu.be/NjdNaqzliFQ?si=Y-4R7a3ttm0r3Z76'),
(24, 'Sastra', 'belajar ', NULL, 7, 'https://youtu.be/fBuTCW7S9P8?si=XRGXi8a7wRtdQ4Fz'),
(25, 'Puisi', 'belajar ', NULL, 7, 'https://youtu.be/NTXiDnFYjME?si=kU1zZ14ZNqJ4apnH'),
(26, 'Dongeng', 'belajar ', NULL, 7, ' https://youtu.be/F2wR1ADQ-Yg?si=wA7rrM4vkD6CApNB'),
(27, 'Cerita Rakyat', 'belajar ', NULL, 7, 'https://youtu.be/fYocTrYDMv8?si=avelse4sLhXGu3uR'),
(28, 'Bilangan', 'belajar ', NULL, 8, 'https://youtu.be/R1c0jdDM7GE?si=MO4VzbmtrT745grw'),
(29, 'Waktu', 'belajar ', NULL, 8, 'https://youtu.be/YHhuzD35Ywk?si=DMY8K7yqmQUT86Os'),
(30, 'Berat', 'belajar ', NULL, 8, 'https://youtu.be/pXpP7tLN_78?si=YDQCsSNIj3Bws-si'),
(31, 'Panjang', 'belajar ', NULL, 8, 'https://youtu.be/feu1DIeXT_Y?si=tAQ9ObimuxpajAQK'),
(32, 'Bangun Datar', 'belajar ', NULL, 8, 'https://youtu.be/IJifPf-mTE4?si=5N120wKuJhv6sbwb'),
(33, 'Operasi Hitung', 'belajar ', NULL, 8, 'https://youtu.be/7A8pI5OzXAo?si=oVGsaDn8KEgOOefO'),
(34, 'Mengenal anggota tubuhku', 'belajar ', NULL, 9, 'https://youtu.be/_B9mUgT8KuY?si=bPp31BFTznh--My0'),
(35, 'Kebutuhan tubuhku', 'belajar ', NULL, 9, 'https://youtu.be/5UaPXhcTFz4?si=Ogza3qGb8gkj3jUm'),
(36, 'Melestarikan Lingkungan', 'belajar ', NULL, 9, 'https://youtu.be/8hq2JaqhJv4?si=2TD9WTcCMhV9-t6E'),
(37, 'Benda dan sifatnya', 'belajar ', NULL, 9, 'https://youtu.be/3hqjPBKLX4U?si=lH3dXNNxrwu3fBFx'),
(38, 'Gerak Benda', 'belajar ', NULL, 9, 'https://youtu.be/5Lyhojw9ZFM?si=6sdyRnnibDqqs9u3'),
(39, 'Kehidupan Makhluk Hidup', 'belajar ', NULL, 9, 'https://youtu.be/PizytBhVUfA?si=FRHSLZJ6QvYf0zdJ'),
(40, 'Alat dan bahan', 'belajar ', NULL, 9, 'https://youtu.be/AUOG4jDXgOI?si=HV31QLfnC45ozImY'),
(41, 'Mengenal diri sendiri', 'belajar ', NULL, 10, 'https://youtu.be/9MhsB9lQRbc?si=8-HC2vpoL96cwadi'),
(42, 'Mengenal Keluarga', 'belajar ', NULL, 10, 'https://youtu.be/YVmPObr7dNc?si=5c7FDm0fm_VwoiA7'),
(43, 'Mengenal Lingkungan sekitar', 'belajar ', NULL, 10, 'https://youtu.be/3tXXAp8k10c?si=gsdIcPoewXTri2ud'),
(44, 'Mengenal budayaku', 'belajar ', NULL, 10, 'https://youtu.be/BDy2ChJusqU?si=G5QzxrIKyHjwopz3'),
(45, 'Kehidupan Sosial dan Budaya', 'belajar ', NULL, 10, 'https://youtu.be/gEGYFyeJ8L0?si=EkN5MGXQcdAKNCUu'),
(46, 'Aku cinta Pancasila', 'belajar ', NULL, 11, 'https://youtu.be/-RSBDi42WKU?si=342pIYkYdGSBwLyv'),
(47, 'Hidup Rukun', 'belajar ', NULL, 11, 'https://youtu.be/RzLdhgf2sDw?si=UVElLCWSK8ma8y6a'),
(48, 'Bersih dan sehat', 'belajar ', NULL, 11, 'https://youtu.be/z1kInWrCV3M?si=2yFczmL90KWww1XE'),
(49, 'Peduli lingkungan ', 'belajar ', NULL, 11, 'https://youtu.be/GtUWBdC1sr4?si=ypPmU9GJVLCZ-tql'),
(50, 'Tertib di sekolah', 'belajar ', NULL, 11, 'https://youtu.be/ikpDFn6ZfrI?si=KZ4N43w6A3V7C7oF'),
(51, 'Kemitraan dan Kerjasama', 'belajar ', NULL, 11, 'https://youtu.be/ikpDFn6ZfrI?si=esET2UgDZnbCcuZD'),
(52, 'Keberagaman', 'belajar ', NULL, 11, 'https://youtu.be/ur2J7P5QI44?si=X817BKtmisBr-Kwl'),
(53, 'Aktivitas gerak dasar', 'belajar ', NULL, 12, 'https://youtu.be/iaW5nCOzf9w?si=6XtZpw6uKbN991UA'),
(54, 'Permainan sederhana', 'belajar ', NULL, 12, 'https://youtu.be/PhERxrdbQ7I?si=XI0QOwMcyYj5y_yY'),
(55, 'Aktifitas Pengembangan ', 'belajar ', NULL, 12, 'https://youtu.be/mVy4DYhCn0k?si=qSxi9zvZogLXqja3'),
(56, 'Kesehatan', 'belajar ', NULL, 12, 'https://youtu.be/PH4cxAus2hA?si=vhIRuKmwtO03zZug'),
(57, 'Indonesia', 'belajar ', NULL, 13, 'https://youtu.be/i1lsr4I46R0?si=C08xBrmW7oBKQwyW'),
(58, 'MTK', 'belajar ', NULL, 14, 'https://youtu.be/k-UGVaM_2Zw?si=3fmXggW8pFxGq7vm'),
(59, 'IPS', 'belajar ', NULL, 15, 'https://youtu.be/AcczfLYMfdg?si=ce9jJ0gHmXL1t024'),
(60, 'IPA', 'belajar ', NULL, 16, 'https://youtu.be/ns-DXOUZOw0?si=KnNMLrq3QGPbqZYm'),
(61, 'PPKN', 'belajar ', NULL, 17, 'https://youtu.be/OV1T3po1Uog?si=L7GRkeUN_PYKBScO'),
(62, 'PJOK', 'belajar ', NULL, 18, 'https://youtu.be/vZrOUu2NkvI?si=7p7-Om-ihQ-wLq5U'),
(63, 'Indonesia', 'belajar ', NULL, 19, 'https://youtu.be/AaGMnNxxLbY?si=sFuDMa-bnXo1loEn'),
(64, 'MTK', 'belajar ', NULL, 20, 'https://youtu.be/sJqLbS8dcAA?si=eRS21wSLBFz3n4Ul'),
(65, 'IPS', 'belajar ', NULL, 21, 'https://youtu.be/ISqp7r1C9L0?si=y5NqH4hACL4mlC03'),
(66, 'IPA', 'belajar ', NULL, 22, 'https://youtu.be/IzKohvP2jbk?si=nUzpDAPez-_BbVJx'),
(67, 'PPKN', 'belajar ', NULL, 23, 'https://youtu.be/b-RHKgbPy1g?si=5MlA9wmPok0nSsAH'),
(68, 'PJOK', 'belajar ', NULL, 24, 'https://youtu.be/pfTygpkOgv0?si=DpI6lqWHsvFc41Ei'),
(69, 'Kosakata', 'belajar ', NULL, 25, 'https://youtu.be/pVvoeFoyCb4?si=4n3bv7Xq7BJ8wFf3'),
(70, 'Membaca', 'belajar ', NULL, 25, 'https://youtu.be/903g9wMaBUI?si=I7aB8b4dfGC1YTaa'),
(71, 'Menulis', 'belajar ', NULL, 25, 'https://youtu.be/-aDw6kTPzTE?si=Yx0w8Ma3xfgS9Zkf'),
(72, 'Sastra', 'belajar ', NULL, 25, 'https://youtu.be/Eh6g_Ykoc70?si=9YnPEpfJ849_azus'),
(73, 'Bilangan', 'belajar ', NULL, 26, 'https://youtu.be/-hudLTIDUXk?si=wqfVMgLbUq3tsT0x'),
(74, 'Pecahan', 'belajar ', NULL, 26, 'https://youtu.be/0hPRfqPFtt8?si=vZzFwdL8XKe82YyP'),
(75, 'Pengukuran', 'belajar ', NULL, 26, 'https://youtu.be/TKfOTe0o6Bc?si=-9bnHNZpIwhmCCR8'),
(76, 'Operasi Hitung', 'belajar ', NULL, 26, 'https://youtu.be/4VFsHwtJY30?si=nUwKPi5xoOy5465V'),
(77, 'Geometri', 'belajar ', NULL, 26, 'https://youtu.be/mSoKyLJehYM?si=dOw8Ypeq4DqQBesW'),
(78, 'Mengenal anggota tubuhku', 'belajar ', NULL, 27, 'https://youtu.be/_B9mUgT8KuY?si=flr1tkcj3Zl1xCVC'),
(79, 'Kebutuhan tubuhku', 'belajar ', NULL, 27, 'https://youtu.be/a8DjzviTld4?si=3eq8-3znCc7HfZ8l'),
(80, 'Melestarikan Lingkungan', 'belajar ', NULL, 27, 'https://youtu.be/bPsgMGgTi3c?si=3EWlcfZC-mORi1LZ'),
(81, 'Benda dan sifatnya', 'belajar ', NULL, 27, 'https://youtu.be/LNKMtlCuOvU?si=Nvr72TxJgIMWKLOA'),
(82, 'Gerak Benda', 'belajar ', NULL, 27, 'https://youtu.be/YxKNrasx7sQ?si=NjkVdNrgHvcnsSHY'),
(83, 'Kehidupan Makhluk Hidup', 'belajar ', NULL, 27, 'https://youtu.be/f9cwrjDGOHo?si=iOdZOsNyXf-dF6V5'),
(84, 'Alat dan bahan', 'belajar ', NULL, 27, 'https://youtu.be/rTvUByt8jE8?si=VEhuFsH3RcCBZyr-'),
(85, 'Mengenal diri sendiri', 'belajar ', NULL, 28, 'https://youtu.be/wtUliCy3Jw8?si=sYJ1VpbC671B3Oua'),
(86, 'Mengenal Keluarga', 'belajar ', NULL, 28, 'https://youtu.be/7S3iX74Ui5o?si=_O3rujdqKh5HCmKB'),
(87, 'Mengenal Lingkungan sekitar', 'belajar ', NULL, 28, 'https://youtu.be/AcczfLYMfdg?si=uyADsTqOV-fXeBXm'),
(88, 'Mengenal Negaraku', 'belajar ', NULL, 28, 'https://youtu.be/edLyhYWCpRo?si=Eav_Kdv-6WCr5kdD'),
(89, 'Mengenal Budayaku', 'belajar ', NULL, 28, 'https://youtu.be/lIVTb1OxTDg?si=ftT-CIukX_1_IqnQ'),
(90, 'Kehidupan Sosial dan Budaya', 'belajar ', NULL, 28, 'https://youtu.be/gEGYFyeJ8L0?si=yvqRDDACCcXK8ow1'),
(91, 'Sejarah', 'belajar ', NULL, 28, 'https://youtu.be/CqDBiqfgrpY?si=UcKgoNg-ASfnNC36'),
(92, 'Geografi', 'belajar ', NULL, 28, 'https://youtu.be/Mw4GBqbXoe0?si=Vr1RBaKo2vkbI8Pf'),
(93, 'Aku cinta Pancasila', 'belajar ', NULL, 29, 'https://youtu.be/kuKsRwkSfcw?si=8o1U_be9wHT3leZr'),
(94, 'Hidup Rukun', 'belajar ', NULL, 29, 'https://youtu.be/MuUdZNOoHp0?si=G2cgONGEcq12pS7E'),
(95, 'Bersih dan sehat', 'belajar ', NULL, 29, 'https://youtu.be/6Qq7KgX0M50?si=8BhQ9pDFN3DJYzYM'),
(96, 'Peduli lingkungan ', 'belajar ', NULL, 29, 'https://youtu.be/GtUWBdC1sr4?si=lPJ9qDyNAvNKqS3P'),
(97, 'Tertib di sekolah', 'belajar ', NULL, 29, 'https://youtu.be/GtUWBdC1sr4?si=DUMwO6vpTmvrpDAp'),
(98, 'Kemitraan dan Kerjasama', 'belajar ', NULL, 29, 'https://youtu.be/vbOqibzXTTw?si=5qlKTvwgeqzyVHrM'),
(99, 'Keberagaman', 'belajar ', NULL, 29, 'https://youtu.be/M4bXg075LA8?si=WIXUVygmi6LZ6X6T'),
(100, 'Demokrasi', 'belajar ', NULL, 29, 'https://youtu.be/h32LjRkbNCM?si=j_J6RjWc0bX85Ql9'),
(101, 'Aktivitas Getak Dasar', 'belajar ', NULL, 30, 'https://youtu.be/J4pJ9ZtA03U?si=hp1qOW4ykPWnI-Gn'),
(102, 'Permainan sederhana', 'belajar ', NULL, 30, 'https://youtu.be/UlNAInMzqc0?si=xWfs3uH-mwxbOC6n'),
(103, 'Aktivitas Pengembangan', 'belajar ', NULL, 30, 'https://youtu.be/xtCmj6ViAFQ?si=67u-3X-BlxIiVV0o'),
(104, 'Kesehatan', 'belajar ', NULL, 30, 'https://youtu.be/R5pM161pqPo?si=n9w04X2rPb68REMO'),
(105, 'Kosakata', 'belajar ', NULL, 31, 'https://youtu.be/f7qV8LNi-nU?si=CSSNxMZPYI7kA6Xp'),
(106, 'Membaca', 'belajar ', NULL, 31, 'https://youtu.be/3ReWoaYwjrY?si=IiS4Y22kcnwPvfiB'),
(107, 'Menulis', 'belajar ', NULL, 31, 'https://youtu.be/y8SFQdCA4fg?si=uOs6Qz1BQK3_kHi9'),
(108, 'Sastra', 'belajar ', NULL, 31, 'https://youtu.be/Eh6g_Ykoc70?si=jMprZQlUKOowPTtx'),
(109, 'Bilangan', 'belajar ', NULL, 32, 'https://youtu.be/woaU3cLuNHA?si=8g3s9bu3zPfdJtB4'),
(110, 'Pecahan', 'belajar ', NULL, 32, 'https://youtu.be/pleXhmmfSyE?si=Ge5Y9QdH9ivT2qeT'),
(111, 'Pengukuran', 'belajar ', NULL, 32, 'https://youtu.be/4s3M3UuXHxQ?si=heirhTIJYTKEAAAN'),
(112, 'Operasi Hitung', 'belajar ', NULL, 32, 'https://youtu.be/zAiiCZWaYxg?si=AUwf3GGLuCY-q-os'),
(113, 'Geometri', 'belajar ', NULL, 32, 'https://youtu.be/4s3M3UuXHxQ?si=heirhTIJYTKEAAAN'),
(114, 'Peta dan Grafik', 'belajar ', NULL, 32, 'https://youtu.be/gvSb1sRKzus?si=5AHzrjfRizSRlGRa'),
(115, 'Mengenal anggota tubuhku', 'belajar ', NULL, 33, 'https://youtu.be/Bbfp4Y_9AQ8?si=hXqqYzb44Xi2QzHl'),
(116, 'Kebutuhan tubuhku', 'belajar ', NULL, 33, 'https://youtu.be/qA8J_2YrMJM?si=y1Wt-C1q6aBvaszC'),
(117, 'Melestarikan Lingkungan', 'belajar ', NULL, 33, 'https://youtu.be/PBZt4E0wwnw?si=u200MTQYaJjheyio'),
(118, 'Benda dan sifatnya', 'belajar ', NULL, 33, 'https://youtu.be/hUA174sEFA0?si=SSMtlXC-D0KbVdBV'),
(119, 'Gerak Benda', 'belajar ', NULL, 33, 'https://youtu.be/-whzxEfRcmQ?si=h5Ha3qNRZ93lyx31'),
(120, 'Kehidupan Makhluk Hidup', 'belajar ', NULL, 33, 'https://youtu.be/tCjwyq2D7ws?si=7M10Gq0WQaoUqysJ'),
(121, 'Alat dan bahan', 'belajar ', NULL, 33, 'https://youtu.be/400DTubkGeE?si=ch3MX3c6NJeNHNto'),
(122, 'Karya Ilmiah', 'belajar ', NULL, 33, 'https://youtu.be/KU2DoqIC9Rc?si=3u6kCtIlAy5CahVU'),
(123, 'Mengenal diri sendiri', 'belajar ', NULL, 34, 'https://youtu.be/xNyphyHnPPA?si=EB49oelF6HZ8EDs5'),
(124, 'Mengenal Keluarga', 'belajar ', NULL, 34, 'https://youtu.be/QPlej_N5kV8?si=AFA513GT3lPszLce'),
(125, 'Mengenal Lingkungan sekitar', 'belajar ', NULL, 34, 'https://youtu.be/bVyOR1yet98?si=IB8Y7gqgyoBPFe5b'),
(126, 'Mengenal Negaraku', 'belajar ', NULL, 34, 'https://youtu.be/r2rrieppZA0?si=AfGFUI23RVNoxaTa'),
(127, 'Mengenal Budayaku', 'belajar ', NULL, 34, 'https://youtu.be/Qq67SHLWM-I?si=-5hya8GdGJe6THur'),
(128, 'Kehidupan Sosial dan Budaya', 'belajar ', NULL, 34, 'https://youtu.be/k1_-2kCB_pc?si=ZiTbOpa7wAIQjEWx'),
(129, 'Sejarah', 'belajar ', NULL, 34, 'https://youtu.be/3jL2KXshp98?si=ly9EsRdhPDVig-E6'),
(130, 'Geografi', 'belajar ', NULL, 34, 'https://youtu.be/iadtfBbCOLE?si=IP1ry4BV_IOQ9bit'),
(131, 'Ekonomi', 'belajar ', NULL, 34, 'https://youtu.be/b6iyaDHtDaU?si=4BRqzsayJBu9Ss0v'),
(132, 'Aku cinta Pancasila', 'belajar ', NULL, 35, 'https://youtu.be/UMaOrxofOww?si=X0u83vFOF0Fwuaya'),
(133, 'Hidup Rukun', 'belajar ', NULL, 35, 'https://youtu.be/NESbkpCm6f4?si=R46AIWZfgFl4Glcp'),
(134, 'Bersih dan sehat', 'belajar ', NULL, 35, 'https://youtu.be/pM9yfMc0ki4?si=siCD95uQ9AdAV6Yv'),
(135, 'Peduli lingkungan ', 'belajar ', NULL, 35, 'https://youtu.be/Q21osKYfolc?si=H4nZV6l5tCFy7QIn'),
(136, 'Tertib di sekolah', 'belajar ', NULL, 35, 'https://youtu.be/nW8C9CzImo8?si=0Lz6-plrVgVZ_QRx'),
(137, 'Kemitraan dan Kerjasama', 'belajar ', NULL, 35, 'https://youtu.be/82Od4wgLIrw?si=YcE6nFRCjo1Mk6Q7'),
(138, 'Keberagaman', 'belajar ', NULL, 35, 'https://youtu.be/4vi7WVTU6Og?si=8PxWaNAXMcwqa79j'),
(139, 'Demokrasi', 'belajar ', NULL, 35, 'https://youtu.be/ir3MWc3M62g?si=0SVflcb0i-P_oGeY'),
(140, 'Kewarganegaraan', 'belajar ', NULL, 35, 'https://youtu.be/MKEspag5JdE?si=fvSCNRQ-vHkmSVFi'),
(141, 'Aktivitas gerak dasar', 'belajar ', NULL, 36, 'https://youtu.be/_8_ZBv_6uK4?si=_nAQQrYYgzLU5LK9'),
(142, 'Kosakata', 'belajar ', NULL, 37, 'https://youtu.be/h1_YIOJFrqA?si=v4ytMWe43wfWBnYh'),
(143, 'Membaca', 'belajar ', NULL, 37, 'https://youtu.be/ftwlhTZ_OC4?si=96MGLRV-2FIwuLDd'),
(144, 'Menulis', 'belajar ', NULL, 37, 'https://youtu.be/7GZCklpgTZU?si=6K3xrvox0A9gss5J'),
(145, 'Sastra', 'belajar ', NULL, 37, 'https://youtu.be/Eh6g_Ykoc70?si=wPiXGOK6AZuwIKzj'),
(146, 'Bilangan', 'belajar ', NULL, 38, 'https://youtu.be/cQAwIhfC6Dg?si=EXCHsfQCdObFdqpa'),
(147, 'Pecahan', 'belajar ', NULL, 38, 'https://youtu.be/oaVYH_m_igo?si=A6S8YTvyfn3OOTVJ'),
(148, 'Pengukuran', 'belajar ', NULL, 38, 'https://youtu.be/sXLWEpx0H58?si=-55T94SChIPM0qD6'),
(149, 'Operasi Hitung', 'belajar ', NULL, 38, 'https://youtu.be/ZNBSs0C7rPY?si=d-mJ6WIbMVEkjOAK'),
(150, 'Geografi', 'belajar ', NULL, 38, 'https://youtu.be/UWnuESTww1U?si=YP3gUdGLUSKxsTxw'),
(151, 'Peta dan Grafik', 'belajar ', NULL, 38, 'https://youtu.be/zCI44b8pYjA?si=cV_lz9XokZjOdFfH'),
(152, 'Aljabar ', 'belajar ', NULL, 38, 'https://youtu.be/OJhDRcYojt8?si=EwpoOaUMaVYOBGrQ'),
(153, 'Fisika', 'belajar ', NULL, 39, 'https://youtu.be/0z2ivJ7M17A?si=Cc_FSdui3cyqRIKi'),
(154, 'Kimia', 'belajar ', NULL, 39, 'https://youtu.be/Lyiwj0_0gXE?si=iUcHuBBzswUtqOBS'),
(155, 'Biologi', 'belajar ', NULL, 39, 'https://youtu.be/VzoPfyaJaZQ?si=uzyF0A-C_bqav97W'),
(156, 'Geografi', 'belajar ', NULL, 40, 'https://youtu.be/IX70LRChaOU?si=hwE5Bs4cB3jFDutQ'),
(157, 'Sejarah', 'belajar ', NULL, 40, 'https://youtu.be/x62w92mrv-0?si=kAASwfM5X4gLWxd3'),
(158, 'Ekonomi', 'belajar ', NULL, 40, 'https://youtu.be/Yaeao5KZdWA?si=_-nCKXWnqwTJGGIv'),
(159, 'Sosiologi', 'belajar ', NULL, 40, 'https://youtu.be/OulaaAAuL30?si=2zv8qth_9azzQ7mc'),
(160, 'Kewarganegaraan', 'belajar ', NULL, 41, 'https://youtu.be/VjeLXzB_DtE?si=64tSMDn7HUjXqj8-'),
(161, 'Demokrasi', 'belajar ', NULL, 41, ' https://youtu.be/FTFxjLXj1q4?si=sev3EguI415kxNfA'),
(162, 'Budaya', 'belajar ', NULL, 41, 'https://youtu.be/Qq67SHLWM-I?si=IvVzv0ROMadFND9U'),
(163, 'Globalisasi', 'belajar ', NULL, 41, 'https://youtu.be/q52WbOmAeTc?si=HOC-3B3MVIbbVjQV'),
(164, 'Aktifitas Gerak Dasar', 'belajar ', NULL, 42, 'https://youtu.be/FbCoIoMdmY4?si=5TcKTmvQhWoBYQyq'),
(165, 'Permainan sederhana dan tradisonal', 'belajar ', NULL, 42, 'https://youtu.be/BcYrWyUX-rc?si=48B-wRdTTHddl1eh'),
(166, 'Aktifitas Pengembangan', 'belajar ', NULL, 42, 'https://youtu.be/Z5rW8vbdxDY?si=xAbZYHC-UE_JDaKK'),
(167, 'Kesehatan', 'belajar ', NULL, 42, 'https://youtu.be/2gIwhXtXZvs?si=MKzPSrPtkW81Uf3L'),
(168, 'Listening', 'belajar ', NULL, 43, 'https://youtu.be/t3VdnsGC6ug?si=OG558xplK7dgQI0N'),
(169, 'Speaking', 'belajar ', NULL, 43, 'https://youtu.be/VGvS3YoL4IY?si=CnNVIGO2zELnrAd1'),
(170, 'Reading', 'belajar ', NULL, 43, 'https://youtu.be/rzaqmXUcQDs?si=LwGEyb1D-LMeysLR'),
(171, 'Writing', 'belajar ', NULL, 43, 'https://youtu.be/D3R4WRdGs1M?si=rZLtHl_Z0Gm82KxZ'),
(172, 'Indonesia', 'belajar ', NULL, 44, 'https://youtube.com/playlist?list=PL6E8cGDJ2xeAV7DeVsy65UkvYWN_mCoco&si=jV3qK0tjlqUFpSe_'),
(173, 'MTK', 'belajar ', NULL, 45, 'https://youtube.com/playlist?list=PL6E8cGDJ2xeAylN1vIQBAx7ROAXouiGCU&si=vQ-t0ot8Gw4H9_Zx'),
(174, 'IPA', 'belajar ', NULL, 46, 'https://youtube.com/playlist?list=PL6E8cGDJ2xeANfQ-6dwGrCPgcFeKS68kl&si=cnm33iyp0B_xTg1D'),
(175, 'IPS', 'belajar ', NULL, 47, 'https://youtube.com/playlist?list=PL6E8cGDJ2xeChh0ODvbFygQ-ZUjFJnLz6&si=Y2u5yQpoThPxWtoG'),
(176, 'PPKN', 'belajar ', NULL, 48, 'https://youtube.com/playlist?list=PL6E8cGDJ2xeB0NkE_6UE-8KL7hAmYdyMK&si=EfCBevRgY5A2xr5-'),
(177, 'PJOK', 'belajar ', NULL, 49, 'https://youtu.be/pQm0jQ3anr4?si=xgJwJcbmCZrFDiy3'),
(178, 'Bahasa Inggris', 'belajar ', NULL, 50, 'https://youtu.be/t3VdnsGC6ug?si=OG558xplK7dgQI0N'),
(179, 'Kosakata', 'belajar ', NULL, 51, 'https://youtu.be/d_swRsQOmu4?si=FA0cR7OPohpLfKCn'),
(180, 'Membaca', 'belajar ', NULL, 51, 'https://youtu.be/FUTwXT8bq2M?si=3MQzErfPsn4dpWT8'),
(181, 'Menulis', 'belajar ', NULL, 51, 'https://youtu.be/7eaDDR-oLxk?si=zg7cjiaWgK8DyQ5e'),
(182, 'Sastra', 'belajar ', NULL, 51, 'https://youtu.be/eKg21cu9kZc?si=yFCd4Amd-Px0ILFT'),
(183, 'Bilangan', 'belajar ', NULL, 52, 'https://youtu.be/7ye3WMx_n9s?si=eoHuhxB7IKg_qOMu'),
(184, 'Pecahan', 'belajar ', NULL, 52, 'https://youtu.be/mpSkjJE4f4Q?si=xCcpRM9vFF_ccS5n'),
(185, 'Pengukuran', 'belajar ', NULL, 52, 'https://youtu.be/8CsttDvJa9A?si=tPmyUcc3KcU-3pD2'),
(186, 'Operasi Hitung', 'belajar ', NULL, 52, 'https://youtu.be/i9WBpNm1oIQ?si=VIWwO-yqMCtuzRX2'),
(187, 'Geometri', 'belajar ', NULL, 52, 'https://youtu.be/slTG7rbeL_M?si=SfrQtGKWqS0dP4fV'),
(188, 'Aljabar ', 'belajar ', NULL, 52, 'https://youtu.be/OlpPqwsihwU?si=68ww6nx8onqGqJsC'),
(189, 'Fisika', 'belajar ', NULL, 53, 'https://youtu.be/hioHw9Dy4Cs?si=IFKTV8NSc5lsgppF'),
(190, 'Kimia', 'belajar ', NULL, 53, 'https://youtu.be/N4a-yeVuYjE?si=Xga3Bm0SiWVgQEck'),
(191, 'Biologi', 'belajar ', NULL, 53, 'https://youtu.be/dqj9CEi5ttY?si=IYgBD7xBoZ5lVPCV'),
(192, 'Geografi', 'belajar ', NULL, 54, 'https://youtu.be/hf-pCwUjoLA?si=GVzNTX4vuyyL5lcI'),
(193, 'Sejarah', 'belajar ', NULL, 54, 'https://youtu.be/yAXWsfVhmwY?si=6bwNw2pxqbXuGePS'),
(194, 'Ekonomi', 'belajar ', NULL, 54, 'https://youtu.be/ZDlhSDDGiCg?si=AERxTLDLEuk5yjrS'),
(195, 'Sosiologi', 'belajar ', NULL, 54, 'https://youtu.be/VY3Cp608osA?si=SSzwfFd7wovR1IQS'),
(196, 'Kewarganegaraan', 'belajar ', NULL, 55, 'https://youtu.be/6-FtOqBfMHg?si=DfHeqxF_XUCfKu7G'),
(197, 'Demokrasi', 'belajar ', NULL, 55, 'https://youtu.be/r2lxYi3Vndg?si=MATycd_7Pq8vXsxq'),
(198, 'Kebudayaan', 'belajar ', NULL, 55, 'https://youtu.be/NuWybg_YxGQ?si=GXZv9IoDcw9HTVI_'),
(199, 'Globalisasi', 'belajar ', NULL, 55, 'https://youtu.be/q52WbOmAeTc?si=-joFun6sFOYYkVn8'),
(200, 'Aktifitas Gerak Dasar', 'belajar ', NULL, 56, 'https://youtu.be/vYmpYviGmeM?si=ASJSnsgIn8SamPGc'),
(201, 'Permainan Gerak Dasar', 'belajar ', NULL, 56, 'https://youtu.be/Jl0aiBWU5aI?si=s9mW9r_kec-KrBKx'),
(202, 'Aktivitas dan Pengembangan', 'belajar ', NULL, 56, 'https://youtu.be/2fIycGMfzCA?si=PqFWHcTWlv5nE8rt'),
(203, 'Kesehatan', 'belajar ', NULL, 56, 'https://youtu.be/jtiE-pRUYOU?si=fOhhLT7r10AvzUr1'),
(204, 'Listening', 'belajar ', NULL, 57, 'https://youtu.be/rI3hKgGk34s?si=zX4H1x50nQZ6yt9V'),
(205, 'Speaking', 'belajar ', NULL, 57, 'https://youtu.be/ers70Yn_aUQ?si=kCyxLxTn1joNcLmr'),
(206, 'Reading', 'belajar ', NULL, 57, 'https://youtu.be/el_dtDhqB5A?si=7n2GNjVD14At5yOF'),
(207, 'Writing', 'belajar ', NULL, 57, 'https://youtu.be/J6FiroPgn74?si=ircv2Gn2hOIlw7nj'),
(326, 'pengantar  1', '', 'uploads/Bahasa Indonesia_Pengantar Informatika untuk Masyarakat.pptx', 1, 'https://youtu.be/x8fvwC5xVGg?si=98d7TtznYJAC6lF2'),
(327, 'abc', '<div>abc</div>', 'uploads/Bahasa Indonesia_Kontrak Kuliah.pptx', NULL, ''),
(329, 'abc', '<div>abcdf</div>', 'uploads/Bahasa Indonesia_Membuat Simulasi Jaringan VLAN.pdf', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id_quiz` int(11) NOT NULL,
  `question` text DEFAULT NULL,
  `option1` varchar(255) DEFAULT NULL,
  `option2` varchar(255) DEFAULT NULL,
  `option3` varchar(255) DEFAULT NULL,
  `option4` varchar(255) DEFAULT NULL,
  `correct_option` int(11) DEFAULT NULL,
  `time_limit` int(11) DEFAULT 30,
  `deadline` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `studyaccess`
--

CREATE TABLE `studyaccess` (
  `AccessID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `StudyLevelID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studyaccess`
--

INSERT INTO `studyaccess` (`AccessID`, `UserID`, `StudyLevelID`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6),
(7, 7, 7),
(8, 8, 8),
(9, 9, 9);

-- --------------------------------------------------------

--
-- Table structure for table `studylevel`
--

CREATE TABLE `studylevel` (
  `StudyLevelID` int(11) NOT NULL,
  `LevelName` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studylevel`
--

INSERT INTO `studylevel` (`StudyLevelID`, `LevelName`) VALUES
(1, '1 SD'),
(2, '2 SD'),
(3, '3 SD'),
(4, '4 SD'),
(5, '5 SD'),
(6, '6 SD'),
(7, '7 SMP'),
(8, '8 SMP'),
(9, '9 SMP');

-- --------------------------------------------------------

--
-- Table structure for table `upload_assignment`
--

CREATE TABLE `upload_assignment` (
  `upload_id` int(11) NOT NULL,
  `courseID` int(11) DEFAULT NULL,
  `Title` text DEFAULT NULL,
  `deksripsi` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `Deadline` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `upload_assignment`
--

INSERT INTO `upload_assignment` (`upload_id`, `courseID`, `Title`, `deksripsi`, `file_path`, `upload_time`, `Deadline`) VALUES
(1, 1, 'Tugas 1', 'carilah kalimat baku', 'uploads/Bahasa Indonesia_UJI PROPORSI.pdf', '2023-10-24 12:40:02', '2023-10-28'),
(13, 1, 'tugas 3', 'abc', '', '2023-11-27 07:15:38', '2023-11-12'),
(15, 1, ' abc', '<div>abc</div>', 'uploads/Bahasa Indonesia_UJI PROPORSI.pdf', '2023-11-23 20:10:47', '2023-11-26'),
(17, 1, 'uii', '<div>acb</div>', 'uploads/11_Membuat Simulasi Jaringan VLAN.pdf', '2023-11-23 20:14:37', '2023-11-30'),
(18, 1, ' abc', '<div>abc<br><br></div>', '', '2023-11-23 20:23:04', '2023-12-16'),
(19, 1, 'abc', '<div>abcb</div>', 'uploads/11_62-192-1-PB.pdf', '2023-11-23 20:23:33', '2023-11-27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(10) NOT NULL,
  `photo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `role`, `photo`) VALUES
(1, 'fulan', 'student1@example.com', '$2a$12$DRdFdGUf/Q4yEJAroN9wKeTbKwJJA92z0tPVEcixHEuEOB5gCzVBu', 'Student', 'uploads/1_Salinan IMG_0251e (1).jpg'),
(2, 'Student2', 'student2@example.com', '$2a$12$v5l/RkaDSQw3UH6Z9ZcX7uNV4In/axlsdhdJP6QkgfYAvC3BVTsPq', 'Student', ''),
(3, 'Student3', 'student3@example.com', '$2a$12$VOLnrU1EmMW8wFwSbF4pSO98IO0ZltV4IwSABAtVju6uMmVTnOE56', 'Student', ''),
(4, 'Student4', 'student4@example.com', '$2a$12$k0OQk563drxDzAA6hZpDHeHkBs8br268UrJFFNtwS6NhWcaJhL6k6\r\n', 'Student', ''),
(5, 'Student5', 'student5@example.com', '$2a$12$AdOJ/kBa.qGq/x1wcx6tUuggNr54/TJUmbEoz7hnubO84gKtbHWiK', 'Student', ''),
(6, 'Student6', 'student6@example.com', '$2a$12$7tX49ZLpL3prOglgmkt4KO9Vzl6.ohpYEnm/75JiRSD/dtdC2XNWi', 'Student', ''),
(7, 'Student7', 'student7@example.com', '$2a$12$DODt3njYO.KoIZTj09H51.b96xxzLnTELpKSLTLkNa8unlVq3XSta\r\n', 'Student', ''),
(8, 'Student8', 'student8@example.com', '$2a$12$79R3bYJBPiGB9uwA35QyreO8UMQdhDdw0cr.TisXP4Q1pJBM5JFaa', 'Student', ''),
(9, 'Student9', 'student9@example.com', '$2a$12$ZZDS6hzb31I8ien896Xvx.m97FQwi2GF6SyUf.Y2aVB51E005nnLi', 'Student', ''),
(10, 'aurel', 'teacher1@example.com', '$2a$12$Ga3kKYIVhc3Flg..SGH2WudKKoojkwrs83s763K4x.zvTAhLgIbgK', 'Teacher', 'uploads/10_Salinan IMG_0251e (1).jpg'),
(11, 'Teacher2', 'teacher2@example.com', '$2a$12$.vrWJ9qog.Wauz9WLZL86.vokvLLhAdC3OD84JEvB26W2SGKwE8tS', 'Teacher', ''),
(12, 'Teacher3', 'teacher3@example.com', '$2a$12$vZnUVAertaTbE5nzHhVOJ.I9fGcuOPhs5ne4J6H.U2HSLCHb7j37C', 'Teacher', ''),
(13, 'Teacher4', 'teacher4@example.com', '$2a$12$Z0LEjN7quxpPDaqrlJztXuZWZk2dhTvJMZaUrb8fX6YTq/rpDkMK.', 'Teacher', ''),
(14, 'Teacher5', 'teacher5@example.com', '$2a$12$eQ/EbeB.4tA8H7iJPIbweO5QSWfQ9CvwQ/vMMcJjPfrzKvdSUCWBy', 'Teacher', ''),
(15, 'sakura', 'teacher6@example.com', '$2a$12$51A93vbIK05SiL4j8m0lEuOYVxc/EU9BYWXtY2w1l7qKGBqskZngW', 'Teacher', ''),
(16, 'leeReum', 'leeReum@gmail.com', '$2a$12$keBsZ3gxMiRWBWaF2mEtbeiQPWXsEM7NjJfjFPKNdHG8tCbfwhuJO', 'Admin', NULL),
(18, 'inoki', 'inoki@gmail.com', '$2y$10$PU9GMq9GaEFE2U1dc8dcweOFWVVwHjrHHzIdnyj/INiyShje8S6/e', 'Student', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`AssignmentID`),
  ADD KEY `assignment_ibfk_2` (`UserID`),
  ADD KEY `assigment` (`assigment`),
  ADD KEY `CourseName` (`Course`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`CourseID`),
  ADD KEY `course_name` (`CourseName`),
  ADD KEY `Level_studi` (`StudyLevelID`);

--
-- Indexes for table `course_master`
--
ALTER TABLE `course_master`
  ADD PRIMARY KEY (`id_nameCourse`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`MaterialID`),
  ADD KEY `Couse_Material` (`CourseID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id_quiz`);

--
-- Indexes for table `studyaccess`
--
ALTER TABLE `studyaccess`
  ADD PRIMARY KEY (`AccessID`),
  ADD KEY `studyaccess_ibfk_1` (`UserID`),
  ADD KEY `level_study` (`StudyLevelID`);

--
-- Indexes for table `studylevel`
--
ALTER TABLE `studylevel`
  ADD PRIMARY KEY (`StudyLevelID`);

--
-- Indexes for table `upload_assignment`
--
ALTER TABLE `upload_assignment`
  ADD PRIMARY KEY (`upload_id`),
  ADD KEY `Course` (`courseID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `AssignmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `course_master`
--
ALTER TABLE `course_master`
  MODIFY `id_nameCourse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `MaterialID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=330;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id_quiz` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `studyaccess`
--
ALTER TABLE `studyaccess`
  MODIFY `AccessID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `studylevel`
--
ALTER TABLE `studylevel`
  MODIFY `StudyLevelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `upload_assignment`
--
ALTER TABLE `upload_assignment`
  MODIFY `upload_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `CourseName` FOREIGN KEY (`Course`) REFERENCES `course` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assigment` FOREIGN KEY (`assigment`) REFERENCES `upload_assignment` (`upload_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assignment_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `Level_studi` FOREIGN KEY (`StudyLevelID`) REFERENCES `studylevel` (`StudyLevelID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_name` FOREIGN KEY (`CourseName`) REFERENCES `course_master` (`id_nameCourse`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `Couse_Material` FOREIGN KEY (`CourseID`) REFERENCES `course` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `studyaccess`
--
ALTER TABLE `studyaccess`
  ADD CONSTRAINT `level_study` FOREIGN KEY (`StudyLevelID`) REFERENCES `studylevel` (`StudyLevelID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `studyaccess_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `upload_assignment`
--
ALTER TABLE `upload_assignment`
  ADD CONSTRAINT `Course` FOREIGN KEY (`courseID`) REFERENCES `course` (`CourseID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
