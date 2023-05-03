DROP DATABASE IF EXISTS databaseDAW;
CREATE DATABASE databaseDAW CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;

CREATE TABLE Cours (
    idCours integer AUTO_INCREMENT PRIMARY KEY,
    titre varchar(128) NOT NULL,
    description varchar(256),
    type varchar(64) NOT NULL,
    chemin varchar(128) NOT NULL,
    dateCours DATETIME DEFAULT now()
);

CREATE TABLE Utilisateur (
    login varchar(32) PRIMARY KEY,
    mdpHash varchar(128) NOT NULL,
    nom varchar(128),
    prenom varchar(128),
    email varchar(128) UNIQUE,
    admin boolean NOT NULL
);

CREATE TABLE Topic (
    idTopic integer AUTO_INCREMENT PRIMARY KEY,
    titre varchar(128) NOT NULL,
    idUtilisateur varchar(32) NOT NULL,
    nbReponses integer DEFAULT -1,
    CONSTRAINT fk_idUtilisateur FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur (login) ON DELETE CASCADE
);

CREATE TABLE Message (
    idMessage integer AUTO_INCREMENT PRIMARY KEY,
    idTopic integer NOT NULL,
    idUtilisateur varchar(32) NOT NULL,
    contenu text NOT NULL,
    dateMessage DATETIME DEFAULT now(),
    CONSTRAINT fk_idTopic FOREIGN KEY (idTopic) REFERENCES Topic (idTopic) ON DELETE CASCADE,
    CONSTRAINT fk_idUtilisateur2 FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur (login) ON DELETE CASCADE
);