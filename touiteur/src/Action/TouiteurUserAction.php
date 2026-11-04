<?php

namespace iutnc\touiteur\Action;

use iutnc\touiteur\BD\TouiteurRepository;
use iutnc\touiteur\Render\TouitesUserRenderer;

/**
 * Action permettant de regarder les touites d'un utilisateur donnée
 */
class TouiteurUserAction extends ActionAbs{
    public function execute():string{
        // Verifie si l'id est bien present
        if (!isset($_GET['id'])) {
            return "<p>Aucun utilisateur sélectionné.</p>";
        }

        // Verifie l'id de l'util
        $id = filter_var(
            $_GET['id'],
            FILTER_VALIDATE_INT
        );

        if ($id === false || $id <= 0) {
            return "<p>Identifiant invalide.</p>";
        }

        // Recupere tout les touites
        $repository = TouiteurRepository::getInstance();
        $touites = $repository->TouiteSelonUtil($id);

        // Appeler le Renderer
        $renderer = new TouitesUserRenderer();

        return $renderer->render($touites, $id);
    }
}