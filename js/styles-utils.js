console.log("js connected"); // sanity check, remove in final

let searchBtn = document.getElementById("show-search");
let searchField = document.getElementById("main-search");
let submitBtn = document.querySelector(".search-submit");
let searchForm = document.querySelector(".search-form");

// Search Field toggle for mobile
searchBtn.addEventListener("click", () => {
    if (searchField.classList.contains("hidden")) {
        document.querySelector("#main-search .search-field").placeholder = "Search Pacesetter..."
        searchField.classList.toggle("hidden");

        document.querySelector(".search-submit").classList.add("hidden");
        document.querySelector(".search-section").classList.toggle("absolute-element");

        document.querySelector(".cart-link").classList.toggle("hidden");
    } else {
        console.log("Search searched");

    }
});

// toggles search bar closed if user clicks outside of it
document.addEventListener('click', (evt) => {
    const searchSection = document.querySelector('.search-section');
    const clickedInside = searchSection.contains(evt.target);

    if (!clickedInside && !searchField.classList.contains("hidden")) {
        console.log("user clicked outside search");
        searchField.classList.toggle("hidden");
        document.querySelector(".search-section").classList.remove("absolute-element");
        document.querySelector(".cart-link").classList.remove("hidden");
    }
});
