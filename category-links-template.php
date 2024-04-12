<?php
/*
Template Name: Products Category Template
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

        get_template_part('template-parts/category-banner');
        get_template_part('template-parts/breadcrumbs');
        if ($category) {
            echo '<div class="category-links container">';

            // Get child categories of the current category
            $child_categories_ids = get_term_children($category->term_id, 'product_cat');

            foreach ($child_categories_ids as $child_category_id) {
                $child_category = get_term($child_category_id, 'product_cat');
                $child_category_slug = $child_category->slug;
                $child_category_name = $child_category->name;
                $child_category_img = get_category_image_url($child_category->term_id);
                ?>
                <a href="<?php echo esc_url($current_url . $child_category_slug);?>" class="category-link">
                    <div style="background-image: url('<?php echo $child_category_img ?>');">
                        <h2><?php echo $child_category_name ?></h2>
                    </div>
                </a>
                <?php
            }

            echo '</div>';
        } else {
            echo '<p>No category found for this page.</p>';
        }
        ?>

    </main>
</div>

<?php get_footer(); ?>

<?php
// Helper function to get category image URL
function get_category_image_url($category_id) {
    $category_image_id = get_term_meta($category_id, 'thumbnail_id', true);
    return $category_image_id ? wp_get_attachment_url($category_image_id) : '';
}
?>
