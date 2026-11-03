<?php

require_once 'vendor/autoload.php';

use iutnc\touiteur\BD\ConnectionBD;
use iutnc\touiteur\Dispatch\Dispatcher;
use iutnc\touiteur\Action\DefaultAction;

// On charge la configuration de la base de données
ConnectionBD::setConfig('config/db.config.ini');

// On crée le dispatcher et on lui donne les routes
$dispatcher = new Dispatcher();
$dispatcher->addRoute('default', DefaultAction::class);

//on ajoute la route qui permet d'acceder à l'action de publication d'un touite
$dispatcher->addRoute(
    'publier-touite',
    \iutnc\touiteur\action\PublierTouiteAction::class
);

// On lance l'action demandée dans l'URL
$dispatcher->run();