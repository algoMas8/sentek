<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sentek
 */

?>

<footer id="colophon" class="site-footer">

	<div class="container">

		<div class="row footer-row">

			<div class="col-md-3">

				<img src="<?php echo get_template_directory_uri(); ?>/images/footer-logo.png" alt="sentek logo" />


			</div>

			<div class="col-md-3">

				<h5>Sentek</h5>
				<p>77 Magill Road</p>
				<p>Stepney South Australia 5069</p>
				<p>Phone: +61 8 8366 1900</p>

				<p><i class="fa fa-facebook-f"></i><i class="fa fa-youtube"></i><i class="fa fa-instagram"></i><i class="fa fa-linkedin"></i></p>

			</div>

			<div class="col-md-3">

				<h5>Quick Links</h5>

				<nav id="quick-links">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'quick-links',
							'menu_id'        => 'footer-menu',
						)
					);
					?>
				</nav><!-- #site-navigation -->

			</div>

			<div class="col-md-3">

				<h5>Important Information</h5>

				<nav id="quick-links">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'important-info',
							'menu_id'        => 'footer-right-menu',
						)
					);
					?>
				</nav><!-- #site-navigation -->

			</div>

		</div>

	</div>



</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

<!-- open and close menu -->
<script>
function openNav() {

	document.getElementById("mobile-nav").style.width = "100%";
	jQuery('body').css('overflow-y', 'hidden');

}

function closeNav() {

	document.getElementById("mobile-nav").style.width = "0%";
	jQuery('body').css('overflow-y', 'auto');

}
</script>

<!-- show and hide elements on products landing page -->
<script>
jQuery('.show-hide-product-details').each(function(){

	jQuery(this).click(function() {

		jQuery(this).toggleClass('fa-chevron-down fa-chevron-up');
		jQuery(this).closest('.product-info').find('.product-excerpt').slideToggle('slow');

	});

});
</script>

<!-- toggle class of icons on 'where to buy page' -->
<script>
jQuery('.region-icon').each(function(){

	jQuery(this).click(function() {

		jQuery(this).toggleClass('fa-chevron-down fa-chevron-up');

	});

});
</script>

<script>
//jQuery(window).resize(function() {

	//if (jQuery(window).width() > 1119) {

		jQuery('.menu-item-has-children').each(function(){

			jQuery(this).hover(function() {

				jQuery(this).find('.sub-menu').slideToggle('slow');

			});

		});

	//}

//s});

</script>

</body>
</html>
