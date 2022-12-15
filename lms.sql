-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 15, 2022 at 11:21 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `lms_admin`
--

CREATE TABLE `lms_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_uname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `admin_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lms_admin`
--

INSERT INTO `lms_admin` (`admin_id`, `admin_uname`, `admin_password`) VALUES
(4, 'admin', '1a1dc91c907325c69271ddf0c944bc72');

-- --------------------------------------------------------

--
-- Table structure for table `lms_book`
--

CREATE TABLE `lms_book` (
  `book_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `book_author` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `location_rack_id` int(11) NOT NULL,
  `book_name` text COLLATE utf8_unicode_ci NOT NULL,
  `book_isbn_number` int(15) NOT NULL,
  `book_no_of_copy` int(5) NOT NULL,
  `publisher` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `publication_date` date DEFAULT NULL,
  `image_file` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `book_status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lms_book`
--

INSERT INTO `lms_book` (`book_id`, `category_id`, `book_author`, `location_rack_id`, `book_name`, `book_isbn_number`, `book_no_of_copy`, `publisher`, `publication_date`, `image_file`, `book_status`) VALUES
(188, 22, 'Max Lugavere', 29, 'Genius Foods', 2147483647, 13, 'Harper Wave', '2022-10-20', 'genius-foods.jpg', 'Active'),
(196, 22, 'Andrea Bonior', 29, 'Detox Your Thoughts', 1452184879, 17, 'Chronicle Prism', '2022-06-15', 'detox-your-thoughts.jpg', 'Active'),
(199, 19, 'Enric Sala', 30, 'The Nature of Nature', 1426221010, 20, 'National Geographic', '2022-03-17', 'nature-of-nature-9781426221019_hr.jpg', 'Active'),
(200, 19, 'Ed Yong', 30, 'An Immense World', 593133234, 20, 'Random House', '2021-07-14', '59575939.jpg', 'Active'),
(201, 19, 'Jane Wilsher', 30, 'Jungle Animals', 1681887665, 16, 'Earth Aware Editions Kids', '2021-03-17', 'jungle-animals-9781681887661_hr.jpg', 'Active'),
(202, 19, 'DK, John Woodward', 30, 'The Dinosaur Book', 1465474765, 20, 'DK Children', '2020-08-13', '91H5l3+C1wL.jpg', 'Active'),
(203, 21, 'Jeremy Popkin', 31, 'A New World Begins', 465096662, 20, 'Basic Books', '2021-08-18', '9780465096664_ahwjkl.jpg', 'Inactive'),
(220, 20, 'George E. Andrews', 31, 'Number Theory', 465451262, 15, 'Dover Publications', '2021-07-15', 's-l1600.jpg', 'Active'),
(221, 20, 'Clifford A. Pickover', 31, 'The Math Book', 269436662, 20, 'Union Square & Co.', '2021-09-09', '6393242.jpg', 'Active'),
(230, 22, 'Carole Hungerford', 29, 'Good Health in the 21st Century', 465081234, 20, 'Scribe US', '2022-05-12', '9781921844584.jpg', 'Active'),
(246, 22, 'Mark Twain', 31, 'Unleash the Dragon', 423423, 100, 'Author Solutions', '2019-02-06', 'media_1b7327f720408f3da750167464f8cbcd74fa319c5.jpeg', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `lms_category`
--

CREATE TABLE `lms_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `category_status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lms_category`
--

INSERT INTO `lms_category` (`category_id`, `category_name`, `category_status`) VALUES
(19, 'Science', 'Inactive'),
(20, 'Math', 'Active'),
(21, 'History', 'Active'),
(22, 'Health', 'Active'),
(23, 'FIction', 'Active'),
(27, 'Communication', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `lms_issue_book`
--

CREATE TABLE `lms_issue_book` (
  `issue_book_id` int(11) NOT NULL,
  `school_id` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `book_isbn_number` int(13) NOT NULL,
  `issue_date_time` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `expected_return_date` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `return_date_time` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `book_fines` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `no_of_copy` int(1) NOT NULL,
  `book_issue_status` enum('Borrowing','Returned','Late','Pending','Denied','Cancelled') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lms_issue_book`
--

INSERT INTO `lms_issue_book` (`issue_book_id`, `school_id`, `book_isbn_number`, `issue_date_time`, `expected_return_date`, `return_date_time`, `book_fines`, `no_of_copy`, `book_issue_status`) VALUES
(162, '202178521', 1465474765, '2022-08-15 16:19:51', '2022-08-25 16:19:51', '2022-08-18 16:23:45', '0', 1, 'Returned'),
(165, '202030977', 1426221010, '2022-08-18 16:23:13', '2022-08-28 16:23:13', '2022-08-27 16:26:08', '0', 3, 'Returned'),
(166, '202178521', 593133234, '2022-08-18 16:24:12', '2022-08-28 16:24:12', '2022-08-27 16:26:11', '0', 3, 'Returned'),
(167, '202178521', 465081234, '2022-08-27 16:26:37', '2022-09-03 16:26:37', '2022-09-04 16:26:51', '20', 1, 'Returned'),
(168, '202055876', 269436662, '2022-09-05 16:28:19', '2022-09-12 16:28:19', '2022-09-16 16:36:07', '20', 1, 'Returned'),
(169, '202055876', 465451262, '2022-09-07 16:28:44', '2022-09-14 16:28:44', '2022-09-13 16:29:49', '0', 1, 'Returned'),
(170, '202178521', 1452184879, '2022-09-08 16:29:19', '2022-09-15 16:29:19', '2022-09-14 16:30:08', '0', 1, 'Returned'),
(172, '202055876', 465081234, '', '', '', '0', 0, 'Denied'),
(175, '202045328', 1681887665, '2022-12-10 04:12:44', '2022-12-17 04:12:44', '', '0', 1, 'Borrowing'),
(176, '202178521', 269436662, '', '', '', '0', 0, 'Cancelled'),
(177, '202178521', 465081234, '2022-12-05 19:54:25', '2022-12-12 19:54:25', '2022-12-06 19:37:34', '0', 1, 'Returned'),
(178, '202055876', 465451262, '2022-12-10 04:12:38', '2022-12-17 04:12:38', '', '0', 1, 'Borrowing'),
(179, '202055876', 465451262, '2022-12-10 04:12:35', '2022-12-17 04:12:35', '', '0', 1, 'Borrowing'),
(180, '202055876', 465451262, '2022-12-10 04:11:55', '2022-12-17 04:11:55', '', '0', 1, 'Late'),
(181, '202055876', 465451262, '2022-12-05 21:02:33', '2022-12-12 21:02:33', '2022-12-06 19:37:39', '0', 1, 'Returned'),
(182, '202055876', 465081234, '', '', '', '0', 0, 'Cancelled'),
(202, '202178521', 1452184879, '2022-12-10 04:11:41', '2022-12-17 04:11:41', '', '0', 1, 'Late');

-- --------------------------------------------------------

--
-- Table structure for table `lms_librarian`
--

CREATE TABLE `lms_librarian` (
  `librarian_id` int(11) NOT NULL,
  `librarian_fname` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `librarian_lname` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lib_user_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `librarian_address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `librarian_contact_no` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `librarian_email_address` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `librarian_password` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lib_school_id` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lms_librarian`
--

INSERT INTO `lms_librarian` (`librarian_id`, `librarian_fname`, `librarian_lname`, `lib_user_name`, `librarian_address`, `librarian_contact_no`, `librarian_email_address`, `librarian_password`, `lib_school_id`) VALUES
(4, 'Arthur', 'Maxon', 'arthur', 'Prwyden', '09293808284', 'am@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '201734761'),
(7, 'Francis', 'matthew', 'francis', 'Cebu City', '08232', 'francis@uspf.edu.ph', '1a1dc91c907325c69271ddf0c944bc72', '3242352');

-- --------------------------------------------------------

--
-- Table structure for table `lms_location_rack`
--

CREATE TABLE `lms_location_rack` (
  `location_rack_id` int(11) NOT NULL,
  `location_rack_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `location_rack_status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lms_location_rack`
--

INSERT INTO `lms_location_rack` (`location_rack_id`, `location_rack_name`, `location_rack_status`) VALUES
(29, 'A1', 'Active'),
(30, 'A2', 'Active'),
(31, 'B1', 'Active'),
(32, 'B2', 'Active'),
(33, 'C1', 'Active'),
(37, 'C2', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `lms_setting`
--

CREATE TABLE `lms_setting` (
  `setting_id` int(11) NOT NULL,
  `library_total_book_issue_day` int(5) NOT NULL,
  `library_one_day_fine` decimal(4,2) NOT NULL,
  `library_issue_total_book_per_user` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lms_setting`
--

INSERT INTO `lms_setting` (`setting_id`, `library_total_book_issue_day`, `library_one_day_fine`, `library_issue_total_book_per_user`) VALUES
(1, 7, '20.00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `lms_user`
--

CREATE TABLE `lms_user` (
  `user_id` int(11) NOT NULL,
  `user_fname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_lname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_address` text COLLATE utf8_unicode_ci NOT NULL,
  `user_contact_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_email_address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `school_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lms_user`
--

INSERT INTO `lms_user` (`user_id`, `user_fname`, `user_lname`, `user_name`, `user_address`, `user_contact_no`, `user_email_address`, `user_password`, `school_id`) VALUES
(66, 'Preston', 'Garvey', 'minuteman', 'Sanctuary Hills', '09285551887', 'pg@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '202045328'),
(67, 'Piper', 'Wright', 'piper', 'Diamond City', '0933555758', 'pw@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '202178521'),
(68, 'Nick', 'Valentine', 'nick', 'Diamond City', '02805553367', 'nv@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '202055876'),
(69, 'John', 'Hancock', 'john', 'Good Neighbor', '09295557763', 'jh@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '202030977'),
(71, 'Robert', 'MacCready', 'robert', 'Little Lamplight', '09335557253', 'rm@gmail.com', '1a1dc91c907325c69271ddf0c944bc72', '202264529');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lms_admin`
--
ALTER TABLE `lms_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `lms_book`
--
ALTER TABLE `lms_book`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `book_isbn_number` (`book_isbn_number`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `location_rack_id` (`location_rack_id`);

--
-- Indexes for table `lms_category`
--
ALTER TABLE `lms_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `lms_issue_book`
--
ALTER TABLE `lms_issue_book`
  ADD PRIMARY KEY (`issue_book_id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `book_isbn_number` (`book_isbn_number`);

--
-- Indexes for table `lms_librarian`
--
ALTER TABLE `lms_librarian`
  ADD PRIMARY KEY (`librarian_id`);

--
-- Indexes for table `lms_location_rack`
--
ALTER TABLE `lms_location_rack`
  ADD PRIMARY KEY (`location_rack_id`);

--
-- Indexes for table `lms_setting`
--
ALTER TABLE `lms_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `lms_user`
--
ALTER TABLE `lms_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `school_id` (`school_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lms_admin`
--
ALTER TABLE `lms_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lms_book`
--
ALTER TABLE `lms_book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `lms_category`
--
ALTER TABLE `lms_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `lms_issue_book`
--
ALTER TABLE `lms_issue_book`
  MODIFY `issue_book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `lms_librarian`
--
ALTER TABLE `lms_librarian`
  MODIFY `librarian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lms_location_rack`
--
ALTER TABLE `lms_location_rack`
  MODIFY `location_rack_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `lms_setting`
--
ALTER TABLE `lms_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lms_user`
--
ALTER TABLE `lms_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lms_book`
--
ALTER TABLE `lms_book`
  ADD CONSTRAINT `lms_book_ibfk_1` FOREIGN KEY (`location_rack_id`) REFERENCES `lms_location_rack` (`location_rack_id`),
  ADD CONSTRAINT `lms_book_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `lms_category` (`category_id`);

--
-- Constraints for table `lms_issue_book`
--
ALTER TABLE `lms_issue_book`
  ADD CONSTRAINT `lms_issue_book_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `lms_user` (`school_id`),
  ADD CONSTRAINT `lms_issue_book_ibfk_2` FOREIGN KEY (`book_isbn_number`) REFERENCES `lms_book` (`book_isbn_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
