<?php
namespace iutnc\touiteur\Action;

use iutnc\touiteur\BD\TouiteurRepository;

class SuivreUtilisateurAction extends ActionAbs {

    public function execute(): string {
        // Validation des paramètres passés en GET
        $idSuiveur = filter_input(INPUT_GET, 'id_suiveur', FILTER_VALIDATE_INT) 
                     ?? ($_SESSION['id_utilisateur'] ?? null);
        $idSuivi = filter_input(INPUT_GET, 'id_suivi', FILTER_VALIDATE_INT);

        // Vérification de la validité des identifiants
        if ($idSuiveur === false || $idSuiveur === null || $idSuivi === false || $idSuivi === null) {
            return "<div class='error'>
                        <p>Identifiants invalides ou manquants.</p>
                        <p><a href='?action=default'>Retour à l'accueil</a></p>
                    </div>";
        }

        // Règle métier : empêcher l'auto-suivi
        if ($idSuiveur === $idSuivi) {
            return "<div class='error'>
                        <p>Vous ne pouvez pas vous suivre vous-même.</p>
                        <p><a href='?action=default'>Retour à l'accueil</a></p>
                    </div>";
        }

        $repo = TouiteurRepository::getInstance();

        // Bascule : désabonnement si déjà suivi, abonnement sinon
        if ($repo->estAbonneUtilisateur($idSuiveur, $idSuivi)) {
            $repo->desabonnerUtilisateur($idSuiveur, $idSuivi);
            $message = "Vous ne suivez plus cet utilisateur.";
        } else {
            $repo->abonnerUtilisateur($idSuiveur, $idSuivi);
            $message = "Vous êtes désormais abonné à cet utilisateur !";
        }

        return "<div class='confirmation'>
                    <p style='color: green;'>{$message}</p>
                    <p><a href='?action=default'>Retour à l'accueil</a></p>
                </div>";
    }
}