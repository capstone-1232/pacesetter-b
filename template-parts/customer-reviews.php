<?php
/*
Template Name: Customer Reviews template part
Template Post Type: customer-reviews
*/
?>

<section class="review-section">
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
              <p>
                <?php echo $feedback ?>
              </p>
              <p>-
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
          <button class="review_btn review_btn-next">></button>
          <button class="review_btn review_btn-prev">
            << /button>
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
    const nextreview_slide = document.querySelector(".review_btn-next");

    // select prev review_slide button
    const prevreview_slide = document.querySelector(".review_btn-prev");

    // current review_slide counter
    let curreview_slide = 0;
    // maximum number of review_slides
    let maxreview_slide = document.querySelectorAll('.review_slide').length - 1;
    // select all review_slides
    const review_slides = document.querySelectorAll('.review_slide');

    // add event listener and navigation functionality for next button
    nextreview_slide.addEventListener("click", function () {
      changeReviewSlide(curreview_slide + 1);
    });

    // add event listener and navigation functionality for prev button
    prevreview_slide.addEventListener("click", function () {
      changeReviewSlide(curreview_slide - 1);
    });

    // Automatic review_slide change every 15 seconds
    setInterval(function () {
      changeReviewSlide(curreview_slide + 1);
    }, 5000);

    // Function to change the review_slide
    function changeReviewSlide(newreview_slide) {
      // Ensure the new review_slide is within bounds
      if (newreview_slide < 0) {
        newreview_slide = maxreview_slide;
      } else if (newreview_slide > maxreview_slide) {
        newreview_slide = 0;
      }

      // Move review_slides
      curreview_slide = newreview_slide;
      review_slides.forEach((review_slide, indx) => {
        review_slide.style.transform = `translateX(${100 * (indx - curreview_slide)}%)`;
      });
    }
  });
</script>

<style>
  .review_slider {
    width: 100%;
    height: 350px;
    position: relative;
    overflow: hidden;
  }

  .review_slide {
    width: 100%;
    height: 350px;
    position: absolute;
    transition: all 0.5s;
  }

  .review_slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .review_btn {
    position: absolute;
    width: 40px;
    height: 40px;
    padding: 10px;
    border: none;
    border-radius: 50%;
    z-index: 10;
    cursor: pointer;
    background-color: #013652;
    color: #fff;
    font-size: 18px;
  }

  .review_btn:active {
    transform: scale(1.1);
  }

  .review_btn-prev {
    top: 45%;
    left: 2%;
  }

  .review_btn-next {
    top: 45%;
    right: 2%;
  }
</style>