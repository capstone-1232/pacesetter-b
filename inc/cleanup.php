<?php
/**
 * Remove generator version number
 * @package pacesetter
 */

/* Remove version string from js and css */
function pacesetter_remove_wp_version_strings( $src ) {
    global $wp_version;
    parse_str(parse_url($src, PHP_URL_QUERY), $query);
    if (!empty($query['ver']) && $query['ver'] ===  $wp_version) {
        $src = remove_query_arg( 'ver', $src);
    }
    return $src;
}

add_filter('script_loader_src', 'pacesetter_remove_wp_version_strings' );
add_filter('style_loader_src', 'pacesetter_remove_wp_version_strings' );

/* Remove metatag generator from header */
function pacesetter_remove_meta_version() {
    return '';
}
add_filter('the_generator', 'pacesetter_remove_meta_version');

function mailtrap($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = 'e3b0a56338aa12';
    $phpmailer->Password = '12d1a7dd594396';
  }
  
  add_action('phpmailer_init', 'mailtrap');

  function my_filter_function() {
    $filterType = isset($_POST['filterType']) ? $_POST['filterType'] : '';
    $filterValue = isset($_POST['filterValue']) ? $_POST['filterValue'] : '';

    // Process filters and fetch content based on $filterType and $filterValue

    // For example, assuming you have a filter.php file in your theme folder
    ob_start();
    include get_stylesheet_directory() . '/includes/filter.php';
    $filteredContent = ob_get_clean();

    echo json_encode($filteredContent);
    exit;
}

add_action('wp_ajax_my_filter_function', 'my_filter_function');
add_action('wp_ajax_nopriv_my_filter_function', 'my_filter_function');