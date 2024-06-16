-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 16 Juin 2024 à 17:49
-- Version du serveur :  5.6.20
-- Version de PHP :  5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `sae23`
--

-- --------------------------------------------------------

--
-- Structure de la table `Administration`
--

CREATE TABLE IF NOT EXISTS `Administration` (
  `id_admin` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `mot_de_passe` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Administration`
--

INSERT INTO `Administration` (`id_admin`, `login`, `mot_de_passe`) VALUES
(0, 'admin', 'passroot');

-- --------------------------------------------------------

--
-- Structure de la table `Batiment`
--

CREATE TABLE IF NOT EXISTS `Batiment` (
`batiment_ID` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `gest_ID` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `Batiment`
--

INSERT INTO `Batiment` (`batiment_ID`, `nom`, `gest_ID`) VALUES
(1, 'RT', 1),
(2, 'GIM', 2),
(3, 'CS', 2);

-- --------------------------------------------------------

--
-- Structure de la table `Capteur`
--

CREATE TABLE IF NOT EXISTS `Capteur` (
`capteur_ID` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `unite` varchar(255) NOT NULL,
  `Salle_ID` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=211 ;


-- --------------------------------------------------------

--
-- Structure de la table `Gestionnaire`
--

CREATE TABLE IF NOT EXISTS `Gestionnaire` (
  `id_gestionnaire` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `mot_de_passe` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Gestionnaire`
--

INSERT INTO `Gestionnaire` (`id_gestionnaire`, `login`, `mot_de_passe`) VALUES
(1, 'tnunes', '*6DC97D6963F43A7E72140B3FF98ED'),
(2, 'admin', '*BFDE131CB6D66FCE04F81DA953811');

-- --------------------------------------------------------

--
-- Structure de la table `mesure`
--

CREATE TABLE IF NOT EXISTS `mesure` (
`mesure_ID` int(11) NOT NULL,
  `mesure` float NOT NULL,
  `date` date NOT NULL,
  `horaire` time NOT NULL,
  `capteur_ID` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=761 ;


-- --------------------------------------------------------

--
-- Structure de la table `Salle`
--

CREATE TABLE IF NOT EXISTS `Salle` (
`Salle_ID` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `type` varchar(255) NOT NULL,
  `capacite` int(11) NOT NULL,
  `batiment_ID` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Batiment`
--
ALTER TABLE `Batiment`
 ADD PRIMARY KEY (`batiment_ID`), ADD KEY `gest_ID` (`gest_ID`), ADD KEY `gest_ID_2` (`gest_ID`), ADD KEY `gest_ID_3` (`gest_ID`);

--
-- Index pour la table `Capteur`
--
ALTER TABLE `Capteur`
 ADD PRIMARY KEY (`capteur_ID`), ADD KEY `Salle_ID` (`Salle_ID`), ADD FULLTEXT KEY `unite` (`unite`);

--
-- Index pour la table `Gestionnaire`
--
ALTER TABLE `Gestionnaire`
 ADD PRIMARY KEY (`id_gestionnaire`), ADD KEY `password` (`mot_de_passe`);

--
-- Index pour la table `mesure`
--
ALTER TABLE `mesure`
 ADD PRIMARY KEY (`mesure_ID`);

--
-- Index pour la table `Salle`
--
ALTER TABLE `Salle`
 ADD PRIMARY KEY (`Salle_ID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Batiment`
--
ALTER TABLE `Batiment`
MODIFY `batiment_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `Capteur`
--
ALTER TABLE `Capteur`
MODIFY `capteur_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=211;
--
-- AUTO_INCREMENT pour la table `mesure`
--
ALTER TABLE `mesure`
MODIFY `mesure_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=761;
--
-- AUTO_INCREMENT pour la table `Salle`
--
ALTER TABLE `Salle`
MODIFY `Salle_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Capteur`
--
ALTER TABLE `Capteur`
ADD CONSTRAINT `Capteur_ibfk_1` FOREIGN KEY (`Salle_ID`) REFERENCES `Salle` (`Salle_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
