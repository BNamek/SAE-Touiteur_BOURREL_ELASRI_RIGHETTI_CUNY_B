<?php

namespace iutnc\touiteur\Action;

use iutnc\touiteur\BD\TouiteurRepository;

class SuivreUtilisateurAction extends ActionAbs {

    public function execute(): string {
        // Identification du suiveur (session ou paramètre fallback)
        $idSuiveur = $_SESSION['id_utilisateur'] 
                     ?? filter_input(INPUT_GET, 'id_suiveur', FILTER_VALIDATE_INT) 
                     ?? 1;

        // Validation de l'auteur ciblé
        $idSuivi = filter_input(INPUT_GET, 'id_suivi', FILTER_VALIDATE_INT);

        if ($idSuivi === false || $idSuivi === null) {
            return "<div class='error'>
                        <p>Identifiant d'auteur invalide ou manquant.</p>
                        <p><a href='?action=default'>Retour à l'accueil</a></p>
                    </div>";
        }

        // Garde-fou : interdiction de se suivre soi-même
        if ($idSuiveur === $idSuivi) {
            return "<div class='error'>
                        <p>Vous ne pouvez pas vous suivre vous-même.</p>
                        <p><a href='?action=default'>Retour à l'accueil</a></p>
                    </div>";
        }

        $repo = TouiteurRepository::getInstance();

        // Bascule de l'abonnement
        if ($repo->estAbonneUtilisateur($idSuiveur, $idSuivi)) {
            $repo->desabonnerUtilisateur($idSuiveur, $idSuivi);
            $message = "Vous ne suivez plus cet utilisateur.";
        } else {
            $repo->abonnerUtilisateur($idSuiveur, $idSuivi);
            $message = "Vous êtes désormais abonné à cet utilisateur !";
        }

        return "<div class='confirmation' style='padding: 20px;'>
                    <p style='color: #16a34a; font-weight: bold;'>{$message}</p>
                    <p style='margin-top: 15px;'>
                        <a class='detail-back' href='?action=default'>← Retour à l'accueil</a>
                    </p>
                </div>";
    }
}