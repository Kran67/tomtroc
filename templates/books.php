<?php
    /**
     * Affichage des livres à l'échange.
     */
?>
<div class="exchange-books-main">
    <div class="exchange-books-bar">    
        <div class="exchange-books-title">Nos livres à l’échange</div>
            <input name="searchTitle" id="searchTitle" class="exchange-books-searchbar" type="text"
                   placeholder="Rechercher un livre" value="<?= /** @var string $filter */
            $filter ?>" aria-label="Rechercher un livre">
    </div>
    <div class="exchange-books_grid">
        <?php
            /** @var array $books */
            foreach($books as $book) {
                echo $book;
            }
        ?>
    </div>
</div>