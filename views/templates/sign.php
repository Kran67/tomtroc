<?php
    /**
     * Affichage de la page de connexion / inscription.
     */
?>
<div class="sign">
    <div class="sign-form-container">
        <div class="sign-title"><?= /** @var Bool $signup */
            $signup ? "Inscription" : "Connexion" ?></div>
        <?php if ($signup) {?>
            <div class="sign-form-row">
                <label for="nickname">Pseudo</label>
                <input name="nickname" id="nickname" type="text">
            </div>
        <?php }?>
        <div class="sign-form-row">
            <label for="email">Adresse email</label>
            <input name="email" id="email" type="text">
        </div>
        <div class="sign-form-row">
            <label for="password">Mot de passe</label>
            <input name="password" id="password" type="password">
        </div>
        <button class="cta sign-submit-btn" <?= Utils::changeAction($signup ? "addUser" : "login") ?>><?= $signup ? "S'inscrire" : "Se connecter" ?></button>
        <div class="sign-ask"><?= $signup ? "Déjà inscrit" : "Pas de compte" ?> ? <button type="submit" <?= Utils::changeAction($signup ? "signin" : "signup")?>><?= $signup ? "Connectez-vous" : "Inscrivez-vous" ?></button></div>
    </div>
    <img src="<?= IMG ?>connexion.jpg" alt="connection">
</div>