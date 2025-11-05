<?php
    /**
     * Affichage du détail d'un utilisateur.
     */
?>
<div class="account-main">
    <div class="account-title">Mon compte</div>
    <div class="account-detail">
        <?= $user->getCard() ?>
        <?= $user->getUpdateForm() ?>
    </div>
    <?= $user->getBooks($books) ?>
<div>