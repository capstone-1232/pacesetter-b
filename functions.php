<?php
/**
 * pacesetter functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package pacesetter
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function pacesetter_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on pacesetter, use a find and replace
		* to change 'pacesetter' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'pacesetter', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'pacesetter' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'pacesetter_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'pacesetter_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pacesetter_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'pacesetter_content_width', 640 );
}
add_action( 'after_setup_theme', 'pacesetter_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function pacesetter_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'pacesetter' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'pacesetter' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'pacesetter_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function pacesetter_scripts() {
	wp_enqueue_style( 'pacesetter-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'pacesetter-style', 'rtl', 'replace' );

	wp_enqueue_script( 'pacesetter-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pacesetter_scripts' );
function new_excerpt_more($more) {
    global $post;
    error_log('Debug: new_excerpt_more function called.'); // Debugging line
    error_log('Post ID: ' . $post->ID); // Debugging line
    return '<a class="moretag" href="'. get_permalink($post->ID) . '"> Read More</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');
function pacesetter_search_where($where){
	global $wpdb;
	if (is_search())
	  $where .= "OR (t.name LIKE '%".get_search_query()."%' AND {$wpdb->posts}.post_status = 'publish')";
	return $where;
  }
  
								function pacesetter_search_join($join){
									global $wpdb;
									if (is_search())
									$join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
									return $join;
								}
								
								function pacesetter_search_groupby($groupby){
									global $wpdb;
								
									// we need to group on post ID
									$groupby_id = "{$wpdb->posts}.ID";
									if(!is_search() || strpos($groupby, $groupby_id) !== false) return $groupby;
								
									// groupby was empty, use ours
									if(!strlen(trim($groupby))) return $groupby_id;
								
									// wasn't empty, append ours
									return $groupby.", ".$groupby_id;
								}
								
								add_filter('posts_where','pacesetter_search_where');
								add_filter('posts_join', 'pacesetter_search_join');
								add_filter('posts_groupby', 'pacesetter_search_groupby');

								function pacesetter_add_woocommerce_support() {
									add_theme_support( 'woocommerce' );
								}
								add_action( 'after_setup_theme', 'pacesetter_add_woocommerce_support' );

								function remove_editor_support() {
									remove_post_type_support('post', 'editor'); }
									 add_action('init', 'remove_editor_support');
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * cleanup unnecesarry additions.
 */
require get_template_directory() . '/inc/cleanup.php';

/**
 * Enqueue additions.
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Enqueue filters.
 */
require get_template_directory() . '/inc/filter.php';

/**
 * Enqueue breadcrumbs.
 */
require get_template_directory() . '/inc/breadcrumbs.php';

/**
 * Enqueue ratings.
 */
require get_template_directory() . '/inc/rating.php';

/**
 * Enqueue reviews.
 */
require get_template_directory() . '/inc/more-review.php';
/**
 * Enqueue readmore
 */
require get_template_directory() . '/inc/read_more.php';
/**
 * Enqueue products.
 */
require get_template_directory() . '/inc/products.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


