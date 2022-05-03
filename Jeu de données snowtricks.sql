-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 03 mai 2022 à 10:45
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `snowtricks`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `name`) VALUES
(1, 'Grabs'),
(2, 'Rotations'),
(3, 'Flips'),
(4, 'Rotations désaxées'),
(5, 'Slides'),
(6, 'One foot tricks'),
(7, 'Old school'),
(8, 'Sauts'),
(9, 'Barre de slide');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `body` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CA76ED395` (`user_id`),
  KEY `IDX_9474526CB281BE2E` (`trick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `trick_id`, `body`) VALUES
(26, 2, 37, 'fsfsdfsdfsd'),
(27, 2, 37, 'mon message'),
(28, 2, 37, 'mon message'),
(29, 2, 37, 'fff');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220121085818', '2022-01-21 08:58:37', 134),
('DoctrineMigrations\\Version20220121135048', '2022-01-21 13:51:20', 24),
('DoctrineMigrations\\Version20220121143440', '2022-01-21 14:34:48', 118),
('DoctrineMigrations\\Version20220222141616', '2022-02-22 14:16:27', 233),
('DoctrineMigrations\\Version20220222142213', '2022-02-22 14:22:16', 82),
('DoctrineMigrations\\Version20220222142530', '2022-02-22 14:25:33', 69),
('DoctrineMigrations\\Version20220322142129', '2022-03-22 14:21:41', 71);

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_id` int(11) DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6A2CA10CB281BE2E` (`trick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id`, `trick_id`, `type`, `file_name`) VALUES
(55, 34, 'Image', 'Mute-62309b3768478.png'),
(56, 35, 'Image', 'sad-johnny-brady-side-fenelon-62309b78db3b0.avif'),
(57, 36, 'Image', 'indy-62309bda05349.jpg'),
(58, 37, 'Image', 'Stalefish-62309c185860d.jpg'),
(59, 38, 'Image', 'tail-grab-1-62309c51cfa8d.jpg'),
(60, 39, 'Image', 'Trick-Nose-62309cfc40feb.jpg'),
(61, 40, 'Image', 'Trick-Japan-Grab-62309d613cbda.jpg'),
(62, 41, 'Image', 'hqdefault-62309db6251bf.jpg'),
(63, 42, 'Image', 'truck-driver-62309dddcc703.jpg'),
(65, 43, 'Image', '180-6230a2dd33f88.jpg'),
(67, 44, 'Image', '180-6230a2f48417b.jpg'),
(69, 45, 'Image', '180-6230a30931da5.jpg'),
(71, 46, 'Image', '180-6230a31984134.jpg'),
(73, 47, 'Image', '180-6230a32a232b4.jpg'),
(78, 48, 'Image', '180-6230a3a90a073.jpg'),
(79, 43, 'Image', 'default.jpg'),
(80, 50, 'Image', '179-6230a45138995.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

DROP TABLE IF EXISTS `reset_password_request`;
CREATE TABLE IF NOT EXISTS `reset_password_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reset_password_request`
--

INSERT INTO `reset_password_request` (`id`, `user_id`, `selector`, `hashed_token`, `requested_at`, `expires_at`) VALUES
(1, 3, 'weQzORMBg1dnJHPPBoZb', 'H7eVf1Y3kFHZP3n49Yhf8LtMDrXxRBAojaoBcNAOfK0=', '2022-04-05 07:34:25', '2022-04-05 08:34:25');

-- --------------------------------------------------------

--
-- Structure de la table `trick`
--

DROP TABLE IF EXISTS `trick`;
CREATE TABLE IF NOT EXISTS `trick` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `definition` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D8F0A91E5E237E06` (`name`),
  KEY `IDX_D8F0A91EBCF5E72D` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick`
--

INSERT INTO `trick` (`id`, `categorie_id`, `name`, `definition`) VALUES
(34, 1, 'Mute', 'Saisie de la carre frontside de la planche entre les deux pieds avec la main avant'),
(35, 1, 'Sad', 'Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant'),
(36, 1, 'Indy', 'Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière'),
(37, 1, 'Stalefish', 'Saisie de la carre backside de la planche entre les deux pieds avec la main arrière'),
(38, 1, 'Tail grab', 'Saisie de la partie arrière de la planche, avec la main arrière'),
(39, 1, 'Nose grab', 'Saisie de la partie avant de la planche, avec la main avant'),
(40, 1, 'Japan', 'Saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside'),
(41, 1, 'Seat belt', 'Saisie du carre frontside à l\'arrière avec la main avant'),
(42, 1, 'Truck driver', 'Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture)'),
(43, 2, '180°', 'un 180 désigne un demi-tour, soit 180 degrés d\'angle'),
(44, 2, '360°', '360, trois six pour un tour complet'),
(45, 2, '540°', '540, cinq quatre pour un tour et demi'),
(46, 2, '720°', '720, sept deux pour deux tours complets'),
(47, 2, '900 °', '900 pour deux tours et demi'),
(48, 2, '1080 °', '1080 ou big foot pour trois tours'),
(50, 3, 'Front flips', 'une rotation verticale en avant.');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`, `avatar`) VALUES
(2, 'geoffray.buhler@gmail.com', '[]', '$2y$13$0EdeD0jUgxihQ.Ze0jT5beIAIvT17p/QJy./3o.AUrt7nMyFqRxIy', 'jeanjean', 'Griff-PNG-artwork-6218eaa0aa768.png'),
(3, 'seigneur39@gmail.com', '[]', '$2y$13$LzOfoZNrKStXjG1k8KwcnOENhFS9zpnFypRne4hc3iXxJtbr/CaxW', 'Griffont', 'red-6221c6e9bdf22.png');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_9474526CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `FK_6A2CA10CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `trick`
--
ALTER TABLE `trick`
  ADD CONSTRAINT `FK_D8F0A91EBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
