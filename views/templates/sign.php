<?php
    /**
     * Affichage de la page de connexion / inscription.
     */
?>
<div class="sign">
    <div class="sign-form-container">
        <div class="sign-title"><?= $signup ? "Inscription" : "Connexion" ?></div>
        <form class="sign-form" action="" method="post">
            <?php if ($signup) {?>
                <div class="sign-form-row">
                    <label for="nickname">Pseudo</label>
                    <input name="nickname" id="nickname" type="text" />
                </div>
            <?php }?>
            <div class="sign-form-row">
                <label for="email">Adresse email</label>
                <input name="email" id="email" type="text" />
            </div>
            <div class="sign-form-row">
                <label for="password">Mot de passe</label>
                <input name="password" id="password" type="text" />
            </div>
            <button class="cta sign-submit-btn"><?= $signup ? "S'inscrire" : "Se connecter" ?></button>
        </form>
        <div class="sign-ask"><?= $signup ? "Déjà inscrit" : "Pas de compte" ?> ? <a href="?action=<?= $signup ? "signin" : "signup" ?>"><?= $signup ? "Connectez-vous" : "Inscrivez-vous" ?></a></div>
    </div>
    <image src="<?= IMG ?>connexion.jpg" alt="" />
</div>