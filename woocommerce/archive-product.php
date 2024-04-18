<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */
get_template_part('template-parts/woocommerce-header'); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
    <?php
    $shop_page_id = wc_get_page_id( 'shop' );
    $featured_image_url = get_the_post_thumbnail_url( $shop_page_id, 'full' );
    ?>

    <div class="page-banner" style="background-image: url('<?php echo esc_url($featured_image_url); ?>')">
        <h1><?php woocommerce_page_title(); ?></h1>
    </div>
        <?php get_template_part('template-parts/breadcrumbs'); ?>

        <div class="category-links">
            <?php
            $exclude_category_basics = get_term_by('name', 'basics', 'product_cat');
            $exclude_category_uncategorized = get_term_by('name', 'uncategorized', 'product_cat');

            $args = array(
                'taxonomy'   => 'product_cat',
                'orderby'    => 'name',
                'order'      => 'ASC',
                'hide_empty' => false,
                'exclude'    => array($exclude_category_basics->term_id, $exclude_category_uncategorized->term_id),
                'parent'     => 0,
            );

            $categories = get_terms($args);

            if (!empty($categories)) :
                foreach ($categories as $category) :
					$category_url = get_category_link($category->term_id);
                    $category_image_id = get_term_meta($category->term_id, 'thumbnail_id', true);

                    $category_image = wp_get_attachment_url($category_image_id);

                    if ($category_image == ""){
                        $category_image = get_template_directory_uri() . '/img/faq-banner.jpg';
                    }

                    ?>
                    <a href="<?php echo esc_html($category_url); ?>" class="category-link">
                        <div style="background-image: url('<?php echo $category_image?>');">
                            <h2><?php echo esc_html($category->name); ?></h2>
                        </div>
                    </a>
                <?php
                endforeach;
            else :
                echo esc_html__('No categories found', 'pacesetter');
            endif;
            ?>
        </div>
    </main>
</div>

<?php get_footer(); ?>
