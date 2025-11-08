<?php

/**
 * Entité Message
 */ 
class Thread extends AbstractEntity 
{
    private string $user_id;
    private string $nickname;
    private string $avatar;
    private string $content;
    private DateTime $sent_at;

    /**
     * Setter pour l'identifiant de l'utilisateur.
     * @param string $user_id
     */
    public function setUserId(string $user_id) : void 
    {
        $this->user_id = $user_id;
    }

    /**
     * Getter pour l'identifiant de l'utilisateur'.
     * @return string
     */
    public function getUserId() : string
    {
        return $this->user_id;
    }

    /**
     * Setter pour le pseudo de l'utilisateur.
     * @param string $nickname
     */
    public function setNickname(string $nickname) : void 
    {
        $this->nickname = $nickname;
    }

    /**
     * Getter pour le pseudo de l'utilisateur.
     * @return string
     */
    public function getNickname() : string
    {
        return $this->nickname;
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
    public function getContent(int $length = -1) : string
    {
        if ($length > 0) {
            // Ici, on utilise mb_substr et pas substr pour éviter de couper un caractère en deux (caractère multibyte comme les accents).
            $content = mb_substr($this->content, 0, $length);
            if (strlen($this->content) > $length) {
                $content .= "...";
            }
            return $content;
        }
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

    public function __toString() : string
    {
        return "<div class='thread-main'>
            <div class='thread-image-container'>
                <img src='".IMG_AVATARS.Utils::format($this->avatar)."' alt='".Utils::format($this->avatar)."'>
            </div>
            <div class='thread-right'>
                <div class='thread-right-header'>
                    <span class='thread-nickname'>".Utils::format($this->nickname)."</span>
                    <span class='thread-send-at'>".Utils::convertDateToFrenchFormat($this->sent_at, "HH:mm")."</span>
                </div>
                <div class='thread-last-message'>".Utils::format($this->getContent(27))."</div>
            </div>
        </div>";
    }
}