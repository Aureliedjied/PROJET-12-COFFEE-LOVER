// Listen for the DOMContentLoaded event to ensure that the DOM is fully loaded before executing the script
document.addEventListener('DOMContentLoaded', function () {

  // Select all radio input elements on the page
  const responses = document.querySelectorAll('input[type="radio"]');
  
  // Select the "Next" button and the alert message elements
  const nextButton = document.getElementById('nextButton');
  const alertMessage = document.getElementById('alertMessage');

  // Attach a change event listener to each radio input
  responses.forEach(response => {
    response.addEventListener('change', function () {
      // Hide the alert message and enable the "Next" button if a radio option is selected
      alertMessage.style.display = 'none';
      nextButton.disabled = false;
    });
  });

  // Attach a click event listener to the "Next" button
  nextButton.addEventListener('click', function(event) {

      // Convert the NodeList of radio inputs to an array to use the 'some' method
      // 'some' checks if at least one radio input is checked
      const isResponseSelected = Array.from(responses).some(r => r.checked);
      
      // If no radio input is selected, prevent the default action (navigation) and display the alert message
      if (!isResponseSelected) {
        event.preventDefault();
        alertMessage.style.display = 'block';
      }
  });
});

  