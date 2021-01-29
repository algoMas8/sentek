<?php
/**
 * Template Name: Products Category Landing
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sentek
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :

      the_post();

			get_template_part( 'template-parts/content', 'product-categories-landing' );

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php

get_footer();
