<?php
/**
 * Template part for displaying page content in page-where-to-buy.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sentek
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>



    <header class="entry-header">
  		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
  	</header><!-- .entry-header -->

    <div class="container">


      <div class="entry-content">

        <?php the_content(); ?>

        <?php echo do_shortcode('[cardinal-storelocator]'); ?>

        <h2>All Dealers</h2>

        <div id="accordion">

          <div class="card">
            <div class="card-header" id="headingOne">
              <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                  North America
                </button>
              </h5>
            </div>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body">
                <?php echo do_shortcode('[displaydealersNA cat="north-america"]');?>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header" id="headingTwo">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Oceania
                </button>
              </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
              <div class="card-body">
                <?php echo do_shortcode('[displaydealersAUS cat="australia-nz-and-pacific"]');?>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header" id="headingThree">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Latin America
                </button>
              </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
              <div class="card-body">
                <?php echo do_shortcode('[displaydealers cat="latin-america"]');?>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header" id="headingFour">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Africa
                </button>
              </h5>
            </div>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
              <div class="card-body">
                <?php echo do_shortcode('[displaydealers cat="africa"]');?>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header" id="headingFive">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                  Asia
                </button>
              </h5>
            </div>
            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
              <div class="card-body">
                <?php echo do_shortcode('[displaydealers cat="asia"]');?>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header" id="headingSix">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                  Middle East
                </button>
              </h5>
            </div>
            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
              <div class="card-body">
                <?php echo do_shortcode('[displaydealers cat="middle-east"]');?>
              </div>
            </div>
          </div>


        </div>








      </div><!-- .entry-content -->

    </div>



</article><!-- #post-<?php the_ID(); ?> -->

<script type="text/javascript">
/*jQuery( document ).ready(function() {
	jQuery( "#country-filters-container select" ).hide();
	jQuery( "#state-filters-container select" ).hide();
	jQuery( ".bh-sl-reset" ).hide();
	jQuery( ".bh-sl-reset" ).click(function() {
		jQuery('#bh_sl_loc_cat-filters-container select').removeAttr("disabled");
		jQuery('#country-filters-container select').removeAttr("disabled");
		jQuery( "#country-filters-container select" ).hide();
		jQuery( "#state-filters-container select" ).hide();
	});

  jQuery( "#bh_sl_loc_cat-filters-container select" ).change(function() {
		jQuery( ".bh-sl-reset" ).show();
		jQuery('#bh_sl_loc_cat-filters-container select').attr('disabled', 'disabled');
		jQuery( "#country-filters-container select" ).show();
		jQuery("#country-filters-container select option" ).hide();

		/* show country of selected region*/
	/*	var selectedRegion = jQuery(this).val();
		var availableCountry = Object.keys( map_datasource_arr[selectedRegion] );

    jQuery.map(availableCountry, function(item, index) {
			jQuery('#country-filters-container select option[value="'+item+'"]').show();
			return true;
		});

		/* show the default item and select the first item */
	/*	jQuery('.defaultoption').show();
		jQuery('#country-filters-container select').prop('selectedIndex',0);
		jQuery('#state-filters-container select').prop('selectedIndex',0);
	});

  jQuery( "#country-filters-container select" ).change(function() {
		jQuery('#country-filters-container select').attr('disabled', 'disabled');
		jQuery( "#state-filters-container select option" ).hide();
		jQuery('#state-filters-container select').prop('selectedIndex',0);
		jQuery( "#state-filters-container select" ).show();
		jQuery('.defaultoption').show();

		/* show state of selected country */
	/*	var selectedRegion = jQuery( "#bh_sl_loc_cat-filters-container select" ).val();
		var selectedCountry = jQuery(this).val();
		var availableState = Object.keys( map_datasource_arr[selectedRegion][selectedCountry] );

    jQuery.map(availableState, function(item, index) {
			jQuery('#state-filters-container select option[value="'+item+'"]').show();
			return true;
		});

	});
});
</script>
