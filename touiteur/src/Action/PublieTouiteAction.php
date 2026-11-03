<?php
namespace iutnc\touiteur\Action;

use iutnc\touiteur\action\ActionAbs;
use iutnc\touiteur\BD\TouiteurRepository;
use iutnc\touiteur\touite\Touite;

class PublieTouiteAction extends ActionAbs {

    public function execute(): string {
        // 1. Affichage du formulaire en GET
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $this->renderForm();
        }

        // 2. Traitement du formulaire en POST
        $texte = filter_input(INPUT_POST, 'texte', FILTER_DEFAULT) ?? '';
        $idAuteur = filter_input(INPUT_POST, 'id_auteur', FILTER_VALIDATE_INT) ?? 1;

        try {
            // Instancie l'entité (lèvera InvalidArgumentException si > 235 caractères)
            $touite = new Touite($texte, $idAuteur);

            // Insertion via le Repository
            $repo = TouiteurRepository::getInstance();
            $repo->insertTouite($touite);

            return "
                <p style='color: green; font-weight: bold;'>Votre touite a été publié avec succès !</p>
                <p><a href='?action=default'>Retour à l'accueil</a> | <a href='?action=publish-touite'>Publier un autre touite</a></p>
            ";
        } catch (\InvalidArgumentException $e) {
            return "
                <p style='color: red; font-weight: bold;'>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>" . 
                $this->renderForm($texte);
        } catch (\Exception $e) {
            return "<p style='color: red;'>Erreur lors de l'enregistrement en base : " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }

    private function renderForm(string $texte = ''): string {
        $texteHtml = htmlspecialchars($texte);
        return <<<HTML
        <h2>Publier un nouveau touite</h2>
        <form method="POST" action="?action=publish-touite">
            <div>
                <label for="texte">Message (maximum 235 caractères) :</label><br>
                <textarea id="texte" name="texte" rows="5" cols="50" maxlength="235" required>{$texteHtml}</textarea>
            </div>
            <br>
            <div>
                <label for="id_auteur">ID Auteur (ex: 1) :</label><br>
                <input type="number" id="id_auteur" name="id_auteur" value="1" required>
            </div>
            <br>
            <button type="submit">Publier le touite</button>
        </form>
        HTML;
    }
}