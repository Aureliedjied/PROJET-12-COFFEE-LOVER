document.addEventListener("DOMContentLoaded", function () {
    const searchTermInput = document.getElementById('searchTerm');
    const placeholderText = "Rechercher un article";

    // Affiche le texte initial dans le placeholder au chargement de la page
    searchTermInput.placeholder = "";

    // Déclenche l'animation après un délai initial de 2 secondes
    setTimeout(function () {
        animatePlaceholder(placeholderText);
    }, 2000);

    // Fonction pour animer le placeholder lettre par lettre
    function animatePlaceholder(text) {
        let currentIndex = 0;

        // Ajoute la loupe au début
        searchTermInput.placeholder += " "; // Loupe emoji ou remplace par l'icône Bootstrap

        // Utilise setInterval pour ajouter chaque lettre à intervalles réguliers
        const intervalId = setInterval(function () {
            searchTermInput.placeholder += text[currentIndex];
            currentIndex++;

            // Arrête l'animation lorsque tout le texte est ajouté
            if (currentIndex === text.length) {
                clearInterval(intervalId);

                // Ajoute un délai avant de recommencer l'animation
                setTimeout(function () {
                    searchTermInput.placeholder = "🔍 "; // Réinitialise la loupe pour l'animation suivante
                    setTimeout(function () {
                        animatePlaceholder(placeholderText);
                    }, 1000);
                }, 2000);
            }
        }, 100);
    }
});







