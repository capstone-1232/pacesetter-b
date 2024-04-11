<?php
/*
Template Name: Customer Reviews template part
Template Post Type: customer-reviews
*/
?>

<section class="review-section">
  <h2>Customer Reviews</h2>
  <h2>Customer Reviews</h2>
  <div id="review-carousel" class="review_slider">
    <div class="carousel-inner">

      <?php
      $review_query = new WP_Query(
        array(
          'post_type' => 'customer-reviews',
          'posts_per_page' => -1,
        )
      );

      if ($review_query->have_posts()):
        $index = 0;
        while ($review_query->have_posts()):
          $review_query->the_post();
          $active_class = ($index === 0) ? 'active' : '';

          // Retrieve meta values
          $customer_name = get_post_meta(get_the_ID(), 'customer_name', true);
          $feedback = get_post_meta(get_the_ID(), 'feedback', true);

          // Output the carousel item
          ?>
          <div class="review_slide <?php echo $active_class; ?>">
            <div class="review_slide-content">
              <p class="feedback">
              <p class="feedback">
                <?php echo $feedback ?>
              </p>
              <p class="customer-name">-
              <p class="customer-name">-
                <?php echo $customer_name ?>
              </p>
            </div>
          </div>

          <?php
          $index++;
        endwhile;

        // Check the number of posts before outputting navigation buttons
        if ($review_query->post_count > 1):
          ?>
          <button class="review_btn review_btn-next">
            <svg fill="#000000" height="800px" width="800px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                viewBox="0 0 491.1 491.1" xml:space="preserve">
              <g>
                <path d="M379.25,282.85l-192.8,192.8c-20.6,20.6-54,20.6-74.6,0s-20.6-54,0-74.6l155.5-155.5l-155.5-155.5
                  c-20.6-20.6-20.6-54,0-74.6s54-20.6,74.6,0l192.8,192.8C399.85,228.85,399.85,262.25,379.25,282.85z"/>
              </g>
            </svg>
          </button>
          <button class="review_btn review_btn-next">
            <svg fill="#000000" height="800px" width="800px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                viewBox="0 0 491.1 491.1" xml:space="preserve">
              <g>
                <path d="M379.25,282.85l-192.8,192.8c-20.6,20.6-54,20.6-74.6,0s-20.6-54,0-74.6l155.5-155.5l-155.5-155.5
                  c-20.6-20.6-20.6-54,0-74.6s54-20.6,74.6,0l192.8,192.8C399.85,228.85,399.85,262.25,379.25,282.85z"/>
              </g>
            </svg>
          </button>
          <button class="review_btn review_btn-prev">
            <svg class="svg-flip" fill="#000000" height="800px" width="800px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
              viewBox="0 0 491.1 491.1" xml:space="preserve">
              <g>
                <path d="M379.25,282.85l-192.8,192.8c-20.6,20.6-54,20.6-74.6,0s-20.6-54,0-74.6l155.5-155.5l-155.5-155.5
                  c-20.6-20.6-20.6-54,0-74.6s54-20.6,74.6,0l192.8,192.8C399.85,228.85,399.85,262.25,379.25,282.85z"/>
              </g>
            </svg>
          </button>
            <svg class="svg-flip" fill="#000000" height="800px" width="800px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
              viewBox="0 0 491.1 491.1" xml:space="preserve">
              <g>
                <path d="M379.25,282.85l-192.8,192.8c-20.6,20.6-54,20.6-74.6,0s-20.6-54,0-74.6l155.5-155.5l-155.5-155.5
                  c-20.6-20.6-20.6-54,0-74.6s54-20.6,74.6,0l192.8,192.8C399.85,228.85,399.85,262.25,379.25,282.85z"/>
              </g>
            </svg>
          </button>
            <?php endif;

        wp_reset_postdata();
      endif;
      ?>

    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // select next review_slide button
    const nextReviewSlide = document.querySelector(".review_btn-next");

    // select prev review_slide button
    const prevReviewSlide = document.querySelector(".review_btn-prev");

    // current review_slide counter
    let currentReviewSlide = 0;
    // maximum number of review_slides
    let maxReviewSlide = document.querySelectorAll('.review_slide').length - 1;
    // select all review_slides
    const reviewSlides = document.querySelectorAll('.review_slide');

    // add event listener and navigation functionality for next button
    nextReviewSlide.addEventListener("click", function () {
        changeReviewSlide(currentReviewSlide + 1);
    });

    // add event listener and navigation functionality for prev button
    prevReviewSlide.addEventListener("click", function () {
        changeReviewSlide(currentReviewSlide - 1);
    });

    // Automatic review_slide change every 15 seconds
    setInterval(function () {
        changeReviewSlide(currentReviewSlide + 1);
    }, 5000);
    changeReviewSlide(currentReviewSlide + 1);

    // Function to change the review_slide
    function changeReviewSlide(newReviewSlide) {
        // Ensure the new review_slide is within bounds
        if (newReviewSlide < 0) {
            newReviewSlide = maxReviewSlide;
        } else if (newReviewSlide > maxReviewSlide) {
            newReviewSlide = 0;
        }

        // Move review_slides
        currentReviewSlide = newReviewSlide;
        reviewSlides.forEach((reviewSlide, index) => {
            reviewSlide.style.transform = `translateX(${100 * (index - currentReviewSlide)}%)`;
        });
    }
});
</script>
