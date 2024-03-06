DROP DATABASE IF EXISTS accordenergie;  
CREATE DATABASE accordenergie ;
USE accordenergie ; 
DROP TABLE IF EXISTS utilisateur ;
DROP TABLE IF EXISTS statut ;
DROP TABLE IF EXISTS degreurgence ;
DROP TABLE IF EXISTS intervention ;

-- set session sql_mode = 'ONLY_FULL_GROUP_BY';

CREATE TABLE user (
  `user_id` int NOT NULL PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) engine=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE statut (
  `StatutID` int NOT NULL PRIMARY KEY,
  `Type` varchar(50) NOT NULL,
  `Couleur` varchar(15) NOT NULL
) engine=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE degreurgence (
  `DegreUrgenceID` int NOT NULL PRIMARY KEY,
  `Type` varchar(50) NOT NULL,
  `Couleur` varchar(15) NOT NULL
) engine=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE intervention (
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