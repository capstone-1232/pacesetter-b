<?php
add_action('wp_ajax_subcategory', 'get_subcategory');
add_action('wp_ajax_nopriv_subcategory', 'get_subcategory');

function get_subcategory()
{
    $categoryName = isset ($_POST['category']) ? $_POST['category'] : '';
    $categoryDetails = get_term_by('name', strval($categoryName), 'product_cat');
    $categoryId = $categoryDetails->term_id;
    
    $subcategories = get_terms(
        array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'parent' => $categoryId,
        )
    );

    $subcategories_list = '<ul>';
    foreach ($subcategories as $subcategory) {
        $subcategories_list.='<li><a href="' . get_term_link($subcategory) . '">' . $subcategory->name . '</a></li>';
    };
    $subcategories_list .= '</ul>';

    echo $subcategories_list;
    
    wp_die();
}
