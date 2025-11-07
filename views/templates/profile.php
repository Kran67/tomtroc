<?php
    /**
     * Affichage du détail du profile d'un utilisateur.
     */
?>
<div class="profile-main">
    <div class="profile-container">
    <?= $user->getCard() ?>
    <?= $user->getBooks($books) ?>
    <div>
<div>