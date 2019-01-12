-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 12 jan. 2019 à 12:30
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projetphp`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `num_commande` int(255) NOT NULL AUTO_INCREMENT,
  `addr_livraison` varchar(255) NOT NULL,
  `cp_livraison` int(5) NOT NULL,
  `ville_livraison` varchar(100) NOT NULL,
  `pays_livraison` varchar(255) NOT NULL,
  `num_box` int(255) NOT NULL,
  `description_box` varchar(255) NOT NULL,
  `date_commande` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`num_commande`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`num_commande`, `addr_livraison`, `cp_livraison`, `ville_livraison`, `pays_livraison`, `num_box`, `description_box`, `date_commande`) VALUES
(1, '36 Avenue Général Eisenhower', 69005, 'Lyon', 'France', 762, 'Boite Classique ', '2019-01-09 13:29:58'),
(2, '21 Rue des Farges', 75001, 'Paris', 'France', 762, 'Boite Personnalisé : 1 - Poulet, 2 - Dinde', '2019-01-09 13:46:08'),
(3, '44 Rue Pauline Marie Jaricot', 69005, 'Lyon', 'France', 112, 'Boite Economique', '2019-01-09 13:29:58'),
(4, '108', 1002, 'Bourg-en-Bresse', 'France', 762, 'Boite Classique ', '2019-01-09 13:46:08');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `titre` text CHARACTER SET latin1 NOT NULL,
  `contenu` text CHARACTER SET latin1 NOT NULL,
  `auteur` text CHARACTER SET latin1 NOT NULL,
  `note` int(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `titre`, `contenu`, `auteur`, `note`, `date`) VALUES
(1, 'Plutôt satisfait', 'Je dois avouer que je fus plutôt perplexe au départ. Ma femme m\'a incité à acheter une de ces boites du fait d\'un bouche à oreille. Un fois testé, je suis assez content de ce qu\'il en ressort.', 'Jean Valjean', 4, '2018-09-09 10:30:05'),
(3, 'Sa Race', '8 déc. 2014 - Bonjour, J\'aimerais envoyer un mail à un utilisateur qui s\'est inscris dans mon site lorsqu\'il a oublié son mot de passe, mon formulaire : Code ...\r\n', 'Lenovo', 4, '2018-11-18 23:00:05'),
(4, 'Administration Test', 'Évidemment, on ne va pas dire au membre : « La clef que tu proposes est déjà utilisée, prends-en une autre ! ». Déjà, ça génèrera des heures supplémentaires dans votre service après-vente pour calmer les clients mécontents et en plus, il ne faut surtout pas que ça se sache ! Si ça se savait, on pourrait justement exploiter la « faille de la clef utilisée plus d\'une fois », sans compter le fait que le membre en question peut s\'amuser à obtenir le mot de passe de quelqu\'un d\'autre en utilisant cette clef (quoique comme indiqué plus haut, ça ne lui servira à rien puisque le mot de passe est renvoyé par e-mail et le membre n\'y a pas accès).\r\n\r\n', 'Pedro de la Vega', 4, '2018-11-09 21:00:55'),
(5, 'J\'en ai marre', 'Now, let\'s create a \"logout.php\" file. When the user clicks on the log out or sign out link, the script inside this file destroys the session and redirect the user back to the login page.\r\n\r\n', 'Tuez moi', 5, '2019-01-09 11:30:05');

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_request`
--

DROP TABLE IF EXISTS `password_reset_request`;
CREATE TABLE IF NOT EXISTS `password_reset_request` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date_requested` datetime NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `password_reset_request`
--

INSERT INTO `password_reset_request` (`id`, `user_id`, `date_requested`, `token`) VALUES
(5, 1, '2019-01-11 11:13:44', '8d885358a6568f12b0d354e553f3d027'),
(6, 10, '2019-01-11 11:14:23', '2f16b4fb8b482c2b11193c5436214f63'),
(7, 1, '2019-01-12 12:25:49', '226f67c282df5eeef43ce22179823890');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `identifiant` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`identifiant`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `prenom`, `nom`, `identifiant`, `email`, `password`, `admin`, `created_at`) VALUES
(1, 'Mehdi', 'CHOUANIA', 'Mehdi', 'chouania.mehdi@hotmail.fr', '$2y$10$5gl7IOVtY6EfuKiSWEPrBubthV4NcVbRVMZ/KHQbI6HljMsAZ/c/q', 1, '2019-01-04 15:51:26'),
(10, 'Test', 'Test', 'Pistache', 'pistache@gmail.com', '$2y$10$vLGAVubOIiRtsFQnfXH0Yenu8Tp73PTIQz2fLHQGDUKXTWHFnsjUS', NULL, '2019-01-10 14:33:26'),
(13, 'Virgil', 'CARON', 'Casdin', 'popopo@lejho.com', '$2y$10$if1BIKRZRDXzh4RHKuXGhergk4Mp54tta3wdlQun5SlpYFjg8eSGK', NULL, '2019-01-10 16:00:28');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
