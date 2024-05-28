-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2024 at 06:35 PM
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
-- Database: `cropsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `breed_name_tb`
--

CREATE TABLE `breed_name_tb` (
  `id` int(200) NOT NULL,
  `breed_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `breed_name_tb`
--

INSERT INTO `breed_name_tb` (`id`, `breed_name`) VALUES
(39, 'pumpoy'),
(74, 'Bigwhith'),
(75, 'Samly'),
(76, '8 Pew'),
(77, 'Namvang'),
(78, 'Violet');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` int(10) NOT NULL,
  `breed1` varchar(20) NOT NULL,
  `breed2` varchar(20) NOT NULL,
  `version` text NOT NULL,
  `Number_of_stalks` text DEFAULT NULL,
  `Fruit_height` text NOT NULL,
  `Stem_height` text NOT NULL,
  `Leaf_angle` text NOT NULL,
  `Fruit_length` text NOT NULL,
  `Fruit_appearance` text NOT NULL,
  `Stem_length` text NOT NULL,
  `Male_flowering_age` text NOT NULL,
  `Flowering_age` text NOT NULL,
  `Flowering_age_gap` text NOT NULL,
  `Number_of_chrysanthemums` text NOT NULL,
  `Male_stalk_length` text DEFAULT NULL,
  `Fruit_length_and_skin` text DEFAULT NULL,
  `The_tail_on_the_end_of_the_fruit` text DEFAULT NULL,
  `Fertility` text DEFAULT NULL,
  `Original_size` text DEFAULT NULL,
  `Root_system` text DEFAULT NULL,
  `images` text NOT NULL,
  `Germination_rate` text NOT NULL,
  `Birth_rate_albino` text NOT NULL,
  `worm_damage_level` text NOT NULL,
  `Strength` text NOT NULL,
  `age_gap_between_male_and_female_flowers` text NOT NULL,
  `get_sick` text NOT NULL,
  `disease_level` text NOT NULL,
  `number_of_collapsed_trees` text NOT NULL,
  `peeled_fruit_diameter` text NOT NULL,
  `peel_number` text NOT NULL,
  `number_of_rows_of_seeds_per_fruit` text NOT NULL,
  `number_of_bullets_per_rows` text NOT NULL,
  `seed_range_shape` text NOT NULL,
  `sum` text NOT NULL,
  `grain_color` text NOT NULL,
  `fruit_peel` text NOT NULL,
  `weight` text NOT NULL,
  `worm` text NOT NULL,
  `seeding_vigor` text NOT NULL,
  `your_child_strength` text NOT NULL,
  `Number_of_roots` text NOT NULL,
  `Tip_length` text NOT NULL,
  `Male_flowering_day` text NOT NULL,
  `Flower_Day` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `breed1`, `breed2`, `version`, `Number_of_stalks`, `Fruit_height`, `Stem_height`, `Leaf_angle`, `Fruit_length`, `Fruit_appearance`, `Stem_length`, `Male_flowering_age`, `Flowering_age`, `Flowering_age_gap`, `Number_of_chrysanthemums`, `Male_stalk_length`, `Fruit_length_and_skin`, `The_tail_on_the_end_of_the_fruit`, `Fertility`, `Original_size`, `Root_system`, `images`, `Germination_rate`, `Birth_rate_albino`, `worm_damage_level`, `Strength`, `age_gap_between_male_and_female_flowers`, `get_sick`, `disease_level`, `number_of_collapsed_trees`, `peeled_fruit_diameter`, `peel_number`, `number_of_rows_of_seeds_per_fruit`, `number_of_bullets_per_rows`, `seed_range_shape`, `sum`, `grain_color`, `fruit_peel`, `weight`, `worm`, `seeding_vigor`, `your_child_strength`, `Number_of_roots`, `Tip_length`, `Male_flowering_day`, `Flower_Day`) VALUES
(222, 'violet', 'pumpoy', '3', '5', '7', ' 9', '11', '13', '15', '17', '1', '2', '4', '6', '8', '10', '12', '14', '16', '18', 'uploads/Screenshot 2023-08-02 214129.png, uploads/Screenshot 2023-08-02 214129.png, uploads/Screenshot 2024-01-30 155757.png', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '38', '31', '32', '33', '34', '35', '36', '37', '39', '40', '41', '42'),
(223, 'pumpoy', 'violet', '12', '', '', ' ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(224, 'violet', 'violet', '12', '', '', ' ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(226, 'violet', 'bigwhith', '12', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(227, 'pumpoy', 'pumpoy', '1', '', '', ' ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(228, 'pumpoy', 'pumpoy', '1', '12.2', '12.3', '0', '0', '0', '0', '0', '12', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', ''),
(229, 'pumpoy', 'pumpoy', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', ''),
(230, 'pumpoy', 'pumpoy', '12.12', '12', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'uploads/photo_1_2024-01-17_20-27-03.jpg', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', ''),
(231, 'pumpoy', 'pumpoy', '12', '', '', ' ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(232, 'bigwhith', 'bigwhith', '1', '', '', ' ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(233, 'bigwhith', 'violet', '12', '', '', ' ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(234, 'bigwhith', 'pumpoy', '1', '', '', ' ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(235, 'bigwhith', 'bigwhith', '1', '', '', ' ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'uploads/1.png, uploads/Screenshot 2024-01-30 155807.png, uploads/Screenshot 2024-01-30 161011.png, uploads/Screenshot 2024-02-02 133952.png, uploads/Screenshot 2024-02-02 134014.png', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '111', '222', '333', '444'),
(236, 'bigwhith', 'bigwhith', '12', '1', '2', '3 ', '4', '5', '6', '7', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'uploads/1.png, uploads/Screenshot 2023-08-02 214129.png, uploads/Screenshot 2024-01-30 155757.png, uploads/Screenshot 2024-01-30 155807.png, uploads/photo_1_2024-01-17_20-26-17.jpg, uploads/photo_1_2024-01-17_20-26-25.jpg, uploads/photo_1_2024-01-17_20-26-33.jpg, uploads/photo_1_2024-01-17_20-26-41.jpg', '8', '11', '9', '12', '10', '13', '11', '14', '12', '15', '13', '16', '19', '22', '19', '14', '17', '15', '18', '16', '17', '20', '18', '21'),
(237, 'pumpoy', 'Bigwhith', '007', '', '', ' ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'uploads/photo_1_2024-01-17_20-26-17.jpg, uploads/photo_1_2024-01-17_20-26-49.jpg, uploads/photo_1_2024-01-17_20-26-56.jpg, uploads/photo_1_2024-01-17_20-27-03.jpg, uploads/photo_1_2024-01-17_20-27-11.jpg', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `images` text NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `type` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `email`, `phone_number`, `images`, `status`, `type`) VALUES
(30, 'Phanun', 'Sok', 'nun', '$2y$10$w47o0bpHRdJ3WLt5YQGJPeF6AJ9Qg2nIqsH3gWJTSHu98vqbTUwzW', 'broakzinll29@gmail.com', '0965101579', 'uploads/20230424_205010.jpg', 'active', 'admin'),
(36, 'Devith', 'Ku', 'vit', '$2y$10$L5qTgSIEWMIj6pPg39HqouJWJmUK83Ud8q.TIUuuQ8GDHtz2TXawi', 'broakzinll29@gmail.com', '1234567890', 'uploads/photo_1_2024-01-16_22-27-55.jpg', 'active', 'user'),
(45, 'admin', 'admin', 'teacher', '$2y$10$uR7oZ9pwRIso4IG9NJ10f.GRRUbKqgtt8TA6lpvavPn/IPqJqACRa', '', '', '', 'active', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `breed_name_tb`
--
ALTER TABLE `breed_name_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `breed_name_tb`
--
ALTER TABLE `breed_name_tb`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
