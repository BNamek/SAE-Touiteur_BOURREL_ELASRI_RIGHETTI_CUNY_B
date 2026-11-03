<?php
namespace iutnc\touiteur\dispatch;

class Dispatcher{
    private $action;
    private array $route;

    public function __construct(){
        //On crée un tableau vide qui ne contient aucune route
        $this -> route = [];
        //Si il n'y a rien dans le query alors on met la route par défaut qui est default
        if(!isset($_GET['action'])){
            $this -> action = 'default';
        }else{
            $this -> action = $_GET['action'];
        }
    }

    //Methode qui lance l'action qui vas se produire selon la classe
    public function run():void{
        //Si l'action dans le tableau existe et qu'il a une route vers sa classe crée
        if(array_key_exists($this -> action,$this -> route)){
            //On le stock dans une variable
            $obj = $this ->route[$this->action];
            //Dans une autre variable on stock l'objet qui vien d'etre crée on pourras donc utiliser sa méthode
            $r = new $obj();
            //C'est une action alors on peut appeller sa méthode execute
            $r = $r ->execute();
            //On affiche la suite de la page pour réaliser les autres actions
            $this -> renderPage($r);
        }else{
            echo 'La valeur du query n est pas la bonne ou n existe pas';
        }
    }

    //Fonction qui permet d'ajouter une route dans le tableau avec son nom qu'il dois avoir dans le query et sa classe
    public function addRoute(string $action, string $class): self{
        $this -> route[$action] = $class;
        return $this;
    }

    //La fonction renderPage vas afficher la suite de la page html
    //Le parametre html c'est donc le execute qu'on vas afficher
    private function renderPage(string $html):void{
        echo '<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Touiteur</title>

        </head>
        <body>
        <h1>Touiteur</h1>
        <br>
        <a href="?action=default">Acceuil</a>
        <br>
        <a href="?action=publish-touite">Publier un touite</a>
        <br>
        <a href="?action=add-user">Se connecter</a>
        <br>'.$html.'</body> </html>';
    }
}
