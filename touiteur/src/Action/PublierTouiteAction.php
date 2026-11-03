<?php

namespace iutnc\touiteur\Action;

class PublierTouiteAction extends ActionAbs {

    public function execute(): string {

        // Pour le moment on affiche uniquement le formulaire 
        // On ajoute après le traitement de POST
        if ($this->methode_http === 'POST') {
            return "<p>Traitement de publication a implementer.</p>";
        }

        return '
            <h2>Publier un touite</h2>

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
                ></textarea>

                <br>

                <button type="submit">
                    Publier
                </button>

            </form>
        ';
    }
}
