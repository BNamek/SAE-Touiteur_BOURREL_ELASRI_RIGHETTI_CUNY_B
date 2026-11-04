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

        // Sécurisation des données avant affichage
        $texte = nl2br(htmlspecialchars($touite['texte']));
        $nom = htmlspecialchars($touite['nom']);
        $prenom = htmlspecialchars($touite['prenom']);
        $auteur = $prenom . ' ' . $nom;
        $initiale = htmlspecialchars(mb_substr($prenom, 0, 1));
        $date = htmlspecialchars($touite['date_publication']);
        $note = (int)$touite['note'];
        $idAuteur = (int)$touite['id_utilisateur'];

        // Identification de l'utilisateur connecté (session ou fallback temporaire)
        $idConnecte = $_SESSION['id_utilisateur'] 
                      ?? filter_input(INPUT_GET, 'id_suiveur', FILTER_VALIDATE_INT) 
                      ?? 1;

        // Logique dynamique de suivi
        $lienSuivi = "";
        if ($idConnecte !== $idAuteur) {
            $estAbonne = $repo->estAbonneUtilisateur($idConnecte, $idAuteur);
            $texteSuivi = $estAbonne ? "Ne plus suivre" : "Suivre";
            $classeSuivi = $estAbonne ? "badge-unfollow" : "badge-follow";
            $lienSuivi = " · <a class='{$classeSuivi}' href='?action=suivre-utilisateur&id_suivi={$idAuteur}'>{$texteSuivi}</a>";
        }

        return "
            <article class='touite-detail'>
                <div class='detail-header'>
                    <div class='detail-avatar'>{$initiale}</div>
                    <div class='detail-user'>
                        <a class='detail-author' href='?action=touites-user&id={$idAuteur}'>{$auteur}</a>
                        <span class='detail-username'>
                            @auteur{$idAuteur} {$lienSuivi}
                        </span>
                    </div>
                </div>

                <div class='detail-text'>{$texte}</div>

                <div class='detail-date'>{$date}</div>

                <div class='detail-score'>
                    <strong>{$note}</strong> évaluation(s)
                </div>

                <div class='detail-footer'>
                    <a class='detail-back' href='?action=default'>← Retour aux touites</a>
                </div>
            </article>
        ";
    }
}