-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Temps de generació: 12-02-2017 a les 20:34:53
-- Versió del servidor: 10.1.16-MariaDB
-- Versió de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `rma`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `averies`
--

CREATE TABLE `averies` (
  `id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `averia` text COLLATE utf8_spanish_ci,
  `prod_averiat_marca` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `prod_averiat_model` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `prod_averiat_sn` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `prod_nou_marca` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `prod_nou_model` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `prod_nou_sn` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `lloc` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `aula` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `reposar_prod_averiat` int(11) DEFAULT '0',
  `garantia_fins` date DEFAULT NULL,
  `enviat_reparar` date DEFAULT NULL,
  `tornat_reparar` date DEFAULT NULL,
  `tancat` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Estructura de la taula `interactions`
--

CREATE TABLE `interactions` (
  `id` int(11) NOT NULL,
  `id_averia` int(11) NOT NULL,
  `data` date NOT NULL,
  `cos` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Estructura de la taula `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_GUID` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_spanish_ci NOT NULL,
  `entry_date` datetime NOT NULL,
  `status` enum('0','1') CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Estructura de la taula `user_profile`
--

CREATE TABLE `user_profile` (
  `profile_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Indexos per taules bolcades
--

--
-- Index de la taula `averies`
--
ALTER TABLE `averies`
  ADD PRIMARY KEY (`id`);

--
-- Index de la taula `interactions`
--
ALTER TABLE `interactions`
  ADD PRIMARY KEY (`id`);

--
-- Index de la taula `productes_sn`
--
ALTER TABLE `productes_sn`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `marca` (`marca`,`model`,`sn`);

--
-- Index de la taula `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Index de la taula `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Restriccions per taules bolcades
--

--
-- Restriccions per la taula `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
