-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 06 avr. 2022 à 10:24
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
-- Base de données : `bdd_1`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
                                       `id` int(11) NOT NULL,
                                       `nomutilisateur` varchar(255) NOT NULL,
                                       `motdepasse` varchar(255) NOT NULL,
                                       PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `nomutilisateur`, `motdepasse`) VALUES
    (1, '887375daec62a9f02d32a63c9e14c7641a9a8a42e4fa8f6590eb928d9744b57bb5057a1d227e4d40ef911ac030590bbce2bfdb78103ff0b79094cee8425601f5', '$2y$10$hkZhhSR6lBA1z0D5e7WOKuw83pH/N9r1WNoyuOY7FCjAvnYoq8BCa');

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
                                          `id` int(11) NOT NULL,
                                          `idauteur` int(11) NOT NULL,
                                          `titre` varchar(255) NOT NULL,
                                          `contenu` varchar(5000) NOT NULL,
                                          PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `idauteur`, `titre`, `contenu`) VALUES
                                                                  (2, 1, 'Nulla amet dolore', '<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi <b>sint occaecati cupiditate non provident</b>, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>'),
                                                                  (3, 1, 'Tempus ullamcorper', '<p>Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</p>'),
                                                                  (4, 1, 'Sed etiam facilis', '<p>Curabitur rhoncus lacus maximus, bibendum sapien ut, ultricies libero. Nullam ornare dui vel tortor ultrices, ut aliquet massa euismod. Maecenas tincidunt ante quis suscipit luctus. Aenean imperdiet hendrerit nisl non posuere. Etiam nec arcu et ex convallis laoreet a sagittis felis. <i>Morbi eu sollicitudin</i> justo, at malesuada enim. Sed convallis finibus lorem eget hendrerit. Vivamus mauris lorem, tincidunt eget dolor quis, tincidunt facilisis ipsum. </p>'),
                                                                  (5, 1, 'Feugiat lorem aenean', '<p>Nulla auctor egestas mi sed mattis. Donec pellentesque mauris ac dignissim sagittis. Nunc id magna nec ipsum aliquam consequat. Sed eu maximus libero. Ut scelerisque porta magna sodales cursus. Donec sed ultrices nunc. Donec nibh turpis, dapibus nec vestibulum sit amet, commodo tincidunt ante. Maecenas suscipit ullamcorper volutpat. In et cursus risus. Nunc sit amet ornare risus, sed euismod ligula. </p>'),
                                                                  (6, 1, 'Amet varius aliquam', '<p>Nulla non lacus condimentum, pretium tortor id, fermentum magna. Phasellus sed leo ultricies, dictum nulla ut, ornare elit. Aliquam egestas vulputate diam eu placerat. Sed volutpat lobortis suscipit. Sed quis imperdiet libero. Aliquam hendrerit turpis sed mi tincidunt, ac aliquet tortor imperdiet. Proin turpis sapien, venenatis ullamcorper diam sed, tempor condimentum eros. </p>');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
                                              `id` int(11) NOT NULL,
                                              `idarticle` int(11) NOT NULL,
                                              `pseudo` varchar(255) NOT NULL,
                                              `commentaire` varchar(255) NOT NULL,
                                              PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `idarticle`, `pseudo`, `commentaire`) VALUES
                                                                            (1, 1, 'Trolleur', 'Ca ne veut rien dire votre article là !'),
                                                                            (2, 6, 'Trolleur', 'rien compris...');

-- --------------------------------------------------------

--
-- Structure de la table `connexion`
--

DROP TABLE IF EXISTS `connexion`;
CREATE TABLE IF NOT EXISTS `connexion` (
                                           `id` int(11) NOT NULL AUTO_INCREMENT,
                                           `user_id` int(11) NOT NULL,
                                           `ip` varchar(255) NOT NULL,
                                           `user_agent` varchar(255) NOT NULL,
                                           `zipcode` varchar(255) NOT NULL,
                                           `country` varchar(255) NOT NULL,
                                           `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                           PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `connexion`
--

INSERT INTO `connexion` (`id`, `user_id`, `ip`, `user_agent`, `zipcode`, `country`, `created_at`) VALUES
                                                                                                      (1, 1, '147.94.73.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36 Edg/100.0.1185.29', '13000', 'FR', '2022-04-06 12:07:48'),
                                                                                                      (2, 1, '147.94.73.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36 Edg/100.0.1185.29', '13000', 'FR', '2022-04-06 12:09:07'),
                                                                                                      (3, 1, '147.94.73.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36 Edg/100.0.1185.29', '13000', 'FR', '2022-04-06 12:10:13'),
                                                                                                      (4, 1, '147.94.73.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36 Edg/100.0.1185.29', '13000', 'FR', '2022-04-06 12:10:47'),
                                                                                                      (5, 1, '147.94.73.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36 Edg/100.0.1185.29', '13000', 'FR', '2022-04-06 12:11:50'),
                                                                                                      (6, 1, '147.94.73.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36 Edg/100.0.1185.29', '13000', 'FR', '2022-04-06 12:15:44'),
                                                                                                      (7, 1, '147.94.73.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.60 Safari/537.36 Edg/100.0.1185.29', '13000', 'FR', '2022-04-06 12:16:51');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
                                      `id` int(11) NOT NULL AUTO_INCREMENT,
                                      `login` varchar(255) NOT NULL,
                                      `password` varchar(255) NOT NULL,
                                      `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                      `modified_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                      PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `created_at`, `modified_at`) VALUES
                                                                                (1, '10e06b990d44de0091a2113fd95c92fc905166af147aa7632639c41aa7f26b1620c47443813c605b924c05591c161ecc35944fc69c4433a49d10fc6b04a33611', '$2y$10$uwY2WqTbQGfQBSqzmHha.uXb4z9Juifg0JxdSEDcokniY9CStWXCy', '2022-04-06 11:22:29', '2022-04-06 12:02:48'),
                                                                                (2, 'tata', 'tata', '2022-04-06 11:24:42', '2022-04-06 11:24:42');

-- --------------------------------------------------------

--
-- Structure de la table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
CREATE TABLE IF NOT EXISTS `user_details` (
                                              `id` int(11) NOT NULL,
                                              `user_id` int(11) NOT NULL,
                                              `lastname` varchar(255) NOT NULL,
                                              `firstname` varchar(255) NOT NULL,
                                              `city` varchar(255) NOT NULL,
                                              `region` varchar(255) NOT NULL,
                                              `country` varchar(255) NOT NULL,
                                              `zipcode` varchar(255) NOT NULL,
                                              `lastip` varchar(255) NOT NULL,
                                              `nbconn` int(11) NOT NULL,
                                              `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                              `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
