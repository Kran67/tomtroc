<?php 

namespace App\src\controllers;

use App\src\models\View;
use App\src\dao\BookDao;
use App\src\dao\UserDao;
use App\src\services\Utils;
use Exception;

class ProfileController 
{
    /**
     * Affichage de la page de profil d'un utilisateur.
     * @return void
     * @throws Exception
     */
    public function showProfile(): void
    {
        $userId = Utils::request('id', '');
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

        if (Utils::getUserId() === $userId) {
            $view = new View("account");
            $view->render("account", ["user" => $user, "books" => $userBooks]);
        } else {
            $view = new View("profile");
            $view->render("profile", ["user" => $user, "books" => $userBooks]);
        }
    }
}