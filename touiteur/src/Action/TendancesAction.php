<?php

namespace iutnc\touiteur\Action;

use iutnc\touiteur\BD\TouiteurRepository;
use iutnc\touiteur\Render\TendancesRenderer;

class TendancesAction extends ActionAbs{
    public function execute(): string{
        $repository = TouiteurRepository::getInstance();

        $tendances = $repository->getTendances();

        $renderer = new TendancesRenderer($tendances);

        return $renderer->render();
    }
}