<?php
/**
 * The template for displaying product categories
 *
 * This is the template that displays product categories
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pacesetter
 */
?>

<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php get_template_part('template-parts/products-banner'); ?>
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
                    $category_image_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                    $category_image = wp_get_attachment_url($category_image_id);
                    ?>
                    <a href="<?php echo home_url('/products/' . $category->slug); ?>" class="category-link">
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
