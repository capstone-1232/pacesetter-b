<?php
function fetch_products() {
    
    $offset = $_POST['offset'] ? $_POST['offset'] : 12;
    $category_slug = $_POST['current_slug'];
    $filters = $_POST['filters'] ? json_decode(stripslashes($_POST['filters']), true) :'';
    $sort_by = $_POST['sort_by'] ? $_POST['sort_by'] :'';
    $sort_by = $_POST['sort_by'] ? $_POST['sort_by'] :'';

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $offset,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $category_slug,
            ),
        ),
    );

    // Handle different sorting options
switch ($sort_by) {
    case 'price_high_to_low':
        $args['meta_key'] = '_price';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
        break;
    case 'price_low_to_high':
        $args['meta_key'] = '_price';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'ASC';
        break;
    case 'newest':
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
        break;
    case 'oldest':
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
        break;
    default:
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
        break;
}
    
    if ($filters) {
        foreach ($filters as $filter) {
            $filterType = $filter['filterType'];
            $filterValue = $filter['filterValue'];
            if ($filterType == 'brand') {
                    $args['tax_query'][] = array(
                        'taxonomy' => 'brands',
                        'field' => 'name',
                        'terms' => $filterValue,
                        'operator' => 'IN',
                    );
            }
            if ($filterType == 'length') {
                list($min, $max) = explode('-', $filterValue);
                $min = intval($min);
                $max = intval($max);
                $terms_in_range = range($min, $max);
                if (!empty($terms_in_range)) {
                    $args['tax_query'][] = array(
                        'taxonomy' => 'pa_size',
                        'field' => 'slug',
                        'terms' => $terms_in_range,
                        'operator' => 'IN',
                    );
                }
            }
            if ($filterType == 'price_range') {
                $price_values = explode('-', $filterValue);
                if (!empty($price_values)) {
                    $args['meta_query'][] = array(
                        'key' => '_price',
                        'value' => $price_values,
                        'type' => 'NUMERIC',
                        'compare' => 'BETWEEN',
                    );
                }
            }
        }
    }
    
    $products_query = new WP_Query($args);

    $total_products = $products_query->found_posts;
    
    // Now you can loop through the products
    if ($products_query->have_posts()) {
        while ($products_query->have_posts()) {
            $products_query->the_post();
            $product = wc_get_product(get_the_ID());
            $product_id = $products_query->ID;
            $product_image_url = get_the_post_thumbnail_url($product_id, 'full');
            $product_price = $product->get_price();
            $product_url = get_permalink($product_id);
            $in_stock = $product->is_in_stock() ? 'In Stock <svg fill="#000000" width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>checkmark</title> <path d="M16 3c-7.18 0-13 5.82-13 13s5.82 13 13 13 13-5.82 13-13-5.82-13-13-13zM23.258 12.307l-9.486 9.485c-0.238 0.237-0.623 0.237-0.861 0l-0.191-0.191-0.001 0.001-5.219-5.256c-0.238-0.238-0.238-0.624 0-0.862l1.294-1.293c0.238-0.238 0.624-0.238 0.862 0l3.689 3.716 7.756-7.756c0.238-0.238 0.624-0.238 0.862 0l1.294 1.294c0.239 0.237 0.239 0.623 0.001 0.862z"></path> </g></svg>' : 'Out of Stock <svg fill="#000000" width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>cancel</title> <path d="M16 29c-7.18 0-13-5.82-13-13s5.82-13 13-13 13 5.82 13 13-5.82 13-13 13zM21.961 12.209c0.244-0.244 0.244-0.641 0-0.885l-1.328-1.327c-0.244-0.244-0.641-0.244-0.885 0l-3.761 3.761-3.761-3.761c-0.244-0.244-0.641-0.244-0.885 0l-1.328 1.327c-0.244 0.244-0.244 0.641 0 0.885l3.762 3.762-3.762 3.76c-0.244 0.244-0.244 0.641 0 0.885l1.328 1.328c0.244 0.244 0.641 0.244 0.885 0l3.761-3.762 3.761 3.762c0.244 0.244 0.641 0.244 0.885 0l1.328-1.328c0.244-0.244 0.244-0.641 0-0.885l-3.762-3.76 3.762-3.762z"></path> </g></svg>';
            // Render products
            ?>
            <a href="<?php echo $product_url?>">
                <div>
                    <img src="<?php echo esc_url($product_image_url ? $product_image_url : home_url() . "/wp-content/themes/pacesetter-b/img/placeholder.webp")?>" alt="">
                    <h3><?php the_title();?></h3>
                    <?php echo $in_stock?>
                    <p>$<?php echo $product_price?></p>
                </div>
            </a>
            <?php
        }
        wp_reset_postdata();
    } else {
        // No products found
        echo 'No products found in the "' . $category_slug . '" category.';
    }
    echo ($product && $offset < $total_products) ? "<button id=\"view-more-btn\" class=\"view-more-btn\">View More Reviews</button>" : "";
    exit;
}

// Hook the AJAX handler to WordPress
add_action('wp_ajax_fetch_products', 'fetch_products');
add_action('wp_ajax_nopriv_fetch_products', 'fetch_products');


// product filter function
function product_list_filter() {
    if (isset($_POST['filters'])) {
        $filters = json_decode(stripslashes($_POST['filters']), true);

        $meta_queries = array();

        // Build tax queries based on selected filters
        foreach ($filters as $filter) {
            if (!empty($filter['filterType'])) {
                    $meta_queries[] = array(
                        'key'     => 'tags_' . $filter['filterType'],
                        'value'   => $filter['filterValue'],
                        'compare' => 'LIKE',
                    );
            }
        }

        // Initialize your $args array here
        $args = array(
            'post_type'      => 'products',
            'post_status'    => 'publish',
            'meta_key'       => 'date_and_time_start',
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
        );

        // Add meta_queries to $args if it's not empty
        if (!empty($meta_queries)) {
            $args['meta_query'] = array(
                'relation' => 'AND',
                $meta_queries,
            );
        }

        // Query for related products
        $products_query = new WP_Query($args);
        echo "<div class=\"related-products__wrapper\">";
        if ($products_query->have_posts()) {
            while ($products_query->have_posts()) {
                $products_query->the_post();
            }

            // Restore global post data
            wp_reset_postdata();
        } else {
            // No related products found
            echo 'No products found.';
        }
        exit;
    } else {
        // Handle other cases or provide a default response
        echo json_encode(['error' => 'Invalid request']);
        exit;
    }
}

add_action('wp_ajax_product_list_filter', 'product_list_filter');
add_action('wp_ajax_nopriv_product_list_filter', 'product_list_filter');

function remove_product_filter_list_function() {
    if (isset($_POST['filters'])) {
        $filters = json_decode(stripslashes($_POST['filters']), true);

        // Build tax queries based on selected filters
        foreach ($filters as $filter): ?>
            <?php if ($filter['filterType'] == "price_range"): ?>
                <?php if ($filter['filterValue'] == '1000-99999'): ?>
                    <a href="#" class="products-filter-remove" data-filter="<?php echo $filter['filterType'];?>" data-value="<?php echo $filter['filterValue'];?>">$1000 & above <span>X</span></a>
                <?php elseif ($filter['filterValue'] == '0-200'): ?>
                    <a href="#" class="products-filter-remove" data-filter="<?php echo $filter['filterType'];?>" data-value="<?php echo $filter['filterValue'];?>">Under $200 <span>X</span></a>
                <?php else: ?>
                    <a href="#" class="products-filter-remove" data-filter="<?php echo $filter['filterType'];?>" data-value="<?php echo $filter['filterValue'];?>">$<?php echo ucfirst($filter['filterValue']); ?> <span>X</span></a>
                <?php endif; ?>
            <?php elseif ($filter['filterType'] == "length"): ?>
                <a href="#" class="products-filter-remove" data-filter="<?php echo $filter['filterType'];?>" data-value="<?php echo $filter['filterValue'];?>"><?php echo ucfirst($filter['filterValue']); ?>cm <span>X</span></a>
            <?php elseif (!empty($filter['filterType']) && !empty($filter['filterValue'])): ?>
                <a href="#" class="products-filter-remove" data-filter="<?php echo $filter['filterType'];?>" data-value="<?php echo $filter['filterValue'];?>"><?php echo ucfirst($filter['filterValue']); ?> <span>X</span></a>
            <?php endif; ?>
        <?php endforeach;
        foreach ($filters as $filter): ?>
            <?php if ($filter['filterType'] == "price_range"): ?>
                <?php if ($filter['filterValue'] == '1000-99999'): ?>
                    <a href="#" class="products-filter-remove" data-filter="<?php echo $filter['filterType'];?>" data-value="<?php echo $filter['filterValue'];?>">$1000 & above X</a>
                <?php elseif ($filter['filterValue'] == '0-200'): ?>
                    <a href="#" class="products-filter-remove" data-filter="<?php echo $filter['filterType'];?>" data-value="<?php echo $filter['filterValue'];?>">Under $200 X</a>
                <?php else: ?>
                    <a href="#" class="products-filter-remove" data-filter="<?php echo $filter['filterType'];?>" data-value="<?php echo $filter['filterValue'];?>">$<?php echo ucfirst($filter['filterValue']); ?> X</a>
                <?php endif; ?>
            <?php elseif ($filter['filterType'] == "length"): ?>
                <a href="#" class="products-filter-remove" data-filter="<?php echo $filter['filterType'];?>" data-value="<?php echo $filter['filterValue'];?>"><?php echo ucfirst($filter['filterValue']); ?>cm X</a>
            <?php elseif (!empty($filter['filterType']) && !empty($filter['filterValue'])): ?>
                <a href="#" class="products-filter-remove" data-filter="<?php echo $filter['filterType'];?>" data-value="<?php echo $filter['filterValue'];?>"><?php echo ucfirst($filter['filterValue']); ?> X</a>
            <?php endif; ?>
        <?php endforeach;
        exit;
    } else {
        // Handle other cases or provide a default response
        echo json_encode(['error' => 'Invalid request']);
        exit;
    }
}

add_action('wp_ajax_remove_product_filter_list_function', 'remove_product_filter_list_function');
add_action('wp_ajax_nopriv_remove_product_filter_list_function', 'remove_product_filter_list_function');

function update_active_product_list_function() {
    

    $filters = [
        "length" => [
            "150-155" => "150-155cm",
            "156-160" => "156-160cm",
            "161-165" => "161-165cm",
            "166-170" => "166-170cm",
            "171-175" => "171-175cm",
            "176-180" => "176-180cm",
            "181-185" => "181-185cm",
            "186-190" => "186-190cm",
            "191-195" => "191-195cm",
            "196-999" => "196cm+",
        ],
        "brand" => [
            "dynastar" => "Dynastar",
            "armada" => "Armada",
            "black-crows" => "Black Crows",
            "blizzard" => "Blizard",
            "k2" => "K2",
            "smith" => "Smith",
            "rossignol" => "Rossignol",
            "salomon" => "Salomon",
            "fischer" => "Fischer",
            "stockli" => "Stöckli",
            "volkl" => "Völkl",
            "capita" => "Capita",
        ],
        "price_range" => [
            "0-200" => "Under $200",
            "200-400" => "$200 - $400",
            "400-600" => "$400 - $600",
            "600-800" => "$600 - $800",
            "800-1000" => "$800 - $1000",
            "1000-99999" => "$1000 & above",
        ]
    ];

    // Check if the 'filters' parameter is set in the POST data
    if (isset($_POST['filters'])) {
        // Decode the JSON data and store it in the $active_filters array
        $active_filters = json_decode(stripslashes($_POST['filters']), true);

        // Generate the filter buttons
        foreach ($filters as $filter => $options) {
            // Replace underscores or dashes with spaces and capitalize the words for the heading
            $heading = ucwords(str_replace(["_", "-"], " ", $filter));
            // Add a heading before each button group
            echo "<h4 class=\"\">" .
                htmlspecialchars($heading) .
                "</h4>";

            echo '<div class="" role="group" aria-label="' .
                htmlspecialchars($filter) .
                ' Filter Group">';
            foreach ($options as $value => $label) {
                // Check if the value exists in the active_filters array
                $is_active = false;
                foreach ($active_filters as $filter_item) {
                    if ($filter_item['filterType'] === $filter && $filter_item['filterValue'] === $value) {
                        $is_active = true;
                        break;
                    }
                }
                $updated_filters = $active_filters;

                if ($is_active) {
                    $updated_filters = array_filter($updated_filters, function($item) use ($filter, $value) {
                        return !($item['filterType'] === $filter && $item['filterValue'] === $value);
                    });
                } else {
                    $updated_filters[] = ['filterType' => $filter, 'filterValue' => $value];
                }

                // Output button link
                echo '<a href="#" class="products-filter ' .
                    ($is_active ? "filter-active" : "") .
                    '" data-filter="' . htmlspecialchars($filter) . '" data-value="' . htmlspecialchars($value) . '">' .
                    htmlspecialchars($label) .
                    "</a>";
            }
            echo "</div>";
        }
        exit;
    } else {
        // Handle other cases or provide a default response
        echo json_encode(['error' => 'Invalid request']);
        exit;
    }
}

add_action('wp_ajax_update_active_product_list_function', 'update_active_product_list_function');
add_action('wp_ajax_nopriv_update_active_product_list_function', 'update_active_product_list_function');


?>
