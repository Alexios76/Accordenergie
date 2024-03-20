DROP DATABASE IF EXISTS accordenergie;  
CREATE DATABASE accordenergie ;
USE accordenergie ; 
DROP TABLE IF EXISTS utilisateur ;
DROP TABLE IF EXISTS statut ;
DROP TABLE IF EXISTS degreurgence ;
DROP TABLE IF EXISTS intervention ;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accordenergie`
--

-- --------------------------------------------------------

--
-- Table structure for table `degreurgence`
--

CREATE TABLE `degreurgence` (
  `degre_urgence_id` int NOT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `degreurgence`
--

INSERT INTO `degreurgence` (`degre_urgence_id`, `type`) VALUES
(1, 'img/1.png'),
(2, 'img/2.png'),
(3, 'img/3.png'),
(4, 'img/4.png');

-- --------------------------------------------------------

--
-- Table structure for table `intervention`
--

CREATE TABLE `intervention` (
  `intervention_id` int NOT NULL,
  `date_intervention` date NOT NULL,
  `nature_intervention` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `street_and_number` varchar(100) NOT NULL,
  `adress_complement` varchar(100) NOT NULL,
  `code_postal` varchar(100) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `societe` varchar(100) DEFAULT NULL,
  `degre_urgence_id` int DEFAULT NULL,
  `status_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `id_intervenant` int DEFAULT NULL,
  `id_standardiste` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `intervention`
--

INSERT INTO `intervention` (`intervention_id`, `date_intervention`, `nature_intervention`, `description`, `street_and_number`, `adress_complement`, `code_postal`, `ville`, `societe`, `degre_urgence_id`, `status_id`, `user_id`, `id_intervenant`, `id_standardiste`) VALUES
(6, '2024-03-19', 'Alerte Incendie', 'Fuite d\'eau  !\r\n', '17 rue saint hubert', '', '77500', 'Chelles', 'ff', 4, 4, 12, 13, 19),
(12, '2024-03-22', 'Test Deau', 'tetre', '3', '', '44', 'rff', '', 1, 5, 21, 13, 19),
(13, '2024-03-23', 'Problème electrique dans le salon', 'Prises électriques défectueuses dans le salon, risque potentiel d\'incendie.', '456 Avenue du Soleil', '', '31000', 'Toulouse', '', 3, 1, 21, 13, 19),
(14, '2024-03-28', 'Fuite de gaz', 'Odeur de gaz détectée dans la salle de bain, nécessite une vérification et une réparation urgente ', '789 Rue des Iris', '', '13001', 'Marseille', '', 3, 3, 12, 21, 19),
(15, '2024-04-19', 'Fuite d\'eau', 'Fuite importante observée sous le lavabo de la salle de bain, risque d\'endommager le plancher\r\n\r\n', '1010 Rue des Orchidées', '', '44000', 'Nantes', '', 2, 3, 12, 18, 19);

-- --------------------------------------------------------

--
-- Table structure for table `statut`
--

CREATE TABLE `statut` (
  `status_id` int NOT NULL,
  `type` enum('en attente','en cours','validee','annuler','cloturer') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `statut`
--

INSERT INTO `statut` (`status_id`, `type`) VALUES
(1, 'en attente'),
(2, 'en cours'),
(3, 'validee'),
(4, 'cloturer'),
(5, 'annuler');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `user_type` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `surname`, `password`, `email`, `phone_number`, `user_type`, `created_at`, `updated_at`) VALUES
(9, 'Bassil', 'Tony', '$2y$10$dWgTqpNTtmhxV1Ft5si1C.JbtSk4n1g7iAHEdEIRFSyee/ZmZnBdy', 'tony@gmail.com', '0758623514', 'admin', '2024-03-06 09:58:39', '2024-03-14 17:42:56'),
(12, 'Duboiss', 'Valentino', '$2y$10$337./jv3rGgKAYMz1WMhI.HFCHBfGSOcSL33YmwJBPZjav4U94gTG', 'valentin@gmail.com', '0658568512', 'client', '2024-03-07 10:25:05', '2024-03-19 20:43:05'),
(13, 'Bassils', 'Samuel', '$2y$10$6QdDPm6huvnsiXxHan/dAuzoFtGAE6MobnMmnMTLKAXdZ7COa9.GS', 'samuel@gmail.com', '0752653514', 'intervenant', '2024-03-07 17:29:58', '2024-03-20 07:47:23'),
(18, 'Charpentier', 'Martin', '$2y$10$/7GkLj6VYVOO6Wfz0njLKust7e2EKDbEqq30FyW7MVzIiseXTk8n.', 'martin@gmail.com', '0625318495', 'intervenant', '2024-03-13 14:35:30', '2024-03-17 14:55:51'),
(19, 'Brousse', 'Gabriel', '$2y$10$M3subXU38YfvAR5S5tEKyufuI0JoE7nPNbk8eyzAAUa5mj.xD2kba', 'gabriel@gmail.com', '0776328273', 'standardiste', '2024-03-14 12:43:14', '2024-03-17 14:55:44'),
(20, 'Claude', 'Dupont', '$2y$10$NaPPekm.5uqDhqo72M/oXeRU3n64bxSKs6logsG9GshSds/zWdfGK', 'claude@gmail.com', '0782923232', 'standardiste', '2024-03-14 12:44:17', '2024-03-14 12:44:28'),
(21, 'Thomas', 'Lefeve', '$2y$10$n9WK3qojAByMzOQd2FuLtuv1jwsyDAnphMGvYlgXLCFCD5HoIVDyG', 'thomas@gmail.com', '06273282327', 'client', '2024-03-14 12:45:13', '2024-03-14 12:45:13'),
(22, 'admin', 'admin', '$2y$10$dQHq22y1rOIQh8H5ehzoE.xsVe9HtVbTqt3IRIwCODOCTwvL73Ita', 'admin@admin.com', '000000000', 'admin', '2024-03-15 14:10:44', '2024-03-15 14:11:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `degreurgence`
--
ALTER TABLE `degreurgence`
  ADD PRIMARY KEY (`degre_urgence_id`);

--
-- Indexes for table `intervention`
--
ALTER TABLE `intervention`
  ADD PRIMARY KEY (`intervention_id`),
  ADD KEY `FK3` (`user_id`),
  ADD KEY `FK4` (`id_intervenant`),
  ADD KEY `FK5` (`id_standardiste`),
  ADD KEY `FK2` (`status_id`),
  ADD KEY `FK1` (`degre_urgence_id`);

--
-- Indexes for table `statut`
--
ALTER TABLE `statut`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `degreurgence`
--
ALTER TABLE `degreurgence`
  MODIFY `degre_urgence_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `intervention`
--
ALTER TABLE `intervention`
  MODIFY `intervention_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `statut`
--
ALTER TABLE `statut`
  MODIFY `status_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `intervention`
--
ALTER TABLE `intervention`
  ADD CONSTRAINT `FK3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK4` FOREIGN KEY (`id_intervenant`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK5` FOREIGN KEY (`id_standardiste`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK_degre_urgence_id` FOREIGN KEY (`degre_urgence_id`) REFERENCES `degreurgence` (`degre_urgence_id`),
  ADD CONSTRAINT `FK_status_id` FOREIGN KEY (`status_id`) REFERENCES `statut` (`status_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
