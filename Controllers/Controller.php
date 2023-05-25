<?php

namespace App\Controllers;

abstract class Controller 
{
    public function render(string $fichier, array $donnees = [], string $template = 'default' )
    {
        // on extrait le contenu des donnees
        extract($donnees);

        // on demarre le buffer de sortie
        ob_start();

        // on cree le chemin vers la vue
        require_once ROOT.'/views/'.$fichier.'.php';

        // transfere le buffer 
        $contenu = ob_get_clean();

        // template de la page 
        require_once ROOT.'/Views/'.$template.'.php';
    }
}