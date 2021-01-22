<?php
/**
 * Template part for displaying page content in page-faq.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sentek
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<!--<div class="container slider-container">

		<?php //get_template_part('inc/image-slider');?>

	</div>-->

	<div class="container page-container default-page-container">

		<div class="entry-content">

      <h1><?php the_title();?></h1>

      <?php the_content(); ?>

      <br />

      <?php

					// check if the page template has an accordion
					if( have_rows('faq') ): ?>

						<!--Accordion wrapper-->
						<div class="faq" id="accordion" role="tablist" aria-multiselectable="true">

 							<?php

							// init counter
							$counter = 0;

							// loop through the accordion rows of data

							while ( have_rows('faq') ) : the_row(); ?>

									<!-- Accordion card -->
							    <div class="card">
                    <div class="card-header" role="tab" id="heading<?php echo $counter;?>">
                      <h5 class="mb-0">
							          <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $counter;?>" aria-expanded="false" aria-controls="collapse<?php echo $counter;?>">
                          <?php the_sub_field('question');?> <i class="fa fa-chevron-down region-icon"></i>
                        </button>
							         </h5>
							       </div>

							        <!-- Card body -->
							        <div id="collapse<?php echo $counter;?>" class="collapse" aria-labelledby="heading<?php echo $counter;?>" data-parent="#accordion">
							            <div class="card-body">
							               <?php the_sub_field('answer'); ?>
							            </div>
							        </div>
							    </div>
							    <!-- Accordion card -->



    			<?php

						$counter++;

						 endwhile; ?>

						</div>
						<!--/ close .Accordion wrapper-->

				<?php endif; ?>


      </div><!-- .entry-content -->

	</div>

</div> <!-- close background image div created in header -->

<?php get_template_part('inc/footer-top');?>

</article><!-- #post-<?php the_ID(); ?> -->
