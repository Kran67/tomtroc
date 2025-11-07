<?php

/** 
 * Classe MessageManager pour gérer les requêtes liées aux messages.
 */

class MessagingManager extends AbstractEntityManager 
{
    /**
     * Récupère les conversations pour un utilisateur.
     * @return array : les conversations avec le dernier message.
     */
    public function getThreadsByUserId(int $userId) : array
    {
        $sql = "SELECT mt.id, u.id as user_id, u.nickname, u.avatar, m.content, m.sent_at
                FROM message_thread mt
                JOIN user u ON u.id = mt.from_user_id
                JOIN message m ON m.thread_id = mt.id
                WHERE mt.user_id = :userId
                    AND m.sent_at = (
                        SELECT MAX(m2.sent_at)
                        FROM message m2
                        WHERE m2.thread_id = mt.id
                    )
                ORDER BY m.sent_at DESC";
        $result = $this->db->query($sql, ['userId' => $userId]);
        $threads = [];

        while ($thread = $result->fetch()) {
            $threads[] = new Thread($thread);
        }
        return $threads;
    }

    /**
     * Récupère le nombre de message non lus pour un utilisateur.
     * @return int : le nombre de messages.
     */
    public function getUnReadMessageCountByUserId(int $userId) : int
    {
        $sql = "SELECT count(m.id) as count FROM message_thread mt LEFT JOIN message m ON m.thread_id = mt.id WHERE m.is_read = 0 and mt.user_id = :userId";
        $query = $this->db->query($sql, ['userId' => $userId]);
        $result = $query->fetch();

        if (!$result) $result = 0;
        return $result["count"];
    }

    /**
     * Récupère les messages d'une conversation.
     * @return array : tableau de message.
     */
    public function getThreadMessagesById(int $threadId) : array
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
     * @return array : un tableau d'objets Message.
     */
    public function getTreadById(int $threadId) : ?Thread
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
}