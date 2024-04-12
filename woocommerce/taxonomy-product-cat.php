<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     4.7.0
 */

get_template_part('template-parts/woocommerce-header');

global $post
?>

<div id="primary" class="content-area taxonomy-product">
	<main id="main" class="site-main" role="main">
		<?php
		// Get the current category object
		$category = get_queried_object();

		// Check if the queried object is a category
		if (is_a($category, 'WP_Term')) {
			// Get category ID
			$category_id = $category->term_id;

			// Get category name
			$category_name = $category->name;

			$category_slug = $category->slug;

			// Get category description
			$category_description = $category->description;


			$banner_image = get_field('category_banner', $category);

			// Check if Category has children
			$child_categories_ids = get_term_children($category_id, 'product_cat');
		}

		// Get the ACF banner-image field value for the current category
		$banner_image = get_field('category_banner', 'product_cat_' . $category_id);

		$category_description = term_description($category_id, 'product_cat');

		// Get the category title
		$category_title = $category->name;

		$child_categories = get_terms(
			array(
				'taxonomy' => 'product_cat',
				'parent' => $category_id,
			)
		);
		if (!$child_categories && !is_wp_error($child_categories)) {
			?>
			<div class="page-banner" style="">
				<div>
					<h1>
						<?php echo esc_html($category_title); ?>
					</h1>
					<?php echo $category_description ?>
				</div>
				<img class="banner-background-image" src="<?php echo esc_url($banner_image); ?>" alt="">
			</div>
		<?php } else {
			get_template_part('template-parts/category-banner');
		}
		echo "<div class=\"container\">";
		get_template_part('template-parts/breadcrumbs');
		echo "</div>";

		if ($child_categories && !is_wp_error($child_categories)) {
			echo "<div class=\"category-links\">";
			foreach ($child_categories as $child_category) {
				$child_category_slug = $child_category->slug;
				$child_category_name = $child_category->name;
				$thumbnail_id = get_term_meta($child_category->term_id, 'thumbnail_id', true);
				if ($thumbnail_id) {
					$thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'thumbnail');
				}
				?>
				<a href="<?php echo esc_url(get_term_link($child_category)) ?>" class="category-link">
					<div style="background-image: url('<?php echo esc_url($thumbnail_url[0]) ?>');">
						<h2>
							<?php echo $child_category_name ?>
						</h2>
					</div>
				</a>
				<?php
			}
			echo "</div>";
		} else { ?>
			<div class="grid-container container">
				<div class="show-filters">
					<p>Filters</p>
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
						stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
					</svg>
				</div>
				<div id="filters" class="product-filters">
					<div>
						<p>Filters</p>
						<button type="button"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
								stroke-width="1.5" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
							</svg>
						</button>
					</div>

					<?php
					$filters = [
						"length" => [
							"150-155" => "150-155cm",
							"156-160" => "156-160cm",
							"161-165" => "161-165cm",
							"166-170" => "166-170cm",
							"171-175" => "171-175cm",
							"176-180" => "176-180cm",
							"181-185" => "181-185cm",
							"186-190" => "186-190cm",
							"191-195" => "191-195cm",
							"196-999" => "196cm+",
						],
						"brand" => [
							"dynastar" => "Dynastar",
							"armada" => "Armada",
							"black-crows" => "Black Crows",
							"blizzard" => "Blizzard",
							"k2" => "K2",
							"smith" => "Smith",
							"rossignol" => "Rossignol",
							"salomon" => "Salomon",
							"fischer" => "Fischer",
							"stockli" => "Stöckli",
							"volkl" => "Völkl",
							"capita" => "Capita",
						],
						"price_range" => [
							"0-200" => "Under $200",
							"200-400" => "$200 - $400",
							"400-600" => "$400 - $600",
							"600-800" => "$600 - $800",
							"800-1000" => "$800 - $1000",
							"1000-99999" => "$1000 & above",
						]
					];


					foreach ($filters as $filter_name => $options) {
						$filter_display_name = ucwords(str_replace('_', ' ', $filter_name));
						echo "<div class=\"accordion $filter_name\">";
						echo "<h3>$filter_display_name <svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"m19.5 8.25-7.5 7.5-7.5-7.5\" /></svg></h3>";
						echo "<div>";
						foreach ($options as $value => $label) {
							echo "<div>";
							echo "<input type='radio' name='$filter_name' value='$value' id='$value'>";
							echo "<label for='$value'>$label</label>";
							echo "</div>";
						}
						echo "</div>";
						echo "</div>";
					}
					?>

					<button type="button">Show Results</button>
				</div>
				<div id="removeFilterList" class="removeFilterList"></div>
				<div class="sort-by">
					<select name="sort_by" id="sort_by">
						<option value="default">Sort by</option>
						<option value="price_low_to_high">Price: Low to High</option>
						<option value="price_high_to_low">Price: High to Low</option>
						<option value="newest">Newest Arrivals</option>
						<option value="oldest">Oldest Arrivals</option>
					</select>
				</div>
			</div>
			<div id="products" class="container grid-container">
			</div>
		<?php }
		?>
	</main>
</div>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		let offset = 12;
		let currentSlug = "<?php echo $category_slug ?>";
		let sortBy = '';

		// Array to store selected filters
		let selectedFilters = [];

		// Get all radio buttons
		const filters = document.querySelectorAll('input[type="radio"]');

		filters.forEach(filter => {
			filter.addEventListener('change', function () {
				const label = this.nextElementSibling.textContent;
				const filterType = this.getAttribute('name');
				const filterValue = this.value;

				// Check if a filter with the same name exists in the selectedFilters array
				const existingFilterIndex = selectedFilters.findIndex(filter => filter.filterType === filterType);

				// If the filter already exists, update its value
				if (existingFilterIndex !== -1) {
					selectedFilters[existingFilterIndex].filterValue = filterValue;
				} else { // Otherwise, add the new filter
					selectedFilters.push({ filterType: filterType, filterValue: filterValue });
				}
				updateProducts();
				updateFiltersList();
			});
		});

		function updateProducts() {
			var xhr = new XMLHttpRequest();
			var filtersJSON = JSON.stringify(selectedFilters);

			xhr.onreadystatechange = function () {
				if (xhr.readyState === 4) {
					if (xhr.status === 200) {
						document.getElementById('products').innerHTML = xhr.responseText;
					} else {
						console.error('Error:', xhr.status, xhr.statusText);
					}
				}
			};
			xhr.open('POST', ajax_object.ajax_url, true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
			xhr.send('action=fetch_products&offset=' + offset + '&sort_by=' + sortBy + '&current_slug=' + currentSlug + '&filters=' + encodeURIComponent(filtersJSON));
		}
		updateProducts();

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
			xhr.send('action=remove_product_filter_list_function&filters=' + encodeURIComponent(filtersJSON));
		}

		// Sort by change function
		function handleSortChange() {
			sortBy = document.getElementById("sort_by").value;
			updateProducts(); // Call updateProducts() whenever sortBy changes
		}

		// filter selected function
		function handleSortChange() {
			sortBy = document.getElementById("sort_by").value;
			updateProducts(); // Call updateProducts() whenever sortBy changes
		}

		// Event handler for filter buttons (using event delegation)
		document.addEventListener('click', function (event) {
			if (event.target && event.target.classList.contains('products-filter')) {
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
				updateProducts();
				updateFiltersList();
				updateActiveFilters();
			}
		});

		// Attach event listener to document for event delegation
		document.addEventListener('click', function (event) {
			if (event.target && event.target.classList.contains('products-filter-remove')) {
				event.preventDefault(); // Prevent default link behavior

				// Access data attributes
				var filterType = event.target.getAttribute('data-filter');
				var filterValue = event.target.getAttribute('data-value');

				selectedFilters = selectedFilters.filter(function (item) {
					return item.filterType !== filterType || item.filterValue !== filterValue;
				});

				// Deselect the radio button of its kind
				var activeFilter = document.querySelectorAll('input[type="radio"][name="' + filterType + '"]');
				activeFilter.forEach(function (radioButton) {
					if (radioButton.value === filterValue) {
						radioButton.checked = false;
					}
				});

				// Call functions
				updateProducts();
				updateFiltersList();
				updateActiveFilters();
			}
		});

		// Event handler for filter buttons (using event delegation)
		document.addEventListener('click', function (event) {
			if (event.target && event.target.classList.contains('view-more-btn')) {
				event.preventDefault();

				// Increment offset
				offset = offset + 12;

				// Call functions
				updateProducts()
			}
		});

		document.getElementById("sort_by").addEventListener("change", handleSortChange);
	});
</script>
<?php get_footer(); ?>