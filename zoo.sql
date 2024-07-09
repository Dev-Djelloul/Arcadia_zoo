-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : sam. 06 juil. 2024 à 02:11
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
-- Structure de la table `Animal`
--

CREATE TABLE `Animal` (
  `id` int(11) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `race` varchar(255) NOT NULL,
  `images` text DEFAULT NULL,
  `habitat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `avis` text NOT NULL,
  `approuve` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `pseudo`, `avis`, `approuve`) VALUES
(1, 'nicolas', 'super ludique ! ', 1),
(2, 'djelloul', 'un parc plaisant et des animaux joyeux et jolis 😇🦅🦋🦕', 1),
(3, 'elodie ', 'je me suis bien amusé en famille, les enfants ont adoré ! je reviendrais très prochainement :)', 1),
(7, 'wilfried ', 'J\'ai passé ma journée au vivarium 🦎🐍🐊', 1),
(8, 'batman', 'Les deux girafes se sont battues 🦒🤭', 1),
(10, 'Romano ', 'J\'ai aimé les dauphins surtout 🐬🐬🐬', 1),
(15, 'nicolette', 'Ma petite fille a adoré et moi aussi ! merci ! ', 1);

-- --------------------------------------------------------

--
-- Structure de la table `CompteRenduVeterinaire`
--

CREATE TABLE `CompteRenduVeterinaire` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `etat` varchar(255) NOT NULL,
  `commentaire` text DEFAULT NULL,
  `animal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Consultation`
--

CREATE TABLE `Consultation` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `alimentation` varchar(255) NOT NULL,
  `grammage` double NOT NULL,
  `animal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Habitat`
--

CREATE TABLE `Habitat` (
  `id` int(11) NOT NULL,
  `NomHabitat` varchar(255) NOT NULL,
  `DescriptionHabitat` text NOT NULL,
  `ImageHabitat` varchar(255) DEFAULT NULL,
  `ListeAnimaux` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Horaires`
--

CREATE TABLE `Horaires` (
  `jour` varchar(50) NOT NULL,
  `heure_ouverture` time DEFAULT NULL,
  `heure_fermeture` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(7, 'Fast Food Monkey', 'Manger dans notre nouveau restaurant pour tous en bonne compagnie 😝', '/uploads/fast-food-monkey.jpeg'),
(24, 'Visite du zoo en train', 'Découvrez le zoo à bord de notre train magique ! ', '/uploads/train-zoo.jpeg'),
(25, 'Boutique de souvenirs ', 'Laissez vous charmer par notre boutique qui vous émerveillera par ses objets en tous genre pour les petits et les grands !  ', '/uploads/boutique-souvenirs-zoo.jpeg');

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
('admin@arcadiazoo.com', '$2y$10$XPSaMkmMu4yql9TG6VdCwe7dB6wqh5gowvBvooUihwKkAoYk9SzGS', 'administrateur'),
('employe@arcadiazoo.com', '$2y$10$cXed4xhKNIn6MA.mG4Sre.vROFtQBZpZKEK0iBhU2YWQft1WCrlHa', 'employe'),
('veterinaire@arcadiazoo.com', '$2y$10$LFpUtsW49UZnDA9NGD22/uPVnA/hfg55PBxwn8ETHr.sAX6EvVBBW', 'veterinaire');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Animal`
--
ALTER TABLE `Animal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `habitat_id` (`habitat_id`);

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `CompteRenduVeterinaire`
--
ALTER TABLE `CompteRenduVeterinaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Index pour la table `Consultation`
--
ALTER TABLE `Consultation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Index pour la table `Habitat`
--
ALTER TABLE `Habitat`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Horaires`
--
ALTER TABLE `Horaires`
  ADD PRIMARY KEY (`jour`);

--
-- Index pour la table `Services`
--
ALTER TABLE `Services`
  ADD PRIMARY KEY (`IdService`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`Username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Animal`
--
ALTER TABLE `Animal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `CompteRenduVeterinaire`
--
ALTER TABLE `CompteRenduVeterinaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Consultation`
--
ALTER TABLE `Consultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Habitat`
--
ALTER TABLE `Habitat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Services`
--
ALTER TABLE `Services`
  MODIFY `IdService` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Animal`
--
ALTER TABLE `Animal`
  ADD CONSTRAINT `animal_ibfk_1` FOREIGN KEY (`habitat_id`) REFERENCES `Habitat` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `CompteRenduVeterinaire`
--
ALTER TABLE `CompteRenduVeterinaire`
  ADD CONSTRAINT `compterenduveterinaire_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `Animal` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Consultation`
--
ALTER TABLE `Consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `Animal` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
