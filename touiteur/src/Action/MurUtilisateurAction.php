<?php

namespace iutnc\touiteur\Action;

use iutnc\touiteur\BD\TouiteurRepository;
use iutnc\touiteur\Render\TouiteRender;

class MurUtilisateurAction extends ActionAbs{
    public function execute():string{
        // Recuperation de l'identifiant de l'utilisateur dans l'URL
        $idUtilisateur = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        // Verification de la validite de l'identifiant
        if ($idUtilisateur === false || $idUtilisateur === null || $idUtilisateur <= 0) {
            return "<p>Identifiant utilisateur invalide.</p>";
        }

        // r2cuperation des touites du mur depuis le Repository
        $repository = TouiteurRepository::getInstance();
        $touites = $repository->getMurUtil($idUtilisateur);

        $html = "<h2>Mur de l'utilisateur</h2>";

        // Verification de la presence de touites
        if (empty($touites)) {
            return $html . "<p>Aucun touite à afficher sur ce mur.</p>";
        }

        // Affichage des touites avec le Renderer existant
        foreach ($touites as $touite) {
            $renderer = new TouiteRender($touite);
            $html .= $renderer->versionCourte();
        }

        return $html;
    }
}