-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Gazda: localhost
-- Timp de generare: 22 Aug 2012 la 12:24
-- Versiune server: 5.5.24-log
-- Versiune PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza de date: `homequest`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `tf_homequest_seek_index_posts`
--

CREATE TABLE IF NOT EXISTS `tf_homequest_seek_index_posts` (
  `post_id` int(255) NOT NULL,
  `_terms` longtext,
  `seek_property_sale_type` int(255) NOT NULL DEFAULT '1',
  `seek_property_price` int(255) NOT NULL DEFAULT '0',
  `seek_property_bedrooms` int(255) NOT NULL DEFAULT '0',
  `seek_property_baths` int(255) NOT NULL DEFAULT '0',
  `seek_property_square` int(255) NOT NULL DEFAULT '0',
  `seek_property_maps_has_position` int(255) NOT NULL DEFAULT '0',
  `seek_property_maps_lat` varchar(255) NOT NULL DEFAULT '0',
  `seek_property_maps_lng` varchar(255) NOT NULL DEFAULT '0',
  UNIQUE KEY `post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Salvarea datelor din tabel `tf_homequest_seek_index_posts`
--

INSERT INTO `tf_homequest_seek_index_posts` (`post_id`, `_terms`, `seek_property_sale_type`, `seek_property_price`, `seek_property_bedrooms`, `seek_property_baths`, `seek_property_square`, `seek_property_maps_has_position`, `seek_property_maps_lat`, `seek_property_maps_lng`) VALUES
(42, '59,47,61,28,30,31,32,33,34,41,54,29,35,36,', 1, 789000, 4, 3, 6086, 1, '40.701512', '-73.98428'),
(268, '50,59,47,61,62,30,31,32,33,34,41,54,29,35,36,39,51,52,53,56,38,', 1, 2000000, 6, 4, 8530, 1, '40.693297', '-74.001011'),
(274, '26,47,61,62,31,32,33,34,54,35,39,53,56,43,45,46,', 1, 420000, 2, 2, 1250, 1, '40.691019', '-74.021165'),
(279, '26,47,66,30,31,32,34,41,35,39,52,53,43,45,46,', 1, 1790000, 3, 2, 1500, 1, '40.707124', '-74.009155'),
(284, '59,47,61,68,30,31,33,34,35,36,39,51,52,53,56,43,46,', 1, 650000, 4, 3, 4200, 1, '40.705221', '-73.954213'),
(325, '26,37,31,32,33,34,41,54,39,51,53,56,', 1, 590000, 3, 2, 13760, 1, '40.705042', '-74.046920'),
(333, '50,59,37,40,41,44,49,39,51,52,56,43,45,46,', 2, 45000, 0, 0, 1, 1, '40.71151612319385', '-74.05870914459229'),
(338, '59,37,64,28,30,31,32,33,34,41,29,35,36,39,51,52,53,56,43,55,', 1, 7900000, 6, 4, 13760, 1, '40.69310161435084', '-74.06767845153809'),
(344, '50,37,64,38,45,46,', 2, 1500, 0, 2, 5200, 1, '40.70230950514285', '-74.07651901245117'),
(351, '59,47,65,66,35,36,39,52,43,46,', 1, 6890000, 4, 3, 4355, 1, '40.7023745740469', '-74.10261154174805'),
(356, '50,37,60,36,39,52,53,43,45,46,', 2, 3500, 0, 2, 1, 1, '40.7164279675614', '-74.06793594360352'),
(360, '50,42,28,30,33,44,29,39,56,58,46,55,', 2, 3200, 5, 2, 4322, 1, '51.50561724594842', '-0.1096487045288086'),
(361, '50,42,31,33,34,49,35,36,51,56,58,55,', 2, 435, 1, 1, 1, 1, '51.50147667659368', '-0.11724472045898438'),
(362, '50,37,64,48,31,40,41,44,49,29,39,53,56,43,46,', 2, 7600, 1, 1, 1, 1, '40.70757988042049', '-74.1331672668457'),
(533, '50,48,40,44,49,54,43,46,', 2, 1800, 0, 0, 0, 1, '40.729177554196376', '-74.17591094970703'),
(559, '50,42,33,40,44,49,58,55,', 2, 2100, 1, 1, 1, 1, '51.505510397274925', '-0.13016223907470703'),
(560, '26,42,32,40,41,44,35,36,51,53,58,27,55,', 1, 435000, 3, 1, 1, 1, '51.499927205524024', '-0.09949922561645508'),
(561, '50,42,33,34,41,44,39,52,53,56,58,46,', 2, 5467, 1, 1, 1, 1, '51.498938722318094', '-0.09239673614501953');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
