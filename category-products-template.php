<?php
/*
Template Name: Products Category Page Template
*/
?>

<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php 
        
        // Get the current page slug
        $current_slug = basename(get_permalink());
        $current_url = get_permalink();

        // Get the WooCommerce product category based on the slug
        $category = get_term_by('slug', $current_slug, 'product_cat');
        $category_id = $category->term_id;

        // Get the current page slug
        $current_slug = basename(get_permalink());

        // Get the ACF banner-image field value for the current category
        $banner_image = get_field('category_banner', 'product_cat_' . $category_id);

        $category_description = term_description($category_id, 'product_cat');

        // Get the category title
        $category_title = $category->name;
        ?>

        <div class="page-banner" style="">
        <div>
            <h1><?php echo esc_html($category_title); ?></h1>
            <?php echo $category_description?>
        </div>
        <img src="<?php echo esc_url($banner_image);?>" alt="">
        </div>
        <?php get_template_part('template-parts/breadcrumbs'); ?>
        <div class="filters"></div>
        <div id="removeFilterList"></div>
        <div id="products">
        <?php
        $args = array(
            'post_type' => 'product',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $current_slug,
                ),
            ),
        );
        
        $products_query = new WP_Query($args);
        
        // Now you can loop through the products
        if ($products_query->have_posts()) {
            while ($products_query->have_posts()) {
                $products_query->the_post();
                $product_id = $products_query->ID;
                $product_image_url = get_the_post_thumbnail_url($product_id, 'full');
                $product_price = $product->get_price();
                $product_url = get_permalink($product_id);
                $in_stock = $product->is_in_stock() ? 'In Stock <svg fill="#000000" width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>checkmark</title> <path d="M16 3c-7.18 0-13 5.82-13 13s5.82 13 13 13 13-5.82 13-13-5.82-13-13-13zM23.258 12.307l-9.486 9.485c-0.238 0.237-0.623 0.237-0.861 0l-0.191-0.191-0.001 0.001-5.219-5.256c-0.238-0.238-0.238-0.624 0-0.862l1.294-1.293c0.238-0.238 0.624-0.238 0.862 0l3.689 3.716 7.756-7.756c0.238-0.238 0.624-0.238 0.862 0l1.294 1.294c0.239 0.237 0.239 0.623 0.001 0.862z"></path> </g></svg>' : 'Out of Stock <svg fill="#000000" width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>cancel</title> <path d="M16 29c-7.18 0-13-5.82-13-13s5.82-13 13-13 13 5.82 13 13-5.82 13-13 13zM21.961 12.209c0.244-0.244 0.244-0.641 0-0.885l-1.328-1.327c-0.244-0.244-0.641-0.244-0.885 0l-3.761 3.761-3.761-3.761c-0.244-0.244-0.641-0.244-0.885 0l-1.328 1.327c-0.244 0.244-0.244 0.641 0 0.885l3.762 3.762-3.762 3.76c-0.244 0.244-0.244 0.641 0 0.885l1.328 1.328c0.244 0.244 0.641 0.244 0.885 0l3.761-3.762 3.761 3.762c0.244 0.244 0.641 0.244 0.885 0l1.328-1.328c0.244-0.244 0.244-0.641 0-0.885l-3.762-3.76 3.762-3.762z"></path> </g></svg>';
                // Render products
                ?>
                <a href="<?php echo $product_url?>">
                    <div>
                        <img src="<?php echo $product_image_url?>" alt="">
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
            echo 'No products found in the "' . $category_title . '" category.';
        }
        ?>
        </div>
    </main>
</div>

<?php get_footer(); ?>
