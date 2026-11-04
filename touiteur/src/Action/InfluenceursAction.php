<?php

namespace iutnc\touiteur\Action;

use iutnc\touiteur\BD\TouiteurRepository;
use iutnc\touiteur\Render\InfluenceursRenderer;

/**
 * Action permettant de voir les top 5 influenceurs
 */
class InfluenceursAction extends ActionAbs{
    public function execute(): string{
        // Recuperation des influenceurs depuis la bdd
        $repo = TouiteurRepository::getInstance();
        $influenceurs = $repo->getInfluenceurs();

        // Envoie au renderer pour l'affichage
        $renderer = new InfluenceursRenderer($influenceurs);

        return $renderer->render();
    }
}
