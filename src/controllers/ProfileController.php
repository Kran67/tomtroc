<?php 

namespace App\src\controllers;

use App\src\models\View;
use App\src\dao\BookDao;
use App\src\dao\UserDao;
use Exception;

class ProfileController 
{
    /**
     * Affichage de la page de profil d'un utilisateur.
     * @param string $userId
     * @return void
     * @throws Exception
     */
    public function showProfile(string $userId): void
    {
        if (!isset($userId) || $userId < 1) {
            throw new Exception("Profile inconnu");
        }

        $userDao = new UserDao();
        $user = $userDao->getUserById($userId);

        if (!$user) {
            throw new Exception("Profile inconnu");
        }

        $bookDao = new BookDao();
        $userBooks = $bookDao->getAllBooksFromUserId($user->getId());

        if (isset($_SESSION) && isset($_SESSION['idUser']) && $_SESSION['idUser'] === $userId) {
            $view = new View("account");
            $view->render("account", ["user" => $user, "books" => $userBooks]);
        } else {
            $view = new View("profile");
            $view->render("profile", ["user" => $user, "books" => $userBooks]);
        }
    }

}