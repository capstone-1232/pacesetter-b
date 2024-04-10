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

	<main id="primary" class="site-main blog-display">

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
                <div class="image-container">
                    <img src="<?php echo esc_html(get_field('blog_image'));?>" alt="">
                    
                    <div class="byline">
                        
                            <p>Posted by:<?php echo esc_html(get_field('blog_author'));?></p>
                            <p>Posted on: <?php the_date();?></p>
                       
                    </div>
                </div>
                <p><?php echo esc_html(get_field('blog_entry')); ?></p>
			</article>
			<?php
 
            
 
        // End the loop.
        endwhile;
        ?>

        </main><!-- .site-main -->
    </div><!-- .content-area -->
	<section class="related">
        <h3>Related Blogs</h3>
        <div class="card-container">

            <div class="outer-wrapper">
                <div class="inner-wrapper">
    
        <?php
    
    $related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => 5, 'post__not_in' => array($post->ID) ) );
    if( $related ) foreach( $related as $post ) {
    setup_postdata($post); ?>
     <div class="blog-card">
         <img src="<?php echo esc_html(get_field('blog_image'))?>" alt="">
         <h4><?php the_title()?></h4>
         <p><?php echo substr(get_field('blog_entry'),0,100) ?> ...</p>
         <div>
             <a  class="read-more-button" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">Read More</a>
         </div>
        
     </div>
    <?php }
    wp_reset_postdata(); ?>
                </div> <!--end of inner wrapper-->
            </div> <!-- end of outer wrapper -->           
        </div>
	</section>
 
<?php get_footer(); ?>