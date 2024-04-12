<?php
session_start();
/**
 * The template for displaying single events.
 *
 * @package pacesetter
 */
get_header();

// Retrieve information from custom fields.
$event_id = get_the_id();
$description = get_field('description');
$location = get_field('location');
$is_all_day = get_field('all_day');
$date_time_start = get_field('date_and_time_start');
$date_time_end = get_field('date_and_time_end');
$fee = get_field('fee');
$capacity = get_field('rsvp');
$event_image_url = get_field('event_image');

// Initialize Form error message
$full_name_message = '';
$phone_number_message = '';
$email_message = '';

// Check if the form submission identifier is not set
if (!isset($_SESSION['form_submission_identifier'])) {
    // Initialize an empty array to store event_ids
    $_SESSION['form_submission_identifier'] = array();
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    if (!in_array($event_id, $_SESSION['form_submission_identifier'])) {
        // Add event_id to identifier array
        $_SESSION['form_submission_identifier'][] = $event_id;

        // Process form data
        $full_name = sanitize_text_field($_POST['full_name']);
        $phone_number = sanitize_text_field($_POST['phone_number']);
        $email = sanitize_email($_POST['email']);
        $additional_attendees = sanitize_textarea_field($_POST['additional_attendees']);

        $form_good = true;

        // Validate Full Name
        if (empty($full_name)) {
            $form_good = false;
            $full_name_message = 'Please enter your full name.';
        }

        // Validate Phone Number
        if (empty($phone_number) || !preg_match('/^[0-9]{10}$/', $phone_number)) {
            $form_good = false;
            $phone_number_message = 'Please enter a valid 10-digit phone number.';
        }

        // Validate Email
        if (empty($email) || !is_email($email)) {
            $form_good = false;
            $email_message = 'Please enter a valid email address.';
        }

        if ($form_good) {
            // Calculate the remaining capacity after the new RSVP
            $remaining_capacity = max(0, $capacity - 1);
            echo $remaining_capacity;

            // Update the ACF field with the new remaining capacity
            update_field('rsvp', $remaining_capacity, $event_id);

            $subject = 'Form Submission';
            $message = 'This is the content of the email.';
            $headers = array('Content-Type: text/html; charset=UTF-8');

            $mailResult = wp_mail($email, $subject, $message, $headers);

            // Check if the email was sent successfully
            if ($mailResult) {
                echo "Email sent successfully.";
            } else {
                echo "Error: Unable to send email.";
            }

        } else {
            // Handle errors or display error messages to the user
            echo 'There are errors in your form. Please correct them and try again.';
        }
    }
}

// Format Start date
$date_start = DateTime::createFromFormat('m/d/Y h:i a', $date_time_start);
$formatted_date_start = $date_start->format('l, F d Y');

// Get Start time
$time_start = $date_start->format('h:i a');

// Get current time stamp
$current_timestamp = time();

// Get end date information if event has an end date
if ($date_time_end) {
    //Format End date
    $date_end = DateTime::createFromFormat('m/d/Y h:i a', $date_time_end);
    $formatted_date_end = $date_end->format('l, F d Y');

    // Get End time
    $time_end = $date_end->format('h:i a');

    // Convert end date to timestamp and calculate next day.
    $next_day = strtotime('tomorrow', strtotime($date_time_end));
} else {
    // Convert end date to timestamp and calculate next day if date and time end is empty.
    $next_day = strtotime('tomorrow', strtotime($date_time_start));

}

// Draft event and redirect user if event is past due.
if ($current_timestamp > $next_day) {
    $post_data = array(
        'ID' => $event_id,
        'post_status' => 'draft',
    );
    wp_update_post($post_data);
    wp_redirect(home_url('/'));
    exit;
}
?>

<main id="primary" class="site-main">
    <button type="button" class="rsvp-toggle">
        RSVP
    </button>
    <a href="<?php echo esc_url(home_url('/events')); ?>">
        << Back to Events</a>
            <article class="container event-details">
                <!-- Heading -->
                <div>
                    <h2>
                        <?php the_title(); ?>
                    </h2>
                    <p>
                        <?php echo ($fee == 0 || !$fee) ? "FREE" : "$" . $fee; ?>
                    </p>
                </div>
                <div>
                    <!-- Date & time of the event -->
                    <div>
                        <?php
                        echo ($formatted_date_start == $formatted_date_end) ? "<p>$formatted_date_start</p>" : "<p>$formatted_date_start to $formatted_date_end</p>";

                        echo ($date_time_end) ? "<p>$time_start to $time_end</p>" : "<p>$time_start</p>"
                            ?>
                    </div>
                    <!-- Event image -->
                    <img src="<?php echo esc_url($event_image_url ? $event_image_url : home_url() . "/wp-content/themes/pacesetter-b/img/placeholder.webp")?>" alt="Image of the event">
                    <!-- Event tags -->
                    <div>
                        <?php
                        $tags = get_the_tags();

                        if ($tags) {
                            echo '<ul>';
                            foreach ($tags as $tag) {
                                echo '<li>' . esc_html($tag->name) . '</li>';
                            }
                            echo '</ul>';
                        }
                        ?>
                    </div>
                    <!-- Event description -->
                    <div>
                        <p>
                            <?php echo $description ?>
                        </p>
                    </div>
                </div>
                <!-- RSVP -->
                <aside class="rsvp-panel">
                    <div class="container">
                        <!-- If SESSION form has not yet submitted -->
                        <button type="button unstyle" class="close">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <?php if (!in_array($event_id, $_SESSION['form_submission_identifier'])): ?>
                            <h2>Reserve your spot at this event!</h2>
                            <!-- RSVP capacity -->
                            <p>Spots left:
                                <?php echo $capacity ?>
                            </p>
                            <!-- RSVP Form -->
                            <form id="myForm" action="" method="POST">
                                <!-- Full Name -->
                                <div>
                                    <label for="full_name">Full Name *</label>
                                    <input type="text" id="full_name" name="full_name" required>
                                    <p>
                                        <?php echo $full_name_message ?>
                                    </p>
                                </div>

                                <!-- Phone Number -->
                                <div>
                                    <label for="phone_number">Phone Number *</label>
                                    <input type="tel" id="phone_number" name="phone_number" required>
                                    <p>
                                        <?php echo $phone_number_message ?>
                                    </p>
                                </div>


                                <!-- Email -->
                                <div>
                                    <label for="email">Email *</label>
                                    <input type="email" id="email" name="email" required>
                                    <p>
                                        <?php echo $email_message ?>
                                    </p>
                                </div>

                                <!-- Additional Attendees (optional) -->
                                <div>
                                    <label for="additional_attendees">Additional Attendees (optional):</label>
                                    <textarea id="additional_attendees" name="additional_attendees" rows="4"></textarea>
                                </div>

                                <!-- RSVP submit button -->
                                <button type="submit" name="submit">RSVP</button>
                            </form>
                            <!-- If SESSION form has been submitted -->
                        <?php else: ?>
                            <div class="submitted-form">
                                <h3>Thank you for RSVPing</h3>
                                <p>See you at the event!</p>
                            </div>
                        <?php endif; ?>
                        <div class="rsvp-share-event">
                            <div>
                                <p>Attending?</p>
                                <p>Share this event!</p>
                            </div>
                            <div>
                                <a href=""><svg fill="#000000" width="36px" height="36px" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M12 2.03998C6.5 2.03998 2 6.52998 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.84998C10.44 7.33998 11.93 5.95998 14.22 5.95998C15.31 5.95998 16.45 6.14998 16.45 6.14998V8.61998H15.19C13.95 8.61998 13.56 9.38998 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96C15.9164 21.5878 18.0622 20.3855 19.6099 18.57C21.1576 16.7546 22.0054 14.4456 22 12.06C22 6.52998 17.5 2.03998 12 2.03998Z">
                                            </path>
                                        </g>
                                    </svg></a>
                                <a href=""><svg fill="#000000" height="36px" width="36px" version="1.1" id="Layer_1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        viewBox="-143 145 512 512" xml:space="preserve">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g>
                                                <path
                                                    d="M113,446c24.8,0,45.1-20.2,45.1-45.1c0-9.8-3.2-18.9-8.5-26.3c-8.2-11.3-21.5-18.8-36.5-18.8s-28.3,7.4-36.5,18.8 c-5.3,7.4-8.5,16.5-8.5,26.3C68,425.8,88.2,446,113,446z">
                                                </path>
                                                <polygon
                                                    points="211.4,345.9 211.4,308.1 211.4,302.5 205.8,302.5 168,302.6 168.2,346 ">
                                                </polygon>
                                                <path
                                                    d="M183,401c0,38.6-31.4,70-70,70c-38.6,0-70-31.4-70-70c0-9.3,1.9-18.2,5.2-26.3H10v104.8C10,493,21,504,34.5,504h157 c13.5,0,24.5-11,24.5-24.5V374.7h-38.2C181.2,382.8,183,391.7,183,401z">
                                                </path>
                                                <path
                                                    d="M113,145c-141.4,0-256,114.6-256,256s114.6,256,256,256s256-114.6,256-256S254.4,145,113,145z M241,374.7v104.8 c0,27.3-22.2,49.5-49.5,49.5h-157C7.2,529-15,506.8-15,479.5V374.7v-52.3c0-27.3,22.2-49.5,49.5-49.5h157 c27.3,0,49.5,22.2,49.5,49.5V374.7z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg></a>
                                <a href=""><svg fill="#000000" height="36px" width="36px" version="1.1" id="Layer_1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        viewBox="-143 145 512 512" xml:space="preserve">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M113,145c-141.4,0-256,114.6-256,256s114.6,256,256,256s256-114.6,256-256S254.4,145,113,145z M215.2,361.2 c0.1,2.2,0.1,4.5,0.1,6.8c0,69.5-52.9,149.7-149.7,149.7c-29.7,0-57.4-8.7-80.6-23.6c4.1,0.5,8.3,0.7,12.6,0.7 c24.6,0,47.3-8.4,65.3-22.5c-23-0.4-42.5-15.6-49.1-36.5c3.2,0.6,6.5,0.9,9.9,0.9c4.8,0,9.5-0.6,13.9-1.9 C13.5,430-4.6,408.7-4.6,383.2v-0.6c7.1,3.9,15.2,6.3,23.8,6.6c-14.1-9.4-23.4-25.6-23.4-43.8c0-9.6,2.6-18.7,7.1-26.5 c26,31.9,64.7,52.8,108.4,55c-0.9-3.8-1.4-7.8-1.4-12c0-29,23.6-52.6,52.6-52.6c15.1,0,28.8,6.4,38.4,16.6 c12-2.4,23.2-6.7,33.4-12.8c-3.9,12.3-12.3,22.6-23.1,29.1c10.6-1.3,20.8-4.1,30.2-8.3C234.4,344.5,225.5,353.7,215.2,361.2z">
                                            </path>
                                        </g>
                                    </svg></a>
                            </div>
                        </div>
                    </div>
                </aside>
            </article>
            <!-- Related Events -->
            <section class="related-events">
                <div class="container">
                    <div class="rectangle-graphic"></div>
                    <h2>Related Events</h2>
                    <?php
                    global $post;

                    if (!empty($tags)) {
                        // Get tags from current post
                        $current_post_tags = wp_get_post_tags($event_id, array('fields' => 'ids'));

                        // Create query args
                        $args = array(
                            'post_type' => 'events',
                            'posts_per_page' => 3,
                            'tax_query' => array(
                                'relation' => 'OR',
                                array(
                                    'taxonomy' => 'post_tag',
                                    'field' => 'id',
                                    'terms' => $current_post_tags,
                                    'operator' => 'IN',
                                ),
                            ),
                            'post__not_in' => array($event_id),
                            'post_status' => 'publish',
                        );

                        // Query for related events
                        $related_events_query = new WP_Query($args);
                        echo "<div class=\"related-events__wrapper\">";
                        if ($related_events_query->have_posts()) {
                            while ($related_events_query->have_posts()) {
                                $related_events_query->the_post();

                                // Access data for related events
                                $related_event_title = get_the_title();
                                $related_post_url = get_permalink(get_the_ID());
                                $related_post_img = get_field('event_image');
                                $related_date_time_start = get_field('date_and_time_start');
                                $related_date_start = DateTime::createFromFormat('m/d/Y h:i a', $date_time_start);
                                $related_formatted_date_start = $date_start->format('l, F d Y');

                        // Your code for each related event goes here
                        ?>
                        <div class="">
                        
                            <a href="<?php echo $related_post_url ?>">
                                <img src="<?php echo esc_url($related_post_img ? $related_post_img : home_url() . "/wp-content/themes/pacesetter-b/img/placeholder.webp"); ?>" alt="">
                            </a>
                            <h3><?php echo $related_event_title ;?></h3>
                            <p><?php echo $related_formatted_date_start;?></p>
                        </div>
                        <?php
                    }

                            // Restore global post data
                            wp_reset_postdata();
                        } else {
                            // No related events found
                            echo 'No related events found.';
                        }
                    } else {
                        // No tags found for the event
                        echo 'No related events found.';
                    }
                    ?>
                </div>
            </section>
            <!-- Modal for when RSVP'd -->
            <div id="eventModal"
                class="event-modal <?php echo (!in_array($event_id, $_SESSION['form_submission_identifier'])) ? "hidden" : "" ?>">
                <div class="event-modal-content">
                    <!-- Close button edit as needed position absolute top right -->
                    <span class="event-modal-close"><svg width="42px" height="42px" viewBox="0 -0.5 21 21" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <title>close [#1511]</title>
                                <desc>Created with Sketch.</desc>
                                <defs> </defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Dribbble-Light-Preview" transform="translate(-419.000000, -240.000000)"
                                        fill="#000000">
                                        <g id="icons" transform="translate(56.000000, 160.000000)">
                                            <polygon id="close-[#1511]"
                                                points="375.0183 90 384 98.554 382.48065 100 373.5 91.446 364.5183 100 363 98.554 371.98065 90 363 81.446 364.5183 80 373.5 88.554 382.48065 80 384 81.446">
                                            </polygon>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg></span>
                    <div class="text-content">
                        <p>You have successfully RSVPd to:</p>
                        <div class="arrow-background">
                            <p>
                                <?php echo the_title(); ?>
                            </p>
                        </div>
                        <p>You will receive an email containing more details about your reservation!</p>
                        <p>We are looking forward to seeing you in October 2, 2023, at 7:00 pm!</p>
                        <p>See you on the slopes!</p>
                    </div>
                    <div>
                        <a href="">Back to Events</a>
                        <a href="">Back to Home</a>
                    </div>
                </div>
            </div>
</main><!-- #main -->
<?php
get_footer();
