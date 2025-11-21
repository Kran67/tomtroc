<?php

namespace App\src\controllers;

use App\src\dao\MessagingDAO;
use App\src\services\Utils;
use App\src\models\Message;
use App\src\models\View;
use Exception;

class MessagingController
{
    /**
     * Affichage de la page des messages.
     * @return void
     * @throws Exception
     */
    public function showMessaging(): void
    {
        $userId = Utils::getUserId();
        $current_discussion_id = $_SESSION['currentDiscussionId'] ?? '';
        $id = Utils::request("id", '');
        if (!empty($id) && $current_discussion_id <> $id) {
            $current_discussion_id = $id;
        }

        $screenWidth = intval($_SESSION["screenWidth"], 10);

        if (empty($userId)) {
            Utils::redirect("signin");
        }

        // récupération de toutes les conversations pour l'utilisateur courant
        $messagingDao = new MessagingDAO();
        $discussions = $messagingDao->getDiscussionsByUserId($userId);

        if (empty($current_discussion_id)) {
            $current_discussion_id = Utils::request("id", '');
        }

        if (empty($current_discussion_id) && isset($discussions[0]) && $screenWidth > 377) {
            $current_discussion_id = $discussions[0]->getId();
        }

        // récupération des messages de la conversation en cours
        $current_discussion = $messagingDao->getDiscussionById($current_discussion_id);
        if (isset($current_discussion)) {
            $current_discussion_messages = $messagingDao->getDiscussionMessagesById($current_discussion_id);
        } elseif (empty($current_discussion_id)) {
            throw new Exception("Vous n'avez pas de messages");
        } elseif ($screenWidth > 377) {
            throw new Exception("La conversation n'existe pas");
        }
        // on sauvegarde la conversation courante
        $_SESSION['currentDiscussionId'] = $current_discussion_id;

        if ($current_discussion_id) {
            // on lit tous les messages de la conversation courante
            $messagingDao->readAllDiscussionMessage($current_discussion_id);
        }

        // on met à jour la variable de session qui donne le nombre de messages non lus
        $_SESSION['unReadMessages'] = $messagingDao->getUnReadMessageCountByUserId($userId);

        $view = new View("Messaging");
        $view->render("messaging", [
            "discussions" => $discussions,
            "current_discussion" => $current_discussion,
            "current_discussion_messages" => $current_discussion_messages ??[]
        ]);
    }

    /**
     * Création si la conversation n'existe pas et affichage de la conversation.
     * @return void
     * @throws Exception
     */
    public function createOrViewDiscussion(): void
    {
        $toUserId = Utils::request("id", "");
        $fromUserId = Utils::getUSerId();
        // on va voir s'il y a déjà une discussion entre l'utilisateur actuel et l'utilisateur qui met le livre à disposition
        $messagingDao = new MessagingDAO();
        $discussion = $messagingDao->getDiscussionByUsers($fromUserId, $toUserId);

        // il n'a y pas encore de conversation entre les deux personnes, on en créée une
        if (!isset($discussion)) {
            $id = Utils::guidv4();
            $messagingDao->createNewDiscussion($id, $toUserId, $fromUserId);
        } else {
            $id = $discussion->getId();
        }
        $_SESSION['currentDiscussionId'] = $id;

        $this->showMessaging();
    }

    /**
     * Ajoute un message à la conversation courante.
     * @return void
     * @throws Exception
     */
    public function sendMessage(): void
    {
        $discussionId = Utils::request('id', '');
        $content = Utils::request('content', '');

        $message = new Message([
            "id" => Utils::guidv4(),
            "discussion_id" => $discussionId,
            "user_id" => $_SESSION['idUser'],
            "content" =>  htmlspecialchars($content),
        ]);

        $messagingDao = new MessagingDAO();
        $messagingDao->sendMessage($message);

        $this->showMessaging();
    }
}
