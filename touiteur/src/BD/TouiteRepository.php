<?php

namespace iutnc\touiteur\BD;

use iutnc\touiteur\touite\Touite;

class TouiteRepository {

    private \PDO $pdo;

    public function __construct() {

        //on recupere la connexion a la base de donnees
        $this->pdo = ConnectionBD::getInstance()->pdo;
    }

    public function save(Touite $touite): void {

        //on prepare la requete SQL
        $sql = "INSERT INTO Touite (texte, id_auteur, note)
                VALUES (:texte, :id_auteur, :note)";

        $requete = $this->pdo->prepare($sql);

        //on execute la requete avec les donnees du touite
        $requete->execute([
            'texte' => $touite->getTexte(),
            'id_auteur' => $touite->getIdAuteur(),
            'note' => $touite->getNote()
        ]);

        //on recupere l'identifiant genere par MySQL
        $id = (int) $this->pdo->lastInsertId();

        $touite->setId($id);
    }
}
