<?php
/** 
 * @package pacesetter
 */
get_header();
?>

<main>

    <h2> Pacesetter Blog</h2>
    
    <p>Welcome to the Pacesetter Blog</p>

    <!-- Filter buttons -->
    <div id="filter-buttons">
        <button class="filter-button" data-category="all">All</button>
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

    <?php
    if (have_posts()):
        while (have_posts()):
            the_post();
            // Get post categories
            $post_categories = get_the_category();
            ?>
            <!-- close php and start html-->
            <article class="flex blog-post">
                <img src="<?php echo esc_html(get_field('blog_image')); ?>" alt="">
                <div>
                    <h3><?php the_title(); ?></h3>
                    <p><?php the_date(); ?></p>
                    <div>
                        <p><?php get_the_excerpt('read more'); ?></p>
                        <!-- Filter button for each post -->
                        <div class="post-filter-buttons">
                            <?php foreach ($post_categories as $post_category) : ?>
                                <button class="filter-button" data-category="<?php echo $post_category->slug; ?>"><?php echo $post_category->name; ?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </article>
            <?php
        endwhile;
    endif;
    ?>

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
