<?php

class MessagingController
{
    /**
     * Affichage de la page des messages.
     * @return void of Message
     * @throws Exception
     */
    public function showMessaging(): void
    {
        $userId = $_SESSION['idUser'] ?? '';
        $current_discussion_id = $_SESSION['currentDiscussionId'] ?? '';
        $screenWidth = intval($_SESSION["screenWidth"], 10);

        if (empty($userId)) {
            Utils::redirect("signin");
        }

        // récupération de toutes les conversations pour l'utilisateur courant
        $messagingManager = new MessagingManager();
        $discussions = $messagingManager->getDiscussionsByUserId($userId);

        if (empty($current_discussion_id)) {
            $current_discussion_id = Utils::request("discussionId", '');
        }

        if (empty($current_discussion_id) && isset($discussions[0]) && $screenWidth > 377) {
            $current_discussion_id = $discussions[0]->getId();
        }

        // récupération des messages de la conversation en cours
        $current_discussion = $messagingManager->getDiscussionById($current_discussion_id);
        if (isset($current_discussion)) {
            $current_discussion_messages = $messagingManager->getDiscussionMessagesById($current_discussion_id);
        } elseif (empty($current_discussion_id)) {
            throw new Exception("Vous n'avez pas de messages");
        } elseif ($screenWidth > 377) {
            throw new Exception("La conversation n'existe pas");
        }
        // on sauvegarde la conversation courante
        $_SESSION['currentDiscussionId'] = $current_discussion_id;

        if ($current_discussion_id) {
            // on lit tous les messages de la conversation courante
            $messagingManager->readAllDiscussionMessage($current_discussion_id);
        }

        // on met à jour la variable de session qui donne le nombre de messages non lus
        $_SESSION['unReadMessages'] = $messagingManager->getUnReadMessageCountByUserId($userId);

        $view = new View("Messaging");
        $view->render("messaging", [
            "discussions" => $discussions,
            "current_discussion" => $current_discussion,
            "current_discussion_messages" => $current_discussion_messages ??[]
        ]);
    }

    /**
     * Création si la conversation n'existe pas et affichage de la conversation.
     * @param string $toUserId
     * @throws Exception
     */
    public function createOrViewDiscussion(string $toUserId): void
    {
        // on va voir s'il y a déjà une discussion entre l'utilisateur actuel et l'utilisateur qui met le livre à disposition
        $fromUserId = $_SESSION['idUser'];
        $messagingManager = new MessagingManager();
        $discussion = $messagingManager->getDiscussionByUsers($fromUserId, $toUserId);

        // il n'a y pas encore de conversation entre les deux personnes, on en créée une
        if (!isset($discussion)) {
            $id = Utils::guidv4();
            $messagingManager->createNewDiscussion($id, $toUserId, $fromUserId);
        } else {
            $id = $discussion->getId();
        }
        $_SESSION['currentDiscussionId'] = $id;

        $this->showMessaging();
    }

    /**
     * Ajoute un message à la conversation courante.
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
            "content" =>  $content,
        ]);

        $messagingManager = new MessagingManager();
        $messagingManager->sendMessage($message);

        $this->showMessaging();
    }
}
