<!-- mobile nav is a full width overlay -->
<div id="mobile-nav" class="mobile-overlay">

	 <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

		 <div class="overlay-content">

				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				) );
				?>

        <img src="<?php echo get_template_directory_uri(); ?>/images/footer-logo.png" alt="sentek logo" />

			</div>

</div> <!-- close nav -->
