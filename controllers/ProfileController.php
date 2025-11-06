<?php 

class ProfileController 
{
    /**
     * Affichage de la page de profile d'un l'utilisateur.
     * @return User
     */
    public function showProfile(int $id): void
    {
        if (!isset($id) || $id < 1) {
            throw new Exception("Profile inconnu");
        }

        $userManager = new UserManager();
        $user = $userManager->getUserById($id);

        if (!$user) {
            throw new Exception("Profile inconnu");
        }

        $bookManager = new BookManager();
        $userBooks = $bookManager->getAllBooksFromUserId($user->getId());

        if (isset($_SESSION) && isset($_SESSION['idUser']) && $_SESSION['idUser'] === $id) {
            $view = new View("account");
            $view->render("account", ["user" => $user, "books" => $userBooks]);
        } else {
            $view = new View("profile");
            $view->render("profile", ["user" => $user, "books" => $userBooks]);
        }
    }

}