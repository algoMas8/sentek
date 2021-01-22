<?php get_header(); ?>

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

			<div class="container page-container">

				<div class="row">

					<div class="col-md-12">

						<h1><?php the_title();?></h1>

					</div>

				</div>

				<div class="row">

					<div class="col-md-6 single-location-wrapper">

						<?php if(get_post_meta( get_the_id(), '_bh_sl_web', true )){?>
						<a href="<?php echo get_post_meta( get_the_id(), '_bh_sl_web', true );?>">Website</a><br />
						<?php } ?>

						<?php echo get_post_meta( get_the_id(), '_bh_sl_address', true );?><br />
						<?php if(get_post_meta( get_the_id(), '_bh_sl_address_two', true )){?>
						<?php echo get_post_meta( get_the_id(), '_bh_sl_address_two', true );?><br />
						<?php } ?>
						<?php echo get_post_meta( get_the_id(), '_bh_sl_city', true );?>,
						<?php echo get_post_meta( get_the_id(), '_bh_sl_state', true );?>&nbsp;
						<?php echo get_post_meta( get_the_id(), '_bh_sl_postal', true );?><br /><br />

						<?php if(get_post_meta( get_the_id(), '_bh_sl_phone', true )){?>
						<?php echo get_post_meta( get_the_id(), '_bh_sl_phone', true );?><br />
						<?php } ?>

						<?php if(get_post_meta( get_the_id(), '_bh_sl_fax', true )){?>
						<?php echo get_post_meta( get_the_id(), '_bh_sl_fax', true );?><br /><br />
						<?php } ?>

						<?php if(get_post_meta( get_the_id(), 'wpcf-biography', true )){?>
						<strong>Biography</strong><br />
						<?php echo get_post_meta( get_the_id(), 'wpcf-biography', true );?><br /><br />
						<?php } ?>

					</div>

					<div class="col-sm-6">

						<?php

							$mapaddress =  get_post_meta( get_the_id(), '_bh_sl_address', true ) . ' ' . get_post_meta( get_the_id(), '_bh_sl_address_two', true ) . ' ' . get_post_meta( get_the_id(), '_bh_sl_city', true ) . ' ' . get_post_meta( get_the_id(), '_bh_sl_state', true ) . ' ' . get_post_meta( get_the_id(), '_bh_sl_postal', true );

							echo $mapaddress;

							get_template_part( 'template-parts/content', 'dealer-map' );

						?>

					</div>

				</div>


			</div>

		</div> <!-- close background image div created in header -->

		<?php endwhile; ?>

	<?php endif; ?>

<?php get_footer(); ?>
