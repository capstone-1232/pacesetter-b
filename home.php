<?php
/** 
 * @package pacesetter
 * 
 * 
 * 
 * */
get_header()
    ?>


<h2> Pacesetter Blog</h2>

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
                <div>
                <p>
                    <?php the_excerpt(); ?>
                </p>

                    <p><?php echo esc_html(get_field('categories')) ?></p>
                </div>
            </div>
        </article>
        <?php
    endwhile;
endif;?>

<?php $args=array(
                'post_type' => 'posts',
                'post_status'=>'publish'
            );
            $loop=new WP_Query($args);
            while ($loop->have_posts()){
                $loop-> the_post();
                ?>
                <div>
                <div>
                    <h3><?php echo the_title();?></h3>
                    <p><?php echo the_date();?></p>
                    <p><?php the_excerpt();?></p>
                    <p><?php echo esc_html(get_field('categories'))?></p>
            
                </div>



<?php }?>