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
        </div>
    </main>
</div>
<script>
        document.addEventListener('DOMContentLoaded', function () {
        offset = 12;
        currentSlug = "<?php echo $current_slug?>";

        function updateProducts() {
        var xhr = new XMLHttpRequest();
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    document.getElementById('products').innerHTML = xhr.responseText;
                } else {
                    console.error('Error:', xhr.status, xhr.statusText);
                }
            }
        };
        xhr.open('POST', ajax_object.ajax_url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.send('action=fetch_products&offset=' + offset + '&current_slug=' + currentSlug);
    }
    updateProducts();

        // Event handler for filter buttons (using event delegation)
        document.addEventListener('click', function(event) {
            // Check if the clicked element has the class '.events-filter'
            if (event.target && event.target.classList.contains('view-more-btn')) {
                event.preventDefault();

                // Increment offset
                offset = offset + 12;

                // Call functions
                updateProducts()

            }
        });
    });
</script>
<?php get_footer(); ?>
