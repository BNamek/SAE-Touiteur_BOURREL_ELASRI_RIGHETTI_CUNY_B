<?php

require_once 'vendor/autoload.php';

use iutnc\touiteur\BD\ConnectionBD;
use iutnc\touiteur\Dispatch\Dispatcher;
use iutnc\touiteur\Action\DefaultAction;
use iutnc\touiteur\Action\TouiteurUserAction;
use iutnc\touiteur\Action\PublieTouiteAction;
use iutnc\touiteur\Action\AbonnementTagAction;
use iutnc\touiteur\Action\ListeTouitesAction;
use iutnc\touiteur\Action\DetailTouiteAction;
use iutnc\touiteur\Action\ListeTouiteTagAction;

// Configuration de la base
ConnectionBD::setConfig('config/db.config.ini');

// Création du Dispatcher
$dispatcher = new Dispatcher();

$dispatcher->addRoute('default', DefaultAction::class);
// Route de la fonctionnalites 4
$dispatcher->addRoute('touites-user', TouiteurUserAction::class);
$dispatcher->addRoute('publie-touite', PublieTouiteAction::class);
$dispatcher->addRoute('abonnement-tag', AbonnementTagAction::class);
$dispatcher->addRoute('touites',ListeTouitesAction::class);
$dispatcher->addRoute('detail-touite', DetailTouiteAction::class);
$dispatcher->addRoute('tag', ListeTouiteTagAction::class);

// On lance l'action demandée dans l'URL
$dispatcher->run();
