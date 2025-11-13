-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 13, 2025 at 10:13 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logistique_agenda`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_device`
--

CREATE TABLE `app_device` (
  `id` bigint UNSIGNED NOT NULL,
  `employe_id` bigint UNSIGNED NOT NULL,
  `device_uuid` varchar(100) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` tinyint UNSIGNED NOT NULL,
  `schedule_mode` enum('PRECISE','SLOT') NOT NULL DEFAULT 'PRECISE',
  `default_order_duration_min` int NOT NULL DEFAULT '60',
  `show_assignments_in_agenda` tinyint(1) NOT NULL DEFAULT '1',
  `show_tours_in_agenda` tinyint(1) NOT NULL DEFAULT '1',
  `truck_count` int UNSIGNED NOT NULL DEFAULT '0',
  `slot_morning_start` time NOT NULL DEFAULT '08:00:00',
  `slot_morning_end` time NOT NULL DEFAULT '12:00:00',
  `slot_afternoon_start` time NOT NULL DEFAULT '13:00:00',
  `slot_afternoon_end` time NOT NULL DEFAULT '17:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `schedule_mode`, `default_order_duration_min`, `show_assignments_in_agenda`, `show_tours_in_agenda`, `truck_count`, `slot_morning_start`, `slot_morning_end`, `slot_afternoon_start`, `slot_afternoon_end`, `updated_at`) VALUES
(1, 'PRECISE', 60, 1, 1, 0, '08:00:00', '12:00:00', '13:00:00', '17:00:00', '2025-11-12 14:35:32');

-- --------------------------------------------------------

--
-- Table structure for table `clock_session`
--

CREATE TABLE `clock_session` (
  `id` bigint UNSIGNED NOT NULL,
  `employe_id` bigint UNSIGNED NOT NULL,
  `clock_in_at` datetime NOT NULL,
  `clock_in_source` enum('APP','WEB','ADMIN','BADGE') NOT NULL DEFAULT 'APP',
  `clock_in_lat` decimal(9,6) DEFAULT NULL,
  `clock_in_lng` decimal(9,6) DEFAULT NULL,
  `clock_out_at` datetime DEFAULT NULL,
  `clock_out_source` enum('APP','WEB','ADMIN','BADGE') DEFAULT NULL,
  `clock_out_lat` decimal(9,6) DEFAULT NULL,
  `clock_out_lng` decimal(9,6) DEFAULT NULL,
  `device_id` bigint UNSIGNED DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE `commande` (
  `id` bigint UNSIGNED NOT NULL,
  `ref_client` varchar(100) DEFAULT NULL,
  `adresse_ligne1` varchar(150) DEFAULT NULL,
  `adresse_ligne2` varchar(150) DEFAULT NULL,
  `code_postal` varchar(20) DEFAULT NULL,
  `ville` varchar(120) DEFAULT NULL,
  `date_livraison` date DEFAULT NULL,
  `start_at` datetime DEFAULT NULL,
  `duration_minutes` int DEFAULT NULL,
  `creneau` enum('AM','PM') DEFAULT NULL,
  `statut` enum('DRAFT','PLANIFIEE','ASSIGNEE','EN_LIVRAISON','LIVREE','ANNULEE') NOT NULL DEFAULT 'DRAFT',
  `livreur_id` bigint UNSIGNED DEFAULT NULL,
  `equipe_id` bigint UNSIGNED DEFAULT NULL,
  `vehicule_id` bigint UNSIGNED DEFAULT NULL,
  `tournee_id` bigint UNSIGNED DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

--
-- Triggers `commande`
--
DELIMITER $$
CREATE TRIGGER `bi_commande_set_defaults` BEFORE INSERT ON `commande` FOR EACH ROW BEGIN
  DECLARE def_duree INT;
  SELECT default_order_duration_min INTO def_duree FROM app_settings WHERE id = 1;
  IF NEW.duration_minutes IS NULL THEN
    SET NEW.duration_minutes = def_duree;
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `bu_commande_set_defaults` BEFORE UPDATE ON `commande` FOR EACH ROW BEGIN
  DECLARE def_duree INT;
  SELECT default_order_duration_min INTO def_duree FROM app_settings WHERE id = 1;
  IF NEW.duration_minutes IS NULL THEN
    SET NEW.duration_minutes = def_duree;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `employe`
--

CREATE TABLE `employe` (
  `id` bigint UNSIGNED NOT NULL,
  `prenom` varchar(80) NOT NULL,
  `nom` varchar(120) NOT NULL,
  `email` varchar(190) DEFAULT NULL,
  `telephone` varchar(40) DEFAULT NULL,
  `role` enum('LIVREUR','PREPARATEUR','ADMIN','MANAGER') NOT NULL DEFAULT 'LIVREUR',
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipe`
--

CREATE TABLE `equipe` (
  `id` bigint UNSIGNED NOT NULL,
  `nom` varchar(120) NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipe_membre`
--

CREATE TABLE `equipe_membre` (
  `id` bigint UNSIGNED NOT NULL,
  `equipe_id` bigint UNSIGNED NOT NULL,
  `employe_id` bigint UNSIGNED NOT NULL,
  `role_dans_equipe` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pv`
--

CREATE TABLE `pv` (
  `id` bigint UNSIGNED NOT NULL,
  `vehicule_id` bigint UNSIGNED NOT NULL,
  `employe_id` bigint UNSIGNED DEFAULT NULL,
  `date_heure` datetime NOT NULL,
  `lieu` varchar(255) DEFAULT NULL,
  `nature` enum('VITESSE','STATIONNEMENT','AUTRE') NOT NULL DEFAULT 'AUTRE',
  `montant` decimal(10,2) DEFAULT NULL,
  `points` tinyint DEFAULT NULL,
  `ref_externe` varchar(100) DEFAULT NULL,
  `statut` enum('NOUVEAU','CONTESTE','A_PAYER','PAYE','CLASSE') NOT NULL DEFAULT 'NOUVEAU',
  `preuve_url` varchar(1024) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tournee`
--

CREATE TABLE `tournee` (
  `id` bigint UNSIGNED NOT NULL,
  `date_tour` date NOT NULL,
  `nom` varchar(120) DEFAULT NULL,
  `driver_id` bigint UNSIGNED DEFAULT NULL,
  `equipe_id` bigint UNSIGNED DEFAULT NULL,
  `vehicule_id` bigint UNSIGNED DEFAULT NULL,
  `statut` enum('PLANIFIEE','EN_COURS','TERMINEE','ANNULEE') NOT NULL DEFAULT 'PLANIFIEE',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tournee_commande`
--

CREATE TABLE `tournee_commande` (
  `id` bigint UNSIGNED NOT NULL,
  `tournee_id` bigint UNSIGNED NOT NULL,
  `commande_id` bigint UNSIGNED NOT NULL,
  `ordre` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicule`
--

CREATE TABLE `vehicule` (
  `id` bigint UNSIGNED NOT NULL,
  `immatriculation` varchar(20) NOT NULL,
  `marque` varchar(80) DEFAULT NULL,
  `modele` varchar(80) DEFAULT NULL,
  `capacite_m3` decimal(6,2) DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_agenda_commandes`
-- (See below for the actual view)
--
CREATE TABLE `v_agenda_commandes` (
`commande_id` bigint unsigned
,`ref_client` varchar(100)
,`statut` enum('DRAFT','PLANIFIEE','ASSIGNEE','EN_LIVRAISON','LIVREE','ANNULEE')
,`livreur_id` bigint unsigned
,`livreur_nom` varchar(201)
,`equipe_id` bigint unsigned
,`equipe_nom` varchar(120)
,`vehicule_id` bigint unsigned
,`vehicule_immat` varchar(20)
,`tournee_id` bigint unsigned
,`date_tour` date
,`event_start` datetime
,`event_end` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_temps_travail`
-- (See below for the actual view)
--
CREATE TABLE `v_temps_travail` (
`id` bigint unsigned
,`employe_id` bigint unsigned
,`duree_min` bigint
);

-- --------------------------------------------------------

--
-- Structure for view `v_agenda_commandes`
--
DROP TABLE IF EXISTS `v_agenda_commandes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_agenda_commandes`  AS SELECT `c`.`id` AS `commande_id`, `c`.`ref_client` AS `ref_client`, `c`.`statut` AS `statut`, `c`.`livreur_id` AS `livreur_id`, concat(`e`.`nom`,' ',`e`.`prenom`) AS `livreur_nom`, `c`.`equipe_id` AS `equipe_id`, `eq`.`nom` AS `equipe_nom`, `c`.`vehicule_id` AS `vehicule_id`, `v`.`immatriculation` AS `vehicule_immat`, `c`.`tournee_id` AS `tournee_id`, `t`.`date_tour` AS `date_tour`, (case when (`c`.`start_at` is not null) then `c`.`start_at` else timestamp(`c`.`date_livraison`,(case `c`.`creneau` when 'AM' then `s`.`slot_morning_start` else `s`.`slot_afternoon_start` end)) end) AS `event_start`, (case when (`c`.`start_at` is not null) then (`c`.`start_at` + interval coalesce(`c`.`duration_minutes`,`s`.`default_order_duration_min`) minute) else timestamp(`c`.`date_livraison`,(case `c`.`creneau` when 'AM' then `s`.`slot_morning_end` else `s`.`slot_afternoon_end` end)) end) AS `event_end` FROM (((((`commande` `c` left join `employe` `e` on((`e`.`id` = `c`.`livreur_id`))) left join `equipe` `eq` on((`eq`.`id` = `c`.`equipe_id`))) left join `vehicule` `v` on((`v`.`id` = `c`.`vehicule_id`))) left join `tournee` `t` on((`t`.`id` = `c`.`tournee_id`))) join `app_settings` `s`) ;

-- --------------------------------------------------------

--
-- Structure for view `v_temps_travail`
--
DROP TABLE IF EXISTS `v_temps_travail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_temps_travail`  AS SELECT `cs`.`id` AS `id`, `cs`.`employe_id` AS `employe_id`, timestampdiff(MINUTE,`cs`.`clock_in_at`,`cs`.`clock_out_at`) AS `duree_min` FROM `clock_session` AS `cs` WHERE (`cs`.`clock_out_at` is not null) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_device`
--
ALTER TABLE `app_device`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_device_uuid` (`device_uuid`),
  ADD KEY `fk_dev_emp` (`employe_id`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clock_session`
--
ALTER TABLE `clock_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_clock_emp` (`employe_id`,`clock_in_at`),
  ADD KEY `fk_clock_dev` (`device_id`);

--
-- Indexes for table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_commande_start` (`start_at`),
  ADD KEY `idx_commande_date` (`date_livraison`,`creneau`),
  ADD KEY `idx_commande_statut` (`statut`),
  ADD KEY `fk_cmd_livreur` (`livreur_id`),
  ADD KEY `fk_cmd_equipe` (`equipe_id`),
  ADD KEY `fk_cmd_veh` (`vehicule_id`),
  ADD KEY `fk_cmd_tour` (`tournee_id`);

--
-- Indexes for table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipe_membre`
--
ALTER TABLE `equipe_membre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_equipe_membre` (`equipe_id`,`employe_id`),
  ADD KEY `fk_em_employe` (`employe_id`);

--
-- Indexes for table `pv`
--
ALTER TABLE `pv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pv_dt` (`date_heure`),
  ADD KEY `idx_pv_veh` (`vehicule_id`),
  ADD KEY `fk_pv_emp` (`employe_id`);

--
-- Indexes for table `tournee`
--
ALTER TABLE `tournee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tournee_date` (`date_tour`),
  ADD KEY `fk_tour_driver` (`driver_id`),
  ADD KEY `fk_tour_equipe` (`equipe_id`),
  ADD KEY `fk_tour_veh` (`vehicule_id`);

--
-- Indexes for table `tournee_commande`
--
ALTER TABLE `tournee_commande`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_tournee_commande` (`tournee_id`,`commande_id`),
  ADD KEY `idx_tour_ordre` (`tournee_id`,`ordre`),
  ADD KEY `fk_tc_cmd` (`commande_id`);

--
-- Indexes for table `vehicule`
--
ALTER TABLE `vehicule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `immatriculation` (`immatriculation`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_device`
--
ALTER TABLE `app_device`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clock_session`
--
ALTER TABLE `clock_session`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employe`
--
ALTER TABLE `employe`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equipe_membre`
--
ALTER TABLE `equipe_membre`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pv`
--
ALTER TABLE `pv`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tournee`
--
ALTER TABLE `tournee`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tournee_commande`
--
ALTER TABLE `tournee_commande`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicule`
--
ALTER TABLE `vehicule`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_device`
--
ALTER TABLE `app_device`
  ADD CONSTRAINT `fk_dev_emp` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `clock_session`
--
ALTER TABLE `clock_session`
  ADD CONSTRAINT `fk_clock_dev` FOREIGN KEY (`device_id`) REFERENCES `app_device` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_clock_emp` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `fk_cmd_equipe` FOREIGN KEY (`equipe_id`) REFERENCES `equipe` (`id`),
  ADD CONSTRAINT `fk_cmd_livreur` FOREIGN KEY (`livreur_id`) REFERENCES `employe` (`id`),
  ADD CONSTRAINT `fk_cmd_tour` FOREIGN KEY (`tournee_id`) REFERENCES `tournee` (`id`),
  ADD CONSTRAINT `fk_cmd_veh` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule` (`id`);

--
-- Constraints for table `equipe_membre`
--
ALTER TABLE `equipe_membre`
  ADD CONSTRAINT `fk_em_employe` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_em_equipe` FOREIGN KEY (`equipe_id`) REFERENCES `equipe` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pv`
--
ALTER TABLE `pv`
  ADD CONSTRAINT `fk_pv_emp` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`id`),
  ADD CONSTRAINT `fk_pv_veh` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule` (`id`);

--
-- Constraints for table `tournee`
--
ALTER TABLE `tournee`
  ADD CONSTRAINT `fk_tour_driver` FOREIGN KEY (`driver_id`) REFERENCES `employe` (`id`),
  ADD CONSTRAINT `fk_tour_equipe` FOREIGN KEY (`equipe_id`) REFERENCES `equipe` (`id`),
  ADD CONSTRAINT `fk_tour_veh` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule` (`id`);

--
-- Constraints for table `tournee_commande`
--
ALTER TABLE `tournee_commande`
  ADD CONSTRAINT `fk_tc_cmd` FOREIGN KEY (`commande_id`) REFERENCES `commande` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tc_tour` FOREIGN KEY (`tournee_id`) REFERENCES `tournee` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
