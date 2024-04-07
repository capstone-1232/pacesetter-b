<?php

// Get the current page slug
$current_slug = basename(get_permalink());

// Get the WooCommerce product category based on the slug
$category = get_term_by('slug', $current_slug, 'product_cat'); 

// Get the ACF banner-image field value for the current category
$banner_image = get_field('category_banner', $category);

// Get the category title
$category_title = $category->name;
?>

<div class="page-banner" style="background-image: url('<?php echo esc_url($banner_image); ?>')">
    <h1><?php echo esc_html($category_title); ?></h1>
</div>
