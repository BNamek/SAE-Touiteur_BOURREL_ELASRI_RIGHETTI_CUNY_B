<?php
namespace iutnc\touiteur\Action;

use iutnc\touiteur\BD\TouiteurRepository;

class AbonnementTagAction extends ActionAbs {

    public function execute(): string {
        // Validation stricte du paramètre id_tag passé en GET
        $idTag = filter_input(INPUT_GET, 'id_tag', FILTER_VALIDATE_INT);

        if ($idTag === false || $idTag === null) {
            return "<div class='error'>
                        <p>Identifiant de tag invalide ou absent.</p>
                        <p><a href='?action=default'>Retourner à l'accueil</a></p>
                    </div>";
        }

        // Récupération de l'utilisateur connecté depuis la session, avec fallback en GET ou id=1 pour les tests
        $idUser = $_SESSION['id_utilisateur'] 
                  ?? filter_input(INPUT_GET, 'id_user', FILTER_VALIDATE_INT) 
                  ?? 1;

        $repo = TouiteurRepository::getInstance();

        // On vérifie si l'utilisateur est déjà abonné ou non au tag
        if ($repo->estAbonneTag($idUser, $idTag)) {
            $repo->desabonnerTag($idUser, $idTag);
            $message = "Vous ne suivez plus ce tag.";
        } else {
            $repo->abonnerTag($idUser, $idTag);
            $message = "Vous êtes désormais abonné à ce tag !";
        }

        return "<div class='confirmation' style='padding: 20px;'>
                    <p style='color: #16a34a; font-weight: bold;'>{$message}</p>
                    <p style='margin-top: 15px;'>
                        <a class='detail-back' href='?action=default'>← Retour à l'accueil</a>
                    </p>
                </div>";
    }
}