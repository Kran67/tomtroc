<?php

require_once 'config/config.php';
require_once 'config/autoload.php';

// On récupère l'action demandée par l'utilisateur.
// Si aucune action n'est demandée, on affiche la page d'accueil.
$action = Utils::request('action', 'home');
$userId = isset($_SESSION) && isset($_SESSION['idUser']) ? $_SESSION['idUser'] : -1;
$MessagingManager = new MessagingManager();
$unReadMessages = $MessagingManager->getUnReadMessageCountByUserId($userId);
$_SESSION['unReadMessages'] = $unReadMessages;


// Try catch global pour gérer les erreurs
try {
    // Pour chaque action, on appelle le bon contrôleur et la bonne méthode.
    switch ($action) {
        // Pages accessibles à tous.
        case 'home':
            $bookController = new BookController();
            $bookController->showHome();
            break;

        case 'books':
            $title = Utils::request('title', '');
            $bookController = new BookController();
            $bookController->showBooks($title);
            break;

        case 'book':
            $bookId = Utils::request('id', '-1');
            $bookController = new BookController();
            $bookController->showBookDetail($bookId);
            break;

        case 'signup':
            $signController = new SignController();
            $signController->showSignForm();
            break;

        case 'signin':
            $signController = new SignController();
            $signController->showSignForm(false);
            break;
        
        case 'addUser':
            $signController = new SignController();
            $signController->addUser();
            break;

        case 'login':
            $signController = new SignController();
            $signController->connectUser();
            break;

        case 'logout':
            $signController = new SignController();
            $signController->disconnectUser();
            break;

        case 'account':
            $signController = new SignController();
            $signController->showAccount();
            break;
        
        case 'updateAccount':
            $signController = new SignController();
            $signController->updateAccount();
            break;

        case 'editBook':
            $bookId = Utils::request('id', '-1');
            $signController = new SignController();
            $signController->editBook($bookId);
            break;

        case 'deleteBook':
            $bookId = Utils::request('id', '-1');
            $signController = new SignController();
            $signController->deleteBook($bookId);
            break;

        case 'profile':
            $profileController = new ProfileController();
            $profileController->showProfile(Utils::request('id', '-1'));
            break;

        case 'messaging':
            $MessagingController = new MessagingController();
            $MessagingController->showMessaging();
            break;

    default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}
