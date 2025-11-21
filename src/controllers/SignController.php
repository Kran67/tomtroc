<?php 

namespace App\src\controllers;

use App\src\dao\UserDao;
use App\src\dao\BookDao;
use App\src\models\View;
use App\src\services\Utils;
use App\src\models\Book;
use App\src\models\User;
use Exception;

class SignController 
{
    /**
     * Affiche la page de connexion.
     * @return void
     * @throws Exception
     */
    public function showSignUpForm() : void
    {
        $this->showSignForm();
    }

    /**
     * Affiche la page d'enregistrement.
     * @return void
     * @throws Exception
     */
    public function showSignInForm() : void
    {
        $this->showSignForm(false);
    }

    /**
     * Affiche la page d'enregistrement ou de connexion.
     * @param bool $signup
     * @return void
     * @throws Exception
     */
    private function showSignForm(bool $signup = true) : void
    {
        $user = new User();
        if (isset($_SESSION['idUser'])) {
            echo "checkIfUserIsConnected";
            $userDao = new UserDao();
            $user = $userDao->getUserById($_SESSION['idUser']);
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
     * @throws Exception
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
        $userDao = new UserDao();
        $user = $userDao->getUserByLogin($login);
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
     * @return void
     * @throws Exception
     */
    public function addUser() : void
    {
        // On récupère les données du formulaire.
        $login = substr(Utils::request("email"), 0, 50);
        $password = substr(Utils::request("password"), 0, 255);
        $nickname = substr(Utils::request("nickname"), 0, 30);

        // On vérifie que les données sont valides.
        if (empty($login) || empty($password) || empty($nickname)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

        // On vérifie que l'utilisateur n'existe pas.
        $userDao = new UserDAO();
        $user = $userDao->getUserByLogin($login);
        if ($user) {
            throw new Exception("L'utilisateur existe déjà.");
        }

        $user = new User([
            'id' => Utils::guidv4(),
            'login' => htmlspecialchars($login),
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'nickname' => htmlspecialchars($nickname)
        ]);

        // On enregistre le nouvel utilisateur
        $user = $userDao->addUser($user);

        // On connecte l'utilisateur.
        $_SESSION['user'] = $user;
        $_SESSION['idUser'] = $user->getId();

        // On redirige vers la page du compte.
        Utils::redirect("account");
    }

    /**
     * Modification d'un utilisateur.
     * @return void
     * @throws Exception
     */
    public function updateAccount() : void 
    {
        $target_dir = "img/avatars/";
        $avatar = $_FILES["avatarUpload"]["name"];
        $target_file = $target_dir.basename($avatar);

        // On récupère les données du formulaire.
        $password = substr(Utils::request("password"), 0, 255);
        $nickname = substr(Utils::request("nickname"), 0, 30);

        $uploadOk = true;
        if (isset($_FILES["avatarUpload"]) && !empty($_FILES["avatarUpload"]["tmp_name"])) {
            $info = getimagesize($_FILES["avatarUpload"]["tmp_name"]);
            if (!$info) {
                $uploadOk = false;
            } elseif ($info[0] > 135 && $info[1] > 135) {
                $uploadOk = false;
            }
        }

        // Check if $uploadOk is set to 0 by an error
        if (!$uploadOk) {
            $avatar = "avatar.png";
        // if everything is ok, try to upload file
        } elseif (!move_uploaded_file($_FILES["avatarUpload"]["tmp_name"], $target_file)) {
                $avatar = "avatar.png";
        }

        // On vérifie que les données sont valides.
        if (empty($nickname)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

        // On crée l'objet User.
        $user = new User([
            'id' => $_SESSION['idUser'],
            'password' => !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : "",
            'nickname' => htmlspecialchars($nickname),
            'avatar' => htmlspecialchars($avatar)
        ]);

        $userDao = new UserDAO();
        $userDao->updateUser($user);

        // On redirige vers la page du compte.
        Utils::redirect("account");
    }

    /**
     * Affichage de la page du compte de l'utilisateur.
     * @return void
     * @throws Exception
     */
    public function showAccount(): void
    {
        if (!isset($_SESSION['user'])) {
            Utils::redirect("signin");
        }

        $userDao = new UserDAO();
        $user = $userDao->getUserById($_SESSION['idUser']);

        $bookDao = new BookDAO();
        $userBooks = $bookDao->getAllBooksFromUserId($user->getId());

        $view = new View("account");
        $view->render("account", ["user" => $user, "books" => $userBooks]);
    }

    /**
     * Edition d'un livre.
     * @return void
     * @throws Exception
     */
    public function editBook() : void
    {
        $this->checkIfUserIsConnected();

        $id = Utils::request("id", "");

        // On récupère l'article associé.
        $bookDao = new BookDAO();
        $book = $bookDao->getBookById($id);
       
        if (!$book && !empty($id)) {
            throw new Exception("Le livre demandé n'existe pas.");
        } else {
            if (empty($id)) {
                $book = new Book();
                $book->setImage("a_book.jpg");
            }

            $view = new View("updateBookForm");
            $view->render("updateBookForm", ["book" => $book]);
        }
    }

    /**
     * Modification d'un livre.
     * @return void
     * @throws Exception
     */
    public function updateBook() : void 
    {
        $target_dir = "img/books/";
        $booksImgFolder = $_FILES["imageUpload"]["name"];
        $target_file = $target_dir.basename($booksImgFolder);
        $target_min_dir = "img/books/min/";
        $target_min_file = $target_min_dir.basename($booksImgFolder);

        // On récupère les données du formulaire.
        $id = Utils::request("id");
        $title = substr(Utils::request("title"), 0, 100);
        $author = substr(Utils::request("author"), 0, 30);
        $description = Utils::request("description");
        $image = substr(Utils::request("image"), 0, 255);
        $availability = Utils::request("availability");

        $uploadOk = true;
        if (isset($_FILES["imageUpload"]) && !empty($_FILES["imageUpload"]["tmp_name"])) {
            $info = getimagesize($_FILES["imageUpload"]["tmp_name"]);
            if (!$info) {
                $uploadOk = false;
            } elseif ($info[0] > 783 && $info[1] > 1175) {
                $uploadOk = false;
            }
        }

        // Check if $uploadOk is set to 0 by an error
        if (!$uploadOk) {
            $booksImgFolder = "a_book.jpg";
        // if everything is ok, try to upload file
        } elseif (!file_exists($target_file)) {
            $fileMoved = move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file);
            if (!$fileMoved) {
                $booksImgFolder = "a_book.jpg";
            } else {
                // Resample
                list($width, $height) = getimagesize($target_file);
                $image_p = imagecreatetruecolor(200, 200);
                $image = imagecreatefromjpeg($target_file);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, 200, 200, $width, $height);
                imagejpeg($image_p, $target_min_file);
            }
        }
        if (empty($booksImgFolder)) {
            $booksImgFolder = $image;
        }

        // On vérifie que les données sont valides.
        if (empty($title) || empty($author) || empty($description)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

        // On crée l'objet Book.
        $book = new Book([
            'id' => $id,
            'title' => htmlspecialchars($title),
            'author' => htmlspecialchars($author),
            'description' => htmlspecialchars($description),
            'image' => $booksImgFolder,
            'status' => $availability
        ]);

        $bookDao = new BookDAO();
        $bookDao->addOrUpdateBook($book);

        // On redirige vers la page du compte.
        Utils::redirect("account");
    }

    /**
     * Suppression d'un livre.
     * @return void
     */
    public function deleteBook() : void
    {
        $this->checkIfUserIsConnected();

        $id = Utils::request("id", "");

        // On supprime le livre.
        $bookDao = new BookDAO();
        $bookDao->deleteBook($id);
       
        // On redirige vers la page du compte.
        Utils::redirect("account");
    }
}