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

	<div class="container slider-container"></div>

</div> <!-- close background image div created in header -->

	<div class="container page-container default-page-container">

		<div class="entry-content">
			<h1><?php the_title();?></h1>
			<?php the_content(); ?>
		</div><!-- .entry-content -->


    <div class="row home-products-row products-landing-row">

        <?php //spit out children of 'products' and display in grid

            $args = array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'post_parent'    => $post->ID,
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

                            <a href="<?php the_permalink(); ?>">
                                <div class="feat-img-wrapper" style="background: url('<?php echo $backgroundImg[0]; ?>') no-repeat; "></div>
                            </a>

                            <br />

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
