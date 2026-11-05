<?php

namespace iutnc\touiteur\Render;

class TendancesRenderer{
    private array $tendances;

    public function __construct(array $tend){
        $this->tendances = $tend;
    }

    public function render() : string{
        $html = "<div class='right-card'>";
        $html .="<h2>Top 5 des tags</h2>";

        if (empty(this->tendances)){
            $html .="<p>Aucun tag trouvé</p>";
        } else {
            $html .= "<div class='tendances-list'>";

            foreach ($this->tendances as $tendance) {
                $tag = htmlspecialchars($tendance['libelle'], ENT_QUOTES, 'UTF-8');

                $nbMentions = (int) $tendance['nb_mentions'];

                $html .= "
                    <div class='tendance'>
                        <strong>#$tag</strong>
                        <span>$nbMentions mentions</span>
                    </div>";
            }
            $html .= "</div>";
        }
        $html .= "</div>";

        return $html;
    }
}