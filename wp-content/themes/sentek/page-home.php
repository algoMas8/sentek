<?php
/**
 * Template Name: Home
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sentek
 */

get_header();
?>

	<main id="primary" class="site-main">

    <div class="container">

      <?php get_template_part('inc/image-slider');?>

    </div>

    <div class="container main-home-band">

      <div class="row">

        <div class="col-md-6">

          <?php

          while ( have_posts() ) :

									the_post(); ?>

              		<h1><?php the_title();?></h1>

              		<?php the_content(); ?>

        </div>

        <?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>

        <div class="col-md-6">

          <div class="home-right-img" style="background: url('<?php echo $backgroundImg[0]; ?>') no-repeat; "></div>

        </div>

      </div>

    </div>

  <?php endwhile; // End of the loop. ?>

	<div class="second-home-band-wrapper">

			<div class="container second-home-band">

				<div class="row">

					<div class="col-12">
						<h2>Markets</h2>
						<?php the_field('markets_description');?>

					</div>

				</div>

				<br />

				<div class="row">

				<?php //spit out children of 'markets' and display in grid

						$args = array(
						    'post_type'      => 'page',
						    'posts_per_page' => 4,
						    'post_parent'    => '20094',
						    'order'          => 'ASC',
						    'orderby'        => 'menu_order'
						 );


						$childrens = new WP_Query( $args );

						if ( $childrens->have_posts() ) : ?>

						    <?php while ( $childrens->have_posts() ) :

										$childrens->the_post();

										$backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>

						        <div class="col-md-3" id="child-<?php the_ID(); ?>">

											<div class="home-market-wrapper">

												<a href="<?php the_permalink(); ?>"><div class="feat-img-wrapper" style="background: url('<?php echo $backgroundImg[0]; ?>') no-repeat; "></div></a>

												<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

											</div>

						        </div>

						    <?php endwhile;

						endif;

						wp_reset_query(); ?>

					</div>

			</div>

		</div>

		<div class="strengths-wrapper">

			<div class="container third-home-band">

				<div class="row">

					<div class="col-12">
						<h2>Our Strengths</h2>
					</div>

				</div>

				<br />

				<div class="row">

					<?php if( have_rows('our_strengths') ):

    						while( have_rows('our_strengths') ) :

									the_row();

        					$icon = get_sub_field('icon');
									$title = get_sub_field('title');
									$description = get_sub_field('description'); ?>

									<div class="col-md-4">

										<div class="icon-wrapper">

											<img src="<?php echo $icon;?>" class="mx-auto d-block img-fluid" />

										</div>

										<div class="strengths-description-wrapper">
											<h4><?php echo $title;?></h4>
											<p><?php echo $description;?></p>
										</div>

									</div>



								<?php

								endwhile;

							endif; ?>

						</div>

					</div>

				</div>

				<div class="leaders-wrapper">

					<div class="container fourth-home-band">

						<div class="row">

							<div class="col-md-6">
								<h4>Leaders in their Field</h4>
								<p>We are proud to work with progressive organisations globally</p>
							</div>

							<div class="col-md-6">
								<h4>Latest News</h4>

								<?php
							     // Define our WP Query Parameters
							     $query_options = array(
							         'posts_per_page' => 1,
							     );
							     $the_query = new WP_Query( $query_options );

							     while ($the_query -> have_posts()) :

										 $the_query -> the_post(); ?>

									 			<a href="<?php echo the_permalink();?>"><h5><?php the_title();?></h5></a>
												<?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
												<a href="<?php echo the_permalink();?>"><div class="feat-img-container" style="background: url('<?php echo $backgroundImg[0]; ?>') no-repeat; "></div></a>
												<p><?php the_date();?></p>
									 			<?php the_excerpt();?>

										<?php endwhile;

										wp_reset_query(); ?>

							</div>

						</div>

					</div>

				</div>

				<div class="bottom-wrapper">

					<div class="container">

						<div class="row">

							<div class="col-md-6">
								<?php echo do_shortcode('[gravityform id="1" title="true" description="true" ajax="true"]');?>
							</div>

							<div class="col-md-6">
								<?php echo do_shortcode('[gravityform id="2" title="true" description="true" ajax="true"]');?>
							</div>

						</div>

					</div>

				</div>




	</main><!-- #main -->

<?php

get_footer();
