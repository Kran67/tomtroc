<?php

/**
 * Entité User : un user est défini par son id, un login et un password.
 */ 
class User extends AbstractEntity 
{
    private string $login;
    private string $password;
    private string $nickname;
    private string $avatar;
    private ?DateTime $created_at;
    private int $book_count;

    /**
     * Setter pour le login.
     * @param string $login
     */
    public function setLogin(string $login) : void 
    {
        $this->login = $login;
    }

    /**
     * Getter pour le login.
     * @return string
     */
    public function getLogin() : string 
    {
        return $this->login;
    }

    /**
     * Setter pour le password.
     * @param string $password
     */
    public function setPassword(string $password) : void 
    {
        $this->password = $password;
    }

    /**
     * Getter pour le password.
     * @return string
     */
    public function getPassword() : string 
    {
        return $this->password;
    }

    /**
     * Setter pour le pseudo.
     * @param string $nickname
     */
    public function setNickname(string $nickname) : void 
    {
        $this->nickname = $nickname;
    }

    /**
     * Getter pour le pseudo.
     * @return string
     */
    public function getNickname() : string 
    {
        return $this->nickname;
    }

    /**
     * Setter pour l'avatar'.
     * @param string $avatar
     */
    public function setAvatar(string $avatar) : void 
    {
        $this->avatar = $avatar;
    }

    /**
     * Getter pour l'avatar'.
     * @return string
     */
    public function getAvatar() : string 
    {
        return $this->avatar;
    }

    /**
     * Setter pour la date de création.
     * @param DateTime $created_at
     */
    public function setCreatedAt(string $created_at) : void
    {
        $this->created_at = new DateTime($created_at);
    }

    /**
     * Getter pour la date de création.
     * @return DateTime
     */
    public function getCreatedAt() : DateTime 
    {
        return $this->created_at;
    }

    /**
     * Setter pour le nombre de livre.
     * @param int $bookCount
     */
    public function setBookCount(int $bookCount) : void 
    {
        $this->book_count = $bookCount;
    }

    /**
     * Getter pour le nombre de livre.
     * @return int
     */
    public function getBookCount() : int 
    {
        return $this->book_count;
    }

    public function __toString() : string
    {
        return 
            "<form class='flex' action='./' method='post'>
                <input type='hidden' name='action' value='profile'>
                <input type='hidden' name='id' value='{$this->id}'>
                <button type='submit' class='avatar'>
                    <img src='".Utils::format(IMG_AVATARS.$this->avatar)."' class='avatar-image' alt='".Utils::format(IMG_AVATARS.$this->avatar)."'>
                    <span class='avatar-nickname'>".Utils::format($this->nickname)."</span>
                </button>
            </form>";
    }

    private function isConnected() : bool
    {
        return isset($_SESSION) && isset($_SESSION['idUser']) && $_SESSION['idUser'] === $this->id;
    }

    public function getCard() : string
    {
        $accountMemberSince = Utils::differenceDate($this->created_at);
        $result = "<div class='account-card'>
            <img id='avatar' src='". IMG_AVATARS.$this->getAvatar() ."' alt='{$this->getAvatar()}'>";
        if ($this->isConnected()) {
            $result .= "<label for='avatarUpload' class='link account-image-update'>modifier</label>";
        } else {
            $result .= "<div class='account-spacer'></div>";
        }
        $result .= "<hr>
            <div class='account-nickname'>". Utils::format($this->nickname) ."</div>
            <div class='account-member-since'>Membre ".$accountMemberSince["texte"]."</div>
            <div class='account-library'>BIBLIOTHEQUE</div>
            <div class='account-book-count'><img src='".IMG."livres.svg' alt='livres'>{$this->book_count} livre".($this->book_count > 1 ? "s" : "")."</div>";
        if (!$this->isConnected()) {
            $result .= "<form class='flex' action='./' method='post'>";
            $result .= "    <input type='hidden' name='action' value='action'>";
            $result .= "    <button type='submit' class='cta cta2 account-button'>Écrire un message</button>";
            $result .= "</form>";
        }
        $result .= "</div>";
        return $result;
    }

    public function getUpdateForm() : string
    {
        return "<div class='account-update-form'>
            <div class='account-update-form-title'></div>
            <form class='sign-form' action='./' method='post' enctype='multipart/form-data'>
                <input type='hidden' name='action' value='updateAccount'>
                <input type='file' name='avatarUpload' id='avatarUpload' accept='.jpg, .png, .gif' ".Utils::onChangeImage('avatar').">
                <div class='sign-form-row'>
                    <label for='email'>Adresse email</label>
                    <input name='email' id='email' type='text' value='{$this->login}' readonly>
                </div>
                <div class='sign-form-row'>
                    <label for='password'>Mot de passe</label>
                    <input name='password' id='password' type='password' required>
                </div>
                <div class='sign-form-row'>
                    <label for='nickname'>Pseudo</label>
                    <input name='nickname' id='nickname' type='text' value='{$this->nickname}'>
                </div>
                <button class='cta cta2 sign-submit-btn'>Enregistrer</button>
            </form>
        </div>";
    }

    public function getBooks(array $books) : string
    {
        $result = "<div class='account-detail-books'>
            <div class='user-books-header'>
                <div class='user-books-column-image'>PHOTO</div>
                <div class='user-books-column-title'>TITRE</div>
                <div class='user-books-column-author'>AUTEUR</div>
                <div class='user-books-column-desc'>DESCRIPTION</div>";
                if ($this->isConnected()) {
                    $result .= "<div class='user-books-column-availability'>DISPONIBILITE</div>
                        <div class='user-books-column-action'>ACTION</div>";
                }
            $result .= "</div>";
            if (count($books) === 0) {
                $result .= "<div class='user-books-no-book'>Aucun livre à afficher<br>";
                //$result .= "<a href='./action=addBook' class='user-books-add-book'>Ajouter un livre</a>";
            } else {
                if (!$this->isConnected()) {
                    $result .= "<div class='user-books-row-container'>";
                }
                foreach($books as $book) {
                    $result .= "<div class='user-books-row'>";
                    $result .= "<div class='user-books-column-image user-books-image-container'>";
                    $result .= "    <img src='".Utils::format(IMG_BOOKS.$book->getImage())."' class='user-books-image' alt='".Utils::format($book->getImage())."'>";
                    $result .= "</div>";
                    $result .= "<div class='user-books-column-title'>".Utils::format($book->getTitle())."</div>";
                    $result .= "<div class='user-books-column-author'>".Utils::format($book->getAuthor())."</div>";
                    $result .= "<div class='user-books-column-desc'>".Utils::format($book->getDescription(82))."</div>";
                    $status = $book->getStatus() === 'indisponible' ? 'non dispo.' : $book->getStatus();
                    if ($this->isConnected()) {
                        $result .= "<div class='user-books-column-availability'><span class='book-tag {$book->getStatus()}'>".$status."</span></div>";
                        $result .= "<div class='user-books-column-action'>";
                        $result .= "    <form class='flex' action='./' method='post'>";
                        $result .= "        <input type='hidden' name='action' value='editBook'>";
                        $result .= "        <input type='hidden' name='id' value='{$book->getId()}'>";
                        $result .= "        <button type='submit'>Éditer</button>";
                        $result .= "    </form>";
                        $result .= "    <form class='flex' action='./' method='post'>";
                        $result .= "        <input type='hidden' name='action' value='deleteBook'>";
                        $result .= "        <input type='hidden' name='id' value='{$book->getId()}'>";
                        $result .= "        <button type='submit' class='delete' {Utils::askConfirmation('Êtes-vous sûr de vouloir supprimer ce livre ?')}>Supprimer</button>";
                        $result .= "    </form>";
                        $result .= "</div>";
                    }
                    $result .= "</div>";
                }
                if (!$this->isConnected()) {
                    $result .= "</div>";
                }
            }
        $result .= "</div>";
        return $result;
    }
}