<?php

namespace App\src\models;

/**
 * Cette classe génère les vues en fonction de ce que chaque contrôleur lui passe en paramètre.
 */
class View 
{
    private $file;

    /**
     * Cette méthode retourne une page complète.
     * @param string $viewName
     * @param array $params : les paramètres que le contrôleur a envoyés à la vue.
     * @return void
     * @throws Exception
     */
    public function render($viewName, $params = [])
    {
        $this->file = '../templates/'.$viewName.'.php';
        $content = $this->renderfile($this->file, $params);
        $view = $this->renderfile('../templates/main.php', [
            'content' => $content
        ]);
        echo $view;
    }

    /**
     * Cœur de la classe, c'est ici qu'est généré ce que le contrôleur a demandé.
     * @param $file : le fichier de la vue demandée par le contrôleur.
     * @param array $params : les paramètres que le contrôleur a envoyés à la vue.
     * @throws Exception : si la vue n'existe pas.
     * @return string : le contenu de la vue.
     */
    private function renderfile($file, $params)
    {
        if (file_exists($file)) {
            extract($params);
            ob_start();
            require $file;
            return ob_get_clean();
        }
        echo 'Fichier inexistant';
    }        
}