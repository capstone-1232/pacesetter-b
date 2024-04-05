<?php
function enqueue_styles() {
  // Enqueue main stylesheet
  wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/src/sass/main.css', array(), null);

  // Enqueue animations stylesheet
  wp_enqueue_style('animations', get_stylesheet_directory_uri() . '/src/sass/animations.css', array(), null);

}
add_action('wp_enqueue_scripts', 'enqueue_styles');

function enqueue_custom_scripts() {
  // Enqueue jQuery with a specific version (you can adjust the version if needed)
  wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.4.min.js', array(), '3.6.4', true);

  // Enqueue your custom script with jQuery as a dependency
  wp_enqueue_script('events-form-submission-script', get_template_directory_uri() . '/js/events-modal.js', array('jquery'), null, true);

  // Enqueue your custom script with jQuery as a dependency
  wp_enqueue_script('back-to-top-script', get_template_directory_uri() . '/js/back-to-top.js', array('jquery'), null, true);

  // Pass data to the script
  wp_localize_script('events-form-submission-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}

// Hook the function to the wp_enqueue_scripts action
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

function enqueue_styles_scripts() {
  // Enqueue jQuery
  wp_enqueue_script('jquery');

  // Enqueue jQuery UI CSS
  wp_enqueue_style( 'jquery-ui-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css', array('jquery'), '1.13.2', true);

  // Enqueue jQuery UI
  wp_enqueue_script('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js', array('jquery'), '1.13.2', true);
  
  // Enqueue Javascript for styling,with jQuery
  wp_enqueue_script('styles-scripts', get_template_directory_uri() . '/js/styles-utils.js', array('jquery'), '1.0.0', true, true);
  
  // AJAX to dynamically select subcategory on button click
  wp_localize_script('styles-scripts', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'enqueue_styles_scripts');

?>