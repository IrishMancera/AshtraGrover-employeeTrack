-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2023 at 04:47 PM
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
-- Database: `ashtragroverdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminuser` varchar(50) DEFAULT NULL,
  `adminpass` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminuser`, `adminpass`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `atlog`
--

CREATE TABLE `atlog` (
  `atlog_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `atlog_date` date DEFAULT NULL,
  `am_in` time DEFAULT NULL,
  `am_out` time DEFAULT NULL,
  `pm_in` time DEFAULT NULL,
  `pm_out` time DEFAULT NULL,
  `am_late` int(11) DEFAULT NULL,
  `am_undertime` int(11) DEFAULT NULL,
  `pm_late` int(11) DEFAULT NULL,
  `pm_undertime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `atlog`
--

INSERT INTO `atlog` (`atlog_id`, `emp_id`, `atlog_date`, `am_in`, `am_out`, `pm_in`, `pm_out`, `am_late`, `am_undertime`, `pm_late`, `pm_undertime`) VALUES
(6, 20230001, '2023-12-19', '10:16:33', '11:36:30', '13:07:30', '22:48:23', NULL, 220, NULL, NULL),
(8, 20230002, '2023-12-19', '10:20:15', '14:26:17', '13:10:05', NULL, NULL, 53, 40, NULL),
(9, 20230003, '2023-12-19', '10:23:03', '10:59:41', '13:16:05', '13:16:49', 203, 263, 46, 283),
(10, 20230004, '2023-12-19', '10:30:46', '11:42:28', NULL, NULL, 210, 228, NULL, NULL),
(11, 20230005, '2023-12-19', '10:32:01', '11:36:03', NULL, NULL, 212, 235, NULL, NULL),
(12, 20230006, '2023-12-19', '10:55:26', '11:38:21', NULL, NULL, 235, 257, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL,
  `emp_fname` varchar(100) DEFAULT NULL,
  `emp_mname` varchar(100) DEFAULT NULL,
  `emp_lname` varchar(100) DEFAULT NULL,
  `emp_address` varchar(255) DEFAULT NULL,
  `emp_email` varchar(100) DEFAULT NULL,
  `emp_phone` varchar(20) DEFAULT NULL,
  `emp_hire_date` date DEFAULT NULL,
  `emp_pic` varchar(200) DEFAULT NULL,
  `emp_password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `emp_fname`, `emp_mname`, `emp_lname`, `emp_address`, `emp_email`, `emp_phone`, `emp_hire_date`, `emp_pic`, `emp_password`) VALUES
(20230001, 'John', 'Doe', 'Smith', '123 Main St', 'john@example.com', '1234567890', '2023-01-01', 'employee_picture/DSCF0007.jpg', 'ashtragrover1234'),
(20230002, 'Alice', 'E', 'Johnson', '456 Elm St', 'alice@example.com', '9876543210', '2023-02-15', 'employee_picture/DSCF0199.jpg', 'kianpogi'),
(20230003, 'Bob', 'F', 'Williams', '789 Oak St', 'bob@example.com', '5558889999', '2023-03-20', 'employee_picture/Olivier_1500_Trptch.jpg', 'ashtragrover1234'),
(20230004, 'Emily', 'G', 'Brown', '101 Pine St', 'emily@example.com', '4443332221', '2023-04-05', 'employee_picture/39sunkhvpw341.jpg', 'ashtragrover1234'),
(20230005, 'Michael', 'H', 'Miller', '111 Cedar St', 'michael@example.com', '7779991112', '2023-05-10', 'employee_picture/35af6a41332353.57a1ce913e889.jpg', 'ashtragrover1234'),
(20230006, 'Sophia', 'I', 'Jones', '222 Walnut St', 'sophia@example.com', '6662225553', '2023-06-25', 'employee_picture/aw.jpg', 'ashtragrover1234'),
(20230007, 'William', 'J', 'Davis', '333 Maple St', 'william@example.com', '9991113334', '2023-07-30', 'employee_picture/DSC08166-2.jpg', 'ashtragrover1234'),
(20230008, 'Olivia', 'K', 'Wilson', '444 Birch St', 'olivia@example.com', '2224447775', '2023-08-14', 'employee_picture/ad.jpg', 'ashtragrover1234'),
(20230009, 'Daniel', 'L', 'Martinez', '555 Spruce St', 'daniel@example.com', '1117778886', '2023-09-19', 'employee_picture/D8Dp0c5WkAAkvMEwd.jpg', 'ashtragrover1234'),
(20230010, 'Ava', 'M', 'Garcia', '666 Oakwood St', 'ava@example.com', '3335552227', '2023-10-24', 'employee_picture/MV5BOWM2OWZmMDktOTMyZi00OWRiLWFkZTMtZGZlawd.jpg', 'ashtragrover1234'),
(20230012, 'Kyla', 'A', 'Nicandro', 'Sogoy, Castilla,sorsogon,philipines', 'aira@gmail.com', '09123456789', '2023-03-10', 'employee_picture/DSCF7335.jpg', 'ashtragrover1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atlog`
--
ALTER TABLE `atlog`
  ADD PRIMARY KEY (`atlog_id`),
  ADD KEY `fk_atlog_employee` (`emp_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atlog`
--
ALTER TABLE `atlog`
  MODIFY `atlog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20230013;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `atlog`
--
ALTER TABLE `atlog`
  ADD CONSTRAINT `fk_atlog_employee` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
