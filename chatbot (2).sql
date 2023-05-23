-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 23, 2023 at 06:51 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatbot`
--

-- --------------------------------------------------------

--
-- Table structure for table `c_categorie`
--

CREATE TABLE `c_categorie` (
  `id` int NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `slug` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `c_categorie`
--

INSERT INTO `c_categorie` (`id`, `categorie`, `url`, `slug`) VALUES
(1, 'jouet', 'https://site.fr/categorie-jouet', 0),
(2, 'bois', 'https://site.fr/categorie-bois', 0);

-- --------------------------------------------------------

--
-- Table structure for table `c_keyword`
--

CREATE TABLE `c_keyword` (
  `id` int NOT NULL,
  `keyword` varchar(64) NOT NULL,
  `response_id` int NOT NULL,
  `priority` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `c_keyword`
--

INSERT INTO `c_keyword` (`id`, `keyword`, `response_id`, `priority`) VALUES
(1, 'bonjour', 1, 1),
(2, 'salut', 1, 1),
(3, 'commande', 2, 2),
(4, 'catégorie', 5, 2),
(5, 'produit', 4, 4),
(6, 'prix', 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `c_produit`
--

CREATE TABLE `c_produit` (
  `id` int NOT NULL,
  `produit` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ref` int NOT NULL,
  `categorie_id` int DEFAULT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `c_produit`
--

INSERT INTO `c_produit` (`id`, `produit`, `prix`, `url`, `ref`, `categorie_id`, `slug`) VALUES
(1, 'Marionnette Pinocchio', 49.99, 'https://site.fr/marionette-pinochio', 59847, 1, ''),
(2, 'Balustrade en bois de pin', 9.99, 'https://site.fr/ballustrade-en-bois', 748741, 2, ''),
(3, 'palissade en chêne', 15.3, 'https://site.fr/palissade-chêne', 41095, 2, ''),
(4, 'Playmobil policier', 7.59, 'https://site.fr/playmobil-policier', 14417, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `c_response`
--

CREATE TABLE `c_response` (
  `id` int NOT NULL,
  `response` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `c_response`
--

INSERT INTO `c_response` (`id`, `response`) VALUES
(1, 'Bonjour, je m\'appelle Billy, comment puis-je vous aidez ?'),
(2, 'Voici le lien pour voir vos commande en cours :'),
(3, 'De quel produit voulez-vous savoir le prix ?'),
(4, 'Quel produit recherchez-vous ? '),
(5, 'Quelle catégorie recherchez vous ? '),
(6, 'Désolé il n\'existe aucun produit correspondant à votre recherche.');

-- --------------------------------------------------------

--
-- Table structure for table `c_user`
--

CREATE TABLE `c_user` (
  `id` int NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_connection` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `c_user`
--

INSERT INTO `c_user` (`id`, `login`, `password`, `last_connection`) VALUES
(1, 'root2', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `c_categorie`
--
ALTER TABLE `c_categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c_keyword`
--
ALTER TABLE `c_keyword`
  ADD PRIMARY KEY (`id`),
  ADD KEY `response_id` (`response_id`);

--
-- Indexes for table `c_produit`
--
ALTER TABLE `c_produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `liaison` (`categorie_id`);

--
-- Indexes for table `c_response`
--
ALTER TABLE `c_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c_user`
--
ALTER TABLE `c_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `c_categorie`
--
ALTER TABLE `c_categorie`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `c_keyword`
--
ALTER TABLE `c_keyword`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `c_produit`
--
ALTER TABLE `c_produit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `c_response`
--
ALTER TABLE `c_response`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `c_user`
--
ALTER TABLE `c_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `c_keyword`
--
ALTER TABLE `c_keyword`
  ADD CONSTRAINT `c_keyword_ibfk_1` FOREIGN KEY (`response_id`) REFERENCES `c_response` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `c_produit`
--
ALTER TABLE `c_produit`
  ADD CONSTRAINT `liaison` FOREIGN KEY (`categorie_id`) REFERENCES `c_categorie` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
