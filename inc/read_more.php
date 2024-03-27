<?php function new_excerpt_more($more) {
    global $post;
    error_log('Debug: new_excerpt_more function called.'); // Debugging line
    error_log('Post ID: ' . $post->ID); // Debugging line
    return '<a class="moretag" href="'. get_permalink($post->ID) . '"> Read More</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');
?>