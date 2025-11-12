<?php
    /**
     * Affichage des livres à l'échange.
     */
?>
<div class="exchange-books-main">
    <div class="exchange-books-bar">    
        <div class="exchange-books-title">Nos livres à l’échange</div>
            <input name="title" id="title" class="exchange-books-searchbar" type="text"
                   placeholder="Rechercher un livre" value="<?= /** @var string $filter */
            $filter ?>">
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