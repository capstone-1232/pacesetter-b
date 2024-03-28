<?php
/*
Template Name: Hero Banner Template
Template Post Type: hero-banner
*/
?>

<section id="hero-carousel" class="slider">
  <div class="carousel-inner">

    <?php
    $hero_banner_query = new WP_Query(array(
      'post_type' => 'hero-banner',
      'posts_per_page' => -1,
    ));

    if ($hero_banner_query->have_posts()) :
      $index = 0;
      while ($hero_banner_query->have_posts()) : $hero_banner_query->the_post();
        $active_class = ($index === 0) ? 'active' : '';

        // Retrieve field values
        $title = get_field('subheading');
        $tag_line = get_field('tag_line');
        $call_to_action = get_field( 'call_to_action');
        $call_to_action_url = get_field( 'call_to_action_url');
        $call_to_action_2 = get_field( 'call_to_action_2');
        $call_to_action_url_2 = get_field( 'call_to_action_url_2');
        $background_image = get_field('background_image');
        

        // Output the carousel item
        ?>
        <div class="slide <?php echo $active_class; ?>" style="background-image: url('<?php echo esc_url($background_image); ?>');">
          <div class="slide-content">
            <h2><?php echo $title; ?></h2>
            <p><?php echo $tag_line; ?></p>
            <a href="<?php echo esc_url($call_to_action_url); ?>"><?php echo esc_html($call_to_action); ?></a>
            <?php if ($call_to_action_2):?>
              <a href="<?php echo esc_url($call_to_action_url_2); ?>"><?php echo esc_html($call_to_action_2); ?></a>
              <?php endif;?>
          </div>
        </div>

        <?php
        $index++;
      endwhile;

      // Check the number of posts before outputting navigation buttons
      if ($hero_banner_query->post_count > 1) :
      ?>
        <button class="btn btn-next">></button>
        <button class="btn btn-prev"><</button>

        <!-- Navigation dots -->
        <div class="carousel-dots">
          <?php for ($i = 0; $i < $hero_banner_query->post_count; $i++) : ?>
            <div class="dot"></div>
          <?php endfor; ?>
        </div>
      <?php endif;

      wp_reset_postdata();
    endif;
    ?>

  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // select next slide button
    const nextSlide = document.querySelector(".btn-next");

    // select prev slide button
    const prevSlide = document.querySelector(".btn-prev");

     // Create an array to store dot elements
    const dots = document.querySelectorAll('.dot');

    // Add click event listeners to each dot
    dots.forEach((dot, index) => {
      dot.addEventListener('click', function () {
        changeSlide(index);
      });
    });

    // current slide counter
    let curSlide = 0;
    // maximum number of slides
    let maxSlide = document.querySelectorAll('.slide').length - 1;
    // select all slides
    const slides = document.querySelectorAll('.slide');

    // add event listener and navigation functionality for next button
    nextSlide.addEventListener("click", function () {
      changeSlide(curSlide + 1);
    });

    // add event listener and navigation functionality for prev button
    prevSlide.addEventListener("click", function () {
      changeSlide(curSlide - 1);
    });

    // Automatic slide change every 15 seconds
    setInterval(function () {
      changeSlide(curSlide + 1);
    }, 5000);

    // Function to change the slide
    function changeSlide(newSlide) {
    // Ensure the new slide is within bounds
    if (newSlide < 0) {
      newSlide = maxSlide;
    } else if (newSlide > maxSlide) {
      newSlide = 0;
    }

    // Move slides
    curSlide = newSlide;
    slides.forEach((slide, indx) => {
      slide.style.transform = `translateX(${100 * (indx - curSlide)}%)`;
    });

    // Update active dot
    dots.forEach((dot, index) => {
      if (index === curSlide) {
        dot.classList.add('active');
      } else {
        dot.classList.remove('active');
      }
    });
  }
});
</script>

<style>
.slider {
  width: 100%;
  height: 400px;
  position: relative;
  overflow: hidden;
}

.slide {
  width: 100%;
  height: 400px;
  position: absolute;
  transition: all 0.5s;
}

.slide img {
  width: 100%;
  max-height: 400px;
  object-fit: cover;
}

.btn {
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

.btn:active {
  transform: scale(1.1);
}

.btn-prev {
  top: 45%;
  left: 2%;
}

.btn-next {
  top: 45%;
  right: 2%;
}

.carousel-dots {
  position: absolute;
  bottom: 10px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 8px;
}

.dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background-color: #ccc;
  cursor: pointer;
  transition: .5s ease;
}

.dot:hover,
.dot:focus-within {
  transform: translateY(-2px);
}

.dot.active {
  background-color: #555; /* Change color for active dot */
}
</style>
