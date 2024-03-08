DROP DATABASE IF EXISTS accordenergie;  
CREATE DATABASE accordenergie ;
USE accordenergie ; 
DROP TABLE IF EXISTS utilisateur ;
DROP TABLE IF EXISTS statut ;
DROP TABLE IF EXISTS degreurgence ;
DROP TABLE IF EXISTS intervention ;

-- set session sql_mode = 'ONLY_FULL_GROUP_BY';

CREATE TABLE user (
<<<<<<< HEAD
  `user_id` int NOT NULL PRIMARY KEY,
=======
  `user_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
>>>>>>> 2d34e4247d66db562c96b41bd4265b6f960d6120
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
<<<<<<< HEAD
  `user_type` varchar(20) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
=======
  `user_type` varchar(20),
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
>>>>>>> 2d34e4247d66db562c96b41bd4265b6f960d6120
) engine=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE statut (
<<<<<<< HEAD
  `StatutID` int NOT NULL PRIMARY KEY,
  `Type` varchar(50) NOT NULL,
  `Couleur` varchar(15) NOT NULL
) engine=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE degreurgence (
  `DegreUrgenceID` int NOT NULL PRIMARY KEY,
  `Type` varchar(50) NOT NULL,
  `Couleur` varchar(15) NOT NULL
=======
  `status_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `color` varchar(15) NOT NULL
) engine=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE degreurgence (
  `degre_urgence_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `couleur` varchar(15) NOT NULL
>>>>>>> 2d34e4247d66db562c96b41bd4265b6f960d6120
) engine=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE intervention (
<<<<<<< HEAD
  `InterventionID` int NOT NULL PRIMARY KEY,
  `DateIntervention` date NOT NULL,
  `NatureIntervention` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `NumeroEtRue` varchar(100) NOT NULL,
  `ComplementAdresse` varchar(100) NOT NULL,
  `CodePostal` varchar(100) NOT NULL,
  `Ville` varchar(100) NOT NULL,
  `Societe` varchar(100),
  `DegreUrgenceID` int,
  `StatutID` int,
  `UtilisateurID` int,
  `StandardisteID` int,
  `IntervenantID` int,
  
   constraint FK1 foreign key (DegreUrgenceID) references degreurgence(DegreUrgenceID),
   constraint FK2 foreign key (StatutID) references statut(StatutID),
   constraint FK3 foreign key (UtilisateurID) references utilisateur(UtilisateurID),
   constraint FK4 foreign key (StandardisteID) references utilisateur(UtilisateurID),
   constraint FK5 foreign key (IntervenantID) references utilisateur(UtilisateurID)
   
   
) engine=InnoDB DEFAULT CHARSET=latin1;
=======
  `intervention_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `date_intervention` date NOT NULL,
  `nature_intervention` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `street_and_number` varchar(100) NOT NULL,
  `adress_complement` varchar(100) NOT NULL,
  `code_postal` varchar(100) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `societe` varchar(100),
  `degre_urgence_id` int,
  `status_id` int,
  `user_id` int,
  
  
   constraint FK1 foreign key (degre_urgence_id) references degreurgence(degre_urgence_id),
   constraint FK2 foreign key (status_id) references statut(status_id),
   constraint FK3 foreign key (user_id) references user(user_id)
   
   
) engine=InnoDB DEFAULT CHARSET=latin1;
>>>>>>> 2d34e4247d66db562c96b41bd4265b6f960d6120
