-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 30, 2020 at 11:34 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kirklees-hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

DROP TABLE IF EXISTS `amenities`;
CREATE TABLE IF NOT EXISTS `amenities` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `name`) VALUES
(1, 'WiFi'),
(2, 'Swimming Pool'),
(3, 'Spa'),
(4, 'Parking'),
(5, 'Gym'),
(6, 'A/C'),
(7, 'Restaurant'),
(8, 'TV'),
(9, 'Pets'),
(10, '24-hour reception');

-- --------------------------------------------------------

--
-- Table structure for table `amenity_hotel`
--

DROP TABLE IF EXISTS `amenity_hotel`;
CREATE TABLE IF NOT EXISTS `amenity_hotel` (
  `amenity_id` int(10) UNSIGNED NOT NULL,
  `hotel_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`amenity_id`,`hotel_id`),
  KEY `fk_amenity_hotel__hotel` (`hotel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `amenity_hotel`
--

INSERT INTO `amenity_hotel` (`amenity_id`, `hotel_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(10, 1),
(4, 2),
(8, 2),
(1, 3),
(4, 3),
(6, 3),
(7, 3),
(8, 3),
(10, 3),
(1, 4),
(7, 4),
(10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

DROP TABLE IF EXISTS `hotels`;
CREATE TABLE IF NOT EXISTS `hotels` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `stars` tinyint(4) NOT NULL,
  `price` smallint(6) NOT NULL,
  `check_in` time NOT NULL,
  `check_out` time NOT NULL,
  `location_id` int(10) UNSIGNED NOT NULL,
  `style_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_hotels_locations_location_id` (`location_id`),
  KEY `fk_hotels_styles_style_id` (`style_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `stars`, `price`, `check_in`, `check_out`, `location_id`, `style_id`) VALUES
(1, 'The Georgian', 5, 112, '15:00:00', '11:00:00', 1, 5),
(2, 'Newfields Guesthouse', 2, 28, '12:00:00', '11:00:00', 2, 2),
(3, 'The Regency', 4, 98, '14:00:00', '10:30:00', 5, 3),
(4, 'The Merchants Hotel', 4, 105, '15:00:00', '11:30:00', 7, 4);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `location` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location`) VALUES
(1, 'Batley'),
(2, 'Colne Valley'),
(3, 'Denby Dale'),
(4, 'Holme valley'),
(5, 'Huddersfield East'),
(6, 'Huddersfield West'),
(7, 'Kirkburton'),
(8, 'Mirfield'),
(9, 'Spen Valley and Heckmondwike');

-- --------------------------------------------------------

--
-- Table structure for table `styles`
--

DROP TABLE IF EXISTS `styles`;
CREATE TABLE IF NOT EXISTS `styles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `styles`
--

INSERT INTO `styles` (`id`, `name`) VALUES
(1, 'Boutique'),
(2, 'Budget'),
(3, 'Business'),
(4, 'Historic'),
(5, 'Luxury');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint(4) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'k.l.hutton@assign3.ac.uk', '$2y$10$C8RsCwFPKUbhuWU9ze4p9e1TdjJxhUVKp/IJF9kpxzul9jgmDya36', 1, 'rWNI09K3CQc9jqg1vXqA5J1Szn1UrHAVM5LeDaMDUuDBJrihHyW4nqwxPTzd', NULL, NULL),
(2, 'y.miandad@assign3.ac.uk', '$2y$10$x7f9igWGzIUVJ4XcGxVbmO6LHe.HwLLGqR0aA6gllxMT50.POHMM.', 2, 'lhE5X6kNWnKAnjJeTvRlB2AaFf884UiB0J2GlJdgvIixqNNmRKkK74xNsOBi', NULL, NULL),
(3, 's.laxman@assign3.ac.uk', '$2y$10$JBaf7d66ishGUwGDcgSs.uNKyqTqEcdMzZgiPBvp5034wCB.hikKS', 1, NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `amenity_hotel`
--
ALTER TABLE `amenity_hotel`
  ADD CONSTRAINT `fk_amenity_hotel__amenity` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`),
  ADD CONSTRAINT `fk_amenity_hotel__hotel` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`);

--
-- Constraints for table `hotels`
--
ALTER TABLE `hotels`
  ADD CONSTRAINT `fk_hotels_locations_location_id` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `fk_hotels_styles_style_id` FOREIGN KEY (`style_id`) REFERENCES `styles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
