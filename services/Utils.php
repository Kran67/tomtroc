<?php

use JetBrains\PhpStorm\NoReturn;

/**
 * Classe utilitaire : cette classe ne contient que des fonctions statiques qui peuvent être appelées
 * directement sans avoir besoin d'instancier un objet Utils.
 * Exemple : Utils::redirect('home'); 
 */
class Utils {
    /**
     * Convertit une date vers le format de type "samedi 15 juillet 2023" en francais.
     * @param DateTime|null $date : la date à convertir.
     * @param string $pattern
     * @return string : la date convertie.
     */
    public static function convertDateToFrenchFormat(?DateTime $date, string $pattern = 'EEEE d MMMM Y') : string
    {
        // Attention, s'il y a un souci lié à IntlDateFormatter c'est qu'il faut
        // activer l'extension intl_date_formater (ou intl) au niveau du serveur apache.
        // Ca peut se faire depuis php.ini ou parfois directement depuis votre utilitaire (wamp/mamp/xamp)
        if (!isset($date)) {
            return "";
        } else {
            $dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
            $dateFormatter->setPattern($pattern);
            return $dateFormatter->format($date);
        }
    }

    /**
     * Redirige vers une URL.
     * @param string $action : l'action que l'on veut faire (correspond aux actions dans le routeur).
     * @return void
     */
    #[NoReturn] public static function redirect(string $action) : void
    {
        $_SESSION['action'] = $action;
        $url = "./";
        header("Location: $url");
        exit();
    }

    /**
     * Cette fonction retourne le code js à insérer en attribut d'un bouton.
     * Pour ouvrir une popup "confirm", et n'effectuer l'action que si l'utilisateur
     * a bien cliqué sur "ok".
     * @param string $message : le message à afficher dans la popup.
     * @return string : le code js à insérer dans le bouton.
     */
    public static function askConfirmation(string $message) : string
    {
        return "onclick=\"return confirm('$message');\"";
    }

    /**
     * Cette fonction retourne le code js à insérer en attribut d'un élément HTML.
     * Retour en arrière.
     * @return string : le code js à insérer dans le bouton.
     */
    public static function back() : string
    {
        return "onclick=\"history.back();\"";
    }

    /**
     * Cette fonction protège une chaine de caractères contre les attaques XSS.
     * @param string $string : la chaine à protéger.
     * @return string : la chaine protégée.
     */
    public static function format(string $string) : string
    {
        // Étape 1, on protège le texte avec htmlspecialchars.
        return htmlspecialchars($string, ENT_QUOTES);
    }

    public static function formatToParagraph(string $string) : string
    {
        // Étape 1, on protège le texte avec htmlspecialchars.
        $finalString = htmlspecialchars($string, ENT_QUOTES);

        // Étape 2, le texte va être découpé par rapport aux retours à la ligne,
        $lines = explode("\n", $finalString);

        // On reconstruit en mettant chaque ligne dans un paragraphe (et en sautant les lignes vides).
        $finalString = "";
        foreach ($lines as $line) {
            if (trim($line) != "") {
                $finalString .= "<p>$line</p>";
            }
        }
        
        return $finalString;
    }

    /**
     * Cette fonction permet de récupérer une variable de la superglobale $_REQUEST.
     * Si cette variable n'est pas définie, on retourne la valeur null (par défaut)
     * ou celle qui est passée en paramètre si elle existe.
     * @param string $variableName : le nom de la variable à récupérer.
     * @param mixed $defaultValue : la valeur par défaut si la variable n'est pas définie.
     * @return mixed : la valeur de la variable ou la valeur par défaut.
     */
    public static function request(string $variableName, mixed $defaultValue = null) : mixed
    {
        return $_REQUEST[$variableName] ?? $defaultValue;
    }

    /**
     * À noter qu'il vous faudra configurer le timezone pour afficher la bonne différence, à la minute prés
     * Le timezone pour la France :
     * date_default_timezone_set("europe/paris");
     * À utiliser en haut du document
     */
    public static function differenceDate(DateTime $firstDate, ?DateTime $lastDate = null): array
    {
        //on part du principe que $firstDate et $lastDate peut être envoyé sous deux formats : un timestamp ou une date formatée
        
        //on vérifie donc le format envoyé, pour le mettre en date formatée si c'est un timestamp :
        //is_numeric vérifie si c'est un nombre entier (un timestamp est un nombre entier)
        //$firstDate = is_numeric($firstDate) ? date("d-m-Y H:i:s", $firstDate) : $firstDate;
        
        //on crée ensuite la date via date_create (Retourne un nouvel objet DateTime (DateTime: Représentation d'une date et heure))
        //$firstDate = date_create($firstDate);
        $maintenant = !isset($lastDate) ? date_create() : $lastDate;
        
        //date_diff nous donne maintenant des valeurs sur les représentations ci-dessus
        $interval = date_diff($maintenant, $firstDate);
        
        //on récupère les valeurs d'$interval qui nous intéresse
        $y = $interval->y;//années
        $m = $interval->m;//mois
        $d = $interval->d;//jours
        $h = $interval->h;//heures
        $i = $interval->i;//minutes
        $s = $interval->s;//secondes
        $invert = $interval->invert;//0 = $firstDate est dans le futur, 1 = $firstDate est dans le passé
        $texte_invert = $invert === (!isset($lastDate) ? 1 : 0) ? "depuis" : "Dans";//il y a une différence lorsqu'on demande un interval ou si on demande "depuis $firstDate seulement":
        //depuis $firstDate seulement: 1 = $firstDate est dans le futur, 0 = $firstDate est dans le passé
        //interval entre $firstDate et $lastDate: 0 = $firstDate est dans le futur, 1 = $firstDate est dans lea passé
        $days = $interval->days;//nombre de jours écoulés (depuis combien ou dans combien, nombre entier positif)
        
        //enfin, on retourne les différences pour les afficher :
        
        //s'il y a plus d'un an, on affiche le nombre d'années plus le nombre de jours ("5 ans et 18 jours" par exemple)
        if ($y > 0) $texte = "$texte_invert $y an".($y > 1 ? "s" : "").($d > 0 ? " et ".$d." jour".($d > 1 ? "s" : "") : "");
        //s'il y a moins d'un an, on affiche les mois et les jours ("5 mois et 24 jours" par exemple)
        elseif ($m > 0) $texte = "$texte_invert $m mois".($d > 0 ? " et $d jour".($d > 1 ? "s" : "") : "");
        //s'il y a moins d'un mois, on affiche les jours, évidemment
        elseif ($d > 0) $texte = "$texte_invert $d jour".($d > 1 ? "s" : "");
        //les heures s'il y a moins d'un jour
        elseif ($h > 0) $texte = "$texte_invert $h heure".($h > 1 ? "s" : "");
        //les minutes s'il y a moins d'une heure
        elseif ($i > 0) $texte = "$texte_invert $i minute".($i > 1 ? "s" : "");
        // et les secondes s'il y a moins d'une minute
        elseif ($s > 0) $texte = "$texte_invert $s seconde".($s > 1 ? "s" : "");
        
        //si toutes les précédentes valeurs précédentes sont à 0, c'est forcément que c'est maintenant/aujourd'hui (s'affiche seulement si les heures et minutes ne sont pas précisées)
        else $texte = "Depuis aujourd'hui!";
        
        //on retourne un tableau, au moins on pourra afficher la ou les valeurs voulues
        return [
                "texte" => $texte,//notre texte formaté du genre "Il y a 5 heures" ou "Dans 1 mois et 12 jours", par exemple
                "y" => $y,
                "m" => $m,
                "d" => $d,
                "h" => $h,
                "i" => $i,
                "s" => $s,
                "invert" => $invert,
                "texte_invert" => $texte_invert,
                "days" => $days,
            ];
    }

    /**
     * Fonction qui génère un identifiant unique de type UUID
     * @param null $data
     * @return string
     * @throws Exception
     */
    public static function guidv4($data = null): string
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Cette fonction retourne le code js à insérer en attribut d'un élément HTML.
     * @param string $imgId : identifiant de l'image dans le DOM.
     * @return string : le code js à insérer dans le bouton.
     */
    public static function onChangeImage(string $imgId) : string
    {
        return "onchange=\"imageChanged(this, '".$imgId."');\"";
    }

    /**
     * Cette fonction retourne le code js à insérer en attribut d'un élément HTML.
     * @return string : le code js à insérer dans le bouton.
     */
    public static function onSendMessage() : string
    {
        if (isset($_SESSION) && !isset($_SESSION["idUser"])) {
            return "onclick=\"alert('Vous devez vous connecter pour envoyer un message.'); return false;\"";
        }
        return "";
    }

    /**
     * Cette fonction permet de changer de page lorsque l'utilisateur clique sur un bouton
     * @param $newAction : nouvelle action
     * @param $params : les valeurs à mettre dans les champs cachés
     * @return string : le code à mettre deans le HTML du bouton
     */
    public static function changeAction(string $newAction, string $params = "{}") : string
    {
        return "onclick=\"changeAction('".$newAction."', ".$params.");\"";
    }

    /**
     * Cette fonction ajoute un événement onclick sur un bouton pour ouvrir le menu burger
     * @return string : le code à mettre deans le HTML du bouton
     */
    public static function openBurger() : string
    {
        return "onclick=\"this.classList.toggle('open');\"";
    }

    /**
     * Cette fonction ajoute un événemen onkeydown sur le formulaire principal
     * @return string : le code à mettre deans le HTML du bouton
     */
    public static function preventEnter() {
        return "onkeydown=\"return preventEnter(event);\"";
    }
}