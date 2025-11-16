<?php

    use App\src\services\Utils;
    
    /**
     * Affichage du détail du profil d'un utilisateur.
     */
    $userId = isset($_SESSION) && isset($_SESSION['idUser']) ? $_SESSION['idUser'] : '';
    $screenWidth = intval($_SESSION["screenWidth"], 10);
    $action = $_SESSION["action"];
    $isMobileView = $screenWidth <= 377 && $screenWidth > 0;
    $viewDiscussions = $action === "messaging";
    $viewDiscussion = $action === "sendMessage" || $action === "changeDiscussion";
?>
<div class="messaging-main">
    <div class="messaging-discussions <?php echo !$viewDiscussions && $isMobileView ? "hidden" : "" ?> ">
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
    <div class="messaging-current-discussion <?php echo $isMobileView && !$viewDiscussion ? "hidden" : "" ?>">
        <button type="submit" class="messaging-current-discussion-back" <?= Utils::changeAction("messaging") ?> >&#8592; retour</button>
        <div class="messaging-current-discussion-header">
            <div class='discussion-image-container'>
                <img src='<?= /** @var Discussion $current_discussion */
                IMG_AVATARS.Utils::format($current_discussion ? $current_discussion->getAvatar() : ""); ?>' alt="Personne : '<?= $current_discussion->getNickname() ?>'">
            </div>
            <?= $current_discussion ? $current_discussion->getNickname() : ""; ?>
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
                                    <img src="<?= IMG_AVATARS.Utils::format($message->getAvatar()); ?>" alt="Personne : '<?= $current_discussion->getNickname() ?>'">
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
        <div class="messaging-send-message-form">
            <input type="text" name="content" class="content" placeholder="Tapez votre message ici" aria-label="Tapez votre message ici">
            <button class="cta messaging-submit-btn" 
                <?= Utils::changeAction("sendMessage", "{'id':'".($current_discussion ? $current_discussion->getId() : "")."', 'userId': '".$userId."'}") ?>
            >Envoyer</button>
        </div>
    </div>
</div>
