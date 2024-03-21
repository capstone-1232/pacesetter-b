<?php
/**
 * Function to submit a review for a product.
 *
 * @param int $product_id The ID of the product for which the review is submitted.
 * @param int $rating The rating provided in the review.
 * @param string $comment The comment content provided in the review.
 * @param string $name The name of the reviewer.
 * 
 * @return bool|int Returns the review ID if the review was successfully submitted, false otherwise.
 */
function submit_product_review($product_id, $rating, $comment, $name) {
    // Check if WooCommerce is active
    if (class_exists('WC_Product_Review')) {
        // Create a new review object
        $review = new WC_Product_Review();

        // Set review data
        $review_data = array(
            'comment_post_ID' => $product_id,
            'comment_author' => $name,
            'comment_content' => $comment,
            'user_id' => $name, // Assuming the user is logged in
            'comment_approved' => 1,
            'rating' => $rating,
        );

        // Save the review
        $review_id = $review->save_comment($review_data);

        // Return the review ID if successfully added, or false if failed
        return $review_id;
    }

    // Return false if WooCommerce is not active or review couldn't be added
    return false;
}

// Register the function for AJAX submission
add_action('wp_ajax_submit_product_review', 'submit_product_review');
add_action('wp_ajax_nopriv_submit_product_review', 'submit_product_review');
?>
