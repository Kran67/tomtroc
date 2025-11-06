<?php
    /**
     * Affichage du détail du profile d'un utilisateur.
     */
?>
<div class="profile-main">
    <?= $user->getCard() ?>
    <?= $user->getBooks($books) ?>
<div>