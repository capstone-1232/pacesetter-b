<?php
/** 
 * @package pacesetter
 * 
 *
 * 
 * */
get_header()
    ?>


<h1> Pacesetter Blog</h1>

<p>Welcome to the Pacesetter Blog</p>


<?php
if (have_posts()):
    while (have_posts()):
        the_post();
        //this is the content being looped
        ?>
        <!-- close php and start html-->
        <article class="flex">
            <img src="<?php echo esc_html(get_field('blog_image'))?>" alt="">
            <div>

                <h3>
                    <?php the_title(); ?>
                </h3>
                <p>
                    <?php the_date() ?>
                </p>
                <p>
                    <?php the_excerpt(); ?>
                </p>
            </div>
        </article>
        <?php
    endwhile;
endif;
?>