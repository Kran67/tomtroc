<?php

/**
 * Entité User : un user est défini par son id, un login et un password.
 */ 
class User extends AbstractEntity 
{
    private string $login;
    private string $password;
    private string $nickname;
    private string $avatar;
    private ?DateTime $created_at;

    /**
     * Setter pour le login.
     * @param string $login
     */
    public function setLogin(string $login) : void 
    {
        $this->login = $login;
    }

    /**
     * Getter pour le login.
     * @return string
     */
    public function getLogin() : string 
    {
        return $this->login;
    }

    /**
     * Setter pour le password.
     * @param string $password
     */
    public function setPassword(string $password) : void 
    {
        $this->password = $password;
    }

    /**
     * Getter pour le password.
     * @return string
     */
    public function getPassword() : string 
    {
        return $this->password;
    }

    /**
     * Setter pour le pseudo.
     * @param string $nickname
     */
    public function setNickname(string $nickname) : void 
    {
        $this->nickname = $nickname;
    }

    /**
     * Getter pour le pseudo.
     * @return string
     */
    public function getNickname() : string 
    {
        return $this->nickname;
    }

    /**
     * Setter pour l'avatar'.
     * @param string $avatar
     */
    public function setAvatar(string $avatar) : void 
    {
        $this->avatar = $avatar;
    }

    /**
     * Getter pour l'avatar'.
     * @return string
     */
    public function getAvatar() : string 
    {
        return $this->avatar;
    }

    /**
     * Getter pour la date de création.
     * @return DateTime
     */
    public function getCreatedAt() : DateTime 
    {
        return $this->created_at;
    }
}