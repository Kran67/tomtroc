<?php

/** 
 * Classe UserManager pour gérer les requêtes liées aux users et à l'authentification.
 */

class UserManager extends AbstractEntityManager 
{
    /**
     * Récupère un user par son login.
     * @param string $login
     * @return ?User
     */
    public function getUserByLogin(string $login) : ?User 
    {
        $sql = "SELECT * FROM user WHERE login = :login";
        $result = $this->db->query($sql, ['login' => $login]);
        $user = $result->fetch();
        if ($user) {
            return new User($user);
        }
        return null;
    }

    /**
     * Récupère un user par son identifiant.
     * @param int $id
     * @return ?User
     */
    public function getUserById(int $id) : ?User 
    {
        $sql = "SELECT * FROM user WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $user = $result->fetch();
        if ($user) {
            $bookManger = new BookManager();
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
        $sql = "INSERT INTO user (login, password, nickname, avatar, created_at) VALUES (:login, :password, :nickname, :avatar, NOW())";
        $this->db->query($sql, [
            'login' => $user->getLogin(),
            'password' => $user->getPassword(),
            'nickname' => $user->getNickname(),
            'avatar' => 'avatar.png',
        ]);
        if ($user) {
            return $this->getUserByLogin($user->getLogin());
        }
        return null;
    }

    /**
     * Modifie un utilisateur.
     * @params User $user
     */
    public function updateUser(User $user) : void
    {
        $sql = "UPDATE user SET password = :password, nickname = :nickname WHERE id = :id";
        $this->db->query($sql, [
            'password' => $user->getPassword(),
            'nickname' => $user->getNickname(),
            'id' => $user->getId()
        ]);

        // on met à jour la session
        $_SESSION['user'] = $this->getUserById($user->getId());
    }

    /**
     * Récupère le nombre de livres de l'utilisateur.
     * @return string
     */
    public function getBookCount() : string
    {
        $sql = "SELECT * FROM book WHERE user_id = :id";
        $result = $this->db->query($sql, ['id' => $this->id]);
        $count = $result->fetch();
        if ($count) {
            return $count;
        }
        return "0";
    }
}