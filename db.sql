-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  jeu. 08 nov. 2018 à 11:11
-- Version du serveur :  5.6.38
-- Version de PHP :  7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `ISIR`
--

-- --------------------------------------------------------

--
-- Structure de la table `isir_users`
--

CREATE TABLE `isir_users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `spam` tinyint(2) NOT NULL DEFAULT '0',
  `deleted` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Déchargement des données de la table `isir_users`
--

INSERT INTO `isir_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`, `spam`, `deleted`) VALUES
(1, 'root', '$P$ByNs2NZ4g047mHhlM6zY.IvN6JeFDx.', 'root', 'root@gmail.com', '', '2018-10-11 14:00:33', '', 0, 'root', 0, 0),
(2, 'ziyi', '$P$ByNs2NZ4g047mHhlM6zY.IvN6JeFDx.', 'ziyi', 'ziyi@gmail.com', '', '2018-10-11 00:00:00', '', 0, 'ziyi', 0, 0),
(3, 'souka', '$P$ByNs2NZ4g047mHhlM6zY.IvN6JeFDx.', 'souka', 'souka@gmail.com', '', '2018-10-11 00:00:00', '', 0, 'souka', 0, 0),
(4, 'desse', '$P$ByNs2NZ4g047mHhlM6zY.IvN6JeFDx.', 'desse', 'desse@gmail.com', '', '2018-10-11 00:00:00', '', 0, 'desse', 0, 0),
(5, 'amel', '$P$ByNs2NZ4g047mHhlM6zY.IvN6JeFDx.', 'amel', 'amel@gmail.com', '', '2018-10-11 00:00:00', '', 0, 'amel', 0, 0),
(6, 'sylia', '$P$ByNs2NZ4g047mHhlM6zY.IvN6JeFDx.', 'sylia', 'sylia@gmail.com', '', '2018-10-11 00:00:00', '', 0, 'sylia', 0, 0),
(7, 'alex', '$P$ByNs2NZ4g047mHhlM6zY.IvN6JeFDx.', 'alex', 'alex@gmail.com', '', '2018-10-11 00:00:00', '', 0, 'alex', 0, 0),
(8, 'nicolas', '$P$ByNs2NZ4g047mHhlM6zY.IvN6JeFDx.', 'nicolas', 'nicolas@gmail.com', '', '2018-10-11 00:00:00', '', 0, 'nicolas', 0, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `isir_users`
--
ALTER TABLE `isir_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nicename`),
  ADD KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `isir_users`
--
ALTER TABLE `isir_users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
