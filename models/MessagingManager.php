<?php

/** 
 * Classe MessageManager pour gérer les requêtes liées aux messages.
 */

class MessagingManager extends AbstractEntityManager 
{
    /**
     * Récupère les conversations pour un utilisateur.
     * @param string $userId : identifiant de l'utilisateur.
     * @return array : les conversations avec le dernier message.
     */
    public function getThreadsByUserId(string $userId) : array
    {
        $sql = "SELECT 
                    u.id AS user_id,
                    u.nickname,
                    u.avatar,
                    mt.id,
                    m.id AS message_id,
                    m.content,
                    m.sent_at,
                    m.is_read
                FROM message_thread mt
                JOIN user u 
                    ON u.id = CASE 
                                WHEN mt.user_id = :userId THEN mt.from_user_id
                                ELSE mt.user_id
                            END
                LEFT JOIN message m 
                    ON m.thread_id = mt.id
                    AND m.sent_at = (
                        SELECT MAX(m2.sent_at)
                        FROM message m2
                        WHERE m2.thread_id = mt.id
                    )
                WHERE mt.user_id = :userId OR mt.from_user_id = :userId
                ORDER BY mt.created_at DESC, m.sent_at DESC";
        $result = $this->db->query($sql, ['userId' => $userId]);
        $threads = [];

        while ($thread = $result->fetch()) {
            $threads[] = new Thread($thread);
        }
        return $threads;
    }

    /**
     * Récupère le nombre de message non lus pour un utilisateur.
     * @param string $userId : identifiant de l'utilisateur.
     * @return int : le nombre de messages.
     */
    public function getUnReadMessageCountByUserId(string $userId) : int
    {
        $sql = "SELECT count(m.id) as count
                FROM message m
                JOIN message_thread mt ON m.thread_id = mt.id
                WHERE m.is_read = 0
                    AND (
                            (mt.user_id = :userId AND m.user_id != :userId)
                            OR
                            (mt.from_user_id = :userId AND m.user_id != :userId)
                        )";

        $query = $this->db->query($sql, ['userId' => $userId]);
        $result = $query->fetch();

        if (!$result) $result = 0;
        return $result["count"];
    }

    /**
     * Récupère les messages d'une conversation.
     * @param string $threadId : identifiant de la conversation
     * @return array : tableau de message.
     */
    public function getThreadMessagesById(string $threadId) : array
    {
        $sql = "SELECT m.content, m.sent_at, m.user_id, u.avatar
            FROM message m
            JOIN user u ON u.id = m.user_id
            WHERE thread_id = :threadId
            ORDER BY sent_at ASC";
        $result = $this->db->query($sql, ['threadId' => $threadId]);
        $messages = [];

        while ($message = $result->fetch()) {
            $messages[] = new Message($message);
        }
        return $messages;
    }

    /**
     * Récupère tous les messages d'un utilisateur.
     * @param string $threadId : identifiant de la conversation
     * @return array : un tableau d'objets Message.
     */
    public function getTreadById(string $threadId) : ?Thread
    {
        $sql = "SELECT mt.id, u.id as user_id, u.nickname, u.avatar
                FROM message_thread mt
                JOIN user u ON u.id = mt.from_user_id
                WHERE mt.id = :threadId";
        $result = $this->db->query($sql, ['threadId' => $threadId]);
        $thread = $result->fetch();
        if ($thread) {
            return new Thread($thread);
        }
        return null;
    }

    /**
     * Récupère la conversation pour deux utilisateurs.
     * @param string $userId : identifiant de l'utilisateur connecté.
     * @param string $userId : identifiant de l'utilisateur avec qui on souhaite échanger.
     * @return Thread : la conversation.
     */
    public function getThreadByUsers(string $fromUserId, string $toUserId) : ?Thread
    {
        $sql = "SELECT *
                FROM message_thread
                WHERE user_id = :userId AND from_user_id = :fromUserId";
        $result = $this->db->query($sql, ['userId' => $toUserId, 'fromUserId' => $fromUserId]);
        $thread = $result->fetch();
        if ($thread) {
            return new Thread($thread);
        }
        return null;
    }

    /**
     * Ajoute une conversation.
     * @param string $id : identifiant de la conversation.
     * @param string $toUserId : identifiant 
     * @param string $fromUserId : identifiant.
     * @return void
     */
    public function createNewThread(string $id, string $toUserId, string $fromUserId) : void {
        $sql = "INSERT INTO message_thread (id, user_id, from_user_id, created_at) VALUES (:id, :userId, :fromUserId, NOW())";
        $this->db->query($sql, [
            "id" => $id,
            "userId" => $toUserId,
            "fromUserId" => $fromUserId
        ]);
    }


    public function sendMessage(Message $message) : void
    {
        $sql = "INSERT INTO message (id, thread_id, user_id, content, sent_at, is_read) VALUES (:id, :threadId, :userId, :content, NOW(), 0)";
        $this->db->query($sql, [
            "id" => $message->getId(),
            "threadId" => $message->getThreadId(),
            "userId" => $message->getUserId(),
            "content" => $message->getContent()
        ]);
    }

    public function readAllThreadMessage(string $threadId) : void
    {
        $sql = "UPDATE message SET is_read = 1 WHERE thread_id = :threadId";
        $this->db->query($sql, ["threadId" => $threadId]);
    }
}