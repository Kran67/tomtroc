<?php
    /**
     * Affichage du détail du profile d'un utilisateur.
     */
$userId = isset($_SESSION) && isset($_SESSION['idUser']) ? $_SESSION['idUser'] : '';
?>
<div class="messaging-main">
    <div class="messaging-threads">
        <div class="messaging-threads-title">Messagerie</div>
        <div class="messaging-threads-container">
        <?php
            foreach($threads as $thread) {
                echo $thread;
            }
        ?>
        </div>
    </div>
    <div class="messaging-current-thread">
        <div class="messaging-current-thread-header">
            <div class='thread-image-container'>
                <img src='<?= IMG_AVATARS.Utils::format($current_thread->getAvatar()); ?>' alt='avatar'>
            </div>
            <?= $current_thread->getNickname(); ?>
        </div>
        <div class="thread-messages-container">
            <div class="thread-messages">
                <?php
                    foreach($current_thread_messages as $message) {
                ?>
                        <div class="messaging-current-thread-container">
                            <div class="messaging-current-thread-message-header <?= $message->getUserId() === $userId ? 'connected-user' : '' ?>">
                                <div class="messaging-current-thread-image-container <?= $message->getUserId() === $userId ? 'hidden' : '' ?>">
                                    <img src="<?= IMG_AVATARS.Utils::format($message->getAvatar()); ?>" alt="avatar">
                                </div>
                                <span><?= Utils::convertDateToFrenchFormat($message->getSentAt(), "dd:MM HH:mm"); ?></span>
                            </div>
                            <div class="messaging-current-thread-message-content <?= $message->getUserId() === $userId ? 'connected-user' : '' ?>">
                                <span><?= $message->getContent(); ?></span>
                            </div>
                        </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <form class="messaging-send-message-form" action="./" method="post">
            <input type="hidden" name="action" value="sentMessage">
            <input type="hidden" name="id" value="<?= $current_thread->getId() ?>" /    >
            <input type="hidden" name="userId" value="<?= $userId ?>">
            <input type="text" name="message" id="message" placeholder="Tapez votre message ici">
            <button class="cta messaging-submit-btn">Envoyer</button>
        </form>
    </div>
</div>
