<?php
function enqueue_styles() {

  wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/src/sass/main.css', array(), null);
}
add_action('wp_enqueue_scripts', 'enqueue_styles');

function enqueue_styles_scripts() {
  // Enqueue Javascript for styling
  wp_enqueue_script('styles-scripts', get_template_directory_uri() . '/js/styles-utils.js', array('jquery'), '1.0.0', true, true);
}

add_action('wp_enqueue_scripts', 'enqueue_styles_scripts');

function enqueue_custom_scripts() {
  // Enqueue jQuery with a specific version (you can adjust the version if needed)
  wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.4.min.js', array(), '3.6.4', true);

  // Enqueue your custom script with jQuery as a dependency
  wp_enqueue_script('events-form-submission-script', get_template_directory_uri() . '/js/events-modal.js', array('jquery'), null, true);

  // Enqueue scripts for page styling

  // Pass data to the script
  wp_localize_script('events-form-submission-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}

// Hook the function to the wp_enqueue_scripts action
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
