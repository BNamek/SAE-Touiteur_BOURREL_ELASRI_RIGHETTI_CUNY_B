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
        $nom = htmlspecialchars($this -> touite -> getNom());
        $prenom = htmlspecialchars($this -> touite -> getPrenom());
        $tex= preg_replace('/#(\w+)/','<a href="?action=touites-tag&tag=$1">#$1</a>',$tex);
        $prenom = htmlspecialchars($this -> touite -> getprenom());
        $idtouite = htmlspecialchars($this -> touite -> getId());

        $res = "<div class='touite'>
            <p class='pn'><a href='?action=touites-user&id=$aut'>$nom $prenom</a></p>
            <p class='date'>$dat</p>
            <p class='texte'>$tex</p>
            <a href='?action=detail-touite&id=$idtouite'>Voir le détail</a>
        </div>";

        return $res;
    }

}
