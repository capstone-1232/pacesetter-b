<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package pacesetter
 */

get_header();
?>

	<main id="primary" class="site-main">

	<div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
 
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();
 
            /*
             * Include the post format-specific template for the content. If you want to
             * use this in a child theme, then include a file called called content-___.php
             * (where ___ is the post format) and that will be used instead.
             */
            get_template_part( 'content', get_post_format() );?>
			<article>
				<h2><?php echo the_title(); ?></h2>
                <img src="<?php echo esc_html(get_field('blog_image'))?>" alt="">
				<p><?php echo get_the_author_meta('display_name');?></p>
			</article>
			<p><?php echo the_content() ?></p>
			<?php
 
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
			endif;
 
        // End the loop.
        endwhile;
        ?>

        </main><!-- .site-main -->
    </div><!-- .content-area -->
	<div>
	<?php

$related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => 5, 'post__not_in' => array($post->ID) ) );
if( $related ) foreach( $related as $post ) {
setup_postdata($post); ?>
 <ul> 
        <li>
        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
        <img src="<?php echo esc_html(get_field('blog_image'))?>" alt="">
            <?php the_excerpt('read more'); ?>
        </li>
    </ul>   
<?php }
wp_reset_postdata(); ?>
	</div>
 
<?php get_footer(); ?>