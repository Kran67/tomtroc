<?php 

namespace App\src\controllers;

use App\src\dao\BookDAO;
use App\src\dao\UserDAO;
use App\src\models\View;
use Exception;

class BookController 
{
    /**
     * Affiche la page d'accueil.
     * @return void
     * @throws Exception
     */
    public function showHome() : void
    {
        $bookDao = new BookDAO();
        $books = $bookDao->getLastBooks();

        $view = new View("Home");
        $view->render("home", ['books' => $books]);
    }

    /**
     * Affiche la page des livres à échanger.
     * @param string $bookTitle
     * @return void
     * @throws Exception
     */
    public function showBooks(string $bookTitle) : void
    {
        $bookDao = new BookDAO();
        $books = $bookDao->getAllBooks($bookTitle);

        $view = new View("Books");
        $view->render("books", ['books' => $books, 'filter' => $bookTitle]);
    }

    /**
     * Affiche du détail d'un livre.
     * @param string $bookId : identifiant du livre
     * @return void
     * @throws Exception
     */
    public function showBookDetail(string $bookId) : void
    {
        $bookDao = new BookDAO();
        $book = $bookDao->getBookById($bookId);

        if (!$book) {
            throw new Exception("Le livre demandé n'existe pas.");
        }

        $userDao = new UserDAO();
        $user = $userDao->getUserById($book->getUserId());

        $view = new View("Book");
        $view->render("book", ['book' => $book, 'user' => $user]);
    }
}
