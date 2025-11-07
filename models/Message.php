<?php

/**
 * Entité Message
 */ 
class Message extends AbstractEntity 
{
    private int $thread_id;
    private int $user_id;
    private string $content;
    private ?DateTime $sent_at;
    private int $is_read;
    private string $avatar;

    /**
     * Setter pour l'identifiant de la conversation.
     * @param int $thread_id
     */
    public function setThreadId(int $thread_id) : void 
    {
        $this->thread_id = $thread_id;
    }

    /**
     * Getter pour l'identifiant de la conversation.
     * @return int
     */
    public function getThreadId() : int
    {
        return $this->thread_id;
    }

    /**
     * Setter pour l'identifiant de l'utilisateur qui a écrit le message.
     * @param int $user_id
     */
    public function setUserId(int $user_id) : void 
    {
        $this->user_id = $user_id;
    }

    /**
     * Getter pour l'identifiant de l'utilisateur qui a écrit le message.
     * @return int
     */
    public function getUserId() : int
    {
        return $this->user_id;
    }

    /**
     * Setter pour le contenu du message.
     * @param string $content
     */
    public function setContent(string $content) : void 
    {
        $this->content = $content;
    }

    /**
     * Getter pour le contenu du message.
     * @return string
     */
    public function getContent() : string
    {
        return $this->content;
    }

    /**
     * Setter pour la date du message.
     * @param DateTime $sent_at
     */
    public function setSentAt(string|DateTime $sent_at, string $format = 'Y-m-d H:i:s') : void 
    {
        if (is_string($sent_at)) {
            $sent_at = DateTime::createFromFormat($format, $sent_at);
        }
        $this->sent_at = $sent_at;
    }

    /**
     * Getter pour la date du message.
     * @return DateTime
     */
    public function getSentAt() : DateTime
    {
        return $this->sent_at;
    }

    /**
     * Setter pour la lecture du message.
     * @param bool $is_read
     */
    public function setIsRead(bool $is_read) : void 
    {
        $this->is_read = $is_read;
    }

    /**
     * Getter pour la lecture du message.
     * @return bool
     */
    public function getIsRead() : bool
    {
        return $this->is_read;
    }

    /**
     * Setter pour l'avatar de l'utilisateur.
     * @param string $avatar
     */
    public function setAvatar(string $avatar) : void 
    {
        $this->avatar = $avatar;
    }

    /**
     * Getter pour l'avatar de l'utilisateur.
     * @return string
     */
    public function getAvatar() : string
    {
        return $this->avatar;
    }
}