<?php

namespace App\src\dao;

use App\src\dao\AbstractEntityDAO;
use App\src\models\Discussion;
use App\src\models\Message;

/** 
 * Classe MessagingDAO pour gérer les requêtes liées aux messages.
 */

class MessagingDAO extends AbstractEntityDAO
{
    /**
     * Récupère les conversations pour un utilisateur.
     * @param string $userId : identifiant de l'utilisateur.
     * @return array : les conversations avec le dernier message.
     */
    public function getDiscussionsByUserId(string $userId) : array
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
                    ON u.id = IF(mt.user_id = :userId, mt.from_user_id, mt.user_id)
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
        $discussions = [];

        while ($discussion = $result->fetch()) {
            $discussions[] = new Discussion($discussion);
        }
        return $discussions;
    }

    /**
     * Récupère le nombre de messages non lus pour un utilisateur.
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
     * @param string $discussionId : identifiant de la conversation
     * @return array : tableau de message.
     */
    public function getDiscussionMessagesById(string $discussionId) : array
    {
        $sql = "SELECT m.content, m.sent_at, m.user_id, u.avatar
            FROM message m
            JOIN user u ON u.id = m.user_id
            WHERE thread_id = :discussionId
            ORDER BY sent_at ";
        $result = $this->db->query($sql, ['discussionId' => $discussionId]);
        $messages = [];

        while ($message = $result->fetch()) {
            $messages[] = new Message($message);
        }
        return $messages;
    }

    /**
     * Récupère tous les messages d'un utilisateur.
     * @param string $discussionId : identifiant de la conversation
     * @return Discussion|null : un tableau d'objets Message.
     */
    public function getDiscussionById(string $discussionId) : ?Discussion
    {
        $sql = "SELECT mt.id, u.id as from_user_id, u.nickname, u.avatar, u2.id as to_user_id, u2.nickname as to_nickname, u2.avatar as to_avatar
                FROM message_thread mt
                JOIN user u ON u.id = mt.from_user_id
                JOIN user u2 ON u2.id = mt.user_id
                WHERE mt.id = :discussionId";
        $result = $this->db->query($sql, ['discussionId' => $discussionId]);
        $discussion = $result->fetch();
        if ($discussion) {
            if ($discussion["from_user_id"] === $_SESSION["idUser"]) {
                $discussion["from_user_id"] = $discussion["to_user_id"];
                $discussion["nickname"] = $discussion["to_nickname"];
                $discussion["avatar"] = $discussion["to_avatar"];
            }
            return new Discussion($discussion);
        }
        return null;
    }

    /**
     * Récupère la conversation pour deux utilisateurs.
     * @param string $fromUserId
     * @param string $toUserId
     * @return Discussion|null : la conversation.
     */
    public function getDiscussionByUsers(string $fromUserId, string $toUserId) : ?Discussion
    {
        $sql = "SELECT *
                FROM message_thread
                WHERE user_id = :userId AND from_user_id = :fromUserId";
        $result = $this->db->query($sql, ['userId' => $toUserId, 'fromUserId' => $fromUserId]);
        $discussion = $result->fetch();
        if ($discussion) {
            return new Discussion($discussion);
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
    public function createNewDiscussion(string $id, string $toUserId, string $fromUserId) : void {
        $sql = "INSERT INTO message_thread (id, user_id, from_user_id, created_at) VALUES (:id, :userId, :fromUserId, NOW())";
        $this->db->query($sql, [
            "id" => $id,
            "userId" => $toUserId,
            "fromUserId" => $fromUserId
        ]);
    }


    public function sendMessage(Message $message) : void
    {
        $sql = "INSERT INTO message (id, thread_id, user_id, content, sent_at, is_read) VALUES (:id, :discussionId, :userId, :content, NOW(), 0)";
        $this->db->query($sql, [
            "id" => $message->getId(),
            "discussionId" => $message->getDiscussionId(),
            "userId" => $message->getUserId(),
            "content" => $message->getContent()
        ]);
    }

    public function readAllDiscussionMessage(string $discussionId) : void
    {
        $sql = "UPDATE message SET is_read = 1 WHERE thread_id = :discussionId AND user_id <> :user_id";
        $this->db->query($sql, [
            "discussionId" => $discussionId,
            "user_id" => $_SESSION["idUser"]
        ]);
    }
}