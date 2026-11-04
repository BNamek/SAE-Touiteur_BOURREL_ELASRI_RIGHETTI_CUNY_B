<?php
namespace iutnc\touiteur\BD;

use PDO;
use iutnc\touiteur\touite\Touite;

class TouiteurRepository {

    private PDO $pdo;
    private static ?TouiteurRepository $instance = null;

    private function __construct() {
        // Récupère l'objet PDO via notre classe ConnectionBD existante
        $this->pdo = ConnectionBD::getInstance() -> pdo;
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

        // Ca lance la requete avec l'id en param
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        //
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $touites = [];

        while ($ligne = $stmt->fetch()) {
            $touites[] = $ligne;
        }

        return $touites;
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


}
    //Premiere fonctionaliter
    public function fonction1():array{
        $requete = "select t.texte,t.id_touite,t.date_publication,t.id_auteur from touite t
        order by t.date_publication desc";

        //On met prepare pour éviter l'injection sql, donc faire des requetes préparée
        $rq = $this -> pdo -> prepare($requete);
        //On execute ensuite la requete
        $rq -> execute();

        //On crée un tableau vide pour stocker les touite
        $res = [];

        //On stock les valeurs dans un tableau associatif
        while($ligne = $rq -> fetch(PDO::FETCH_ASSOC)){
            $t = new Touite($ligne['texte'],$ligne['id_touite'],$ligne['date_publication'],$ligne['id_auteur']);
            $res []= $t;
        }

        return $res;

    }
}
