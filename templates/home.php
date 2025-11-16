<?php
    /**
     * Affichage des 4 derniers livres.
     */

    use App\src\services\Utils;
?>
<div class="home-top-part">
    <div class="left-part">
        <div class="title home-top-part-title">Rejoignez nos lecteurs passionnés</div>
        <div class="home-top-part-desc">Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.</div>
        <button type="submit" class="cta home-top-part-button" <?= Utils::changeAction("books"); ?> >Découvrir</button>
    </div>
    <div class="right-part"></div>
</div>
<div class="home-middle-part">
    <div class="home-middle-part-title">Les derniers livres ajoutés</div>
    <div class="home-middle-part-books">
        <?php
        /** @var array $books */
        foreach($books as $book) {
                echo $book;
            }
        ?>
    </div>
    <button type="submit" class="cta home-middle-part-button" <?= Utils::changeAction("books"); ?> >Voir tous les livres</button>
</div>
<div class="home-bottom-part">
    <div class="title">Comment ça marche ?</div>
    <div class="home-bottom-part-desc">Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour commencer :</div>
    <div class="home-bottom-part-steps">
        <div class="home-bottom-part-step">Inscrivez-vous gratuitement sur notre plateforme.</div>
        <div class="home-bottom-part-step">Ajoutez les livres que vous souhaitez échanger à votre profil.</div>
        <div class="home-bottom-part-step">Parcourez les livres disponibles chez d'autres membres.</div>
        <div class="home-bottom-part-step">Proposez un échange et discutez avec d'autres passionnés de lecture.</div>
    </div>
    <button type="submit" class="cta cta2 home-bottom-part-button" <?= Utils::changeAction("books"); ?> >Voir tous les livres</button>
    <div class="home-bottom-part-image"></div>
    <div class="home-bottom-part-our-values">
        <div class="title">Nos valeurs</div>
        <div class="home-bottom-part-desc2">
            Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.
            <br><br>
            Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé.
            <br><br>
            Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.
        </div>
        <div class="home-bottom-part-signature">L’équipe Tom Troc</div>
    </div>
</div>