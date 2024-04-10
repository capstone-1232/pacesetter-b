<?php
// Get the current category object
$current_category = get_queried_object();

// Check if ACF function exists and if the field is set for the current category
if (function_exists('get_field') && get_field('category_banner', $current_category)) {
    // Get the value of the 'category_banner' ACF field for the current category
    $banner_image = get_field('category_banner', $current_category);
} else {
    // Set a default value if the field is not set or ACF is not active
    $banner_image = '';
}
?>

<div class="page-banner" style="background-image: url('<?php echo esc_url($banner_image); ?>')">
    <h1><?php woocommerce_page_title(); ?></h1>
</div>
