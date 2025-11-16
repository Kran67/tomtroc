<?php

namespace App\src\dao;

use App\src\dao\DBDAO;

/**
 * Classe abstraite qui représente un data access object. Elle récupère automatiquement le gestionnaire de base de données. 
 */
abstract class AbstractEntityDAO {
    
    protected DBDAO $db;

    /**
     * Constructeur de la classe.
     * Il récupère automatiquement l'instance de DBDAO. 
     */
    public function __construct() 
    {
        $this->db = DBDAO::getInstance();
    }
}