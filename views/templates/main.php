<?php 
/**
 * Ce fichier est le modèle principal qui "contient" ce qui aura été généré par les autres vues.
 * 
 * Les variables qui doivent impérativement être définie sont : 
 *      $title string : le titre de la page.
 *      $content string : le contenu de la page. 
 */
$action = $_SESSION['action'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TomTroc</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="./script/main.js"></script>
</head>

<body>
    <form action="./" method="post" enctype="multipart/form-data">
        <input type="hidden" id="action" name="action" value="<?= $action ?>">
        <input type="hidden" id="screenWidth" name="screenWidth">
        <input type="hidden" id="id" name="id">
        <input type="hidden" id="userId" name="userId">
        <header>
            <nav class="header" <?= Utils::openBurger() ?>>
                <div class="spacer"></div>    
                <div class="spacer"></div>
                <button type="submit" class="logo" <?= Utils::changeAction("home"); ?>>
                    <img src="<?= IMG."logo.png" ?>" alt="logo">
                </button>
                <button type="submit" class="home <?php if ($action === 'home') echo 'active'; ?>" <?= Utils::changeAction("home"); ?>>Accueil</button>
                <button type="submit" class="books link exchangeBooks <?php if ($action === 'books') echo 'active'; ?>" <?= Utils::changeAction("books"); ?>>Nos livres à l’échange</button>
                <div class="spacer"></div>    
                <div class="line"></div>
                <button type="submit" class="messaging <?php if ($action === 'messaging' || $action === 'sendMessage' || $action === 'changeDiscussion') echo 'active'; ?>" <?= Utils::changeAction("messaging"); ?>>
                    <img src="<?= IMG . 'messaging.svg' ?>" alt="messagerie">
                    <span class="messagingTxt">Messagerie</span><span class="bubble"><?= $_SESSION['unReadMessages'] ?></span>
                </button>
                <button type="submit" class="account <?php if ($action === 'account') echo 'active'; ?>" <?= Utils::changeAction("account"); ?>>
                    <img src="<?= IMG . 'account.svg' ?>" alt="compte">
                    <span class="accountTxt">Mon compte</span>
                </button>
                <button type="submit" class="sign signin <?php if ($action === 'signin') echo 'active'; ?>" <?= Utils::changeAction(isset($_SESSION['idUser']) ? "logout" : "signin"); ?>>
                    <?= isset($_SESSION['idUser']) ? "Déconnexion" : "Connexion" ?>
                </button>
                <div class="spacer"></div>
            </nav>
        </header>

        <main>    
            <?= /** @var string $content */
            $content /* Ici est affiché le contenu réel de la page. */ ?>
        </main>
        
        <footer>
            <span class="privacy-policy">Politique de confidentialité</span>
            <span class="legal-notice">Mentions légales</span>
            <span class="copyright">Tom Troc©</span>
            <img src="<?= IMG_MIN.'logo.png' ?>" alt="logo_min" class="logo-min">
        </footer>
    </form>
</body>
</html>