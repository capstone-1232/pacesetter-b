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

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <section>
            <div>
                <h3>Filters</h3>
                <div id="filters"></div>
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
    document.addEventListener('click', function(event) {
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
            updateActiveFilters();
        }
    });

});

</script>
<?php get_footer(); ?>
