console.log("js connected"); // sanity check, remove in final

var $j = jQuery.noConflict();

$j(document).ready(function(){
    console.log("JQUERY connected") // sanity check, remove in final
    
    // on load behaviours
    $j(".search-submit").hide();
    $j(".category-select a").on("click", function(evt) {
        evt.preventDefault();
    });

    $j("#show-search").click(function(){
        $j("#main-search").toggle({
            done: function() {
                $j(".cart-link").toggle();
                $j(".operation-hours").toggle();
                $j(".nav-utils").toggleClass("full-width");
            },
        });
    });

    // Toggle mobile dropdown menu
    $j(".main-nav-toggle").click(function(){
        $j(".toggle-menu").slideToggle();
        $j(".main-nav-toggle .open").toggleClass("hidden");
        $j(".main-nav-toggle .close").toggleClass("hidden");
        $j(".right-column").removeClass("shown");
        $j(".column-container").removeClass("flex-container");
        $j(".left-column").removeClass("squished");
        $j(".subcategories").html("");




        // Makes document unscrollable if menu dropdown visible.
        $j("html").toggleClass("overflow-hidden");
    });

    // check if user clicks outside of search bar to close it
    // Might refactor later to have a close button on left side of search bar as well
    $j(document).on("click", function(evt){
        let targetElement = $j(".search-section");
        if (!targetElement.is(evt.target) && targetElement.has(evt.target).length === 0) {
            $j("#main-search").hide({
                done: function() {
                    $j(".cart-link").show();
                    $j(".operation-hours").show();
                    $j(".nav-utils").removeClass("full-width");
                },
            });
        }
    });

    // get subcategories through ajax
    $j(".category-select").on("click", function() {
        console.log("clicked a category");

        $j(".subcategories").html("<div class=\"flex-container justify-center\" style=\"margin-top:100%\"><div class=\"loader\"></div></div>");
        $j(".toggle-menu").addClass("flex-container");
        $j(".left-column").addClass("squished");
        $j(".right-column").addClass("shown");
        $j(".column-container").addClass("flex-container");

        $j.ajax({
            url: ajax_object.ajax_url,
            type: "POST",
            data: {
                action: "subcategory",
                category: $j(this)[0].textContent,
            },
            success: function(response) {
                $j(".subcategories").html(response);
            },
            error: function(response) {
                console.log("error" + response);
            }
        });

    });

    $j(".right-column button").on("click", function() {
        $j(".toggle-menu").removeClass("flex-container");
        $j(".left-column").removeClass("squished");
        $j(".right-column").removeClass("shown");
        $j(".column-container").removeClass("flex-container");
        $j(".subcategories").html("");
    });

});

