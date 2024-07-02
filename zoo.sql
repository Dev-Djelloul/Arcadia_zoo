-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : dim. 30 juin 2024 à 04:39
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
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `avis` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `approuve` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `pseudo`, `avis`, `date`, `approuve`) VALUES
(1, 'nicolas', 'super ludique ! ', '2024-06-30 01:05:41', 1),
(2, 'djelloul', 'un parc plaisant et des animaux joyeux et jolis 😇🦅🦋🦕', '2024-06-30 01:19:08', 1),
(3, 'elodie ', 'je me suis bien amusé en famille, les enfants ont adoré ! je reviendrais très prochainement :)', '2024-06-30 01:20:27', 1),
(5, 'test', 'test\r\n', '2024-06-30 02:32:05', 0);

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `Username` varchar(255) NOT NULL,
  `MotDePasse` varchar(255) DEFAULT NULL,
  `TypeUtilisateur` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`Username`, `MotDePasse`, `TypeUtilisateur`) VALUES
('admin@arcadiazoo.com', 'arcadia', 'administrateur'),
('employe@arcadiazoo.com', 'arcadia', 'employe'),
('veterinaire@arcadiazoo.com', 'arcadia', 'veterinaire'),
('visiteur@arcadiazoo.com', 'arcadia', 'visiteur');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`Username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
