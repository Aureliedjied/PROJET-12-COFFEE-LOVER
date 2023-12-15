// On sélectionne le champ de recherche pour la version mobile :
const searchInputMobile = document.getElementById('searchMobileTerm');

// On ajoute un événement qui écoute la valeur de l'entrée du texte :
searchInputMobile.addEventListener('input', async function (event) {
    event.preventDefault();
    const searchTerm = event.target.value;

    // Recherche en fonction du titre :
    try {
        // Si le champ n'est pas vide
        if (searchTerm !== '') {
            const response = await fetch(`/search?searchTerm=${searchTerm}`);
            const data = await response.json();

            // Fonction qui affiche les résultats du formulaire pour la version mobile
            displaySearchResultsMobile(data);
        } else {
            // Si la recherche est vide, efface les résultats 
            clearSearchResultsMobile();
        }
    } catch (error) {
        console.error('Erreur lors de la recherche:', error);
    }
});

function displaySearchResultsMobile(results) {
    const searchResultsContainerMobile = document.getElementById('search-results-mobile');
    console.log('Résultats de la recherche pour la version mobile:', results);
    // Effacez les résultats précédents 
    searchResultsContainerMobile.textContent = '';

    // Vérifiez s'il y a des résultats à afficher
    if (results.length > 0) {
        results.forEach(result => {
            // Créez un élément div pour chaque résultat pour la version mobile
            const resultItemMobile = document.createElement('div');
            // Ajout d'une classe (cf. CSS)
            resultItemMobile.classList.add('search-result-item-mobile');

            // Création d'un titre en lien cliquable pour la version mobile
            const titleLinkMobile = document.createElement('a');
            // Ajout d'une classe (cf. CSS)
            titleLinkMobile.classList.add('result-title-mobile');
            // On injecte le titre en résultat
            titleLinkMobile.textContent = result.title;
            // Ici, on pourra ajouter le lien du show ( cf controller)
            titleLinkMobile.href = result.url;

            // Ajout du titre cliquable à l'élément div pour la version mobile
            resultItemMobile.appendChild(titleLinkMobile);

            // Ajout de l'élément div au conteneur pour la version mobile
            searchResultsContainerMobile.appendChild(resultItemMobile);
        });
    } else {
        // Aucun résultat trouvé, on affiche le message :
        const noResultMessageMobile = document.createElement('div');
        noResultMessageMobile.textContent = 'Aucun résultat trouvé';
        // on attache ce message à la div parente :
        searchResultsContainerMobile.appendChild(noResultMessageMobile);
    }
}

function clearSearchResultsMobile() {
    const searchResultsContainerMobile = document.getElementById('search-results-mobile');
    // Efface les résultats précédents en vidant le contenu de la div  :
    searchResultsContainerMobile.textContent = '';
}

window.addEventListener('resize', positionSearchResultsContainer);

    // On ajoute un evenement sur la div de resultats :
document.addEventListener('click', function (event) {
    const searchResultsContainerMobile = document.getElementById('search-results-mobile');

    // Si le clic est ailleurs, on ferme
    if (!searchResultsContainerMobile.contains(event.target) && event.target !== searchInputMobile) {
        clearSearchResultsMobile();
    }
});