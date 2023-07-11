-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 11 juil. 2023 à 08:28
-- Version du serveur : 5.7.40
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
  `Prénom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Adresse` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date_contrat` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `colis`
--

DROP TABLE IF EXISTS `colis`;
CREATE TABLE IF NOT EXISTS `colis` (
  `Numéro` int(11) NOT NULL AUTO_INCREMENT,
  `Taille` int(11) NOT NULL,
  `Poids` int(11) NOT NULL,
  `Adresse_Livraison` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date_Livraison` date NOT NULL,
  `Lieu_Livraison` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`Numéro`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Prix` int(11) DEFAULT NULL,
  `Client` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Vendeur` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`Client`),
  UNIQUE KEY `ID` (`ID`),
  KEY `Vendeur` (`Vendeur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contrat_livreur`
--

DROP TABLE IF EXISTS `contrat_livreur`;
CREATE TABLE IF NOT EXISTS `contrat_livreur` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contrat_vendeur`
--

DROP TABLE IF EXISTS `contrat_vendeur`;
CREATE TABLE IF NOT EXISTS `contrat_vendeur` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `liste_produit_vendu`
--

DROP TABLE IF EXISTS `liste_produit_vendu`;
CREATE TABLE IF NOT EXISTS `liste_produit_vendu` (
  `ID_Produit` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `livreur`
--

DROP TABLE IF EXISTS `livreur`;
CREATE TABLE IF NOT EXISTS `livreur` (
  `Prénom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Cmd_a_Livrer` int(11) NOT NULL,
  `Adresse_Last_Livraison` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Last_Cmd_Livree` date NOT NULL,
  `Adresse` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Permis` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Type_Véhicule` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `Cmd_a_Livrer` (`Cmd_a_Livrer`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `marketplace`
--

DROP TABLE IF EXISTS `marketplace`;
CREATE TABLE IF NOT EXISTS `marketplace` (
  `Nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Chiffre_d'affaire` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `ID_Cmd` int(11) NOT NULL,
  `ID_Produit` int(11) NOT NULL,
  `Quantité` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Prix` int(11) NOT NULL,
  `Image` varbinary(8000) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vendeur`
--

DROP TABLE IF EXISTS `vendeur`;
CREATE TABLE IF NOT EXISTS `vendeur` (
  `Nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ID_Produit_Vendu` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
