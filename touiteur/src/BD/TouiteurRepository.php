<?php
namespace iutnc\touiteur\BD;

use iutnc\touiteur\touite\Touite;
use PDO;

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
