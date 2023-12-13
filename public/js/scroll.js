// Set up an event listener for when the window loads.
window.onload= function(){
     // Find the first element with ID 'scroll-point'.
    let section = document.querySelector('#scroll-point');
    // If the element exists, scroll to make it visible.
    if (section) {
        section.scrollIntoView();
    }
};