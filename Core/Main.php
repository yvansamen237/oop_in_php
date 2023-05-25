<?php

namespace App\Core;

use App\Controllers\MainController;

class Main
{
    public function start()
    {
        // on demarre la session
        session_start();
        // on retire le 'trailing slash' eventuel de l'url
        $uri = $_SERVER['REQUEST_URI'];

        // on verifie que l'uri n'est pas vide et se termine par un '/'
        if ((isset($uri) && !empty($uri)) && (substr($uri, -1) === '/')) {
            $uri = substr($uri, 0, -1);

            // on envoi un code de redirection permante
            http_response_code(301);

            // on redirige vers l'url sans le '/'
            header('Location: ' . $uri);
        }

        // on gere les parametres d'url (p=cont/met/par/)

        $params = explode('/', $_GET['p']);

        if ($params[0] !== '') {
            // on recupere le nom du controlleur a instancier
            $controller = 'App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';

            // on instancie le controller
            $controller = new $controller();

            // on recupere le 2eme param
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if (method_exists($controller, $action)) {
                //  s'il reste des parametres on les passe a la methode
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            } else {
                http_response_code(404);
                echo "la page demandee n'existe pas";
            }
        } else {
            // on a pas de params, on instancie le controlleur par defaut

            $controller = new MainController;

            // on app la methode index
            $controller->index();
        }
    }
}
