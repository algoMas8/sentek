<?php
/**
 * Template part for displaying page content in page-products-landing.php
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

	<div class="container page-container">

		<div class="row">

        <div class="col-sm-6 left-products-landing">

          <h1><?php the_title();?></h1>
    			<?php the_content(); ?>

        </div>

        <div class="col-sm-6 right-products-landing">

					<?php the_field('beginners_guide');?>

					<br />

					<a class="sentek-button" href="<?php echo get_home_url();?>/beginners-guide">Learn More</a>

        </div>


      </div>

		</div>

	</div> <!-- close background image div created in header -->

	<div class="container page-container">

		<div class="row home-products-row products-landing-row">

			<?php //spit out children of 'products' and display in grid

					$args = array(
							'post_type'      => 'page',
							'posts_per_page' => 4,
							'post_parent'    => '20175',
							'order'          => 'ASC',
							'orderby'        => 'menu_order'
					 );


					$childrens = new WP_Query( $args );

					if ( $childrens->have_posts() ) : ?>

							<?php while ( $childrens->have_posts() ) :

									$childrens->the_post();

									$backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>

									<div class="col-md-3" id="child-<?php the_ID(); ?>">

										<div class="home-product-wrapper">

											<a href="<?php the_permalink(); ?>"><div class="feat-img-wrapper" style="background: url('<?php echo $backgroundImg[0]; ?>') no-repeat; "></div></a>

											<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

											<!-- get ID of current item in loop -->
											<?php $currentPostID = get_the_ID(); ?>

											<?php $args2 = array(
													'post_type'      => 'page',
													'post_parent'    => $currentPostID,
													'order'          => 'ASC',
													'orderby'        => 'menu_order'
											 );

											 	$grandChildrens = new WP_Query( $args2 ); //get children of each post in current context

												if ( $grandChildrens->have_posts() ) : ?>

														<?php while ( $grandChildrens->have_posts() ) :

																$grandChildrens->the_post(); ?>

																<div class="product-info">

																	<p><?php the_title(); ?><i class="fa fa-chevron-down show-hide-product-details"></i></p>

																	<div class="product-excerpt">

																		<br />

																		<?php the_excerpt();?>

																		<br />

																		<a class="sentek-button" href="<?php echo the_permalink();?>">View Product</a>

																	</div>

																</div>

													<?php endwhile;

											endif; ?>

										</div>

									</div>

							<?php endwhile;

					endif;

					wp_reset_query(); ?>

				</div>

				<div class="bottom-products-band">

					<div class="row">

						<div class="col-md-6">

							<?php the_field('bottom_left');?>

							<br />

							<a class="sentek-button" href="#">Learn More</a>

						</div>

						<div class="col-md-6">

							<?php the_field('bottom_right');?>

							<br />

							<a class="sentek-button" href="#">Learn More</a>

						</div>

					</div>

				</div>



	</div>

</article><!-- #post-<?php the_ID(); ?> -->

<?php get_template_part('inc/footer-top');?>
