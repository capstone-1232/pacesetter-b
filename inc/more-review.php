<?php
function fetch_reviews() {
    $offset = $_POST['offset'] ? $_POST['offset'] : 2;
    $product_id = $_POST['product_id'];

    // Get review query
    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'number'         => $offset,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
            array(
                'key'     => 'rating',
                'value'   => 0,
                'compare' => '>',
            ),
        ),
    );
    $reviews_count = get_post_meta($product_id, '_wc_rating_count', true);
    $total_review_count = array_sum($reviews_count);

    $reviews = get_comments($args);
    // render reviews
    if ($reviews) {
        foreach ($reviews as $review) {
            $rating   = intval(get_comment_meta($review->comment_ID, 'rating', true));
            $comment  = $review->comment_content;
            $author   = $review->comment_author;
            $datetime = strtotime($review->comment_date);
            $date     = date('F j, Y', $datetime);
            ?>
            
            <div>
                <?php render_review_rating_stars($rating)?>
                <h5><?php echo $author?></h5>
                <p class="date"><?php echo $date?></p>
                <p class="comment"><?php echo $comment?></p>
            </div>

            <?php
        }
    } else {
        echo '<p>No reviews found for this product.</p>';
    }
    echo ($reviews && $offset < $total_review_count) ? "<button id=\"view-more-btn\" class=\"view-more-btn\">View More Reviews</button>" : "";
    exit;
}

// Hook the AJAX handler to WordPress
add_action('wp_ajax_fetch_reviews', 'fetch_reviews');
add_action('wp_ajax_nopriv_fetch_reviews', 'fetch_reviews');
