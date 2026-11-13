<?php

namespace iutnc\touiteur\Render;

use iutnc\touiteur\Action\TouitesUserAction;
use iutnc\touiteur\BD\TouiteurRepository;

class TouitesUserRenderer{
    public function render(array $touites, int $idUtilisateur): string{
        if (empty($touites)) {
            return "<p>Aucun touite trouvé pour cet utilisateur.</p>";
        }

        // recupere le nom prenom de l'utilisateur
        $nom = filter_var(
            $touites[0]['nom'],
            FILTER_SANITIZE_SPECIAL_CHARS
        );

        $prenom = filter_var(
            $touites[0]['prenom'],
            FILTER_SANITIZE_SPECIAL_CHARS
        );

        $idConnecte = $_SESSION['id_utilisateur'] ?? filter_input(INPUT_GET, 'id_suiveur', FILTER_VALIDATE_INT) ?? 1;
        $repo = TouiteurRepository::getInstance();
        $boutonSuivi = "";

        if ($idConnecte !== $idUtilisateur) {
            $estAbonne = $repo->estAbonneUtilisateur($idConnecte, $idUtilisateur);
            $texte = $estAbonne ? "Ne plus suivre" : "Suivre";
            $classe = $estAbonne ? "badge-unfollow" : "badge-follow";
            $boutonSuivi = " <a class='{$classe}' href='?action=suivre-utilisateur&id_suivi={$idUtilisateur}'>{$texte}</a>";
        }

        // Titre
        $html = "<div style='display:flex; justify-content:space-between; align-items:center; padding:10px 0;'><h2>Touites de $prenom $nom</h2><div>$boutonSuivi</div></div>";

        // Bouton permettant d'acceder au mur de l'util
        $html .= "<a href='?action=mur&id={$idUtilisateur}' class='mur-button'>
            Voir son mur
          </a>";

        // Afficher les touites
        foreach ($touites as $touite) {
            $texte = filter_var(
                $touite['texte'],
                FILTER_SANITIZE_SPECIAL_CHARS
            );
            $date = filter_var(
                $touite['date_publication'],
                FILTER_SANITIZE_SPECIAL_CHARS
            );
            $html .= "
                <article>
                    <p>$texte</p>
                    <small>$date</small>
                    <hr>
                </article>
            ";
        }
        return $html;
    }
}
