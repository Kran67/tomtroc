<?php 
    /** 
     * Template du formulaire d'update/creation d'un livre. 
     */
?>
<div class="book-form-main">
    <div class="book-form-container">
        <form class="flex" action="./" method="post">
            <input type="hidden" name="action" value="account">
            <button type="submit" class="book-form-back" <?= Utils::back(); ?>>&#8592; retour</button>
        </form>
        <h2><?= empty($book->getId()) ? "Création d'un livre" : "Modifier les informations"?></h2>
        <form class="book-form" action="./" method="post" enctype="multipart/form-data">
            <div class="book-form-left">
                <div class="book-form-image-title">Photo</div>
                <div class="book-form-image-container">
                    <img id="book-image" class="book-form-image" src="<?= IMG_BOOKS.$book->getImage() ?>" alt="image du livre">
                </div>
                <label for="imageUpload" class="link book-form-image-upload">Modifier la photo</label>
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
                        <option value="indisponible" <?= $book->getStatus() === "indisponible" ? "selected" : "" ?>>non disponible</option>
                    </select>
                </div>
                <input type="hidden" name="action" value="updateBook">
                <input type="hidden" name="id" value="<?= $book->getId() ?>">
                <input type="file" name="imageUpload" id="imageUpload" accept=".jpg, .png, .gif" <?= Utils::onChangeImage('book-image') ?>>
                <input type="hidden" name="image" value="<?= $book->getImage() ?>">
                <button class="cta book-submit-btn">Valider</button>
            </div>
        </form>
    </div>
</div>