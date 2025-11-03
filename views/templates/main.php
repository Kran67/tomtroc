<?php 
/**
 * Ce fichier est le template principal qui "contient" ce qui aura été généré par les autres vues.  
 * 
 * Les variables qui doivent impérativement être définie sont : 
 *      $title string : le titre de la page.
 *      $content string : le contenu de la page. 
 */
$action = Utils::request('action', 'home');
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
            <a href="./" class="logo">
                <img src="./img/logo.png" alt="logo" />
            </a>
            <a href="./" class="home <?php if ($action === 'home') echo 'active'; ?>">Accueil</a>
            <a href="./" class="exchangeBooks <?php if ($action === 'books') echo 'active'; ?>">Nos livres à l’échange</a>
            <div class="line"></div>
            <a href="./" class="messaging <?php if ($action === 'messaging') echo 'active'; ?>">
                <img src="./img/messaging.svg" alt="messagerie" />
                <span class="messagingTxt">Messagerie</span><span class="bubble">
                    <span class="bubbleText">0</span>
                </span>
            </a>
            <a href="./" class="account <?php if ($action === 'account') echo 'active'; ?>">
                <img src="./img/account.svg" alt="compte" />
                <span class="accountTxt">Mon compte</span>
            </a>
            <a href="./" class="signin" <?php if ($action === 'signin') echo 'active'; ?>">Connexion</a>
        </nav>
    </header>

    <main>    
        <?= $content /* Ici est affiché le contenu réel de la page. */ ?>
    </main>
    
    <footer>
        <span class="privacy-policy">Politique de confidentialité</span>
        <span class="legal-notice">Mentions légales</span>
        <span class="title">Tom Troc©</span>
        <img src="./img/min/logo.png" alt="logo_min" class="logo-min" />
    </footer>

</body>
</html>