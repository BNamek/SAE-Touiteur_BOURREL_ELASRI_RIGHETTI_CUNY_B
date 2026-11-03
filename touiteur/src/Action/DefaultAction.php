<?php
namespace iutnc\touiteur\action;

use iutnc\touiteur\action\ActionAbs;

class DefaultAction extends ActionAbs{

    //Cette méthode retourne un String qui est l'action par défaut que l'application vas faire
    public function execute():string{
        return "<!DOCTYPE html>
        <html lang='fr'>
          <head>
            <meta charset='UTF-8'>
            <title>Touiteur</title>
          </head>
          <body>
            <h1>Bienvenue sur Touiteur</h1>
          </body>
        </html>";
    }
}
