<?php 

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

        $userManager = new UserManager();
        $user = $userManager->getUserById($userId);

        if (!$user) {
            throw new Exception("Profile inconnu");
        }

        $bookManager = new BookManager();
        $userBooks = $bookManager->getAllBooksFromUserId($user->getId());

        if (isset($_SESSION) && isset($_SESSION['idUser']) && $_SESSION['idUser'] === $userId) {
            $view = new View("account");
            $view->render("account", ["user" => $user, "books" => $userBooks]);
        } else {
            $view = new View("profile");
            $view->render("profile", ["user" => $user, "books" => $userBooks]);
        }
    }

}