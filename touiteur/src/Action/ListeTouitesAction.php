<?php

namespace iutnc\touiteur\Action;

use iutnc\touiteur\BD\TouiteurRepository;
use iutnc\touiteur\Render\TouiteRender;

class ListeTouitesAction extends ActionAbs{

    public function execute(): string{
        $touite = TouiteurRepository::getInstance()->fonction1();
        $html = "<h2> Les touites </h2> <br>";
        if($touite === []){
            $html .= "Il n'y a pas de touites pour le moment";
            return $html;
        }

        foreach($touite as $t){
            $res = new TouiteRender($t);
            $html .= $res -> versionCourte() . "<br>";
        }
        return $html;
    }
}
