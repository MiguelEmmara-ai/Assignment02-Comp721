-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2022 at 02:24 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

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
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `email`, `username`, `password`, `carsAvailability`, `created_at`) VALUES
(1, 'admin@gmail.com', 'admin', '$2y$10$GbdRvbYxBxcP8ARGmTg8I.RPKmsw3IUyWuMACbQQ/VecofbBMUeau', 'Scooter, Hatch Back, Suv, Sedan, Van', '2022-04-26 01:25:22'),
(2, 'ferguso@gmail.com', 'ferguso', '$2y$10$XfgkO8A2MT/jY5MTw/JyR.eMLj.UTmF6GywG88wawJwduRMIBoiy6', 'Suv, Sedan, Van', '2022-04-26 01:35:52'),
(3, 'ahmad@gmail.com', 'ahmad', '$2y$10$EEDwHn6OMqIMsvrkjh6svu.6Qx7FyaJxgvP.T9rIa5y8a8ESUqkFC', 'Suv, Van', '2022-04-26 23:59:47'),
(4, 'shituber@gmail.com', 'test1', '$2y$10$mdggxjGOirEVb0H2eXvb.e.oikvaOdbYFsj0FdLdCN9WtBmoh9yIi', 'Scooter, Suv, Sedan', '2022-04-27 22:08:07'),
(5, 'testingtesting@gmail.com', 'test2', '$2y$10$QVPouycRylJPix0.Qat/Vu/YblnTb14IwoPAdpwSpUXa/k4lR9HwO', 'Scooter, Suv, Sedan', '2022-04-27 22:08:28');

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
('BRN00555', 'fghgf hsgdrg', 2147483647, '3463463', '3456345634', 'tfhhtffhth', 'thtyjhdrfh', 'rtdhrtdhrth', '2022-04-26', '23:57:00', 'Assigned', 'Hatchback', 'admin'),
('BRN02676', 'testimoni testimoni', 4444444, '4444444', '4444444', 'testimoni', 'testimoni', 'testimoni', '2022-04-29', '15:31:00', 'Assigned', 'Scooter', ''),
('BRN03605', 'efgefg dfgdefawgdef', 234532532, '25235', '23523523', '365236', 'rtsgsdfv', 'rgrbv', '2022-05-03', '19:08:00', 'Assigned', 'Suv', ''),
('BRN03797', 'testimoni testimoni', 4444444, '4444444', '4444444', 'testimoni', 'testimoni', 'testimoni', '2022-04-29', '15:31:00', 'Assigned', 'Scooter', ''),
('BRN04439', 'efgefg dfgdefawgdef', 234532532, '25235', '23523523', '365236', 'rtsgsdfv', 'rgrbv', '2022-05-02', '21:10:00', 'Assigned', 'Scooter', ''),
('BRN05467', 'testimoni testimoni', 4444444, '4444444', '4444444', 'testimoni', 'testimoni', 'testimoni', '2022-04-29', '13:37:00', 'Assigned', 'Scooter', ''),
('BRN06141', 'testimoni testimoni', 4444444, '4444444', '4444444', 'testimoni', 'testimoni', 'testimoni', '2022-04-30', '15:39:00', 'Assigned', 'Scooter', ''),
('BRN06474', 'testimoni testimoni', 4444444, '4444444', '4444444', 'testimoni', 'testimoni', 'testimoni', '2022-04-27', '16:29:00', 'Assigned', 'Scooter', ''),
('BRN07401', 'testimoni testimoni', 2147483647, '55555555555', '55555555555', 'testimoni', 'testimoni', 'testimoni', '2022-04-27', '18:27:00', 'Assigned', 'Scooter', ''),
('BRN99862', 'Test One', 1, '1', '1', 'One', 'One', 'One', '2022-04-26', '01:29:00', 'Assigned', 'Suv', 'admin');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
