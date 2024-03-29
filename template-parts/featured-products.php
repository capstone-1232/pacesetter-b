<section class="container featured-products">
    <div>
            <h2>Featured Products</h2>
    <?php
    // Get featured products
    $featured_products = wc_get_featured_product_ids();
    $shop_page_url = get_permalink(wc_get_page_id('shop'));
    
    // Shuffle the array of featured products
    shuffle($featured_products);
    
    // Display 3 of the featured products
    for ($i = 0; $i < min(3, count($featured_products)); $i++) {
        $product_id = $featured_products[$i];
        $product = wc_get_product($product_id);
    
        // Retrieve product information
        $product_title = $product->get_title();
        $product_price = $product->get_price();
        $product_image_url = get_the_post_thumbnail_url($product_id, 'full');
        $short_description = $product->get_short_description();
        $product_url = get_permalink($product_id);
        $in_stock = $product->is_in_stock() ? 'In Stock <svg fill="#000000" width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>checkmark</title> <path d="M16 3c-7.18 0-13 5.82-13 13s5.82 13 13 13 13-5.82 13-13-5.82-13-13-13zM23.258 12.307l-9.486 9.485c-0.238 0.237-0.623 0.237-0.861 0l-0.191-0.191-0.001 0.001-5.219-5.256c-0.238-0.238-0.238-0.624 0-0.862l1.294-1.293c0.238-0.238 0.624-0.238 0.862 0l3.689 3.716 7.756-7.756c0.238-0.238 0.624-0.238 0.862 0l1.294 1.294c0.239 0.237 0.239 0.623 0.001 0.862z"></path> </g></svg>' : 'Out of Stock <svg fill="#000000" width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>cancel</title> <path d="M16 29c-7.18 0-13-5.82-13-13s5.82-13 13-13 13 5.82 13 13-5.82 13-13 13zM21.961 12.209c0.244-0.244 0.244-0.641 0-0.885l-1.328-1.327c-0.244-0.244-0.641-0.244-0.885 0l-3.761 3.761-3.761-3.761c-0.244-0.244-0.641-0.244-0.885 0l-1.328 1.327c-0.244 0.244-0.244 0.641 0 0.885l3.762 3.762-3.762 3.76c-0.244 0.244-0.244 0.641 0 0.885l1.328 1.328c0.244 0.244 0.641 0.244 0.885 0l3.761-3.762 3.761 3.762c0.244 0.244 0.641 0.244 0.885 0l1.328-1.328c0.244-0.244 0.244-0.641 0-0.885l-3.762-3.76 3.762-3.762z"></path> </g></svg>';
        ?>
        <!-- Render product cards -->
            <div>
                <div>
                    <img src="<?php echo esc_url($product_image_url) ?>" alt="<?php echo $short_description ?>" aria-label="<?php echo "An image of a" . $short_description ?>">
                    <h3><?php echo $product_title ?></h3>
                    <p><?php echo $short_description ?></p>
                    <div>
                        <p>$<?php echo $product_price ?></p>
                        <p><?php echo $in_stock ?></p>
                    </div>
                    <a class="card-button" href="<?php echo esc_url($product_url);?>">View Product</a>
                </div>
            </div>
        </div>
    
    <?php } ?>
    <a class="yellow-btn" href="<?php echo esc_url($shop_page_url);?>">Shop All Products <svg fill="#000000" height="800px" width="800px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	        viewBox="0 0 491.1 491.1" xml:space="preserve">
            <g>
                <path d="M379.25,282.85l-192.8,192.8c-20.6,20.6-54,20.6-74.6,0s-20.6-54,0-74.6l155.5-155.5l-155.5-155.5
                    c-20.6-20.6-20.6-54,0-74.6s54-20.6,74.6,0l192.8,192.8C399.85,228.85,399.85,262.25,379.25,282.85z"/>
            </g>
            </svg></a>
</section>
