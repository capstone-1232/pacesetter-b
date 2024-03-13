<?php
/**
 * The template for displaying all events
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pacesetter
 */

get_header();

$filters = [
    "skill_level" => [
        "beginner" => "Beginner",
        "intermediate" => "Intermediate",
        "advanced" => "Advanced",
    ],
    "location" => [
        "edmonton" => "Edmonton",
        "calgary" => "Calgary",
        "banff" => "Banff",
        "jasper" => "Jasper",
        "waterton_national_park" => "Waterton National Park",
        "whistler" => "Whistler"
    ],
    "time_range" => [
        "all_day" => "All day",
        "morning" => "Morning",
        "daytime" => "Daytime",
        "evening" => "Evening",
        "night" => "Night",
    ],
];

// State filters to check $_GET
$known_filters = ["skill_level", "location", "time_range", "price_range"];
$active_filters = [];

foreach ($_GET as $filter => $values) {
    // Check $_GET if filters are present
    if (in_array($filter, $known_filters)) {
        if (!is_array($values)) {
            $values = [$values];
        }
        $active_filters[$filter] = array_map("htmlspecialchars", $values);
    }
}
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <section>
            <div>
                <h3>Filters</h3>
                <div>
                    <?php
                    // Generate the filter buttons
                    foreach ($filters as $filter => $options) {
                        // Replace underscores or dashes with spaces and capitalize the words for the heading
                        $heading = ucwords(str_replace(["_", "-"], " ", $filter));
                        // Add a heading before each button group
                        echo "<h4 class=\"fw-light w-100 text-sm-center text-lg-start\">" .
                            htmlspecialchars($heading) .
                            "</h4>";

                        echo '<div class="btn-group mb-3" role="group" aria-label="' .
                            htmlspecialchars($filter) .
                            ' Filter Group">';
                        foreach ($options as $value => $label) {
                            $is_active = in_array(
                                $value,
                                $active_filters[$filter] ?? []
                            );
                            $updated_filters = $active_filters;

                            if ($is_active) {
                                $updated_filters[$filter] = array_diff(
                                    $updated_filters[$filter],
                                    [$value]
                                );
                                if (empty($updated_filters[$filter])) {
                                    unset($updated_filters[$filter]);
                                }
                            } else {
                                $updated_filters[$filter][] = $value;
                            }

                            // Output button link
                            echo '<a href="#" class="events-filter btn ' .
                                ($is_active ? "btn-info" : "btn-outline-info") .
                                '" data-filter="' . htmlspecialchars($filter) . '" data-value="' . htmlspecialchars($value) . '">' .
                                htmlspecialchars($label) .
                                "</a>";
                        }
                        echo "</div>";
                    } ?>
                </div>
            </div>
            <div id="removeFilterList"></div>
            <div id="filteredContent">
                <?php
                $args = array(
                    'post_type'      => 'events-posts',
                    'post_status'    => 'publish',
                    'meta_key'       => 'date_and_time_start',
                    'orderby'        => 'meta_value',
                    'order'          => 'ASC',
                );

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
                ?>
            </div>
        </section>
    </main>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Event handlers for filter buttons
    var filters = document.querySelectorAll('.events-filter');

    // Array to store selected filters
    var selectedFilters = [];

    // Add event handler for buttons
    filters.forEach(function (filter) {
        filter.addEventListener('click', function (event) {
            event.preventDefault();

            // Get data-filter value
            var filterType = filter.dataset.filter;

            // Get data-value value
            var filterValue = filter.dataset.value;

            // Check if the filter type is already present in the array
            var existingFilterIndex = selectedFilters.findIndex(function (item) {
                return item.filterType === filterType;
            });

            // If present, replace the value; otherwise, add a new entry
            if (existingFilterIndex !== -1) {
                selectedFilters[existingFilterIndex].filterValue = filterValue;
            } else {
                selectedFilters.push({ filterType: filterType, filterValue: filterValue });
            }

            // Call functions
            updateEventsList();
            updateFiltersList();
        });
    });

    // Function to update events list with selected filters
    function updateEventsList() {
        var xhr = new XMLHttpRequest();
        var filtersJSON = JSON.stringify(selectedFilters);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    document.getElementById('filteredContent').innerHTML = xhr.responseText;
                } else {
                    console.error('Error:', xhr.status, xhr.statusText);
                }
            }
        };

        xhr.open('POST', ajax_object.ajax_url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.send('action=event_filter_function&filters=' + encodeURIComponent(filtersJSON));
    }

    // Attach event listener to document for event delegation
    document.addEventListener('click', function(event) {
        // Check if the clicked element has the class '.events-filter-remove'
        if (event.target && event.target.classList.contains('events-filter-remove')) {
            event.preventDefault(); // Prevent default link behavior

            // Access data attributes
            var filterType = event.target.getAttribute('data-filter');
            var filterValue = event.target.getAttribute('data-value');

            selectedFilters = selectedFilters.filter(function(item) {
                return item.filterType !== filterType || item.filterValue !== filterValue;
            });

            // Call functions
            updateEventsList();
            updateFiltersList();
        }
    });

    // Function to update filter list with selected filters
    function updateFiltersList() {
        var xhr = new XMLHttpRequest();
        var filtersJSON = JSON.stringify(selectedFilters);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    document.getElementById('removeFilterList').innerHTML = xhr.responseText;
                } else {
                    console.error('Error:', xhr.status, xhr.statusText);
                }
            }
        };

        xhr.open('POST', ajax_object.ajax_url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.send('action=remove_filter_list_function&filters=' + encodeURIComponent(filtersJSON));
    }
});

</script>
<?php get_footer(); ?>
