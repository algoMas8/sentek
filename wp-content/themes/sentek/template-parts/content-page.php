<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sentek
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="container slider-container">

		<?php get_template_part('inc/image-slider');?>

	</div>

</div> <!-- close background image div created in header -->

	<div class="container page-container default-page-container">

		<div class="entry-content">
			<h1><?php the_title();?></h1>
			<?php the_content(); ?>
		</div><!-- .entry-content -->

	</div>



</article><!-- #post-<?php the_ID(); ?> -->
