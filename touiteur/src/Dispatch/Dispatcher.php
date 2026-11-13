<?php
namespace iutnc\touiteur\Dispatch;

use iutnc\touiteur\Action\InfluenceursAction;
use iutnc\touiteur\Action\TendancesAction;

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
    
    private function renderPage(string $html): void{
        $actionInfluenceurs = new InfluenceursAction();
        $htmlInfluenceurs = $actionInfluenceurs->execute();

        $actionTendances = new TendancesAction();
        $htmlTendances = $actionTendances->execute();
        $title = match ($this->action) {
            'touites' => 'Fil d’actualité',
            'publie-touite' => 'Publier un touite',
            'touites-user' => 'Profil utilisateur',
            'abonnement-tag' => 'Abonnements',
            default => 'Accueil'
        };

        echo <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                content="width=device-width, initial-scale=1.0">
            <title>Touiteur</title>
            <link rel="stylesheet" href="css/style.css">
        </head>

        <body>
            <div class="twitter-layout">

                <!-- NAVIGATION GAUCHE -->
                <aside class="sidebar">
                    <a class="logo" href="?action=default">
                        <span class="logo-symbol">✦</span>
                        <span>Touiteur</span>
                    </a>

                    <nav class="menu">
                        <a href="?action=default">
                            <span class="menu-icon">⌂</span>
                            Accueil
                        </a>

                        <a href="?action=publie-touite">
                            <span class="menu-icon">✎</span>
                            Nouveau touite
                        </a>
                    </nav>

                    <a href="?action=publie-touite"
                    class="tweet-button">
                        Publier
                    </a>

                    <div class="sidebar-bottom">
                        <div class="profile-avatar">T</div>
                        <div>
                            <strong>Touiteur</strong>
                            <span>@touiteur</span>
                        </div>
                    </div>
                </aside>

                <!-- CONTENU CENTRAL -->
                <main class="timeline">
                    <header class="timeline-header">
                        <h1>{$title}</h1>
                    </header>

                    <section class="timeline-content">
                        {$html}
                    </section>
                </main>

                <!-- COLONNE DROITE -->
                <aside class="right-sidebar">
                    $htmlInfluenceurs


                    $htmlTendances
                    <div class="search-display">
                        ⌕ &nbsp; Découvrir Touiteur
                    </div>


                    <div class="right-card">
                        <h2>À découvrir</h2>

                        <a href="?action=touites"
                        class="right-link">
                            <span>Publications</span>
                            <strong>Voir les touites</strong>
                        </a>
                    </div>

                    <p class="right-footer">
                        Touiteur.app · SAE BUT Informatique
                    </p>
                </aside>

            </div>
        </body>
        </html>
        HTML;
    }

}
