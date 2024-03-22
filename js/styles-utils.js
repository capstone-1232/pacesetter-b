console.log("js connected"); // sanity check, remove in final

var $j = jQuery.noConflict();

$j(document).ready(function(){
    console.log("JQUERY connected")

    $j("#show-search").click(function(){
        $j("#main-search").toggle({
            done: function() {
                $j(".search-submit").hide();
                $j(".cart-link").toggle();
                $j(".operation-hours").toggle();
                $j(".nav-utils").toggleClass("full-width");
            },
        });
    });

    // Toggle mobile dropdown menu
    $j(".main-nav-toggle").click(function(){
        $j(".toggle-menu").toggle("fold");
        $j(".main-nav-toggle .open").toggleClass("hidden");
        $j(".main-nav-toggle .close").toggleClass("hidden");

        // Makes document unscrollable if menu dropdown visible.
        $j("html").toggleClass("overflow-hidden");
    });

});

let searchBtn = document.getElementById("show-search");
let searchField = document.getElementById("main-search");
let submitBtn = document.querySelector(".search-submit");
let searchForm = document.querySelector(".search-form");
let mainNavToggle = document.querySelector(".main-nav-toggle");

// toggles search bar closed if user clicks outsidse of it
document.addEventListener('click', (evt) => {
    const searchSection = document.querySelector('.search-section');
    const clickedInside = searchSection.contains(evt.target);

    if (!clickedInside && !searchField.classList.contains("hidden")) {
        console.log("user clicked outside search");
        searchField.classList.toggle("hidden");
        document.querySelector(".search-section").classList.remove("absolute");
        document.querySelector(".cart-link").classList.remove("hidden");
    }
});


