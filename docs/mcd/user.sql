-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 28 Janvier 2013 à 09:32
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `user`
--

-- --------------------------------------------------------

--
-- Structure de la table `consumers`
--

CREATE TABLE IF NOT EXISTS `consumers` (
  `id_consumer` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `consumer_key` char(40) NOT NULL,
  `consumer_secret` char(40) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_consumer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `consumers-nonce`
--

CREATE TABLE IF NOT EXISTS `consumers-nonce` (
  `id_consumer-nonce` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nonce` char(27) DEFAULT NULL,
  `id_consumer` bigint(19) unsigned NOT NULL,
  PRIMARY KEY (`id_consumer-nonce`),
  KEY `fk_consumers-nonce_consumers1_idx` (`id_consumer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id_event` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `date_begin` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  PRIMARY KEY (`id_event`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id_group` bigint(19) unsigned NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` text,
  `id_role` bigint(20) NOT NULL,
  PRIMARY KEY (`id_group`),
  KEY `fk_groups_roles_idx` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `groups-users`
--

CREATE TABLE IF NOT EXISTS `groups-users` (
  `id_group` bigint(19) unsigned NOT NULL,
  `id_user` bigint(20) NOT NULL,
  PRIMARY KEY (`id_group`,`id_user`),
  KEY `fk_groups_has_users_users1_idx` (`id_user`),
  KEY `fk_groups_has_users_groups1_idx` (`id_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `token-types`
--

CREATE TABLE IF NOT EXISTS `token-types` (
  `id_token-types` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_token-types`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tokens`
--

CREATE TABLE IF NOT EXISTS `tokens` (
  `id_token` bigint(19) unsigned NOT NULL AUTO_INCREMENT,
  `token` char(40) NOT NULL,
  `token_secret` char(40) NOT NULL,
  `token_verifier` varchar(255) NOT NULL,
  `callback` varchar(255) NOT NULL,
  `id_consumer` bigint(19) unsigned NOT NULL,
  `id_token-types` bigint(19) unsigned NOT NULL,
  `id_user` bigint(20) NOT NULL,
  PRIMARY KEY (`id_token`),
  KEY `fk_tokens_consumers1_idx` (`id_consumer`),
  KEY `fk_tokens_token-types1_idx` (`id_token-types`),
  KEY `fk_tokens_users1_idx` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_ldap` binary(16) DEFAULT NULL,
  `access_token` char(32) DEFAULT NULL,
  `id_role` bigint(20) NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `fk_users_roles1_idx` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `users-events`
--

CREATE TABLE IF NOT EXISTS `users-events` (
  `id_user` bigint(20) NOT NULL,
  `id_event` bigint(20) NOT NULL,
  PRIMARY KEY (`id_user`,`id_event`),
  KEY `fk_users_has_events_users1_idx` (`id_user`),
  KEY `fk_users_has_events_events1_idx` (`id_event`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `consumers-nonce`
--
ALTER TABLE `consumers-nonce`
  ADD CONSTRAINT `fk_consumers-nonce_consumers1` FOREIGN KEY (`id_consumer`) REFERENCES `consumers` (`id_consumer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `fk_groups_roles` FOREIGN KEY (`id_role`) REFERENCES `application`.`roles` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `groups-users`
--
ALTER TABLE `groups-users`
  ADD CONSTRAINT `fk_groups_has_users_groups1` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id_group`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_groups_has_users_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `fk_tokens_consumers1` FOREIGN KEY (`id_consumer`) REFERENCES `consumers` (`id_consumer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tokens_token-types1` FOREIGN KEY (`id_token-types`) REFERENCES `token-types` (`id_token-types`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tokens_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_roles1` FOREIGN KEY (`id_role`) REFERENCES `application`.`roles` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `users-events`
--
ALTER TABLE `users-events`
  ADD CONSTRAINT `fk_users_has_events_events1` FOREIGN KEY (`id_event`) REFERENCES `events` (`id_event`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_events_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
