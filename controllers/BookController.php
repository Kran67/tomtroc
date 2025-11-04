<?php 

class BookController 
{
    /**
     * Affiche la page d'accueil.
     * @return void
     */
    public function showHome() : void
    {
        $bookManager = new BookManager();
        $books = $bookManager->getLastBooks();

        $view = new View("Home");
        $view->render("home", ['books' => $books]);
    }

    /**
     * Affiche la page des livres à échanger.
     * @return void
     */
    public function showBooks(string $bookTitle) : void
    {
        $bookManager = new BookManager();
        $books = $bookManager->getAllBooks($bookTitle);

        $view = new View("Books");
        $view->render("books", ['books' => $books]);
    }
}
