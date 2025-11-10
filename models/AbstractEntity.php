<?php

abstract class AbstractEntity 
{
    // Par défaut l'id il vaut '', ce qui permet de vérifier facilement si l'entité est nouvelle ou pas.
    protected string $id = '';

    /**
     * Constructeur de la classe.
     * Si un tableau associatif est passé en paramètre, on hydrate l'entité.
     * 
     * @param array $data
     */
    public function __construct(array $data = []) 
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    /**
     * Système d'hydratation de l'entité.
     * Permet de transformer les données d'un tableau associatif.
     * Les noms de champs de la table doivent correspondre aux noms des attributs de l'entité.
     * Les underscores sont transformés en camelCase (ex : date_creation devient setDateCreation).
     * @param array $data
     * @return void
     */
    protected function hydrate(array $data) : void 
    {
        foreach ($data as $key => $value) {
            $method = 'set' . str_replace('_', '', ucwords($key, '_'));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /** 
     * Setter pour l'id.
     * @param string $id
     * @return void
     */
    public function setId(string $id) : void 
    {
        $this->id = $id;
    }

    
    /**
     * Getter pour l'id.
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }
}