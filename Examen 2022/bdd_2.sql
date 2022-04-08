-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 06 avr. 2022 à 10:23
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bdd_2`
--

-- --------------------------------------------------------

--
-- Structure de la table `cles`
--

DROP TABLE IF EXISTS `cles`;
CREATE TABLE IF NOT EXISTS `cles` (
                                      `id` int(11) NOT NULL AUTO_INCREMENT,
                                      `id_user` int(11) NOT NULL,
                                      `cle` varchar(255) NOT NULL,
                                      `iv` varchar(255) NOT NULL,
                                      `datcre` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                      PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `cles`
--

INSERT INTO `cles` (`id`, `id_user`, `cle`, `iv`, `datcre`) VALUES
    (1, 1, 'e21a69686d3ecc6fb500dcd83fc0ec6701e5ed5652aaeb043c066314af0cd67fcae91cd866e7b26ff5a349f5b604fb59015ab10082ae53c05f51f72f38edbc8d', '700715760755278f6d1d1e21454294a1', '2022-04-06 12:16:51');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
