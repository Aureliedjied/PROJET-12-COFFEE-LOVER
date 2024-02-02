// Select the form:
const searchTermInput = document.getElementById('searchTerm');

// Add an event listener to listen for text input:
searchTermInput.addEventListener('input', async function (event) {
    event.preventDefault();
    const searchTerm = event.target.value;

    // Search based on the title:
    try {
        // If the field is empty
        if (searchTerm !== '') {
            const response = await fetch(`/search?searchTerm=${searchTerm}`);
            const data = await response.json();

            // Function that displays the form results
            displaySearchResults(data);
        } else {
            // If the search is empty, clear the previous results
            clearSearchResults();
        }
    } catch (error) {
        console.error('Error during search:', error);
    }
});

function displaySearchResults(results) {
    // Select the div below my navbar:
    const searchResultsContainer = document.getElementById('search-results');
    // Clear previous results
    searchResultsContainer.textContent = '';

    // Check if there are results to display
    if (results.length > 0) {
        results.forEach(result => {
            // Create a div for each result
            const resultItem = document.createElement('div');
            // Add a class (see CSS)
            resultItem.classList.add('search-result-item');

            // Create a clickable title link
            const titleLink = document.createElement('a');
            // Add a class (see CSS)
            titleLink.classList.add('result-title');
            // Inject the title as the result
            titleLink.textContent = result.title;
            // Here, you can add the show link
            titleLink.href = result.url;

            // Add the clickable title to the div
            resultItem.appendChild(titleLink);

            // Add the div to the container
            searchResultsContainer.appendChild(resultItem);
        });
    } else {
        // No results found, display an appropriate message
        const noResultMessage = document.createElement('div');
        noResultMessage.classList.add('search-result-item', 'no-result-message');

        const messageText = document.createElement('p');
        messageText.textContent = 'Aucun résultat trouvé';

        noResultMessage.appendChild(messageText);
        searchResultsContainer.appendChild(noResultMessage);
    }
}

function clearSearchResults() {
    const searchResultsContainer = document.getElementById('search-results');
    // Clear previous results by emptying the content of the div:
    searchResultsContainer.textContent = '';
}

const searchResultsContainer = document.getElementById('search-results');

// Function to position the container
function positionSearchResultsContainer() {

    const searchForm = document.getElementById('search-form');

    // Get the coordinates and size of the form
    const rect = searchForm.getBoundingClientRect();

    // Automatically adjust the width, height, and position of the container to its parent
    // Add 18 px, which will be added to the height
    const offset = 8;
    searchResultsContainer.style.width = `${rect.width}px`;
    searchResultsContainer.style.left = `${rect.left}px`;
    searchResultsContainer.style.top = `${rect.bottom + offset}px`;
}

window.addEventListener('resize', positionSearchResultsContainer);

document.addEventListener('click', function (event) {
    const searchResultsContainer = document.getElementById('search-results');

    // If the click is outside, close the results
    if (!searchResultsContainer.contains(event.target) && event.target !== searchTermInput) {
        clearSearchResults();
    }
});

// Position the container initially
positionSearchResultsContainer();

// The scroll will remain attached to the search regardless of what happens
window.addEventListener('scroll', function () {
    positionSearchResultsContainer();
});
