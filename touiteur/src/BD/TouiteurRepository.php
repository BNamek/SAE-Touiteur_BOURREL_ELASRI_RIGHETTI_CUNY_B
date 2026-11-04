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

    
    public function fonction1(): array {

        $requete = "SELECT
                        t.texte,
                        t.id_touite,
                        t.date_publication,
                        t.id_auteur,
                        u.nom,
                        u.prenom
                    FROM touite t
                    INNER JOIN utilisateur u
                        ON t.id_auteur = u.id_utilisateur
                    ORDER BY t.date_publication DESC";

        $rq = $this->pdo->prepare($requete);
        $rq->execute();

        $res = [];

        while ($ligne = $rq->fetch(PDO::FETCH_ASSOC)) {$t = new Touite($ligne['texte'], (int) $ligne['id_auteur'], $ligne['date_publication'], 0, (int) $ligne['id_touite']);

            $t->setNom($ligne['nom']);
            $t->setPrenom($ligne['prenom']);

            $res[] = $t;
        }

        return $res;
    }

    public function getTouiteDetail(int $idTouite): ?array{
        $sql = "SELECT t.id_touite, t.texte, t.date_publication, t.note, u.id_utilisateur, u.nom, u.prenom
                FROM Touite t
                JOIN Utilisateur u ON t.id_auteur = u.id_utilisateur
                WHERE t.id_touite = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $idTouite
        ]);

        $res = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $res ?: null;
    }

    public function getInfluenceurs() : array{
        $sql = "SELECT u.id_utilisateur, u.nom, u.prenom, COUNT(s.id_suiveur) AS nb_abonnes FROM Utilisateur u 
        LEFT JOIN Suivi_Utilisateur s ON u.id_utilisateur = s.id_suivi 
        GROUP BY u.id_utilisateur, u.nom, u.prenom ORDER BY nb_abonnes DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
