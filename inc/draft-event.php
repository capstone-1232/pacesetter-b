<?php
function check_and_draft_past_due_events() {
    $args = array(
        'post_type'      => 'events', // Replace 'event' with your actual post type
        'posts_per_page' => -1,       // Retrieve all posts
        'post_status'    => 'publish', // Only published events
    );
    $events = new WP_Query($args);
    
    // Loop through each event
    if ($events->have_posts()) {
        while ($events->have_posts()) {
            $events->the_post();
            
            // Get event details
            $event_id = get_the_ID();
            $date_time_start = get_field('date_and_time_start');
            $date_time_end = get_field('date_and_time_end');
    
            // Check if event has an end date
            if ($date_time_end) {
                $next_day = strtotime('tomorrow', strtotime($date_time_end));
            } else {
                $next_day = strtotime('tomorrow', strtotime($date_time_start));
            }
    
            // Get current timestamp
            $current_timestamp = time();
    
            // Draft event and redirect user if event is past due
            if ($current_timestamp > $next_day) {
                $post_data = array(
                    'ID'           => $event_id,
                    'post_status'  => 'draft',
                );
                wp_update_post($post_data);
            }
        }
        wp_reset_postdata(); // Restore global post data
    }
}

// Schedule the event checking function to run hourly
add_action('init', 'schedule_event_checking');

function schedule_event_checking() {
    if (!wp_next_scheduled('check_and_draft_past_due_events')) {
        wp_schedule_event(time(), 'every_30_minutes', 'check_and_draft_past_due_events');
    }
}

function custom_cron_intervals($schedules) {
    // Add custom interval for every 30 minutes
    $schedules['every_30_minutes'] = array(
        'interval' => 1800, // 30 minutes in seconds
        'display'  => __('Every 30 Minutes')
    );
    return $schedules;
}
add_filter('cron_schedules', 'custom_cron_intervals');