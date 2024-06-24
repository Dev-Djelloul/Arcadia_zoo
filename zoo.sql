-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : dim. 23 juin 2024 à 15:25
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
-- Structure de la table `Alimentation`
--

CREATE TABLE `Alimentation` (
  `IDAlimentation` int(11) NOT NULL,
  `IDAnimal` int(11) DEFAULT NULL,
  `DateHeureAlimentation` datetime DEFAULT NULL,
  `NourritureDonnee` varchar(100) DEFAULT NULL,
  `Quantite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Animal`
--

CREATE TABLE `Animal` (
  `IDAnimal` int(11) NOT NULL,
  `PrenomAnimal` varchar(100) DEFAULT NULL,
  `RaceAnimal` varchar(100) DEFAULT NULL,
  `IDHabitat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Avis`
--

CREATE TABLE `Avis` (
  `IDAvis` int(11) NOT NULL,
  `PseudoVisiteur` varchar(100) DEFAULT NULL,
  `ContenuAvis` text DEFAULT NULL,
  `StatutValidation` varchar(50) DEFAULT NULL,
  `DateSoumission` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `CompteRenduVeterinaire`
--

CREATE TABLE `CompteRenduVeterinaire` (
  `IDCompteRendu` int(11) NOT NULL,
  `IDAnimal` int(11) DEFAULT NULL,
  `EtatAnimal` varchar(100) DEFAULT NULL,
  `NourritureProposee` varchar(100) DEFAULT NULL,
  `Grammage` int(11) DEFAULT NULL,
  `DateCompteRendu` date DEFAULT NULL,
  `DetailFacultatif` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Consultation`
--

CREATE TABLE `Consultation` (
  `IDConsultation` int(11) NOT NULL,
  `IDAnimal` int(11) DEFAULT NULL,
  `DateHeureConsultation` datetime DEFAULT NULL,
  `IDUtilisateur` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Habitat`
--

CREATE TABLE `Habitat` (
  `IDHabitat` int(11) NOT NULL,
  `NomHabitat` varchar(100) DEFAULT NULL,
  `DescriptionHabitat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Service`
--

CREATE TABLE `Service` (
  `IDService` int(11) NOT NULL,
  `NomService` varchar(100) DEFAULT NULL,
  `DescriptionService` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Index pour les tables déchargées
--

--
-- Index pour la table `Alimentation`
--
ALTER TABLE `Alimentation`
  ADD PRIMARY KEY (`IDAlimentation`),
  ADD KEY `IDAnimal` (`IDAnimal`);

--
-- Index pour la table `Animal`
--
ALTER TABLE `Animal`
  ADD PRIMARY KEY (`IDAnimal`),
  ADD KEY `IDHabitat` (`IDHabitat`);

--
-- Index pour la table `Avis`
--
ALTER TABLE `Avis`
  ADD PRIMARY KEY (`IDAvis`);

--
-- Index pour la table `CompteRenduVeterinaire`
--
ALTER TABLE `CompteRenduVeterinaire`
  ADD PRIMARY KEY (`IDCompteRendu`),
  ADD KEY `IDAnimal` (`IDAnimal`);

--
-- Index pour la table `Consultation`
--
ALTER TABLE `Consultation`
  ADD PRIMARY KEY (`IDConsultation`),
  ADD KEY `IDAnimal` (`IDAnimal`),
  ADD KEY `IDUtilisateur` (`IDUtilisateur`);

--
-- Index pour la table `Habitat`
--
ALTER TABLE `Habitat`
  ADD PRIMARY KEY (`IDHabitat`);

--
-- Index pour la table `Service`
--
ALTER TABLE `Service`
  ADD PRIMARY KEY (`IDService`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`Username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Alimentation`
--
ALTER TABLE `Alimentation`
  MODIFY `IDAlimentation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Animal`
--
ALTER TABLE `Animal`
  MODIFY `IDAnimal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Avis`
--
ALTER TABLE `Avis`
  MODIFY `IDAvis` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `CompteRenduVeterinaire`
--
ALTER TABLE `CompteRenduVeterinaire`
  MODIFY `IDCompteRendu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Consultation`
--
ALTER TABLE `Consultation`
  MODIFY `IDConsultation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Habitat`
--
ALTER TABLE `Habitat`
  MODIFY `IDHabitat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Service`
--
ALTER TABLE `Service`
  MODIFY `IDService` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Alimentation`
--
ALTER TABLE `Alimentation`
  ADD CONSTRAINT `alimentation_ibfk_1` FOREIGN KEY (`IDAnimal`) REFERENCES `Animal` (`IDAnimal`);

--
-- Contraintes pour la table `Animal`
--
ALTER TABLE `Animal`
  ADD CONSTRAINT `animal_ibfk_1` FOREIGN KEY (`IDHabitat`) REFERENCES `Habitat` (`IDHabitat`);

--
-- Contraintes pour la table `CompteRenduVeterinaire`
--
ALTER TABLE `CompteRenduVeterinaire`
  ADD CONSTRAINT `compterenduveterinaire_ibfk_1` FOREIGN KEY (`IDAnimal`) REFERENCES `Animal` (`IDAnimal`);

--
-- Contraintes pour la table `Consultation`
--
ALTER TABLE `Consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`IDAnimal`) REFERENCES `Animal` (`IDAnimal`),
  ADD CONSTRAINT `consultation_ibfk_2` FOREIGN KEY (`IDUtilisateur`) REFERENCES `Utilisateur` (`Username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
