<?php 

class ProfileController 
{
    /**
     * Affichage de la page de profile d'un l'utilisateur.
     * @param string $id : l'identifiant de l'utilisateur
     * @return User
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