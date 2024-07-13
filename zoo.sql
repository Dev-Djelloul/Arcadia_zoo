-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : sam. 13 juil. 2024 à 21:03
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
  `Prenom` varchar(255) NOT NULL,
  `Race` varchar(255) DEFAULT NULL,
  `ImageAnimal` varchar(255) DEFAULT NULL,
  `NomHabitat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Animal`
--

INSERT INTO `Animal` (`id`, `Prenom`, `Race`, `ImageAnimal`, `NomHabitat`) VALUES
(2, 'Cuzco', 'Perroquet ', '/uploads/colorful-parrots.png', 'La Grande Volière '),
(4, 'Léo ', 'Félins', '/uploads/couple-lion.jpeg', 'La Savane'),
(5, 'Alli le croco ', 'Reptiles', '/uploads/crocodile.jpeg', 'Le Marais'),
(6, 'Mowgli', 'Famille des Lemuridae', '/uploads/lemurs-playing.jpg', 'La Jungle');

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
-- Structure de la table `Habitat`
--

CREATE TABLE `Habitat` (
  `id` int(11) NOT NULL,
  `NomHabitat` varchar(255) NOT NULL,
  `DescriptionHabitat` text NOT NULL,
  `ImageHabitat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Habitat`
--

INSERT INTO `Habitat` (`id`, `NomHabitat`, `DescriptionHabitat`, `ImageHabitat`) VALUES
(2, 'Le Marais', 'Les marais sont des zones humides riches en biodiversité, abritant une variété d\'oiseaux, de reptiles et de mammifères adaptés à ce milieu aquatique. Les visiteurs peuvent observer des crocodiles, des alligators, des flamants roses, des hérons et d\'autres espèces qui dépendent des marais pour leur nourriture et leur habitat. Des passerelles et des observatoires offrent aux visiteurs des vues privilégiées sur ces habitats aquatiques.', '/uploads/crocodile.jpeg'),
(3, 'La Jungle', 'La jungle est une forêt dense et luxuriante où la lumière du soleil peine à pénétrer à travers le feuillage dense. Cette partie du parc est peuplée de singes, de perroquets aux couleurs vives, de serpents, de jaguars et d\'autres créatures étonnantes. Les chemins sinueux à travers la végétation offrent aux visiteurs une immersion totale dans cet habitat mystérieux et vibrant de vie.', '/uploads/monkey.jpeg'),
(9, 'La Savane', 'La savane est un vaste paysage ouvert caractérisé par de l\'herbe courte et des arbres dispersés, typique des régions tropicales et subtropicales. Dans cette partie du parc, vous pouvez observer des animaux emblématiques comme les lions, les éléphants, les girafes et les antilopes. Les vastes plaines permettent aux visiteurs de voir ces majestueux animaux se déplacer librement à travers leur environnement naturel.	', '/uploads/couple-lion.jpeg'),
(10, 'La Grande Volière ', 'La grande volière est un espace spectaculaire où les visiteurs peuvent découvrir une variété d\'oiseaux exotiques vivant dans un environnement similaire à leur habitat naturel. Ce sanctuaire aérien offre aux oiseaux la liberté de voler et de se déplacer dans un espace vaste et diversifié, rempli de végétation luxuriante et de points d\'eau. Les visiteurs peuvent admirer des espèces colorées telles que les perroquets, les aras, les toucans et les loriquets qui volent au-dessus de leurs têtes ou se perchent dans les arbres et les buissons. Des chemins panoramiques et des plateformes d\'observation permettent aux visiteurs de se rapprocher des oiseaux et d\'observer leurs comportements naturels, comme la recherche de nourriture, les interactions sociales et les moments de repos. La grande volière est un lieu d\'émerveillement pour les amateurs d\'oiseaux de tous âges, offrant une expérience immersive et éducative sur la diversité des espèces aviaires et leur adaptation aux différents habitats à travers le monde.', '/uploads/voliere-parc-zoo.jpeg');

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
(7, 'Notre coin resto monkey ', 'Manger dans notre nouveau restaurant pour tous en bonne compagnie 😝', '/uploads/fast-food-monkey.jpeg'),
(24, 'Le Train Magique', 'Découvrez le zoo à bord de notre train magique !', '/uploads/train-zoo.jpeg'),
(25, 'Notre boutique de souvenirs ', 'Laissez vous charmer par notre boutique qui vous émerveillera par ses objets en tous genre pour les petits et les grands !  ', '/uploads/boutique-souvenirs-zoo.jpeg'),
(32, 'La visite guidée', 'Explorez les habitats avec nos guides experts le temps d\'une après-midi ! ', '/uploads/guide-zoo.jpeg');

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
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Habitat`
--
ALTER TABLE `Habitat`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `Habitat`
--
ALTER TABLE `Habitat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `Services`
--
ALTER TABLE `Services`
  MODIFY `IdService` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
