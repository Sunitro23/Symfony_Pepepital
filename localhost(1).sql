-- phpMyAdmin SQL Dump
-- version 5.2.0-1.fc36
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 13 déc. 2022 à 12:39
-- Version du serveur : 10.5.18-MariaDB
-- Version de PHP : 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pepepitalrdv`
--
CREATE DATABASE IF NOT EXISTS `pepepitalrdv` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pepepitalrdv`;

-- --------------------------------------------------------

--
-- Structure de la table `assistant`
--

CREATE TABLE `assistant` (
  `id` int(11) NOT NULL,
  `login` varchar(180) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `assistant`
--

INSERT INTO `assistant` (`id`, `login`) VALUES
(1, 'armand');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20221206124833', '2022-12-06 12:49:08', 2697),
('DoctrineMigrations\\Version20221206130808', '2022-12-06 13:08:17', 166),
('DoctrineMigrations\\Version20221206131400', '2022-12-06 13:14:12', 1419),
('DoctrineMigrations\\Version20221206140213', '2022-12-06 14:02:16', 58),
('DoctrineMigrations\\Version20221206140248', '2022-12-06 14:02:55', 77),
('DoctrineMigrations\\Version20221206144721', '2022-12-06 14:47:27', 263);

-- --------------------------------------------------------

--
-- Structure de la table `indisponibilite`
--

CREATE TABLE `indisponibilite` (
  `id` int(11) NOT NULL,
  `medecin_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `libelle` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

CREATE TABLE `medecin` (
  `id` int(11) NOT NULL,
  `assistant_id` int(11) DEFAULT NULL,
  `nom` varchar(180) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `medecin`
--

INSERT INTO `medecin` (`id`, `assistant_id`, `nom`) VALUES
(1, 1, 'Basile'),
(3, NULL, 'julien'),
(4, NULL, 'lael');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `nom` varchar(180) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `mail` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`id`, `nom`, `adresse`, `mail`) VALUES
(1, 'Lael', 'qsdqsdqs', 'lael.vander@gmail.com'),
(2, 'test', 'test', 'test'),
(3, 'patient', 'patient', 'patient@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

CREATE TABLE `rdv` (
  `id` int(11) NOT NULL,
  `medecin_id` int(11) NOT NULL,
  `statut_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `duree` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `rdv`
--

INSERT INTO `rdv` (`id`, `medecin_id`, `statut_id`, `patient_id`, `date`, `heure`, `duree`) VALUES
(1, 3, 1, 3, '2017-01-01', '00:00:00', 15);

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

CREATE TABLE `statut` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `statut`
--

INSERT INTO `statut` (`id`, `libelle`) VALUES
(1, 'En attente'),
(2, 'Valide');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) NOT NULL,
  `username` varchar(25) NOT NULL,
  `medecin_id` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `assistant_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `username`, `medecin_id`, `patient_id`, `assistant_id`) VALUES
(2, 'lael.vander@gmail.com', '[\"ROLE_MEDECIN\"]', '$2y$13$wtWNLpyqGQoQ1LspMwyCgOApRHgjh.g3VJg1LeSMQvMcvoxOQAipu', 'lael', 4, NULL, NULL),
(3, 'patient@gmail.com', '[\"ROLE_PATIENT\"]', '$2y$13$t9yweGxgIHmwXWWcyxZlOORQEedA6PXe2P8mewVJzpT4Eh0NrHpuq', 'patient', NULL, 3, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `assistant`
--
ALTER TABLE `assistant`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C2997CD1AA08CB10` (`login`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `indisponibilite`
--
ALTER TABLE `indisponibilite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8717036F4F31A84` (`medecin_id`);

--
-- Index pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1BDA53C66C6E55B5` (`nom`),
  ADD UNIQUE KEY `UNIQ_1BDA53C6E05387EF` (`assistant_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1ADAD7EB6C6E55B5` (`nom`);

--
-- Index pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_10C31F864F31A84` (`medecin_id`),
  ADD KEY `IDX_10C31F86F6203804` (`statut_id`),
  ADD KEY `IDX_10C31F866B899279` (`patient_id`);

--
-- Index pour la table `statut`
--
ALTER TABLE `statut`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_8D93D6494F31A84` (`medecin_id`),
  ADD UNIQUE KEY `UNIQ_8D93D6496B899279` (`patient_id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E05387EF` (`assistant_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `assistant`
--
ALTER TABLE `assistant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `indisponibilite`
--
ALTER TABLE `indisponibilite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `medecin`
--
ALTER TABLE `medecin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `rdv`
--
ALTER TABLE `rdv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `statut`
--
ALTER TABLE `statut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `indisponibilite`
--
ALTER TABLE `indisponibilite`
  ADD CONSTRAINT `FK_8717036F4F31A84` FOREIGN KEY (`medecin_id`) REFERENCES `medecin` (`id`);

--
-- Contraintes pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD CONSTRAINT `FK_1BDA53C6E05387EF` FOREIGN KEY (`assistant_id`) REFERENCES `assistant` (`id`);

--
-- Contraintes pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD CONSTRAINT `FK_10C31F864F31A84` FOREIGN KEY (`medecin_id`) REFERENCES `medecin` (`id`),
  ADD CONSTRAINT `FK_10C31F866B899279` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `FK_10C31F86F6203804` FOREIGN KEY (`statut_id`) REFERENCES `statut` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6494F31A84` FOREIGN KEY (`medecin_id`) REFERENCES `medecin` (`id`),
  ADD CONSTRAINT `FK_8D93D6496B899279` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `FK_8D93D649E05387EF` FOREIGN KEY (`assistant_id`) REFERENCES `assistant` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
