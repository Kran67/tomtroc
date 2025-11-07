<?php

/**
 * Classe qui gère les livres.
 */
class BookManager extends AbstractEntityManager 
{
    /**
     * Récupère tous les livres.
     * @return array : un tableau d'objets Book.
     */
    public function getAllBooks(string $bookTitle) : array
    {
        $sqlParams = [];
        $sql = BASE_BOOK_QUERY;
        if (!empty($bookTitle)) {
            $sql .= " WHERE b.title like :bookTitle ";
            $sqlParams = ['bookTitle' => "%".Utils::format($bookTitle)."%"];
        }
        $result = $this->db->query($sql, $sqlParams);
        $books = [];

        while ($book = $result->fetch()) {
            $books[] = new Book($book);
        }
        return $books;
    }
    
    /**
     * Récupère les 4 derniers livres ajoutés.
     * @return array : un tableau d'objets Book.
     */
    public function getLastBooks() : array
    {
        $sql = BASE_BOOK_QUERY ." ORDER BY created_at LIMIT 0, 4";
        $result = $this->db->query($sql);
        $books = [];

        while ($book = $result->fetch()) {
            $books[] = new Book($book);
        }
        return $books;
    }
    
    /**
     * Récupère un livre par son id.
     * @param int $id : l'id du livre.
     * @return Book|null : un objet Book ou null si le livre n'existe pas.
     */
    public function getBookById(int $id) : ?Book
    {
        $sql = BASE_BOOK_QUERY ." WHERE b.id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $book = $result->fetch();
        if ($book) {
            return new Book($book);
        }
        return null;
    }

    /**
     * Ajoute ou modifie un livre.
     * On sait si le livre est un nouveau livre car son id sera -1.
     * @param Book $book : le livre à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdateBook(Book $book) : void 
    {
        if ($book->getId() == -1) {
            $this->addBook($book);
        } else {
            $this->updateBook($book);
        }
    }

    /**
     * Ajoute un livre.
     * @param Book $livre : le livre à ajouter.
     * @return void
     */
    public function addBook(Book $book) : void
    {
        $sql = "INSERT INTO book (user_id, title, author, image, description, status, created_at, updated_at) VALUES (:id_user, :title, :author, :image, :description, :status, NOW(), NOW())";
        $this->db->query($sql, [
            'id_user' => $book->getUserId(),
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'image' => $book->getImage(),
            'description' => $book->getDescription(),
            'status' => $book->getStatus()
        ]);
    }

    /**
     * Modifie un livre.
     * @param Book $book : le livre à modifier.
     * @return void
     */
    public function updateBook(Book $book) : void
    {
        $sql = "UPDATE book SET title = :title, author = :author, image = :image, description = :description, statut = :statut, date_update = NOW() WHERE id = :id";
        $this->db->query($sql, [
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'image' => $book->getImage(),
            'description' => $book->getDescription(),
            'status' => $book->getStatus(),
        ]);
    }

    /**
     * Supprime un livre.
     * @param int $id : l'id du livre à supprimer.
     * @return void
     */
    public function deleteBook(int $id) : void
    {
        $sql = "DELETE FROM book WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }

    /**
     * Récupère le nombre de livre pour un utilisateur.
     * @return int : le nombre de livres.
     */
    public function getBookCountByUserId(int $userId) : int
    {
        $sql = "SELECT count(id) as count FROM book WHERE user_id = :userId";
        $query = $this->db->query($sql, ['userId' => $userId]);
        $result = $query->fetch();

        if (!$result) $result = 0;
        return $result["count"];
    }

    /**
     * Récupère tous les livres d'un utilisateur.
     * @return array : un tableau d'objets Book.
     */
    public function getAllBooksFromUserId(int $userId) : array
    {
        $sql = BASE_BOOK_QUERY ." WHERE b.user_id = :userId ORDER BY b.created_at";
        $result = $this->db->query($sql, ['userId' => $userId]);
        $books = [];

        while ($book = $result->fetch()) {
            $books[] = new Book($book);
        }
        return $books;
    }
}