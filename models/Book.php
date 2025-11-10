<?php

/**
 * Entité Book, un livre est défini par les champs
 * id, user, title, author, image, description, status, created_at, updated_at
 */
 class Book extends AbstractEntity 
 {
    private string $user_id;
    private string $title = "";
    private string $author = "";
    private string $image = "";
    private string $description = "";
    private string $status = "";
    private DateTime $created_at;
    private DateTime $updated_at;
    private string $user_nickname;


    /**
     * Setter pour l'identifiant du propriétaire du livre.
     * @param string $user_id
     */
    public function setUserId(string $user_id) : void 
    {
        $this->user_id = $user_id;
    }

    /**
     * Getter pour l'identifiant du propriétaire du livre.
     * @return string
     */
    public function getUserId() : string
    {
        return $this->user_id;
    }

    /**
     * Setter pour le pseudo de propriétaire du livre.
     * @param string $user_nickname
     */
    public function setUserNickname(string $user_nickname) : void 
    {
        $this->user_nickname = $user_nickname;
    }

    /**
     * Getter pour le pseudo de propriétaire du livre.
     * @return string
     */
    public function getUserNickname() : string
    {
        return $this->user_nickname;
    }

    /**
     * Setter pour le titre du livre.
     * @param string $title
     */
    public function setTitle(string $title) : void 
    {
        $this->title = $title;
    }

    /**
     * Getter pour le titre du livre.
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * Setter pour l'auteur du livre.
     * @param string $author
     */
    public function setAuthor(string $author) : void 
    {
        $this->author = $author;
    }

    /**
     * Getter pour l'auteur du livre.
     * @return string
     */
    public function getAuthor() : string
    {
        return $this->author;
    }

    /**
     * Setter pour l'image du livre.
     * @param string $image
     */
    public function setImage(string $image) : void 
    {
        $this->image = $image;
    }

    /**
     * Getter pour l'image du livre.
     * @return string
     */
    public function getImage() : string
    {
        return $this->image;
    }
 
    /**
     * Setter pour la description du livre.
     * @param string $description
     */
    public function setDescription(string $description) : void 
    {
        $this->description = $description;
    }

     /**
      * Getter pour la description du livre.
      * @param int $length
      * @return string
      */
    public function getDescription(int $length = -1) : string
    {
        if ($length > 0) {
            // Ici, on utilise mb_substr et pas substr pour éviter de couper un caractère en deux
            // (caractère multibyte comme les accents).
            $description = mb_substr($this->description, 0, $length);
            if (strlen($this->description) > $length) {
                $description .= "...";
            }
            return $description;
        }
        return $this->description;
    }
 
    /**
     * Setter pour la description du livre.
     * @param string $status
     */
    public function setStatus(string $status) : void 
    {
        $this->status = $status;
    }

    /**
     * Getter pour le statut du livre.
     * @return string
     */
    public function getStatus() : string
    {
        return $this->status;
    }

    /**
     * Setter pour la date de création. Si la date est une chaine, on la convertit en DateTime.
     * @param string|DateTime $created_at
     * @param string $format : le format pour la conversion de la date si elle est une chaine.
     * Par défaut, c'est le format de date mysql qui est utilisé. 
     */
    public function setCreatedAt(string|DateTime $created_at, string $format = 'Y-m-d H:i:s') : void 
    {
        if (is_string($created_at)) {
            $created_at = DateTime::createFromFormat($format, $created_at);
        }
        $this->created_at = $created_at;
    }

    /**
     * Getter pour la date de création.
     * Grâce au setter, on a la garantie de récupérer un objet DateTime.
     * @return DateTime
     */
    public function getCreatedAt() : DateTime 
    {
        return $this->created_at;
    }

    /**
     * Setter pour la date de mise à jour. Si la date est une chaine, on la convertit en DateTime.
     * @param string|DateTime $updated_at
     * @param string $format : le format pour la conversion de la date si elle est une chaine.
     * Par défaut, c'est le format de date mysql qui est utilisé.
     */
    public function setUpdatedAt(string|DateTime $updated_at, string $format = 'Y-m-d H:i:s') : void
    {
        if (is_string($updated_at)) {
            $updated_at = DateTime::createFromFormat($format, $updated_at);
        }
        $this->updated_at = $updated_at;
    }

    /**
     * Getter pour la date de mise à jour.
     * Grâce au setter, on a la garantie de récupérer un objet DateTime ou null
     * si la date de mise à jour n'a pas été définie.
     * @return DateTime|null
     */
    public function getUpdatedAt() : ?DateTime
    {
        return $this->updated_at;
    }

    /**
     * Getter pour le pseudo du propriétaire.
     * @return string
     */
    public function getOwnerNickName() : string
    {
        return $this->user_nickname;
    }

    public function __toString() : string
    {
        $status = $this->status === 'indisponible' ? 'non dispo.' : $this->status;
        return 
        "<form class='flex' action='./' method='post'>
            <input type='hidden' name='action' value='book'>
            <input type='hidden' name='id' value='".$this->id."'>
            <button type='submit' class='book-card-link'>
                <span class='book-card'>
                    <img src='".IMG_BOOKS_MIN.Utils::format($this->image)."' alt='".Utils::format($this->image)."'>
                    <span class='book-tag ".$this->status."'>".$status."</span>
                    <span class='book-content'>
                        <span class='book-title'>".Utils::format($this->title)."</span>
                        <span class='book-author'>".Utils::format($this->author)."</span>
                        <span class='book-seller'>Vendu par : ".Utils::format($this->user_nickname)."</span>
                    </span>
                </span>
            </button>
        </form>";
    }
}