<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pacesetter
 */

get_header();
?>
<main>
    <section class="contact-section">
        <h2>Contact us</h2>
        <p>Give us a call, fill out our contact form, or come in person if you have any questions.
            We’re happy to help and have our expert staff available during hours of operation. </p>
        <?php $args = array(
            'post_type' => 'business',
            'post_status' => 'publish'
        );
        $loop = new WP_Query($args);
        while ($loop->have_posts()) {
            $loop->the_post();
            ?>
            <div>
                <h3>Phone</h3>
                <p>
                    <?php echo esc_html(get_field('phone_number')); ?>
                </p>
            </div>
            <div>
                <h3>Hours of Operation</h3>
                <p>Mon-Fri:
                    <?php echo esc_html(get_field('hours_mon-fri')) ?>
                </p>
                <p>Sat:
                    <?php echo esc_html(get_field('hours_sat')) ?>
                </p>
                <p>Sun:
                    <?php echo esc_html(get_field('hours_sun')) ?>
                </p>

            </div>
            <?php
        }
        ?>
        <div>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d151740.59956275974!2d-113.8983764132812!3d53.54086290000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x53a02103230e0325%3A0xdb9361d3d0c6e002!2sPacesetter%20Ski%20Shoppe!5e0!3m2!1sen!2sca!4v1708037539783!5m2!1sen!2sca"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
    <section class="email-section">
        <h2>Send us an email!</h2>
        <form action="$_POST">
            <div>
                <div>
                    <label for="name">name:</label>
                    <input type="text" name="name" id="name">
                </div>
                <div>
                    <label for="email">email:</label>
                    <input type="email" name="email" id="email">
                </div>
                <div>
                    <label for="message">What you want to say:</label>
                    <textarea name="message" id="message"></textarea>
                </div>
                <input type="submit" value="Send">
            </div>
        </form>
        <?php echo do_shortcode('[forminator_form id="139"]'); ?>
    </section>
    <section>
        <h2>FAQs</h2>
        <p>Check out our FAQ page to find common questions</p>
        <a href="<? echo get_template_directory_uri() ?>/page-faq.php">FAQ </a>
    </section>
</main>
<?php
get_footer()
    ?>