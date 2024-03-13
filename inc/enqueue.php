<?php
function enqueue_styles() {
  wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/css/style.css', array(), null);
}
add_action('wp_enqueue_scripts', 'enqueue_styles');

function enqueue_custom_scripts() {
  // Enqueue jQuery
  wp_enqueue_script('jquery');

  wp_enqueue_script('events-form-submission-script', get_template_directory_uri() . '/js/events-modal.js', array('jquery'), null, true);

  // Pass data to the script
  wp_localize_script('events-form-submission-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');