<?php
function custom_breadcrumbs() {
    // Check if it's a product category archive page
    if (is_product_category()) {
        $category = get_queried_object(); // Get the current category object
        $ancestors = get_ancestors($category->term_id, 'product_cat'); // Get category ancestors

        echo '<div class="breadcrumbs">';
        echo '<a href="' . home_url() . '">Home</a>'; // Home link

        $shop_page_id = wc_get_page_id('shop');
        echo ' / <a href="' . get_permalink($shop_page_id) . '">' . __('Products', 'woocommerce') . '</a>';


        // Loop through the ancestors to display the breadcrumb trail
        foreach (array_reverse($ancestors) as $ancestor) {
            $ancestor_term = get_term($ancestor, 'product_cat'); // Get ancestor term
            echo ' / <a href="' . get_term_link($ancestor_term) . '">' . $ancestor_term->name . '</a>'; // Ancestor link
        }

        echo ' / ' . $category->name; // Current category name
        echo '</div>';
    }
}

function custom_product_breadcrumbs() {
    if (is_singular('product')) { // Check if it's a single product page
        global $product;

        echo '<div class="breadcrumbs">';
        echo '<a href="' . home_url() . '">Home</a>'; // Home link

        // Link to the shop page
        $shop_page_url = get_permalink(wc_get_page_id('shop'));
        echo ' / <a href="' . $shop_page_url . '">' . __('Products', 'woocommerce') . '</a>';

        // Product category breadcrumbs
        $categories = wp_get_post_terms($product->get_id(), 'product_cat');
        if ($categories) {
            // Sort categories based on hierarchy
            usort($categories, function($a, $b) {
                return count(get_ancestors($a->term_id, 'product_cat')) - count(get_ancestors($b->term_id, 'product_cat'));
            });

            // Display category breadcrumbs excluding "basics" category
            foreach ($categories as $category) {
                if ($category->slug === 'basics') {
                    continue; // Skip the "basics" category
                }
                $category_link = get_term_link($category);
                echo ' / <a href="' . $category_link . '">' . $category->name . '</a>';
            }
        }

        echo '<span> / ' . get_the_title() . '</span>'; // Product title
        echo '</div>';
    }
}

