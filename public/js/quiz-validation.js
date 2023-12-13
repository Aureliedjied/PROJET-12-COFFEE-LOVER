document.addEventListener('DOMContentLoaded', function () {
    const responses = document.querySelectorAll('input[type="radio"]');
    const nextButton = document.getElementById('nextButton');
    const alertMessage = document.getElementById('alertMessage');
  
    responses.forEach(response => {
      response.addEventListener('change', function () {
        // Cache le message d'alerte et "active" le bouton "suivant" si un "radio" est selectionné
        alertMessage.style.display = 'none';
        nextButton.disabled = false;
      });
    });
  
    nextButton.addEventListener('click', function(event) {
        //Converts 'responses' to Array to use the 'some' method.
        // 'some' checks whether at least one of the elements in the array satisfies the given condition.
        // Here, the condition is: radio ('response') is selected ('checked').
      const isResponseSelected = Array.from(responses).some(r => r.checked);
        
      //If none ('radio') is selected -> Displays the alert message 
      if (!isResponseSelected) {
        event.preventDefault();
        alertMessage.style.display = 'block';
      }
    });
  });
  