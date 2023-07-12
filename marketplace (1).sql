-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 12 juil. 2023 à 15:29
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
-- Base de données : `marketplace`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `Prénom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tel` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Adresse` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Date_contrat` date DEFAULT NULL,
  `Mot_de_Passe` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ID` int NOT NULL AUTO_INCREMENT,
  `numero_CB` int DEFAULT NULL,
  `date_CB` date DEFAULT NULL,
  `crypto_CB` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`Prénom`, `Nom`, `Mail`, `Tel`, `Adresse`, `Date_contrat`, `Mot_de_Passe`, `ID`, `numero_CB`, `date_CB`, `crypto_CB`) VALUES
('michel', 'toto', 'toto@gmail.com', '', '68B rue Smith, Espl. François Mitterand, 69002 Lyon', NULL, '81dc9bdb52d04dc20036dbd8313ed055', 1, NULL, NULL, NULL),
('Jean', 'Cary', 'jean@gmail.com', '', '29 avenue Leclerc, 69007 Lyon', NULL, '01cfcd4f6b8770febfb40cb906715822', 2, NULL, NULL, NULL);

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
  `Prix` float DEFAULT NULL,
  `ID_Client` int NOT NULL,
  `Vendeur` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ID_Livreur` int DEFAULT NULL,
  PRIMARY KEY (`ID_Client`),
  UNIQUE KEY `ID` (`ID`),
  KEY `Vendeur` (`Vendeur`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`ID`, `Prix`, `ID_Client`, `Vendeur`, `ID_Livreur`) VALUES
(1, 90, 1, 'Estiam', 2),
(2, 45.75, 2, 'Micromania', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `contrat`
--

DROP TABLE IF EXISTS `contrat`;
CREATE TABLE IF NOT EXISTS `contrat` (
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contrat_livreur`
--

DROP TABLE IF EXISTS `contrat_livreur`;
CREATE TABLE IF NOT EXISTS `contrat_livreur` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contrat_vendeur`
--

DROP TABLE IF EXISTS `contrat_vendeur`;
CREATE TABLE IF NOT EXISTS `contrat_vendeur` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `liste_produit_vendu`
--

DROP TABLE IF EXISTS `liste_produit_vendu`;
CREATE TABLE IF NOT EXISTS `liste_produit_vendu` (
  `ID_Produit` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `livreur`
--

DROP TABLE IF EXISTS `livreur`;
CREATE TABLE IF NOT EXISTS `livreur` (
  `Prénom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Cmd_a_Livrer` int NOT NULL,
  `Adresse_Last_Livraison` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Last_Cmd_Livree` date NOT NULL,
  `Adresse` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Permis` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Type_Véhicule` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Temps_Tournee` float NOT NULL,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`),
  KEY `Cmd_a_Livrer` (`Cmd_a_Livrer`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `livreur`
--

INSERT INTO `livreur` (`Prénom`, `Nom`, `Cmd_a_Livrer`, `Adresse_Last_Livraison`, `Last_Cmd_Livree`, `Adresse`, `Permis`, `Type_Véhicule`, `Temps_Tournee`, `ID`) VALUES
('Jean', 'Cary', 2, '29 avenue Leclerc, 69007 Lyon', '2023-02-15', 'St Michel - Mairie, 69007 Lyon', 'B', 'voiture', 7.2, 1),
('Michel', 'toto', 4, ' 98 Av. des Frères Lumière, 69008 Lyon', '2023-02-14', 'Croix-Rousse Centre\r\n69004 Lyon', 'B', 'voiture', 4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `marketplace`
--

DROP TABLE IF EXISTS `marketplace`;
CREATE TABLE IF NOT EXISTS `marketplace` (
  `Nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Chiffre_d'affaire` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `ID_Cmd` int NOT NULL,
  `ID_Produit` int NOT NULL,
  `Quantité` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Prix` int NOT NULL,
  `Image` varbinary(8000) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vendeur`
--

DROP TABLE IF EXISTS `vendeur`;
CREATE TABLE IF NOT EXISTS `vendeur` (
  `Nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ID_Produit_Vendu` int NOT NULL,
  `ID` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
