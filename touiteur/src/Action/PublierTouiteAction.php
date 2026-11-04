<?php

namespace iutnc\touiteur\Action;
use iutnc\touiteur\touite\Touite;
use iutnc\touiteur\BD\TouiteRepository;

class PublierTouiteAction extends ActionAbs {

    public function execute(): string {

        $texte = '';
        $message = '';

        //on verifie si le formulaire a ete envoye
        if ($this->methode_http === 'POST') {

            //on verifie que le texte existe et est une chaine
            if (!isset($_POST['texte']) || !is_string($_POST['texte'])) {
                $message = "Erreur : aucun texte renseigne.";

            } else {

                //on recupere le texte du formulaire
                $texte = $_POST['texte'];

                //on verifie que le texte n'est pas vide
                if (trim($texte) === '') {
                    $message = "Erreur : le touite est vide !";

                } elseif (mb_strlen($texte) > 235) {
                    //on verifie la limite de 235 caracteres
                    $message = "Erreur : 235 caracteres maximum !";

                } else {

                    //on recupere l'identifiant de l'utilisateur connecte
                    $idAuteur = filter_var(
                        $_SESSION['id_utilisateur'] ?? null,
                        FILTER_VALIDATE_INT
                    );

                    //on verifie que l'utilisateur est connecte
                    if ($idAuteur === false ||
                        $idAuteur === null ||
                        $idAuteur <= 0) {
                        $message = "Erreur : vous devez etre connecte pour publier !";
                    } else {

                        try {

                            //on cree un objet Touite
                            $touite = new Touite($texte, $idAuteur);

                            //on cree le repository
                            $repository = new TouiteRepository();

                            //on enregistre le touite dans la BD
                            $repository->save($touite);

                            //on confirme la publication
                            $message = "Touite publie avec succes !";

                            //on vide le formulaire apres publication
                            $texte = '';

                        } catch (\PDOException $e) {

                            //on affiche un message sans exposer les details SQL
                            $message = "Erreur lors de la publication du touite !";
                        }
                    }
                }
            }
        }

        //on protege le texte avant de l'afficher en HTML
        $texteAffichable = filter_var(
            $texte,
            FILTER_SANITIZE_SPECIAL_CHARS
        );

        //on affiche le formulaire
        return '
            <h2>Publier un touite</h2>

            <p>' . $message . '</p>

            <form method="POST" action="?action=publier-touite">

                <label for="texte">Votre touite :</label>
                <br>

                <textarea
                    id="texte"
                    name="texte"
                    rows="5"
                    cols="50"
                    maxlength="235"
                    required
                >' . $texteAffichable . '</textarea>

                <br>

                <button type="submit">Publier</button>

            </form>
        ';
    }
}