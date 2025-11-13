<?php

require_once 'config/config.php';
require_once 'config/autoload.php';

// On récupère l'action demandée par l'utilisateur.
// Si aucune action n'est demandée, on affiche la page d'accueil.
$action = Utils::request('action', 'home');
$action = isset($_SESSION) && isset($_SESSION['action']) ? $_SESSION['action'] : $action;
if (!isset($_SESSION['action'])) {
    $_SESSION['action'] = $action;
}
$userId = isset($_SESSION) && isset($_SESSION['idUser']) ? $_SESSION['idUser'] : '';
$messagingManager = new MessagingManager();
$_SESSION['unReadMessages'] = $messagingManager->getUnReadMessageCountByUserId($userId);
$_SESSION["screenWidth"] = Utils::request('screenWidth', 0);

//Liste des actions possibles nécessitant d'être connecté.
$actions = [
    'account',
    'addUser',
    'changeDiscussion',
    'createOrViewDiscussion',
    'deleteBook',
    'editBook',
    'editBookForm',
    'messaging',
    'sendMessage',
    'updateAccount',
    'updateBook',
];
// Try catch global pour gérer les erreurs
try {
    if (in_array($action, $actions) && !isset($_SESSION['user'])) {
        throw new Exception("Vous devez être connecté pour accéder à cette page.");
    }
    // Pour chaque action, on appelle le bon contrôleur et la bonne méthode.
    switch ($action) {
        // Pages accessibles à tous.
        case 'home':
            $bookController = new BookController();
            $bookController->showHome();
            break;

        case 'books':
            $title = Utils::request('searchTitle', '');
            $bookController = new BookController();
            $bookController->showBooks($title);
            break;

        case 'book':
            $bookId = Utils::request('id', '');
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
            $bookId = Utils::request('id', '');
            $signController = new SignController();
            $signController->editBook();
            break;

        case 'updateBook':
            $bookId = Utils::request('id', '');
            $signController = new SignController();
            $signController->updateBook();
            break;

        case 'deleteBook':
            $bookId = Utils::request('id', '');
            $signController = new SignController();
            $signController->deleteBook();
            break;

        case 'profile':
            $profileController = new ProfileController();
            $profileController->showProfile(Utils::request('id', ''));
            break;

        case 'messaging':
            $MessagingController = new MessagingController();
            $MessagingController->showMessaging();
            break;

        case 'createOrViewDiscussion':
            $toUserId = Utils::request('id', '');
            $MessagingController = new MessagingController();
            $MessagingController->createOrViewDiscussion($toUserId);
            break;

        case 'changeDiscussion':
            $discussionId = Utils::request('id', '');
            if (isset($_SESSION['currentDiscussionId']) && $_SESSION['currentDiscussionId'] !== $discussionId) {
                $_SESSION['currentDiscussionId'] = $discussionId;
            }
            $MessagingController = new MessagingController();
            $MessagingController->showMessaging();
            break;

        case 'sendMessage':
            $MessagingController = new MessagingController();
            $MessagingController->sendMessage();
            break;

        default:
            throw new Exception('La page demandée n\'existe pas.');
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}

unset($_SESSION['action']);