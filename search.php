<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package pacesetter
 */

get_header();

$search_query = get_search_query();
?>

	<main id="primary" class="site-main">
		<div>
			<h1>Showing Results for: <?php echo $search_query ?></h1>
		</div>
		<div>
			<p>Show only:</p>
			<label class="radio-label">
				<input type="radio" name="post_type" value="product">
				Products
			</label>

			<label class="radio-label">
				<input type="radio" name="post_type" value="events-posts">
				Events
			</label>

			<label class="radio-label">
				<input type="radio" name="post_type" value="post">
				Blogs
			</label>

			<label class="radio-label">
				<input type="radio" name="post_type" value="other">
				Other
			</label>
		</div>


		<div id="searchResults">
			
    <?php if ( have_posts() ) : ?>
        <!-- Display search results -->
        <?php while ( have_posts() ) : the_post(); ?>
		<?php
			get_template_part('template-parts/search-content', 'search');?>
        <?php endwhile; ?>
    <?php else : ?>
        <!-- Display message if no search results found -->
        <p>No results found for this search.</p>
    <?php endif; ?>
</div>

	</main><!-- #main -->
	<script>
	document.addEventListener('DOMContentLoaded', function () {

		// Get all radio buttons with name "post_type"
		const radioButtons = document.querySelectorAll('input[name="post_type"]');
		let searchQuery = "<?php echo esc_js($search_query); ?>";

		// Add event listener to each radio button
		radioButtons.forEach(function(radioButton) {
			radioButton.addEventListener('change', function() {
				filterSearchResults();
			});
		});

		function filterSearchResults() {
			// Retrieve the value of the selected radio button
			var postType = document.querySelector('input[name="post_type"]:checked').value;
			
			// Call updateProducts() with the selected postType
			updateProducts(postType);
		}

		// Example updateProducts() function
		function updateProducts(postType) {
			console.log(postType);
			updateSearchResults(postType);
		}

		function updateSearchResults(postType) {
			 var xhr = new XMLHttpRequest();
			 
			 xhr.onreadystatechange = function () {
				 if (xhr.readyState === 4) {
					 if (xhr.status === 200) {
						 document.getElementById('searchResults').innerHTML = xhr.responseText;
					 } else {
						 console.error('Error:', xhr.status, xhr.statusText);
					 }
				 }
			 };
			 xhr.open('POST', ajax_object.ajax_url, true);
			 xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
			 xhr.send('action=fetch_search_results&post_type=' + postType + '&search_query=' + searchQuery);
		 }
	})
	</script>
<?php

get_footer();
