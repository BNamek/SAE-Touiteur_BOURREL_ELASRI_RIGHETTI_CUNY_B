<?php

namespace iutnc\touiteur\Action;

use iutnc\touiteur\BD\TouiteurRepository;
use iutnc\touiteur\Render\TouiteRender;

class ListeTouitesAction extends ActionAbs{

    public function execute(): string{
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }else{
            $page = 1;
        }
        $page_valide = filter_var($page,FILTER_VALIDATE_INT);

        if($page_valide === false ||$page_valide === null || $page<=0){
            $page = 1;
        }

        $touite = TouiteurRepository::getInstance()->fonction1();
        $html = "<h2> Les touites </h2> <br>";
        if($touite === []){
            $html .= "Il n'y a pas de touites pour le moment";
            return $html;
        }

        $totaleTouite = count($touite);
        //Ceil qui arrondis a l'entier supérieur pour avoir 4 page si le résultat est 3,2
        $nbPage = (int) ceil($totaleTouite/10);

        //On fais -1 pour commencer au bonne endroit au tableau c'est a dire que sur la page on commencera a 0, page 2 a 10 et on continue pour toute les pages
        $debut = ($page-1) * 10;

        //On coupe le tableau touite a la position de debut jusqu'a 10 valeur plus loin
        $touitePage = array_slice($touite,$debut,10);

        foreach($touitePage as $t){
            $res = new TouiteRender($t);
            $html .= $res -> versionCourte() . "<br>";
        }

        if($page > 1){
            $precedent = $page - 1;
            $html .= "<a href=?action=touites&page=$precedent>Precedent</a> ";
        }

        $html .= "Page $page sur $nbPage";

        if($page < $nbPage){
            $suivant = $page+ 1;
            $html .= " <a href=?action=touites&page=$suivant>Suivant</a>";
        }
        return $html;
    }
}
