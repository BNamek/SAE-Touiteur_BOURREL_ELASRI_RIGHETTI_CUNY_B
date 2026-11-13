<?php

namespace iutnc\touiteur\Render;

class InfluenceursRenderer{
    private array $influenceurs;

    public function __construct(array $influenceurs){
        $this->influenceurs = $influenceurs;
    }

    public function render(): string{
        /**
         * Creattion du bloc contenant les 5 influenceurs
         */
        $html = "<div class='right-card influenceurs-card'>";
        $html .= "<h2>Top 5 des influenceurs</h2>";

        // Verifie si il existe au moins un utilisateur
        if (empty($this->influenceurs)) {
            $html .= "<p>Aucun influenceur trouvé.</p>";
        } else {
            $html .= "<div class='influenceurs-list'>";

            // Parcours les influenceurs recupere depuis la base
            foreach ($this->influenceurs as $influenceur) {
                // Protection contre les injection xss
                $nom = htmlspecialchars($influenceur['nom'], ENT_QUOTES, 'UTF-8');
                $prenom = htmlspecialchars($influenceur['prenom'],ENT_QUOTES, 'UTF-8');

                $id = (int) $influenceur['id_utilisateur'];
                $nbAbonnes = (int) $influenceur['nb_abonnes'];

                // Creation de l'affichage de chaque influenceur
                $html .= "
                    <div class='influenceur'>
                        <div class='influenceur-info'>
                            <a href='?action=touites-user&id={$id}'>
                                <strong>{$prenom} {$nom}</strong>
                            </a>
                            <span>{$nbAbonnes} abonnés</span>
                        </div>
                    </div>";
            }
            $html .= "</div>";
        }
        $html .= "</div>";

        return $html;
    }
}
