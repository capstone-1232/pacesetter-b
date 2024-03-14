<?php
// Events filter function
function event_filter_function() {
    if (isset($_POST['filters'])) {
        $filters = json_decode(stripslashes($_POST['filters']), true);

        $tax_queries = array();

        // Build tax queries based on selected filters
        foreach ($filters as $filter) {
            if (!empty($filter['filterType'])) {
                switch ($filter['filterType']) {
                    case 'time_range':
                        $tax_queries[] = array(
                            'key'     => 'tags_time_range',
                            'value'   => $filter['filterValue'],
                            'compare' => '=',
                        );
                        break;
                    case 'skill_level':
                        $tax_queries[] = array(
                            'key'     => 'tags_skill_level',
                            'value'   => $filter['filterValue'],
                            'compare' => '=',
                        );
                        break;
                    case 'location_tag':
                        $tax_queries[] = array(
                            'key'     => 'tags_location_tag',
                            'value'   => $filter['filterValue'],
                            'compare' => '=',
                        );
                        break;
                    // Add more cases for other filter types if needed
                }
            }
        }

        // Initialize your $args array here
        $args = array(
            'post_type'      => 'events-posts',
            'post_status'    => 'publish',
            'meta_key'       => 'date_and_time_start',
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
        );

        // Add tax_queries to $args if it's not empty
        if (!empty($tax_queries)) {
            $args['tax_query'] = array(
                'relation' => 'AND', // Use 'AND' for events that must have all selected tags
                $tax_queries, // Include the dynamically generated tax queries
            );
        }

        // Query for related events
        $events_query = new WP_Query($args);
        echo "<div class=\"related-events__wrapper\">";
        if ($events_query->have_posts()) {
            while ($events_query->have_posts()) {
                $events_query->the_post();

                // Access data for all events
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

                // Convert date to Morning/ Afternoon/ Evening
                $timestamp = strtotime($date_time_start);
                $hour = date('G', $timestamp);
                // Determine the time of day
                if ($hour >= 5 && $hour < 12) {
                    $time_of_day = 'Morning';
                } elseif ($hour >= 12) {
                    $time_of_day = 'Evening';
                } elseif (!$date_time_end) {
                    $time_of_day = 'All day';
                }

                ?>
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
            }

            // Restore global post data
            wp_reset_postdata();
        } else {
            // No related events found
            echo 'No related events found.';
        }
        exit;
    } else {
        // Handle other cases or provide a default response
        echo json_encode(['error' => 'Invalid request']);
        exit;
    }
}

add_action('wp_ajax_event_filter_function', 'event_filter_function');
add_action('wp_ajax_nopriv_event_filter_function', 'event_filter_function');

function remove_filter_list_function() {
    if (isset($_POST['filters'])) {
        $filters = json_decode(stripslashes($_POST['filters']), true);

        // Build tax queries based on selected filters
        foreach ($filters as $filter) {
            if (!empty($filter['filterType']) && !empty($filter['filterValue'])) :?>
            <a href="#" class="events-filter-remove" data-filter="<?php echo $filter['filterType'];?>" data-value="<?php echo $filter['filterValue'];?>"><?php echo ucfirst($filter['filterValue']); ?> X</a>
        <?php
        endif;
    }
        exit;
    } else {
        // Handle other cases or provide a default response
        echo json_encode(['error' => 'Invalid request']);
        exit;
    }
}

add_action('wp_ajax_remove_filter_list_function', 'remove_filter_list_function');
add_action('wp_ajax_nopriv_remove_filter_list_function', 'remove_filter_list_function');
?>
