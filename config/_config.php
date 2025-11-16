<?php
    
    // En fonction des routes utilisées, il est possible d'avoir besoin de la session ; on la démarre dans tous les cas. 
    session_start();

    // Ici on met les constantes utiles, 
    // les données de connexions à la bdd
    // et tout ce qui sert à configurer. 

    define('TEMPLATE_VIEW_PATH', '../templates/'); // Le chemin vers les templates de vues.
    define('MAIN_VIEW_PATH', TEMPLATE_VIEW_PATH . 'main.php'); // Le chemin vers le template principal.
    define('IMG', '../public/img/'); // Le chemin vers les images.
    define('IMG_MIN', '../public/img/min/'); // Le chemin vers les images miniatures.
    define('IMG_BOOKS', '../public/img/books/'); // Le chemin vers les images des livres.
    define('IMG_BOOKS_MIN', '../public/img/books/min/'); // Le chemin vers les images des livres.
    define('IMG_AVATARS', '../public/img/avatars/'); // Le chemin vers les images.
    define('BASE_BOOK_QUERY', 'SELECT b.*, u.nickname as user_nickname FROM book b LEFT JOIN user u ON u.id = b.user_id');

    define('DB_HOST', 'localhost');
    define('DB_NAME', 'tomtroc');
    define('DB_USER', 'root');
    define('DB_PASS', '');

