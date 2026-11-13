-- 1. Table Utilisateur
CREATE TABLE Utilisateur (
    id_utilisateur NUMBER PRIMARY KEY,
    nom VARCHAR2(100),
    prenom VARCHAR2(100),
    email VARCHAR2(255),
    nb_touites NUMBER DEFAULT 0
);

-- 2. Table Tag
CREATE TABLE Tag (
    id_tag NUMBER PRIMARY KEY,
    libelle VARCHAR2(100),
    description_tag VARCHAR2(500)
);

-- 3. Table Touite
CREATE TABLE Touite (
    id_touite NUMBER PRIMARY KEY,
    texte VARCHAR2(235 CHAR),
    date_publication DATE DEFAULT SYSDATE,
    id_auteur NUMBER,
    note NUMBER DEFAULT 0,
    FOREIGN KEY (id_auteur)
        REFERENCES Utilisateur(id_utilisateur)
);

-- 4. Table Image
CREATE TABLE Image (
    id_image NUMBER PRIMARY KEY,
    chemin_image VARCHAR2(500),
    description_image VARCHAR2(500),
    id_touite NUMBER,
    FOREIGN KEY (id_touite)
        REFERENCES Touite(id_touite)
);

-- 5. Table Touite_Tag
CREATE TABLE Touite_Tag (
    id_touite NUMBER,
    id_tag NUMBER,
    PRIMARY KEY (id_touite, id_tag),
    FOREIGN KEY (id_touite)
        REFERENCES Touite(id_touite),
    FOREIGN KEY (id_tag)
        REFERENCES Tag(id_tag)
);

-- 6. Table Suivi_Utilisateur
CREATE TABLE Suivi_Utilisateur (
    id_suiveur NUMBER,
    id_suivi NUMBER,
    PRIMARY KEY (id_suiveur, id_suivi),
    FOREIGN KEY (id_suiveur)
        REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY (id_suivi)
        REFERENCES Utilisateur(id_utilisateur)
);

-- 7. Table Abonnement_Tag
CREATE TABLE Abonnement_Tag (
    id_utilisateur NUMBER,
    id_tag NUMBER,
    PRIMARY KEY (id_utilisateur, id_tag),
    FOREIGN KEY (id_utilisateur)
        REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY (id_tag)
        REFERENCES Tag(id_tag)
);

-- 8. Table Evaluation_Touite
CREATE TABLE Evaluation_Touite (
    id_utilisateur NUMBER,
    id_touite NUMBER,
    valeur NUMBER(1),
    PRIMARY KEY (id_utilisateur, id_touite),
    FOREIGN KEY (id_utilisateur)
        REFERENCES Utilisateur(id_utilisateur),
    FOREIGN KEY (id_touite)
        REFERENCES Touite(id_touite)
);




