<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 */
?>

<?php

// require_once ABSPATH . 'wp-admin/includes/plugin.php';
// if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
//     include_once( WC()->plugin_path() . '/includes/wc-template-functions.php' );
// }

 global $product;

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = isset($_POST["name"]) ? sanitize_text_field($_POST["name"]) : '';
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];
    $product_id = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : 0;

    if ($product_id > 0) { // Check if product ID is valid
        // Add the review using WooCommerce function
        $review_data = array(
            'comment_post_ID' => $product_id,
            'comment_author' => $name,
            'comment_content' => $comment,
            'user_id' => $name, // Assuming the user is logged in
            'comment_approved' => 1,
            'rating' => $rating,
        );

        // Insert the comment into the database
        $comment_id = wp_insert_comment($review_data);
        print_r($comment_id);

        if ($comment_id) {
            // Add the rating to the comment meta
            add_comment_meta($comment_id, 'rating', $rating);
        
            // Increment the review count for the corresponding rating
            $ratings_count = get_post_meta($product_id, '_wc_rating_count', true);
        if (!is_array($ratings_count)) {
            // If $ratings_count is not an array, initialize it as an empty array
            $ratings_count = array();
        }
            if (isset($ratings_count[$rating])) {
                $ratings_count[$rating]++;
            } else {
                $ratings_count[$rating] = 1;
            }
        
            // Update the '_wc_rating_count' meta with the modified ratings count array
            update_post_meta($product_id, '_wc_rating_count', $ratings_count);
        
            // Calculate the new average rating
            $total_ratings_count = array_sum($ratings_count);
            $total_score = 0;
            foreach ($ratings_count as $rating_value => $count) {
                $total_score += $rating_value * $count;
            }
            $new_average_rating = $total_score / $total_ratings_count;
        
            // Update the '_wc_average_rating' meta with the new average rating
            update_post_meta($product_id, '_wc_average_rating', $new_average_rating);
        
            // Redirect back to the product page after submission
            wp_redirect(get_permalink($product_id) . '#reviews');
            exit;
        } else {
            // Handle error if the review couldn't be added
            echo 'Failed to submit review. Please try again.';
        }
    } else {
        echo 'Invalid product ID. Please try again.';
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
$product_brands = wp_get_post_terms($product_id, 'brands');

if (!empty($product_brands) && !is_wp_error($product_brands)) {
    $product_brand = $product_brands[0];
    $brand_name = $product_brands[0]->name;
    $brand_logo_url = get_field('brand_logo', $product_brand);
    $brand_slogan = get_field('brand_slogan', $product_brand);
}

get_header(); 

?>
<main class="product">
    <div class="container">
    <?php custom_product_breadcrumbs(); ?>
    <section id="productInfo">
        <div class="grid-container">
            <div class="heading">
                <h2><?php echo $product_title?></h2>
                <span></span>
            </div>
                <?php
                // Check if there are gallery images
                // if (!empty($gallery_image_ids)) {
                //     foreach ($gallery_image_ids as $image_id) {
                //         // Get the image URL
                //         $image_url = wp_get_attachment_image_url($image_id, 'full');

                //         // Output the image
                //         echo '<img src="' . esc_url($image_url) . '" alt="Gallery Image">';
                //     }
                // }
                ?>
            <img src="<?php echo esc_url($product_image_url ? $product_image_url : home_url() . "/wp-content/themes/pacesetter-b/img/placeholder.webp")?>" alt="">
            <p class="slogan"><?php echo isset($brand_slogan) ? $brand_slogan : '';?></p>
            <?php if (isset($brand_logo_url)) : ?>
                <img class="brand" src="<?php echo $brand_logo_url; ?>" alt="Product logo for <?php echo $brand_name; ?>">
            <?php endif; ?>
            <!-- Call product rating function -->
            <?php render_product_rating_stars($product_id); ?>
            <div class="stock-check">
                <?php
                // Display if item is in stock
                echo ( $product->is_in_stock() ) ?
                    '<p class="in-stock">In stock <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                  </svg>
                  </p>' : '<p class="out-stock">Out of Stock <svg fill="#000000" width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>cancel</title> <path d="M16 29c-7.18 0-13-5.82-13-13s5.82-13 13-13 13 5.82 13 13-5.82 13-13 13zM21.961 12.209c0.244-0.244 0.244-0.641 0-0.885l-1.328-1.327c-0.244-0.244-0.641-0.244-0.885 0l-3.761 3.761-3.761-3.761c-0.244-0.244-0.641-0.244-0.885 0l-1.328 1.327c-0.244 0.244-0.244 0.641 0 0.885l3.762 3.762-3.762 3.76c-0.244 0.244-0.244 0.641 0 0.885l1.328 1.328c0.244 0.244 0.641 0.244 0.885 0l3.761-3.762 3.761 3.762c0.244 0.244 0.641 0.244 0.885 0l1.328-1.328c0.244-0.244 0.244-0.641 0-0.885l-3.762-3.76 3.762-3.762z"></path> </g></svg></p>';
                ?>
            </div>
            <p class="price">$<?php echo $product_price?> <span>CAD</span></p>
            <?php
                if($attributes) {
                    foreach ($attributes as $attribute) {
                        if ($attribute->is_taxonomy()) {
                            $taxonomy = $attribute->get_terms();
                        }
                        $attribute_name = $attribute->get_name();
                        $cleaned_attribute_name = str_replace('pa_', '', $attribute_name);
                        $cleaned_and_capitalized_attribute_name = ucwords($cleaned_attribute_name);
                        echo '<div class="attributes">';
                        echo '<h4>' . esc_html($cleaned_and_capitalized_attribute_name) . '</h4>';
                        if ($cleaned_and_capitalized_attribute_name == "Size") {
                            echo "<a href=\"#\">Size Guide</a>";
                        }
                        echo '</div>';
                        echo "<div class=\"attribute-values\">";
                        foreach ($taxonomy as $term) {
                            // Use term name instead of slug
                            $term_name = $term->name;
                            $term_slug = $term->slug;
                            echo '<label><input type="radio" name="attribute_' . esc_attr(sanitize_title($attribute_name)) . '" value="' . esc_attr($term_slug) . '">' . esc_html($term_name) . '</label>';
                        }
                        echo "</div>";
                    }
                }
            ?>
            <p class="description"><?php echo $short_description;?></p>
            <div class="questions">
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact-us'))); ?>">Ask us a Question</a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('faq'))); ?>">Product Care Guides</a>
            </div>
        </div>
            </div>
    </section>
    <div class="container snow-texture" style="background: url(<?php echo home_url(); ?>/wp-content/themes/pacesetter-b/img/snow-background-texture.webp)">
        <div class="background-overlay"></div>    
    <section id="productFeatures">
        <div class="heading">
            <div class="container-narrow">
                <h3>Features</h3>
                <span></span>
            </div>
        </div>
        <div class="container-narrow">
            <div class="feature-content">
                <p><?php echo $product_description?></p>
            </div>
        </div>
        </section>
        <section id="reviews">
            <div class="container-narrow">
                <div class="container-narrow">
                    <div class="grid-container">
                        <div class="heading">
                            <h3>Customer Reviews</h3>
                            <span class=""></span>
                        </div>
                        <div class="reviews-container" id="reviewsContainer">
                            </div>
                            <div class="average-review">
                                <p>Average Customer Review</p>
                                <p><span><?php echo number_format((float)get_post_meta($product_id, '_wc_average_rating', true),1);?></span> out of <span>5</span> stars</p>
                                <?php render_product_rating_stars($product_id);?>
                            </div>
                            <div class="review-button">
                                <button id="openReviewModal">Review This Product</button>
                            </div>
                            <span></span>
                        </div>
                    </div>
                </div>
        <div id="reviewModalMobile" class="review-modal-mobile">
            <div class="review-modal-content">
                <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.910926 0.937369C1.10637 0.742446 1.37131 0.632959 1.64754 0.632959C1.92377 0.632959 2.18871 0.742446 2.38415 0.937369L9.98656 8.5289L17.589 0.937369C17.6844 0.835103 17.7995 0.753079 17.9273 0.696188C18.0552 0.639297 18.1932 0.608707 18.3332 0.606241C18.4732 0.603775 18.6122 0.629484 18.742 0.681835C18.8718 0.734186 18.9897 0.812107 19.0887 0.910947C19.1876 1.00979 19.2657 1.12752 19.3181 1.25713C19.3705 1.38674 19.3963 1.52557 19.3938 1.66533C19.3913 1.80509 19.3607 1.94292 19.3037 2.0706C19.2467 2.19828 19.1646 2.3132 19.0622 2.40849L11.4598 10L19.0622 17.5915C19.1646 17.6868 19.2467 17.8018 19.3037 17.9294C19.3607 18.0571 19.3913 18.195 19.3938 18.3347C19.3963 18.4745 19.3705 18.6133 19.3181 18.7429C19.2657 18.8725 19.1876 18.9902 19.0887 19.0891C18.9897 19.1879 18.8718 19.2659 18.742 19.3182C18.6122 19.3706 18.4732 19.3963 18.3332 19.3938C18.1932 19.3913 18.0552 19.3607 17.9273 19.3039C17.7995 19.247 17.6844 19.1649 17.589 19.0627L9.98656 11.4711L2.38415 19.0627C2.18655 19.2465 1.9252 19.3466 1.65515 19.3419C1.38511 19.3371 1.12745 19.2279 0.936468 19.0372C0.745487 18.8465 0.63609 18.5892 0.631326 18.3195C0.626561 18.0498 0.7268 17.7889 0.910926 17.5915L8.51333 10L0.910926 2.40849C0.715722 2.21332 0.606079 1.94877 0.606079 1.67293C0.606079 1.39709 0.715722 1.13254 0.910926 0.937369Z" fill="#aaa"/>
                    </svg>
                <div class="form-content">
                    <div>
                        <h2>Review This Product!</h2>
                        <form id="reviewForm" class="review-form" method="post" action="<?php echo esc_url( get_the_permalink() ); ?>#reviews">
                            <div>
                                <label for="name">Your Name <span class="required">*</span></label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            
                            <div>
                                <label for="rating">Your Rating <span class="required">*</span></label>
                                <select name="rating" id="productRating" required>
                                    <option value=""></option>
                                    <option value="1">⭐</option>
                                    <option value="2">⭐⭐</option>
                                    <option value="3">⭐⭐⭐</option>
                                    <option value="4">⭐⭐⭐⭐</option>
                                    <option value="5">⭐⭐⭐⭐⭐</option>
                                </select>
                            </div>    
                            
                            <div class="custom-form-comment">
                                <label for="comment">Your Comment <span class="required">*</span></label>
                                <textarea id="comment" name="comment" cols="45" rows="10" required></textarea>
                            </div>
                            
                            <div class="form-submit">
                                <?php wp_nonce_field( 'woocommerce-posted-review', 'woocommerce-nonce' ); ?>
                                <input type="hidden" name="product_id" value="<?php echo esc_attr( $product_id ); ?>" />
                                <button type="submit" class="product-submit"><?php esc_html_e( 'Submit Review', 'woocommerce' ); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="reviewModalDesktop" class="review-modal-desktop">
            <div class="review-modal-content">
                <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.910926 0.937369C1.10637 0.742446 1.37131 0.632959 1.64754 0.632959C1.92377 0.632959 2.18871 0.742446 2.38415 0.937369L9.98656 8.5289L17.589 0.937369C17.6844 0.835103 17.7995 0.753079 17.9273 0.696188C18.0552 0.639297 18.1932 0.608707 18.3332 0.606241C18.4732 0.603775 18.6122 0.629484 18.742 0.681835C18.8718 0.734186 18.9897 0.812107 19.0887 0.910947C19.1876 1.00979 19.2657 1.12752 19.3181 1.25713C19.3705 1.38674 19.3963 1.52557 19.3938 1.66533C19.3913 1.80509 19.3607 1.94292 19.3037 2.0706C19.2467 2.19828 19.1646 2.3132 19.0622 2.40849L11.4598 10L19.0622 17.5915C19.1646 17.6868 19.2467 17.8018 19.3037 17.9294C19.3607 18.0571 19.3913 18.195 19.3938 18.3347C19.3963 18.4745 19.3705 18.6133 19.3181 18.7429C19.2657 18.8725 19.1876 18.9902 19.0887 19.0891C18.9897 19.1879 18.8718 19.2659 18.742 19.3182C18.6122 19.3706 18.4732 19.3963 18.3332 19.3938C18.1932 19.3913 18.0552 19.3607 17.9273 19.3039C17.7995 19.247 17.6844 19.1649 17.589 19.0627L9.98656 11.4711L2.38415 19.0627C2.18655 19.2465 1.9252 19.3466 1.65515 19.3419C1.38511 19.3371 1.12745 19.2279 0.936468 19.0372C0.745487 18.8465 0.63609 18.5892 0.631326 18.3195C0.626561 18.0498 0.7268 17.7889 0.910926 17.5915L8.51333 10L0.910926 2.40849C0.715722 2.21332 0.606079 1.94877 0.606079 1.67293C0.606079 1.39709 0.715722 1.13254 0.910926 0.937369Z" fill="#aaa"/>
                    </svg>
                <div class="form-content">
                    <div>
                        <h2>Review This Product!</h2>
                        <form id="reviewForm" class="review-form" method="post" action="<?php echo esc_url( get_the_permalink() ); ?>#reviews">
                            <div>
                                <label for="name">Your Name <span class="required">*</span></label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            
                            <div>
                                <label for="rating">Your Rating <span class="required">*</span></label>
                                <select name="rating" id="productRating" required>
                                    <option value=""></option>
                                    <option value="1">⭐</option>
                                    <option value="2">⭐⭐</option>
                                    <option value="3">⭐⭐⭐</option>
                                    <option value="4">⭐⭐⭐⭐</option>
                                    <option value="5">⭐⭐⭐⭐⭐</option>
                                </select>
                            </div>    
                            
                            <div class="custom-form-comment">
                                <label for="comment">Your Comment <span class="required">*</span></label>
                                <textarea id="comment" name="comment" cols="45" rows="10" required></textarea>
                            </div>
                            
                            <div class="form-submit">
                                <?php wp_nonce_field( 'woocommerce-posted-review', 'woocommerce-nonce' ); ?>
                                <input type="hidden" name="product_id" value="<?php echo esc_attr( $product_id ); ?>" />
                                <button type="submit" class="product-submit"><?php esc_html_e( 'Submit Review', 'woocommerce' ); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var offset = 2;
        const productID = <?php echo $product_id?>;

        function updateReviews() {
        var xhr = new XMLHttpRequest();
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    document.getElementById('reviewsContainer').innerHTML = xhr.responseText;
                } else {
                    console.error('Error:', xhr.status, xhr.statusText);
                }
            }
        };
        xhr.open('POST', ajax_object.ajax_url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.send('action=fetch_reviews&offset=' + offset + '&product_id=' + productID);
    }
    updateReviews();

    // Event handler for filter buttons (using event delegation)
    document.addEventListener('click', function(event) {
        // Check if the clicked element has the class '.events-filter'
        if (event.target && event.target.classList.contains('view-more-btn')) {
            event.preventDefault();

            // Increment offset
            offset = offset + 2;

            // Call functions
            updateReviews()

        }
    });
    });

    // Get the modal element
    var mobileModal = document.getElementById('reviewModalMobile');
    var desktopModal =document.getElementById('reviewModalDesktop');

    // Get the button that opens the modal
    var btn = document.getElementById("openReviewModal");

    // When the user clicks the button, open the modal
    function handleClick() {
    const windowWidth = window.innerWidth;

        if (windowWidth >= 781) {
            desktopModal.style.visibility = "visible";
            desktopModal.style.opacity = "1";
        } else {
            mobileModal.style.left = "0";
        }
    }

    function handleCloseClick() {
        const windowWidth = window.innerWidth;

        if (windowWidth >= 781) {
            desktopModal.style.visibility = "hidden";
            desktopModal.style.opacity = "0";
        } else {
            mobileModal.style.left = "-110%";
        }
    }

    btn.addEventListener('click', handleClick);

    document.addEventListener('click', function(event) {
    if (event.target && event.target.classList.contains('close')) {
        handleCloseClick();
    }
    });
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            handleCloseClick();
        }
    }

</script>
<?php
get_footer();
