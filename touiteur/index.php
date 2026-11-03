<?php

require_once 'vendor/autoload.php';

use iutnc\touiteur\BD\ConnectionBD;
use iutnc\touiteur\Dispatch\Dispatcher;
use iutnc\touiteur\Action\DefaultAction;
use iutnc\touiteur\Action\TouiteurUserAction;

// Configuration de la base
ConnectionBD::setConfig('config/db.config.ini');

// Création du Dispatcher
$dispatcher = new Dispatcher();

$dispatcher->addRoute('default', DefaultAction::class);
// Route de la fonctionnalites 4
$dispatcher->addRoute('touites-user', TouiteurUserAction::class);

$dispatcher->run();
