<?php

namespace iutnc\touiteur\Action;

use iutnc\touiteur\BD\TouiteurRepository;

class DetailTouiteAction extends ActionAbs {

    public function execute(): string {
        // Validation du paramètre d'URL "id"
        $idTouite = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($idTouite === false || $idTouite === null) {
            return "<div class='error'>
                        <p>Identifiant de touite invalide ou manquant.</p>
                        <p><a href='?action=default'>Retour à l'accueil</a></p>
                    </div>";
        }

        $repo = TouiteurRepository::getInstance();
        $touite = $repo->getTouiteDetail($idTouite);

        if ($touite === null) {
            return "<div class='error'>
                        <p>Aucun touite trouvé pour cet identifiant.</p>
                        <p><a href='?action=default'>Retour à l'accueil</a></p>
                    </div>";
        }

        // Sécurisation des données avant affichage HTML
        $texte = nl2br(htmlspecialchars($touite['texte']));
        $auteur = htmlspecialchars($touite['prenom'] . ' ' . $touite['nom']);
        $date = htmlspecialchars($touite['date_publication']);
        $note = (int)$touite['note'];
        $idAuteur = (int)$touite['id_utilisateur'];

        return "
            <article class='touite-detail' style='border: 1px solid #ccc; padding: 15px; margin: 10px 0; border-radius: 8px;'>
                <h2>Détail du touite</h2>
                
                <p style='font-size: 1.2em; font-style: italic;'>« {$texte} »</p>
                
                <hr>
                
                <p>
                    <strong>Auteur :</strong> 
                    <a href='?action=touites-user&id={$idAuteur}'>{$auteur}</a>
                </p>
                <p><strong>Date de publication :</strong> {$date}</p>
                <p><strong>Score / Note :</strong> {$note}</p>

                <p style='margin-top: 20px;'>
                    <a href='?action=default'>← Retour à la liste des touites</a>
                </p>
            </article>
        ";
    }
}