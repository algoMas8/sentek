<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package sentek
 */

get_header();
?>

	<main id="primary" class="site-main">

		<div class="container slider-container single-case-study-container">

			<h1>Case Studies</h1>

			<?php while ( have_posts() ) :

					the_post();

		 			the_title('<h2 class="case-study-title">', '</h2>'); ?>

					<!-- top section displays slider or hero image based on user selection-->
					<?php if(get_field('top_hero_area') == 'image slider') {

				  			get_template_part('inc/image-slider');

		  					}

	  		 				else if(get_field('top_hero_area') == 'single hero image') { ?>


					 			<div class="hero-image" style="background-image: url(<?php the_field('hero_image'); ?>);"></div>


				 		<?php } ?>

			</div>

</div> <!-- close background image div created in header -->

			<div class="container">

				 <div class="single-case-study-content">

				 	<?php the_content(); ?>

				</div>

		 		<?php endwhile; // End of the loop. ?>


		</div>



	</main><!-- #main -->

<?php

get_footer();
