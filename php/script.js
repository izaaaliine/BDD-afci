function handleFormSubmit(event) {
  event.preventDefault(); // Prevent the form from submitting

  // Get the clicked button
  const clickedButton = event.submitter;

  // Check the current state using the data-state attribute
  const currentState = clickedButton.getAttribute('data-state');

  // Update the button text based on the current state
  if (currentState === 'edit') {
    clickedButton.innerText = 'Enregistrer';
    clickedButton.setAttribute('data-state', 'save');
  } else {
    // Handle save logic here if needed
    // For now, revert back to "Modifier" for demonstration purposes
    clickedButton.innerText = 'Modifier';
    clickedButton.setAttribute('data-state', 'edit');
  }

  // Perform other form handling or AJAX requests if needed

  return false; // Prevent the form from submitting
}
