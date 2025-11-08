<?php 
/**
 * Ce fichier est le template principal qui "contient" ce qui aura été généré par les autres vues.  
 * 
 * Les variables qui doivent impérativement être définie sont : 
 *      $title string : le titre de la page.
 *      $content string : le contenu de la page. 
 */
$action = Utils::request('action', 'home');
$action = isset($_SESSION) && isset($_SESSION['action']) ? $_SESSION['action'] : $action;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TomTroc</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <header>
        <nav>
            <div></div>    
            <div></div>    
            <form class="flex logo" action="./" method="post">
                <button type="submit">
                    <img src="<?= IMG . 'logo.png' ?>" alt="logo">
                </button>
            </form>
            <form class="flex" action="./" method="post">
                <button type="submit" class="home <?php if ($action === 'home') echo 'active'; ?>">Accueil</button>
            </form>
            <form class="flex" action="./" method="post">
                <input type="hidden" name="action" value="books">
                <button type="submit" class="link exchangeBooks <?php if ($action === 'books') echo 'active'; ?>">Nos livres à l’échange</button>
            </form>
            <div></div>    
            <div class="line"></div>
            <form class="flex" action="./" method="post">
                <input type="hidden" name="action" value="messaging">
                <button type="submit" class="messaging <?php if ($action === 'messaging') echo 'active'; ?>">
                    <img src="<?= IMG . 'messaging.svg' ?>" alt="messagerie">
                    <span class="messagingTxt">Messagerie</span><span class="bubble"><?= $_SESSION['unReadMessages'] ?></span>
                </button>
            </form>
            <form class="flex" action="./" method="post">
                <input type="hidden" name="action" value="account">
                <button type="submit" class="account <?php if ($action === 'account') echo 'active'; ?>">
                    <img src="<?= IMG . 'account.svg' ?>" alt="compte">
                    <span class="accountTxt">Mon compte</span>
                </button>
            </form>
            <form class="flex" action="./" method="post">
                <input type="hidden" name="action" value="<?= isset($_SESSION['idUser']) ? "logout" : "signin" ?>">
                <button type="submit" class="signin <?php if ($action === 'signin') echo 'active'; ?>">
                    <?= isset($_SESSION['idUser']) ? "Déconnexion" : "Connexion" ?>
                </button>
            </form>
            <div></div>
        </nav>
    </header>

    <main>    
        <?= $content /* Ici est affiché le contenu réel de la page. */ ?>
    </main>
    
    <footer>
        <span class="privacy-policy">Politique de confidentialité</span>
        <span class="legal-notice">Mentions légales</span>
        <span class="copyright">Tom Troc©</span>
        <img src="<?= IMG_MIN . 'logo.png' ?>" alt="logo_min" class="logo-min">
    </footer>

</body>
</html>