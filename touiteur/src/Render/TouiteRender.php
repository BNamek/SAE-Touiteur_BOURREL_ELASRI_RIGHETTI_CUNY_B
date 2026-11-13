<?php

namespace iutnc\touiteur\Render;

use iutnc\touiteur\touite\Touite;
use iutnc\touiteur\BD\TouiteurRepository;

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
        $tex= preg_replace('/#(\w+)/','<a href="?action=tag&tag=$1">#$1</a>',$tex);
        $prenom = htmlspecialchars($this -> touite -> getprenom());
        $idtouite = htmlspecialchars($this -> touite -> getId());

        $idConnecte = $_SESSION['id_utilisateur'] ?? filter_input(INPUT_GET, 'id_suiveur', FILTER_VALIDATE_INT) ?? 1;
        $repo = TouiteurRepository::getInstance();
        $voteActuel = $repo->getEvaluationTouite($idConnecte, (int)$idtouite);
        $note = method_exists($this->touite, 'getNote') ? $this->touite->getNote() : 0;

        if ($voteActuel === 1) {
            $boutonsVote = "<a class='btn-vote btn-like-active' href='?action=evaluer-touite&id={$idtouite}&type=like' title='Annuler mon like'>👍</a>";
        } elseif ($voteActuel === -1) {
            $boutonsVote = "<a class='btn-vote btn-dislike-active' href='?action=evaluer-touite&id={$idtouite}&type=dislike' title='Annuler mon dislike'>👎</a>";
        } else {
            $boutonsVote = "
                <a class='btn-vote btn-like' href='?action=evaluer-touite&id={$idtouite}&type=like' title='J aime'>👍</a>
                <a class='btn-vote btn-dislike' href='?action=evaluer-touite&id={$idtouite}&type=dislike' title='Je n aime pas'>👎</a>
            ";
        }
        
        $res = "<div class='touite'>
            <p class='pn'><a href='?action=touites-user&id=$aut'>$nom $prenom</a></p>
            <p class='date'>$dat</p>
            <p class='texte'>$tex</p>
            <div style='display: flex; align-items: center; justify-content: space-between; margin-top: 8px;'>
                <a href='?action=detail-touite&id=$idtouite'>Voir le détail</a>
                <div style='display: flex; align-items: center; gap: 8px;'>
                    <span style='font-size: 13px; font-weight: 700;'>$note note</span>
                    $boutonsVote
                </div>
            </div>
        </div>";

        return $res;
    }

}
