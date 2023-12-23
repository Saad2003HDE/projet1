-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 23 déc. 2023 à 04:36
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecom1_project`
crate database if not exist ecom1_projet;
use ecom1_projet;

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `street_name` varchar(255) NOT NULL,
  `street_nb` int NOT NULL,
  `city` varchar(40) NOT NULL,
  `province` varchar(40) NOT NULL,
  `zip_code` varchar(6) NOT NULL,
  `country` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `address`
--

INSERT INTO `address` (`id`, `street_name`, `street_nb`, `city`, `province`, `zip_code`, `country`) VALUES
(35, 'salabery', 0, 'Montréal', 'Québec', 'H4N8B', 'Canada'),
(36, '', 0, '', '', '', ''),
(37, 'salabery', 0, 'Montréal', 'Québec', 'H4N8B', 'Canada'),
(38, 'salabery', 0, 'Montréal', 'Québec', 'H4N8B', 'Canada'),
(39, 'salabery', 0, 'Montréal', 'Québec', 'H4N8B', 'Canada');

-- --------------------------------------------------------

--
-- Structure de la table `order_has_product`
--

DROP TABLE IF EXISTS `order_has_product`;
CREATE TABLE IF NOT EXISTS `order_has_product` (
  `quantity` int NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `order_id` bigint NOT NULL,
  `product_id` bigint NOT NULL,
  PRIMARY KEY (`product_id`,`order_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `order_has_product`
--

INSERT INTO `order_has_product` (`quantity`, `price`, `order_id`, `product_id`) VALUES
(21, '12.00', 107, 15),
(4, '100.00', 111, 35),
(1, '100.00', 111, 36),
(1, '100.00', 111, 34),
(1, '200.00', 111, 31);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `quantity`, `price`, `img_url`, `description`) VALUES
(36, 'tenue de portugal', 150, '100.00', '65865a15e4557portugal.jpeg', 'tenue de portugal pour homme'),
(35, 'tenue de japon', 150, '100.00', '658659f742777japon.jpeg', 'tenue de japon pour homme '),
(34, 'Tenue de france', 150, '100.00', '658659c6d593ffrance.jpeg', 'Tenue de france homme'),
(33, 'Tenue de Maroc', 150, '100.00', '658659a78940cmaroc.jpeg', 'Tenue de Maroc pour homme'),
(31, 'Tenue de Real Madrid', 150, '200.00', '6586533d23637658627caa47766586114df1aefmadrid.jpeg', 'Tenue de Real Madrid pour homme'),
(32, 'Tenue de Brésil', 150, '100.00', '6586597477baa6586100f108c1bresil.jpeg', 'Tenue de Brésil pour homme');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `name`, `description`) VALUES
(3, 'SuperAdmin', 'role super administrateur'),
(2, 'Administar', 'role administrateur'),
(1, 'client', 'role client');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `billing_address_id` bigint NOT NULL,
  `shipping_address_id` bigint NOT NULL,
  `token` varchar(255) NOT NULL,
  `role_id` bigint NOT NULL,
  `user_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `pwd`, `fname`, `lname`, `billing_address_id`, `shipping_address_id`, `token`, `role_id`, `user_name`) VALUES
(98, 'superadmin@admin.ca', '$2y$10$pvYufmdKSn/3teuX0DWSzud7Z5kZpyKoGF1810Stjaw1kgIefh/06', '', '', 0, 0, '', 3, 'superadmin'),
(111, 'saadnassib120@gmail.com', '$2y$10$/skphJQrsXHDt.z4vUtCDeUjDdtmhFiJXl8202oaOg0mPomDVFDEm', '', '', 0, 0, '', 1, 'saad'),
(110, 'saadnassib120@gmail.com', '$2y$10$YXjcC7zm0XGNA/Ssl6343ecAK0zPFFR9L8EcX/zqvG68b1ywJF2gG', '', '', 0, 0, '', 1, 'badr'),
(107, 'saadnassib120@gmail.com', '$2y$10$ah/SbPkOg9a6ga746U2LKeI/O5MzS7CC4Kru5xA5srxvUQb2sEZpK', 'Mohamed Saad', 'Nassib', 39, 36, '', 1, 'khalid'),
(108, 'saad@GMAIL.COM', '$2y$10$9Tmo6FERzXVzfXmrdlkofuyGEQdieNsqh5Lr6EihU0P7I2a5dF1cu', '', '', 0, 0, '', 1, 'saad1'),
(109, 'saadnassib120@gmail.com', '$2y$10$SUtqVotVlVXdnbnQRghpTu3invEyh.y3cmNihoIbo0XU/aAcVcySi', '', '', 0, 0, '', 1, 'red');

-- --------------------------------------------------------

--
-- Structure de la table `user_order`
--

DROP TABLE IF EXISTS `user_order`;
CREATE TABLE IF NOT EXISTS `user_order` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `ref` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `user_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
