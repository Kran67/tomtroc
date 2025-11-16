<?php
    /**
     * Affichage du détail du profil d'un utilisateur.
     */
?>
<div class="profile-main">
    <div class="profile-container">
        <?= /** @var User $user */
    $user->getCard() ?>
        <?= /** @var Array $books */
    $user->getBooks($books) ?>
    <div>
<div>