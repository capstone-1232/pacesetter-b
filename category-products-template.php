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
        <div id="filters"></div>
        <div id="removeFilterList"></div>
        <div id="products">
        </div>
    </main>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        offset = 12;
        currentSlug = "<?php echo $current_slug?>";

        // Array to store selected filters
        var selectedFilters = [];

        function updateProducts() {
            var xhr = new XMLHttpRequest();
            var filtersJSON = JSON.stringify(selectedFilters);
            
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
            xhr.send('action=fetch_products&offset=' + offset + '&current_slug=' + currentSlug + '&filters=' + encodeURIComponent(filtersJSON));
        }
        updateProducts();
        
        function updateActiveFilters() {
            var xhr = new XMLHttpRequest();
            var filtersJSON = JSON.stringify(selectedFilters);
            
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        document.getElementById('filters').innerHTML = xhr.responseText;
                    } else {
                        console.error('Error:', xhr.status, xhr.statusText);
                    }
                }
            };
            xhr.open('POST', ajax_object.ajax_url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            xhr.send('action=update_active_product_list_function&filters=' + encodeURIComponent(filtersJSON));
        }
        updateActiveFilters()

        // Function to update filter list with selected filters
        function updateFiltersList() {
            var xhr = new XMLHttpRequest();
            var filtersJSON = JSON.stringify(selectedFilters);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        document.getElementById('removeFilterList').innerHTML = xhr.responseText;
                    } else {
                        console.error('Error:', xhr.status, xhr.statusText);
                    }
                }
            };

            xhr.open('POST', ajax_object.ajax_url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            xhr.send('action=remove_product_filter_list_function&filters=' + encodeURIComponent(filtersJSON));
        }

        // Event handler for filter buttons (using event delegation)
        document.addEventListener('click', function(event) {
            // Check if the clicked element has the class '.events-filter'
            if (event.target && event.target.classList.contains('products-filter')) {
                event.preventDefault(); // Prevent default link behavior

                // Get data attributes
                var filterType = event.target.dataset.filter;
                var filterValue = event.target.dataset.value;

                // Check if the filter type is already present in the array
                var existingFilterIndex = selectedFilters.findIndex(function (item) {
                    return item.filterType === filterType;
                });

                // If present, replace the value; otherwise, add a new entry
                if (existingFilterIndex !== -1) {
                    selectedFilters[existingFilterIndex].filterValue = filterValue;
                } else {
                    selectedFilters.push({ filterType: filterType, filterValue: filterValue });
                }

                // Call functions
                updateProducts();
                updateFiltersList();
                updateActiveFilters();
            }
        });

        // Attach event listener to document for event delegation
        document.addEventListener('click', function(event) {
            // Check if the clicked element has the class '.events-filter-remove'
            if (event.target && event.target.classList.contains('product-filter-remove')) {
                event.preventDefault(); // Prevent default link behavior

                // Access data attributes
                var filterType = event.target.getAttribute('data-filter');
                var filterValue = event.target.getAttribute('data-value');

                selectedFilters = selectedFilters.filter(function(item) {
                    return item.filterType !== filterType || item.filterValue !== filterValue;
                });

                // Call functions
                updateProducts();
                updateFiltersList();
                updateActiveFilters();
            }
        });

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
