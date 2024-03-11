-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : dim. 10 mars 2024 à 21:23
-- Version du serveur : 5.7.39
-- Version de PHP : 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `profil_utilisateur`
--

-- --------------------------------------------------------

--
-- Structure de la table `archives`
--

CREATE TABLE `archives` (
  `id` int(11) NOT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `naissance` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `provenance` varchar(255) DEFAULT NULL,
  `arrivee` varchar(255) DEFAULT NULL,
  `chambre` varchar(255) DEFAULT NULL,
  `cartid` varchar(255) DEFAULT NULL,
  `name_description` text,
  `pere_nom_prenom` varchar(255) DEFAULT NULL,
  `pere_date_naissance` varchar(255) DEFAULT NULL,
  `pere_ville` varchar(255) DEFAULT NULL,
  `pere_tele` varchar(20) DEFAULT NULL,
  `pere_email` varchar(255) DEFAULT NULL,
  `pere_identification` varchar(255) DEFAULT NULL,
  `mere_nom_prenom` varchar(255) DEFAULT NULL,
  `mere_date_naissance` varchar(255) DEFAULT NULL,
  `mere_ville` varchar(255) DEFAULT NULL,
  `mere_tele` varchar(20) DEFAULT NULL,
  `mere_email` varchar(255) DEFAULT NULL,
  `mere_identification` varchar(255) DEFAULT NULL,
  `nom_ecole` varchar(255) DEFAULT NULL,
  `niveau_scolaire` varchar(255) DEFAULT NULL,
  `adaptation` text,
  `note_semestre1` decimal(5,2) DEFAULT NULL,
  `note_semestre2` decimal(5,2) DEFAULT NULL,
  `total` decimal(5,2) DEFAULT NULL,
  `bourse` varchar(255) DEFAULT NULL,
  `tutorat` varchar(255) DEFAULT NULL,
  `medicaments` varchar(255) DEFAULT NULL,
  `etat_de_sante` varchar(255) DEFAULT NULL,
  `sante_description` text,
  `archiving_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_picture` varchar(255) DEFAULT NULL,
  `total1` varchar(255) DEFAULT NULL,
  `total2` varchar(255) DEFAULT NULL,
  `total3` varchar(255) DEFAULT NULL,
  `totaltronc` varchar(255) DEFAULT NULL,
  `total1bac` varchar(255) DEFAULT NULL,
  `total2bac` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `sujet` varchar(255) DEFAULT NULL,
  `message` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `id` int(11) NOT NULL,
  `genre` varchar(10) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `naissance` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `provenance` varchar(255) DEFAULT NULL,
  `arrivee` varchar(255) DEFAULT NULL,
  `chambre` varchar(10) DEFAULT NULL,
  `cartid` varchar(20) DEFAULT NULL,
  `name_description` text,
  `pere_nom_prenom` varchar(255) DEFAULT NULL,
  `pere_date_naissance` varchar(255) DEFAULT NULL,
  `pere_ville` varchar(255) DEFAULT NULL,
  `pere_identification` varchar(20) DEFAULT NULL,
  `mere_nom_prenom` varchar(255) DEFAULT NULL,
  `mere_date_naissance` varchar(255) DEFAULT NULL,
  `mere_ville` varchar(255) DEFAULT NULL,
  `mere_identification` varchar(20) DEFAULT NULL,
  `nom_ecole` varchar(255) DEFAULT NULL,
  `niveau_scolaire` varchar(255) DEFAULT NULL,
  `adaptation` varchar(255) DEFAULT NULL,
  `note_semestre1` varchar(10) DEFAULT NULL,
  `note_semestre2` varchar(10) DEFAULT NULL,
  `total` varchar(10) DEFAULT NULL,
  `bourse` varchar(255) DEFAULT NULL,
  `tutorat` varchar(255) DEFAULT NULL,
  `medicaments` varchar(255) DEFAULT NULL,
  `etat_de_sante` varchar(255) DEFAULT NULL,
  `sante_description` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_picture` varchar(255) DEFAULT NULL,
  `pere_tele` varchar(255) DEFAULT NULL,
  `pere_email` varchar(255) DEFAULT NULL,
  `mere_tele` varchar(255) DEFAULT NULL,
  `mere_email` varchar(255) DEFAULT NULL,
  `nam_du_centre` varchar(255) DEFAULT NULL,
  `total1` varchar(255) DEFAULT NULL,
  `total2` varchar(255) DEFAULT NULL,
  `total3` varchar(255) DEFAULT NULL,
  `totaltronc` varchar(255) DEFAULT NULL,
  `total1bac` varchar(255) DEFAULT NULL,
  `total2bac` varchar(255) DEFAULT NULL,
  `add_by` varchar(255) DEFAULT NULL,
  `modify_by` varchar(255) DEFAULT NULL,
  `archived_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `user_type` enum('admin','standard') NOT NULL DEFAULT 'standard',
  `profile_image_users` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`uid`, `name`, `email`, `password`, `mobile`, `user_type`, `profile_image_users`, `reset_token`) VALUES
(1, 'adminuser', 'admin@gmail.com', '$2y$10$tvQYvmEKKrCKYWDE8.x6hejFKB4SsoT2ZBapSfEd5LvhQcwVzUy1i', '0102030405', 'admin', '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `visites`
--

CREATE TABLE `visites` (
  `id` int(11) NOT NULL,
  `beneficiaire` varchar(255) DEFAULT NULL,
  `visiteur` varchar(255) DEFAULT NULL,
  `cin_visiteur` varchar(255) DEFAULT NULL,
  `type_visiteur` varchar(255) DEFAULT NULL,
  `lieu` varchar(255) DEFAULT NULL,
  `date_heure` datetime DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `archives`
--
ALTER TABLE `archives`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- Index pour la table `visites`
--
ALTER TABLE `visites`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `archives`
--
ALTER TABLE `archives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `visites`
--
ALTER TABLE `visites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
