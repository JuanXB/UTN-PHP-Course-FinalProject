<?php

include_once 'models/Session.php';
class SectionController
{

    /**
     * Se encarga de determinar la seccion que debe cargarse en el layout de
     * la aplicacion.
     */
    public static function getSection(string|bool $route): string
    {

        $route = isset($_GET['route']) ? $_GET['route'] : false;

        // Si la ruta no esta seteada retorna la pantalla welcome por defecto
        if ($route) {

            if ($route == '500') {
                return APP_CONFIG['errorsPath']."/{$route}.php";
            }

            $path = APP_CONFIG['sectionsPath']."/{$route}.php";
            
            // Si la seccion no existe en el proyecto retorna la vista 404.
            $sectionPath = file_exists($path) ? $path : APP_CONFIG['errorsPath']."/404.php";

            return $sectionPath;
        } else {
            return APP_CONFIG['sectionsPath']."/users.php";
        }
    }
}
