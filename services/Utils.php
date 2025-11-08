<?php
/**
 * Classe utilitaire : cette classe ne contient que des méthodes statiques qui peuvent être appelées
 * directement sans avoir besoin d'instancier un objet Utils.
 * Exemple : Utils::redirect('home'); 
 */
class Utils {
    /**
     * Convertit une date vers le format de type "Samedi 15 juillet 2023" en francais.
     * @param DateTime $date : la date à convertir.
     * @return string : la date convertie.
     */
    public static function convertDateToFrenchFormat(DateTime $date, string $pattern = 'EEEE d MMMM Y') : string
    {
        // Attention, s'il y a un soucis lié à IntlDateFormatter c'est qu'il faut
        // activer l'extention intl_date_formater (ou intl) au niveau du serveur apache. 
        // Ca peut se faire depuis php.ini ou parfois directement depuis votre utilitaire (wamp/mamp/xamp)
        $dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
        $dateFormatter->setPattern($pattern);
        return $dateFormatter->format($date);
    }

    /**
     * Redirige vers une URL.
     * @param string $action : l'action que l'on veut faire (correspond aux actions dans le routeur).
     * @param array $params : Facultatif, les paramètres de l'action sous la forme ['param1' => 'valeur1', 'param2' => 'valeur2']
     * @return void
     */
    public static function redirect(string $action, array $params = []) : void
    {
        $_SESSION['action'] = $action;
        $url = "./";
        //foreach ($params as $paramName => $paramValue) {
        //    $url .= "&$paramName=$paramValue";
        //}
        header("Location: $url");
        exit();
    }

    /**
     * Cette méthode retourne le code js a insérer en attribut d'un bouton.
     * pour ouvrir une popup "confirm", et n'effectuer l'action que si l'utilisateur
     * a bien cliqué sur "ok".
     * @param string $message : le message à afficher dans la popup.
     * @return string : le code js à insérer dans le bouton.
     */
    public static function askConfirmation(string $message) : string
    {
        return "onclick=\"return confirm('$message');\"";
    }

    /**
     * Cette méthode retourne le code js a insérer en attribut d'un élément HTML.
     * retour en arrière.
     */
    public static function back() : string
    {
        return "onclick=\"history.back();\"";
    }

    /**
     * Cette méthode protège une chaine de caractères contre les attaques XSS.
     * @param string $string : la chaine à protéger.
     * @return string : la chaine protégée.
     */
    public static function format(string $string) : string
    {
        // Etape 1, on protège le texte avec htmlspecialchars.
        $finalString = htmlspecialchars($string, ENT_QUOTES);

        return $finalString;
    }

    public static function formatToParagraph(string $string) : string
    {
        // Etape 1, on protège le texte avec htmlspecialchars.
        $finalString = htmlspecialchars($string, ENT_QUOTES);

        // Etape 2, le texte va être découpé par rapport aux retours à la ligne, 
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
     * Cette méthode permet de récupérer une variable de la superglobale $_REQUEST.
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
     * A noter qu'il vous faudra configurer le timezone pour afficher la bonne différence, à la minute prés
     * Le timezone pour la France:
     * date_default_timezone_set("europe/paris");
     * A utiliser en haut du document
     */
    public static function differenceDate(DateTime $firstDate, ?DateTime $lastDate = null){
        //on part du principe que $firstDate et $lastDate peut être envoyé sous deux formats: un timestamp ou une date formatée
        
        //on vérifie donc le format envoyé, pour le mettre en date formatée si c'est un timestamp:
        //is_numeric vérifie si c'est un nombre entier (un timestamp est un nombre entier)
        //$firstDate = is_numeric($firstDate) ? date("d-m-Y H:i:s", $firstDate) : $firstDate;
        
        //on crée ensuite la date via date_create (Retourne un nouvel objet DateTime (DateTime: Représentation d'une date et heure))
        //$firstDate = date_create($firstDate);
        $maintenant = !isset($lastDate) ? date_create("now") : $lastDate;
        
        //si jamais la date formatée qui à été envoyée est incorrect, on retourne un message d'erreur
        if (!$firstDate)
        {
            echo "La date envoyée à differenceDate() est incorrecte.";
            return;
        }
        //date_diff nous donne maintenant des valeurs sur les représentations ci-dessus
        $interval = date_diff($maintenant, $firstDate);
        
        //on récupère les valeurs d'$interval qui nous intéresse
        $y = $interval->y;//années
        $m = $interval->m;//mois
        $d = $interval->d;//jours
        $h = $interval->h;//heures
        $i = $interval->i;//minutes
        $s = $interval->s;//secondes
        $invert = $interval->invert;//0 = $firstDate est dans le futur, 1 = $firstDate est dans la passé
        $texte_invert = $invert === (!isset($lastDate) ? 1 : 0) ? "depuis" : "Dans";//il y a une différence lorsqu'on demande un interval ou si on demande "depuis $firstDate seulement":
        //depuis $firstDate seulement: 1 = $firstDate est dans le futur, 0 = $firstDate est dans la passé
        //interval entre $firstDate et $lastDate: 0 = $firstDate est dans le futur, 1 = $firstDate est dans la passé
        $days = $interval->days;//nombre de jours écoulés (depuis combien ou dans combien, nombre entier positif)
        
        //enfin, on retourne les différences pour les afficher:
        
        //si il y a plus d'un an, on affiche le nombre d'année plus le nombre de jours ("5 ans et 18 jours" par exemple)
        if ($y > 0) $texte = "$texte_invert $y an".($y > 1 ? "s" : "").($d > 0 ? " et ".$d." jour".($d > 1 ? "s" : "") : "");
        //si il y a moins d'un an, on affiche les mois et les jours ("5 mois et 24 jours" par exemple)
        elseif ($m > 0) $texte = "$texte_invert $m mois".($d > 0 ? " et $d jour".($d > 1 ? "s" : "") : "");
        //si il y a moins d'un mois, on affiche les jours, évidemment
        elseif ($d > 0) $texte = "$texte_invert $d jour".($d > 1 ? "s" : "");
        //les heures si il y a moins d'un jour
        elseif ($h > 0) $texte = "$texte_invert $h heure".($h > 1 ? "s" : "");
        //les minutes si il y a moins d'une heure
        elseif ($i > 0) $texte = "$texte_invert $i minute".($i > 1 ? "s" : "");
        // et les secondes si il y a moins d'une minute
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
     * Fonction qui généère un identifiant unique de type UUID
     * @return string
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
}