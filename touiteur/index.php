<?php

require_once 'vendor/autoload.php';

use iutnc\touiteur\BD\ConnectionBD;
use iutnc\touiteur\Dispatch\Dispatcher;
use iutnc\touiteur\Action\DefaultAction;
use iutnc\touiteur\Action\PublieTouiteAction;
use iutnc\touiteur\Action\AbonnementTagAction;

// On charge la configuration de la base de données
ConnectionBD::setConfig('config/db.config.ini');

// On crée le dispatcher et on lui donne les routes
$dispatcher = new Dispatcher();
$dispatcher->addRoute('default', DefaultAction::class);
$dispatcher->addRoute('publie-touite', PublieTouiteAction::class);
$dispatcher->addRoute('abonnement-tag', AbonnementTagAction::class);

// On lance l'action demandée dans l'URL
$dispatcher->run();
