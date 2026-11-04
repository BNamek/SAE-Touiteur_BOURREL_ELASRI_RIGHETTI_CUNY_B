<?php
namespace iutnc\touiteur\Action;

use iutnc\touiteur\BD\TouiteurRepository;

class AbonnementTagAction extends ActionAbs{

    public function execute(): string {
        // Validation stricte du paramètre id_tag passé en GET
        $idTag = filter_input(INPUT_GET, 'id_tag', FILTER_VALIDATE_INT);

        if ($idTag === false || $idTag === null) {
            return "<div class='error'>
                        <p>Identifiant de tag invalide ou absent.</p>
                        <p><a href='?action=default'>Retourner à l'accueil</a></p>
                    </div>";
        }

        // En attendant le système d'authentification/session complet,
        // on simule un utilisateur connecté (id = 1 ou récupéré en GET si spécifié)
        $idUser = filter_input(INPUT_GET, 'id_user', FILTER_VALIDATE_INT) ?: 1;

        $repo = TouiteurRepository::getInstance();

        // on vérifie si l'utilisateur est déjà abonné ou non
        if ($repo->estAbonneTag($idUser, $idTag)) {
            $repo->desabonnerTag($idUser, $idTag);
            $message = "Vous ne suivez plus ce tag.";
        } else {
            $repo->abonnerTag($idUser, $idTag);
            $message = "Vous êtes désormais abonné à ce tag !";
        }

        return "<div class='confirmation'>
                    <p style='color: green;'>{$message}</p>
                    <p><a href='?action=default'>Retour à l'accueil</a></p>
                </div>";
    }
}