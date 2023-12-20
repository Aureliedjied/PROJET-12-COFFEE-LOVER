// Selecting the search field for the mobile version:
const searchInputMobile = document.getElementById('searchMobileTerm');

// Adding an event listener to listen for text input:
searchInputMobile.addEventListener('input', async function (event) {
    event.preventDefault();
    const searchTerm = event.target.value;

    // Search based on the title:
    try {
        // If the field is not empty
        if (searchTerm !== '') {
            const response = await fetch(`/search?searchTerm=${searchTerm}`);
            const data = await response.json();

            // Function that displays the search results for the mobile version
            displaySearchResultsMobile(data);
        } else {
            // If the search is empty, clear the results
            clearSearchResultsMobile();
        }
    } catch (error) {
        console.error('Error during search:', error);
    }
});

function displaySearchResultsMobile(results) {
    const searchResultsContainerMobile = document.getElementById('search-results-mobile');
    console.log('Search results for the mobile version:', results);
    // Clear previous results
    searchResultsContainerMobile.textContent = '';

    // Check if there are results to display
    if (results.length > 0) {
        results.forEach(result => {
            // Create a div element for each result for the mobile version
            const resultItemMobile = document.createElement('div');
            // Add a class (see CSS)
            resultItemMobile.classList.add('search-result-item-mobile');

            // Create a clickable title link for the mobile version
            const titleLinkMobile = document.createElement('a');
            // Add a class (see CSS)
            titleLinkMobile.classList.add('result-title-mobile');
            // Inject the title as the result
            titleLinkMobile.textContent = result.title;
            // Here, you can add the show link (see controller)
            titleLinkMobile.href = result.url;

            // Add the clickable title to the div element for the mobile version
            resultItemMobile.appendChild(titleLinkMobile);

            // Add the div element to the container for the mobile version
            searchResultsContainerMobile.appendChild(resultItemMobile);
        });
    } else {
        // No results found, display the message:
        const noResultMessageMobile = document.createElement('div');
        noResultMessageMobile.textContent = 'No results found';
        // Attach this message to the parent div:
        searchResultsContainerMobile.appendChild(noResultMessageMobile);
    }
}

function clearSearchResultsMobile() {
    const searchResultsContainerMobile = document.getElementById('search-results-mobile');
    // Clear previous results by emptying the content of the div:
    searchResultsContainerMobile.textContent = '';
}

window.addEventListener('resize', positionSearchResultsContainer);

// Add an event to the results div:
document.addEventListener('click', function (event) {
    const searchResultsContainerMobile = document.getElementById('search-results-mobile');

    // If the click is outside, close the results
    if (!searchResultsContainerMobile.contains(event.target) && event.target !== searchInputMobile) {
        clearSearchResultsMobile();
    }
});

