<?php

namespace iutnc\touiteur\Render;

use iutnc\touiteur\touite\Touite;

class TouiteRender{
    private Touite $touite;

    public function __construct(Touite $t){
        $this -> touite = $t;
    }

    public function versionCourte():string{
        $aut = htmlspecialchars($this -> touite -> getIdAuteur());
        $tex = htmlspecialchars($this -> touite -> getTexte());
        $dat = htmlspecialchars($this -> touite -> getDatePublication());

        $res = "<div class='touite'>
            <p class='auteur'><a href='?action=touites-auteur&id=...'>$aut</a></p>
            <p class='date'>$dat</p>
            <p class='texte'>$tex</p>
            <a href='?action=detail&id=...'>Voir le détail</a>
        </div>";

        return $res;
    }

}
