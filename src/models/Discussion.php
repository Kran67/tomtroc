<?php

namespace App\src\models;

use App\src\models\AbstractEntity;
use App\src\services\Utils;
use DateTime;

/**
 * Entité Message
 */ 
class Discussion extends AbstractEntity
{
    private string $user_id;
    private string $nickname;
    private string $avatar;
    private ?string $content;
    private ?DateTime $sent_at;
    private ?bool $is_read;

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
     * @param string|null $content
     */
    public function setContent(string|null $content) : void 
    {
        if (!isset($content)) {
            $content = "";
        }
        $this->content = $content;
    }

    /**
     * Getter pour le contenu du message.
     * @param int $length
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
     * @param string|DateTime|null $sent_at
     * @param string $format
     */
    public function setSentAt(string|DateTime|null $sent_at, string $format = 'Y-m-d H:i:s') : void 
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
    public function setIsRead(?bool $is_read) : void 
    {
        $this->is_read = $is_read;
    }

    /**
     * Getter pour la lecture du message.
     * @return bool
     */
    public function getIsRead() : bool
    {
        return $this->is_read ?? false;
    }

    public function __toString() : string
    {
        $current_discussion_id = $_SESSION['currentDiscussionId'] ?? "";
        $screenWidth = intval($_SESSION["screenWidth"], 10);
        $result = "<div class='discussion-main ".($current_discussion_id === $this->id ? "active" : "")."'>
            <div class='discussion-image-container'>
                <img src='".IMG_AVATARS.Utils::format($this->avatar)."' alt=\"Personne : '".Utils::format($this->nickname)."'\">
            </div>
            <div class='discussion-right'>
                <div class='discussion-right-header'>";
        if ($current_discussion_id !== $this->id || $screenWidth <= 377) {
            $result .= "    <button type='submit' ".Utils::changeAction("changeDiscussion", "{'id': '".$this->id."'}").">";
        }
        $result .= "        <span class='discussion-nickname'>".Utils::format($this->nickname)."</span>";
        if ($current_discussion_id !== $this->id || $screenWidth <= 377) {
            $result .= "    </button>";
        }
        $result .= "<span class='discussion-send-at'>".Utils::convertDateToFrenchFormat($this->sent_at, "HH:mm")."</span>
                </div>
                <div class='discussion-last-message ".(!$this->getIsRead() ? "unread" : "")."'>".Utils::format($this->getContent(27))."</div>
            </div>
        </div>";
        return $result;
    }
}