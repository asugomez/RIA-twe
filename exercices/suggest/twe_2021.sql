-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mar 17 Septembre 2019 à 11:37
-- Version du serveur :  5.7.27-0ubuntu0.18.04.1
-- Version de PHP :  7.2.19-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `web2`
--

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

 
--
-- Contenu de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `nom`, `prenom`) VALUES
(1,  'AIT MOUNA','Rida'),				 
(2,  'ALDANA VALVERDE','Pablo'),			
(3,  'BENICHOU','Yaniv'),				
(4,  'BETHUNE','Nicolas'),				
(5,  'CAMMARATA','Hugo'),				
(6,  'DA SILVA PONTES','Joel Kalil'),		
(7,  'DESSART','Martin'),				
(8,  'DUFRESNE','Hugo'),				
(9,  'FAVRE','Guillaume'),				
(10, 'GAZEAU','Gregoire'),				
(11, 'GIBIER','Paul-Ewen'),				
(12, 'GUIMARAES DE MOURA','Matheus'),		
(13, 'KIROV','David'),				
(14, 'LECKERT','Stanley'),				
(15, 'LINERO','Yann'),				
(16, 'MALTA PURIM','Andreis Gustavo'),		
(17, 'MALTAVERNE','Julien'),				
(18, 'MARCIANO','Samuel'),				
(19, 'MOREL FILLON','Antonin'),			
(20, 'MOUKHAFI','Ahmed'),				
(21, 'OUARDI','Ilyas'),				
(22, 'PERROT','Mathieu'),				
(23, 'POUGET','Thomas'),				
(24, 'PRUDHOMME','Colin'),				
(25, 'ROBINEAU','Joseph'),				
(26, 'RODRIGUEZ','Pierre'),				
(27, 'ROURE','Julien'),				
(28, 'SANTOS PENHA DE OLIVEIRA','Joao Lucas'),	
(29, 'SIDIBE','Amara'),				
(30, 'SIMON','Loic'),				
(31, 'SUN','Yishan'),				
(32, 'THIBAULT','Alexandre'),			
(33, 'VASSEUR','Henri'),				
(34, 'ASKOUR','Soufiane'),				
(35, 'BENARD','Julien'),				
(36, 'BONNIN','Olivier'),				
(37, 'CAMPOS COSTA','Eliot'),			
(38, 'CAPLAN','Jean-Baptiste'),			
(39, 'CHAOUI','Amal'),				
(40, 'CLAVEL','Paul'),				
(41, 'COHEN','Benjamin'),				
(42, 'DAMMARETZ','Remy'),				
(43, 'DARGAUD','Laurine'),				
(44, 'ESCOURROU','Antoine'),				
(45, 'FREMERYE','Louis'),				
(46, 'GELINAS','Sebastien'),				
(47, 'GILLES','Theo-Gabriel'),			
(48, 'GOMEZ COLOMER','Asuncion Carolina'),		
(49, 'GRESILLON','Leo'),				
(50, 'HADJ-BOUZID','Rayan'),				
(51, 'MACUDZINSKI','Matyas'),			
(52, 'MILHIET','Louis'),				
(53, 'PELLOUX','Alexandre'),				
(54, 'PINHEIRO MELO','Daniel'),			
(55, 'PINHEIRO MELO','Joao Paulo'),			
(56, 'PLOTTON','Matthieu'),				
(57, 'SALEM','Emilie'),				
(58, 'SUISSA','Deborah'),				
(59, 'VALIAU','Virgile'),				
(60, 'VEYSSEYRE','Robin'),				
(61, 'WANG','Celine'),				
(62, 'WU','Bowen'),					
(63, 'CECHURA','Tom'),				
(64, 'JEAN','Matthieu');                             

--
-- Index pour les tables exportées
--

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

