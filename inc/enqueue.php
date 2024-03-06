<?php
function enqueue_styles() {
  wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/css/style.css', array(), null);
}
add_action('wp_enqueue_scripts', 'enqueue_styles');