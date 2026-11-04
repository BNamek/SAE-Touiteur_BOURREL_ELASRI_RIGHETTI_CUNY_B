<?php

namespace iutnc\touiteur\Render;

use iutnc\touiteur\Action\TouitesUserAction;

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

        // Titre
        $html = "<h2>Touites de $prenom $nom</h2>";

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
