<?php
/**
 * Template Name: Contact
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sentek
 */

get_header();
?>

<main id="primary" class="site-main">


    <div class="container main-contact-band">

        <div class="row">

            <div class="col-12">

                <?php

          while ( have_posts() ) :

									the_post(); ?>

                <h1><?php the_title();?></h1>

                <?php get_template_part('inc/contact-map');?>

                <br /><br />

            </div>
        </div>



        <div class="row">

            <div class="col-md-6">


                <?php the_content(); ?>

                <!--<div id="contact-image"><?php the_post_thumbnail( 'full' ); ?></div>-->

            </div>

            <div class="col-md-3">

                <?php the_field('center_content');?>

            </div>

            <div class="col-md-3">

                <?php the_field('right_hand_content');?>

            </div>

        </div>

    </div>

    <?php endwhile; // End of the loop. ?>

    </div> <!-- close background image div created in header -->


    <div class="footer-top">

        <div class="container">

            <div class="col-md-8 offset-md-2">

                <h2>Contact Sentek</h2>

                <?php echo do_shortcode('[gravityform id="3" title="false" description="true" ajax="true"]');?>

            </div>

        </div>


    </div>




</main><!-- #main -->

<?php

get_footer();
