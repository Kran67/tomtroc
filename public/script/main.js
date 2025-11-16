/**
 * Fonction qui permet de changer la source d'une image
 * @param obj : contient les données de la nouvelle image
 * @param imgId : identifiant de l'élément image dans le DOM
 * @returns void
 */
function imageChanged(obj, imgId) {
    var reader = new FileReader();

    reader.onload = (e) => {
        document.getElementById(imgId).src = e.target.result;
    }

    reader.readAsDataURL(obj.files[0]);
}

/**
 * Fonction qui permet de stocker la largeur de l'écran dans un champ caché
 * @returns void
 */
function saveScreenWidth() {
    document.getElementById("screenWidth").value = window.innerWidth;
}

/**
 * Ajout d'événement sur le DOM pour avoir la largeur de l'écran
 */
window.addEventListener("DOMContentLoaded", (event) => saveScreenWidth());
window.addEventListener("resize", (event) => saveScreenWidth());

/**
 * Fonction qui permet de changer les modes de vue du site (évite de passer les infos par l'url)
 * @param action : vue à afficher via les contrôleurs
 * @param params : valeurs à mettre dans les champs cachés
 * @returns void
 */
function changeAction(action, params) {
    for (const key of ['id']) {
        document.getElementById(key).value = '';
    }
    document.getElementById('action').value = action;

    for (const [key, value] of Object.entries(params)) {
        document.getElementById(key).value = value;
    }
}

/**
 * Fonction qui permet d'empécher l'utilisateur d'utiliser la touche ENTER dans les champs de saisie sauf pour le filtrage des livres
 * @param event : l'événement lié à la touche ENTER
 * @returns true or false
 */
function preventEnter(event) {
    if (event.srcElement.id === 'searchTitle' && event.key === 'Enter') {
        changeAction('books', {});
        document.forms[0].submit();
        return false;
    }
    return event.key !== 'Enter';
}