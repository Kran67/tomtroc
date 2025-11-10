<?php

/**
 * Cette classe génère les vues en fonction de ce que chaque contrôleur lui passe en paramètre.
 */
class View 
{
    /**
     * Le titre de la page.
     */
    private string $title;
    
    
    /**
     * Constructeur. 
     */
    public function __construct($title) 
    {
        $this->title = $title;
    }

    /**
     * Cette méthode retourne une page complète.
     * @param string $viewName
     * @param array $params : les paramètres que le contrôleur a envoyés à la vue.
     * @throws Exception
     */
    public function render(string $viewName, array $params = []) : void 
    {
        // On s'occupe de la vue envoyée
        $viewPath = $this->buildViewPath($viewName);
        
        // Les deux variables ci-dessous sont utilisées dans le "main.php" qui est le modèle principal.
        $content = $this->_renderViewFromTemplate($viewPath, $params);
        $title = $this->title;
        ob_start();
        require(MAIN_VIEW_PATH);
        echo ob_get_clean();
    }
    
    /**
     * Cœur de la classe, c'est ici qu'est généré ce que le contrôleur a demandé.
     * @param $viewPath : le chemin de la vue demandée par le contrôleur.
     * @param array $params : les paramètres que le contrôleur a envoyés à la vue.
     * @throws Exception : si la vue n'existe pas.
     * @return string : le contenu de la vue.
     */
    private function _renderViewFromTemplate(string $viewPath, array $params = []) : string
    {  
        if (file_exists($viewPath)) {
            extract($params); // On transforme les diverses variables stockées dans le tableau "params" en véritables variables qui pourront être lues dans le modèle.
            ob_start();
            require($viewPath);
            return ob_get_clean();
        } else {
            throw new Exception("La vue '$viewPath' est introuvable.");
        }
    }

    /**
     * Cette méthode construit le chemin vers la vue demandée.
     * @param string $viewName : le nom de la vue demandée.
     * @return string : le chemin vers la vue demandée.
     */
    private function buildViewPath(string $viewName) : string
    {
        return TEMPLATE_VIEW_PATH . $viewName . '.php';
    }
}



