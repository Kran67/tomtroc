<?php
    /**
     * Affichage du détail d'un livre.
     */
?>
<div class="book-detail-breadcrumb"><a href="./?action=books">Nos livres</a>&nbsp;> <?= Utils::format($book->getTitle()) ?></div>
<div class="book-detail-main">
    <div class="book-detail-img-container">    
        <img class="book-detail-img" src="<?= IMG_BOOKS.$book->getImage() ?>" />
    </div>
    <div class="book-detail-detail">
        <div class="book-detail-title"><?= Utils::format($book->getTitle()) ?></div>
        <div class="book-detail-author">par <?= Utils::format($book->getAuthor()) ?></div>
        <hr class="book-detail-sep" />
        <div class="book-detail-desc-title">DESCRIPTION</div>
        <div class="book-detail-desc"><?= Utils::formatToParagraph($book->getDescription()) ?></div>
        <div class="book-detail-owner-title">PROPRIÉTAIRE</div>
        <div class="book-detail-owner"><?= $user ?></div>
        <a class="cta book-detail-button" href="./?action=sendmsg&id=<?= $user->getId() ?>">Envoyer un message</a>
    </div>
</div>
