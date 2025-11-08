<?php
    /**
     * Affichage des livres à l'échange.
     */
?>
<div class="exchange-books-main">
    <div class="exchange-books-bar">    
        <div class="exchange-books-title">Nos livres à l’échange</div>
        <form action="./" method="post">
            <input type="hidden" name="action" value="books">
            <input name="title" id="title" class="exchange-books-searchbar" type="text" placeholder="Rechercher un livre" value="<?= $filter ?>">
        </form>
    </div>
    <div class="exchange-books_grid">
        <?php
            foreach($books as $book) {
                echo $book;
            }
        ?>
    </div>
</div>