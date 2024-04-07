<?php
// Get the current post/page ID
$current_id = get_the_ID();

// Get the featured image URL
$featured_image_url = get_the_post_thumbnail_url($current_id, 'full');

// Get the page title
$page_title = get_the_title($current_id);
?>

<div class="page-banner" style="background-image: url('<?php echo esc_url($featured_image_url); ?>')">
    <h1><?php echo esc_html($page_title); ?></h1>
</div>