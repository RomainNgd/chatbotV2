-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 20, 2023 at 12:27 PM
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
CREATE DATABASE IF NOT EXISTS `chatbot` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `chatbot`;

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

-- --------------------------------------------------------

--
-- Table structure for table `c_commande`
--

CREATE TABLE `c_commande` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `create_at` datetime NOT NULL,
  `product` varchar(255) NOT NULL,
  `status` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(6, 'prix', 3, 5),
(14, 'connexion', 20, 5),
(15, 'inscription', 21, 10),
(17, 'deconnexion', 23, 5),
(18, 'ajouter au panier ', 24, 10),
(19, 'voir le panier', 25, 5),
(20, 'voir mon panier', 25, 5),
(21, 'visualiser le panier', 25, 5),
(22, 'supprimer du panier', 26, 5);

-- --------------------------------------------------------

--
-- Table structure for table `c_palette`
--

CREATE TABLE `c_palette` (
  `id` int UNSIGNED NOT NULL,
  `libelle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `main_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `light_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dark_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gray_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `white_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `c_palette`
--

INSERT INTO `c_palette` (`id`, `libelle`, `main_color`, `light_color`, `dark_color`, `gray_color`, `white_color`, `active`) VALUES
(1, 'Palette Violet', '#857dff', '#f0f2f5', '#7B39EB', '#E4E6EB', '#FFFFFF', 1),
(2, 'Palette Orange', '#ff570a', '#FF8A54', '#D0612E', '#E4E6EB', '#FFFFFF', 0),
(3, 'Palette Bleue', '#10A5B2', '#A8F1F7', '#0C848F', '#E4E6EB', '#FFFFFF', 0);

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

-- --------------------------------------------------------

--
-- Table structure for table `c_response`
--

CREATE TABLE `c_response` (
  `id` int NOT NULL,
  `response` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `action` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `c_response`
--

INSERT INTO `c_response` (`id`, `response`, `slug`, `action`) VALUES
(1, 'Bonjour, je m\'appelle Billy, comment puis-je vous aidez ?', 'hello', NULL),
(2, 'Etes vous sur de vouloir commander votre panier en cours ? Taper oui ou non', 'commande', NULL),
(3, 'De quel produit voulez-vous savoir le prix ?', 'price', NULL),
(4, 'Quel produit recherchez-vous ? ', 'product', NULL),
(5, 'Quelle catégorie recherchez vous ? ', 'category', NULL),
(20, 'Si vous souhaitez vous connecter taper \'oui\', si vous souhaitez réinitialisé le chat taper \'non\'', 'connection', NULL),
(21, 'Si vous souhaitez vous inscrire taper \'oui\', si vous souhaitez réinitialisé le chat taper \'non\'', 'inscription', NULL),
(23, 'Voulez vous vraiment vous déconnecter ? Tapez \'oui\' ou \'non\'', 'deconnection', NULL),
(24, 'Quelle produit voulez-vous ajouter au panier ? ', 'add', 1),
(25, 'Vous souhaites voir votre panier ?', 'see', 1),
(26, 'Taper la référence du produit que vous voulez supprimer de votre panier', 'delete', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `c_user`
--

CREATE TABLE `c_user` (
  `id` int NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_connection` datetime DEFAULT NULL,
  `role` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `c_user`
--

INSERT INTO `c_user` (`id`, `login`, `password`, `last_connection`, `role`) VALUES
(1, 'admin', '$2y$10$SuUMZIRudqpaqv2PJoP8V.nNykpuWXytyKmFEIA7XHIlBAlQTtnDq', NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `c_categorie`
--
ALTER TABLE `c_categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c_commande`
--
ALTER TABLE `c_commande`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c_keyword`
--
ALTER TABLE `c_keyword`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c_keyword_ibfk_1` (`response_id`);

--
-- Indexes for table `c_palette`
--
ALTER TABLE `c_palette`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `c_commande`
--
ALTER TABLE `c_commande`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `c_keyword`
--
ALTER TABLE `c_keyword`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `c_palette`
--
ALTER TABLE `c_palette`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `c_produit`
--
ALTER TABLE `c_produit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `c_response`
--
ALTER TABLE `c_response`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `c_user`
--
ALTER TABLE `c_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `c_keyword`
--
ALTER TABLE `c_keyword`
  ADD CONSTRAINT `c_keyword_ibfk_1` FOREIGN KEY (`response_id`) REFERENCES `c_response` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `c_produit`
--
ALTER TABLE `c_produit`
  ADD CONSTRAINT `liaison` FOREIGN KEY (`categorie_id`) REFERENCES `c_categorie` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
