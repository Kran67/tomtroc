<?php

namespace App\src\dao;

use App\src\models\User;

/** 
 * Classe UserDAO pour gérer les requêtes liées aux users et à l'authentification.
 */

class UserDAO extends AbstractEntityDAO
{
    /**
     * Récupère un user par son login.
     * @param string $login
     * @return ?User
     */
    public function getUserByLogin(string $login) : ?User 
    {
        $sql = "SELECT * FROM `user` WHERE login = :login";
        $result = $this->db->query($sql, ['login' => $login]);
        $user = $result->fetch();
        if ($user) {
            return new User($user);
        }
        return null;
    }

    /**
     * Récupère un user par son identifiant.
     * @param string $id
     * @return ?User
     */
    public function getUserById(string $id) : ?User 
    {
        $sql = "SELECT * FROM `user` WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $user = $result->fetch();
        if ($user) {
            $bookManger = new BookDAO();
            $user = new User($user);
            $user->setBookCount($bookManger->getBookCountByUserId($id));
            return $user;
        }
        return null;
    }

    /**
     * Ajoute un utilisateur.
     * @param User $user
     * @return ?User
     */
    public function addUser(User $user) : ?User 
    {
        $sql = "INSERT INTO `user` (id, login, password, nickname, avatar, created_at) 
            VALUES (:id, :login, :password, :nickname, :avatar, NOW())";
        $this->db->query($sql, [
            'id' => Utils::guidv4(),
            'login' => $user->getLogin(),
            'password' => $user->getPassword(),
            'nickname' => $user->getNickname(),
            'avatar' => 'avatar.png',
        ]);
        return $this->getUserByLogin($user->getLogin());
    }

    /**
     * Modifie un utilisateur.
     * @params User $user
     */
    public function updateUser(User $user) : void
    {
        $sqlParams = [
            'nickname' => $user->getNickname(),
            'avatar' => $user->getAvatar(),
            'id' => $user->getId()
        ];
        $sql = "UPDATE `user` SET nickname = :nickname, avatar = :avatar ";
        if (!empty($user->getPassword())) {
            $sql .= ", password = :password";
            $sqlParams['password'] = $user->getPassword();
        }
        $sql .= " WHERE id = :id";

        $this->db->query($sql, $sqlParams);

        // on met à jour la session
        $_SESSION['user'] = $this->getUserById($user->getId());
    }
}