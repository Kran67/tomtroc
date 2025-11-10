<?php

/**
 * Entité Message
 */ 
class Message extends AbstractEntity 
{
    private string $discussion_id;
    private string $user_id;
    private string $content;
    private ?DateTime $sent_at;
    private int $is_read;
    private string $avatar;

    /**
     * Setter pour l'identifiant de la conversation.
     * @param string $discussion_id
     */
    public function setDiscussionId(string $discussion_id) : void 
    {
        $this->discussion_id = $discussion_id;
    }

    /**
     * Getter pour l'identifiant de la conversation.
     * @return string
     */
    public function getDiscussionId() : string
    {
        return $this->discussion_id;
    }

    /**
     * Setter pour l'identifiant de l'utilisateur qui a écrit le message.
     * @param string $user_id
     */
    public function setUserId(string $user_id) : void 
    {
        $this->user_id = $user_id;
    }

    /**
     * Getter pour l'identifiant de l'utilisateur qui a écrit le message.
     * @return string
     */
    public function getUserId() : string
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
     * @param string|DateTime $sent_at
     * @param string $format
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