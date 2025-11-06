<?php 
    /** 
     * Template du formulaire d'update/creation d'un livre. 
     */
?>
<div class="book-form-main">
    <a class="book-form-back" <?= Utils::back(); ?> href="#">&#8592; retour</a>
    <h2><?= $book->getId() === -1 ? "Création d'un livre" : "Modifier les informations"?></h2>
    <form class="book-form" action="index.php" method="post">
        <div class="book-form-left">
            <div class="book-form-image-title">Photo</div>
            <div class="book-form-image-container">
                <img class="book-form-image" src="<?= IMG_BOOKS.$book->getImage() ?>" alt="avatar" />
            </div>
            <a class="book-form-image-upload" href="/?action=">Modifier la photo</a>
        </div>
        <div class="book-form-right">
            <div class='book-form-row'>
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" value="<?= $book->getTitle() ?>" required>
            </div>
            <div class='book-form-row'>
                <label for="author">Auteur</label>
                <input type="text" name="author" id="author" value="<?= $book->getAuthor() ?>" required>
            </div>
            <div class='book-form-row'>
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="30" rows="10" required><?= $book->getDescription() ?></textarea>
            </div>
            <div class='book-form-row'>
                <label for="availability">Disponibilité</label>
                <select id="availability" name="availability">
                    <option value="disponible">disponible</option>
                    <option value="indisponible">non disponible</option>
                </select>
                <!-- <textarea name="availability" id="availability" cols="30" rows="10" required><?= $book->getDescription() ?></textarea> -->
            </div>
            <input type="hidden" name="action" value="updateBook">
            <input type="hidden" name="id" value="<?= $book->getId() ?>">
            <button class="cta book-submit-btn">Valider</button>
        </div>
    </form>
</div>