<?php
namespace App\config;

/**
 * Système d'autoload. 
 * A chaque fois que PHP va avoir besoin d'une classe, il va appeler cette fonction 
 * et chercher dans les divers dossiers (ici models, controllers, views, services) s'il trouve 
 * un fichier avec le bon nom. Si c'est le cas, il l'inclut avec require_once.
 */
class AutoLoader
{
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload($class)
    {
        $class = str_replace('App', '', $class);
        $class = str_replace('\\', '/', $class);
        require '../' . $class . '.php';
    }    
}