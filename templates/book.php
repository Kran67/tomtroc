<?php
    /**
     * Affichage du détail d'un livre.
     */

    use App\src\services\Utils;
    
?>
<div class="book-detail">
    <div class="book-detail-container">
        <div class="book-detail-breadcrumb">
            <button type="submit" <?= Utils::changeAction("books"); ?>>Nos livres</button>
            &nbsp; > <?= Utils::format($book->getTitle()) ?>
        </div>
        <div class="book-detail-main">
            <div class="book-detail-img-container">    
                <img id="book-image" class="book-detail-img" src="<?= Utils::format(IMG_BOOKS.$book->getImage()) ?>" alt="Couverture du livre : '<?= Utils::format($book->getTitle()) ?>'">
            </div>
            <div class="book-detail-detail">
                <div class="book-detail-title"><?= Utils::format($book->getTitle()) ?></div>
                <div class="book-detail-author">par <?= Utils::format($book->getAuthor()) ?></div>
                <hr class="book-detail-sep">
                <div class="book-detail-desc-title">DESCRIPTION</div>
                <div class="book-detail-desc"><?= Utils::formatToParagraph($book->getDescription()) ?></div>
                <div class="book-detail-owner-title">PROPRIÉTAIRE</div>
                <div class="book-detail-owner"><?= $user ?></div>
                <button class="cta book-detail-button" <?= Utils::onSendMessage(); ?>
                    <?= Utils::changeAction("createOrViewDiscussion", "{ 'id': '".$user->getId()."'}"); ?>>Envoyer un message</button>
            </div>
        </div>
    </div>
</div>
