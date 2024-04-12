<?php
/** 
 * @package pacesetter
 */
get_header();
?>

<main class="blog-container">
    <section>
        <div class="intro" style="background-image: url('<?php echo esc_url(get_template_directory_uri() . '/img/snow-background-texture.webp'); ?>');">
            <div class="intro-container">
                <h2> Pacesetter Blog <span class="offset-underline"></span></h2>
                <p>Welcome to the blog! From gear reviews and expert tips, to destination spotlights and community stories, our blog is your go-to resource for all things powder. View all our blogs from the most recent, or filter by the blog type category.</p>
                
                <!-- Filter buttons -->
                <div id="filter-buttons" class="intro-buttons">
                    <button class="filter-button" data-category="all">All Blogs</button>
                    <?php
                    // Retrieve unique categories
                    $categories = get_categories(array(
                        'hide_empty' => true,
                    ));
                    foreach ($categories as $category) {
                        echo '<button class="filter-button" data-category="' . $category->slug . '">' . $category->name . '</button>';
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <?php
        if (have_posts()):
            while (have_posts()):
                the_post();
                // Get post categories
                $post_categories = get_the_category();
                ?>
                <!-- close php and start html-->
                <article class="blog-post">
                    <img src="<?php echo esc_html(get_field('blog_image')); ?>" alt="">
                    <div>
                        <h3><?php the_title(); ?></h3>
                        <p><?php the_date(); ?></p>
                        <p><?php echo substr(get_field('blog_entry'),0,150) ?> ...</p>
                        
                            <!-- Filter button for each post -->
                            <div class="post-filter-buttons">
                                <a href="<?php the_permalink(); ?>"class="read-more-button">Read More</a>
                                <?php foreach ($post_categories as $post_category) : ?>
                                    <button class="filter-button" data-category="<?php echo $post_category->slug; ?>"><?php echo $post_category->name; ?></button>
                                <?php endforeach; ?>
                            </div>
                        
                    </div>
                </article>
                <?php
            endwhile;
        endif;
        ?>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-button');
        const blogPosts = document.querySelectorAll('.blog-post');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                blogPosts.forEach(post => {
                    if (category === 'all' || post.querySelector('.post-filter-buttons').querySelector('[data-category="' + category + '"]')) {
                        post.style.display = 'flex';
                    } else {
                        post.style.display = 'none';
                    }
                });
            });
        });
    });
</script>

<?php get_footer(); ?>
