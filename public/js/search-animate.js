// Select the search form id:
document.addEventListener("DOMContentLoaded", function () {
    const searchTermInput = document.getElementById('searchTerm');
    const placeholderText = "Rechercher un article";

    // Display the initial text in the placeholder when the page loads
    searchTermInput.placeholder = "";

    // Trigger the animation after an initial delay of 2 seconds
    setTimeout(function () {
        animatePlaceholder(placeholderText);
    }, 2000);

    // Function to animate the placeholder letter by letter
    function animatePlaceholder(text) {
        let currentIndex = 0;

        // Add the magnifying glass at the beginning
        searchTermInput.placeholder += " "; 

        // Use setInterval to add each letter at regular intervals
        const intervalId = setInterval(function () {
            searchTermInput.placeholder += text[currentIndex];
            currentIndex++;

            // Stop the animation when the entire text is added
            if (currentIndex === text.length) {
                clearInterval(intervalId);

                // Add a delay between two animations
                setTimeout(function () {
                    searchTermInput.placeholder = "🔍 "; // Reset the magnifying glass for the next animation
                    setTimeout(function () {
                        animatePlaceholder(placeholderText);
                    }, 1000);
                }, 2000);
            }
        }, 100);
    }
});








