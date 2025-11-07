<?php 

class MessagingController 
{
    /**
     * Affichage de la page des messages.
     * @return array of Message
     */
    public function showMessaging(): void
    {
        $userId = $_SESSION['idUser'] ?? 0;

        if ($userId === 0) {
            Utils::redirect("signin");
        }

        $messagingManager = new MessagingManager();
        $threads = $messagingManager->getThreadsByUserId($userId);

        $current_thread = null;
        $current_thread_id = Utils::request("threadId", -1);

        if ($current_thread_id === -1) {
            $current_thread_id = $threads[0]->getId();
        }

        $current_thread_messages = [];
        $current_thread = $messagingManager->getTreadById($current_thread_id);
        if (isset($current_thread)) {
            $current_thread_messages = $messagingManager->getThreadMessagesById($current_thread_id);
        } else {
            throw new Exception("La conversation n'existe pas");
        }

        $view = new View("Messaging");
        $view->render("messaging", ["threads" => $threads, "current_thread" => $current_thread, "current_thread_messages" => $current_thread_messages]);
    }
}