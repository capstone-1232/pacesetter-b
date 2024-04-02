console.log("js connected"); // sanity check, remove in final

var $j = jQuery.noConflict();

$j(document).ready(function () {
    console.log("JQUERY connected") // sanity check, remove in final

    // on load behaviours
    $j(".search-submit").hide();
    $j(".category-select a").on("click", function (evt) {
        evt.preventDefault();
    });
    $j(".dropdown-menu").toggle();
    $j(".event-filters").hide();


    if ($j(window).width() < 768) {
        $j("#show-search").click(function () {
            $j("#main-search").toggle({
                start: function () {
                    $j(".cart-link").hide("fold");
                    $j(".operation-hours").hide("fold");
                },
            });
        });
    }

    // Toggle mobile dropdown menu
    $j(".main-nav-toggle").on("click", function () {
        $j(".toggle-menu").slideToggle();
        $j(".main-nav-toggle .open").toggleClass("hidden");
        $j(".main-nav-toggle .close").toggleClass("hidden");
        $j(".right-column").hide("fold");
        $j(".column-container").removeClass("flex-container");
        $j(".left-column").removeClass("squished");
        $j(".category-select").removeClass("selected");

        // Makes document unscrollable if menu dropdown visible.
        $j("body").toggleClass("overflow-hidden");
    });

    // check if user clicks outside of search bar to close it
    // Might refactor later to have a close button on left side of search bar as well
    $j(document).on("click", function (evt) {
        let targetElement = $j(".search-section");
        if (!targetElement.is(evt.target) && targetElement.has(evt.target).length === 0) {

            if ($j(window).width() < 768) {
                $j("#main-search").hide({
                    start: function () {
                        $j(".cart-link").show("fold");
                        $j(".operation-hours").show("fold");
                    }
                });
            } else {
                $j(".nav-utils").removeClass("full-width", 500);
            }
        }
    });

    // Toggles open subcategory menu and double column layout switch on tap
    $j(".category-select").on("click", function () {


        $j(".column-container").addClass("flex-container");

        $j(".left-column").addClass("squished", {
            duration: "200",
            easing: "easeInOutExpo",
        });

        $j(".right-column").show("fold");

        let queryStr = ".subcategories." + $j(this).text();

        if (!$j(this).hasClass("selected")) {
            $j(".category-select").removeClass("selected");

            $j(".subcategories").hide("fold");
            $j(queryStr).toggle("slide");
        }

        $j($j(this)).addClass("selected");
    })

    // closes right column on button click
    $j(".right-column button").on("click", function () {
        $j(".category-select").removeClass("selected");

        $j(".right-column").hide({
            done: function () {
                $j(".left-column").removeClass("squished");
                $j(".column-container").removeClass("flex-container");
            }
        });
    });


    // toggles dropdown menu
    $j(".dropdown-toggle").on("click", function (evt) {
        evt.preventDefault();
        $j(".dropdown-menu").slideToggle();

        // rotates chevron svg on click
        var transformValue = $j(".dropdown-toggle svg").attr("transform");
        if (transformValue === "rotate(180)") {
            $j(".dropdown-toggle svg").attr("transform", "rotate(0)");
        } else {
            $j(".dropdown-toggle svg").attr("transform", "rotate(180)");
        }
    });

    // expand search bar when activated in desktop
    $j(".search-field").on("click", function () {
        $j(".nav-utils").addClass("full-width", 500);
    });

    // toggles slideover filter menu
    $j(".filter-toggle").on("click", function () {
        console.log("filters clicked");
        $j(".event-filters").animate({
            width: "toggle",
        }, 200);
    });

});

