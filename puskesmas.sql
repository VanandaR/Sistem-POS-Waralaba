-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 30, 2016 at 10:59 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `puskesmas`
--

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE IF NOT EXISTS `diagnosis` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `patient` int(8) NOT NULL,
  `date` date NOT NULL,
  `doctor` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `doctor` (`doctor`),
  KEY `patient` (`patient`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis_detail`
--

CREATE TABLE IF NOT EXISTS `diagnosis_detail` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `diagnosis` int(8) NOT NULL,
  `disease` int(8) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `diagnosis` (`diagnosis`),
  KEY `disease` (`disease`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis_detail_medicine`
--

CREATE TABLE IF NOT EXISTS `diagnosis_detail_medicine` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `diagnosis_detail` int(8) NOT NULL,
  `medicine` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `medicine` (`medicine`),
  KEY `diagnosis_detail` (`diagnosis_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `diseases`
--

CREATE TABLE IF NOT EXISTS `diseases` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `symptom` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `diseases`
--

INSERT INTO `diseases` (`id`, `name`, `symptom`, `status`) VALUES
(1, 'flu', 'hidung ada ingusnya\r\ndemam\r\n ', 0),
(2, 'flu', 'demam\r\npilek', 1),
(3, 'batuk', 'tenggorokan sakit\r\ndemam', 1);

-- --------------------------------------------------------

--
-- Table structure for table `log_activity`
--

CREATE TABLE IF NOT EXISTS `log_activity` (
  `id` int(8) NOT NULL,
  `activities` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `user` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE IF NOT EXISTS `medicine` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `type` enum('Generic','Paten') NOT NULL,
  `kind` enum('Tablet','Kapsul','Puyer','Oles','Cair') NOT NULL,
  `name` varchar(50) NOT NULL,
  `dose` mediumint(8) NOT NULL,
  `unit` enum('mg','ml') NOT NULL,
  `stock` mediumint(8) NOT NULL,
  `selling_price` mediumint(8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`id`, `type`, `kind`, `name`, `dose`, `unit`, `stock`, `selling_price`, `status`) VALUES
(1, 'Generic', 'Tablet', 'bodrex', 90, 'mg', 7, 1500, 1),
(2, 'Generic', 'Oles', 'Salonpas', 80, 'mg', 0, 2000, 1),
(3, 'Generic', 'Tablet', 'Neuralgin', 90, 'mg', 8, 7000, 1),
(4, 'Generic', 'Tablet', 'Paracetamol', 50, 'ml', 15, 1500, 1),
(5, 'Generic', 'Puyer', 'IPI Vitamin C', 22, 'ml', 0, 8000, 1),
(6, 'Paten', 'Tablet', 'Panadol', 150, 'mg', 3, 2000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_restock`
--

CREATE TABLE IF NOT EXISTS `medicine_restock` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `user` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `medicine_restock`
--

INSERT INTO `medicine_restock` (`id`, `time`, `user`) VALUES
(1, '2016-12-13 06:25:20', 1),
(2, '2016-12-13 06:26:07', 1),
(3, '2016-12-13 06:26:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_restock_details`
--

CREATE TABLE IF NOT EXISTS `medicine_restock_details` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `medicine_restock` int(8) NOT NULL,
  `medicine` int(8) NOT NULL,
  `expired` date NOT NULL,
  `amount` int(5) NOT NULL,
  `stock` int(5) NOT NULL,
  `buying_price` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `medicine_restock` (`medicine_restock`,`medicine`),
  KEY `medicine` (`medicine`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `medicine_restock_details`
--

INSERT INTO `medicine_restock_details` (`id`, `medicine_restock`, `medicine`, `expired`, `amount`, `stock`, `buying_price`) VALUES
(1, 1, 6, '2016-12-27', 5, 0, 1000),
(2, 1, 1, '2016-12-13', 10, 7, 500),
(3, 1, 3, '2016-12-28', 5, 0, 5000),
(4, 2, 3, '2016-12-29', 10, 8, 6000),
(5, 2, 4, '2016-12-18', 5, 5, 1000),
(6, 3, 6, '2016-12-01', 5, 3, 1500),
(7, 3, 4, '2016-12-25', 10, 10, 1200);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_sales`
--

CREATE TABLE IF NOT EXISTS `medicine_sales` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `user` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `medicine_sales`
--

INSERT INTO `medicine_sales` (`id`, `time`, `user`) VALUES
(1, '2016-12-13 06:27:34', 1),
(2, '2016-12-13 06:28:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_sales_details`
--

CREATE TABLE IF NOT EXISTS `medicine_sales_details` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `medicine_sales` int(8) NOT NULL,
  `medicine_restock_details` int(8) NOT NULL,
  `amount` int(5) NOT NULL,
  `selling_price` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `medicine_restock_details` (`medicine_sales`),
  KEY `medicine_restock_details_2` (`medicine_sales`),
  KEY `medicine_restock_details_3` (`medicine_restock_details`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `medicine_sales_details`
--

INSERT INTO `medicine_sales_details` (`id`, `medicine_sales`, `medicine_restock_details`, `amount`, `selling_price`) VALUES
(1, 1, 2, 3, 1500),
(2, 1, 1, 3, 2000),
(3, 2, 3, 5, 7000),
(4, 2, 4, 2, 7000),
(5, 2, 1, 2, 2000),
(6, 2, 6, 2, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE IF NOT EXISTS `patients` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `id_card` char(16) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(150) NOT NULL,
  `place_of_birth` varchar(25) NOT NULL,
  `date_of_birth` date NOT NULL,
  `nationality` enum('WNI','WNA') NOT NULL,
  `religion` tinyint(1) NOT NULL COMMENT '1 = Islam, 2 = Khatolik, 3 = Protestan, 4 = Hindu, 5 = Budha',
  `gender` enum('L','P') NOT NULL,
  `job` varchar(50) NOT NULL,
  `blood_type` enum('A','B','AB','O') NOT NULL,
  `bpjs` enum('BPJS','Non BPJS','','') NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `id_card`, `name`, `phone`, `address`, `place_of_birth`, `date_of_birth`, `nationality`, `religion`, `gender`, `job`, `blood_type`, `bpjs`, `status`) VALUES
(1, '1907394231', 'Putri Kusuma', '0819728634', 'Jalan Kenanga', 'Jember', '2000-11-30', 'WNI', 1, 'P', 'Pelajar', 'A', 'Non BPJS', 1),
(2, '1257569', 'Ayu', '4546', 'Jalan Mawar', 'Jember', '1999-11-02', 'WNA', 3, 'P', 'Pelajar', 'B', 'BPJS', 1),
(3, '414124414241', 'Ramadan', '08970000111', 'Jl. Jawa no. 16', 'Jember', '1993-10-18', 'WNI', 2, 'L', 'Mahasiswa', 'B', 'BPJS', 1),
(4, '21443563', 'Dino', '23', 'Jl Kenanga', 'Jember', '2016-12-20', 'WNI', 2, 'L', 'hfgf', 'AB', 'Non BPJS', 1),
(5, '142410101052', 'edwin', '0812345551111', 'semery', 'jember', '1995-02-02', 'WNI', 1, 'L', 'mahasiswa', 'AB', 'BPJS', 1),
(6, '142410101052', 'edwin', '0812345551111', 'semery', 'jember', '1995-02-02', 'WNI', 1, 'L', 'mahasiswa', 'AB', 'BPJS', 1),
(7, '142410101052', 'edwin', '0812345551111', 'semery', 'jember', '1995-02-02', 'WNI', 1, 'L', 'mahasiswa', 'AB', 'BPJS', 1);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(5) NOT NULL,
  `price` mediumint(8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `number`, `price`, `status`) VALUES
(1, '000', 0, 0),
(4, '002', 90000, 1),
(5, '007', 80000, 1),
(6, '009', 89000, 1),
(7, '009', 90000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_medicine_restock`
--

CREATE TABLE IF NOT EXISTS `tmp_medicine_restock` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `medicine` int(8) NOT NULL,
  `expired` date NOT NULL,
  `amount` int(5) NOT NULL,
  `buying_price` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `medicine_restock` (`medicine`),
  KEY `medicine` (`medicine`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_medicine_sales`
--

CREATE TABLE IF NOT EXISTS `tmp_medicine_sales` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `medicine` int(8) NOT NULL,
  `amount` int(8) NOT NULL,
  `selling_price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `medicine` (`medicine`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tmp_medicine_sales`
--

INSERT INTO `tmp_medicine_sales` (`id`, `medicine`, `amount`, `selling_price`) VALUES
(1, 6, 3, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE IF NOT EXISTS `treatment` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `price` int(8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`id`, `name`, `price`, `status`) VALUES
(1, 'pelayanan 1', 900000, 0),
(2, '1212', 1232323, 1),
(3, 'flu', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` char(32) NOT NULL,
  `id_card` char(16) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(150) NOT NULL,
  `place_of_birth` varchar(25) NOT NULL,
  `date_of_birth` date NOT NULL,
  `nationality` enum('WNI','WNA') NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `level` tinyint(1) NOT NULL COMMENT '1 = Kepala Puskesmas, 2 = Dokter, 3 = Loket, 4 = Apoteker',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `id_card`, `name`, `phone`, `address`, `place_of_birth`, `date_of_birth`, `nationality`, `gender`, `level`, `status`) VALUES
(1, 'kepala', 'c4ca4238a0b923820dcc509a6f75849b', '1923780374785462', 'Pak Kepala', '081235192333', 'Jalan Mawar Melati No. 1', 'Surabaya', '1970-11-01', 'WNI', 'L', 1, 1),
(2, 'dokter', 'c4ca4238a0b923820dcc509a6f75849b', '236482469', 'Dr. Lia S.Kom', '085649283283', 'Wijaya Kusuma', 'Jember', '2016-11-19', 'WNA', 'P', 2, 1),
(3, 'suster', 'c4ca4238a0b923820dcc509a6f75849b', '12345678910', 'saya', '0331', 'jember', 'jember', '2010-10-10', 'WNA', 'L', 3, 0),
(4, 'loket', 'c4ca4238a0b923820dcc509a6f75849b', '089798098767', 'Hammam', '089765432431', 'Jl. Jawa No. 16', 'Jember', '1995-11-16', 'WNI', 'L', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE IF NOT EXISTS `visits` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `patient` int(8) NOT NULL,
  `anamnesa` text NOT NULL,
  `paid` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `patient` (`patient`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`id`, `date`, `patient`, `anamnesa`, `paid`) VALUES
(3, '2016-12-15', 3, 'pusing, mual, panas tinggi', 0),
(4, '2016-12-15', 6, 'pusing', 0),
(5, '2016-12-15', 7, 'pusing', 0);

-- --------------------------------------------------------

--
-- Table structure for table `visits_details`
--

CREATE TABLE IF NOT EXISTS `visits_details` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `visits` int(8) NOT NULL,
  `kind` tinyint(1) NOT NULL COMMENT '1 = UGD, 2 = Rawat Jalan, 3 = Rawat Inap',
  `date` date NOT NULL,
  `room` int(8) unsigned DEFAULT NULL,
  `user` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `visits` (`visits`),
  KEY `room` (`room`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `visits_details`
--

INSERT INTO `visits_details` (`id`, `visits`, `kind`, `date`, `room`, `user`) VALUES
(2, 3, 2, '2016-12-15', 1, 1),
(4, 5, 3, '2016-12-15', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `visits_medicine`
--

CREATE TABLE IF NOT EXISTS `visits_medicine` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `visits_detail` int(8) NOT NULL,
  `medicine` int(8) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `visits_detail` (`visits_detail`,`medicine`),
  KEY `medicine` (`medicine`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `visits_treatment`
--

CREATE TABLE IF NOT EXISTS `visits_treatment` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `visits_detail` int(8) NOT NULL,
  `treatment` int(8) NOT NULL,
  `time` datetime NOT NULL,
  `who` int(8) NOT NULL COMMENT 'Dokter yang menangani',
  PRIMARY KEY (`id`),
  KEY `visits` (`visits_detail`,`treatment`,`who`),
  KEY `treatment` (`treatment`),
  KEY `who` (`who`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `diagnosis`
--
ALTER TABLE `diagnosis`
  ADD CONSTRAINT `diagnosis_ibfk_1` FOREIGN KEY (`doctor`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `diagnosis_ibfk_2` FOREIGN KEY (`patient`) REFERENCES `patients` (`id`);

--
-- Constraints for table `diagnosis_detail`
--
ALTER TABLE `diagnosis_detail`
  ADD CONSTRAINT `diagnosis_detail_ibfk_1` FOREIGN KEY (`diagnosis`) REFERENCES `diagnosis` (`id`),
  ADD CONSTRAINT `diagnosis_detail_ibfk_2` FOREIGN KEY (`disease`) REFERENCES `diseases` (`id`);

--
-- Constraints for table `diagnosis_detail_medicine`
--
ALTER TABLE `diagnosis_detail_medicine`
  ADD CONSTRAINT `diagnosis_detail_medicine_ibfk_1` FOREIGN KEY (`diagnosis_detail`) REFERENCES `diagnosis_detail` (`id`),
  ADD CONSTRAINT `diagnosis_detail_medicine_ibfk_2` FOREIGN KEY (`medicine`) REFERENCES `medicine` (`id`);

--
-- Constraints for table `log_activity`
--
ALTER TABLE `log_activity`
  ADD CONSTRAINT `log_activity_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Constraints for table `medicine_restock`
--
ALTER TABLE `medicine_restock`
  ADD CONSTRAINT `medicine_restock_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Constraints for table `medicine_restock_details`
--
ALTER TABLE `medicine_restock_details`
  ADD CONSTRAINT `medicine_restock_details_ibfk_1` FOREIGN KEY (`medicine`) REFERENCES `medicine` (`id`),
  ADD CONSTRAINT `medicine_restock_details_ibfk_2` FOREIGN KEY (`medicine_restock`) REFERENCES `medicine_restock` (`id`);

--
-- Constraints for table `medicine_sales`
--
ALTER TABLE `medicine_sales`
  ADD CONSTRAINT `medicine_sales_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Constraints for table `medicine_sales_details`
--
ALTER TABLE `medicine_sales_details`
  ADD CONSTRAINT `medicine_sales_details_ibfk_1` FOREIGN KEY (`medicine_sales`) REFERENCES `medicine_sales` (`id`),
  ADD CONSTRAINT `medicine_sales_details_ibfk_2` FOREIGN KEY (`medicine_restock_details`) REFERENCES `medicine_restock_details` (`id`);

--
-- Constraints for table `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_ibfk_1` FOREIGN KEY (`patient`) REFERENCES `patients` (`id`);

--
-- Constraints for table `visits_details`
--
ALTER TABLE `visits_details`
  ADD CONSTRAINT `visits_details_ibfk_1` FOREIGN KEY (`visits`) REFERENCES `visits` (`id`),
  ADD CONSTRAINT `visits_details_ibfk_2` FOREIGN KEY (`room`) REFERENCES `room` (`id`),
  ADD CONSTRAINT `visits_details_ibfk_3` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Constraints for table `visits_medicine`
--
ALTER TABLE `visits_medicine`
  ADD CONSTRAINT `visits_medicine_ibfk_2` FOREIGN KEY (`medicine`) REFERENCES `medicine` (`id`),
  ADD CONSTRAINT `visits_medicine_ibfk_3` FOREIGN KEY (`visits_detail`) REFERENCES `visits_details` (`id`);

--
-- Constraints for table `visits_treatment`
--
ALTER TABLE `visits_treatment`
  ADD CONSTRAINT `visits_treatment_ibfk_1` FOREIGN KEY (`visits_detail`) REFERENCES `visits_details` (`id`),
  ADD CONSTRAINT `visits_treatment_ibfk_2` FOREIGN KEY (`treatment`) REFERENCES `treatment` (`id`),
  ADD CONSTRAINT `visits_treatment_ibfk_3` FOREIGN KEY (`who`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
