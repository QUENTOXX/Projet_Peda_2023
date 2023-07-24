-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 24 juil. 2023 à 18:24
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
-- Base de données : `newamazony`
--

-- --------------------------------------------------------

--
-- Structure de la table `achats`
--

DROP TABLE IF EXISTS `achats`;
CREATE TABLE IF NOT EXISTS `achats` (
  `ID_commande` int NOT NULL,
  `ID_produit` int NOT NULL,
  `quantite` int NOT NULL DEFAULT '1',
  `ID_vendeur` int DEFAULT NULL,
  `Prix` int DEFAULT NULL,
  PRIMARY KEY (`ID_commande`,`ID_produit`),
  KEY `fk_ID_produit` (`ID_produit`),
  KEY `fk_ID_vendeur` (`ID_vendeur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `achats`
--

INSERT INTO `achats` (`ID_commande`, `ID_produit`, `quantite`, `ID_vendeur`, `Prix`) VALUES
(1, 1, 8, NULL, NULL),
(1, 2, 5, NULL, NULL),
(1, 3, 2, NULL, NULL),
(1, 8, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `Prénom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tel` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Adresse` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Date_contrat` date DEFAULT NULL,
  `mdp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ID` int NOT NULL AUTO_INCREMENT,
  `numero_CB` int DEFAULT NULL,
  `date_CB` date DEFAULT NULL,
  `crypto_CB` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`Prénom`, `Nom`, `Mail`, `Tel`, `Adresse`, `Date_contrat`, `mdp`, `ID`, `numero_CB`, `date_CB`, `crypto_CB`) VALUES
('michel', 'toto', 'toto@gmail.com', '122458484', '68B rue Smith, Espl. François Mitterand, 69002 Lyon', NULL, '81dc9bdb52d04dc20036dbd8313ed055', 1, 21051521, '2025-05-25', 325),
('francine', 'BOULE', 'francine@gmail.com', '122458484', '68B rue Smith, Espl. François Mitterand, 69002 Lyon', NULL, '81dc9bdb52d04dc20036dbd8313ed055', 2, 21051521, '2025-05-25', 325),
('michel', 'toto', 'coco@gmail.com', '122458484', '68B rue Smith, Espl. François Mitterand, 69002 Lyon', NULL, '81dc9bdb52d04dc20036dbd8313ed055', 3, 21051521, '2025-05-25', 325);

-- --------------------------------------------------------

--
-- Structure de la table `colis`
--

DROP TABLE IF EXISTS `colis`;
CREATE TABLE IF NOT EXISTS `colis` (
  `Numéro` int NOT NULL AUTO_INCREMENT,
  `Taille` int NOT NULL,
  `Poids` int NOT NULL,
  `Adresse_Livraison` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date_Livraison` date NOT NULL,
  `Lieu_Livraison` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`Numéro`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_Client` int NOT NULL,
  `ID_Livreur` int DEFAULT NULL,
  `Valide` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `ID_Client` (`ID_Client`),
  KEY `ID_Livreur` (`ID_Livreur`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`ID`, `ID_Client`, `ID_Livreur`, `Valide`) VALUES
(1, 1, 1, 0),
(2, 2, 1, 0),
(3, 2, 1, 0),
(4, 3, 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `livreur`
--

DROP TABLE IF EXISTS `livreur`;
CREATE TABLE IF NOT EXISTS `livreur` (
  `Prénom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Cmd_a_Livrer` int NOT NULL,
  `Adresse` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Permis` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Type_Véhicule` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Temps_Tournee` float NOT NULL,
  `ID` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Cmd_a_Livrer` (`Cmd_a_Livrer`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `livreur`
--

INSERT INTO `livreur` (`Prénom`, `Nom`, `Cmd_a_Livrer`, `Adresse`, `Permis`, `Type_Véhicule`, `Temps_Tournee`, `ID`, `email`, `mdp`) VALUES
('Jean', 'Cary', 2, 'St Michel - Mairie, 69007 Lyon', 'B', 'voiture', 7.2, 1, 'jean.cary@gmail.com', 'b71985397688d6f1820685dde534981b'),
('Michel', 'toto', 4, 'Croix-Rousse Centre\r\n69004 Lyon', 'B', 'voiture', 4, 2, 'michel.toto@gmail.com', 'd780182f77b121450849c2b088a444f0');

-- --------------------------------------------------------

--
-- Structure de la table `marketplace`
--

DROP TABLE IF EXISTS `marketplace`;
CREATE TABLE IF NOT EXISTS `marketplace` (
  `CA` int NOT NULL,
  `nombreCommande` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Prix` float NOT NULL,
  `Img` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Descript` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Quantite` int NOT NULL,
  `Nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Hauteur` float NOT NULL,
  `Largeur` float NOT NULL,
  `Longueur` float NOT NULL,
  `Poids` float NOT NULL,
  `ID_Vendeur` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_Vendeur` (`ID_Vendeur`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`ID`, `Prix`, `Img`, `Descript`, `Quantite`, `Nom`, `Hauteur`, `Largeur`, `Longueur`, `Poids`, `ID_Vendeur`) VALUES
(1, 69.99, 'product1.jpg', 'Casque sans fil, Bluetooth, Réduction de bruit', 42, 'Casque G@mer', 0, 0, 0, 0, 6),
(2, 109.99, 'product2.jpg', 'Wifi 6\r\nLivraison GRATUITE en France', 19, 'Fire TV Stick 4K Max | Appareil de streaming', 0, 0, 0, 0, 6),
(3, 108.15, 'product3.jpg', 'Montre pour hommes', 83, 'Fossil Commuter', 0, 0, 0, 0, 6),
(27, 399.99, 'rdclimatiseur.jpg', 'Suntec Climatiseur Mobile Silencieux Advance 12.0-12000 BTU Climatiseur Portable 4 en 1, Déshumidificateur, Ventilateur, Minuterie Programmable, 3,5KW, max~60 M2, Télécommande', 75, 'Climatiseur Mobile', 66.5, 44.5, 33.5, 32.9, 7),
(26, 11.9, 'rdlivre_codage.jpg', 'HTML: Le guide complet du développement et de la conception de sites Web pour programmer des sites Web en 7 jours', 5, 'livre codage informatique', 12.7, 0.86, 20.32, 0.17, 7),
(28, 160.99, 'rdchaises.jpg', 'Amazon Basics Lot de 4 chaises de salle à manger en métal, Noir', 140, 'Chaises en Métal', 51, 43, 85, 0.04, 7);

-- --------------------------------------------------------

--
-- Structure de la table `vendeur`
--

DROP TABLE IF EXISTS `vendeur`;
CREATE TABLE IF NOT EXISTS `vendeur` (
  `Prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ID` int NOT NULL AUTO_INCREMENT,
  `ouiadmin` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` int NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vendeur`
--

INSERT INTO `vendeur` (`Prenom`, `Nom`, `ID`, `ouiadmin`, `email`, `mdp`, `tel`) VALUES
('Alexis', 'godard', 6, 0, 'alexis@gmail.com', '79162b02a4adef009a7d8214aaaafec5', 682206617),
('quentin', 'raillard', 7, 1, 'quentin@gmail.com', 'e232baabf13fa4b5812c837c7cfb9026', 2821521);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
