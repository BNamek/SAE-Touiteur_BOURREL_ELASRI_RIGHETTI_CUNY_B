<?php
namespace iutnc\touiteur\Action;

use iutnc\touiteur\action\ActionAbs;

class DefaultAction extends ActionAbs{

    //Cette méthode retourne un String qui est l'action par défaut que l'application vas faire
    public function execute():string{
        return "
            <h1>Bienvenue sur Touiteur</h1>";
    }
}
