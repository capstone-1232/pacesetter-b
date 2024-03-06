<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pacesetter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				pacesetter_posted_on();
				pacesetter_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
	<?php global $EM_Event;
/* @var $EM_Event EM_Event */
if( empty($args['id']) ) $args['id'] = rand(100, getrandmax()); // prevent warnings
$id = esc_attr($args['id']);
?>
<div class="<?php em_template_classes('view-container'); ?>" id="em-view-<?php echo $id; ?>" data-view="event">
	<div class="<?php em_template_classes('event-single'); ?> em-event-<?php echo esc_attr($EM_Event->event_id); ?> <?php if( $EM_Event->active_status == 0 ) echo 'em-event-cancelled'; ?>" id="em-event-<?php echo $id; ?>" data-view-id="<?php echo $id; ?>">
		<?php
		echo $EM_Event->output_single();
		?>
	</div>
</div>
	
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php pacesetter_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
