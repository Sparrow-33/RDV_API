-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 26 mai 2022 à 22:00
-- Version du serveur : 5.7.36
-- Version de PHP : 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `rdv`
--

-- --------------------------------------------------------

--
-- Structure de la table `creneau`
--

DROP TABLE IF EXISTS `creneau`;
CREATE TABLE IF NOT EXISTS `creneau` (
  `CID` int(11) NOT NULL AUTO_INCREMENT,
  `begin` time NOT NULL,
  `end` time NOT NULL,
  PRIMARY KEY (`CID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `creneau`
--

INSERT INTO `creneau` (`CID`, `begin`, `end`) VALUES
(1, '09:00:00', '09:30:00'),
(2, '09:30:00', '10:00:00'),
(3, '10:00:00', '10:30:00'),
(4, '10:30:00', '11:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `PID` varchar(255) COLLATE utf8_bin NOT NULL,
  `Pname` varchar(20) COLLATE utf8_bin NOT NULL,
  `Fname` varchar(20) COLLATE utf8_bin NOT NULL,
  `email` text COLLATE utf8_bin NOT NULL,
  `NID` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8_bin DEFAULT 'HH111',
  PRIMARY KEY (`PID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`PID`, `Pname`, `Fname`, `email`, `NID`, `reference`) VALUES
('ef454d46eb86e65ba6a39c20427fc1ff', 'Haytham', 'El Haoudi', 'h@elhaoudi.com', 'HH12234', 'HHEL2001'),
('4dcdee9b91081afd2948934ffdac3f7e', 'MrTest', 'testing', 'test1@test1.com', 'AZ1211ZZ', 'MrteAZ8b9bb2cefcabeb78b1ae'),
('039021dbe1e0a47de01b116e9e41d781', 'test2', 'test2', 'test2@test2.com', 'H12HH222', 'teteH18ef6e96f10e6a7c805cd');

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

DROP TABLE IF EXISTS `rendezvous`;
CREATE TABLE IF NOT EXISTS `rendezvous` (
  `IDR` int(11) NOT NULL AUTO_INCREMENT,
  `Sujet` text COLLATE utf8_bin NOT NULL,
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateRDV` date NOT NULL,
  `CID` int(11) NOT NULL,
  `PID` varchar(255) COLLATE utf8_bin NOT NULL,
  `STATUS` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`IDR`),
  KEY `PID` (`PID`),
  KEY `CID` (`CID`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `rendezvous`
--

INSERT INTO `rendezvous` (`IDR`, `Sujet`, `creation`, `dateRDV`, `CID`, `PID`, `STATUS`) VALUES
(39, 'Just testingsss', '2022-05-23 15:37:23', '2022-05-03', 1, '039021dbe1e0a47de01b116e9e41d781', 0),
(38, 'Just testing', '2022-05-18 13:24:58', '2022-05-19', 3, 'ef454d46eb86e65ba6a39c20427fc1ff', 0),
(37, 'Just bunch of tests', '2022-05-17 16:51:26', '2022-05-18', 1, '4dcdee9b91081afd2948934ffdac3f7e', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
