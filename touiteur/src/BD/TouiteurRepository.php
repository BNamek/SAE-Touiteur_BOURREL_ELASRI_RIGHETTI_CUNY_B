<?php
namespace iutnc\touiteur\BD;

use PDO;

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

    // C'est ici que chacun ajoutera ses méthodes liées à la BD

    // Fonctionnalités 4
    // Affiches les touites d'un utilisateur donnee
    public function TouiteSelonUtil(int $id) : array {
        // Requete sql permettant d'avoir tout les touites selon l'id de l'utilisateur
        $sql = "SELECT t.texte,t.date_publication, u.nom, u.prenom FROM Touite t JOIN Utilisateur u ON t.id_auteur = u.id_utilisateur 
        WHERE t.id_auteur = :id ORDER BY t.date_publication DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $touites = [];

        while ($ligne = $stmt->fetch()) {
            $touites[] = $ligne;
        }

        return $touites;
    }
}