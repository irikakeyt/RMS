-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2024 at 11:03 AM
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
-- Database: `rms`
--

-- --------------------------------------------------------

--
-- Table structure for table `landlord`
--

CREATE TABLE `landlord` (
  `Id` int(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `landlord`
--

INSERT INTO `landlord` (`Id`, `profile_pic`, `fname`, `lname`, `email`, `password`) VALUES
(5, 'Predator_Wallpaper_01_3840x2400.jpg', 'Predator', 'Baskog', 'marteyy@gmail.com', 'marteyy123'),
(7, 'Predator_Wallpaper_01_3840x2400.jpg', 'Predator', 'Acer', 'admin@gmail.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `newtenant`
--

CREATE TABLE `newtenant` (
  `id` int(11) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `room_num` int(250) DEFAULT NULL,
  `adv` decimal(10,2) NOT NULL,
  `room_price` decimal(10,2) DEFAULT NULL,
  `date_occupied` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newtenant`
--

INSERT INTO `newtenant` (`id`, `lname`, `fname`, `age`, `gender`, `address`, `contact`, `room_num`, `adv`, `room_price`, `date_occupied`) VALUES
(23, 'Martinez', 'Tiara', 23, 'Female', 'Brgy. Tabuc Suba Jaro Iloilo City', '09635354999', 12, 0.00, 7000.00, '2024-03-01'),
(26, 'Altura', 'Mark Xavier', 18, 'Male', 'Brgy. Tabuc Suba Jaro Iloilo City', '09635354999', 10, 0.00, 5000.00, '2024-01-19'),
(27, 'asdas', 'asdas', 25, 'Female', 'Brgy. Tabuc Suba Jaro Iloilo City', '12312312312', 17, 0.00, 7000.00, '2024-02-02');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(110) NOT NULL,
  `tenant_id` int(255) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `invoice` varchar(50) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `tenant_id`, `payment_date`, `payment_amount`, `invoice`, `date_created`) VALUES
(1, 26, '2024-04-03', 10000.00, '998', '2024-04-03 15:56:32'),
(2, 26, '2024-04-18', 4000.00, '5675', '2024-04-03 15:57:00'),
(3, 27, '2024-04-03', 7000.00, '67754', '2024-04-03 16:01:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `landlord`
--
ALTER TABLE `landlord`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `newtenant`
--
ALTER TABLE `newtenant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `landlord`
--
ALTER TABLE `landlord`
  MODIFY `Id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `newtenant`
--
ALTER TABLE `newtenant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(110) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
