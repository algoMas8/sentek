<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sentek
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->

    <link rel="stylesheet" href="https://use.typekit.net/exv4kto.css">

    <script src="https://use.fontawesome.com/768edc4395.js"></script>


    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <?php get_template_part('inc/mobile-overlay-menu');?>

    <div id="page" class="site">

        <div>
            <!--<div class="top-background-image">-->
            <!-- close this div on page templates -->


            <header id="masthead" class="site-header">

                <div class="container header-container">
                    <div class="row">
                        <div class="col-3">
                            <div class="site-branding">
                                <?php the_custom_logo(); ?>
                            </div><!-- .site-branding -->
                        </div>
                        <div class="col-9">

                            <a class="store-link" href="https://orders.sentek.com.au/" target="_blank">Dealer Webstore</a>

                            <div class="hamburger-container" onclick="openNav()">
                                <div class="bar1"></div>
                                <div class="bar2"></div>
                                <div class="bar3"></div>
                            </div>


                            <nav id="site-navigation" class="main-navigation text-right desktop-menu">
                                <?php
                        						wp_nav_menu(
                        							array(
                        								'theme_location' => 'menu-1',
                        								'menu_id'        => 'primary-menu',
                        							)
                        						);
                        				?>
                            </nav><!-- #site-navigation -->
                        </div>
                    </div>

                </div>


            </header><!-- #masthead -->
