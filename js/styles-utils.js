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

    // check if user clicks outside of search bar to close it
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

});

