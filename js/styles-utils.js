console.log("js connected"); // sanity check, remove in final

var $j = jQuery.noConflict();

$j(document).ready(function () {
    console.log("JQUERY connected") // sanity check, remove in final

    // on load behaviours
    $j(".search-submit").hide();
    $j(".category-select a").on("click", function (evt) {
        evt.preventDefault();
    });

    $j("#show-search").click(function () {
        $j("#main-search").toggle({
            done: function () {
                $j(".cart-link").toggle();
                $j(".operation-hours").toggle();
                $j(".nav-utils").toggleClass("full-width");
            },
        });
    });

    // Toggle mobile dropdown menu
    $j(".main-nav-toggle").on("click", function () {
        $j(".toggle-menu").slideToggle();
        $j(".main-nav-toggle .open").toggleClass("hidden");
        $j(".main-nav-toggle .close").toggleClass("hidden");
        $j(".right-column").hide("fold");
        $j(".column-container").removeClass("flex-container");
        $j(".left-column").removeClass("squished");





        // Makes document unscrollable if menu dropdown visible.
        $j("body").toggleClass("overflow-hidden");
    });

    // check if user clicks outside of search bar to close it
    // Might refactor later to have a close button on left side of search bar as well
    $j(document).on("click", function (evt) {
        let targetElement = $j(".search-section");
        if (!targetElement.is(evt.target) && targetElement.has(evt.target).length === 0) {
            $j("#main-search").hide({
                done: function () {
                    $j(".cart-link").show();
                    $j(".operation-hours").show();
                    $j(".nav-utils").removeClass("full-width");
                },
            });
        }
    });

    $j(".category-select").on("click", function () {
        $j(".subcategories").hide("fold");

        $j(".right-column").show();
        $j(".left-column").addClass("squished");
        $j(".column-container").addClass("flex-container");

        let queryStr = ".subcategories." + $j(this).text();
        $j(queryStr).toggle("slide");

    })

    $j(".right-column button").on("click", function() {
        $j(".right-column").hide({
            done: function() {
                $j(".left-column").removeClass("squished");
                $j(".column-container").removeClass("flex-container");
            }
        });
        // $j(".left-column").removeClass("squished");
        // $j(".column-container").removeClass("flex-container");
    });

});

