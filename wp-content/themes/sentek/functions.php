<?php
/**
 * sentek functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package sentek
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'sentek_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function sentek_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on sentek, use a find and replace
		 * to change 'sentek' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'sentek', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'sentek' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'sentek_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'sentek_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function sentek_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'sentek_content_width', 640 );
}
add_action( 'after_setup_theme', 'sentek_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function sentek_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'sentek' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'sentek' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'sentek_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function sentek_scripts() {

	// use new version of jquery for front end
	//wp_deregister_script( 'jquery' );
	//wp_enqueue_script( 'jquery', get_template_directory_uri() . '/jquery/jquery-3.5.1.min.js', array(), '3.5.1' );

	// use new version of jquery migarte for front end
	//wp_deregister_script( 'jquery-migrate' );
	//wp_enqueue_script( 'jquery-migrate', get_template_directory_uri() . '/jquery/jquery-migrate-3.3.1.min.js', array(), '3.3.1' );

	wp_enqueue_style('sentek-bootstrap-min', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css');

	wp_enqueue_script('sentek-bootstrap-min-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.bundle.min.js');

	wp_enqueue_style( 'sentek-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'sentek-style', 'rtl', 'replace' );

	wp_enqueue_script( 'sentek-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sentek_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


// ACF Google maps
//function my_acf_init() {
//    acf_update_setting('google_api_key', 'AIzaSyDCoe4FzRCjhPRUv6g21upOhia149MOwms');
//}
//add_action('acf/init', 'my_acf_init');

// Country code conversion

function countryCodeToCountry($code) {
    $code = strtoupper($code);
    if ($code == 'AF') return 'Afghanistan';
    if ($code == 'AX') return 'Aland Islands';
    if ($code == 'AL') return 'Albania';
    if ($code == 'DZ') return 'Algeria';
    if ($code == 'AS') return 'American Samoa';
    if ($code == 'AD') return 'Andorra';
    if ($code == 'AO') return 'Angola';
    if ($code == 'AI') return 'Anguilla';
    if ($code == 'AQ') return 'Antarctica';
    if ($code == 'AG') return 'Antigua and Barbuda';
    if ($code == 'AR') return 'Argentina';
    if ($code == 'AM') return 'Armenia';
    if ($code == 'AW') return 'Aruba';
    if ($code == 'AU') return 'Australia';
    if ($code == 'AT') return 'Austria';
    if ($code == 'AZ') return 'Azerbaijan';
    if ($code == 'BS') return 'Bahamas the';
    if ($code == 'BH') return 'Bahrain';
    if ($code == 'BD') return 'Bangladesh';
    if ($code == 'BB') return 'Barbados';
    if ($code == 'BY') return 'Belarus';
    if ($code == 'BE') return 'Belgium';
    if ($code == 'BZ') return 'Belize';
    if ($code == 'BJ') return 'Benin';
    if ($code == 'BM') return 'Bermuda';
    if ($code == 'BT') return 'Bhutan';
    if ($code == 'BO') return 'Bolivia';
    if ($code == 'BA') return 'Bosnia and Herzegovina';
    if ($code == 'BW') return 'Botswana';
    if ($code == 'BV') return 'Bouvet Island (Bouvetoya)';
    if ($code == 'BR') return 'Brazil';
    if ($code == 'IO') return 'British Indian Ocean Territory (Chagos Archipelago)';
    if ($code == 'VG') return 'British Virgin Islands';
    if ($code == 'BN') return 'Brunei Darussalam';
    if ($code == 'BG') return 'Bulgaria';
    if ($code == 'BF') return 'Burkina Faso';
    if ($code == 'BI') return 'Burundi';
    if ($code == 'KH') return 'Cambodia';
    if ($code == 'CM') return 'Cameroon';
    if ($code == 'CA') return 'Canada';
    if ($code == 'CV') return 'Cape Verde';
    if ($code == 'KY') return 'Cayman Islands';
    if ($code == 'CF') return 'Central African Republic';
    if ($code == 'TD') return 'Chad';
    if ($code == 'CL') return 'Chile';
    if ($code == 'CN') return 'China';
    if ($code == 'CX') return 'Christmas Island';
    if ($code == 'CC') return 'Cocos (Keeling) Islands';
    if ($code == 'CO') return 'Colombia';
    if ($code == 'KM') return 'Comoros the';
    if ($code == 'CD') return 'Congo';
    if ($code == 'CG') return 'Congo the';
    if ($code == 'CK') return 'Cook Islands';
    if ($code == 'CR') return 'Costa Rica';
    if ($code == 'CI') return 'Cote d\'Ivoire';
    if ($code == 'HR') return 'Croatia';
    if ($code == 'CU') return 'Cuba';
    if ($code == 'CY') return 'Cyprus';
    if ($code == 'CZ') return 'Czech Republic';
    if ($code == 'DK') return 'Denmark';
    if ($code == 'DJ') return 'Djibouti';
    if ($code == 'DM') return 'Dominica';
    if ($code == 'DO') return 'Dominican Republic';
    if ($code == 'EC') return 'Ecuador';
    if ($code == 'EG') return 'Egypt';
    if ($code == 'SV') return 'El Salvador';
    if ($code == 'GQ') return 'Equatorial Guinea';
    if ($code == 'ER') return 'Eritrea';
    if ($code == 'EE') return 'Estonia';
    if ($code == 'ET') return 'Ethiopia';
    if ($code == 'FO') return 'Faroe Islands';
    if ($code == 'FK') return 'Falkland Islands (Malvinas)';
    if ($code == 'FJ') return 'Fiji the Fiji Islands';
    if ($code == 'FI') return 'Finland';
    if ($code == 'FR') return 'France, French Republic';
    if ($code == 'GF') return 'French Guiana';
    if ($code == 'PF') return 'French Polynesia';
    if ($code == 'TF') return 'French Southern Territories';
    if ($code == 'GA') return 'Gabon';
    if ($code == 'GM') return 'Gambia the';
    if ($code == 'GE') return 'Georgia';
    if ($code == 'DE') return 'Germany';
    if ($code == 'GH') return 'Ghana';
    if ($code == 'GI') return 'Gibraltar';
    if ($code == 'GR') return 'Greece';
    if ($code == 'GL') return 'Greenland';
    if ($code == 'GD') return 'Grenada';
    if ($code == 'GP') return 'Guadeloupe';
    if ($code == 'GU') return 'Guam';
    if ($code == 'GT') return 'Guatemala';
    if ($code == 'GG') return 'Guernsey';
    if ($code == 'GN') return 'Guinea';
    if ($code == 'GW') return 'Guinea-Bissau';
    if ($code == 'GY') return 'Guyana';
    if ($code == 'HT') return 'Haiti';
    if ($code == 'HM') return 'Heard Island and McDonald Islands';
    if ($code == 'VA') return 'Holy See (Vatican City State)';
    if ($code == 'HN') return 'Honduras';
    if ($code == 'HK') return 'Hong Kong';
    if ($code == 'HU') return 'Hungary';
    if ($code == 'IS') return 'Iceland';
    if ($code == 'IN') return 'India';
    if ($code == 'ID') return 'Indonesia';
    if ($code == 'IR') return 'Iran';
    if ($code == 'IQ') return 'Iraq';
    if ($code == 'IE') return 'Ireland';
    if ($code == 'IM') return 'Isle of Man';
    if ($code == 'IL') return 'Israel';
    if ($code == 'IT') return 'Italy';
    if ($code == 'JM') return 'Jamaica';
    if ($code == 'JP') return 'Japan';
    if ($code == 'JE') return 'Jersey';
    if ($code == 'JO') return 'Jordan';
    if ($code == 'KZ') return 'Kazakhstan';
    if ($code == 'KE') return 'Kenya';
    if ($code == 'KI') return 'Kiribati';
    if ($code == 'KP') return 'Korea';
    if ($code == 'KR') return 'Korea';
    if ($code == 'KW') return 'Kuwait';
    if ($code == 'KG') return 'Kyrgyz Republic';
    if ($code == 'LA') return 'Lao';
    if ($code == 'LV') return 'Latvia';
    if ($code == 'LB') return 'Lebanon';
    if ($code == 'LS') return 'Lesotho';
    if ($code == 'LR') return 'Liberia';
    if ($code == 'LY') return 'Libyan Arab Jamahiriya';
    if ($code == 'LI') return 'Liechtenstein';
    if ($code == 'LT') return 'Lithuania';
    if ($code == 'LU') return 'Luxembourg';
    if ($code == 'MO') return 'Macao';
    if ($code == 'MK') return 'Macedonia';
    if ($code == 'MG') return 'Madagascar';
    if ($code == 'MW') return 'Malawi';
    if ($code == 'MY') return 'Malaysia';
    if ($code == 'MV') return 'Maldives';
    if ($code == 'ML') return 'Mali';
    if ($code == 'MT') return 'Malta';
    if ($code == 'MH') return 'Marshall Islands';
    if ($code == 'MQ') return 'Martinique';
    if ($code == 'MR') return 'Mauritania';
    if ($code == 'MU') return 'Mauritius';
    if ($code == 'YT') return 'Mayotte';
    if ($code == 'MX') return 'Mexico';
    if ($code == 'FM') return 'Micronesia';
    if ($code == 'MD') return 'Moldova';
    if ($code == 'MC') return 'Monaco';
    if ($code == 'MN') return 'Mongolia';
    if ($code == 'ME') return 'Montenegro';
    if ($code == 'MS') return 'Montserrat';
    if ($code == 'MA') return 'Morocco';
    if ($code == 'MZ') return 'Mozambique';
    if ($code == 'MM') return 'Myanmar';
    if ($code == 'NA') return 'Namibia';
    if ($code == 'NR') return 'Nauru';
    if ($code == 'NP') return 'Nepal';
    if ($code == 'AN') return 'Netherlands Antilles';
    if ($code == 'NL') return 'Netherlands the';
    if ($code == 'NC') return 'New Caledonia';
    if ($code == 'NZ') return 'New Zealand';
    if ($code == 'NI') return 'Nicaragua';
    if ($code == 'NE') return 'Niger';
    if ($code == 'NG') return 'Nigeria';
    if ($code == 'NU') return 'Niue';
    if ($code == 'NF') return 'Norfolk Island';
    if ($code == 'MP') return 'Northern Mariana Islands';
    if ($code == 'NO') return 'Norway';
    if ($code == 'OM') return 'Oman';
    if ($code == 'PK') return 'Pakistan';
    if ($code == 'PW') return 'Palau';
    if ($code == 'PS') return 'Palestinian Territory';
    if ($code == 'PA') return 'Panama';
    if ($code == 'PG') return 'Papua New Guinea';
    if ($code == 'PY') return 'Paraguay';
    if ($code == 'PE') return 'Peru';
    if ($code == 'PH') return 'Philippines';
    if ($code == 'PN') return 'Pitcairn Islands';
    if ($code == 'PL') return 'Poland';
    if ($code == 'PT') return 'Portugal, Portuguese Republic';
    if ($code == 'PR') return 'Puerto Rico';
    if ($code == 'QA') return 'Qatar';
    if ($code == 'RE') return 'Reunion';
    if ($code == 'RO') return 'Romania';
    if ($code == 'RU') return 'Russian Federation';
    if ($code == 'RW') return 'Rwanda';
    if ($code == 'BL') return 'Saint Barthelemy';
    if ($code == 'SH') return 'Saint Helena';
    if ($code == 'KN') return 'Saint Kitts and Nevis';
    if ($code == 'LC') return 'Saint Lucia';
    if ($code == 'MF') return 'Saint Martin';
    if ($code == 'PM') return 'Saint Pierre and Miquelon';
    if ($code == 'VC') return 'Saint Vincent and the Grenadines';
    if ($code == 'WS') return 'Samoa';
    if ($code == 'SM') return 'San Marino';
    if ($code == 'ST') return 'Sao Tome and Principe';
    if ($code == 'SA') return 'Saudi Arabia';
    if ($code == 'SN') return 'Senegal';
    if ($code == 'RS') return 'Serbia';
    if ($code == 'SC') return 'Seychelles';
    if ($code == 'SL') return 'Sierra Leone';
    if ($code == 'SG') return 'Singapore';
    if ($code == 'SK') return 'Slovakia (Slovak Republic)';
    if ($code == 'SI') return 'Slovenia';
    if ($code == 'SB') return 'Solomon Islands';
    if ($code == 'SO') return 'Somalia, Somali Republic';
    if ($code == 'ZA') return 'South Africa';
    if ($code == 'GS') return 'South Georgia and the South Sandwich Islands';
    if ($code == 'ES') return 'Spain';
    if ($code == 'LK') return 'Sri Lanka';
    if ($code == 'SD') return 'Sudan';
    if ($code == 'SR') return 'Suriname';
    if ($code == 'SJ') return 'Svalbard & Jan Mayen Islands';
    if ($code == 'SZ') return 'Swaziland';
    if ($code == 'SE') return 'Sweden';
    if ($code == 'CH') return 'Switzerland, Swiss Confederation';
    if ($code == 'SY') return 'Syrian Arab Republic';
    if ($code == 'TW') return 'Taiwan';
    if ($code == 'TJ') return 'Tajikistan';
    if ($code == 'TZ') return 'Tanzania';
    if ($code == 'TH') return 'Thailand';
    if ($code == 'TL') return 'Timor-Leste';
    if ($code == 'TG') return 'Togo';
    if ($code == 'TK') return 'Tokelau';
    if ($code == 'TO') return 'Tonga';
    if ($code == 'TT') return 'Trinidad and Tobago';
    if ($code == 'TN') return 'Tunisia';
    if ($code == 'TR') return 'Turkey';
    if ($code == 'TM') return 'Turkmenistan';
    if ($code == 'TC') return 'Turks and Caicos Islands';
    if ($code == 'TV') return 'Tuvalu';
    if ($code == 'UG') return 'Uganda';
    if ($code == 'UA') return 'Ukraine';
    if ($code == 'AE') return 'United Arab Emirates';
    if ($code == 'GB') return 'United Kingdom';
    if ($code == 'US') return 'United States of America';
    if ($code == 'UM') return 'United States Minor Outlying Islands';
    if ($code == 'VI') return 'United States Virgin Islands';
    if ($code == 'UY') return 'Uruguay, Eastern Republic of';
    if ($code == 'UZ') return 'Uzbekistan';
    if ($code == 'VU') return 'Vanuatu';
    if ($code == 'VE') return 'Venezuela';
    if ($code == 'VN') return 'Vietnam';
    if ($code == 'WF') return 'Wallis and Futuna';
    if ($code == 'EH') return 'Western Sahara';
    if ($code == 'YE') return 'Yemen';
    if ($code == 'XK') return 'Kosovo';
    if ($code == 'ZM') return 'Zambia';
    if ($code == 'ZW') return 'Zimbabwe';
    return '';
}

// General Dealer query
function displaydealers_func( $atts ) {
	$cat = $atts['cat'];

	$the_query = new WP_Query( array(
    'post_type' => 'bh_sl_locations',
    'meta_key'=>'_bh_sl_country',
    'orderby' => '_bh_sl_country title',
    'order' => 'ASC',
    'tax_query' => array(
        array (
            'taxonomy' => 'bh_sl_loc_cat',
            'field' => 'slug',
            'terms' => $cat,
        )
    ),
) );

//display general dealers

echo '<div class="row">';

while ( $the_query->have_posts() ) :

		$the_query->the_post();

		$newcountry = get_post_meta( get_the_id(), '_bh_sl_country', true );

	  if ($newcountry!=$oldcountry) {
   		echo '</div><div class="row"><div class="col-md-12"><h3>' . countryCodeToCountry($newcountry) . '</h3></div></div><div class="row">';
    }
    echo '<div class="col-md-4"><strong>' . get_the_title() . '</strong><br />';
    echo get_post_meta( get_the_id(), '_bh_sl_address', true );?><br />
				<?php if(get_post_meta( get_the_id(), '_bh_sl_address_two', true )){?>
				<?php echo get_post_meta( get_the_id(), '_bh_sl_address_two', true );?><br />
				<?php } ?>
				<?php echo get_post_meta( get_the_id(), '_bh_sl_city', true );?>,
				<?php echo get_post_meta( get_the_id(), '_bh_sl_state', true );?>&nbsp;
				<?php echo get_post_meta( get_the_id(), '_bh_sl_postal', true );?><br />
				<b><a href="<?php the_permalink();?>">View dealer details</a></b><br /><br /></div>
<?php
	$oldcountry = $newcountry;

endwhile;

echo '</div>';

wp_reset_postdata();

}
add_shortcode( 'displaydealers', 'displaydealers_func' );



//North America shortcode (order by State for both, display states for USA)
function displaydealers_func_na( $atts ) {
	$cat = $atts['cat'];

  //query USA dealers by state
	$the_query = new WP_Query( array(
    'post_type' => 'bh_sl_locations',

    'meta_query' => array(

        'country_clause' => array(
            'key' => '_bh_sl_country',
            'value' => 'us',
        ),
        'state_clause' => array(
            'key' => '_bh_sl_state'

        ),
    ),
    'orderby' => array(
        'country_clause' => 'ASC',
        'state_clause' => 'ASC',
    ),

    'tax_query' => array(
        array (
            'taxonomy' => 'bh_sl_loc_cat',
            'field' => 'slug',
            'terms' => $cat,
        )
    ),

) );



// display US dealers
echo '<h3 style="font-weight: bold; font-size: 30px;">United States of America</h3>';
echo '<div class="row">';

while ( $the_query->have_posts() ) :

    $the_query->the_post();

    $newState = get_post_meta( get_the_id(), '_bh_sl_state', true );
    if ($newState!=$oldState) {
   		echo '</div><div class="row"><div class="col-md-12"><h3>' . $newState . '</h3></div></div><div class="row">';
    }

    echo '<div class="col-md-4"><strong>' . get_the_title() . '</strong><br />';
    echo get_post_meta( get_the_id(), '_bh_sl_address', true );?><br />
				<?php if(get_post_meta( get_the_id(), '_bh_sl_address_two', true )){?>
				<?php echo get_post_meta( get_the_id(), '_bh_sl_address_two', true );?><br />
				<?php } ?>
				<?php echo get_post_meta( get_the_id(), '_bh_sl_city', true );?>,
				<?php echo get_post_meta( get_the_id(), '_bh_sl_state', true );?>&nbsp;
				<?php echo get_post_meta( get_the_id(), '_bh_sl_postal', true );?><br />
				<b><a href="<?php the_permalink();?>">View dealer details</a></b><br /><br /></div>
<?php
	$oldState = $newState;

endwhile;

echo '</div>';

wp_reset_postdata();


//query Canadian dealers by province
$the_query_can = new WP_Query( array(
  'post_type' => 'bh_sl_locations',

  'meta_query' => array(

      'country_clause' => array(
          'key' => '_bh_sl_country',
          'value' => 'ca',
      ),
      'state_clause' => array(
          'key' => '_bh_sl_state'

      ),
  ),
  'orderby' => array(
      'country_clause' => 'ASC',
      'state_clause' => 'ASC',
  ),

  'tax_query' => array(
      array (
          'taxonomy' => 'bh_sl_loc_cat',
          'field' => 'slug',
          'terms' => $cat,
      )
  ),

) );

// display Canadian dealers

echo '<h3 style="font-weight: bold; font-size: 30px;">Canada</h3>';
echo '<div class="row">';

while ( $the_query_can->have_posts() ) :

		$the_query_can->the_post();

    echo '<div class="col-md-4"><strong>' . get_the_title() . '</strong><br />';
    echo get_post_meta( get_the_id(), '_bh_sl_address', true );?><br />
				<?php if(get_post_meta( get_the_id(), '_bh_sl_address_two', true )){?>
				<?php echo get_post_meta( get_the_id(), '_bh_sl_address_two', true );?><br />
				<?php } ?>
				<?php echo get_post_meta( get_the_id(), '_bh_sl_city', true );?>,
				<?php echo get_post_meta( get_the_id(), '_bh_sl_state', true );?>&nbsp;
				<?php echo get_post_meta( get_the_id(), '_bh_sl_postal', true );?>
        <br /><b><a href="<?php the_permalink();?>">View dealer details</a></b><br /><br /></div>
<?php


endwhile;

echo '</div>';

wp_reset_postdata();

}

add_shortcode( 'displaydealersNA', 'displaydealers_func_na' );
//end Canada and USA


//Aus / NZ shortcode (order by State for both, display states for Aus)
function displaydealers_func_au( $atts ) {
	$cat = $atts['cat'];

  //query Australian dealers by state
	$the_query = new WP_Query( array(
    'post_type' => 'bh_sl_locations',

    'meta_query' => array(

        'country_clause' => array(
            'key' => '_bh_sl_country',
            'value' => 'au',
        ),
        'state_clause' => array(
            'key' => '_bh_sl_state'

        ),
    ),
    'orderby' => array(
        'country_clause' => 'ASC',
        'state_clause' => 'ASC',
    ),

    'tax_query' => array(
        array (
            'taxonomy' => 'bh_sl_loc_cat',
            'field' => 'slug',
            'terms' => $cat,
        )
    ),

) );



// display Australian dealers
echo '<h3 style="font-weight: bold; font-size: 30px;">Australia</h3>';
echo '<div class="row">';

while ( $the_query->have_posts() ) :

    $the_query->the_post();

    $newState = get_post_meta( get_the_id(), '_bh_sl_state', true );
    if ($newState!=$oldState) {
   		echo '</div><div class="row"><div class="col-md-12"><h3>' . $newState . '</h3></div></div><div class="row">';
    }

    echo '<div class="col-md-4"><strong>' . get_the_title() . '</strong><br />';
    echo get_post_meta( get_the_id(), '_bh_sl_address', true );?><br />
				<?php if(get_post_meta( get_the_id(), '_bh_sl_address_two', true )){?>
				<?php echo get_post_meta( get_the_id(), '_bh_sl_address_two', true );?><br />
				<?php } ?>
				<?php echo get_post_meta( get_the_id(), '_bh_sl_city', true );?>,
				<?php echo get_post_meta( get_the_id(), '_bh_sl_state', true );?>&nbsp;
				<?php echo get_post_meta( get_the_id(), '_bh_sl_postal', true );?><br />
				<b><a href="<?php the_permalink();?>">View dealer details</a></b><br /><br /></div>
<?php
	$oldState = $newState;

endwhile;

echo '</div>';

wp_reset_postdata();


//query NZ dealers by state
$the_query_nz = new WP_Query( array(
  'post_type' => 'bh_sl_locations',

  'meta_query' => array(

      'country_clause' => array(
          'key' => '_bh_sl_country',
          'value' => 'nz',
      ),
      'state_clause' => array(
          'key' => '_bh_sl_state'

      ),
  ),
  'orderby' => array(
      'country_clause' => 'ASC',
      'state_clause' => 'ASC',
  ),

  'tax_query' => array(
      array (
          'taxonomy' => 'bh_sl_loc_cat',
          'field' => 'slug',
          'terms' => $cat,
      )
  ),

) );

// display New Zealand dealers

echo '<h3 style="font-weight: bold; font-size: 30px;">New Zealand</h3>';
echo '<div class="row">';

while ( $the_query_nz->have_posts() ) :
    $the_query_nz->the_post();

    echo '<div class="col-md-4"><strong>' . get_the_title() . '</strong><br />';
    echo get_post_meta( get_the_id(), '_bh_sl_address', true );?><br />
				<?php if(get_post_meta( get_the_id(), '_bh_sl_address_two', true )){?>
				<?php echo get_post_meta( get_the_id(), '_bh_sl_address_two', true );?><br />
				<?php } ?>
				<?php echo get_post_meta( get_the_id(), '_bh_sl_city', true );?>,
				<?php echo get_post_meta( get_the_id(), '_bh_sl_state', true );?>&nbsp;
				<?php echo get_post_meta( get_the_id(), '_bh_sl_postal', true );?>
        <br /><b><a href="<?php the_permalink();?>">View dealer details</a></b><br /><br /></div>
<?php


endwhile;

echo '</div>';


wp_reset_postdata();

}

add_shortcode( 'displaydealersAUS', 'displaydealers_func_au' );
//end Australia and NZ
