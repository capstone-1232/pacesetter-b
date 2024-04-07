<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <div class="entry-content">
        <?php
        // Check post type
        $post_type = get_post_type();
        if ($post_type == 'post') {
			global $post;

			$title = get_the_title();
			$entry = get_field('blog_entry');
			$blog_img = get_field('blog_image');
			$blog_img_url = wp_get_attachment_image_src($blog_img, 'full');
			$short_entry = substr($entry, 0, 250);
			?>
			<img src="<?php echo $blog_img_url[0]?>">
			<div>
            <h3><?php echo $title?></h3>
			<p><?php echo $short_entry?>...</p>
			</div>
			<?php
        } if ($post_type == 'events-posts') {
			global $post;

			$event_title = get_the_title();
            $description = get_field('description');
            $fee = get_field('fee');
            $capacity = get_field('rsvp');
            $post_url = get_permalink(get_the_ID());
            $post_img = get_field('event_image');
            $date_time_start = get_field('date_and_time_start');
            $date_time_end = get_field('date_and_time_end');
            $date_start = DateTime::createFromFormat('m/d/Y h:i a', $date_time_start);
            $formatted_date_start = $date_start->format('l, F d Y');
            $tags = get_field('tags');
            $skill_level_label = $tags['skill_level']['label'];
            $location_tag_label = $tags['location_tag']['label'];
            $time_range_label = $tags['time_range']['label'];
			?>
			<img src="">
			<div class="">
                    <img src="<?php echo $post_img; ?>" alt="">
                    <h3><?php echo $event_title; ?></h3>
                    <div>
                        <p><?php echo $formatted_date_start ?></p>
                        <p><?php echo $time_of_day; ?></p>
                    </div>
                    <?php
                    $tags = get_the_tags();
                        echo '<ul>';
                            echo '<li class="event-tag">'.$skill_level_label.'</li>';
                            echo '<li class="event-tag">'.$location_tag_label.'</li>';
                            echo '<li class="event-tag">'.$time_range_label.'</li>';
                        echo '</ul>';
                    ?>
                    <div>
                        <p><?php echo substr($description, 0, 250); ?>...</p>
                    </div>
                    <p><?php echo ($fee == 0 || !$fee) ? "FREE" : "$" . $fee; ?></p>
                    <p><?php echo $capacity ?></p>
                    <a href="<?php echo $post_url ?>">View Event
                    </a>
                </div>
			<?php
        } elseif ($post_type == 'page') { ?>
            <div>
                <?php
                // Output the featured image if it exists
                if (has_post_thumbnail()) {
                    echo '<div class="featured-image">';
                    the_post_thumbnail();
                    echo '</div>';
                }
                // Output the page title
                echo '<h2>' . get_the_title() . '</h2>';
                ?>
            </div>
            <?php
        } elseif ($post_type == 'product') {
			global $product;
            // Get WooCommerce product information
            $product_title = $product->get_name();
            $product_description = $product->get_short_description();
            $product_price = $product->get_price_html();
            $in_stock = $product->is_in_stock() ? 'In Stock <svg fill="#000000" width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>checkmark</title> <path d="M16 3c-7.18 0-13 5.82-13 13s5.82 13 13 13 13-5.82 13-13-5.82-13-13-13zM23.258 12.307l-9.486 9.485c-0.238 0.237-0.623 0.237-0.861 0l-0.191-0.191-0.001 0.001-5.219-5.256c-0.238-0.238-0.238-0.624 0-0.862l1.294-1.293c0.238-0.238 0.624-0.238 0.862 0l3.689 3.716 7.756-7.756c0.238-0.238 0.624-0.238 0.862 0l1.294 1.294c0.239 0.237 0.239 0.623 0.001 0.862z"></path> </g></svg>' : 'Out of Stock <svg fill="#000000" width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>cancel</title> <path d="M16 29c-7.18 0-13-5.82-13-13s5.82-13 13-13 13 5.82 13 13-5.82 13-13 13zM21.961 12.209c0.244-0.244 0.244-0.641 0-0.885l-1.328-1.327c-0.244-0.244-0.641-0.244-0.885 0l-3.761 3.761-3.761-3.761c-0.244-0.244-0.641-0.244-0.885 0l-1.328 1.327c-0.244 0.244-0.244 0.641 0 0.885l3.762 3.762-3.762 3.76c-0.244 0.244-0.244 0.641 0 0.885l1.328 1.328c0.244 0.244 0.641 0.244 0.885 0l3.761-3.762 3.761 3.762c0.244 0.244 0.641 0.244 0.885 0l1.328-1.328c0.244-0.244 0.244-0.641 0-0.885l-3.762-3.76 3.762-3.762z"></path> </g></svg>';
            $product_image_url = get_the_post_thumbnail_url($product->get_id(), 'full');

			echo '<img src="' . esc_url($product_image_url) . '" alt="' . esc_attr($product_title) . '">';
			echo '<div>';
            echo '<h3>' . $product_title . '</h3>';
            echo '<p>'. $in_stock . '</p>';
            echo '<p>C' . $product_price . '</p>';
			echo '<p>' . $product_description . '</p>';
			echo '</div>';
        }
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
