DROP DATABASE IF EXISTS accordenergie;  
CREATE DATABASE accordenergie ;
USE accordenergie ; 
DROP TABLE IF EXISTS utilisateur ;
DROP TABLE IF EXISTS statut ;
DROP TABLE IF EXISTS degreurgence ;
DROP TABLE IF EXISTS intervention ;

-- set session sql_mode = 'ONLY_FULL_GROUP_BY';

CREATE TABLE user (
  `user_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `user_type` varchar(20),
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) engine=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE statut (
  `status_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `color` varchar(15) NOT NULL
) engine=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE degreurgence (
  `degre_urgence_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `couleur` varchar(15) NOT NULL
) engine=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE intervention (
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
