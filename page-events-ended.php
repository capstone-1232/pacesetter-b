<?php
/**
 * Template Name: Event Ended Redirect
 *
 * This is the template that redirects users if the event has ended.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pacesetter
 */

// Redirect to the events page after 10 seconds
header("Refresh: 5; URL=" . esc_url(home_url('/events')));

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h1 class="entry-title">Bummer! The Ride's Over!</h1>
    </header>

    <div class="entry-content">
        <p>Whoops, looks like we've reached the end of the line on this gnarly event! Don't worry, we're just getting warmed up. Hang tight while we shred some fresh powder, and we'll whisk you away to the events page before you can say "powder day!"</p>
    </div>
</article>

    </main>
</div>

<?php
get_footer();
?>