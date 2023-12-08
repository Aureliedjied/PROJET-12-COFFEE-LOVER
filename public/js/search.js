// On selectionne le formulaire :
const searchTermInput = document.getElementById('searchTerm');

// On ajoute l'evenement qui ecoute la valeur de l'entrée du texte :
searchTermInput.addEventListener('input', async function(event) {
    event.preventDefault(); 
    const searchTerm = event.target.value;
    
    // recherche en fonction du titre :
    try {
        // si le champ est vide
        if (searchTerm !== '') {
            const response = await fetch(`http://127.0.0.1:8000/search?searchTerm=${searchTerm}`);
            const data = await response.json();

            // Fonction qui affiche les résultats du formulaire
            displaySearchResults(data);
        } else {
            // Si la recherche est vide, efface les résultats précédents
            clearSearchResults();
        }
    } catch (error) {
        console.error('Erreur lors de la recherche:', error);
    }
});

function displaySearchResults(results) {
    // je selectionne la div en dessous ma navbar :
    const searchResultsContainer = document.getElementById('search-results');
    // Effacez les résultats précédents
    searchResultsContainer.textContent = '';

    results.forEach(result => {
        // Créez une div pour chaque résultat
        const resultItem = document.createElement('div');
        // ajout d'une classe ( cf css )
        resultItem.classList.add('search-result-item');

        // création d'un titre en a cliquable
        const titleLink = document.createElement('a');
        // ajout d'une classe ( cf css )
        titleLink.classList.add('result-title');
        // on injecte le titre en resultat
        titleLink.textContent = result.title;
        // ici on pourra ajouter le lien du show
        titleLink.href = '#'; 

        // ajout du titre cliquable a la div
        resultItem.appendChild(titleLink);

        // Ajout de la div o container
        searchResultsContainer.appendChild(resultItem);
    });
}

function clearSearchResults() {
    const searchResultsContainer = document.getElementById('search-results');
    // Efface les résultats précédents en vidant le contenu de la div :
    searchResultsContainer.textContent = '';
}

const searchResultsContainer = document.getElementById('search-results');

// Fonction pour positionner le conteneur
function positionSearchResultsContainer() {

    const searchForm = document.getElementById('search-form');

    // Récupère les coordonnées et la taille du formulaire
    const rect = searchForm.getBoundingClientRect();

    // Ajuste la largeur, position horizontale, et  du conteneur
    searchResultsContainer.style.width = `${rect.width}px`;
    searchResultsContainer.style.left = `${rect.left}px`;
    searchResultsContainer.style.top = `${rect.bottom}px`;
}

// Ajoute l'événement de redimensionnement à la fenêtre
window.addEventListener('resize', positionSearchResultsContainer);

// Positionne le conteneur initialement
positionSearchResultsContainer();