<?php 
    /** 
     * Modèle du formulaire de mise à jour / création d'un livre.
     */

    use App\src\services\Utils;
?>
<div class="book-form-main">
    <div class="book-form-container">
        <button type="submit" class="book-form-back" <?= Utils::changeAction("account") ?> >&#8592; retour</button>
        <h2><?= /** @var Book $book */
            empty($book->getId()) ? "Création d'un livre" : "Modifier les informations"?></h2>
        <div class="book-form">
            <div class="book-form-left">
            <div class="book-form-image-title">Photo</div>
                <div class="book-form-image-container">
                    <img id="book-image" class="book-form-image" src="<?= IMG_BOOKS.Utils::format($book->getImage()) ?>" alt="Couverture du livre : '<?= Utils::format($book->getTitle()) ?>'">
                </div>
                <label for="imageUpload" class="link book-form-image-upload">Modifier la photo</label>
            </div>
            <div class="book-form-right">
                <div class='book-form-row'>
                    <label for="title">Titre</label>
                    <input type="text" name="title" id="title" value="<?= Utils::format($book->getTitle()) ?>" required maxlength="100">
                </div>
                <div class='book-form-row'>
                    <label for="author">Auteur</label>
                    <input type="text" name="author" id="author" value="<?= Utils::format($book->getAuthor()) ?>" required maxlength="30">
                </div>
                <div class='book-form-row'>
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10" required><?= Utils::format($book->getDescription()) ?></textarea>
                </div>
                <div class='book-form-row'>
                    <label for="availability">Disponibilité</label>
                    <select id="availability" name="availability">
                        <option value="disponible">disponible</option>
                        <option value="indisponible" <?= $book->getStatus() === "indisponible" ? "selected" : "" ?>>non disponible</option>
                    </select>
                </div>
                <input type="file" name="imageUpload" id="imageUpload" accept=".jpg, .png, .gif" <?= Utils::onChangeImage('book-image') ?>>
                <input type="hidden" name="image" value="<?= $book->getImage() ?>">
                <button class="cta book-submit-btn" <?= Utils::changeAction("updateBook", "{'id': '".$book->getId()."'}") ?>>Valider</button>
            </div>
        </div>
    </div>
</div>