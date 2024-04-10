<?php
/**
 * The template for displaying all events
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pacesetter
 */

get_header();

?>

<div id="primary" class="content-area events">
    <main id="main" class="site-main container" role="main">
        <section class="banner">
            <h2>Events <span class="offset-underline"></span></h2>
            <p>All our events are free!</p>
        </section>
        <section>
            <div>
                <h3 class="sr-only">Filters</h3>
                <div class="event-menu">
                    <div class="filter-toggle">
                        <p>Filters</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>
                    </div>
                </div>
                <div id="filters" class="event-filters">
                    <div class="loader"></div>
                </div>
                <div class="sort">
                </div>
            </div>
            <div id="removeFilterList"></div>
            <div id="filteredContent"></div>
        </section>
    </main>
</div>
<script>

    document.addEventListener('DOMContentLoaded', function () {

        // Array to store selected filters
        var selectedFilters = [];

        function updateActiveFilters() {
            var xhr = new XMLHttpRequest();
            var filtersJSON = JSON.stringify(selectedFilters);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        document.getElementById('filters').innerHTML = xhr.responseText;
                    } else {
                        console.error('Error:', xhr.status, xhr.statusText);
                    }
                }
            };
            xhr.open('POST', ajax_object.ajax_url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            xhr.send('action=update_active_list_function&filters=' + encodeURIComponent(filtersJSON));
        }
        updateActiveFilters()

        // Event handler for filter buttons (using event delegation)
        document.addEventListener('click', function (event) {
            // Check if the clicked element has the class '.events-filter'
            if (event.target && event.target.classList.contains('events-filter')) {
                event.preventDefault(); // Prevent default link behavior

                // Get data attributes
                var filterType = event.target.dataset.filter;
                var filterValue = event.target.dataset.value;

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
                updateActiveFilters();
            }
        });
        updateEventsList();

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

        // Attach event listener to document for event delegation
        document.addEventListener('click', function (event) {
            // Check if the clicked element has the class '.events-filter-remove'
            if (event.target && event.target.classList.contains('events-filter-remove')) {
                event.preventDefault(); // Prevent default link behavior

                // Access data attributes
                var filterType = event.target.getAttribute('data-filter');
                var filterValue = event.target.getAttribute('data-value');

                selectedFilters = selectedFilters.filter(function (item) {
                    return item.filterType !== filterType || item.filterValue !== filterValue;
                });

                // Call functions
                updateEventsList();
                updateFiltersList();
                updateActiveFilters();
            }
        });

    });

</script>
<?php get_footer(); ?>