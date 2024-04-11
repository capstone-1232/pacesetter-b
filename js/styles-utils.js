console.log("js connected"); // sanity check, remove in final

var $j = jQuery.noConflict();

$j(document).ready(function () {
    console.log("JQUERY connected") // sanity check, remove in final

    // on load color variables based on colors in css
    const colTurqoise = "#027F9A";
    const colPrimaryBlue = "#013562";
    const colStrongOrange = "#FC7803";
    const colBlack = "#000";
    const colWhite = "#fff";

    // on load behaviours
    $j(".search-submit").hide();
    $j(".category-select a").on("click", function (evt) {
        evt.preventDefault();
    });
    $j(".dropdown-menu").toggle();
    $j(".rsvp-toggle").button();
    $j(".rsvp-panel div>button").button();
    $j('#backToTopBtn').hide();

    // mobile only on load behaviours
    if (window.matchMedia("(max-width: 1024px)").matches) {
        $j(".rsvp-panel").hide();
        $j(".product-filters").hide();
        $j(".event-filters").hide();
    }

    if (window.matchMedia("(max-width: 768px)").matches) {
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

            if (window.matchMedia("(max-width: 768px)").matches) {
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
        if (window.matchMedia("(max-width: 768px)").matches) {
            console.log("filters clicked mobile");
            $j(".event-filters").toggle("slide", 200);
        } else {
            console.log("filters clicked desktop");
        }
    });

    $j(".event-filters>button").on("click", function () {
        $j(".event-filters").toggle("slide", 200);
    });

    if (window.matchMedia("(max-width: 1024px)").matches) {
        $j(".rsvp-toggle").on("click", function () {
            console.log("rsvp toggle clicked");

            if ($j(".rsvp-panel").is(":visible")) {
                $j(".rsvp-panel #myForm").submit();
            } else {
                $j(".rsvp-panel").show("slide");
            }
        });

        $j(".rsvp-panel div>button").on("click", function () {
            $j(".rsvp-panel").hide("slide");
        });
    }

    // set ups jQuery UI accordions
    $j(".faq .accordion, .product-filters .accordion, .events .accordion").accordion({
        collapsible: true,
        active: false,
        heightStyle: "content",
    });

    // Shows back to top button when user scrolls past a certain point
    $j(window).scroll(function () {
        var scrollPoint = 200; // replace with the point you're interested in
        if ($j(this).scrollTop() > scrollPoint) {
            $j('#backToTopBtn').show("fade");
        } else {
            $j('#backToTopBtn').hide("fade");
        }
    });

    // Scrolls back to top of page when back to top button is clicked
    $j('#backToTopBtn').click(function () {
        $j('html, body').animate({ scrollTop: 0 }, 'fast');
        return false;
    });

    // Toggles plus and minus icons on faq accordion headers
    $j(".faq .ui-accordion-header").on("click", function (evt) {
        $j(".ui-accordion-header .plus-icon").toggleClass("hidden");
        $j(".ui-accordion-header .minus-icon").toggleClass("hidden");
    });

    // Toggles style of filter option to show it is applied
    if (window.matchMedia("(max-width: 1024px)").matches) {
        $j(".ui-accordion-content>div").on("click", function () {
            $j(this).parent().find(">div").css({
                "background-color": colWhite,
                "color": colBlack,
                "border": "2px solid " + colStrongOrange,
            });

            $j(this).css({
                "background-color": colTurqoise,
                "color": "#fff",
                "border": "2px solid " + colPrimaryBlue,
            });
        });
    }

    // Toggles mobile products filter menu
    if (window.matchMedia("(max-width: 1024px)").matches) {
        $j(".show-filters, .product-filters div:first-of-type>button, .product-filters>button").on("click", function () {
            $j(".product-filters").toggle("slide");
        })
    }

    // Toggles style of filter items back to unchecked when filter is removed
    $j(".removeFilterList").on("click", ".products-filter-remove", function () {
        let filterText = $j(this).attr("data-value");
        $j(".ui-accordion-content>div input").each(function () {
            if ($j(this).val() == filterText) {

                if (window.matchMedia("(max-width: 1024px)").matches) {
                    $j(this).parent().css({
                        "background-color": colWhite,
                        "color": colBlack,
                        "border": "2px solid " + colStrongOrange,
                    });
                }

                $j(this).prop("checked", false).trigger("change");
            }
        });
    });

    if (window.matchMedia("(min-width: 1024px)").matches) {

        // toggles other accordion dropdown not clicked
        $j(".taxonomy-product .accordion").on("click", function () {
            let activeAccordion = $j(this);
            $j(".taxonomy-product .accordion").not(activeAccordion).each(function () {
                $j(this).accordion("option", "active", false);
            });
        })

        // toggles all accordions closed if user clicks outside of them
        $j(document).on("click", function (evt) {
            let targetElement = $j(".taxonomy-product .accordion");
            if (!targetElement.is(evt.target) && targetElement.has(evt.target).length === 0) {
                $j(".taxonomy-product .accordion").accordion("option", "active", false);
            }
        });

        // toggles style of filter option to show it is applied
        $j(".taxonomy-product .ui-accordion-content").on("change", function () {
            let hasChecked = false;
            $j(this).find("input").each(function () {
                if ($j(this).prop("checked") == true) {
                    hasChecked = true;
                }
            });
            if (hasChecked) {
                $j(this).parent().addClass("has-selected");
            } else {
                $j(this).parent().removeClass("has-selected");
            }
        });
    }

    // Event filter accordion togglers
    $j(".event-filters").on("click", ".accordion-header", function () {
        $j(this).next().slideToggle();
        $j(this).toggleClass("active");
        $j(this).next().toggleClass("active");
    });

    // closes mobile event filters drawer menu
    $j(".event-filters").on("click", ".close", function () {
        $j(".event-filters").toggle("slide");
    });


    // temporary measure so site functionailities doesn't break when user resizes page
    // reloads the page if user resizes window to reload javascript
    $j(window).on("resize", function () {
        location.reload();
    });
});

