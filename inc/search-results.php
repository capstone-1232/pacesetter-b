<?php
function fetch_search_results() {
    // Retrieve the post type from the AJAX request
    $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : '';
    $search_query = isset($_POST['search_query']) ? $_POST['search_query'] :'';

    // Initialize the query arguments
    $args = array(
        's' => $search_query,
        'post_status' => 'publish',
    );

    // Define default post types
    $default_post_types = array('product', 'events-posts', 'post');

    // Exclude default post types if 'other' is selected
    if ($post_type === 'other') {
        $args['post_type'] = 'page';
        $args['post__not_in'] = $default_post_types;
    } elseif (!empty($post_type)) {
        $args['post_type'] = $post_type;
    } else {
        $args['post_type'] = $default_post_types;
    }

    // Perform the query
    $query = new WP_Query($args);
    // Check if there are posts
    if ($query->have_posts()) : ?>

        <?php
        // Loop through the posts
        while ($query->have_posts()) :
            $query->the_post();

            // Output the search content template part
            get_template_part('template-parts/search-content');

        endwhile;

        // Restore global post data
        wp_reset_postdata();
    else :
        echo '<p>No results found for this search.</p>';

    endif;

    // Terminate script
    exit;
}
add_action('wp_ajax_fetch_search_results', 'fetch_search_results');
add_action('wp_ajax_nopriv_fetch_search_results', 'fetch_search_results');
