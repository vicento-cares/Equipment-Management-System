-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2023 at 07:05 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `car_models`
--

CREATE TABLE `car_models` (
  `id` int(10) UNSIGNED NOT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `car_models`
--

INSERT INTO `car_models` (`id`, `car_model`, `date_updated`) VALUES
(1, 'Daihatsu', '2023-02-03 14:51:32'),
(2, 'Daihatsu D01L', '2023-02-03 14:51:32'),
(3, 'Daihatsu D92', '2023-02-03 14:51:32'),
(4, 'Honda', '2023-02-03 14:51:33'),
(5, 'Honda TKRA', '2023-02-03 14:51:33'),
(6, 'Honda T20A', '2023-02-03 14:51:33'),
(7, 'Honda TG7', '2023-02-03 14:51:33'),
(8, 'Honda 3M0A', '2023-02-03 14:51:33'),
(9, 'Honda 3TOA', '2023-02-03 14:51:33'),
(10, 'Honda 30AA', '2023-02-03 14:51:33'),
(11, 'Honda RDX', '2023-02-03 14:51:33'),
(12, 'Honda MDX', '2023-02-03 14:51:33'),
(13, 'Mazda', '2023-02-03 14:51:33'),
(14, 'Mazda J12', '2023-02-03 14:51:33'),
(15, 'Mazda Merge', '2023-02-03 14:51:33'),
(16, 'Mazda J30A', '2023-02-03 14:51:34'),
(17, 'Mazda J20E', '2023-02-03 14:51:34'),
(18, 'Nissan / Marelli', '2023-02-03 14:51:34'),
(19, 'Subaru', '2023-02-03 14:51:34'),
(20, 'Suzuki', '2023-02-03 14:51:34'),
(21, 'Suzuki Y2R', '2023-02-03 14:51:34'),
(22, 'Suzuki YD1', '2023-02-03 14:51:34'),
(23, 'Toyota', '2023-02-03 14:51:34'),
(24, 'Toyota 700B', '2023-02-03 14:51:34'),
(25, 'Yamaha', '2023-02-03 14:51:34'),
(26, 'Yamaha Y68', '2023-02-03 14:51:35'),
(28, 'Training Center', '2023-04-13 14:11:07'),
(29, 'AME Area', '2023-04-13 14:11:07'),
(30, 'EQ Workstation', '2023-04-13 14:11:07'),
(31, 'IQC', '2023-04-13 14:11:07'),
(32, 'All', '2023-04-13 14:30:59'),
(33, 'Battery Area', '2023-04-13 14:43:01'),
(34, 'Conversion Area', '2023-04-13 14:48:00'),
(35, 'Aluminum Area', '2023-04-13 14:50:50'),
(36, 'Daihatsu D54L', '2023-04-13 15:18:08'),
(37, 'Tube Cutting Area', '2023-04-13 15:23:28'),
(38, 'Setup Work Shop', '2023-04-13 15:27:10'),
(39, 'Aluminum / Suzuki YD1', '2023-04-13 15:30:55'),
(40, 'Aluminum / Honda TKRA', '2023-04-13 15:30:55'),
(41, 'Zaihai Shop / Suzuki', '2023-04-13 15:32:10'),
(42, 'Zaihai Shop / Suzuki Y2R', '2023-04-13 15:32:10'),
(43, 'Nissan J32B', '2023-04-13 15:41:50'),
(44, 'Daihatsu D92A', '2023-04-13 15:54:59'),
(45, 'Honda 3S5A', '2023-04-13 16:03:33'),
(46, 'Honda TTA', '2023-04-13 16:07:38'),
(47, 'Mazda J78A', '2023-04-13 16:12:01'),
(48, 'Subaru GC7', '2023-04-13 16:15:50'),
(49, 'Subaru GA9', '2023-04-13 16:15:50'),
(50, 'Suzuki Y3J', '2023-04-13 16:21:42'),
(51, 'Suzuki Y6L', '2023-04-13 16:21:42'),
(52, 'Suzuki YT3', '2023-04-13 16:26:40'),
(53, 'Suzuki YV7', '2023-04-13 16:26:40'),
(54, 'Toyota 200D / Daihatsu', '2023-04-13 16:37:36'),
(55, 'EQ-Initial', '2023-06-02 09:47:26'),
(56, 'EQ-Final', '2023-06-02 09:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `fat_forms`
--

CREATE TABLE `fat_forms` (
  `id` int(10) UNSIGNED NOT NULL,
  `fat_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `equipment_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `asset_tag_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prev_location_group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prev_location_loc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prev_location_grid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_transfer` date NOT NULL,
  `new_location_group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_location_loc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_location_grid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Saved',
  `fat_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read_a3` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fat_forms`
--

INSERT INTO `fat_forms` (`id`, `fat_no`, `item_name`, `item_description`, `machine_no`, `equipment_no`, `asset_tag_no`, `prev_location_group`, `prev_location_loc`, `prev_location_grid`, `date_transfer`, `new_location_group`, `new_location_loc`, `new_location_grid`, `reason`, `fat_status`, `is_read_a3`, `date_updated`) VALUES
(5, 'FAT:23053001fa554', '', 'Wire Stripper', 'M-2', 'EQ-5', 'N/A', 'Honda Secondary Process', 'FAS3', '', '2023-06-10', 'Nissan / Marelli', 'FAS3', '', 'Reason', 'Saved', 1, '2023-05-30 13:07:16'),
(9, 'FAT:2305310454efe', '', '0.64 Terminal insertion guide device', '', 'EQ-3', 'N/A', 'EQ Workstation EQ1', 'FAS1', '', '2023-05-31', 'Daihatsu 2001', 'FAS3', '', 'For Setup', 'Saved', 0, '2023-05-31 16:08:25'),
(12, 'FAT:2306131179f2e', '', 'Wire Stripper', 'M-1', '', 'N/A', 'EQ-Initial', 'FAS4', '', '2023-07-08', 'Daihatsu D01L First Process', 'FAS3', '', 'Reason', 'Saved', 0, '2023-06-13 11:52:22'),
(13, 'FAT:2307280597b80', '', 'VO Making Machine', 'M-3', '', 'N/A', 'EQ-Initial', 'FAS4', '', '2023-07-31', 'Tube Cutting Area', 'FAS4', '', 'For Setup', 'Confirmed', 1, '2023-10-06 16:01:03'),
(14, 'FAT:230829023be37', '', 'Wire Stripper', 'M-13', '', 'N/A', 'EQ-Initial', 'FAS4', '', '2023-08-31', 'Daihatsu', 'FAS4', '', 'For Setup', 'Confirmed', 0, '2023-10-03 13:15:16'),
(15, 'FAT:23082902e1a4d', '', 'CONTINUITY TESTER (OMI-10 / 100)', 'M-20', '', 'N/A', 'EQ-Final', 'FAS4', '', '2023-08-31', 'Mazda Merge', 'FAS2', '', 'For Setup', 'Confirmed', 0, '2023-10-03 13:15:16'),
(16, 'FAT:23083105be202', '', 'Wire Stripper', 'M-14', '', 'N/A', 'EQ-Initial', 'FAS4', '', '2023-09-04', 'Subaru GC7', 'FAS2', '', 'For Setup', 'Confirmed', 0, '2023-10-03 13:15:16'),
(17, 'FAT:230831050a6a3', '9454', 'CONTINUITY TESTER (OMI-10 / 100)', 'M-21', '', 'N/A', 'EQ-Final', 'FAS4', '', '2023-09-04', 'Honda T20A', 'FAS3', '', 'For Setup', 'Confirmed', 0, '2023-10-03 13:15:16'),
(18, 'FAT:2309010554a35', '', 'Wire Stripper', 'M-15', '', 'N/A', 'EQ-Initial', 'FAS4', '', '2023-09-04', 'Daihatsu First Process', 'FAS3', '', 'For Setup', 'Confirmed', 0, '2023-10-03 13:15:16'),
(19, 'FAT:23090106f23b5', 'N/A', 'NS-IV', '', 'EQ-2', 'N/A', 'EQ-Initial', 'FAS4', '', '2023-09-20', 'Honda T20A', 'FAS3', 'O8', 'SET-UP FOR NEW CAR MODEL', 'Confirmed', 0, '2023-10-03 13:15:16'),
(20, 'FAT:23090106a504e', '', 'Automatic Cutting & Crimping Machine', '', 'EQ-1', 'N/A', 'EQ-Initial', 'FAS4', '', '2023-09-28', 'Aluminum / Honda TKRA Aluminum', 'Aluminum Area', '010', 'SET-UP', 'Saved', 0, '2023-09-01 18:49:29'),
(21, 'FAT:230901066097b', '', '0.64 Terminal insertion guide device', '', 'EQ-3', 'N/A', 'EQ-Final', 'FAS4', '', '2023-09-28', 'Daihatsu D01L', 'FAS1', '010', 'SET-UP', 'Saved', 0, '2023-09-01 18:55:03'),
(26, 'FAT:23100309e8fd8', '----------', 'Silicon Injection Machine', 'M-34', '', 'N/A', 'Honda TG7 First Process', 'FAS3', '', '2023-10-05', 'Honda 30AA', 'FAS3', '', 'TESTING2', 'Saved', 0, '2023-10-03 09:38:12');

-- --------------------------------------------------------

--
-- Table structure for table `line_no_final`
--

CREATE TABLE `line_no_final` (
  `id` int(10) UNSIGNED NOT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `line_no_final`
--

INSERT INTO `line_no_final` (`id`, `car_model`, `section`, `location`, `route_no`, `date_updated`) VALUES
(1, 'Toyota 4110', 'Section 2', 'FAS1', '1', '2023-04-26 13:26:23'),
(2, 'Toyota 4111', 'Section 2', 'FAS1', '1', '2023-04-26 13:26:24'),
(3, 'Toyota 4018', 'Section 2', 'FAS1', '1', '2023-04-26 13:26:24'),
(4, 'Toyota 4019', 'Section 2', 'FAS1', '1', '2023-04-26 13:26:24'),
(5, 'Suzuki 5101', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:24'),
(6, 'Suzuki 5102', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:24'),
(7, 'Suzuki 5103', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:24'),
(8, 'Suzuki 5104', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:24'),
(9, 'Suzuki 5105', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:24'),
(10, 'Suzuki 5111', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:24'),
(11, 'Suzuki 5112', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:24'),
(12, 'Suzuki 5113', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:24'),
(13, 'Suzuki 5114', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:24'),
(14, 'Suzuki 5015', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:24'),
(15, 'Suzuki 5116', 'Section 2', 'FAS1', '1', '2023-04-26 13:26:24'),
(16, 'Suzuki 5117', 'Section 2', 'FAS1', '1', '2023-04-26 13:26:24'),
(17, 'Suzuki 5119', 'Section 2', 'FAS1', '1', '2023-04-26 13:26:24'),
(18, 'Suzuki 5121', 'Section 2', 'FAS1', '1', '2023-04-26 13:26:24'),
(19, 'Suzuki 5124', 'Section 2', 'FAS1', '1', '2023-04-26 13:26:24'),
(20, 'Suzuki 5125', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:24'),
(21, 'Suzuki 5126', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:24'),
(22, 'Suzuki 5127', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:25'),
(23, 'Suzuki 5128', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:25'),
(24, 'Suzuki 5031', 'Section 2', 'FAS1', '1', '2023-04-26 13:26:25'),
(25, 'Suzuki 5133', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:25'),
(26, 'Suzuki 5138', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:25'),
(27, 'Suzuki 5139', 'Section 1', 'FAS1', '2', '2023-04-26 13:26:25'),
(28, 'Suzuki 5140', 'Section 1', 'FAS1', '1', '2023-04-26 13:26:25'),
(29, 'Mazda 1135', 'Section 3', 'FAS1', '1', '2023-04-26 13:26:25'),
(30, 'Mazda 1137', 'Section 3', 'FAS1', '1', '2023-04-26 13:26:25'),
(31, 'Mazda 1139', 'Section 3', 'FAS1', '1', '2023-04-26 13:26:25'),
(32, 'Mazda 1040', 'Section 3', 'FAS1', '1', '2023-04-26 13:26:25'),
(33, 'Daihatsu 2026', 'Section 4', 'FAS2', '2', '2023-04-26 13:26:25'),
(34, 'Daihatsu 2102', 'Section 4', 'FAS2', '2', '2023-04-26 13:26:25'),
(35, 'Daihatsu 2104', 'Section 4', 'FAS2', '2', '2023-04-26 13:26:25'),
(36, 'Daihatsu 2105', 'Section 4', 'FAS2', '2', '2023-04-26 13:26:25'),
(37, 'Daihatsu 2107', 'Section 4', 'FAS2', '2', '2023-04-26 13:26:25'),
(38, 'Mazda 1101', 'Section 3', 'FAS2', '2', '2023-04-26 13:26:25'),
(39, 'Mazda 1102', 'Section 3', 'FAS2', '2', '2023-04-26 13:26:25'),
(40, 'Mazda 1103', 'Section 3', 'FAS2', '2', '2023-04-26 13:26:25'),
(41, 'Mazda 1004', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:25'),
(42, 'Mazda 1005', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:25'),
(43, 'Mazda 1006', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:25'),
(44, 'Mazda 1007', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:26'),
(45, 'Mazda 1008', 'Section 3', 'FAS2', '2', '2023-04-26 13:26:26'),
(46, 'Mazda 1110', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:26'),
(47, 'Mazda 1112', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:26'),
(48, 'Mazda 1114', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:26'),
(49, 'Mazda 1115', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:26'),
(50, 'Mazda 1117', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:26'),
(51, 'Mazda 1118', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:26'),
(52, 'Mazda 1119', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:26'),
(53, 'Mazda 1121', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:26'),
(54, 'Mazda 1123', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:26'),
(55, 'Mazda 1124', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:26'),
(56, 'Mazda 1125', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:26'),
(57, 'Mazda 1126', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:26'),
(58, 'Mazda 1032', 'Section 3', 'FAS2', '1', '2023-04-26 13:26:26'),
(59, 'Suzuki 5123', 'Section 1', 'FAS2', '1', '2023-04-26 13:26:26'),
(60, 'Suzuki 5130', 'Section 1', 'FAS2', '1', '2023-04-26 13:26:26'),
(61, 'Suzuki 5132', 'Section 1', 'FAS2', '1', '2023-04-26 13:26:26'),
(62, 'Suzuki 5135', 'Section 1', 'FAS2', '2', '2023-04-26 13:26:26'),
(63, 'Suzuki 5009', 'Section 1', 'FAS3', '4', '2023-04-26 13:26:26'),
(64, 'Honda 3122', 'Section 7', 'FAS3', '4', '2023-04-26 13:26:26'),
(65, 'Honda 3123', 'Section 7', 'FAS3', '4', '2023-04-26 13:26:27'),
(66, 'Honda 3124', 'Section 7', 'FAS3', '4', '2023-04-26 13:26:27'),
(67, 'Honda 3125', 'Section 7', 'FAS3', '4', '2023-04-26 13:26:27'),
(68, 'Honda 3127', 'Section 7', 'FAS3', '4', '2023-04-26 13:26:27'),
(69, 'Honda 3129', 'Section 7', 'FAS3', '4', '2023-04-26 13:26:27'),
(70, 'Honda 3130', 'Section 7', 'FAS3', '4', '2023-04-26 13:26:27'),
(71, 'Honda 3133', 'Section 7', 'FAS3', '3', '2023-04-26 13:26:27'),
(72, 'Honda 3136', 'Section 7', 'FAS3', '3', '2023-04-26 13:26:27'),
(73, 'Honda 3138', 'Section 6', 'FAS3', '3', '2023-04-26 13:26:27'),
(74, 'Honda 3139', 'Section 6', 'FAS3', '3', '2023-04-26 13:26:27'),
(75, 'Honda 3140', 'Section 6', 'FAS3', '3', '2023-04-26 13:26:27'),
(76, 'Honda 3141', 'Section 6', 'FAS3', '3', '2023-04-26 13:26:28'),
(77, 'Honda 3142', 'Section 6', 'FAS3', '3', '2023-04-26 13:26:28'),
(78, 'Honda 3144', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:28'),
(79, 'Honda 3145', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:28'),
(80, 'Honda 3053', 'Section 6', 'FAS3', '3', '2023-04-26 13:26:28'),
(81, 'Honda 3158', 'Section 7', 'FAS3', '4', '2023-04-26 13:26:28'),
(82, 'Honda 3159', 'Section 7', 'FAS3', '4', '2023-04-26 13:26:28'),
(83, 'Honda 3160', 'Section 7', 'FAS3', '4', '2023-04-26 13:26:28'),
(84, 'Honda 3161', 'Section 7', 'FAS3', '4', '2023-04-26 13:26:28'),
(85, 'Honda 3168', 'Section 7', 'FAS3', '4', '2023-04-26 13:26:28'),
(86, 'Honda 3169', 'Section 7', 'FAS3', '4', '2023-04-26 13:26:28'),
(87, 'Daihatsu 2001', 'Section 4', 'FAS3', '4', '2023-04-26 13:26:28'),
(88, 'Daihatsu 2109', 'Section 4', 'FAS3', '4', '2023-04-26 13:26:28'),
(89, 'Daihatsu 2111', 'Section 4', 'FAS3', '4', '2023-04-26 13:26:28'),
(90, 'Daihatsu 2112', 'Section 4', 'FAS3', '4', '2023-04-26 13:26:28'),
(91, 'Daihatsu 2113', 'Section 4', 'FAS3', '4', '2023-04-26 13:26:28'),
(92, 'Daihatsu 2114', 'Section 4', 'FAS3', '4', '2023-04-26 13:26:28'),
(93, 'Daihatsu 2115', 'Section 4', 'FAS3', '4', '2023-04-26 13:26:28'),
(94, 'Daihatsu 2116', 'Section 4', 'FAS3', '4', '2023-04-26 13:26:28'),
(95, 'Daihatsu 2117', 'Section 4', 'FAS3', '4', '2023-04-26 13:26:28'),
(96, 'Daihatsu 2119', 'Section 4', 'FAS3', '4', '2023-04-26 13:26:28'),
(97, 'Daihatsu 2120', 'Section 4', 'FAS3', '4', '2023-04-26 13:26:29'),
(98, 'Daihatsu 2121', 'Section 4', 'FAS3', '3', '2023-04-26 13:26:29'),
(99, 'Daihatsu 2122', 'Section 4', 'FAS3', '3', '2023-04-26 13:26:29'),
(100, 'Daihatsu 2123', 'Section 4', 'FAS3', '3', '2023-04-26 13:26:29'),
(101, 'Daihatsu 2124', 'Section 4', 'FAS3', '3', '2023-04-26 13:26:29'),
(102, 'Daihatsu 2125', 'Section 4', 'FAS3', '3', '2023-04-26 13:26:29'),
(103, 'Daihatsu 2127', 'Section 4', 'FAS3', '3', '2023-04-26 13:26:29'),
(104, 'Daihatsu 2128', 'Section 4', 'FAS3', '2', '2023-04-26 13:26:29'),
(105, 'Subaru 7101', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:29'),
(106, 'Subaru 7102', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:29'),
(107, 'Subaru 7103', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:29'),
(108, 'Subaru 7104', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:29'),
(109, 'Subaru 7105', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:29'),
(110, 'Subaru 7106', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:29'),
(111, 'Subaru 7107', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:29'),
(112, 'Subaru 7108', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:29'),
(113, 'Subaru 7109', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:29'),
(114, 'Subaru 7110', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:29'),
(115, 'Subaru 7111', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:30'),
(116, 'Subaru 7112', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:30'),
(117, 'Subaru 7113', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:30'),
(118, 'Subaru 7114', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:30'),
(119, 'Subaru 7015', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:30'),
(120, 'Subaru 7116', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:30'),
(121, 'Subaru 7118', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:30'),
(122, 'Subaru 7119', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:30'),
(123, 'Subaru 7120', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:30'),
(124, 'Subaru 7121', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:30'),
(125, 'Subaru 7122', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:30'),
(126, 'Subaru 7023', 'Section 5', 'FAS3', '3', '2023-04-26 13:26:30'),
(127, 'Suzuki 5006', 'Section 1', 'FAS4', '1', '2023-04-26 13:26:30'),
(128, 'Suzuki 5029', 'Section 1', 'FAS4', '1', '2023-04-26 13:26:30'),
(129, 'Suzuki 5018', 'Section 2', 'FAS4', '5', '2023-04-26 13:26:30'),
(130, 'Honda 3031', 'Section 7', 'FAS4', '4', '2023-04-26 13:26:30'),
(131, 'Honda 3032', 'Section 7', 'FAS4', '4', '2023-04-26 13:26:30'),
(132, 'Honda 3046', 'Section 5', 'FAS4', '5', '2023-04-26 13:26:30'),
(133, 'Honda 3037', 'Section 5', 'FAS4', '4', '2023-04-26 13:26:31'),
(134, 'Honda 3149', 'Section 7', 'FAS4', '5', '2023-04-26 13:26:31'),
(135, 'Honda 3150', 'Section 7', 'FAS4', '4', '2023-04-26 13:26:31'),
(136, 'Honda 3151', 'Section 7', 'FAS4', '4', '2023-04-26 13:26:31'),
(137, 'Honda 3152', 'Section 7', 'FAS4', '4', '2023-04-26 13:26:31'),
(138, 'Honda 3162', 'Section 7', 'FAS4', '5', '2023-04-26 13:26:31'),
(139, 'Honda 3163', 'Section 7', 'FAS4', '5', '2023-04-26 13:26:31'),
(140, 'Honda 3164', 'Section 7', 'FAS4', '5', '2023-04-26 13:26:31'),
(141, 'Honda 3165', 'Section 7', 'FAS4', '5', '2023-04-26 13:26:31'),
(142, 'Honda 3066', 'Section 7', 'FAS4', '5', '2023-04-26 13:26:31'),
(143, 'Honda 3067', 'Section 7', 'FAS4', '5', '2023-04-26 13:26:31'),
(144, 'Mazda 1033', 'Section 3', 'FAS4', '2', '2023-04-26 13:26:31'),
(145, 'Mazda 1034', 'Section 3', 'FAS4', '2', '2023-04-26 13:26:31'),
(146, 'Yamaha 8001', 'Section 2', 'FAS4', '5', '2023-04-26 13:26:31'),
(147, 'Toyota 4120', 'Section 2', 'FAS4', '5', '2023-04-26 13:26:31'),
(148, 'Toyota 4121', 'Section 2', 'FAS4', '5', '2023-04-26 13:26:31'),
(149, 'Toyota 4122', 'Section 2', 'FAS4', '5', '2023-04-26 13:26:31'),
(150, 'Toyota 4123', 'Section 2', 'FAS4', '5', '2023-04-26 13:26:32'),
(151, 'Toyota 4124', 'Section 2', 'FAS4', '5', '2023-04-26 13:26:32'),
(152, 'Toyota 4125', 'Section 2', 'FAS4', '5', '2023-04-26 13:26:32'),
(153, 'Toyota 4126', 'Section 2', 'FAS4', '5', '2023-04-26 13:26:32'),
(155, 'Training Center', 'Training Center', 'FAS1', 'N/A', '2023-04-26 13:26:32'),
(156, 'AME Area', 'AME Area', 'FAS2', 'N/A', '2023-04-26 13:26:32'),
(157, 'EQ Workstation EQ1', 'EQ Workstation', 'FAS1', 'N/A', '2023-04-26 13:26:32'),
(158, 'EQ Workstation EQ3', 'EQ Workstation', 'FAS3', 'N/A', '2023-04-26 13:26:32'),
(159, 'IQC', 'IQC', 'Warehouse', 'N/A', '2023-04-26 13:26:32'),
(160, 'EQ-Final', 'EQ', 'FAS4', 'N/A', '2023-06-02 09:53:48');

-- --------------------------------------------------------

--
-- Table structure for table `line_no_initial`
--

CREATE TABLE `line_no_initial` (
  `id` int(10) UNSIGNED NOT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `line_no_initial`
--

INSERT INTO `line_no_initial` (`id`, `car_model`, `section`, `location`, `route_no`, `date_updated`) VALUES
(1, 'Daihatsu First Process', 'Section 4', 'FAS3', 'N/A', '2023-04-26 13:27:09'),
(2, 'Daihatsu D01L First Process', 'Section 4', 'FAS3', 'N/A', '2023-04-26 13:27:09'),
(3, 'Daihatsu D92 First Process', 'Section 4', 'FAS3', 'N/A', '2023-04-26 13:27:10'),
(4, 'Honda First Process', 'Section 7', 'FAS3', 'N/A', '2023-04-26 13:27:10'),
(5, 'Honda TKRA First Process', 'Section 7', 'FAS3', 'N/A', '2023-04-26 13:27:10'),
(6, 'Honda T20A First Process', 'Section 5', 'FAS3', 'N/A', '2023-04-26 13:27:10'),
(7, 'Honda TG7 First Process', 'Section 6', 'FAS3', 'N/A', '2023-04-26 13:27:10'),
(8, 'Honda 3M0A First Process', 'Section 6', 'FAS3', 'N/A', '2023-04-26 13:27:10'),
(9, 'Honda 3TOA First Process', 'Section 7', 'FAS3', 'N/A', '2023-04-26 13:27:10'),
(10, 'Honda 30AA First Process', 'Section 6', 'FAS3', 'N/A', '2023-04-26 13:27:10'),
(11, 'Honda RDX First Process', 'Section 7', 'FAS3', 'N/A', '2023-04-26 13:27:10'),
(12, 'Honda MDX First Process', 'Section 7', 'FAS3', 'N/A', '2023-04-26 13:27:10'),
(13, 'Mazda First Process', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:10'),
(14, 'Mazda J12 First Process', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:10'),
(15, 'Mazda Merge First Process', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:10'),
(16, 'Mazda J30A First Process', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:10'),
(17, 'Mazda J20E First Process', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:10'),
(18, 'Nissan / Marelli First Process', 'Section 4', 'FAS2', 'N/A', '2023-04-26 13:27:10'),
(19, 'Subaru First Process', 'Section 5', 'FAS3', 'N/A', '2023-04-26 13:27:10'),
(20, 'Suzuki First Process', 'Section 1', 'FAS1', 'N/A', '2023-04-26 13:27:10'),
(21, 'Suzuki Y2R First Process', 'Section 1', 'FAS1', 'N/A', '2023-04-26 13:27:10'),
(22, 'Suzuki YD1 First Process', 'Section 2', 'FAS1', 'N/A', '2023-04-26 13:27:10'),
(23, 'Toyota First Process', 'Section 2', 'FAS1', 'N/A', '2023-04-26 13:27:10'),
(24, 'Toyota 700B First Process', 'Section 2', 'FAS1', 'N/A', '2023-04-26 13:27:10'),
(25, 'Yamaha First Process', 'Section 2', 'FAS4', 'N/A', '2023-04-26 13:27:10'),
(26, 'Yamaha Y68 First Process', 'Section 2', 'FAS4', 'N/A', '2023-04-26 13:27:10'),
(27, 'Daihatsu Secondary Process', 'Section 4', 'FAS3', 'N/A', '2023-04-26 13:27:11'),
(28, 'Daihatsu D01L Secondary Process', 'Section 4', 'FAS3', 'N/A', '2023-04-26 13:27:11'),
(29, 'Daihatsu D92 Secondary Process', 'Section 4', 'FAS3', 'N/A', '2023-04-26 13:27:11'),
(30, 'Honda Secondary Process', 'Section 7', 'FAS3', 'N/A', '2023-04-26 13:27:11'),
(31, 'Honda TKRA Secondary Process', 'Section 7', 'FAS3', 'N/A', '2023-04-26 13:27:11'),
(32, 'Honda T20A Secondary Process', 'Section 5', 'FAS3', 'N/A', '2023-04-26 13:27:11'),
(33, 'Honda TG7 Secondary Process', 'Section 6', 'FAS3', 'N/A', '2023-04-26 13:27:11'),
(34, 'Honda 3M0A Secondary Process', 'Section 6', 'FAS3', 'N/A', '2023-04-26 13:27:11'),
(35, 'Honda 3TOA Secondary Process', 'Section 7', 'FAS3', 'N/A', '2023-04-26 13:27:11'),
(36, 'Honda 30AA Secondary Process', 'Section 6', 'FAS3', 'N/A', '2023-04-26 13:27:11'),
(37, 'Honda RDX Secondary Process', 'Section 7', 'FAS3', 'N/A', '2023-04-26 13:27:11'),
(38, 'Honda MDX Secondary Process', 'Section 7', 'FAS3', 'N/A', '2023-04-26 13:27:11'),
(39, 'Mazda Secondary Process', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:11'),
(40, 'Mazda J12 Secondary Process', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:11'),
(41, 'Mazda Merge Secondary Process', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:11'),
(42, 'Mazda J30A Secondary Process', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:11'),
(43, 'Mazda J20E Secondary Process', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:11'),
(44, 'Nissan / Marelli Secondary Process', 'Section 4', 'FAS2', 'N/A', '2023-04-26 13:27:11'),
(45, 'Subaru Secondary Process', 'Section 5', 'FAS3', 'N/A', '2023-04-26 13:27:11'),
(46, 'Suzuki Secondary Process', 'Section 1', 'FAS1', 'N/A', '2023-04-26 13:27:11'),
(47, 'Suzuki Y2R Secondary Process', 'Section 1', 'FAS1', 'N/A', '2023-04-26 13:27:11'),
(48, 'Suzuki YD1 Secondary Process', 'Section 2', 'FAS1', 'N/A', '2023-04-26 13:27:11'),
(49, 'Toyota Secondary Process', 'Section 2', 'FAS1', 'N/A', '2023-04-26 13:27:11'),
(50, 'Toyota 700B Secondary Process', 'Section 2', 'FAS1', 'N/A', '2023-04-26 13:27:11'),
(51, 'Yamaha Secondary Process', 'Section 2', 'FAS4', 'N/A', '2023-04-26 13:27:11'),
(52, 'Yamaha Y68 Secondary Process', 'Section 2', 'FAS4', 'N/A', '2023-04-26 13:27:12'),
(53, 'Daihatsu', 'Section 4', 'FAS3', 'N/A', '2023-04-26 13:27:12'),
(54, 'Daihatsu D01L', 'Section 4', 'FAS3', 'N/A', '2023-04-26 13:27:12'),
(55, 'Daihatsu D92', 'Section 4', 'FAS3', 'N/A', '2023-04-26 13:27:12'),
(56, 'Honda', 'Section 7', 'FAS3', 'N/A', '2023-04-26 13:27:12'),
(57, 'Honda TKRA', 'Section 7', 'FAS3', 'N/A', '2023-04-26 13:27:12'),
(58, 'Honda T20A', 'Section 5', 'FAS3', 'N/A', '2023-04-26 13:27:12'),
(59, 'Honda TG7', 'Section 6', 'FAS3', 'N/A', '2023-04-26 13:27:12'),
(60, 'Honda 3M0A', 'Section 6', 'FAS3', 'N/A', '2023-04-26 13:27:12'),
(61, 'Honda 3TOA', 'Section 7', 'FAS3', 'N/A', '2023-04-26 13:27:12'),
(62, 'Honda 30AA', 'Section 6', 'FAS3', 'N/A', '2023-04-26 13:27:12'),
(63, 'Honda RDX', 'Section 7', 'FAS3', 'N/A', '2023-04-26 13:27:12'),
(64, 'Honda MDX', 'Section 7', 'FAS3', 'N/A', '2023-04-26 13:27:12'),
(65, 'Mazda', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:12'),
(66, 'Mazda J12', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:12'),
(67, 'Mazda Merge', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:12'),
(68, 'Mazda J30A', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:12'),
(69, 'Mazda J20E', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:12'),
(70, 'Nissan / Marelli', 'Section 4', 'FAS2', 'N/A', '2023-04-26 13:27:12'),
(71, 'Subaru', 'Section 5', 'FAS3', 'N/A', '2023-04-26 13:27:12'),
(72, 'Suzuki', 'Section 1', 'FAS1', 'N/A', '2023-04-26 13:27:12'),
(73, 'Suzuki Y2R', 'Section 1', 'FAS1', 'N/A', '2023-04-26 13:27:12'),
(74, 'Suzuki YD1', 'Section 2', 'FAS1', 'N/A', '2023-04-26 13:27:12'),
(75, 'Toyota', 'Section 2', 'FAS1', 'N/A', '2023-04-26 13:27:12'),
(76, 'Toyota 700B', 'Section 2', 'FAS1', 'N/A', '2023-04-26 13:27:12'),
(77, 'Yamaha', 'Section 2', 'FAS4', 'N/A', '2023-04-26 13:27:12'),
(78, 'Yamaha Y68', 'Section 2', 'FAS4', 'N/A', '2023-04-26 13:27:13'),
(79, 'Battery Area Battery', 'Section 8', 'FAS3', 'N/A', '2023-04-26 13:27:13'),
(80, 'Conversion Area Conversion', 'Conversion Area', 'FAS2', 'N/A', '2023-04-26 13:27:13'),
(81, 'Aluminum Area Aluminum', 'Aluminum Area', 'FAS3', 'N/A', '2023-04-26 13:27:13'),
(82, 'Aluminum / Suzuki YD1 Aluminum', 'Aluminum Area', 'FAS1', 'N/A', '2023-04-26 13:27:13'),
(83, 'Aluminum / Honda TKRA Aluminum', 'Aluminum Area', 'FAS3', 'N/A', '2023-04-26 13:27:13'),
(84, ' All', 'All', 'FAS4', 'N/A', '2023-04-26 13:27:13'),
(85, 'Daihatsu D54L First Process', 'Section 4', 'FAS3', 'N/A', '2023-04-26 13:27:13'),
(86, 'Daihatsu D54L Secondary Process', 'Section 4', 'FAS3', 'N/A', '2023-04-26 13:27:13'),
(87, 'Daihatsu D54L', 'Section 4', 'FAS3', 'N/A', '2023-04-26 13:27:13'),
(88, 'Tube Cutting Area', 'Section 8', 'FAS4', 'N/A', '2023-04-26 13:27:13'),
(89, 'Setup Work Shop SWS1', 'Setup Work Shop', 'FAS1', 'N/A', '2023-04-26 13:27:13'),
(90, 'Setup Work Shop SWS3', 'Setup Work Shop', 'FAS3', 'N/A', '2023-04-26 13:27:13'),
(91, 'Zaihai Shop / Suzuki Zaihai', 'Zaihai Shop', 'FAS1', 'N/A', '2023-04-26 13:27:13'),
(92, 'Zaihai Shop / Suzuki Y2R Zaihai', 'Zaihai Shop', 'FAS2', 'N/A', '2023-04-26 13:27:13'),
(93, 'Nissan J32B First Process', 'Section 4', 'FAS2', 'N/A', '2023-04-26 13:27:13'),
(94, 'Nissan J32B Secondary Process', 'Section 4', 'FAS2', 'N/A', '2023-04-26 13:27:13'),
(95, 'Nissan J32B', 'Section 4', 'FAS2', 'N/A', '2023-04-26 13:27:13'),
(96, 'Daihatsu D92A First Process', 'Section 4', 'FAS3', 'N/A', '2023-04-26 13:27:13'),
(97, 'Daihatsu D92A Secondary Process', 'Section 4', 'FAS3', 'N/A', '2023-04-26 13:27:13'),
(98, 'Daihatsu D92A', 'Section 4', 'FAS3', 'N/A', '2023-04-26 13:27:13'),
(99, 'Honda 3S5A First Process', 'Section 6', 'FAS3', 'N/A', '2023-04-26 13:27:13'),
(100, 'Honda 3S5A Secondary Process', 'Section 6', 'FAS3', 'N/A', '2023-04-26 13:27:13'),
(101, 'Honda 3S5A', 'Section 6', 'FAS3', 'N/A', '2023-04-26 13:27:13'),
(102, 'Honda TTA First Process', 'Section 6', 'FAS3', 'N/A', '2023-04-26 13:27:14'),
(103, 'Honda TTA Secondary Process', 'Section 6', 'FAS3', 'N/A', '2023-04-26 13:27:14'),
(104, 'Honda TTA', 'Section 6', 'FAS3', 'N/A', '2023-04-26 13:27:14'),
(105, 'Mazda J78A First Process', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:14'),
(106, 'Mazda J78A Secondary Process', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:14'),
(107, 'Mazda J78A', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:14'),
(108, 'Subaru GC7 First Process', 'Section 5', 'FAS3', 'N/A', '2023-04-26 13:27:14'),
(109, 'Subaru GC7 Secondary Process', 'Section 5', 'FAS3', 'N/A', '2023-04-26 13:27:14'),
(110, 'Subaru GC7', 'Section 5', 'FAS3', 'N/A', '2023-04-26 13:27:14'),
(111, 'Subaru GA9 First Process', 'Section 5', 'FAS3', 'N/A', '2023-04-26 13:27:14'),
(112, 'Subaru GA9 Secondary Process', 'Section 5', 'FAS3', 'N/A', '2023-04-26 13:27:14'),
(113, 'Subaru GA9', 'Section 5', 'FAS3', 'N/A', '2023-04-26 13:27:14'),
(114, 'Suzuki Y3J First Process', 'Section 1', 'FAS1', 'N/A', '2023-04-26 13:27:14'),
(115, 'Suzuki Y3J Secondary Process', 'Section 1', 'FAS1', 'N/A', '2023-04-26 13:27:14'),
(116, 'Suzuki Y3J', 'Section 1', 'FAS1', 'N/A', '2023-04-26 13:27:14'),
(117, 'Suzuki Y6L First Process', 'Section 1', 'FAS1', 'N/A', '2023-04-26 13:27:14'),
(118, 'Suzuki Y6L Secondary Process', 'Section 1', 'FAS1', 'N/A', '2023-04-26 13:27:14'),
(119, 'Suzuki Y6L', 'Section 1', 'FAS1', 'N/A', '2023-04-26 13:27:14'),
(120, 'Suzuki YT3 First Process', 'Section 1', 'FAS2', 'N/A', '2023-04-26 13:27:14'),
(121, 'Suzuki YT3 Secondary Process', 'Section 1', 'FAS2', 'N/A', '2023-04-26 13:27:14'),
(122, 'Suzuki YT3', 'Section 1', 'FAS2', 'N/A', '2023-04-26 13:27:14'),
(123, 'Suzuki YV7 First Process', 'Section 1', 'FAS1', 'N/A', '2023-04-26 13:27:14'),
(124, 'Suzuki YV7 Secondary Process', 'Section 1', 'FAS1', 'N/A', '2023-04-26 13:27:14'),
(125, 'Suzuki YV7', 'Section 1', 'FAS1', 'N/A', '2023-04-26 13:27:14'),
(126, 'Toyota 200D / Daihatsu First Process', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:15'),
(127, 'Toyota 200D / Daihatsu Secondary Process', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:15'),
(128, 'Toyota 200D / Daihatsu', 'Section 3', 'FAS2', 'N/A', '2023-04-26 13:27:15'),
(129, 'EQ-Initial', 'EQ', 'FAS4', 'N/A', '2023-06-02 09:49:59');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location`, `date_updated`) VALUES
(1, 'FAS1', '2023-02-03 13:49:31'),
(2, 'FAS2', '2023-02-03 13:49:31'),
(3, 'FAS3', '2023-02-03 13:49:31'),
(5, 'FAS4', '2023-04-13 13:26:03'),
(6, 'Event Area', '2023-04-13 13:26:03'),
(7, 'Warehouse', '2023-04-13 13:28:47'),
(8, 'Setup Work Shop', '2023-04-13 13:28:47'),
(9, 'Aluminum Area', '2023-04-13 13:28:47'),
(10, 'Zaihai Shop', '2023-04-13 13:28:47'),
(11, 'FAS', '2023-04-13 13:28:47');

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `id` int(10) UNSIGNED NOT NULL,
  `number` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `process` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trd` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `ns-iv` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machines`
--

INSERT INTO `machines` (`id`, `number`, `process`, `machine_name`, `trd`, `ns-iv`, `date_updated`) VALUES
(1, 2, 'Initial', 'Automatic Cutting & Crimping Machine', 1, 0, '2023-04-11 10:46:28'),
(2, 1, 'Initial', '2 Tons Crimping Machine', 0, 0, '2023-04-11 10:46:28'),
(3, 0, 'Initial', '4 Tons Crimping Machine', 0, 0, '2023-04-11 10:46:28'),
(4, 1, 'Initial', '5 Tons Crimping Machine', 0, 0, '2023-04-11 10:46:29'),
(5, 0, 'Initial', '20 Tons Crimping Machine', 0, 0, '2023-04-11 10:46:29'),
(6, 0, 'Initial', 'Casting Machine', 0, 0, '2023-04-11 10:46:29'),
(7, 0, 'Initial', 'Corrugated Tube Cutting Machine', 0, 0, '2023-04-11 10:46:29'),
(8, 0, 'Initial', 'Dip Soldering Machine', 0, 0, '2023-04-11 10:46:29'),
(9, 0, 'Initial', 'Intermediate Insulation-Stripping Machine', 0, 0, '2023-04-11 10:46:29'),
(10, 0, 'Initial', 'Intermediate Stripping Machine', 0, 0, '2023-04-11 10:46:29'),
(11, 0, 'Initial', 'Joint Taping Machine', 0, 0, '2023-04-11 10:46:29'),
(12, 0, 'Initial', 'Multi Resistance Welding Machine', 0, 0, '2023-04-11 10:46:29'),
(13, 0, 'Initial', 'Lamp Connector Pressure Welding Machine', 0, 0, '2023-04-11 10:46:29'),
(14, 0, 'Initial', 'Cable Stripper', 0, 0, '2023-04-11 10:46:29'),
(15, 0, 'Initial', 'Quick Stripper', 0, 0, '2023-04-11 10:46:29'),
(16, 0, 'Initial', 'Semi Automatic Component Cutter', 0, 0, '2023-04-11 10:46:29'),
(17, 4, 'Initial', 'Silicon Injection Machine', 0, 0, '2023-04-11 10:46:29'),
(18, 0, 'Initial', 'Low Viscous Silicon Injection Machine', 0, 0, '2023-04-11 10:46:30'),
(19, 0, 'Initial', 'Single Wire Twisting Machine', 0, 0, '2023-04-11 10:46:30'),
(20, 0, 'Initial', 'Multi Wire Twisting Machine', 0, 0, '2023-04-11 10:46:30'),
(21, 0, 'Initial', 'Multi Twisting Machine', 0, 0, '2023-04-11 10:46:30'),
(22, 0, 'Initial', 'Strip Crimper', 0, 0, '2023-04-11 10:46:30'),
(23, 0, 'Initial', 'Tube Cutting Machine', 0, 0, '2023-04-11 10:46:30'),
(24, 0, 'Initial', 'Water Proof Tube Heat Shrinker', 0, 0, '2023-04-11 10:46:30'),
(25, 5, 'Initial', 'Wire Stripper', 0, 0, '2023-04-11 10:46:30'),
(26, 0, 'Initial', 'Mira 230', 0, 0, '2023-04-11 10:46:30'),
(27, 0, 'Initial', 'Cosmic 927R', 0, 0, '2023-04-11 10:46:30'),
(28, 0, 'Initial', 'Cosmic 60R', 0, 0, '2023-04-11 10:46:30'),
(29, 0, 'Initial', 'LA Mold Machine', 0, 0, '2023-04-11 10:46:30'),
(30, 0, 'Initial', 'Ultrasonic Soldering System', 0, 0, '2023-04-11 10:46:30'),
(31, 0, 'Initial', 'UV Coating Machine', 0, 0, '2023-04-11 10:46:30'),
(32, 0, 'Initial', 'Vacuum Defoaming Machine', 0, 0, '2023-04-11 10:46:30'),
(33, 0, 'Initial', 'Aluminum Wire\'s Terminal Measure Inspection Machine', 0, 0, '2023-04-11 10:46:30'),
(34, 0, 'Initial', 'Aluminum Anti Corrosion Coating Machine', 0, 0, '2023-04-11 10:46:30'),
(35, 0, 'Initial', 'Aluminum Corrosion Proof Inspection Machine', 0, 0, '2023-04-11 10:46:30'),
(36, 0, 'Initial', 'Enlarged Terminal Check Machine', 0, 0, '2023-04-11 10:46:30'),
(37, 0, 'Initial', 'Aluminum Visual Inspection Machine', 0, 0, '2023-04-11 10:46:31'),
(38, 0, 'Initial', 'COT Making Machine ( V-100, KTC-50, ES-065D,  FH-035D, SAL-460, SHD-50, SC-040, RW-040, A-300 )', 0, 0, '2023-04-11 10:46:31'),
(39, 0, 'Initial', 'COT Making Machine ( KTC-50, ES-065D, FH-035D, SAL-460, SHD-50, SC-040, RW-040 )', 0, 0, '2023-04-11 10:46:31'),
(40, 0, 'Initial', 'COT Making Machine', 0, 0, '2023-04-11 10:46:31'),
(41, 0, 'Initial', 'VO Making Machine', 0, 0, '2023-04-11 10:46:31'),
(42, 0, 'Initial', 'Vinyl Sheet Processing Machine', 0, 0, '2023-04-11 10:46:31'),
(43, 0, 'Initial', 'NS-IV', 0, 1, '2023-04-11 10:46:31'),
(44, 0, 'Initial', 'Automatic Cutting, Crimping and Twisting Machine', 0, 0, '2023-04-11 10:46:31'),
(45, 0, 'Initial', 'Waterproof Pad Crimp Machine', 0, 0, '2023-04-11 10:46:31'),
(46, 0, 'Initial', 'V Type Twisting Machine', 0, 0, '2023-04-11 10:46:31'),
(47, 0, 'Initial', 'Desktop Servo Press', 0, 0, '2023-04-11 10:46:31'),
(48, 0, 'Initial', 'Coaxstrip (6580)', 0, 0, '2023-04-11 10:46:31'),
(49, 0, 'Initial', 'Kokuripper', 0, 0, '2023-04-11 10:46:31'),
(50, 0, 'Initial', 'Wire Tip Processing Device Machine', 0, 0, '2023-04-11 10:46:31'),
(51, 0, 'Initial', 'Ultra Sonic Welding Machine', 0, 0, '2023-04-11 10:46:31'),
(52, 0, 'Initial', 'Temporary Servo Press Machine', 0, 0, '2023-04-11 10:46:32'),
(53, 3, 'Final', '0.64 Terminal insertion guide device', 0, 0, '2023-04-11 10:46:32'),
(54, 0, 'Final', 'Assembly Conveyor', 0, 0, '2023-04-11 10:46:32'),
(55, 3, 'Final', 'AIR GROMMET OPENER (Air Type)', 0, 0, '2023-04-11 10:46:32'),
(56, 0, 'Final', 'ASSY BOARD HOLE PUNCHER', 0, 0, '2023-04-11 10:46:32'),
(57, 0, 'Final', 'DUMMY PLUG DETECTORS', 0, 0, '2023-04-11 10:46:32'),
(58, 0, 'Final', 'SILICON APPLICATOR FOR WATERPROOFING', 0, 0, '2023-04-11 10:46:32'),
(59, 0, 'Final', 'FUSE IMAGE INSPECTOR APPARATUS', 0, 0, '2023-04-11 10:46:32'),
(60, 0, 'Final', 'Grease Injection Machine', 0, 0, '2023-04-11 10:46:32'),
(61, 0, 'Final', 'DYNALAB TEST SYSTEM (NXSOLO256)', 0, 0, '2023-04-11 10:46:32'),
(62, 0, 'Final', 'GROMMET WATERPROOFING (HELIUM) EQUIPMENT', 0, 0, '2023-04-11 10:46:32'),
(63, 0, 'Final', 'UN-LOCKED TERMINAL PULL CHECKERS', 0, 0, '2023-04-11 10:46:32'),
(64, 0, 'Final', 'ARM TYPE TORQUE TIGHTENER', 0, 0, '2023-04-11 10:46:32'),
(65, 4, 'Final', 'CONTINUITY TESTER (OMI-10 / 100)', 0, 0, '2023-04-11 10:46:32'),
(66, 0, 'Final', 'COMPONENT PARALLEL DETECTING SYSTEM', 0, 0, '2023-04-11 10:46:32'),
(67, 0, 'Final', 'IDENTIFICATION TAPE DETECTING DEVICE', 0, 0, '2023-04-11 10:46:32'),
(68, 0, 'Final', 'LONG GROMMET INSERTION MACHINE', 0, 0, '2023-04-11 10:46:33'),
(69, 0, 'Final', 'BEND TERMINAL INSPECTION JIG', 0, 0, '2023-04-11 10:46:33'),
(70, 0, 'Final', 'FHC-800SP', 0, 0, '2023-04-11 10:46:33'),
(71, 0, 'Final', 'FHC-01', 0, 0, '2023-04-11 10:46:33'),
(72, 0, 'Final', 'DOME LAMP LIGHTING INSPECTION MACHINE', 0, 0, '2023-04-11 10:46:33'),
(73, 1, 'Final', 'Band Tightener', 0, 0, '2023-04-11 10:46:33'),
(74, 4, 'Final', 'NMF Machine', 0, 0, '2023-05-04 11:22:31');

-- --------------------------------------------------------

--
-- Table structure for table `machine_history`
--

CREATE TABLE `machine_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `number` int(10) UNSIGNED NOT NULL,
  `process` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_spec` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grid` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `equipment_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_tag_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trd_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ns-iv_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `machine_status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_grid` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_date` date NOT NULL DEFAULT current_timestamp(),
  `history_date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machine_history`
--

INSERT INTO `machine_history` (`id`, `number`, `process`, `machine_name`, `machine_spec`, `car_model`, `location`, `grid`, `machine_no`, `equipment_no`, `asset_tag_no`, `trd_no`, `ns-iv_no`, `machine_status`, `new_car_model`, `new_location`, `new_grid`, `pic`, `status_date`, `history_date_time`) VALUES
(2, 1, 'Initial', 'Wire Stripper', '', 'Subaru', 'FAS3', '', 'M-1', '', 'N/A', '', '', 'DISPOSED', '', '', '', 'Admin', '2023-05-15', '2023-05-15 15:21:45'),
(3, 3, 'Final', '0.64 Terminal insertion guide device', '', 'Toyota 4110', 'FAS2', '', 'M-5', '', 'N/A', '', '', 'UNUSED', '', '', '', 'Admin', '2023-05-16', '2023-05-16 13:46:45'),
(4, 2, 'Final', '0.64 Terminal insertion guide device', '', 'Suzuki 5101', 'FAS1', '', 'M-4', '', 'N/A', '', '', 'UNUSED', '', '', '', 'Admin', '2023-05-16', '2023-05-16 13:54:55'),
(6, 3, 'Final', '0.64 Terminal insertion guide device', '', 'Toyota 4110', 'FAS2', '', 'M-5', '', 'N/A', '', '', 'BORROWED', '', '', '', 'Admin', '2023-05-16', '2023-05-16 13:56:12'),
(7, 2, 'Final', '0.64 Terminal insertion guide device', '', 'Suzuki 5101', 'FAS1', '', 'M-4', '', 'N/A', '', '', 'SOLD', '', '', '', 'Admin', '2023-05-16', '2023-05-16 13:57:36'),
(18, 2, 'Initial', 'Wire Stripper', '', 'Mazda Secondary Process', 'FAS2', 'G7', 'M-2', 'EQ-5', 'N/A', '', '', 'UNUSED', '', '', '', 'Admin', '2023-05-30', '2023-05-30 11:37:03'),
(20, 1, 'Initial', 'VO Making Machine', '', 'Tube Cutting Area', 'FAS4', '', 'M-3', '', 'N/A', '', '', 'Setup', '', '', '', 'Admin', '2023-07-28', '2023-08-01 13:29:42'),
(21, 1, 'Final', 'CONTINUITY TESTER (OMI-10 / 100)', '', 'Mazda Merge', 'FAS2', '', 'M-20', '', 'N/A', '', '', 'Setup', '', '', '', 'Admin', '2023-08-29', '2023-08-29 18:22:16'),
(22, 5, 'Initial', 'Wire Stripper', '', 'Daihatsu First Process', 'FAS3', '', 'M-15', '', 'N/A', '', '', 'Setup', '', '', '', 'Setup-1', '2023-09-01', '2023-09-01 17:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `machine_masterlist`
--

CREATE TABLE `machine_masterlist` (
  `id` int(10) UNSIGNED NOT NULL,
  `number` int(10) UNSIGNED NOT NULL,
  `process` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_spec` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grid` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `equipment_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_tag_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trd_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ns-iv_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `machine_status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_new` tinyint(1) NOT NULL DEFAULT 1,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machine_masterlist`
--

INSERT INTO `machine_masterlist` (`id`, `number`, `process`, `machine_name`, `machine_spec`, `car_model`, `location`, `grid`, `machine_no`, `equipment_no`, `asset_tag_no`, `trd_no`, `ns-iv_no`, `machine_status`, `is_new`, `date_updated`) VALUES
(3, 1, 'Initial', 'Automatic Cutting & Crimping Machine', '', 'EQ-Initial', 'FAS4', '', '', 'EQ-1', 'N/A', 'TRD-101', '', '', 1, '2023-09-02 11:32:28'),
(5, 1, 'Initial', 'NS-IV', '', 'EQ-Initial', 'FAS4', '', '', 'EQ-2', 'N/A', '', 'SAM 101', '', 1, '2023-05-13 09:14:13'),
(6, 1, 'Final', '0.64 Terminal insertion guide device', '', 'EQ-Final', 'FAS4', '', '', 'EQ-3', 'N/A', '', '', '', 1, '2023-04-13 09:38:55'),
(8, 1, 'Initial', 'Wire Stripper', '', 'EQ-Initial', 'FAS4', '', 'M-1', '', 'N/A', '', '', 'DISPOSED', 0, '2023-09-16 14:47:10'),
(9, 2, 'Initial', 'Wire Stripper', '', 'Mazda Secondary Process', 'FAS2', 'G7', 'M-2', 'EQ-5', 'N/A', '', '', 'UNUSED', 0, '2023-05-30 11:37:03'),
(11, 1, 'Initial', 'VO Making Machine', '', 'Tube Cutting Area', 'FAS4', '', 'M-3', '', 'N/A', '', '', 'Setup', 0, '2023-04-27 09:37:38'),
(12, 2, 'Initial', 'Automatic Cutting & Crimping Machine', '', 'EQ-Initial', 'FAS4', '', '', 'EQ-7', 'N/A', 'TRD-102', '', '', 1, '2023-04-29 15:40:37'),
(13, 2, 'Final', '0.64 Terminal insertion guide device', '', 'EQ-Final', 'FAS4', '', 'M-4', '', 'N/A', '', '', 'SOLD', 0, '2023-04-29 15:40:37'),
(14, 3, 'Final', '0.64 Terminal insertion guide device', '', 'EQ-Final', 'FAS4', '', 'M-5', '', 'N/A', '', '', 'BORROWED', 0, '2023-04-29 15:40:37'),
(15, 1, 'Initial', '5 Tons Crimping Machine', '', 'EQ-Initial', 'FAS4', '', '', 'EQ-8', 'N/A', '', '', '', 1, '2023-04-29 15:42:02'),
(16, 1, 'Initial', '2 Tons Crimping Machine', '', 'EQ-Initial', 'FAS4', '', 'M-11', 'EQ-11', 'N/A', '', '', '', 1, '2023-08-01 17:44:26'),
(17, 1, 'Final', 'Band Tightener', '', 'EQ-Final', 'FAS4', '', 'M-12', 'EQ-12', 'N/A', '', '', '', 1, '2023-08-01 17:46:04'),
(18, 3, 'Initial', 'Wire Stripper', '', 'EQ-Initial', 'FAS4', '', 'M-13', '', 'N/A', '', '', '', 1, '2023-08-25 10:17:49'),
(19, 4, 'Initial', 'Wire Stripper', '', 'EQ-Initial', 'FAS4', '', 'M-14', '', 'N/A', '', '', '', 1, '2023-08-25 10:34:46'),
(20, 5, 'Initial', 'Wire Stripper', '', 'Daihatsu First Process', 'FAS3', '', 'M-15', '', 'N/A', '', '', 'Setup', 0, '2023-08-25 10:34:46'),
(21, 1, 'Final', 'CONTINUITY TESTER (OMI-10 / 100)', '', 'Mazda Merge', 'FAS2', '', 'M-20', '', 'N/A', '', '', 'Setup', 0, '2023-08-29 09:40:36'),
(22, 2, 'Final', 'CONTINUITY TESTER (OMI-10 / 100)', '', 'EQ-Final', 'FAS4', '', 'M-21', '', 'N/A', '', '', '', 1, '2023-08-29 09:40:36'),
(23, 3, 'Final', 'CONTINUITY TESTER (OMI-10 / 100)', '', 'EQ-Final', 'FAS4', '', 'M-22', '', 'N/A', '', '', '', 1, '2023-08-29 09:40:36'),
(24, 1, 'Final', 'NMF Machine', '', 'EQ-Final', 'FAS4', '', 'M-23', '', 'N/A', '', '', '', 1, '2023-08-29 09:40:36'),
(25, 2, 'Final', 'NMF Machine', '', 'EQ-Final', 'FAS4', '', 'M-24', '', 'N/A', '', '', '', 1, '2023-08-29 09:40:36'),
(26, 3, 'Final', 'NMF Machine', '', 'EQ-Final', 'FAS4', '', 'M-25', '', 'N/A', '', '', '', 1, '2023-08-29 09:40:36'),
(27, 4, 'Final', 'CONTINUITY TESTER (OMI-10 / 100)', '', 'EQ-Final', 'FAS4', '', 'M-26', '', 'N/A', '', '', '', 1, '2023-08-29 09:42:49'),
(28, 4, 'Final', 'NMF Machine', '', 'EQ-Final', 'FAS4', '', 'M-27', '', 'N/A', '', '', '', 1, '2023-08-29 09:42:49'),
(53, 1, 'Final', 'AIR GROMMET OPENER (Air Type)', '', 'Mazda 1125', 'FAS2', '', 'M-28', '', 'N/A', '', '', 'Setup', 0, '2023-09-07 17:20:04'),
(54, 2, 'Final', 'AIR GROMMET OPENER (Air Type)', '', 'Mazda 1125', 'FAS2', '', 'M-29', '', 'N/A', '', '', 'Setup', 0, '2023-09-07 17:20:04'),
(55, 3, 'Final', 'AIR GROMMET OPENER (Air Type)', '', 'Mazda 1125', 'FAS2', '', 'M-30', '', 'N/A', '', '', 'Setup', 0, '2023-09-07 17:20:04'),
(72, 1, 'Initial', 'Silicon Injection Machine', '----------', 'Honda TG7 First Process', 'FAS3', '', 'M-31', '', 'N/A', '', '', 'UNUSED', 0, '2023-09-19 17:02:26'),
(73, 2, 'Initial', 'Silicon Injection Machine', '----------', 'Honda TG7 First Process', 'FAS3', '', 'M-32', '', 'N/A', '', '', 'UNUSED', 0, '2023-09-19 17:02:26'),
(74, 3, 'Initial', 'Silicon Injection Machine', '----------', 'Honda TG7 First Process', 'FAS3', '', 'M-33', '', 'N/A', '', '', 'UNUSED', 0, '2023-09-19 17:02:26'),
(75, 4, 'Initial', 'Silicon Injection Machine', '----------', 'Honda TG7 First Process', 'FAS3', '', 'M-34', '', 'N/A', '', '', 'UNUSED', 0, '2023-09-19 17:02:26');

-- --------------------------------------------------------

--
-- Table structure for table `machine_pm_accounts`
--

CREATE TABLE `machine_pm_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `process` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machine_pm_accounts`
--

INSERT INTO `machine_pm_accounts` (`id`, `username`, `password`, `name`, `role`, `process`, `date_updated`) VALUES
(1, 'admin', 'admin', 'Admin', 'Admin', 'Initial', '2023-04-05 14:54:39'),
(2, 'admin2', 'admin2', 'Admin2', 'Admin', 'Final', '2023-04-20 14:44:59'),
(3, 'a\'d\'m\'in', 'Admin\'123\'', 'a\'d\'m\'in', 'Admin', 'N/A', '2023-04-20 15:05:57'),
(4, 'qa', 'qa', 'QA', 'QA', 'N/A', '2023-04-27 13:58:17'),
(5, 'prod', 'prod', 'Prod', 'Prod', 'N/A', '2023-04-27 13:58:17'),
(6, 'pm1', 'pm1', 'PM-1', 'PM', 'Initial', '2023-05-09 09:41:33'),
(7, 'pm2', 'pm2', 'PM-2', 'PM', 'Initial', '2023-05-09 14:27:47'),
(8, 'pm3', 'pm3', 'PM-3', 'PM', 'Final', '2023-05-09 14:27:47');

-- --------------------------------------------------------

--
-- Table structure for table `machine_pm_concerns`
--

CREATE TABLE `machine_pm_concerns` (
  `id` int(10) UNSIGNED NOT NULL,
  `pm_concern_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_line` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trd_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ns-iv_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `problem` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_by_id_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `concern_date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `confirm_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirm_by_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_spare` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `no_of_parts` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_pm` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_sp` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machine_pm_concerns`
--

INSERT INTO `machine_pm_concerns` (`id`, `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `request_by_id_no`, `concern_date_time`, `confirm_by`, `confirm_by_username`, `comment`, `no_spare`, `no_of_parts`, `status`, `is_read`, `is_read_pm`, `is_read_sp`) VALUES
(5, 'PM-C:23050604ed386', 'Honda First Process/SAM 101/', 'NS-IV', 'Honda First Process', NULL, NULL, 'Failed to open PC', 'Operator 3', 'OP-3', '2023-05-06 16:13:46', 'Admin', 'admin', 'Waiting for spare PC', 0, 0, 'Pending', 1, 1, 0),
(8, 'PM-C:23051106c1d8c', 'Honda First Process/TRD-102/', 'Automatic Cutting & Crimping Machine', 'Honda First Process', NULL, NULL, 'Cannot Cut', 'Operator 4', '', '2023-05-11 18:36:07', 'Admin2', 'admin2', 'NO SPARE', 1, 6, 'Pending', 1, 1, 1),
(10, 'PM-C:23052409c1650', 'AME Area/ASSY BOARD HOLE PUNCHER/', 'ASSY BOARD HOLE PUNCHER', 'AME Area', NULL, NULL, 'Puncher fails', 'ME', '', '2023-05-24 09:37:35', 'Admin2', 'admin2', 'NO SPARE', 1, 2, 'Pending', 1, 1, 1),
(11, 'PM-C:23052410a3dde', 'Honda 3158/AIR GROMMET OPENER (Air Type)/', 'AIR GROMMET OPENER (Air Type)', 'Honda 3158', NULL, NULL, 'Some problems exists', 'ME', '', '2023-05-24 10:38:27', 'Admin2', 'admin2', 'NO SPARE', 1, 2, 'Pending', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `machine_pm_concerns_history`
--

CREATE TABLE `machine_pm_concerns_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `pm_concern_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_line` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trd_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ns-iv_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `problem` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_by_id_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `concern_date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `confirm_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirm_by_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_spare` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `no_of_parts` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_pm` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_sp` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machine_pm_concerns_history`
--

INSERT INTO `machine_pm_concerns_history` (`id`, `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `request_by_id_no`, `concern_date_time`, `confirm_by`, `confirm_by_username`, `comment`, `no_spare`, `no_of_parts`, `status`, `is_read`, `is_read_pm`, `is_read_sp`) VALUES
(3, 'PM-C:2305060173148', 'Honda First Process/TRD-101/', 'Automatic Cutting & Crimping Machine', 'Honda First Process', NULL, NULL, 'Not Working', 'EQ PERSONNEL', 'EQD-1', '2023-05-06 13:18:35', 'Admin', 'admin', 'DONE', 0, 0, 'Done', 0, 1, 0),
(4, 'PM-C:2305060419844', 'Subaru/Wire Stripper/', 'Wire Stripper', 'Subaru', NULL, NULL, 'Cannot Strip', 'Operator 2', 'OP-2', '2023-05-06 16:12:08', 'Admin2', 'admin2', 'DONE', 1, 1, 'Done', 1, 1, 0),
(6, 'PM-C:23050803a4940', 'Daihatsu D92 First Process/5 Tons Crimping Machine/', '5 Tons Crimping Machine', 'Daihatsu D92 First Process', NULL, NULL, 'Cannot Crimp Properly', 'EQ PERSONNEL', '', '2023-05-08 15:35:20', 'Admin', 'admin', 'DONE', 0, 0, 'Done', 0, 1, 0),
(7, 'PM-C:230508044ffce', 'Tube Cutting Area/VO Making Machine/', 'VO Making Machine', 'Tube Cutting Area', NULL, NULL, 'Cannot Make Tubes', 'Operator 3', '', '2023-05-08 16:43:38', 'Admin', 'admin', 'DONE', 0, 0, 'Done', 1, 1, 0),
(9, 'PM-C:230524098a33b', 'Tube Cutting Area/Tube Cutting Machine/', 'Tube Cutting Machine', 'Tube Cutting Area', NULL, NULL, 'Rusty Cutter', 'ME', '', '2023-05-24 09:36:05', 'Admin', 'admin', 'DONE', 1, 1, 'Done', 0, 1, 1),
(13, 'PM-C:2308250760c10', 'Daihatsu 2102/0.64 Terminal insertion guide device/', '0.64 Terminal insertion guide device', 'Daihatsu 2102', NULL, NULL, 'Problem Exists on Terminal', 'ME2', '', '2023-08-25 07:38:27', 'Admin', 'admin', 'DONE', 1, 3, 'Done', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `machine_pm_docs`
--

CREATE TABLE `machine_pm_docs` (
  `id` int(10) UNSIGNED NOT NULL,
  `process` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_docs_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(260) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machine_pm_docs`
--

INSERT INTO `machine_pm_docs` (`id`, `process`, `machine_name`, `machine_docs_type`, `file_name`, `file_type`, `file_url`, `date_updated`) VALUES
(13, 'Final', '0.64 Terminal insertion guide device', 'WI', 'EMS-Setup_SOU-2023-06-05.csv', 'text/csv', 'http://172.25.112.131/uploads/ems/pm/machine_docs/wi/EMS-Setup_SOU-2023-06-05.csv', '2023-06-08 09:45:00'),
(14, 'Final', '0.64 Terminal insertion guide device', 'RSIR', 'EMS-Setup_FAT-2023-06-05.csv', 'text/csv', 'http://172.25.112.131/uploads/ems/pm/machine_docs/rsir/EMS-Setup_FAT-2023-06-05.csv', '2023-06-08 09:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `machine_pm_no_spare`
--

CREATE TABLE `machine_pm_no_spare` (
  `id` int(10) UNSIGNED NOT NULL,
  `pm_concern_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_line` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trd_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ns-iv_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `problem` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_by_id_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `concern_date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `confirm_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirm_by_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parts_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `po_date` date DEFAULT NULL,
  `po_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_spare_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_arrived` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machine_pm_no_spare`
--

INSERT INTO `machine_pm_no_spare` (`id`, `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `request_by_id_no`, `concern_date_time`, `confirm_by`, `confirm_by_username`, `comment`, `parts_code`, `quantity`, `po_date`, `po_no`, `no_spare_status`, `date_arrived`, `status`, `date_updated`) VALUES
(7, 'PM-C:23051106c1d8c', 'Honda First Process/TRD-102/', 'Automatic Cutting & Crimping Machine', 'Honda First Process', '', '', 'Cannot Cut', 'Operator 4', '', '2023-05-11 18:36:07', 'Admin2', 'admin2', 'NO SPARE', 'T-7', 100, NULL, NULL, NULL, NULL, 'Pending', '2023-05-23 09:56:17'),
(8, 'PM-C:23051106c1d8c', 'Honda First Process/TRD-102/', 'Automatic Cutting & Crimping Machine', 'Honda First Process', '', '', 'Cannot Cut', 'Operator 4', '', '2023-05-11 18:36:07', 'Admin2', 'admin2', 'NO SPARE', 'T-8', 4, NULL, NULL, NULL, NULL, 'Pending', '2023-05-23 09:56:24'),
(9, 'PM-C:23051106c1d8c', 'Honda First Process/TRD-102/', 'Automatic Cutting & Crimping Machine', 'Honda First Process', '', '', 'Cannot Cut', 'Operator 4', '', '2023-05-11 18:36:07', 'Admin2', 'admin2', 'NO SPARE', 'T-9', 15, NULL, NULL, NULL, NULL, 'Pending', '2023-05-23 09:56:33'),
(10, 'PM-C:23051106c1d8c', 'Honda First Process/TRD-102/', 'Automatic Cutting & Crimping Machine', 'Honda First Process', '', '', 'Cannot Cut', 'Operator 4', '', '2023-05-11 18:36:07', 'Admin2', 'admin2', 'NO SPARE', 'T-10', 10, NULL, NULL, NULL, NULL, 'Pending', '2023-05-23 09:56:45'),
(11, 'PM-C:23051106c1d8c', 'Honda First Process/TRD-102/', 'Automatic Cutting & Crimping Machine', 'Honda First Process', '', '', 'Cannot Cut', 'Operator 4', '', '2023-05-11 18:36:07', 'Admin2', 'admin2', 'NO SPARE', 'T-11', 25, NULL, NULL, NULL, NULL, 'Pending', '2023-05-23 09:56:54'),
(12, 'PM-C:23051106c1d8c', 'Honda First Process/TRD-102/', 'Automatic Cutting & Crimping Machine', 'Honda First Process', '', '', 'Cannot Cut', 'Operator 4', '', '2023-05-11 18:36:07', 'Admin2', 'admin2', 'NO SPARE', 'T-12', 11, NULL, NULL, NULL, NULL, 'Pending', '2023-05-23 09:58:14'),
(15, 'PM-C:23052409c1650', 'AME Area/ASSY BOARD HOLE PUNCHER/', 'ASSY BOARD HOLE PUNCHER', 'AME Area', '', '', 'Puncher fails', 'ME', '', '2023-05-24 09:37:35', 'Admin2', 'admin2', 'NO SPARE', 'T-15', 4, '2023-06-01', '12-46344', 'CLOSE', '2023-06-08', 'Pending', '2023-05-24 09:37:51'),
(16, 'PM-C:23052409c1650', 'AME Area/ASSY BOARD HOLE PUNCHER/', 'ASSY BOARD HOLE PUNCHER', 'AME Area', '', '', 'Puncher fails', 'ME', '', '2023-05-24 09:37:35', 'Admin2', 'admin2', 'NO SPARE', 'T-16', 20, '2023-06-03', '12-45341', 'CLOSE', '2023-08-24', 'Pending', '2023-08-24 13:22:23'),
(17, 'PM-C:23052410a3dde', 'Honda 3158/AIR GROMMET OPENER (Air Type)/', 'AIR GROMMET OPENER (Air Type)', 'Honda 3158', '', '', 'Some problems exists', 'ME', '', '2023-05-24 10:38:27', 'Admin2', 'admin2', 'NO SPARE', 'T-15', 2, '2023-08-20', '234', 'CLOSE', '2023-08-24', 'Pending', '2023-08-24 13:22:43'),
(18, 'PM-C:23052410a3dde', 'Honda 3158/AIR GROMMET OPENER (Air Type)/', 'AIR GROMMET OPENER (Air Type)', 'Honda 3158', '', '', 'Some problems exists', 'ME', '', '2023-05-24 10:38:27', 'Admin2', 'admin2', 'NO SPARE', 'T-16', 10, '2023-08-15', '2512', 'OPEN', NULL, 'Pending', '2023-08-24 13:24:02');

-- --------------------------------------------------------

--
-- Table structure for table `machine_pm_no_spare_history`
--

CREATE TABLE `machine_pm_no_spare_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `pm_concern_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_line` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trd_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ns-iv_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `problem` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_by_id_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `concern_date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `confirm_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirm_by_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parts_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `po_date` date DEFAULT NULL,
  `po_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_spare_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_arrived` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machine_pm_no_spare_history`
--

INSERT INTO `machine_pm_no_spare_history` (`id`, `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `request_by_id_no`, `concern_date_time`, `confirm_by`, `confirm_by_username`, `comment`, `parts_code`, `quantity`, `po_date`, `po_no`, `no_spare_status`, `date_arrived`, `status`, `date_updated`) VALUES
(13, 'PM-C:2305060419844', 'Subaru/Wire Stripper/', 'Wire Stripper', 'Subaru', '', '', 'Cannot Strip', 'Operator 2', 'OP-2', '2023-05-06 16:12:08', 'Admin2', 'admin2', 'NO SPARE', 'T-13', 2, '2023-05-01', '12-43542', 'CLOSE', '2023-05-31', 'Done', '2023-05-23 10:21:46'),
(14, 'PM-C:230524098a33b', 'Tube Cutting Area/Tube Cutting Machine/', 'Tube Cutting Machine', 'Tube Cutting Area', '', '', 'Rusty Cutter', 'ME', '', '2023-05-24 09:36:05', 'Admin2', 'admin2', 'NO SPARE', 'T-14', 1, '2023-05-31', '12-35323', 'CLOSE', '2023-06-10', 'Done', '2023-05-24 09:36:20'),
(19, 'PM-C:2308250760c10', 'Daihatsu 2102/0.64 Terminal insertion guide device/', '0.64 Terminal insertion guide device', 'Daihatsu 2102', '', '', 'Problem Exists on Terminal', 'ME2', '', '2023-08-25 07:38:27', 'Admin', 'admin', 'DONE', 'X-1', 4, '2023-08-20', '69477', 'CLOSE', '2023-08-31', 'Done', '2023-08-25 08:25:08'),
(20, 'PM-C:2308250760c10', 'Daihatsu 2102/0.64 Terminal insertion guide device/', '0.64 Terminal insertion guide device', 'Daihatsu 2102', '', '', 'Problem Exists on Terminal', 'ME2', '', '2023-08-25 07:38:27', 'Admin', 'admin', 'DONE', 'X-2', 12, '2023-08-21', '69944', 'CLOSE', '2023-08-31', 'Done', '2023-08-25 08:25:08'),
(21, 'PM-C:2308250760c10', 'Daihatsu 2102/0.64 Terminal insertion guide device/', '0.64 Terminal insertion guide device', 'Daihatsu 2102', '', '', 'Problem Exists on Terminal', 'ME2', '', '2023-08-25 07:38:27', 'Admin', 'admin', 'DONE', 'X-3', 25, '2023-08-22', '89414', 'CLOSE', '2023-08-31', 'Done', '2023-08-25 08:25:08');

-- --------------------------------------------------------

--
-- Table structure for table `machine_pm_plan`
--

CREATE TABLE `machine_pm_plan` (
  `id` int(10) UNSIGNED NOT NULL,
  `number` int(10) UNSIGNED NOT NULL,
  `process` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_spec` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grid` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `equipment_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `trd_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `ns-iv_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `pm_status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `internal_comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ww_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `frequency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manpower` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shift_engineer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pm_plan_comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pm_plan_year` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ww_start_date` date NOT NULL,
  `ww_next_date` date DEFAULT NULL,
  `sched_start_date_time` datetime DEFAULT NULL,
  `sched_end_date_time` datetime DEFAULT NULL,
  `is_delayed` tinyint(1) NOT NULL DEFAULT 0,
  `delay_frequency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delay_manpower` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delay_start_date_time` datetime DEFAULT NULL,
  `delay_end_date_time` datetime DEFAULT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machine_pm_plan`
--

INSERT INTO `machine_pm_plan` (`id`, `number`, `process`, `machine_name`, `machine_spec`, `car_model`, `location`, `grid`, `machine_no`, `equipment_no`, `trd_no`, `ns-iv_no`, `pm_status`, `machine_status`, `internal_comment`, `ww_no`, `frequency`, `manpower`, `shift_engineer`, `pm_plan_comment`, `pm_plan_year`, `ww_start_date`, `ww_next_date`, `sched_start_date_time`, `sched_end_date_time`, `is_delayed`, `delay_frequency`, `delay_manpower`, `delay_start_date_time`, `delay_end_date_time`, `date_updated`) VALUES
(1, 1, 'Initial', 'Wire Stripper', '', 'Subaru', 'FAS3', '', 'M-1', '', '', '', '', '', '', 'WW1', '6', 'PM-1', '', '', '2023', '2023-01-03', NULL, '2023-01-03 12:00:00', '2023-05-03 17:00:00', 0, '', '', NULL, NULL, '2023-05-03 14:57:50'),
(2, 1, 'Initial', 'Wire Stripper', '', 'Subaru', 'FAS3', '', 'M-1', '', '', '', '', '', '', 'WW26', '6', '', '', '', '2022', '2023-06-05', NULL, NULL, NULL, 0, '', '', NULL, NULL, '2023-05-03 16:27:29'),
(3, 1, 'Initial', 'Wire Stripper', '', 'Subaru', 'FAS3', '', 'M-1', '', '', '', '', '', '', 'WW1', '6', 'PM-1', 'Checker 1', '', '2021', '2021-01-04', '2021-06-07', '2023-05-04 15:17:00', '2023-05-04 15:17:00', 0, '', '', NULL, NULL, '2023-05-03 16:58:56'),
(52, 1, 'Initial', 'Automatic Cutting & Crimping Machine', '', 'Honda First Process', 'FAS3', '', '', 'EQ-1', 'TRD-101', '', 'Done', '', '', 'WW1', 'M', 'PM-2', 'Checker 1', '', '2023', '2023-01-03', '2023-09-24', '2023-01-03 00:00:00', '2023-01-03 17:00:00', 0, '', '', NULL, NULL, '2023-05-05 17:16:31'),
(53, 1, 'Initial', 'Automatic Cutting & Crimping Machine', '', 'Honda First Process', 'FAS3', '', '', 'EQ-1', 'TRD-101', '', 'Waiting For Confirmation', '', '', 'WW5', 'M', 'PM-2', 'Checker 1', '', '2023', '2023-02-06', '2023-09-24', '2023-02-07 12:00:00', '2023-02-07 17:00:00', 0, '', '', NULL, NULL, '2023-05-05 17:17:33'),
(54, 1, 'Initial', 'Automatic Cutting & Crimping Machine', '', 'Honda First Process', 'FAS3', '', '', 'EQ-1', 'TRD-101', '', '', '', '', 'WW10', 'M', 'PM-2', '', '', '2023', '2023-03-06', NULL, '2023-09-16 10:00:00', '2023-09-16 12:00:00', 0, '', '', NULL, NULL, '2023-05-05 17:18:18'),
(55, 1, 'Initial', 'Automatic Cutting & Crimping Machine', '', 'Honda First Process', 'FAS3', '', '', 'EQ-1', 'TRD-101', '', '', '', '', 'WW15', 'M', 'PM-2', '', '', '2023', '2023-04-03', NULL, '2023-09-16 10:00:00', '2023-09-16 12:00:00', 0, '', '', NULL, NULL, '2023-05-05 17:18:55'),
(56, 1, 'Initial', 'VO Making Machine', '', 'Tube Cutting Area', 'FAS4', '', 'M-3', '', '', '', '', '', '', 'WW23', 'W', 'PM-1', '', '', '2023', '2023-05-15', NULL, '2023-05-15 08:50:00', '2023-05-19 08:50:00', 0, '', '', NULL, NULL, '2023-10-10 14:14:11'),
(58, 2, 'Initial', 'Wire Stripper', '', 'Mazda Secondary Process', 'FAS2', 'G7', 'M-2', 'EQ-5', '', '', '', '', '', 'WW23', 'Y', '', '', '', '2023', '2023-05-17', NULL, NULL, NULL, 0, '', '', NULL, NULL, '2023-05-17 13:54:15'),
(69, 5, 'Initial', 'Wire Stripper', '', 'EQ-Initial', 'FAS4', '', 'M-15', '', '', '', '', 'SETUP', 'Setup1\nSetup2', 'WW45', 'Y', '', '', '', '2023', '2023-01-08', NULL, NULL, NULL, 0, '', '', NULL, NULL, '2023-09-15 07:48:39'),
(70, 3, 'Final', 'AIR GROMMET OPENER (Air Type)', '', 'Mazda 1125', 'FAS2', '', 'M-30', '', '', '', 'Done', '', '', 'WW1', 'M', 'PM-1', '', '', '2023', '2023-01-03', NULL, '2023-01-09 07:20:00', '2023-01-13 07:20:00', 0, '', '', NULL, NULL, '2023-10-11 07:16:33');

-- --------------------------------------------------------

--
-- Table structure for table `machine_pm_wo`
--

CREATE TABLE `machine_pm_wo` (
  `id` int(10) UNSIGNED NOT NULL,
  `wo_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `process` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `equipment_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(260) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machine_pm_wo`
--

INSERT INTO `machine_pm_wo` (`id`, `wo_id`, `process`, `machine_name`, `machine_no`, `equipment_no`, `file_name`, `file_type`, `file_url`, `date_updated`) VALUES
(2, 'PM-WO:230511051c9ae', 'Initial', 'Wire Stripper', 'M-1', '', 'WI-TEST.csv', 'text/csv', 'http://172.25.112.131/uploads/ems/pm/wo/WI-TEST.csv', '2023-05-11 17:45:26'),
(3, 'PM-WO:230511050b8c0', 'Initial', 'Wire Stripper', 'M-2', 'EQ-5', 'WI-TEST-V2.csv', 'text/csv', 'http://172.25.112.131/uploads/ems/pm/wo/WI-TEST-V2.csv', '2023-05-11 17:50:37'),
(4, 'PM-WO:230826093c2c9', 'Initial', 'Wire Stripper', 'M-15', '', 'RequestTemplateMPPD1XLS.xls', 'application/vnd.ms-excel', 'http://172.25.112.131/uploads/ems/pm/wo/RequestTemplateMPPD1XLS.xls', '2023-08-26 09:37:34');

-- --------------------------------------------------------

--
-- Table structure for table `machine_setup_accounts`
--

CREATE TABLE `machine_setup_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approver_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `process` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machine_setup_accounts`
--

INSERT INTO `machine_setup_accounts` (`id`, `username`, `password`, `name`, `role`, `approver_role`, `process`, `date_updated`) VALUES
(1, 'admin', 'admin', 'Admin', 'Admin', 'N/A', 'Initial', '2023-04-05 14:50:22'),
(2, 'safety', 'safety', 'Safety', 'Safety', '1', 'N/A', '2023-04-03 15:50:32'),
(3, 'eqm', 'eqm', 'EQ Manager', 'EQ Manager', '2', 'N/A', '2023-04-03 15:51:36'),
(4, 'accounting', 'accounting', 'Accounting', 'Accounting', '3', 'N/A', '2023-04-03 15:52:36'),
(5, 'setup1', 'setup1', 'Setup-1', 'Setup', 'N/A', 'Initial', '2023-05-09 10:37:49'),
(6, 'admin2', 'admin2', 'Admin2', 'Admin', 'N/A', 'Final', '2023-05-12 09:15:10'),
(7, 'setup2', 'setup2', 'Setup-2', 'Setup', 'N/A', 'Initial', '2023-05-12 13:27:56'),
(8, 'setup3', 'setup3', 'Setup-3', 'Setup', 'N/A', 'Final', '2023-05-12 13:27:11'),
(9, 'prod_sv_1', 'prod_sv_1', 'Prod SV 1', 'Production Supervisor', '2', 'N/A', '2023-05-31 15:52:13'),
(10, 'qa_sv_1', 'qa_sv_1', 'QA SV 1', 'QA Supervisor', '2', 'N/A', '2023-05-31 15:52:13'),
(11, 'prod_mgr_1', 'prod_mgr_1', 'Prod MGR 1', 'Production Manager', '2', 'N/A', '2023-07-31 16:41:36'),
(12, 'qa_mgr_1', 'qa_mgr_1', 'QA MGR 1', 'QA Manager', '2', 'N/A', '2023-07-31 16:41:36'),
(13, 'prod_engr_mgr_1', 'prod_engr_mgr_1', 'Prod Engr MGR 1', 'Production Engineering Manager', '2', 'N/A', '2023-07-31 16:42:45'),
(14, 'arman', 'Arman@123', 'Arman Paday', 'Setup', 'N/A', 'Final', '2023-09-01 18:04:04'),
(15, 'Troy_Ace', 'P@trickmahalko21223344556677889910', 'Patrick Troy Mendoza', 'Setup', 'N/A', 'Initial', '2023-09-02 11:46:13'),
(16, 'lawrence', 'Silverblade#14', 'lawrence', 'Admin', 'N/A', 'Initial', '2023-09-01 18:10:28');

-- --------------------------------------------------------

--
-- Table structure for table `machine_setup_activities`
--

CREATE TABLE `machine_setup_activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_details` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_date` date NOT NULL,
  `start_date_time` datetime NOT NULL,
  `end_date_time` datetime NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `decline_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_setup` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machine_setup_activities`
--

INSERT INTO `machine_setup_activities` (`id`, `car_model`, `requestor_name`, `activity_details`, `activity_status`, `activity_date`, `start_date_time`, `end_date_time`, `date_updated`, `decline_reason`, `is_read`, `is_read_setup`) VALUES
(1, '', '', 'TEST 1\nTEST 1 TEST 1 TEST 1\nTEST 1 TEST 1', 'Accepted', '2023-05-17', '2023-05-17 00:00:00', '2023-05-17 23:59:59', '2023-05-19 08:30:57', NULL, 0, 0),
(2, '', '', 'TEST 2\nTEST 2\nTEST 2', 'Accepted', '2023-05-16', '2023-05-16 00:00:00', '2023-05-16 23:59:59', '2023-05-19 08:17:05', NULL, 0, 0),
(3, '', '', 'TEST 3', 'Accepted', '2023-05-18', '2023-05-18 00:00:00', '2023-05-18 23:59:59', '2023-05-17 17:06:46', NULL, 0, 0),
(4, '', '', 'TEST 4\nTEST 4\nTEST 4', 'Accepted', '2023-05-20', '2023-05-20 00:00:00', '2023-05-20 23:59:59', '2023-05-19 08:17:32', NULL, 0, 0),
(5, '', '', 'TEST 5\nTEST 5\nTEST 5', 'Accepted', '2023-05-20', '2023-05-20 00:00:00', '2023-05-20 23:59:59', '2023-05-19 08:17:45', NULL, 0, 0),
(9, '', '', 'TEST 6', 'Accepted', '2023-05-22', '2023-05-22 00:00:00', '2023-05-22 23:59:59', '2023-05-18 15:53:52', NULL, 0, 0),
(10, 'Honda', 'ME', 'TEST 7\nTEST 7 TEST 7 TEST 7\nTEST 7 TEST 7 TEST 7', 'Declined', '2023-05-31', '2023-05-31 00:00:00', '2023-05-31 23:59:59', '2023-05-19 08:48:12', 'May Reason Basta', 0, 0),
(11, 'Nissan / Marelli', 'YOU', 'TEST 8\nTEST 8 TEST 8', 'Accepted', '2023-06-01', '2023-06-01 00:00:00', '2023-06-01 23:59:59', '2023-05-19 16:02:51', NULL, 0, 0),
(12, 'Suzuki Y6L', 'ME', 'TEST 9 TEST 9 TEST 9\nTEST 9\nTEST 9 TEST 9\nTEST 9', 'Accepted', '2023-06-01', '2023-06-01 00:00:00', '2023-06-01 23:59:59', '2023-05-22 09:00:21', NULL, 1, 1),
(13, 'Toyota', 'ME', 'TEST 10\nTEST 10 TEST 10', 'Declined', '2023-06-01', '2023-06-01 00:00:00', '2023-06-01 23:59:59', '2023-05-22 09:08:33', 'TESTING FOR DECLINE', 1, 1),
(14, 'Mazda', 'ME', 'SANA MATAPOS', 'Accepted', '2023-06-03', '2023-06-03 00:00:00', '2023-06-03 23:59:59', '2023-05-22 09:10:55', NULL, 0, 1),
(15, 'Nissan J32B', 'ME', 'BILIS BILIS BILIS', 'Declined', '2023-05-02', '2023-05-02 00:00:00', '2023-05-02 23:59:59', '2023-05-22 09:17:42', 'KAYA MO YAN', 0, 1),
(16, 'Suzuki YD1', 'ME', 'TEST 11 TEST 11', 'Accepted', '2023-05-27', '2023-05-27 00:00:00', '2023-05-27 23:59:59', '2023-05-22 09:23:53', NULL, 0, 1),
(17, 'Subaru', 'ME', 'After Holiday', 'For Confirmation', '2023-06-13', '2023-06-13 00:00:00', '2023-06-13 23:59:59', '2023-05-25 11:10:29', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `machine_setup_docs`
--

CREATE TABLE `machine_setup_docs` (
  `id` int(10) UNSIGNED NOT NULL,
  `process` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_docs_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(260) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machine_setup_docs`
--

INSERT INTO `machine_setup_docs` (`id`, `process`, `machine_name`, `machine_docs_type`, `file_name`, `file_type`, `file_url`, `date_updated`) VALUES
(16, 'Initial', 'Automatic Cutting & Crimping Machine', 'MSTPRC', 'EMS-Setup_SOU-2023-06-05.csv', 'text/csv', 'http://172.25.112.131/uploads/ems/setup/machine_docs/mstprc/EMS-Setup_SOU-2023-06-05.csv', '2023-06-08 11:06:17');

-- --------------------------------------------------------

--
-- Table structure for table `machine_sp_accounts`
--

CREATE TABLE `machine_sp_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approver_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `process` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `machine_sp_accounts`
--

INSERT INTO `machine_sp_accounts` (`id`, `username`, `password`, `name`, `role`, `approver_role`, `process`, `date_updated`) VALUES
(1, 'admin', 'admin', 'Admin', 'Admin', '2', 'Final', '2023-04-05 11:23:54');

-- --------------------------------------------------------

--
-- Table structure for table `notif_pm_approvers`
--

CREATE TABLE `notif_pm_approvers` (
  `id` int(10) UNSIGNED NOT NULL,
  `interface` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pending_rsir` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `approved_rsir` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `disapproved_rsir` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notif_pm_approvers`
--

INSERT INTO `notif_pm_approvers` (`id`, `interface`, `pending_rsir`, `approved_rsir`, `disapproved_rsir`) VALUES
(1, 'ADMIN-PM', 0, 0, 0),
(7, 'APPROVER-PROD-MGR', 0, 0, 0),
(9, 'APPROVER-QA-MGR', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notif_pm_concerns`
--

CREATE TABLE `notif_pm_concerns` (
  `id` int(10) UNSIGNED NOT NULL,
  `interface` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_pm_concerns` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `done_pm_concerns` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `pending_pm_concerns` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notif_pm_concerns`
--

INSERT INTO `notif_pm_concerns` (`id`, `interface`, `new_pm_concerns`, `done_pm_concerns`, `pending_pm_concerns`) VALUES
(1, 'ADMIN-PM', 0, 0, 0),
(2, 'PUBLIC-PAGE', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notif_pm_no_spare`
--

CREATE TABLE `notif_pm_no_spare` (
  `id` int(10) UNSIGNED NOT NULL,
  `interface` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_pm_concerns` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notif_pm_no_spare`
--

INSERT INTO `notif_pm_no_spare` (`id`, `interface`, `new_pm_concerns`) VALUES
(1, 'ADMIN-SP', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notif_setup_activities`
--

CREATE TABLE `notif_setup_activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `interface` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_act_sched` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `accepted_act_sched` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `declined_act_sched` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notif_setup_activities`
--

INSERT INTO `notif_setup_activities` (`id`, `interface`, `new_act_sched`, `accepted_act_sched`, `declined_act_sched`) VALUES
(1, 'ADMIN-SETUP', 0, 0, 0),
(2, 'PUBLIC-PAGE', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notif_setup_approvers`
--

CREATE TABLE `notif_setup_approvers` (
  `id` int(10) UNSIGNED NOT NULL,
  `interface` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pending_mstprc` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `approved_mstprc` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `disapproved_mstprc` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notif_setup_approvers`
--

INSERT INTO `notif_setup_approvers` (`id`, `interface`, `pending_mstprc`, `approved_mstprc`, `disapproved_mstprc`) VALUES
(1, 'ADMIN-SETUP', 0, 0, 0),
(2, 'APPROVER-1-SAFETY', 0, 0, 0),
(3, 'APPROVER-2-EQ-MGR', 0, 0, 0),
(4, 'APPROVER-2-EQ-SP', 0, 0, 0),
(5, 'APPROVER-2-PROD-ENGR-MGR', 2, 0, 0),
(6, 'APPROVER-2-PROD-SV', 0, 0, 0),
(7, 'APPROVER-2-PROD-MGR', 1, 0, 0),
(8, 'APPROVER-2-QA-SV', 0, 0, 0),
(9, 'APPROVER-2-QA-MGR', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pm_rsir`
--

CREATE TABLE `pm_rsir` (
  `id` int(10) UNSIGNED NOT NULL,
  `rsir_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rsir_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '''N/A''',
  `equipment_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '''N/A''',
  `rsir_date` date NOT NULL,
  `judgement_of_eq` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `repair_details` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `repaired_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `repair_date` date NOT NULL,
  `next_pm_date` date NOT NULL,
  `judgement_of_prod` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inspected_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmed_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judgement_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rsir_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rsir_approver_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rsir_process_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `returned_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `returned_date_time` datetime DEFAULT NULL,
  `disapproved_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disapproved_by_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disapproved_comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read_pm` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_prod` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_qa` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `file_name` varchar(260) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rsir_eq_group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pm',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pm_rsir`
--

INSERT INTO `pm_rsir` (`id`, `rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `judgement_of_eq`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `judgement_of_prod`, `inspected_by`, `confirmed_by`, `judgement_by`, `rsir_username`, `rsir_approver_role`, `rsir_process_status`, `returned_by`, `returned_date_time`, `disapproved_by`, `disapproved_by_role`, `disapproved_comment`, `is_read_pm`, `is_read_prod`, `is_read_qa`, `file_name`, `file_type`, `file_url`, `rsir_eq_group`, `date_updated`) VALUES
(6, 'RSIR-231003110332b', 'Regular', 'Silicon Injection Machine', 'M-34', '', '2023-10-06', '', 'GOOD', 'Setup 1', '2023-10-05', '2023-11-01', '', 'Admin', '', '', 'admin', 'Prod', 'Saved', 'Admin', '2023-10-04 08:21:59', '', '', '', 1, 0, 0, 'RSIR-231003110332b-RequestTemplateMPPD1XLS.xls', 'application/vnd.ms-excel', 'http://172.25.112.131:80/uploads/ems/pm/rsir/2023/10/04/RSIR-231003110332b-RequestTemplateMPPD1XLS.xls', 'setup', '2023-10-04 08:22:32'),
(7, 'RSIR-23100311223d9', 'Regular', 'Silicon Injection Machine', 'M-33', '', '2023-10-03', '', 'GOOD', 'PM-2', '2023-10-14', '2023-11-02', '', 'Admin', '', '', 'admin', 'Prod', 'Saved', 'Admin', '2023-10-04 08:23:48', '', '', '', 1, 0, 0, 'RSIR-23100311223d9-RequestTemplateMPPD1XLSX.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'http://172.25.112.131:80/uploads/ems/pm/rsir/2023/10/04/RSIR-23100311223d9-RequestTemplateMPPD1XLSX.xlsx', 'pm', '2023-10-04 08:24:10');

-- --------------------------------------------------------

--
-- Table structure for table `pm_rsir_history`
--

CREATE TABLE `pm_rsir_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `rsir_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rsir_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '''N/A''',
  `equipment_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '''N/A''',
  `rsir_date` date NOT NULL,
  `judgement_of_eq` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `repair_details` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `repaired_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `repair_date` date NOT NULL,
  `next_pm_date` date NOT NULL,
  `judgement_of_prod` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inspected_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmed_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judgement_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rsir_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rsir_approver_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rsir_process_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `returned_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `returned_date_time` datetime DEFAULT NULL,
  `disapproved_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disapproved_by_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disapproved_comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read_pm` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_prod` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_qa` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `file_name` varchar(260) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rsir_eq_group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pm',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pm_rsir_history`
--

INSERT INTO `pm_rsir_history` (`id`, `rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `judgement_of_eq`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `judgement_of_prod`, `inspected_by`, `confirmed_by`, `judgement_by`, `rsir_username`, `rsir_approver_role`, `rsir_process_status`, `returned_by`, `returned_date_time`, `disapproved_by`, `disapproved_by_role`, `disapproved_comment`, `is_read_pm`, `is_read_prod`, `is_read_qa`, `file_name`, `file_type`, `file_url`, `rsir_eq_group`, `date_updated`) VALUES
(1, 'RSIR-23080101a41ef', 'Regular', 'VO Making Machine', 'M-3', '', '2023-08-01', 'O', 'GOOD', 'Setup 1', '2023-08-01', '2023-08-31', 'O', 'Admin2', 'Admin2', 'Prod', 'admin2', 'Prod', 'Approved', '', NULL, '', '', '', 1, 0, 0, 'RSIR-23080101a41ef-Export Accounts.xls', 'application/vnd.ms-excel', 'http://172.25.112.131/uploads/ems/pm/rsir/2023/08/01/RSIR-23080101a41ef-Export%20Accounts.xls', 'setup', '2023-08-01 14:21:12'),
(2, 'RSIR-23082906589dc', 'Regular', 'CONTINUITY TESTER (OMI-10 / 100)', 'M-20', '', '2023-08-31', '◯', 'GOOD', 'Setup 1', '2023-08-31', '2023-09-07', '◯', 'Admin', 'Admin', 'Prod', 'admin', 'Prod', 'Approved', '', NULL, '', '', '', 1, 0, 0, 'RSIR-23082906589dc-RequestTemplateMPPD1XLSX.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'http://172.25.112.131/uploads/ems/pm/rsir/2023/08/29/RSIR-23082906589dc-RequestTemplateMPPD1XLSX.xlsx', 'setup', '2023-09-13 17:54:55'),
(3, 'RSIR-2309130500751', 'Regular', 'VO Making Machine', 'M-3', '', '2023-09-14', '◯', 'GOOD', 'PM-1', '2023-09-14', '2023-10-14', '△', 'Admin', 'Admin', 'Prod', 'admin', 'Prod', 'Approved', '', NULL, '', '', '', 1, 0, 0, 'RSIR-2309130500751-RequestTemplateMPPD1XLSX.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'http://172.25.112.131:80/uploads/ems/pm/rsir/2023/09/13/RSIR-2309130500751-RequestTemplateMPPD1XLSX.xlsx', 'pm', '2023-09-14 07:58:46'),
(4, 'RSIR-23082906b2080', 'Special', 'Wire Stripper', 'M-13', '', '2023-08-31', '◯', 'GOOD', 'Setup 1', '2023-08-31', '2023-09-07', '◯', 'Admin', 'Admin', 'QA', 'admin', 'QA', 'Approved', '', NULL, '', '', '', 1, 0, 0, 'RSIR-23082906b2080-RequestTemplateMPPD1XLS.xls', 'application/vnd.ms-excel', 'http://172.25.112.131/uploads/ems/pm/rsir/2023/08/29/RSIR-23082906b2080-RequestTemplateMPPD1XLS.xls', 'setup', '2023-09-14 08:02:37'),
(5, 'RSIR-23091409e0a3f', 'Regular', 'Wire Stripper', 'M-2', 'EQ-5', '2023-09-28', '◯', 'GOOD', 'PM-2', '2023-09-28', '2023-10-07', '◯', 'Admin', 'Admin', '', 'admin', 'QA', 'Disapproved', '', NULL, 'QA', 'QA', 'TEST DISAPPROVE PM RSIR', 1, 0, 0, 'RSIR-23091409e0a3f-RequestTemplateMPPD1XLSX.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'http://172.25.112.131:80/uploads/ems/pm/rsir/2023/09/14/RSIR-23091409e0a3f-RequestTemplateMPPD1XLSX.xlsx', 'pm', '2023-09-14 09:49:10'),
(6, 'RSIR-23101107aec8b', 'Regular', 'AIR GROMMET OPENER (Air Type)', 'M-30', '', '2023-01-11', '◯', 'GOOD', 'PM-1', '2023-01-10', '2023-02-06', '◯', 'PM-1', 'Admin2', 'QA', 'pm1', 'QA', 'Approved', '', NULL, '', '', '', 1, 0, 0, 'RSIR-23101107aec8b-Exercise Details.xls', 'application/vnd.ms-excel', 'http://172.25.112.131:80/uploads/ems/pm/rsir/2023/10/11/RSIR-23101107aec8b-Exercise%20Details.xls', 'pm', '2023-10-11 07:28:32');

-- --------------------------------------------------------

--
-- Table structure for table `setup_mstprc`
--

CREATE TABLE `setup_mstprc` (
  `id` int(10) UNSIGNED NOT NULL,
  `mstprc_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `equipment_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_date` date NOT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grid` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_new` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `to_car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_grid` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pullout_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transfer_reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pullout_reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_approver_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_eq_member` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_eq_g_leader` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_safety_officer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_eq_manager` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_eq_sp_personnel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_prod_engr_manager` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_prod_supervisor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_prod_manager` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_qa_supervisor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_qa_manager` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_process_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `returned_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `returned_date_time` datetime DEFAULT NULL,
  `disapproved_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disapproved_by_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disapproved_comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fat_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sou_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rsir_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read_setup` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_safety` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_eq_mgr` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_eq_sp` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_prod_engr_mgr` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_prod_sv` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_prod_mgr` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_qa_sv` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_qa_mgr` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `file_name` varchar(260) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setup_mstprc`
--

INSERT INTO `setup_mstprc` (`id`, `mstprc_no`, `mstprc_type`, `machine_name`, `machine_no`, `equipment_no`, `mstprc_date`, `car_model`, `location`, `grid`, `is_new`, `to_car_model`, `to_location`, `to_grid`, `pullout_location`, `transfer_reason`, `pullout_reason`, `mstprc_username`, `mstprc_approver_role`, `mstprc_eq_member`, `mstprc_eq_g_leader`, `mstprc_safety_officer`, `mstprc_eq_manager`, `mstprc_eq_sp_personnel`, `mstprc_prod_engr_manager`, `mstprc_prod_supervisor`, `mstprc_prod_manager`, `mstprc_qa_supervisor`, `mstprc_qa_manager`, `mstprc_process_status`, `returned_by`, `returned_date_time`, `disapproved_by`, `disapproved_by_role`, `disapproved_comment`, `fat_no`, `sou_no`, `rsir_no`, `is_read_setup`, `is_read_safety`, `is_read_eq_mgr`, `is_read_eq_sp`, `is_read_prod_engr_mgr`, `is_read_prod_sv`, `is_read_prod_mgr`, `is_read_qa_sv`, `is_read_qa_mgr`, `file_name`, `file_type`, `file_url`, `date_updated`) VALUES
(21, 'MSTPRC-230901063cc65', 'Setup', 'NS-IV', '', 'EQ-2', '2023-09-20', 'Honda T20A', 'FAS3', 'O8', 1, '', '', '', '', '', '', 'Troy_Ace', 'Prod', 'Patrick Troy Mendoza', 'lawrence', '', '', '', '', '', '', '', '', 'Confirmed', '', NULL, '', '', '', 'FAT:23090106f23b5', 'SOU:23090106c2eaa', '', 1, 0, 0, 0, 0, 0, 0, 0, 0, 'MSTPRC-230901063cc65-MEI-013-04  Set-UP Transfer Pulled Out and Relay Out Check Sheet-SAM (NS-IV, NS-C) Machine.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'http://172.25.112.131/uploads/ems/setup/mstprc/2023/09/01/MSTPRC-230901063cc65-MEI-013-04%20%20Set-UP%20Transfer%20Pulled%20Out%20and%20Relay%20Out%20Check%20Sheet-SAM%20%28NS-IV%2C%20NS-C%29%20Machine.xlsx', '2023-09-01 18:30:42'),
(22, 'MSTPRC-230901066706c', 'Setup', 'Automatic Cutting & Crimping Machine', '', 'EQ-1', '2023-09-21', 'Aluminum / Honda TKRA Aluminum', 'Aluminum Area', '010', 1, '', '', '', '', '', '', 'Troy_Ace', '', 'Patrick Troy Mendoza', '', '', '', '', '', '', '', '', '', 'Saved', '', NULL, '', '', '', 'FAT:23090106a504e', 'SOU:23090106ccc3d', '', 1, 0, 0, 0, 0, 0, 0, 0, 0, 'MSTPRC-230901066706c-MEI-013-04 Set Up Transfer Pulled Out and Relay Out Check Sheet-Automatic Cutting & Crimping (TRD) Machine.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'http://172.25.112.131/uploads/ems/setup/mstprc/2023/09/01/MSTPRC-230901066706c-MEI-013-04%20Set%20Up%20Transfer%20Pulled%20Out%20and%20Relay%20Out%20Check%20Sheet-Automatic%20Cutting%20%26%20Crimping%20%28TRD%29%20Machine.xlsx', '2023-09-01 18:49:29'),
(23, 'MSTPRC-23090106ac919', 'Setup', '0.64 Terminal insertion guide device', '', 'EQ-3', '2023-09-21', 'Daihatsu D01L', 'FAS1', '010', 1, '', '', '', '', '', '', 'Troy_Ace', '', 'Patrick Troy Mendoza', '', '', '', '', '', '', '', '', '', 'Returned', 'Admin', '2023-09-30 11:17:29', '', '', '', 'FAT:230901066097b', 'SOU:23090106bed38', '', 1, 0, 0, 0, 0, 0, 0, 0, 0, 'MSTPRC-23090106ac919-MEI-013-04  Set Up Transfer Pulled Out and Relay Out Check Sheet-Mira 230 Machine.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'http://172.25.112.131/uploads/ems/setup/mstprc/2023/09/01/MSTPRC-23090106ac919-MEI-013-04%20%20Set%20Up%20Transfer%20Pulled%20Out%20and%20Relay%20Out%20Check%20Sheet-Mira%20230%20Machine.xlsx', '2023-09-01 18:55:03'),
(28, 'MSTPRC-2310030980650', 'Setup', 'Silicon Injection Machine', 'M-34', '', '2023-10-03', 'Honda 30AA', 'FAS3', '', 0, '', '', '', '', '', '', 'admin', '', 'Admin', '', '', '', '', '', '', '', '', '', 'Saved', 'Admin', '2023-10-03 09:14:30', '', '', '', 'FAT:23100309e8fd8', '', 'RSIR-231003110332b', 1, 0, 0, 0, 0, 0, 0, 0, 0, 'MSTPRC-2310030980650-AME3 Data (Andon System).xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'http://172.25.112.131:80/uploads/ems/setup/mstprc/2023/10/03/MSTPRC-2310030980650-AME3%20Data%20%28Andon%20System%29.xlsx', '2023-10-03 09:38:12');

-- --------------------------------------------------------

--
-- Table structure for table `setup_mstprc_history`
--

CREATE TABLE `setup_mstprc_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `mstprc_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `equipment_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_date` date NOT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grid` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_new` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `to_car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_grid` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pullout_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transfer_reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pullout_reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_approver_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_eq_member` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_eq_g_leader` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_safety_officer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_eq_manager` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_eq_sp_personnel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_prod_engr_manager` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_prod_supervisor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_prod_manager` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_qa_supervisor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_qa_manager` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mstprc_process_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `returned_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `returned_date_time` datetime DEFAULT NULL,
  `disapproved_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disapproved_by_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disapproved_comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fat_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sou_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rsir_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read_setup` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_safety` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_eq_mgr` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_eq_sp` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_prod_engr_mgr` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_prod_sv` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_prod_mgr` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_qa_sv` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_qa_mgr` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `file_name` varchar(260) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setup_mstprc_history`
--

INSERT INTO `setup_mstprc_history` (`id`, `mstprc_no`, `mstprc_type`, `machine_name`, `machine_no`, `equipment_no`, `mstprc_date`, `car_model`, `location`, `grid`, `is_new`, `to_car_model`, `to_location`, `to_grid`, `pullout_location`, `transfer_reason`, `pullout_reason`, `mstprc_username`, `mstprc_approver_role`, `mstprc_eq_member`, `mstprc_eq_g_leader`, `mstprc_safety_officer`, `mstprc_eq_manager`, `mstprc_eq_sp_personnel`, `mstprc_prod_engr_manager`, `mstprc_prod_supervisor`, `mstprc_prod_manager`, `mstprc_qa_supervisor`, `mstprc_qa_manager`, `mstprc_process_status`, `returned_by`, `returned_date_time`, `disapproved_by`, `disapproved_by_role`, `disapproved_comment`, `fat_no`, `sou_no`, `rsir_no`, `is_read_setup`, `is_read_safety`, `is_read_eq_mgr`, `is_read_eq_sp`, `is_read_prod_engr_mgr`, `is_read_prod_sv`, `is_read_prod_mgr`, `is_read_qa_sv`, `is_read_qa_mgr`, `file_name`, `file_type`, `file_url`, `date_updated`) VALUES
(2, 'MSTPRC-23072805505aa', 'Setup', 'VO Making Machine', 'M-3', '', '2023-07-28', 'Tube Cutting Area', 'FAS4', '', 1, '', '', '', '', '', '', 'admin', 'Prod', 'Admin', 'Admin', 'Safety', 'EQ Manager', 'Admin', 'Prod Engr MGR 1', 'Prod SV 1', 'Prod MGR 1', '', '', 'Approved 2', '', NULL, '', '', '', 'FAT:2307280597b80', 'SOU:230728052df47', 'RSIR-23080101a41ef', 1, 0, 0, 0, 0, 0, 0, 0, 0, 'MSTPRC-23072805505aa-IT MANPOWER LIST.csv', 'text/csv', 'http://172.25.112.131/uploads/ems/setup/mstprc/2023/07/28/MSTPRC-23072805505aa-IT%20MANPOWER%20LIST.csv', '2023-08-01 13:29:42'),
(3, 'MSTPRC-23082902daa44', 'Setup', 'CONTINUITY TESTER (OMI-10 / 100)', 'M-20', '', '2023-08-29', 'Mazda Merge', 'FAS2', '', 1, '', '', '', '', '', '', 'admin', 'QA', 'Admin', 'Admin', 'Safety', 'EQ Manager', 'Admin', 'Prod Engr MGR 1', '', '', 'QA SV 1', 'QA MGR 1', 'Approved 2', '', NULL, '', '', '', 'FAT:23082902e1a4d', 'SOU:230829021b421', 'RSIR-23082906589dc', 1, 0, 0, 0, 0, 0, 0, 0, 0, 'MSTPRC-23082902daa44-RequestTemplateMPPD1XLS.xls', 'application/vnd.ms-excel', 'http://172.25.112.131/uploads/ems/setup/mstprc/2023/08/29/MSTPRC-23082902daa44-RequestTemplateMPPD1XLS.xls', '2023-08-29 18:22:17'),
(4, 'MSTPRC-23082902e6d2e', 'Setup', 'Wire Stripper', 'M-13', '', '2023-08-29', 'Daihatsu', 'FAS4', '', 1, '', '', '', '', '', '', 'admin', 'Prod', 'Admin', 'Admin', '', '', '', '', '', '', '', '', 'Disapproved', '', NULL, 'Safety', 'Safety', 'TEST SAFETY DISAPPROVED', 'FAT:230829023be37', 'SOU:23082902b7c86', 'RSIR-23082906b2080', 1, 0, 0, 0, 0, 0, 0, 0, 0, 'MSTPRC-23082902e6d2e-RequestTemplateMPPD1XLSX.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'http://172.25.112.131/uploads/ems/setup/mstprc/2023/08/29/MSTPRC-23082902e6d2e-RequestTemplateMPPD1XLSX.xlsx', '2023-08-30 16:59:18'),
(6, 'MSTPRC-23083105b9d91', 'Setup', 'CONTINUITY TESTER (OMI-10 / 100)', 'M-21', '', '2023-09-01', 'Honda T20A', 'FAS3', '', 1, '', '', '', '', '', '', 'admin', 'Prod', 'Admin', 'Admin', '', '', '', '', '', '', '', '', 'Disapproved', '', NULL, 'Admin', 'Admin-SP', 'TEST DISAPPROVED SP', 'FAT:230831050a6a3', 'SOU:230831057efd4', '', 1, 0, 0, 0, 0, 0, 0, 0, 0, 'MSTPRC-23083105b9d91-RequestTemplateMPPD1XLS.xls', 'application/vnd.ms-excel', 'http://172.25.112.131/uploads/ems/setup/mstprc/2023/08/31/MSTPRC-23083105b9d91-RequestTemplateMPPD1XLS.xls', '2023-08-31 18:30:13'),
(7, 'MSTPRC-230831059038a', 'Setup', 'Wire Stripper', 'M-14', '', '2023-09-01', '', 'FAS2', '', 1, '', '', '', '', '', '', 'admin', 'Prod', 'Admin', 'Admin', '', '', '', '', '', '', '', '', 'Disapproved', '', NULL, 'EQ Manager', 'EQ Manager', 'TEST DISAPPROVED EQM', 'FAT:23083105be202', 'SOU:23083105878b8', '', 1, 0, 0, 0, 0, 0, 0, 0, 0, 'MSTPRC-230831059038a-RequestTemplateMPPD1XLSX.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'http://172.25.112.131/uploads/ems/setup/mstprc/2023/08/31/MSTPRC-230831059038a-RequestTemplateMPPD1XLSX.xlsx', '2023-08-31 18:31:01'),
(8, 'MSTPRC-230901056dbb3', 'Setup', 'Wire Stripper', 'M-15', '', '2023-09-01', 'Daihatsu First Process', 'FAS3', '', 1, '', '', '', '', '', '', 'setup1', 'Prod', 'Setup-1', 'Admin', 'Safety', 'EQ Manager', 'Admin', 'Prod Engr MGR 1', 'Prod SV 1', 'Prod MGR 1', '', '', 'Approved 2', '', NULL, '', '', '', 'FAT:2309010554a35', 'SOU:23090105b3ba6', '', 1, 0, 0, 0, 0, 0, 0, 0, 0, 'MSTPRC-230901056dbb3-ALIGNMENT JIG LIST.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'http://172.25.112.131/uploads/ems/setup/mstprc/2023/09/01/MSTPRC-230901056dbb3-ALIGNMENT%20JIG%20LIST.xlsx', '2023-09-01 17:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `sou_forms`
--

CREATE TABLE `sou_forms` (
  `id` int(10) UNSIGNED NOT NULL,
  `sou_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kigyo_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sup_asset_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orig_asset_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sou_date` date NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `managing_dept_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `managing_dept_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `install_area_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `install_area_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `equipment_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `no_of_units` int(10) UNSIGNED NOT NULL,
  `ntc_or_sa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_purpose` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sou_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Saved',
  `is_read_a3` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sou_forms`
--

INSERT INTO `sou_forms` (`id`, `sou_no`, `kigyo_no`, `asset_name`, `sup_asset_name`, `orig_asset_no`, `sou_date`, `quantity`, `managing_dept_code`, `managing_dept_name`, `install_area_code`, `install_area_name`, `machine_no`, `equipment_no`, `no_of_units`, `ntc_or_sa`, `use_purpose`, `sou_status`, `is_read_a3`, `date_updated`) VALUES
(1, 'SOU:23053104fca95', '230940392312', '0.64 Terminal insertion guide device', '', '', '2023-06-07', 1, '23409', 'TEST DEPT 1', '203', 'TEST DEPT 2', '', 'EQ-3', 1, 'Need To Convert', 'For Setup', 'Saved', 1, '2023-05-31 16:08:25'),
(4, 'SOU:23061311c54a3', '2352352346', 'Wire Stripper', '', '', '2023-07-08', 1, '453', 'TEST 1', '3453', 'TEST 2', 'M-1', '', 1, 'Need To Convert', 'Reason', 'Saved', 0, '2023-06-13 11:52:23'),
(5, 'SOU:230728052df47', '45146964', 'VO Making Machine', '', '', '2023-07-30', 1, '435453', 'ahdhfsdfh', '453', 'fgasdg', 'M-3', '', 1, 'Need To Convert', 'For Setup', 'Confirmed', 1, '2023-10-06 16:00:39'),
(6, 'SOU:23082902b7c86', '21453', 'Wire Stripper', '', '', '2023-08-30', 1, '2342', 'WS', '2321', 'WS2', 'M-13', '', 1, 'Need To Convert', 'For Setup', 'Confirmed', 0, '2023-10-03 13:19:16'),
(7, 'SOU:230829021b421', '6944', 'CONTINUITY TESTER (OMI-10 / 100)', '', '', '2023-08-30', 1, '5811', 'CT', '944', 'CT1', 'M-20', '', 1, 'Need To Convert', 'For Setup', 'Confirmed', 0, '2023-10-03 13:19:16'),
(8, 'SOU:23083105878b8', '894914', 'Wire Stripper', '', '', '2023-09-02', 1, '7587', 'WS', '7854', 'WS1', 'M-14', '', 1, 'Need To Convert', 'For Setup', 'Confirmed', 0, '2023-10-03 13:19:16'),
(9, 'SOU:230831057efd4', '9455655', 'CONTINUITY TESTER (OMI-10 / 100)', '', '', '2023-09-02', 1, '7684', 'WS', '5786', 'WS1', 'M-21', '', 1, 'Need To Convert', 'For Setup', 'Confirmed', 0, '2023-10-03 13:19:16'),
(10, 'SOU:23090105b3ba6', '235235', 'Wire Stripper', '', '', '2023-09-02', 1, '324532', 'WS', '32456', 'WS1', 'M-15', '', 1, 'Need To Convert', 'For Setup', 'Confirmed', 0, '2023-10-03 13:19:16'),
(11, 'SOU:23090106c2eaa', 'N/A', 'NS-IV', '', 'N/A', '2023-09-20', 1, '12', 'LAWRENCE', '12', 'LAWRENCE', '', 'EQ-2', 1, 'Standalone', 'SET-UP', 'Confirmed', 0, '2023-10-03 13:19:16'),
(12, 'SOU:23090106ccc3d', '0009', 'Automatic Cutting & Crimping Machine', '', 'N/A', '2023-09-30', 1, '143', 'TROY', '143', 'TROY', '', 'EQ-1', 1, 'Standalone', 'SET-UP', 'Saved', 0, '2023-09-01 18:49:29'),
(13, 'SOU:23090106bed38', '0000099', '0.64 Terminal insertion guide device', '', 'N/A', '2023-09-28', 1, '143', 'KEVIN', '143', 'KEVIN', '', 'EQ-3', 1, 'Need To Convert', 'SET-UP', 'Saved', 0, '2023-09-01 18:55:03');

-- --------------------------------------------------------

--
-- Table structure for table `unused_machines`
--

CREATE TABLE `unused_machines` (
  `id` int(10) UNSIGNED NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '''N/A''',
  `equipment_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '''N/A''',
  `asset_tag_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unused_machine_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reserved_for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_date` date DEFAULT NULL,
  `sold` tinyint(1) NOT NULL DEFAULT 0,
  `borrowed` tinyint(1) NOT NULL DEFAULT 0,
  `disposed` tinyint(1) NOT NULL DEFAULT 0,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unused_machines`
--

INSERT INTO `unused_machines` (`id`, `machine_name`, `car_model`, `machine_no`, `equipment_no`, `asset_tag_no`, `unused_machine_location`, `status`, `reserved_for`, `pic`, `remarks`, `target_date`, `sold`, `borrowed`, `disposed`, `date_updated`) VALUES
(1, 'Wire Stripper', 'Subaru', 'M-1', '', 'N/A', 'Workstation', 'Di ko alam', 'Kanino Ba', 'Setup-1', '', '2023-05-12', 0, 0, 1, '2023-05-13 08:37:22'),
(2, '0.64 Terminal insertion guide device', 'Toyota 4110', 'M-5', '', 'N/A', 'Workstation', 'Di Ko Alam', 'Kanino Ba', 'Setup-3', '', '2023-05-16', 0, 1, 0, '2023-05-16 13:46:45'),
(3, '0.64 Terminal insertion guide device', 'Suzuki 5101', 'M-4', '', 'N/A', 'Workstation', 'Di Ko Alam', 'Kanino Ba', 'Setup-3', '', '2023-05-16', 1, 0, 0, '2023-05-16 13:54:55'),
(6, 'Wire Stripper', 'Mazda Secondary Process', 'M-2', 'EQ-5', 'N/A', 'Workstation', 'Di Ko Alam', 'Kanino Ba', 'Setup-2', '', '2023-06-05', 0, 0, 0, '2023-05-30 11:37:03'),
(20, 'Silicon Injection Machine', 'Honda TG7 First Process', 'M-31', '', 'N/A', '', '', '', '', '', NULL, 0, 0, 0, '2023-09-19 17:02:26'),
(21, 'Silicon Injection Machine', 'Honda TG7 First Process', 'M-32', '', 'N/A', '', '', '', '', '', NULL, 0, 0, 0, '2023-09-19 17:02:26'),
(22, 'Silicon Injection Machine', 'Honda TG7 First Process', 'M-33', '', 'N/A', '', '', '', '', '', NULL, 0, 0, 0, '2023-09-19 17:02:26'),
(23, 'Silicon Injection Machine', 'Honda TG7 First Process', 'M-34', '', 'N/A', '', '', '', '', '', NULL, 0, 0, 0, '2023-09-19 17:02:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car_models`
--
ALTER TABLE `car_models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `car_model` (`car_model`);

--
-- Indexes for table `fat_forms`
--
ALTER TABLE `fat_forms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fat_no` (`fat_no`);

--
-- Indexes for table `line_no_final`
--
ALTER TABLE `line_no_final`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `line_no_initial`
--
ALTER TABLE `line_no_initial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `factory_area` (`location`);

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `machine_name` (`machine_name`);

--
-- Indexes for table `machine_history`
--
ALTER TABLE `machine_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machine_masterlist`
--
ALTER TABLE `machine_masterlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `machine_no` (`machine_no`),
  ADD KEY `equipment_no` (`equipment_no`);

--
-- Indexes for table `machine_pm_accounts`
--
ALTER TABLE `machine_pm_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `machine_pm_concerns`
--
ALTER TABLE `machine_pm_concerns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pm_concern_id` (`pm_concern_id`);

--
-- Indexes for table `machine_pm_concerns_history`
--
ALTER TABLE `machine_pm_concerns_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pm_concern_id` (`pm_concern_id`);

--
-- Indexes for table `machine_pm_docs`
--
ALTER TABLE `machine_pm_docs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machine_pm_no_spare`
--
ALTER TABLE `machine_pm_no_spare`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machine_pm_no_spare_history`
--
ALTER TABLE `machine_pm_no_spare_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machine_pm_plan`
--
ALTER TABLE `machine_pm_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machine_pm_wo`
--
ALTER TABLE `machine_pm_wo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wo_id` (`wo_id`);

--
-- Indexes for table `machine_setup_accounts`
--
ALTER TABLE `machine_setup_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `machine_setup_activities`
--
ALTER TABLE `machine_setup_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machine_setup_docs`
--
ALTER TABLE `machine_setup_docs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `machine_sp_accounts`
--
ALTER TABLE `machine_sp_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `notif_pm_approvers`
--
ALTER TABLE `notif_pm_approvers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notif_pm_concerns`
--
ALTER TABLE `notif_pm_concerns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notif_pm_no_spare`
--
ALTER TABLE `notif_pm_no_spare`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notif_setup_activities`
--
ALTER TABLE `notif_setup_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notif_setup_approvers`
--
ALTER TABLE `notif_setup_approvers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pm_rsir`
--
ALTER TABLE `pm_rsir`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rsir_no` (`rsir_no`),
  ADD KEY `machine_no` (`machine_no`),
  ADD KEY `equipment_no` (`equipment_no`);

--
-- Indexes for table `pm_rsir_history`
--
ALTER TABLE `pm_rsir_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rsir_no` (`rsir_no`),
  ADD KEY `machine_no` (`machine_no`),
  ADD KEY `equipment_no` (`equipment_no`);

--
-- Indexes for table `setup_mstprc`
--
ALTER TABLE `setup_mstprc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mstprc_no` (`mstprc_no`),
  ADD KEY `machine_name` (`machine_name`),
  ADD KEY `machine_no` (`machine_no`),
  ADD KEY `equipment_no` (`equipment_no`);

--
-- Indexes for table `setup_mstprc_history`
--
ALTER TABLE `setup_mstprc_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mstprc_no` (`mstprc_no`),
  ADD KEY `machine_no` (`machine_no`),
  ADD KEY `equipment_no` (`equipment_no`);

--
-- Indexes for table `sou_forms`
--
ALTER TABLE `sou_forms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sou_no` (`sou_no`);

--
-- Indexes for table `unused_machines`
--
ALTER TABLE `unused_machines`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car_models`
--
ALTER TABLE `car_models`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `fat_forms`
--
ALTER TABLE `fat_forms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `line_no_final`
--
ALTER TABLE `line_no_final`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `line_no_initial`
--
ALTER TABLE `line_no_initial`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `machine_history`
--
ALTER TABLE `machine_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `machine_masterlist`
--
ALTER TABLE `machine_masterlist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `machine_pm_accounts`
--
ALTER TABLE `machine_pm_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `machine_pm_concerns`
--
ALTER TABLE `machine_pm_concerns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `machine_pm_concerns_history`
--
ALTER TABLE `machine_pm_concerns_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `machine_pm_docs`
--
ALTER TABLE `machine_pm_docs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `machine_pm_no_spare`
--
ALTER TABLE `machine_pm_no_spare`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `machine_pm_no_spare_history`
--
ALTER TABLE `machine_pm_no_spare_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `machine_pm_plan`
--
ALTER TABLE `machine_pm_plan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `machine_pm_wo`
--
ALTER TABLE `machine_pm_wo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `machine_setup_accounts`
--
ALTER TABLE `machine_setup_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `machine_setup_activities`
--
ALTER TABLE `machine_setup_activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `machine_setup_docs`
--
ALTER TABLE `machine_setup_docs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `machine_sp_accounts`
--
ALTER TABLE `machine_sp_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notif_pm_approvers`
--
ALTER TABLE `notif_pm_approvers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notif_pm_concerns`
--
ALTER TABLE `notif_pm_concerns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notif_pm_no_spare`
--
ALTER TABLE `notif_pm_no_spare`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notif_setup_activities`
--
ALTER TABLE `notif_setup_activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notif_setup_approvers`
--
ALTER TABLE `notif_setup_approvers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pm_rsir`
--
ALTER TABLE `pm_rsir`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pm_rsir_history`
--
ALTER TABLE `pm_rsir_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `setup_mstprc`
--
ALTER TABLE `setup_mstprc`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `setup_mstprc_history`
--
ALTER TABLE `setup_mstprc_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sou_forms`
--
ALTER TABLE `sou_forms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `unused_machines`
--
ALTER TABLE `unused_machines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
