<?php
/**
 * Template part for displaying page content in page-products.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sentek
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="container slider-container"></div>

</div> <!-- close background image div created in header -->

	<div class="container page-container default-page-container">

		<div class="breadcrumbs-wrapper">

			<?php if ( function_exists('yoast_breadcrumb') ) {
				  yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
				}
			?>

		</div>

		<div class="entry-content">

			<h1><?php the_title();?></h1>
			<?php the_content(); ?>
		</div><!-- .entry-content -->

		<?php if(get_field('second_band_title')){ ?>

			<h2><?php the_field('second_band_title');?></h2>

			<div class="row spec-row">

				<div class="col-md-6">
					<img src="<?php the_field('left_image');?>" />
				</div>

				<div class="col-md-6">
						<img src="<?php the_field('right_image');?>" />
				</div>

			</div>

		<?php } ?>

		<?php if(get_field('faq')){ ?>

				<h2>Frequently Asked Questions</h2>

			 			<?php get_template_part('inc/faq'); ?>

	 		<?php	} ?>

		<?php

			// check if the repeater field has rows of data
			if( have_rows('tabs') ):

				$i = 1; // Set the increment variable

				echo '<ul class="nav nav-tabs" id="myTab" role="tablist">';

			 	// loop through the rows of data for the tab header
			    while ( have_rows('tabs') ) : the_row();

						$header = get_sub_field('tab_button');

				?>

						<li class="nav-item">
					    		<a class="nav-link <?php if($i == 1) echo 'active';?>" id="<?php echo sanitize_title($header); ?>-tab" data-toggle="tab" href="#<?php echo sanitize_title($header); ?>" role="tab" aria-controls="<?php echo sanitize_title($header); ?>" aria-selected="true">
										<?php echo $header; ?>
									</a>
						</li>

				<?php

					$i++; // Increment the increment variable

				endwhile; //End the loop

				echo '</ul>
				<div class="tab-content" id="myTabContent">';

				$i = 1; // Set the increment variable

				// loop through the rows of data for the tab content
				while ( have_rows('tabs') ) : the_row();

					$header = get_sub_field('tab_button');

					if(get_sub_field('how_many_columns_for_tab_content') == 1){
						$content_full_width = get_sub_field('tab_content_one_col');
						$layout = "one column";
					}

					if(get_sub_field('how_many_columns_for_tab_content') == 2){
						$content_left_col = get_sub_field('tab_content_two_col_first');
						$content_right_col = get_sub_field('tab_content_two_col_second');
						$layout = "two column";
					}

				?>

				  <div class="tab-pane fade show <?php if($i == 1) echo 'active';?>" id="<?php echo sanitize_title($header); ?>" role="tabpanel" aria-labelledby="<?php echo sanitize_title($header); ?>-tab">

						<?php if($layout == "one column"){

							echo $content_full_width;

						} ?>

						<?php if($layout == "two column"){ ?>

							<div class="row">

								<div class="col-md-6">
									<?php echo $content_left_col; ?>
								</div>

								<div class="col-md-6">
									<?php echo $content_right_col; ?>
								</div>

							</div>

					<?php } ?>

					</div>

				<?php   $i++; // Increment the increment variable

				endwhile; //End the loop

				echo '</div>';

			else :

			    // no rows found

			endif; ?>

			<div class="row">

				<div class="col-sm-12">

					<h2 class="related-heading">Related Products</h2>

				</div>

			</div>

			<div class="row home-products-row products-landing-row">



		        <?php //spit out children of 'products' and display in grid - exclude current post

		            $args = array(
		                'post_type'      => 'page',
		                'posts_per_page' => -1,
		                'post_parent'    => wp_get_post_parent_id( get_the_ID() ),
		                'order'          => 'ASC',
		                'orderby'        => 'menu_order',
										'post__not_in'   => [ get_the_ID() ]
		             );


		              $childrens = new WP_Query( $args );

		              if ( $childrens->have_posts() ) : ?>

		                    <?php while ( $childrens->have_posts() ) :

		                      $childrens->the_post();

		                      $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>

		                    <div class="col-md-4 related-col" id="child-<?php the_ID(); ?>">

		                        <div class="home-product-wrapper">


															<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		                            <p><?php the_excerpt();?></p>

		                            <br />

		                            <div class="product-link-wrapper">
		                                <a class="sentek-button" href="<?php the_permalink();?>/">View Product</a>
		                            </div>

		                        </div>

		                    </div>

		                    <?php endwhile;

		              endif;

		              wp_reset_query(); ?>

		    </div>




	</div>



</article><!-- #post-<?php the_ID(); ?> -->

<?php get_template_part('inc/footer-top');?>
