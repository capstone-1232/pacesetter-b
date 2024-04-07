(function () {
  document.addEventListener("DOMContentLoaded", function () {
    // Add an event listener to the back to top button
    var backToTopBtn = document.querySelector("#backToTopBtn");
    function scrollToTop() {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
    }
    backToTopBtn.addEventListener("click", scrollToTop);
  });
})();
