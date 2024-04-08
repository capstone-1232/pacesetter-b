(function () {
  var backToTopBtn = document.querySelector("#backToTopBtn");
  document.addEventListener("DOMContentLoaded", function () {
    // Add an event listener to the back to top button
    backToTopBtn.addEventListener("click", scrollToTop);
    function scrollToTop() {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
    }

    // Function to toggle button visibility based on scroll position
    function toggleBackToTopBtn() {
      if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
      ) {
        backToTopBtn.style.visibility = "visible";
        backToTopBtn.style.opacity = "1";
      } else {
        backToTopBtn.style.visibility = "hidden";
        backToTopBtn.style.opacity = "0";
      }
    }

    // Event listener for scrolling
    window.onscroll = function () {
      toggleBackToTopBtn();
    };

    // Function to scroll to the top when the button is clicked
    backToTopBtn.onclick = function () {
      document.body.scrollTop = 0; // For Safari
      document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
    };
  });
})();
