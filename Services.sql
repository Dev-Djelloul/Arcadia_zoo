-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : sam. 26 oct. 2024 à 01:34
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `zoo`
--

-- --------------------------------------------------------

--
-- Structure de la table `Services`
--

CREATE TABLE `Services` (
  `IdService` int(11) NOT NULL,
  `NomService` varchar(100) NOT NULL,
  `DescriptionService` text DEFAULT NULL,
  `ImageService` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Services`
--

INSERT INTO `Services` (`IdService`, `NomService`, `DescriptionService`, `ImageService`) VALUES
(7, 'Notre coin restauration ', 'Manger dans notre nouveau restaurant pour tous en bonne compagnie 😝', '/uploads/fast-food-monkey.jpeg'),
(24, 'Le Train Magique', 'Découvrez le zoo à bord de notre train magique !', '/uploads/train-zoo.jpeg'),
(25, 'Notre boutique de souvenirs ', 'Laissez vous charmer par notre boutique qui vous émerveillera par ses objets en tous genre pour les petits et les grands !  ', '/uploads/boutique-souvenirs-zoo.jpeg'),
(32, 'La visite guidée', 'Explorez les habitats avec nos guides experts le temps d\'une après-midi ! ', '/uploads/guide-zoo.jpeg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Services`
--
ALTER TABLE `Services`
  ADD PRIMARY KEY (`IdService`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Services`
--
ALTER TABLE `Services`
  MODIFY `IdService` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
