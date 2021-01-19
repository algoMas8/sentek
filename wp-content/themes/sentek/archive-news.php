<?php
/**
 * Display archive for custom post news items
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package A3C
 */

get_header();
?>

	<main id="primary" class="site-main">

		<div class="container slider-container">
			<?php get_template_part('inc/image-slider-case-studies-archive');?>
    </div>

	</div> <!-- close background image div created in header -->

		<div class="news-band">

				<div class="container">

					<h1>News</h1>

      <?php

        $taxonomyNews = 'news-category';
        $termsNews = get_terms($taxonomyNews); // Get all terms of a taxonomy

        if ( $termsNews && !is_wp_error( $termsNews ) ) : ?>

            <div class="archive-menu">

                <?php foreach ( $termsNews as $term ) { ?>

                    <a href="<?php echo get_term_link($term->slug, $taxonomyNews); ?>"><?php echo $term->name; ?></a>
                    <br />

                <?php } ?>

            </div>

        <?php

      endif;?>

          <div class="row">

							<?php
							if ( have_posts() ) :

								$postCount = 0;

								/* Start the Loop */
								while ( have_posts() ) :

										the_post();

										$backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>

									<div class="col-md-4 post-archive-col">

										<div class="post-title-wrapper">

											<a href="<?php echo the_permalink();?>">
												<h2><?php the_title();?></h2>
											</a>

										</div>

										<a href="<?php echo the_permalink();?>">
											<div class="post-img" style="background: url('<?php echo $backgroundImg[0];?>')">
											</div>
										</a>

										<div class="post-content-wrapper">

											<p class="post-date"><?php echo get_the_date();?></p>

											<div class="intro"><?php the_excerpt();?></div>
											<br />
											<a class="sentek-button" href="<?php echo the_permalink();?>">Read More</a>

										</div>


									</div>

									<?php

									$postCount++;

									if($postCount % 3 == 0){

										echo '<div class="underline"></div>';

									}

								endwhile;

							endif;
							?>

					</div>

				</div>

			</div>

	</main><!-- #main -->

<?php

get_footer();
