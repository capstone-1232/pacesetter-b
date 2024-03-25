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
        $j(".toggle-menu").toggle("fold");
        $j(".main-nav-toggle .open").toggleClass("hidden");
        $j(".main-nav-toggle .close").toggleClass("hidden");

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

});

