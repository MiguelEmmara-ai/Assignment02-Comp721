-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2022 at 09:59 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cabsonline`
--

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `carsAvailability` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `email`, `username`, `password`, `carsAvailability`, `created_at`) VALUES
(1, 'admin@admin.com', 'admin', '$2y$10$B8MluZWXfKieSLCLM3G7V.oFVbIG6JJ5t7EV3ViRzycuBL3cfw/Su', 'Scooter, Hatch Back, Suv, Sedan, Van', '2022-06-02 07:57:48');

-- --------------------------------------------------------

--
-- Table structure for table `passengers`
--

CREATE TABLE `passengers` (
  `bookingRefNo` varchar(255) NOT NULL,
  `customerName` text NOT NULL,
  `phoneNumber` int(12) NOT NULL,
  `unitNumber` text DEFAULT NULL,
  `streetNumber` text NOT NULL,
  `streetName` text NOT NULL,
  `suburb` text DEFAULT NULL,
  `destinationSuburb` text DEFAULT NULL,
  `pickUpDate` date NOT NULL,
  `pickUpTime` time NOT NULL,
  `status` enum('Assigned','Unassigned') NOT NULL,
  `carsNeed` enum('Scooter','Hatchback','Suv','Sedan','Van') NOT NULL,
  `assignedBy` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`bookingRefNo`, `customerName`, `phoneNumber`, `unitNumber`, `streetNumber`, `streetName`, `suburb`, `destinationSuburb`, `pickUpDate`, `pickUpTime`, `status`, `carsNeed`, `assignedBy`) VALUES
('BRN06757', 'Test One', 22123456, '123', '321', 'Test', 'Test', 'Test', '2022-06-02', '20:00:00', 'Unassigned', 'Sedan', 'None'),
('BRN23502', 'Test Two', 229876543, '', '512', 'Test', '', 'Test', '2022-06-02', '20:25:00', 'Unassigned', 'Van', 'None');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`bookingRefNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
