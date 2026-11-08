<?php

namespace iutnc\touiteur\Action;

use iutnc\touiteur\BD\TouiteurRepository;
use iutnc\touiteur\Render\TouiteRender;

class ListeTouiteTagAction extends ActionAbs{

    public function execute(): string{

        if(!isset($_GET['tag'])){
            return "<h2>Le tag ne dois pas etre vide</h2>";
        }

        //On met trim pour supprimer les espaces
        $mot = trim($_GET['tag']);

        $mot = strtoupper($mot);
        $tag = '#'.$mot;


        $touiteTag = TouiteurRepository::getInstance()->getTouitesParTag($tag);
        $html = "<h2> Les touites avec le tag : ".htmlspecialchars($tag)."</h2> <br>";
        if($touiteTag === []){
            $html .= "Il n'y a pas de touites contenant ce tag : ".htmlspecialchars($tag)." pour le moment";
            return $html;
        }

        foreach($touiteTag as $t){
            $res = new TouiteRender($t);
            $html .= $res -> versionCourte() . "<br>";
        }
        return $html;

    }
}
