-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Lun 05 Avril 2021 à 22:03
-- Version du serveur :  5.7.33-0ubuntu0.18.04.1
-- Version de PHP :  7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `chat-api`
--

-- --------------------------------------------------------

--
-- Structure de la table `chat_conversations`
--

CREATE TABLE `chat_conversations` (
  `id` int(11) NOT NULL COMMENT 'Clé primaire',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'indique si la conversation est active',
  `theme` varchar(40) CHARACTER SET latin1 NOT NULL COMMENT 'Thème de la conversation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `chat_conversations`
--

INSERT INTO `chat_conversations` (`id`, `active`, `theme`) VALUES
(1, 1, 'Les cours de TWE'),
(2, 0, 'Les cours en distanciel');

-- --------------------------------------------------------

--
-- Structure de la table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL COMMENT 'Identifiant du message',
  `idConversation` int(11) NOT NULL COMMENT 'Clé étrangère vers la table des conversations',
  `idAuteur` int(11) NOT NULL COMMENT 'clé étrangère vers la table des auteurs',
  `contenu` varchar(100) CHARACTER SET latin1 NOT NULL COMMENT 'Contenu du message'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `idConversation`, `idAuteur`, `contenu`) VALUES
(1, 1, 1, 'Que penses-tu de la nouvelle organisation des cours en TWE ?'),
(2, 2, 2, 'Quand les cours en présentiel reprendront-ils complètement ?'),
(3, 2, 1, 'A mon avis, pas avant la rentrée de septembre 2021 !'),
(4, 1, 2, 'Je préfère quand tous les cours sont en présentiel'),
(5, 1, 1, 'Moi aussi');

-- --------------------------------------------------------

--
-- Structure de la table `chat_users`
--

CREATE TABLE `chat_users` (
  `id` int(11) NOT NULL COMMENT 'clé primaire, identifiant numérique auto incrémenté',
  `pseudo` varchar(20) CHARACTER SET latin1 NOT NULL COMMENT 'pseudo',
  `passe` varchar(20) CHARACTER SET latin1 NOT NULL COMMENT 'mot de passe',
  `blacklist` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'indique si l''utilisateur est en liste noire',
  `admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'indique si l''utilisateur est un administrateur',
  `couleur` varchar(10) CHARACTER SET latin1 NOT NULL DEFAULT 'black' COMMENT 'indique la couleur préférée de l''utilisateur, en anglais',
  `hash` varchar(100) NOT NULL DEFAULT 'hash'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `chat_users`
--

INSERT INTO `chat_users` (`id`, `pseudo`, `passe`, `blacklist`, `admin`, `couleur`, `hash`) VALUES
(1, 'tom', 'web', 0, 1, 'blue', '4e28dafe87d65cca1482d21e76c61a06'),
(2, 'isa', 'bdd', 0, 0, 'orange', 'b9edda3aacebbf26bdfb708540070c05');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `chat_conversations`
--
ALTER TABLE `chat_conversations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idConversation` (`idConversation`),
  ADD KEY `idAuteur` (`idAuteur`);

--
-- Index pour la table `chat_users`
--
ALTER TABLE `chat_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `chat_conversations`
--
ALTER TABLE `chat_conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du message', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `chat_users`
--
ALTER TABLE `chat_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'clé primaire, identifiant numérique auto incrémenté', AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`idConversation`) REFERENCES `chat_conversations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`idAuteur`) REFERENCES `chat_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
