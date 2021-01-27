<?php
/**
 * Template part for displaying page content in page-markets-landing.php
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

</article><!-- #post-<?php the_ID(); ?> -->

<div class="second-home-band-wrapper">

    <div class="container second-home-band">

        <div class="row">

            <div class="col-12">
                <h1><?php the_title();?></h1>
                <?php the_content(); ?>

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

                    <a href="<?php the_permalink(); ?>">
                        <div class="feat-img-wrapper" style="background: url('<?php echo $backgroundImg[0]; ?>') no-repeat; "></div>
                    </a>

                    <a href="<?php the_permalink(); ?>">
                        <div class="markets-link-wrapper">

                            <h3><?php the_title(); ?></h3>

                        </div>
                    </a>

                </div>

            </div>

            <?php endwhile;

          endif;

          wp_reset_query(); ?>

        </div>

    </div>

</div>
