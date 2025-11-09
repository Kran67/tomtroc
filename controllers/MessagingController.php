<?php 

class MessagingController 
{
    /**
     * Affichage de la page des messages.
     * @return array of Message
     */
    public function showMessaging(): void
    {
        $userId = $_SESSION['idUser'] ?? '';
        $current_thread_id = $_SESSION['currentThreadId'] ?? '';

        if (empty($userId)) {
            Utils::redirect("signin");
        }

        // récupération de toutes les conversations pour l'utilisateur courant
        $messagingManager = new MessagingManager();
        $threads = $messagingManager->getThreadsByUserId($userId);

        $current_thread = null;
        if (empty($current_thread_id)) {
            $current_thread_id = Utils::request("threadId", '');
        }

        if (empty($current_thread_id)) {
            $current_thread_id = $threads[0]->getId();
        }

        // récupération des messages de la conversation en cours
        $current_thread_messages = [];
        $current_thread = $messagingManager->getTreadById($current_thread_id);
        if (isset($current_thread)) {
            $current_thread_messages = $messagingManager->getThreadMessagesById($current_thread_id);
        } else {
            throw new Exception("La conversation n'existe pas");
        }
        // on sauvegarde la converation courante
        $_SESSION['currentThreadId'] = $current_thread_id;

        // on lit tous les messages de la conversation courante
        $messagingManager->readAllThreadMessage($current_thread_id);

        // on met à jour la varaible de session qui donne le nombre de message non lus
        $_SESSION['unReadMessages'] = $messagingManager->getUnReadMessageCountByUserId($userId);

        $view = new View("Messaging");
        $view->render("messaging", ["threads" => $threads, "current_thread" => $current_thread, "current_thread_messages" => $current_thread_messages]);
    }

    /**
     * Création si la conversation n'existe pas et affichage de la conversation.
     * @param string $toUserId 
     */
    public function createOrViewThread(string $toUserId): void
    {
        // on va voir s'il y a déjà un thread entre l'utilisateur actuel et l'utilisateur qui met le livre à disposition
        $fromUserId = $_SESSION['idUser'];
        $messagingManager = new MessagingManager();
        $thread = $messagingManager->getThreadByUsers($fromUserId, $toUserId);

        // il n'a y pas encore de conversation entre les deux personnes, on en créée une
        if (!isset($thread)) {
            $id = Utils::guidv4();
            $_SESSION['currentThreadId']= $id;
            $messagingManager->createNewThread($id, $toUserId, $fromUserId);
        } else {
            $id = $thread->getId();
        }
        
        $this->showMessaging($id);
    }

    /**
     * Ajoute un mesage à la conversation courante.
     */
    public function sendMessage() : void
    {
        $threadId = Utils::request('id', '');
        $content = Utils::request('content', '');

        $message = new Message([
            "id" => Utils::guidv4(),
            "thread_id" => $threadId,
            "user_id" => $_SESSION['idUser'],
            "content" =>  $content,
        ]);

        $messagingManager = new MessagingManager();
        $messagingManager->sendMessage($message);

        $this->showMessaging();
    }
}