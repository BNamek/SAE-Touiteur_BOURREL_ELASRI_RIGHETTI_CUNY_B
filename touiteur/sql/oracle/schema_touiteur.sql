--1. Table Utilisateur

CREATE TABLE Utilisateur (
    id_utilisateur NUMBER PRIMARY KEY,
    nom VARCHAR2(100) NOT NULL,
    prenom VARCHAR2(100) NOT NULL,
    email VARCHAR2(255) NOT NULL UNIQUE,
    nb_touites NUMBER DEFAULT 0 NOT NULL,
    CHECK (nb_touites >= 0)
);

--2. Table Tag

CREATE TABLE Tag (
    id_tag NUMBER PRIMARY KEY,
    libelle VARCHAR2(100) NOT NULL UNIQUE,
    description_tag VARCHAR2(500)
);

--3. Table Touite

CREATE TABLE Touite (
    id_touite NUMBER PRIMARY KEY,
    texte VARCHAR2(235) NOT NULL,
    date_publication DATE DEFAULT SYSDATE NOT NULL,
    id_auteur NUMBER NOT NULL,
    FOREIGN KEY (id_auteur) REFERENCES Utilisateur(id_utilisateur)
);

--4. Table Image (un touite a 0 ou 1 image)

CREATE TABLE Image (
    id_image NUMBER PRIMARY KEY,
    chemin_image VARCHAR2(500) NOT NULL,
    description_image VARCHAR2(500),
    id_touite NUMBER NOT NULL UNIQUE,
    FOREIGN KEY (id_touite) REFERENCES Touite(id_touite)
);

--5. Table Touite_Tag

CREATE TABLE Touite_Tag (
    id_touite NUMBER NOT NULL,
    id_tag NUMBER NOT NULL,
    PRIMARY KEY (id_touite, id_tag),
    FOREIGN KEY (id_touite) REFERENCES Touite(id_touite),
    FOREIGN KEY (id_tag) REFERENCES Tag(id_tag)
);

--6. Table Suivi_Utilisateur

CREATE TABLE Suivi_Utilisateur (
    id_suiveur NUMBER NOT NULL,
    id_suivi NUMBER NOT NULL,
    PRIMARY KEY (id_suiveur, id_suivi),
    FOREIGN KEY (id_suiveur) REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY (id_suivi) REFERENCES Utilisateur(id_utilisateur)
);

--7. Table Abonnement_Tag

CREATE TABLE Abonnement_Tag (
    id_utilisateur NUMBER NOT NULL,
    id_tag NUMBER NOT NULL,
    PRIMARY KEY (id_utilisateur, id_tag),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY (id_tag) REFERENCES Tag(id_tag)
);

--à ajouter 

ALTER TABLE Touite ADD note NUMBER DEFAULT 0 NOT NULL; 
