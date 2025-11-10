<?php
    /**
     * Affichage du détail d'un livre.
     */
?>
<div class="book-detail">
    <div class="book-detail-container">
        <div class="book-detail-breadcrumb">
            <form class="flex" action="./" method="post">
                <input type="hidden" name="action" value="books">
                <button type="submit">Nos livres</button>
            </form>
            &nbsp; > <?= Utils::format($book->getTitle()) ?>
        </div>
        <div class="book-detail-main">
            <div class="book-detail-img-container">    
                <img id="book-image" class="book-detail-img" src="<?= Utils::format(IMG_BOOKS.$book->getImage()) ?>">
            </div>
            <div class="book-detail-detail">
                <div class="book-detail-title"><?= Utils::format($book->getTitle()) ?></div>
                <div class="book-detail-author">par <?= Utils::format($book->getAuthor()) ?></div>
                <hr class="book-detail-sep">
                <div class="book-detail-desc-title">DESCRIPTION</div>
                <div class="book-detail-desc"><?= Utils::formatToParagraph($book->getDescription()) ?></div>
                <div class="book-detail-owner-title">PROPRIÉTAIRE</div>
                <div class="book-detail-owner"><?= $user ?></div>
                <form class="flex" action="./" method="post">
                    <input type="hidden" name="action" value="createOrViewDiscussion">
                    <input type="hidden" name="id" value="<?= $user->getId() ?>">
                    <button class="cta book-detail-button" <?= Utils::onSendMessage(); ?>>Envoyer un message</button>
                </form>
            </div>
        </div>
    </div>
</div>
