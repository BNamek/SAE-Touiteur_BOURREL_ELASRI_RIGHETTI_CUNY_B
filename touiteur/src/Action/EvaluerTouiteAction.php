<?php

namespace iutnc\touiteur\Action;

use iutnc\touiteur\BD\TouiteurRepository;

class EvaluerTouiteAction extends ActionAbs {

    public function execute(): string {
        $idTouite = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $type = filter_input(INPUT_GET, 'type', FILTER_DEFAULT);

        if (!$idTouite || !in_array($type, ['like', 'dislike'], true)) {
            header("Location: ?action=default");
            exit();
        }

        $idConnecte = $_SESSION['id_utilisateur'] ?? filter_input(INPUT_GET, 'id_user', FILTER_VALIDATE_INT) ?? 1;
        $valeur = ($type === 'like') ? 1 : -1;

        TouiteurRepository::getInstance()->evaluerTouite($idConnecte, $idTouite, $valeur);

        header("Location: ?action=detail-touite&id={$idTouite}");
        exit();
    }
}