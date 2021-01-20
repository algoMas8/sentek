<?php
/**
 * Template Name: About
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sentek
 */

get_header();
?>

<main id="primary" class="site-main">

    <div class="container slider-container">

        <?php get_template_part('inc/image-slider');?>

    </div>



    </div> <!-- close background image div created in header -->


    <div class="about-top-wrapper">

        <div class="container">

            <div class="row" id="about-who-we-are">

                <div class="col-md-6">
                    <h2><?php the_field('top_heading')?></h2>
                    <?php the_field('top_text')?>

                </div>

                <div class="col-md-6">
                    <?php $topImage = get_field('top_image'); ?>
                    <div class="half-image" style="background: url('<?php echo $topImage['url']; ?>') no-repeat; "></div>
                </div>

            </div>

            <div class="row" id="about-manufacturing-excellence">

                <div class="col-md-6">
                    <?php $secondardImage = get_field('secondary_image'); ?>
                    <div class="half-image" style="background: url('<?php echo $secondardImage['url']; ?>') no-repeat; "></div>
                </div>

                <div class="col-md-6">
                    <h2><?php the_field('secondary_heading')?></h2>
                    <?php the_field('secondary_text')?>

                </div>

            </div>

        </div>

    </div>

    <div class="about-team-wrapper">
        <div class="container">

            <div class="row">

                <div class="col-12">
                    <h2><?php the_field('management_title')?></h2>
                    <?php the_field('management_intro_text')?>

                </div>
            </div>
        </div>

        <div class="staff-management-band">

            <?php //spit out children of 'staff' > 'management' and display in grid

					$args = array(
							'post_type'      => 'page',
							'post_parent'    => '20281',
							'order'          => 'ASC',
							'orderby'        => 'menu_order',
                            'meta_query' => array(
                                array(
                                    'key' => 'team',
                                    'value' => 'Management'
                                )
                            )
					 );


					$childrens = new WP_Query( $args );
                        
                        $x = 0;

					if ( $childrens->have_posts() ) : ?>

            <?php while ( $childrens->have_posts() ) :

									$childrens->the_post();

									$backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); 
            $profileNumber++;
            
            ?>

            <!-- add a new row around every 2 profiles by seeing if it's an even or odd number -->
            <?php if ($profileNumber % 2 != 0) {
    ?>
            <div class="about-staff-profile-row">
                <?php
} ?>

                <div class="about-staff-profile" id="child-<?php the_ID(); ?>">
                    <div class="about-staff-profile-inner">

                        <div class="about-staff-profile-top">



                            <div class="col-5">
                                <div class="about-staff-image" style="background: url('<?php echo $backgroundImg[0]; ?>') no-repeat; "><br /></div>
                            </div>

                            <div class="col-7">
                                <h3><?php the_title(); ?></h3>
                                <div id="about-staff-job-title"><?php the_field('job_title'); ?></div>
                                <a href="<?php the_field('linkedin_profile'); ?>" id="about-staff-linkedin">LinkedIn</a>
                            </div>



                        </div>

                        <div class="about-staff-profile-bio">
                            <?php echo the_content(); ?>
                        </div>

                    </div>

                </div>

                <!-- close row if required -->
                <?php if ($profileNumber % 2 == 0) {
    ?>
            </div>
            <?php
} ?>

            <?php endwhile;

					endif;

					wp_reset_query(); ?>

        </div>

        <div class="container">

            <div class="row">

                <div class="col-12">
                    <h2><?php the_field('sales_title')?></h2>
                    <?php the_field('sales_intro_text')?>

                </div>
            </div>
        </div>

        <div class="staff-sales-band">

            <?php //spit out children of 'staff' > 'management' and display in grid

					$args = array(
							'post_type'      => 'page',
							'post_parent'    => '20281',
							'order'          => 'ASC',
							'orderby'        => 'menu_order',
                            'meta_query' => array(
                                array(
                                    'key' => 'team',
                                    'value' => 'Sales'
                                )
                            )
					 );


					$childrens = new WP_Query( $args );
                        
                        $x = 0;

					if ( $childrens->have_posts() ) : ?>

            <?php while ( $childrens->have_posts() ) :

									$childrens->the_post();

									$backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); 
            $profileNumber++;
            
            ?>

            <!-- add a new row around every 2 profiles by seeing if it's an even or odd number -->
            <?php if ($profileNumber % 2 != 0) {
    ?>
            <div class="about-staff-profile-row">
                <?php
} ?>

                <div class="about-staff-profile" id="child-<?php the_ID(); ?>">
                    <div class="about-staff-profile-inner">

                        <div class="about-staff-profile-top">



                            <div class="col-5">
                                <div class="about-staff-image" style="background: url('<?php echo $backgroundImg[0]; ?>') no-repeat; "><br /></div>
                            </div>

                            <div class="col-7">
                                <h3><?php the_title(); ?></h3>
                                <div id="about-staff-job-title"><?php the_field('job_title'); ?></div>
                                <a href="<?php the_field('linkedin_profile'); ?>" id="about-staff-linkedin">LinkedIn</a>
                            </div>



                        </div>

                        <div class="about-staff-profile-bio">
                            <?php echo the_content(); ?>
                        </div>

                    </div>

                </div>

                <!-- close row if required -->
                <?php if ($profileNumber % 2 == 0) {
    ?>
            </div>
            <?php
} ?>

            <?php endwhile;

					endif;

					wp_reset_query(); ?>
        </div>

    </div>




    <div class="brag-wrapper">

        <div class="container">

            <div class="row">

                <div class="col-md-6">
                    <h3><?php the_field('brag_title')?></h3>
                    <?php the_field('brag_text')?>

                </div>

                <div class="col-md-6">
                    <?php $topImage = get_field('top_image'); ?>
                    <div class="half-image" style="background: url('<?php echo $topImage['url']; ?>') no-repeat; "></div>
                </div>

            </div>

            <div class="row">

                <div class="col-12">
                    <?php $logos = get_field('logos'); ?>
                    <img src="<?php echo $logos['url']; ?>" width="100%" />
                </div>

            </div>

        </div>

    </div>


    <div class="about-bottom-wrapper">

        <div class="container">

            <div class="row">

                <div class="col-md-6">
                    <h2><?php the_field('dealer_title')?></h2>
                    <?php the_field('dealer_text')?>

                </div>

                <div class="col-md-6">
                    <?php $dealerImage = get_field('dealer_image'); ?>
                    <div class="half-image" style="background: url('<?php echo $dealerImage['url']; ?>') no-repeat; "></div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <?php $careerImage = get_field('careers_image'); ?>
                    <div class="half-image" style="background: url('<?php echo $careerImage['url']; ?>') no-repeat; "></div>
                </div>

                <div class="col-md-6">
                    <h2><?php the_field('careers_title')?></h2>
                    <?php the_field('careers_text')?>

                </div>

            </div>

        </div>

    </div>

    <br /><br />



    <?php get_template_part('inc/footer-top');?>




</main><!-- #main -->

<?php

get_footer();
