<?php

namespace App\src\router;

use App\src\dao\MessagingDAO;
use App\src\controllers\BookController;
use App\src\controllers\SignController;
use App\src\controllers\ProfileController;
use App\src\controllers\MessagingController;
use App\src\models\View;
use App\src\services\Utils;
use Exception;

$messagingDao = new MessagingDAO();
$_SESSION['unReadMessages'] = $messagingDao->getUnReadMessageCountByUserId();
$_SESSION["screenWidth"] = Utils::request('screenWidth', 0);

class Router
{
    /**
     * @var array[] $routes
     */
    private array $routes;

    public function __construct()
    {
        $this->routes = [
            "home" => [BookController::class, 'showHome', false],
            "books" => [BookController::class, 'showBooks', false],
            "book" => [BookController::class, 'showBookDetail', false],
            "signup" => [SignController::class, 'showSignUpForm', false],
            "signin" => [SignController::class, 'showSignInForm', false],
            "addUser" => [SignController::class, 'addUser', true],
            "login" => [SignController::class, 'connectUser', false],
            "logout" => [SignController::class, 'disconnectUser', false],
            "account" => [SignController::class, 'showAccount', true],
            "updateAccount" => [SignController::class, 'updateAccount', true],
            "editBook" => [SignController::class, 'editBook', true],
            "updateBook" => [SignController::class, 'updateBook', true],
            "deleteBook" => [SignController::class, 'deleteBook', true],
            "profile" => [ProfileController::class, 'showProfile', false],
            "messaging" => [MessagingController::class, 'showMessaging', true],
            "createOrViewDiscussion" => [MessagingController::class, 'createOrViewDiscussion', true],
            "changeDiscussion" => [MessagingController::class, 'showMessaging', true],
            "sendMessage" => [MessagingController::class, 'sendMessage', true],
        ];
    }

    /**
     * Handles the HTTP request and sends it to the correct controller and method
     * @return void
     * @throws Exception
     */
    public function handleRequest(): void
    {
        // On récupère l'action demandée par l'utilisateur.
        // Si aucune action n'est demandée, on affiche la page d'accueil.
        $action = Utils::request('action', 'home');
        $action = isset($_SESSION) && isset($_SESSION['action']) ? $_SESSION['action'] : $action;
        if (!isset($_SESSION['action'])) {
            $_SESSION['action'] = $action;
        }

        try {
            // Check if the action exists in the route list
            if (!isset($this->routes[$action])) {
                throw new Exception("La page demandée n'existe pas.");
            }

            // Extract the controller class and method name from the route
            [$controllerClass, $method, $adminRequired] = $this->routes[$action];

            if ($adminRequired && !isset($_SESSION["user"])) {
                throw new Exception("Vous devez être connecté pour accéder à cette page.");
            }

            $controller = new $controllerClass();

            // Check if the method exists in the controller class
            if (!method_exists($controller, $method)) {
                throw new Exception("Erreur serveur");
            }

            $controller->$method();

        } catch (Exception $e) {
            // En cas d'erreur, on affiche la page d'erreur.
            Utils::showErrorPage($e->getMessage());
        }
        unset($_SESSION['action']);
    }
}
