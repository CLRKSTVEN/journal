-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 07, 2025 at 12:57 PM
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
-- Database: `provincial_meet`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `AddID` int(10) UNSIGNED NOT NULL,
  `Province` varchar(100) NOT NULL DEFAULT '',
  `City` varchar(100) NOT NULL DEFAULT '',
  `Brgy` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`AddID`, `Province`, `City`, `Brgy`) VALUES
(78699, 'DAVAO ORIENTAL', 'BANAYBANAY', 'Cabangcalan'),
(78700, 'DAVAO ORIENTAL', 'BANAYBANAY', 'Caganganan'),
(78701, 'DAVAO ORIENTAL', 'BANAYBANAY', 'Calubihan'),
(78702, 'DAVAO ORIENTAL', 'BANAYBANAY', 'Causwagan'),
(78703, 'DAVAO ORIENTAL', 'BANAYBANAY', 'Punta Linao'),
(78704, 'DAVAO ORIENTAL', 'BANAYBANAY', 'Mahayag'),
(78705, 'DAVAO ORIENTAL', 'BANAYBANAY', 'Maputi'),
(78706, 'DAVAO ORIENTAL', 'BANAYBANAY', 'Mogbongcogon'),
(78707, 'DAVAO ORIENTAL', 'BANAYBANAY', 'Panikian'),
(78708, 'DAVAO ORIENTAL', 'BANAYBANAY', 'Pintatagan'),
(78709, 'DAVAO ORIENTAL', 'BANAYBANAY', 'Piso Proper'),
(78710, 'DAVAO ORIENTAL', 'BANAYBANAY', 'Poblacion'),
(78711, 'DAVAO ORIENTAL', 'BANAYBANAY', 'San Vicente'),
(78712, 'DAVAO ORIENTAL', 'BANAYBANAY', 'Rang-ay'),
(78713, 'DAVAO ORIENTAL', 'BOSTON', 'Cabasagan'),
(78714, 'DAVAO ORIENTAL', 'BOSTON', 'Caatihan'),
(78715, 'DAVAO ORIENTAL', 'BOSTON', 'Cawayanan'),
(78716, 'DAVAO ORIENTAL', 'BOSTON', 'Poblacion'),
(78717, 'DAVAO ORIENTAL', 'BOSTON', 'San Jose'),
(78718, 'DAVAO ORIENTAL', 'BOSTON', 'Sibajay'),
(78719, 'DAVAO ORIENTAL', 'BOSTON', 'Carmen'),
(78720, 'DAVAO ORIENTAL', 'BOSTON', 'Simulao'),
(78721, 'DAVAO ORIENTAL', 'CARAGA', 'Alvar'),
(78722, 'DAVAO ORIENTAL', 'CARAGA', 'Caningag'),
(78723, 'DAVAO ORIENTAL', 'CARAGA', 'Don Leon Balante'),
(78724, 'DAVAO ORIENTAL', 'CARAGA', 'Lamiawan'),
(78725, 'DAVAO ORIENTAL', 'CARAGA', 'Manorigao'),
(78726, 'DAVAO ORIENTAL', 'CARAGA', 'Mercedes'),
(78727, 'DAVAO ORIENTAL', 'CARAGA', 'Palma Gil'),
(78728, 'DAVAO ORIENTAL', 'CARAGA', 'Pichon'),
(78729, 'DAVAO ORIENTAL', 'CARAGA', 'Poblacion'),
(78730, 'DAVAO ORIENTAL', 'CARAGA', 'San Antonio'),
(78731, 'DAVAO ORIENTAL', 'CARAGA', 'San Jose'),
(78732, 'DAVAO ORIENTAL', 'CARAGA', 'San Luis'),
(78733, 'DAVAO ORIENTAL', 'CARAGA', 'San Miguel'),
(78734, 'DAVAO ORIENTAL', 'CARAGA', 'San Pedro'),
(78735, 'DAVAO ORIENTAL', 'CARAGA', 'Santa Fe'),
(78736, 'DAVAO ORIENTAL', 'CARAGA', 'Santiago'),
(78737, 'DAVAO ORIENTAL', 'CARAGA', 'Sobrecarey'),
(78738, 'DAVAO ORIENTAL', 'CATEEL', 'Abijod'),
(78739, 'DAVAO ORIENTAL', 'CATEEL', 'Alegria'),
(78740, 'DAVAO ORIENTAL', 'CATEEL', 'Aliwagwag'),
(78741, 'DAVAO ORIENTAL', 'CATEEL', 'Aragon'),
(78742, 'DAVAO ORIENTAL', 'CATEEL', 'Baybay'),
(78743, 'DAVAO ORIENTAL', 'CATEEL', 'Maglahus'),
(78744, 'DAVAO ORIENTAL', 'CATEEL', 'Mainit'),
(78745, 'DAVAO ORIENTAL', 'CATEEL', 'Malibago'),
(78746, 'DAVAO ORIENTAL', 'CATEEL', 'San Alfonso'),
(78747, 'DAVAO ORIENTAL', 'CATEEL', 'San Antonio'),
(78748, 'DAVAO ORIENTAL', 'CATEEL', 'San Miguel'),
(78749, 'DAVAO ORIENTAL', 'CATEEL', 'San Rafael'),
(78750, 'DAVAO ORIENTAL', 'CATEEL', 'San Vicente'),
(78751, 'DAVAO ORIENTAL', 'CATEEL', 'Santa Filomena'),
(78752, 'DAVAO ORIENTAL', 'CATEEL', 'Taytayan'),
(78753, 'DAVAO ORIENTAL', 'CATEEL', 'Poblacion'),
(78754, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Anitap'),
(78755, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Manuel Roxas'),
(78756, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Don Aurelio Chicote'),
(78757, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Lavigan'),
(78758, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Luzon'),
(78759, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Magdug'),
(78760, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Monserrat'),
(78761, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Nangan'),
(78762, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Oregon'),
(78763, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Poblacion'),
(78764, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Pundaguitan'),
(78765, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Sergio OsmeÃ±a'),
(78766, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Surop'),
(78767, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Tagabebe'),
(78768, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Tamban'),
(78769, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Tandang Sora'),
(78770, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Tibanban'),
(78771, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Tiblawan'),
(78772, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Upper Tibanban'),
(78773, 'DAVAO ORIENTAL', 'GOVERNOR GENEROSO', 'Crispin Dela Cruz'),
(78774, 'DAVAO ORIENTAL', 'LUPON', 'Bagumbayan'),
(78775, 'DAVAO ORIENTAL', 'LUPON', 'Cabadiangan'),
(78776, 'DAVAO ORIENTAL', 'LUPON', 'Calapagan'),
(78777, 'DAVAO ORIENTAL', 'LUPON', 'Cocornon'),
(78778, 'DAVAO ORIENTAL', 'LUPON', 'Corporacion'),
(78779, 'DAVAO ORIENTAL', 'LUPON', 'Don Mariano Marcos'),
(78780, 'DAVAO ORIENTAL', 'LUPON', 'Ilangay'),
(78781, 'DAVAO ORIENTAL', 'LUPON', 'Langka'),
(78782, 'DAVAO ORIENTAL', 'LUPON', 'Lantawan'),
(78783, 'DAVAO ORIENTAL', 'LUPON', 'Limbahan'),
(78784, 'DAVAO ORIENTAL', 'LUPON', 'Macangao'),
(78785, 'DAVAO ORIENTAL', 'LUPON', 'Magsaysay'),
(78786, 'DAVAO ORIENTAL', 'LUPON', 'Mahayahay'),
(78787, 'DAVAO ORIENTAL', 'LUPON', 'Maragatas'),
(78788, 'DAVAO ORIENTAL', 'LUPON', 'Marayag'),
(78789, 'DAVAO ORIENTAL', 'LUPON', 'New Visayas'),
(78790, 'DAVAO ORIENTAL', 'LUPON', 'Poblacion'),
(78791, 'DAVAO ORIENTAL', 'LUPON', 'San Isidro'),
(78792, 'DAVAO ORIENTAL', 'LUPON', 'San Jose'),
(78793, 'DAVAO ORIENTAL', 'LUPON', 'Tagboa'),
(78794, 'DAVAO ORIENTAL', 'LUPON', 'Tagugpo'),
(78795, 'DAVAO ORIENTAL', 'MANAY', 'Capasnan'),
(78796, 'DAVAO ORIENTAL', 'MANAY', 'Cayawan'),
(78797, 'DAVAO ORIENTAL', 'MANAY', 'Central (Pob.)'),
(78798, 'DAVAO ORIENTAL', 'MANAY', 'Concepcion'),
(78799, 'DAVAO ORIENTAL', 'MANAY', 'Del Pilar'),
(78800, 'DAVAO ORIENTAL', 'MANAY', 'Guza'),
(78801, 'DAVAO ORIENTAL', 'MANAY', 'Holy Cross'),
(78802, 'DAVAO ORIENTAL', 'MANAY', 'Mabini'),
(78803, 'DAVAO ORIENTAL', 'MANAY', 'Manreza'),
(78804, 'DAVAO ORIENTAL', 'MANAY', 'Old Macopa'),
(78805, 'DAVAO ORIENTAL', 'MANAY', 'Rizal'),
(78806, 'DAVAO ORIENTAL', 'MANAY', 'San Fermin'),
(78807, 'DAVAO ORIENTAL', 'MANAY', 'San Ignacio'),
(78808, 'DAVAO ORIENTAL', 'MANAY', 'San Isidro'),
(78809, 'DAVAO ORIENTAL', 'MANAY', 'New Taokanga'),
(78810, 'DAVAO ORIENTAL', 'MANAY', 'Zaragosa'),
(78811, 'DAVAO ORIENTAL', 'MANAY', 'Lambog'),
(78838, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'Baon'),
(78839, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'Bitaogan'),
(78840, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'Cambaleon'),
(78841, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'Dugmanon'),
(78842, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'Iba'),
(78843, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'La Union'),
(78844, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'Lapu-lapu'),
(78845, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'Maag'),
(78846, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'Manikling'),
(78847, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'Maputi'),
(78848, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'Batobato (Pob.)'),
(78849, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'San Miguel'),
(78850, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'San Roque'),
(78851, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'Santo Rosario'),
(78852, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'Sudlon'),
(78853, 'DAVAO ORIENTAL', 'SAN ISIDRO', 'Talisay'),
(78854, 'DAVAO ORIENTAL', 'TARRAGONA', 'Cabagayan'),
(78855, 'DAVAO ORIENTAL', 'TARRAGONA', 'Central (Pob.)'),
(78856, 'DAVAO ORIENTAL', 'TARRAGONA', 'Dadong'),
(78857, 'DAVAO ORIENTAL', 'TARRAGONA', 'Jovellar'),
(78858, 'DAVAO ORIENTAL', 'TARRAGONA', 'Limot'),
(78859, 'DAVAO ORIENTAL', 'TARRAGONA', 'Lucatan'),
(78860, 'DAVAO ORIENTAL', 'TARRAGONA', 'Maganda'),
(78861, 'DAVAO ORIENTAL', 'TARRAGONA', 'Ompao'),
(78862, 'DAVAO ORIENTAL', 'TARRAGONA', 'Tomoaong'),
(78863, 'DAVAO ORIENTAL', 'TARRAGONA', 'Tubaon'),
(78925, 'DAVAO ORIENTAL', 'BAGANGA', 'Baculin'),
(78926, 'DAVAO ORIENTAL', 'BAGANGA', 'Banao'),
(78927, 'DAVAO ORIENTAL', 'BAGANGA', 'Batawan'),
(78928, 'DAVAO ORIENTAL', 'BAGANGA', 'Batiano'),
(78929, 'DAVAO ORIENTAL', 'BAGANGA', 'Binondo'),
(78930, 'DAVAO ORIENTAL', 'BAGANGA', 'Bobonao'),
(78931, 'DAVAO ORIENTAL', 'BAGANGA', 'Campawan'),
(78932, 'DAVAO ORIENTAL', 'BAGANGA', 'Central (Pob.)'),
(78933, 'DAVAO ORIENTAL', 'BAGANGA', 'Dapnan'),
(78934, 'DAVAO ORIENTAL', 'BAGANGA', 'Kinablangan'),
(78935, 'DAVAO ORIENTAL', 'BAGANGA', 'Lambajon'),
(78936, 'DAVAO ORIENTAL', 'BAGANGA', 'Mahanub'),
(78937, 'DAVAO ORIENTAL', 'BAGANGA', 'Mikit'),
(78938, 'DAVAO ORIENTAL', 'BAGANGA', 'Salingcomot'),
(78939, 'DAVAO ORIENTAL', 'BAGANGA', 'San Isidro'),
(78940, 'DAVAO ORIENTAL', 'BAGANGA', 'San Victor'),
(78941, 'DAVAO ORIENTAL', 'BAGANGA', 'Lucod'),
(78942, 'DAVAO ORIENTAL', 'BAGANGA', 'Saoquegue');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `username` varchar(80) NOT NULL,
  `email` varchar(120) DEFAULT NULL,
  `position_title` varchar(120) DEFAULT NULL,
  `account_level` varchar(50) NOT NULL DEFAULT 'Administrator',
  `contact_number` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_categories`
--

CREATE TABLE `event_categories` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_categories`
--

INSERT INTO `event_categories` (`category_id`, `category_name`) VALUES
(2, '100m Backstroke'),
(3, '100m Breaststroke'),
(4, '100m Butterfly'),
(5, '100m Freestyle'),
(6, '200 m Individual Medley'),
(7, '200M Backstroke'),
(8, '200M Breaststroke'),
(9, '200m Butterfly'),
(10, '200m Freestyle'),
(11, '3x3'),
(12, '3x4'),
(13, '3x5'),
(14, '400M Freestyle'),
(15, '400m Individual Medley'),
(16, '42-45 kg'),
(17, '45-48kg'),
(18, '48-52kg'),
(20, '4x100m Freestyle Relay'),
(21, '4x100m Medley Relay'),
(22, '4x50m Freestyle Relay'),
(19, '4X50M Medley Relay'),
(23, '50m Backstroke'),
(24, '50m Breaststroke'),
(25, '50m Butterfly'),
(26, '50m Freestyle'),
(27, '52-56kg'),
(28, '5x5'),
(29, '8 Balls'),
(30, '9 Balls'),
(31, 'Bantam Weight'),
(32, 'Category 1'),
(33, 'Category 2'),
(34, 'Category 3'),
(35, 'Category A'),
(36, 'Chacha'),
(72, 'dfsdf'),
(37, 'Doubles'),
(38, 'Extralight Weight'),
(39, 'Feather Weight'),
(40, 'Foxtrot'),
(1, 'Girls Team'),
(41, 'Grade A'),
(42, 'Halflight Weight'),
(43, 'Homo-Doubles'),
(44, 'Individual'),
(45, 'Individual Doble Baston'),
(46, 'Individual Espada y Daga Baston'),
(47, 'Individual Solo Baston'),
(48, 'Jive'),
(49, 'Junior Boys, Light Bantam Category'),
(50, 'Junior Boys, Pin Weight Category'),
(51, 'Mix'),
(52, 'Mixed o'),
(53, 'Pasodoble'),
(54, 'Pin Weight'),
(55, 'Quickstep'),
(56, 'Rumba'),
(57, 'Samba'),
(58, 'Single A'),
(59, 'Single B'),
(60, 'Singles'),
(61, 'Synchronized Doble Baston (Non-Traditional)'),
(62, 'Synchronized Espada y Daga (Non-Traditional)'),
(63, 'Synchronized Solo Baston (Non-Traditional)'),
(64, 'Syncrhonized Doble Baston (Non-Traditional)'),
(65, 'Syncrhonized Espada y Daga (Non-Traditional)'),
(66, 'Tango'),
(67, 'Team'),
(68, 'Under 42kg'),
(69, 'Veinnese Waltz'),
(73, 'WALA'),
(70, 'Waltz'),
(71, 'Youth Men, Bantam Weight Category');

-- --------------------------------------------------------

--
-- Table structure for table `event_groups`
--

CREATE TABLE `event_groups` (
  `group_id` tinyint(3) UNSIGNED NOT NULL,
  `group_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_groups`
--

INSERT INTO `event_groups` (`group_id`, `group_name`) VALUES
(1, 'Elementary'),
(2, 'Secondary'),
(3, 'Team');

-- --------------------------------------------------------

--
-- Table structure for table `event_master`
--

CREATE TABLE `event_master` (
  `event_id` int(10) UNSIGNED NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `group_id` tinyint(3) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_master`
--

INSERT INTO `event_master` (`event_id`, `event_name`, `group_id`, `category_id`) VALUES
(2, '100 Meter (Boys)', 1, NULL),
(3, '100 Meter (Boys)', 2, NULL),
(4, '100 Meter (Girls)', 1, NULL),
(5, '100 Meter (Girls)', 2, NULL),
(6, '1500 Meter (Boys)', 1, NULL),
(7, '1500 Meter (Boys)', 2, NULL),
(9, '1500 Meter (Girks)', 2, NULL),
(8, '1500 Meter (Girls)', 1, NULL),
(10, '2,000 m Walkathon (Girls)', 2, NULL),
(11, '200 m (Girls)', 1, NULL),
(12, '200m (Boys)', 1, NULL),
(13, '200m (Boys)', 2, NULL),
(14, '200m (Girls)', 2, NULL),
(15, '3000 Meter (Girls)', 2, NULL),
(16, '400m (Boys)', 1, NULL),
(17, '400m (Boys)', 2, NULL),
(18, '400m (Girls)', 1, NULL),
(19, '400m (Girls)', 2, NULL),
(20, '4x100 Relay (Boys)', 1, NULL),
(21, '4x100 Relay (Boys)', 2, NULL),
(22, '4x100 Relay (Girls)', 1, NULL),
(23, '4x100 Relay (Girls)', 2, NULL),
(24, '4x400 Relay (Boys)', 1, NULL),
(25, '4x400 Relay (Boys)', 2, NULL),
(26, '4x400 Relay (Girls)', 1, NULL),
(27, '4x400 Relay (Girls)', 2, NULL),
(285, '4x50 MEDLEY RELAY', 1, NULL),
(28, '5,000 m (Boys)', 2, NULL),
(29, '8 Balls (Boys)', 2, 29),
(30, '8 Balls (Girls)', 2, 29),
(31, '800M (Boys)', 1, NULL),
(32, '800m (Boys)', 2, NULL),
(34, '800M (Girls)', 2, NULL),
(33, '800m (Girls) Elemenetary', 1, NULL),
(35, '9 Balls (Boys)', 2, 30),
(36, '9 Balls (Girls)', 2, 30),
(37, 'Archery 30 meters (Boys)', 2, NULL),
(38, 'Archery 30 meters (Girls)', 2, NULL),
(39, 'Archery 50 meters (Boys)', 2, NULL),
(40, 'Archery 50 meters (Girls)', 2, NULL),
(41, 'Archery 50 meters (Mixed Gender)', 2, NULL),
(42, 'Archery Olympic Round', 2, NULL),
(44, 'Arnis Anyo (Boys)', 1, 45),
(45, 'Arnis Anyo (Boys)', 1, 46),
(43, 'Arnis Anyo (Boys)', 1, 47),
(47, 'Arnis Anyo (Boys)', 1, 61),
(48, 'Arnis Anyo (Boys)', 1, 62),
(46, 'Arnis Anyo (Boys)', 1, 63),
(50, 'Arnis Anyo (Boys)', 2, 45),
(51, 'Arnis Anyo (Boys)', 2, 46),
(49, 'Arnis Anyo (Boys)', 2, 47),
(52, 'Arnis Anyo (Boys)', 2, 63),
(53, 'Arnis Anyo (Boys)', 2, 64),
(54, 'Arnis Anyo (Boys)', 2, 65),
(57, 'Arnis Anyo (Girls)', 1, 45),
(58, 'Arnis Anyo (Girls)', 1, 46),
(56, 'Arnis Anyo (Girls)', 1, 47),
(60, 'Arnis Anyo (Girls)', 1, 61),
(61, 'Arnis Anyo (Girls)', 1, 62),
(59, 'Arnis Anyo (Girls)', 1, 63),
(63, 'Arnis Anyo (Girls)', 2, 45),
(64, 'Arnis Anyo (Girls)', 2, 46),
(62, 'Arnis Anyo (Girls)', 2, 47),
(65, 'Arnis Anyo (Girls)', 2, 63),
(66, 'Arnis Anyo (Girls)', 2, 64),
(67, 'Arnis Anyo (Girls)', 2, 65),
(55, 'Arnis Anyo (Mixed)', 1, 61),
(69, 'Arnis Laban (Boys)', 2, 31),
(71, 'Arnis Laban (Boys)', 2, 38),
(70, 'Arnis Laban (Boys)', 2, 39),
(72, 'Arnis Laban (Boys)', 2, 42),
(68, 'Arnis Laban (Boys)', 2, 54),
(74, 'Arnis Laban (Girls)', 2, 31),
(76, 'Arnis Laban (Girls)', 2, 38),
(75, 'Arnis Laban (Girls)', 2, 39),
(77, 'Arnis Laban (Girls)', 2, 42),
(73, 'Arnis Laban (Girls)', 2, 54),
(78, 'Badminton (Boys)', 1, 37),
(80, 'Badminton (Boys)', 1, 58),
(79, 'Badminton (Boys)', 1, 59),
(81, 'Badminton (Boys)', 2, 37),
(82, 'Badminton (Boys)', 2, 58),
(83, 'Badminton (Boys)', 2, 59),
(84, 'Badminton (Girls)', 1, 37),
(85, 'Badminton (Girls)', 1, 58),
(86, 'Badminton (Girls)', 1, 59),
(88, 'Badminton (Girls)', 2, 37),
(89, 'Badminton (Girls)', 2, 58),
(87, 'Badminton (Girls)', 2, 59),
(90, 'Baseball (Boys)', 2, NULL),
(91, 'Basketball (Boys)', 1, 67),
(93, 'Basketball (Boys)', 2, 11),
(94, 'Basketball (Boys)', 2, 12),
(95, 'Basketball (Boys)', 2, 13),
(92, 'Basketball (Boys)', 2, 28),
(96, 'Basketball 3x3', 2, NULL),
(97, 'Basketball 5x5', 2, NULL),
(98, 'Basketball 5x5 Girls', 2, NULL),
(100, 'Boxing', 2, 49),
(99, 'Boxing', 2, 50),
(101, 'Boxing', 2, 71),
(102, 'Chess Tournament - BLITZ Boys', 1, 44),
(103, 'Chess Tournament - BLITZ Boys', 1, 67),
(106, 'Chess Tournament - BLITZ Boys', 2, 44),
(107, 'Chess Tournament - BLITZ Boys', 2, 67),
(104, 'Chess Tournament - BLITZ Girls', 1, 44),
(105, 'Chess Tournament - BLITZ Girls', 1, 67),
(108, 'Chess Tournament - BLITZ Girls', 2, 44),
(109, 'Chess Tournament - BLITZ Girls', 2, 67),
(111, 'Chess Tournament - Standard Boys', 1, 44),
(110, 'Chess Tournament - Standard Boys', 1, 67),
(114, 'Chess Tournament - Standard Boys', 2, 44),
(115, 'Chess Tournament - Standard Boys', 2, 67),
(112, 'Chess Tournament - Standard Girls', 1, 44),
(113, 'Chess Tournament - Standard Girls', 1, 67),
(116, 'Chess Tournament - Standard Girls', 2, 44),
(117, 'Chess Tournament - Standard Girls', 2, 67),
(118, 'Discus Throw (Boys)', 2, NULL),
(119, 'Discus Throw (Girls)', 1, NULL),
(120, 'Discus Throw (Girls)', 2, NULL),
(121, 'Discuss Throw (Boys)', 1, NULL),
(1, 'Elementary Boys', 1, 1),
(122, 'Football', 1, NULL),
(123, 'Football', 2, NULL),
(124, 'Futsal', 2, NULL),
(125, 'High Jump (Boys)', 1, NULL),
(126, 'High Jump (Boys)', 2, NULL),
(127, 'High Jump (Girls)', 1, NULL),
(128, 'High Jump (Girls)', 2, NULL),
(129, 'Javelin Throw (Boys)', 1, NULL),
(130, 'Javelin Throw (Boys)', 2, NULL),
(131, 'Javelin Throw (Girls)', 1, NULL),
(132, 'Javelin Throw (Girls)', 2, NULL),
(133, 'Junior Modern Standard Discipline', 2, 36),
(134, 'Junior Modern Standard Discipline', 2, 40),
(135, 'Junior Modern Standard Discipline', 2, 41),
(136, 'Junior Modern Standard Discipline', 2, 48),
(137, 'Junior Modern Standard Discipline', 2, 53),
(138, 'Junior Modern Standard Discipline', 2, 55),
(139, 'Junior Modern Standard Discipline', 2, 56),
(140, 'Junior Modern Standard Discipline', 2, 57),
(141, 'Junior Modern Standard Discipline', 2, 66),
(143, 'Junior Modern Standard Discipline', 2, 69),
(142, 'Junior Modern Standard Discipline', 2, 70),
(144, 'Juvenile Latin American Discipline', 1, 36),
(145, 'Juvenile Latin American Discipline', 1, 41),
(146, 'Juvenile Latin American Discipline', 1, 48),
(147, 'Juvenile Latin American Discipline', 1, 53),
(148, 'Juvenile Latin American Discipline', 1, 56),
(149, 'Juvenile Latin American Discipline', 1, 57),
(150, 'Juvenile Modern Standard Discipline', 1, 40),
(151, 'Juvenile Modern Standard Discipline', 1, 41),
(152, 'Juvenile Modern Standard Discipline', 1, 55),
(153, 'Juvenile Modern Standard Discipline', 1, 66),
(154, 'Juvenile Modern Standard Discipline', 1, 69),
(155, 'Juvenile Modern Standard Discipline', 1, 70),
(156, 'KYUROGI (Boys)', 1, 32),
(157, 'KYUROGI (Boys)', 1, 33),
(158, 'KYUROGI (Girls)', 1, 32),
(159, 'KYUROGI (Girls)', 1, 33),
(160, 'KYUROGI (Girls)', 1, 34),
(161, 'Long Jump (Boys)', 1, NULL),
(162, 'Long Jump (Boys)', 2, NULL),
(163, 'Long Jump (Girls)', 1, NULL),
(164, 'Long Jump (Girls)', 2, NULL),
(165, 'Men\'s Artistic Gymnastics', 2, NULL),
(166, 'Men\'s Artistic Gymnastics', 2, NULL),
(167, 'Poomsae (Boys)', 1, 35),
(284, 'Poomsae (Boys)', 1, 52),
(168, 'Poomsae (Boys)', 1, 67),
(174, 'Poomsae (Boys)', 2, 35),
(175, 'Poomsae (Boys)', 2, 67),
(169, 'Poomsae (Girls)', 1, 35),
(170, 'Poomsae (Girls)', 1, 52),
(171, 'Poomsae (Girls)', 1, 67),
(176, 'Poomsae (Girls)', 2, 35),
(173, 'Poomsae (Girls)', 2, 52),
(177, 'Poomsae (Girls)', 2, 67),
(172, 'Poomsae (Team)', 1, 67),
(178, 'Rhythmic Gymnastics', 2, NULL),
(179, 'Rhythmic Gymnastics', 2, NULL),
(180, 'Rhythmic Gymnastics', 2, NULL),
(181, 'Rhythmic Gymnastics', 2, NULL),
(182, 'Sepak Takraw (Boys)', 1, NULL),
(183, 'Sepak Takraw (Boys)', 2, NULL),
(184, 'Sepak Takraw (Girls)', 2, NULL),
(185, 'Shot Put (Boys)', 1, NULL),
(186, 'Shot Put (Boys)', 2, NULL),
(187, 'Shot Put (Girls)', 1, NULL),
(188, 'Shot Put (Girls)', 2, NULL),
(189, 'Softball', 1, NULL),
(190, 'Softball', 2, NULL),
(192, 'Swimming (Boys)', 1, 2),
(191, 'Swimming (Boys)', 1, 10),
(193, 'Swimming (Boys)', 1, 19),
(199, 'Swimming (Boys)', 1, 20),
(198, 'Swimming (Boys)', 1, 21),
(194, 'Swimming (Boys)', 1, 23),
(195, 'Swimming (Boys)', 1, 24),
(197, 'Swimming (Boys)', 1, 25),
(196, 'Swimming (Boys)', 1, 26),
(201, 'Swimming (Boys)', 2, 2),
(203, 'Swimming (Boys)', 2, 7),
(202, 'Swimming (Boys)', 2, 8),
(207, 'Swimming (Boys)', 2, 9),
(200, 'Swimming (Boys)', 2, 10),
(204, 'Swimming (Boys)', 2, 14),
(206, 'Swimming (Boys)', 2, 15),
(205, 'Swimming (Boys)', 2, 19),
(209, 'Swimming (Boys)', 2, 20),
(208, 'Swimming (Boys)', 2, 21),
(211, 'Swimming (Girls)', 1, 2),
(210, 'Swimming (Girls)', 1, 10),
(212, 'Swimming (Girls)', 1, 19),
(218, 'Swimming (Girls)', 1, 20),
(217, 'Swimming (Girls)', 1, 21),
(213, 'Swimming (Girls)', 1, 23),
(214, 'Swimming (Girls)', 1, 24),
(216, 'Swimming (Girls)', 1, 25),
(215, 'Swimming (Girls)', 1, 26),
(220, 'Swimming (Girls)', 2, 2),
(222, 'Swimming (Girls)', 2, 7),
(221, 'Swimming (Girls)', 2, 8),
(226, 'Swimming (Girls)', 2, 9),
(219, 'Swimming (Girls)', 2, 10),
(223, 'Swimming (Girls)', 2, 14),
(225, 'Swimming (Girls)', 2, 15),
(224, 'Swimming (Girls)', 2, 19),
(228, 'Swimming (Girls)', 2, 20),
(227, 'Swimming (Girls)', 2, 21),
(230, 'Swimming 100m (Boys)', 1, 3),
(231, 'Swimming 100m (Boys)', 1, 4),
(229, 'Swimming 100m (Boys)', 1, 5),
(233, 'Swimming 100m (Boys)', 2, 3),
(234, 'Swimming 100m (Boys)', 2, 4),
(232, 'Swimming 100m (Boys)', 2, 5),
(236, 'Swimming 100m (Girls)', 1, 3),
(237, 'Swimming 100m (Girls)', 1, 4),
(235, 'Swimming 100m (Girls)', 1, 5),
(239, 'Swimming 100m (Girls)', 2, 3),
(240, 'Swimming 100m (Girls)', 2, 4),
(238, 'Swimming 100m (Girls)', 2, 5),
(241, 'Swimming 200m (Boys)', 1, NULL),
(242, 'Swimming 200m Individual Medley (Boys)', 2, 6),
(243, 'Swimming 200m Individual Medley (Girls)', 1, NULL),
(244, 'Swimming 200m Individual Medley (Girls)', 2, 6),
(245, 'Swimming 4x50m (Boys)', 1, 22),
(246, 'Swimming 4x50m (Boys)', 2, 22),
(247, 'Swimming 4x50m (Girls)', 1, 22),
(248, 'Swimming 4x50m (Girls)', 2, 22),
(250, 'Table Tennis (Boys)', 1, 43),
(249, 'Table Tennis (Boys)', 1, 60),
(254, 'Table Tennis (Boys)', 2, 43),
(253, 'Table Tennis (Boys)', 2, 60),
(252, 'Table Tennis (Girls)', 1, 43),
(251, 'Table Tennis (Girls)', 1, 60),
(256, 'Table Tennis (Girls)', 2, 43),
(255, 'Table Tennis (Girls)', 2, 60),
(258, 'Tennis (Boys)', 1, 37),
(257, 'Tennis (Boys)', 1, 60),
(260, 'Tennis (Boys)', 2, 37),
(261, 'Tennis (Boys)', 2, 51),
(259, 'Tennis (Boys)', 2, 60),
(263, 'Tennis (Girls)', 1, 37),
(262, 'Tennis (Girls)', 1, 60),
(265, 'Tennis (Girls)', 2, 37),
(264, 'Tennis (Girls)', 2, 60),
(266, 'Tennis (Mix)', 1, 51),
(267, 'Triple Jump (boys)', 1, NULL),
(268, 'Triple Jump (boys)', 2, NULL),
(269, 'Triple Jump (Girls)', 1, NULL),
(270, 'Triple Jump (Girls)', 2, NULL),
(271, 'Volleyball (Boys)', 1, NULL),
(272, 'Volleyball (Boys)', 2, NULL),
(273, 'Volleyball (Girls)', 1, NULL),
(274, 'Volleyball (Girls)', 2, NULL),
(275, 'Walkathon (Boys)', 2, NULL),
(280, 'WUSHU (Boys)', 2, 16),
(281, 'WUSHU (Boys)', 2, 17),
(282, 'WUSHU (Boys)', 2, 18),
(283, 'WUSHU (Boys)', 2, 27),
(279, 'WUSHU (Boys)', 2, 68),
(277, 'WUSHU (Girls)', 2, 16),
(278, 'WUSHU (Girls)', 2, 18),
(276, 'WUSHU (Girls)', 2, 68);

-- --------------------------------------------------------

--
-- Table structure for table `meet_settings`
--

CREATE TABLE `meet_settings` (
  `id` int(11) NOT NULL,
  `meet_title` varchar(150) NOT NULL DEFAULT 'Provincial Meet',
  `meet_year` varchar(20) NOT NULL DEFAULT '2025',
  `subtitle` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meet_settings`
--

INSERT INTO `meet_settings` (`id`, `meet_title`, `meet_year`, `subtitle`, `updated_at`) VALUES
(1, 'Provincial Meet', '2025', 'Live results encoded by authorized officials. ', '2025-12-01 09:17:11');

-- --------------------------------------------------------

--
-- Table structure for table `raw_results`
--

CREATE TABLE `raw_results` (
  `event_name` varchar(255) NOT NULL,
  `event_group` varchar(50) NOT NULL,
  `category` varchar(150) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `medal` varchar(50) DEFAULT NULL,
  `municipality` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_address`
--

CREATE TABLE `settings_address` (
  `AddID` int(10) UNSIGNED NOT NULL,
  `Province` varchar(100) NOT NULL DEFAULT '',
  `City` varchar(100) NOT NULL DEFAULT '',
  `Brgy` varchar(100) NOT NULL DEFAULT '',
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings_address`
--

INSERT INTO `settings_address` (`AddID`, `Province`, `City`, `Brgy`, `logo`) VALUES
(78699, 'DAVAO ORIENTAL', 'Banaybanay Blazers', 'Cabangcalan', '55c0e30bb327e6e2193ba1e9b1da05bc.jpeg'),
(78700, 'DAVAO ORIENTAL', 'Banaybanay Blazers', 'Caganganan', '55c0e30bb327e6e2193ba1e9b1da05bc.jpeg'),
(78701, 'DAVAO ORIENTAL', 'Banaybanay Blazers', 'Calubihan', '55c0e30bb327e6e2193ba1e9b1da05bc.jpeg'),
(78702, 'DAVAO ORIENTAL', 'Banaybanay Blazers', 'Causwagan', '55c0e30bb327e6e2193ba1e9b1da05bc.jpeg'),
(78703, 'DAVAO ORIENTAL', 'Banaybanay Blazers', 'Punta Linao', '55c0e30bb327e6e2193ba1e9b1da05bc.jpeg'),
(78704, 'DAVAO ORIENTAL', 'Banaybanay Blazers', 'Mahayag', '55c0e30bb327e6e2193ba1e9b1da05bc.jpeg'),
(78705, 'DAVAO ORIENTAL', 'Banaybanay Blazers', 'Maputi', '55c0e30bb327e6e2193ba1e9b1da05bc.jpeg'),
(78706, 'DAVAO ORIENTAL', 'Banaybanay Blazers', 'Mogbongcogon', '55c0e30bb327e6e2193ba1e9b1da05bc.jpeg'),
(78707, 'DAVAO ORIENTAL', 'Banaybanay Blazers', 'Panikian', '55c0e30bb327e6e2193ba1e9b1da05bc.jpeg'),
(78708, 'DAVAO ORIENTAL', 'Banaybanay Blazers', 'Pintatagan', '55c0e30bb327e6e2193ba1e9b1da05bc.jpeg'),
(78709, 'DAVAO ORIENTAL', 'Banaybanay Blazers', 'Piso Proper', '55c0e30bb327e6e2193ba1e9b1da05bc.jpeg'),
(78710, 'DAVAO ORIENTAL', 'Banaybanay Blazers', 'Poblacion', '55c0e30bb327e6e2193ba1e9b1da05bc.jpeg'),
(78711, 'DAVAO ORIENTAL', 'Banaybanay Blazers', 'San Vicente', '55c0e30bb327e6e2193ba1e9b1da05bc.jpeg'),
(78712, 'DAVAO ORIENTAL', 'Banaybanay Blazers', 'Rang-ay', '55c0e30bb327e6e2193ba1e9b1da05bc.jpeg'),
(78713, 'DAVAO ORIENTAL', 'Boston Islander', 'Cabasagan', '3ac7bfc46a33dacb5eeb393c39cfff16.jpeg'),
(78714, 'DAVAO ORIENTAL', 'Boston Islander', 'Caatihan', '3ac7bfc46a33dacb5eeb393c39cfff16.jpeg'),
(78715, 'DAVAO ORIENTAL', 'Boston Islander', 'Cawayanan', '3ac7bfc46a33dacb5eeb393c39cfff16.jpeg'),
(78716, 'DAVAO ORIENTAL', 'Boston Islander', 'Poblacion', '3ac7bfc46a33dacb5eeb393c39cfff16.jpeg'),
(78717, 'DAVAO ORIENTAL', 'Boston Islander', 'San Jose', '3ac7bfc46a33dacb5eeb393c39cfff16.jpeg'),
(78718, 'DAVAO ORIENTAL', 'Boston Islander', 'Sibajay', '3ac7bfc46a33dacb5eeb393c39cfff16.jpeg'),
(78719, 'DAVAO ORIENTAL', 'Boston Islander', 'Carmen', '3ac7bfc46a33dacb5eeb393c39cfff16.jpeg'),
(78720, 'DAVAO ORIENTAL', 'Boston Islander', 'Simulao', '3ac7bfc46a33dacb5eeb393c39cfff16.jpeg'),
(78721, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'Alvar', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78722, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'Caningag', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78723, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'Don Leon Balante', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78724, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'Lamiawan', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78725, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'Manorigao', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78726, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'Mercedes', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78727, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'Palma Gil', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78728, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'Pichon', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78729, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'Poblacion', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78730, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'San Antonio', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78731, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'San Jose', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78732, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'San Luis', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78733, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'San Miguel', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78734, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'San Pedro', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78735, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'Santa Fe', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78736, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'Santiago', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78737, 'DAVAO ORIENTAL', 'Caraga Dawnbreakers', 'Sobrecarey', '7ff0ddedc1f9d90203b52d5f9b6e9ab2.jpeg'),
(78738, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'Abijod', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78739, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'Alegria', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78740, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'Aliwagwag', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78741, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'Aragon', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78742, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'Baybay', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78743, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'Maglahus', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78744, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'Mainit', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78745, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'Malibago', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78746, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'San Alfonso', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78747, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'San Antonio', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78748, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'San Miguel', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78749, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'San Rafael', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78750, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'San Vicente', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78751, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'Santa Filomena', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78752, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'Taytayan', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78753, 'DAVAO ORIENTAL', 'Cateel Majestic Knights', 'Poblacion', 'be80cb2e6b5c07fe724b1b9960d4f215.jpeg'),
(78754, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Anitap', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78755, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Manuel Roxas', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78756, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Don Aurelio Chicote', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78757, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Lavigan', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78758, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Luzon', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78759, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Magdug', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78760, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Monserrat', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78761, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Nangan', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78762, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Oregon', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78763, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Poblacion', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78764, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Pundaguitan', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78765, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Sergio OsmeÃ±a', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78766, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Surop', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78767, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Tagabebe', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78768, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Tamban', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78769, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Tandang Sora', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78770, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Tibanban', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78771, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Tiblawan', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78772, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Upper Tibanban', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78773, 'DAVAO ORIENTAL', 'Gov Gen Fishers', 'Crispin Dela Cruz', '1213b01fb57ae8d8d5180025ab93ee46.jpeg'),
(78774, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Bagumbayan', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78775, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Cabadiangan', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78776, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Calapagan', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78777, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Cocornon', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78778, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Corporacion', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78779, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Don Mariano Marcos', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78780, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Ilangay', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78781, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Langka', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78782, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Lantawan', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78783, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Limbahan', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78784, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Macangao', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78785, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Magsaysay', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78786, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Mahayahay', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78787, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Maragatas', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78788, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Marayag', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78789, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'New Visayas', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78790, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Poblacion', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78791, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'San Isidro', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78792, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'San Jose', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78793, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Tagboa', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78794, 'DAVAO ORIENTAL', 'Lupon Green Warriors', 'Tagugpo', '5ce83c0e972eacb3cc7ff9637012d9b3.jpeg'),
(78795, 'DAVAO ORIENTAL', 'Manay Stallions', 'Capasnan', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78796, 'DAVAO ORIENTAL', 'Manay Stallions', 'Cayawan', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78797, 'DAVAO ORIENTAL', 'Manay Stallions', 'Central (Pob.)', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78798, 'DAVAO ORIENTAL', 'Manay Stallions', 'Concepcion', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78799, 'DAVAO ORIENTAL', 'Manay Stallions', 'Del Pilar', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78800, 'DAVAO ORIENTAL', 'Manay Stallions', 'Guza', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78801, 'DAVAO ORIENTAL', 'Manay Stallions', 'Holy Cross', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78802, 'DAVAO ORIENTAL', 'Manay Stallions', 'Mabini', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78803, 'DAVAO ORIENTAL', 'Manay Stallions', 'Manreza', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78804, 'DAVAO ORIENTAL', 'Manay Stallions', 'Old Macopa', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78805, 'DAVAO ORIENTAL', 'Manay Stallions', 'Rizal', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78806, 'DAVAO ORIENTAL', 'Manay Stallions', 'San Fermin', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78807, 'DAVAO ORIENTAL', 'Manay Stallions', 'San Ignacio', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78808, 'DAVAO ORIENTAL', 'Manay Stallions', 'San Isidro', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78809, 'DAVAO ORIENTAL', 'Manay Stallions', 'New Taokanga', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78810, 'DAVAO ORIENTAL', 'Manay Stallions', 'Zaragosa', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78811, 'DAVAO ORIENTAL', 'Manay Stallions', 'Lambog', 'cec97e1f66e23c8323667a17801257c4.jpeg'),
(78838, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'Baon', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78839, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'Bitaogan', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78840, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'Cambaleon', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78841, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'Dugmanon', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78842, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'Iba', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78843, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'La Union', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78844, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'Lapu-lapu', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78845, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'Maag', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78846, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'Manikling', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78847, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'Maputi', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78848, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'Batobato (Pob.)', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78849, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'San Miguel', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78850, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'San Roque', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78851, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'Santo Rosario', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78852, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'Sudlon', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78853, 'DAVAO ORIENTAL', 'San Isidro Eagles', 'Talisay', '769dec6865d087d3d0a3c3fcea51e0a2.jpeg'),
(78854, 'DAVAO ORIENTAL', 'Tarragona Trailblazers', 'Cabagayan', '2136da1d7f12b92d54c60ae3fec0f266.jpeg'),
(78855, 'DAVAO ORIENTAL', 'Tarragona Trailblazers', 'Central (Pob.)', '2136da1d7f12b92d54c60ae3fec0f266.jpeg'),
(78856, 'DAVAO ORIENTAL', 'Tarragona Trailblazers', 'Dadong', '2136da1d7f12b92d54c60ae3fec0f266.jpeg'),
(78857, 'DAVAO ORIENTAL', 'Tarragona Trailblazers', 'Jovellar', '2136da1d7f12b92d54c60ae3fec0f266.jpeg'),
(78858, 'DAVAO ORIENTAL', 'Tarragona Trailblazers', 'Limot', '2136da1d7f12b92d54c60ae3fec0f266.jpeg'),
(78859, 'DAVAO ORIENTAL', 'Tarragona Trailblazers', 'Lucatan', '2136da1d7f12b92d54c60ae3fec0f266.jpeg'),
(78860, 'DAVAO ORIENTAL', 'Tarragona Trailblazers', 'Maganda', '2136da1d7f12b92d54c60ae3fec0f266.jpeg'),
(78861, 'DAVAO ORIENTAL', 'Tarragona Trailblazers', 'Ompao', '2136da1d7f12b92d54c60ae3fec0f266.jpeg'),
(78862, 'DAVAO ORIENTAL', 'Tarragona Trailblazers', 'Tomoaong', '2136da1d7f12b92d54c60ae3fec0f266.jpeg'),
(78863, 'DAVAO ORIENTAL', 'Tarragona Trailblazers', 'Tubaon', '2136da1d7f12b92d54c60ae3fec0f266.jpeg'),
(78925, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Baculin', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78926, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Banao', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78927, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Batawan', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78928, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Batiano', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78929, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Binondo', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78930, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Bobonao', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78931, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Campawan', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78932, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Central (Pob.)', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78933, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Dapnan', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78934, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Kinablangan', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78935, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Lambajon', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78936, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Mahanub', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78937, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Mikit', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78938, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Salingcomot', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78939, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'San Isidro', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78940, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'San Victor', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78941, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Lucod', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg'),
(78942, 'DAVAO ORIENTAL', 'Banganga Coastal Crushers', 'Saoquegue', 'bdcab9d3d56688d9b80f69fff90f4bd8.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `technical_officials`
--

CREATE TABLE `technical_officials` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `role` enum('Tournament Manager','Technical Official') NOT NULL DEFAULT 'Technical Official',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `event_id` int(10) UNSIGNED DEFAULT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `event_group` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `technical_officials`
--

INSERT INTO `technical_officials` (`id`, `name`, `role`, `created_at`, `event_id`, `event_name`, `event_group`, `category`) VALUES
(4, 'TYRONE EDONG', 'Tournament Manager', '2025-12-06 01:10:04', 8, '1500 Meter (Girls)', 'Elementary', '100m Butterfly');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(10) UNSIGNED NOT NULL,
  `IDNumber` varchar(50) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `fName` varchar(100) DEFAULT NULL,
  `mName` varchar(100) DEFAULT NULL,
  `lName` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'default.png',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `IDNumber`, `username`, `password`, `position`, `fName`, `mName`, `lName`, `email`, `avatar`, `is_active`, `dateCreated`) VALUES
(4, 'admin', 'admin', '$2y$10$16n4r1MQKGloMdMYYjP2fObx8.BieprFIzCuzWgsZRwUDXcVnMHHG', 'Administrator', 'System', '', 'Admin', 'admin@example.com', 'avatar_admin_1764577224.jpeg', 1, '2025-12-01 15:13:45');

-- --------------------------------------------------------

--
-- Table structure for table `winners`
--

CREATE TABLE `winners` (
  `id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) UNSIGNED DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_group` varchar(50) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `medal` enum('Gold','Silver','Bronze') NOT NULL,
  `municipality` varchar(150) NOT NULL,
  `school` varchar(200) DEFAULT NULL,
  `coach` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `winners`
--

INSERT INTO `winners` (`id`, `event_id`, `first_name`, `middle_name`, `last_name`, `event_name`, `event_group`, `category`, `medal`, `municipality`, `school`, `coach`, `created_at`) VALUES
(31, 197, 'EBANO, KRIS ROLANCH\r\nBAYATE, KANEJAY\r\nBARRIDA, JEMAR\r\nMAQUILING, ROMARITO II', '', '', 'Swimming (Boys)', 'Elementary', '4X50M Medley Relay', 'Gold', 'Gov Gen Fishers', '', '', '2025-12-07 02:58:57'),
(32, 6, 'KRIS ROLANCH', '', 'EBANO', '1500 Meter (Boys)', 'Elementary', NULL, 'Gold', 'Boston Islander', '', '', '2025-12-07 04:46:40'),
(33, 9, 'CLARK', '', 'EDONG', '1500 Meter (Girks)', 'Secondary', NULL, 'Gold', 'Banganga Coastal Crushers', '', '', '2025-12-07 10:48:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`AddID`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_username` (`username`);

--
-- Indexes for table `event_categories`
--
ALTER TABLE `event_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `event_groups`
--
ALTER TABLE `event_groups`
  ADD PRIMARY KEY (`group_id`),
  ADD UNIQUE KEY `group_name` (`group_name`);

--
-- Indexes for table `event_master`
--
ALTER TABLE `event_master`
  ADD PRIMARY KEY (`event_id`),
  ADD UNIQUE KEY `uq_event_group_category` (`event_name`,`group_id`,`category_id`),
  ADD KEY `fk_eventmaster_group` (`group_id`),
  ADD KEY `fk_eventmaster_category` (`category_id`);

--
-- Indexes for table `meet_settings`
--
ALTER TABLE `meet_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings_address`
--
ALTER TABLE `settings_address`
  ADD PRIMARY KEY (`AddID`);

--
-- Indexes for table `technical_officials`
--
ALTER TABLE `technical_officials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- Indexes for table `winners`
--
ALTER TABLE `winners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_winners_eventmaster` (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `AddID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83873;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_categories`
--
ALTER TABLE `event_categories`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `event_groups`
--
ALTER TABLE `event_groups`
  MODIFY `group_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event_master`
--
ALTER TABLE `event_master`
  MODIFY `event_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT for table `meet_settings`
--
ALTER TABLE `meet_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings_address`
--
ALTER TABLE `settings_address`
  MODIFY `AddID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83874;

--
-- AUTO_INCREMENT for table `technical_officials`
--
ALTER TABLE `technical_officials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `winners`
--
ALTER TABLE `winners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_master`
--
ALTER TABLE `event_master`
  ADD CONSTRAINT `fk_eventmaster_category` FOREIGN KEY (`category_id`) REFERENCES `event_categories` (`category_id`),
  ADD CONSTRAINT `fk_eventmaster_group` FOREIGN KEY (`group_id`) REFERENCES `event_groups` (`group_id`);

--
-- Constraints for table `winners`
--
ALTER TABLE `winners`
  ADD CONSTRAINT `fk_winners_eventmaster` FOREIGN KEY (`event_id`) REFERENCES `event_master` (`event_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
