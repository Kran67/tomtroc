<?php
    /**
     * Affichage du détail du profil d'un utilisateur.
     */
$userId = isset($_SESSION) && isset($_SESSION['idUser']) ? $_SESSION['idUser'] : '';
?>
<div class="messaging-main">
    <div class="messaging-discussions">
        <div class="messaging-discussions-title">Messagerie</div>
        <div class="messaging-discussions-container">
        <?php
        /** @var array $discussions */
        foreach($discussions as $discussion) {
                echo $discussion;
            }
        ?>
        </div>
    </div>
    <div class="messaging-current-discussion">
        <div class="messaging-current-discussion-header">
            <div class='discussion-image-container'>
                <img src='<?= /** @var Discussion $current_discussion */
                IMG_AVATARS.Utils::format($current_discussion->getAvatar()); ?>' alt='avatar'>
            </div>
            <?= $current_discussion->getNickname(); ?>
        </div>
        <div class="discussion-messages-container">
            <div class="discussion-messages">
                <?php
                /** @var array $current_discussion_messages */
                foreach($current_discussion_messages as $message) {
                ?>
                        <div class="messaging-current-discussion-container">
                            <div class="messaging-current-discussion-message-header <?= $message->getUserId() === $userId ? 'connected-user' : '' ?>">
                                <div class="messaging-current-discussion-image-container <?= $message->getUserId() === $userId ? 'hidden' : '' ?>">
                                    <img src="<?= IMG_AVATARS.Utils::format($message->getAvatar()); ?>" alt="avatar">
                                </div>
                                <span><?= Utils::convertDateToFrenchFormat($message->getSentAt(), "dd:MM HH:mm"); ?></span>
                            </div>
                            <div class="messaging-current-discussion-message-content <?= $message->getUserId() === $userId ? 'connected-user' : '' ?>">
                                <span><?= $message->getContent(); ?></span>
                            </div>
                        </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <form class="messaging-send-message-form" action="./" method="post">
            <input type="hidden" name="action" value="sendMessage">
            <input type="hidden" name="id" value="<?= $current_discussion->getId() ?>" />
            <input type="hidden" name="userId" value="<?= $userId ?>">
            <input type="text" name="content" placeholder="Tapez votre message ici">
            <button class="cta messaging-submit-btn">Envoyer</button>
        </form>
    </div>
</div>
