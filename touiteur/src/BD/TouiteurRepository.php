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
        $sql = "INSERT INTO Touite (texte, date_publication, id_auteur, note) 
                VALUES (:texte, :date_publication, :auteur, :note)";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':texte'            => $t->getTexte(),
            ':date_publication' => $t->getDatePublication(),
            ':auteur'           => $t->getIdAuteur(),
            ':note'             => $t->getNote()
        ]);

        $id = (int)$this->pdo->lastInsertId();
        $t->setId($id);
        return $id;
    }

    public function estAbonneTag(int $idUser, int $idTag): bool {
        $sql = "SELECT COUNT(*) FROM Abonnement_Tag
                WHERE id_utilisateur = :user AND id_tag = :tag";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user' => $idUser,
            ':tag'  => $idTag
        ]);

        return (int)$stmt->fetchColumn() > 0;
    }

    public function abonnerTag(int $idUser, int $idTag): void{
        $sql = "INSERT INTO Abonnement_Tag (id_utilisateur, id_tag)
                VALUES (:user, :tag)"; 
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user' => $idUser,
            ':tag'  => $idTag
        ]);
    }

    public function desabonnerTag(int $idUser, int $idTag): void{
        $sql = "DELETE FROM Abonnement_Tag
                WHERE id_utilisateur = :user 
                AND id_tag = :tag";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user' => $idUser,
            ':tag'  => $idTag
        ]);
    }


}