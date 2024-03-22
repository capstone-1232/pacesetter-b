<?php
function custom_breadcrumbs() {
    global $post;

    // Don't display breadcrumbs on the homepage
    if (is_home()) {
        return;
    }

    echo '<div class="breadcrumbs">';
    echo '<a href="' . home_url() . '">Home</a>';

    if (is_category() || is_single()) {
        echo ' / ';
        the_category(', ');
    } elseif (is_page()) {
        $ancestors = get_post_ancestors($post);
        $ancestors = array_reverse($ancestors);

        foreach ($ancestors as $ancestor) {
            echo ' / <a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a>';
        }
    } elseif (is_search()) {
        echo ' / Search results for "' . get_search_query() . '"';
    } elseif (is_404()) {
        echo ' / 404 Not Found';
    }

    echo ' / ';
    echo get_the_title();
    echo '</div>';
}

function custom_product_breadcrumbs() {
    global $post;

    echo '<div class="breadcrumbs">';
    echo '<a href="' . home_url() . '">Home</a>';
    echo ' / <a href="' . esc_url(home_url('/products')) . '">Products</a>';

    if (is_single() && 'product' === get_post_type()) {
        // Get the product categories
        $product_cats = wp_get_post_terms($post->ID, 'product_cat');

        if (!empty($product_cats)) {
            // Array to store breadcrumbs
            $breadcrumbs = array();

            foreach ($product_cats as $product_cat) {
                $page = get_posts(array(
                    'name'        => $product_cat->slug,
                    'post_type'   => 'page',
                    'post_status' => 'publish',
                    'numberposts' => 1
                ));
                $page_url = get_permalink($page[0]->ID);
                // Add the current category to breadcrumbs
                $breadcrumbs[] = '<a href="' . $page_url . '">' . $product_cat->name . '</a>';
            }

            // Output breadcrumbs in reverse order
            foreach (array_reverse($breadcrumbs) as $breadcrumb) {
                echo ' / ' . $breadcrumb;
            }
        }
        $product_name = get_the_title($post->ID);
        echo ' / <span>' . $product_name . '</span>';
    }
    echo '</div>';
}
