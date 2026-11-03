<?php
namespace iutnc\touiteur\BD;

use PDO;
use iutnc\touiteur\touite\Touite;

class TouiteurRepository {

    private PDO $pdo;
    private static ?TouiteurRepository $instance = null;

    private function __construct() {
        // Récupère l'objet PDO via notre classe ConnectionBD existante
        $this->pdo = ConnectionBD::getInstance()->pdo;
    }

    public static function getInstance(): TouiteurRepository {
        if (self::$instance === null) {
            self::$instance = new TouiteurRepository();
        }
        return self::$instance;
    }

    // Méthodes liées à la BD
    
    public function insertTouite(Touite $t): int {
        $sql = "INSERT INTO Touite (texte, id_auteur, date_publi, note) VALUES (:texte, :auteur, :date_publi, :note)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':texte'      => $t->getTexte(),
            ':auteur'     => $t->getIdAuteur(),
            ':date_publi' => $t->getDatePublication(),
            ':note'       => $t->getNote()
        ]);

        $id = (int)$this->pdo->lastInsertId();
        $t->setId($id);
        return $id;
    }


}