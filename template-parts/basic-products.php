<section class="container products basics">
    <div class="products-flex">
        <h2>New to the Slopes? <span>Get the basics here!</span></h2>
        <?php
        // Get product category ID for "basics"
        $basics_category_id = term_exists('basics', 'product_cat');
    
        // Check if the category exists
        if ($basics_category_id !== 0 && $basics_category_id !== null) {
            $basics_category_id = $basics_category_id['term_id'];
    
            // Get up to 4 products from the "basics" category
            $basics_products = get_posts(
                array(
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'id',
                            'terms' => $basics_category_id,
                        ),
                    ),
                    'numberposts' => 4,
                    'post_type' => 'product',
                    'orderby' => 'rand', // Display random products
                )
            );
    
            $shop_page_url = get_permalink(wc_get_page_id('shop'));
    
            // Display products
            foreach ($basics_products as $product) {
                $product_id = $product->ID;
                $wc_product = wc_get_product($product_id);
    
                // Retrieve product information
                $product_title = $wc_product->get_title();
                $product_price = $wc_product->get_price();
                $product_image_url = get_the_post_thumbnail_url($product_id, 'full');
                $short_description = $wc_product->get_short_description();
                $product_url = get_permalink($product_id);
                $in_stock = $wc_product->is_in_stock() ? 'In Stock <svg fill="#000000" width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>checkmark</title> <path d="M16 3c-7.18 0-13 5.82-13 13s5.82 13 13 13 13-5.82 13-13-5.82-13-13-13zM23.258 12.307l-9.486 9.485c-0.238 0.237-0.623 0.237-0.861 0l-0.191-0.191-0.001 0.001-5.219-5.256c-0.238-0.238-0.238-0.624 0-0.862l1.294-1.293c-0.238-0.238 0.624-0.238 0.862 0l3.689 3.716 7.756-7.756c-0.238-0.238 0.624-0.238 0.862 0l1.294 1.294c0.239 0.237 0.239 0.623 0.001 0.862z"></path> </g></svg>' : 'Out of Stock <svg fill="#000000" width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>cancel</title> <path d="M16 29c-7.18 0-13-5.82-13-13s5.82-13 13-13 13 5.82 13 13-5.82 13-13 13zM21.961 12.209c0.244-0.244 0.244-0.641 0-0.885l-1.328-1.327c-0.244-0.244-0.641-0.244-0.885 0l-3.761 3.761-3.761-3.761c-0.244-0.244-0.641-0.244-0.885 0l-1.328 1.327c-0.244 0.244-0.244 0.641 0 0.885l3.762 3.762-3.762 3.76c-0.244 0.244-0.244 0.641 0 0.885l1.328 1.328c0.244 0.244 0.641 0.244 0.885 0l3.761-3.762 3.761 3.762c0.244 0.244 0.641 0.244 0.885 0l1.328-1.328c0.244-0.244 0.244-0.641 0-0.885l-3.762-3.76 3.762-3.762z"></path> </g></svg>';
                ?>
    
                <!-- Render product cards -->
                <div class="product-card">
                    <img src="<?php echo esc_url($product_image_url) ?>" alt="<?php echo $short_description ?>">
                    <h3>
                        <?php echo $product_title ?>
                    </h3>
                    <p>
                        <?php echo $short_description ?>
                    </p>
                    <div class="product-status">
                        <p>$
                            <?php echo $product_price ?>
                        </p>
                        <p>
                            <?php echo $in_stock ?>
                        </p>
                    </div>
                    <a class="card-button" href="<?php echo esc_url($product_url); ?>">View Product</a>
                </div>
            <?php } ?>
    </div>

    <?php } ?>
</section>