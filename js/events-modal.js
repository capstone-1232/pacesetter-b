document.addEventListener("DOMContentLoaded", function () {
  var modal = document.getElementById("eventModal");

  // Function to hide the modal
  function hideModal() {
    modal.classList.add("hidden");
  }

  // Add an event listener to the close button
  var closeButton = document.querySelector(".event-modal-close");
  if (closeButton) {
    closeButton.addEventListener("click", hideModal);
  }
});
