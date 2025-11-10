<?php
    /**
     * Modèle pour afficher une page d'erreur.
     */
?>

<div class="error">
    <?php
    /** @var string $errorMessage */
    if ($errorMessage === "La page demandée n'existe pas.") {
        ?>
        <h2 class="error-code">404</h2>
        <p class="error-title">Oups, cette page est introuvable !</p>
        <p class="error-link">Le lien est peut-être corrompu.</p>
        <p class="error-page-removed">ou la page a peut-être été supprimée</p>
    <?php } else { ?>
        <p class="error-title"><?= $errorMessage ?></p>
    <?php } ?>
    <form class="flex" action="./" method="post">
        <button type="submit" class="cta error-go-home">Retour à la page d'accueil</button>
    </form>
</div>
