<?php 

class SignController 
{
    /**
     * Affiche la page d'enregistrement ou de connexion.
     * @return void
     */
    public function showSignForm(bool $signup = true) : void
    {
        $user = new User();
        if (isset($_SESSION['idUser'])) {
            echo "checkIfUserIsConnected";
            $userManager = new UserManager();
            $user = $userManager->getUserById($_SESSION['idUser']);
            $view = new View("account");
            $view->render("account", ['user' => $user]);
        } else {
            $view = new View("sign");
            $view->render("sign", ['signup' => $signup, 'user' => $user]);
        }
    }

    /**
     * Vérifie que l'utilisateur est connecté.
     * @return void
     */
    private function checkIfUserIsConnected() : void
    {
        // On vérifie que l'utilisateur est connecté.
        if (!isset($_SESSION['user'])) {
            Utils::redirect("sign", ['signup' => false]);
        }
    }

    /**
     * Connexion de l'utilisateur.
     * @return void
     */
    public function connectUser() : void 
    {
        // On récupère les données du formulaire.
        $login = Utils::request("email");
        $password = Utils::request("password");

        // On vérifie que les données sont valides.
        if (empty($login) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

        // On vérifie que l'utilisateur existe.
        $userManager = new UserManager();
        $user = $userManager->getUserByLogin($login);
        if (!$user) {
            throw new Exception("L'utilisateur demandé n'existe pas.");
        }

        // On vérifie que le mot de passe est correct.
        if (!password_verify($password, $user->getPassword())) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            throw new Exception("Le mot de passe est incorrect : $hash");
        }

        // On connecte l'utilisateur.
        $_SESSION['user'] = $user;
        $_SESSION['idUser'] = $user->getId();

        // On redirige vers la page du compte.
        Utils::redirect("account");
    }

    /**
     * Déconnexion de l'utilisateur.
     * @return void
     */
    public function disconnectUser() : void 
    {
        // On déconnecte l'utilisateur.
        unset($_SESSION['user']);
        unset($_SESSION['idUser']);

        // On redirige vers la page d'accueil.
        Utils::redirect("home");
    }

    /**
     * Connexion de l'utilisateur.
     * @return User
     */
    public function addUser() : ?User
    {
        // On récupère les données du formulaire.
        $login = Utils::request("email");
        $password = Utils::request("password");
        $nickname = Utils::request("nickname");

        // On vérifie que les données sont valides.
        if (empty($login) || empty($password) || empty($nickname)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

        // On vérifie que l'utilisateur n'existe pas.
        $userManager = new UserManager();
        $user = $userManager->getUserByLogin($login);
        if ($user) {
            throw new Exception("L'utilisateur existe déjà.");
        }

        $user = new User(['login' => $login, 'password' => password_hash($password, PASSWORD_DEFAULT), 'nickname' => $nickname]);

        // On enregistre le nouvel utilisateur
        $user = $userManager->addUser($user);

        // On connecte l'utilisateur.
        $_SESSION['user'] = $user;
        $_SESSION['idUser'] = $user->getId();

        // On redirige vers la page du compte.
        Utils::redirect("account");
    }

    /**
     * Modification d'un utilisateur. 
     * @return void
     */
    public function updateAccount() : void 
    {
        // On récupère les données du formulaire.
        $password = Utils::request("password");
        $nickname = Utils::request("nickname");

        // On vérifie que les données sont valides.
        if (empty($password) || empty($nickname)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

        // On crée l'objet User.
        $user = new User([
            'id' => $_SESSION['idUser'],
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'nickname' => $nickname
        ]);

        $userManager = new UserManager();
        $userManager->updateUser($user);

        // On redirige vers la page du compte.
        Utils::redirect("account");
    }

    /**
     * Affichage de la page du compte de l'utilisateur.
     * @return User
     */
    public function showAccount(): void
    {
        if (!isset($_SESSION['user'])) {
            Utils::redirect("signin");
        }

        $userManager = new UserManager();
        $user = $userManager->getUserById($_SESSION['idUser']);

        $bookManager = new BookManager();
        $userBooks = $bookManager->getAllBooksFromUserId($user->getId());

        $view = new View("account");
        $view->render("account", ["user" => $user, "books" => $userBooks]);
    }

    /**
     * Edition d'un livre.
     * @return void
     */
    public function editBook() : void
    {
        $this->checkIfUserIsConnected();

        $id = Utils::request("id", -1);


        // On récupère l'article associé.
        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);
       
        if (!$book) {
            throw new Exception("Le livre demandé n'existe pas.");
        } else {
            $view = new View("updateBookForm");
            $view->render("updateBookForm", ["book" => $book]);
        }
    }

    /**
     * Suppression d'un livre.
     * @return void
     */
    public function deleteBook() : void
    {
        $this->checkIfUserIsConnected();

        $id = Utils::request("id", -1);

        // On supprime le livre.
        $bookManager = new BookManager();
        $bookManager->deleteBook($id);
       
        // On redirige vers la page du compte.
        Utils::redirect("account");
    }
}