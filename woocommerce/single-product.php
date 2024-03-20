<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 */
?>

<?php

require_once ABSPATH . 'wp-admin/includes/plugin.php';
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
    include_once( WC()->plugin_path() . '/includes/wc-template-functions.php' );
}

 global $product;

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = isset($_POST["name"]) ? sanitize_text_field($_POST["name"]) : '';
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];
    $product_id = $_POST["product_id"];

    // Add the review using WooCommerce function
    $review_data = array(
        'comment_post_ID' => $product_id,
        'comment_author' => $name,
        'comment_content' => $comment,
        'user_id' => $name, // Assuming the user is logged in
        'comment_approved' => 1,
        'rating' => $rating,
    );

    // Create the review
    $review_id = wc_create_review($product_id, $review_data);

    // Check if the review was successfully submitted
    if ($review_id) {
        // Redirect back to the product page after submission
        wp_redirect(get_the_permalink($product_id) . '#reviews');
        exit;
    } else {
        // Handle error if the review couldn't be added
        echo 'Failed to submit review. Please try again.';
    }
}


 // Get product ID
 if (is_string($product)) {
    // Get the product object based on the product ID
    $product = wc_get_product(get_the_ID());
}
// Retrieve product details
$product_id = $product->get_id();
$product_title = $product->get_title();
$product_price = $product->get_price();
$product_image_url = get_the_post_thumbnail_url($product_id, 'full');
$gallery_image_ids = $product->get_gallery_image_ids();
$short_description = $product->get_short_description();
$product_description = $product->get_description();
$product_price = $product->get_price();
$attributes = $product->get_attributes();

get_header(); 
custom_product_breadcrumbs();

?>
<main>
    <section>
        <div>
            <h2><?php echo $product_title?></h2>
            <div>
                <?php
                // Check if there are gallery images
                if (!empty($gallery_image_ids)) {
                    foreach ($gallery_image_ids as $image_id) {
                        // Get the image URL
                        $image_url = wp_get_attachment_image_url($image_id, 'full');

                        // Output the image
                        echo '<img src="' . esc_url($image_url) . '" alt="Gallery Image">';
                    }
                }
                ?>
            </div>
            <div><img src="<?php echo $product_image_url?>" alt=""></div>
        </div>
        <div>
            <div>
                <p>Legendary Performance</p>
                <p>Brand name</p>
            </div>
            <div>
                <?php
                // Call product rating function
                render_product_rating_stars($product_id);
                ?>
                <div>
                    <?php
                    // Display if item is in stock
                    echo ( $product->is_in_stock() ) ?
                        'In stock <svg fill="#000000" width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>checkmark</title> <path d="M16 3c-7.18 0-13 5.82-13 13s5.82 13 13 13 13-5.82 13-13-5.82-13-13-13zM23.258 12.307l-9.486 9.485c-0.238 0.237-0.623 0.237-0.861 0l-0.191-0.191-0.001 0.001-5.219-5.256c-0.238-0.238-0.238-0.624 0-0.862l1.294-1.293c0.238-0.238 0.624-0.238 0.862 0l3.689 3.716 7.756-7.756c0.238-0.238 0.624-0.238 0.862 0l1.294 1.294c0.239 0.237 0.239 0.623 0.001 0.862z"></path> </g></svg>' : 'Out of Stock <svg fill="#000000" width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>cancel</title> <path d="M16 29c-7.18 0-13-5.82-13-13s5.82-13 13-13 13 5.82 13 13-5.82 13-13 13zM21.961 12.209c0.244-0.244 0.244-0.641 0-0.885l-1.328-1.327c-0.244-0.244-0.641-0.244-0.885 0l-3.761 3.761-3.761-3.761c-0.244-0.244-0.641-0.244-0.885 0l-1.328 1.327c-0.244 0.244-0.244 0.641 0 0.885l3.762 3.762-3.762 3.76c-0.244 0.244-0.244 0.641 0 0.885l1.328 1.328c0.244 0.244 0.641 0.244 0.885 0l3.761-3.762 3.761 3.762c0.244 0.244 0.641 0.244 0.885 0l1.328-1.328c0.244-0.244 0.244-0.641 0-0.885l-3.762-3.76 3.762-3.762z"></path> </g></svg>';
                    ?>
                </div>
                <div>
                    <!-- Display if available online or in store. -->
                    <p>In store</p>
                    <p>Online</p>
                </div>
                    <p><?php echo $short_description;?></p>
                    <p><?php echo $product_price?></p>
                    <div>
                    <?php
                    // Display each attribute and its terms
                    foreach ( $attributes as $attribute ) {
                        $attribute_name = $attribute->get_name();
                        $options = $attribute->get_options();
                        echo '<div>';
                        echo '<h4>' . esc_html( $attribute_name ) . '</h4>';
                        if ($attribute_name == "Size") {
                            echo "<a href=\"#\">Size Guide</a>";
                        }
                        echo '</div>';
                        
                        foreach ( $options as $option_id => $option ) {
                            echo '<label><input type="radio" name="attribute_' . esc_attr( sanitize_title( $attribute_name ) ) . '" value="' . esc_attr( $option_id ) . '">' . esc_html( $option ) . '</label><br>';
                        }
                    }
                    ?>
                    </div>
                    <div>
                        <a href="">Ask us a Question</a>
                        <a href="">Product Care Guides</a>
                    </div>
            </div>
        </div>
    </section>
    <section>
        <h3>Features</h3>
        <div>
            <p><?php echo $product_description?></p>
        </div>
    </section>
    <section id="reviews">
        <div>
        <h3>Customer Reviews</h3>
        <?php
        // Get review query
        $args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 2,
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
        $reviews = get_comments($args);
        // render reviews
        if ($reviews) {
            foreach ($reviews as $review) {
                $rating   = intval(get_comment_meta($review->comment_ID, 'rating', true));
                $title    = get_comment_meta($review->comment_ID, 'title', true);
                $comment  = $review->comment_content;
                $author   = $review->comment_author;
                $datetime = strtotime($review->comment_date);
                $date     = date('F j, Y', $datetime);
                ?>
                
                <div>
                    <?php render_review_rating_stars($rating)?>
                    <h5><?php echo $title?></h5>
                    <div>
                        <p><?php echo $author?></p>
                        <p><?php echo $date?></p>
                    </div>
                    <p><?php echo $comment?></p>
                </div>

                <?php
            }
        } else {
            echo '<p>No reviews found for this product.</p>';
        }
        ?>
        </div>
        <div>
            <p>Average Customer Review</p>
            <p><?php echo number_format((float)get_post_meta($product_id, '_wc_average_rating', true),1);?> out of 5 stars</p>
            <?php render_product_rating_stars($product_id);?>
            <button id="openReviewModal">Review This Product</button>
        </div>
        <div id="reviewModal" class="review-modal">
            <div class="review-modal-content">
                <span class="close">&times;</span>
                <h2>Review This Product</h2>
                <form id="reviewForm" class="review-form" method="post" action="<?php echo esc_url( get_the_permalink() ); ?>#reviews">
                    <div>
                        <label for="name">Your Name<span class="required">*</span></label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div>
                        <label for="rating">Your Rating<span class="required">*</span></label>
                        <select name="rating" id="productRating" required>
                            <option value=""></option>
                            <option value="5">5 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="2">2 Stars</option>
                            <option value="1">1 Star</option>
                        </select>
                    </div>    

                    <div class="custom-form-comment">
                        <label for="comment">Your Review<span class="required">*</span></label>
                        <textarea id="comment" name="comment" cols="45" rows="8" required></textarea>
                    </div>

                    <div class="form-submit">
                        <?php wp_nonce_field( 'woocommerce-posted-review', 'woocommerce-nonce' ); ?>
                        <input type="hidden" name="product_id" value="<?php echo esc_attr( $product_id ); ?>" />
                        <button type="submit" class="product-submit"><?php esc_html_e( 'Submit', 'woocommerce' ); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
<script>
    // // Get the modal element
    // var modal = document.getElementById('reviewModal');

    // // Get the button that opens the modal
    // var btn = document.getElementById("openReviewModal");

    // // Get the <span> element that closes the modal
    // var span = document.getElementsByClassName("close")[0];

    // // When the user clicks the button, open the modal
    // btn.onclick = function() {
    //     modal.style.display = "block";
    // }

    // // When the user clicks on <span> (x), close the modal
    // span.onclick = function() {
    //     modal.style.display = "none";
    // }

    // // When the user clicks anywhere outside of the modal, close it
    // window.onclick = function(event) {
    //     if (event.target == modal) {
    //         modal.style.display = "none";
    //     }
    // }
    //     document.getElementById('rating').addEventListener('click', function(event) {
    //     event.preventDefault();
    // });

</script>
<?php
get_footer();
