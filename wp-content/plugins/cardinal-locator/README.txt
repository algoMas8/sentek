=== Cardinal Store Locator ===
Contributors: bjorn2404
Donate link: http://www.bjornblog.com
Tags: locator, store, location, locations, maps, map, stores, find, finder
Requires at least: 4.1
Tested up to: 4.9
Stable tag: trunk
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Cardinal Store Locator is an easy to implement locator plugin for WordPress. Location data can be pulled from a custom
post type, XML, KML, or JSON.

== Description ==

Cardinal Store Locator is a WordPress plugin that gives users the ability to add a fully functional locator to a
WordPress website. It is built on top of the
[jQuery Store Locator plugin](https://github.com/bjorn2404/jQuery-Store-Locator-Plugin) and offers all of the same
features as the jQuery plugin along with a WordPress dashboard settings page, the ability to add locations as a
custom post type or other data source of your choosing and set up filtering based on taxonomies. The plugin is aimed at
developers with the amount of options and functionality available but should be accessible enough for non-developers to
understand.

The plugin is built with the Google Maps API and the WordPress Settings API and offers some of the following features
through the different settings that are available:

* Add locations with a new or existing custom post type
* Use location data via KML, XML, or JSON on the local or a remote server
* Map existing address and coordinate meta fields
* Add search filters with custom taxonomies
* Add country select drop-down field
* Implement custom map styling from Snazzy Maps or other source
* Use custom category marker images
* Use custom origin marker image
* Inline directions from origin to destination
* Display the locator in a modal window
* Pagination
* Feature specific locations in results
* Override location list and infowindow markup with custom [Handlebars templates](http://handlebarsjs.com/)
* Add a maximum distance select drop-down field
* Display a loading icon
* Add a field to search locations by name
* Select miles or kilometers as the unit of length
* Switch between any of the [Google Map Types](https://developers.google.com/maps/documentation/javascript/maptypes)
* Only display locations in the locations list that are visible on the map

== Installation ==

This section describes how to install the plugin and get it working.

The steps to install the Cardinal Store Locator plugin are the same as installing any WordPress plugin with the
addition of entering your license key in the plugin settings for it to become functional.

= FTP =

1.  Download the plugin
2.  Unzip the plugin on your computer
3.  Upload the extracted "cardinal-storelocator" directory to /wp-content/plugins/
4.  Login to your WordPress installation admin and activate the plugin under the "Plugins" menu in the dashboard
5.  Visit the plugin settings page by clicking on the "Settings" link in the plugins list or by clicking Settings >
Cardinal Locator in the left column of the WordPress dashboard and enter your license key
6.  [Create a new Google Maps API key](https://developers.google.com/maps/documentation/javascript/get-api-key#key) and
enter it in the Google Maps API key field under Primary Settings. Make sure to enable Google Places API Web Service,
Google Maps Geocoding API and Google Maps Directions API for the project in the Google API Console after setting up the
initial Maps key.

= Upload zip file in WordPress dashboard =

Alternatively, you can install the plugin by uploading the plugin zip file in the WordPress dashboard by following
these steps:

1.  Download the plugin
2.  Login to your WordPress installation admin and navigate to Plugins > Add New > Upload Plugin
3.  Click the browse button to find the zip file on your computer, then click the "Install Now" button
4.  Activate the plugin under the "Plugins" menu in the dashboard
5.  Visit the plugin settings page by clicking on the "Settings" link in the plugins list or by clicking Settings >
Cardinal Locator in the left column of the WordPress dashboard and enter your license key
6.  [Create a new Google Maps API key](https://developers.google.com/maps/documentation/javascript/get-api-key#key) and
enter it in the Google Maps API key field under Primary Settings. Make sure to enable Google Places API Web Service,
Google Maps Geocoding API and Google Maps Directions API for the project in the Google API Console after setting up the
initial Maps key.


== Frequently Asked Questions ==

Please visit the [CardinalWP website](https://cardinalwp.com/faq/) to view an active list of FAQs.

== Changelog ==

= 1.4.6 =
* Fixed missing CSS property .loc-alt-dist needed for front-end distance swap - both KM and miles show in templates without.
* Removed Geocoding API from being sent to the JS file (no longer publicly viewable in page source).
* Updated Handlebars templates so that location names are output with triple stash to avoid special character issues.
* Updated remote data caching functionality so that it's skipped completely if a relative URL is used for the Data file path setting.

= 1.4.5 =
* Added [cardinal-storelocator-address] shortcode to display single location address.
* Added bh_sl_locations_query_args filter to allow location WP_Query arguments to be updated/overridden.
* Added bh_sl_tax_cpts filter to allow the default "Location Categories" taxonomy to be applied to other post types.
* Added cslAjaxData callback to allow custom data to be sent with the AJAX request.
* Added cslAutoGeoSuccess callback that fires after the geolocation API returns a successful result.
* Added cslFormVals callback that fires after the form values have been processed from the form.
* Added cslGeocodeRestrictions callback that allows the componentRestrictions object to be overridden.
* Added cslNearestLoc callback that fires when the nearest location is triggered with the open nearest setting.
* Added cslSorting callback that fires when when a new sorting method is selected.
* Added component filtering for geocoding to better restrict by area - especially helpful with international geocoding.
* Added custom sorting settings under Structure Settings to allow visitors to control the location sort order from the front-end.
* Added drag and drop order functionality to filters set up under Filter Settings.
* Added functionality to specify filter types using the [cardinal-storelocator-filters] shortcode with the filter-types attribute.
* Added functionality to fill in search input with determined address when using Auto geocode or Geocode button settings.
* Added length unit (distance miles/kilometers) front-end swap functionality and settings.
* Added geocoding back-end API key field setting when Data source is set to Register Locations Post Type or Other Custom Post Type.
* Added Google Map object as parameter to cslBeforeSend, cslListClick, cslModalReady, and cslFilters callbacks.
* Added location data object as parameter of cslDirectionsRequest callback.
* Added mappingObject, originPoint, data, and page parameters to cslSuccess callback.
* Added "No results alternative" setting to display the no results message instead of all locations when the closest location is further than the "Distance alert" setting.
* Added open nearest location setting to automatically highlight the closest location from the origin.
* Changed parseJSON to native JSON.parse due to deprecation in rawData processing function.
* Fixed full path disclosure security issue with data passed to JavaScript.
* Fixed issue where HTML5 Geolocation was skipped when using the fullMapStartBlank setting.
* Fixed issue with featuredLocations setting where featured locations at far distances would trigger distance alert.
* Fixed issue with filtering values containing ampersands, which would not display any results - updated filtering regex.
* Fixed issue with mapReload (triggered with optional reset button) where store limit wasn't reset.
* Fixed issue with pagination page numbers displaying after no results.
* Fixed issue with taxonomy filtering and autoGeocode setting where HTML Geocoding API would run on every filter change.
* Fixed missing Google Maps API key parameter from post geocoding call.
* Fixed variable casting warning in PHP v7.1+ in shortcode file with wp_localize_script.
* Fixed typo in admin meta box container ID "locations_meta_box".
* Removed check for safe mode in plugin Support settings tab since it is deprecated as of PHP 5.4.0.
* Renamed EDD updater class to avoid conflicts with other themes and plugins.
* Removed locations transient (bh_sl_locations) expiration to default to none.
* Updated taxonomy filtering so pagination is reset to first page after selecting a filter.

= 1.4.4 =
* Hotfix to add now required key parameter to location post geocoding API call.
* This is just a quick fix - larger update with v1.4.5 coming very soon.

= 1.4.3 =
* Fixed error when filtering with query strings where filter values with spaces wouldn't work.
* Updated processForm method so submitting the map removes focus from any of the form input/select fields instead of just the address input.
* Updated filterData string replace methods to match string replace method in filters setup.
* Updated WPML path modification method so that it only is applied when "A different domain per language" is set as the language URL format.

= 1.4.2 =
* Added ability to indicate multiple query string parameter values (for checkboxes) with a comma separated list value.
* Added additional hours meta fields for a total of seven to match days of the week.
* Added autoCompleteDisableListener setting to disable the listener that immediately triggers a search when an auto complete location option is selected.
* Added bh_sl_page_check filter to disable locator scripts and styles on indicated pages.
* Added bh_sl_filter_vals_"taxonomy" filter so filter values can be modified prior to output.
* Added blur to primary location input field after form submission to hide mobile keyboards.
* Added check to exclusive filtering to make sure filter values are not undefined before proceeding with the regular expression.
* Added functionality to automatically select/check filters on load from query string parameter values.
* Added location details object to callbackListClick and callbackMarkerClick objects.
* Added structure setting to disable form tags.
* Added template URI and stylesheet URI as available variables to Handlebars templates.
* Added WordPress REST API support for default locations custom post type (bh_sl_locations).
* Fixed broken dragSearch functionality that was introduced after map scope pull request was merged from jQuery plugin.
* Fixed geocoding issue when using an alternative custom post type for locations.
* Fixed Handlebars targeting issue triggered by placing an unordered list within the location list template.
* Fixed issue with fullMapStart where conditional was checking if isNaN was true when it should have been false on fullMapStartListLimit setting.
* Updated geocoding functionality to start saving Place IDs when available.
* Updated over 1,000 locations AJAX method to use float values instead of decimals for latitude and longitude coordinates.
* Updated zooming to prevent fitBounds from being used when query string parameters are in use and the location has been set with bh-sl-address.

= 1.4.1 =
* Added cslRegion callback, which allows region to be set before being sent to the Google Maps Geocoding API.
* Fixed admin scripts loading on all WordPress dashboard pages and related post object error.
* Fixed issue where searching by location name after searching by address, without a new address, didn't reset the origin.
* Fixed incorrect origin marker parameter order after code restructure.
* Fixed single map issues with info window content when using alternate custom post type for location data.
* Updated single map script so that global marker overrides are applied when using the shortcode and widget.

= 1.4.0 =
* Added checks to make sure filter values are skipped in shortcode output if the value isn't set.
* Added checks to replace non-ASCII characters when filtering to prevent issues with special characters.
* Added city column to Locations edit pages (list view).
* Added cslCreateMarker JS callback for custom marker overrides.
* Added Disable alpha markers setting.
* Added functionality to accept manual coordinate overrides with latitude and longitude post meta.
* Added [InfoBubble](https://github.com/googlemaps/js-info-bubble) support.
* Added location results total count if HTML element with "bh-sl-total-results" class exists.
* Added map preview post meta box on single location edit screen with manual coordinate fine-tuning available.
* Added query string parameter filter check so that results can be filtered with URL query strings.
* Added reset functionality that can be triggered via a button that has the CSS class "bh-sl-reset".
* Added single location shortcode and widget to display map of a single location on single location posts.
* Added span and class to checkbox and radio button labels in filter output with shortcode.
* Fixed issue with Google Maps settings filter (bh_sl_map_settings) not being applied with full map start blank and no results.
* Fixed issue with Maximum Distance and Query string parameters settings combination.
* Updated Distance alert setting so that it can be disabled.
* Re-structured some of the underlying jQuery code.

= 1.3.13 =
* Fixed issue reading optional custom map styles file with WordPress installed in a subdirectory.
* Fixed issue where custom post meta with the same values were skipped from being included in the location data.

= 1.3.12 =
* Added array of term objects for location output to Handlebars templates for each custom taxonomy assigned to the locations post type.
* Added bh_sl_before_location_query and bh_sl_after_location_query hooks.
* Added cslMapSet callback that fires after the map has been set up.
* Added file existence and valid JSON checks to custom map styles file path setting.
* Changed method of reading custom map styles file from wp_remote_fopen to file_get_contents.
* Fixed issue where locations without attributes set (ex: custom meta fields) could get the attribute values from prior locations.
* Fixed issue where pagination total number of pages was based on the full location set total instead of the storeLimit setting.
* Reverted bh_storelocator_posts_query returning JSON vs. array for backwards compatibility.
* Updated included Handlebars to v4.0.5.

= 1.3.11 =
* Added additional JS error handling when the plugin checks the closest location.
* Added additional information about Google Maps API key, which is now required for all new URLs. [More information](http://googlegeodevelopers.blogspot.com/2016/06/building-for-scale-updates-to-google.html)
* Added fax meta field to default location post type.
* Added listener for autoComplete change so that the search processes when a new place is selected.
* Fixed issue with combination of autoGeocode and originMarker settings.
* Fixed PHP notices that would trigger on non-posts (no post ID) from enqueue_scripts in public class.
* Fixed zoom issue with Search on map drag setting.
* Switched city and address variables to triple stash in Handlebars templates to avoid issues with foreign characters.
* Updated admin class to delete locations transient when Primary Settings are saved to re-generate when Data Source is changed.

= 1.3.10 =
* Added optional Google Maps API key setting under Primary Settings.
* Added query string parameters string and key/val pair array to bh_sl_gmap filter.
* Fixed compatibility issue with WPML when using multiple domains.
* Fixed wp_enqueue_script deps parameters in a couple of instances.

= 1.3.9 =
* Fixed undefined JS issue with previous update.

= 1.3.8 =
* Added ability to override data path and type with shortcode attributes datapath and datatype.

= 1.3.7 =
* Fixed issue with geocoding region parameter.
* Fixed issue with Full map start list limit default setting. Switched -1 default to 0.
* Updated Tested up to WordPress version to 4.5.

= 1.3.6 =
* Added check for WP_DEBUG to trigger jQuery plugin debug mode if enabled.
* Added post ID variable to bh_sl_location_data filter.
* Fixed issue with category marker images in which not setting a marker image could cause display issues with all markers.
* Updated Over 1,000 location query to use custom database table.

= 1.3.5 =
* Fixed geocode encoding issue with hashes in address fields.
* Fixed issue with geocode error handling.
* Minor WP_Query call optimizations.

= 1.3.4 =
* Fixed hard-coded postmeta prefixes in bh_storelocator_posts_query_ajax method.

= 1.3.3 =
* Exposed jQuery plugin callbacks.
* Removed check from createMarker method that removed spaces from categories - created issues with categories that have spaces.
* Re-worked handling of no results.
* Updated createMarker method to ensure custom category marker images are converted to integers if strings are passed for dimensions.
* Updated autoGeocode and default location functionality so that max distance is applied on initial load.

= 1.3.2 =
* Added custom location table row count to system information support tab.
* Fixed issue where custom category images weren't being output correctly to the jQuery plugin.
* Fixed issue in which 0 couldn't be saved as a setting value.
* Fixed issue with Location Category images where URLs weren't inserted when the the Link URL was empty.

= 1.3.1 =
* Added license check to avoid update issues after site migration and URL change.

= 1.3.0 =
* Added bh_sl_location_data filter so location data can be manipulated if needed.
* Added new Search on map drag setting under Primary Settings, which does a new search after the map is dragged.
* Added new Geocode button setting under Structure Settings, which allows you to bind a button to the HTML geolocation API.
* Changed postal code sanitization filter so that letters are allowed instead of just integers.
* Fixed pagination jQuery bubbling issue.
* Fixed pagination issues with autoGeocode combination.
* Fixed issues with Full map start list limit setting in combination with a different store limit.
* Fixed issues with no results where clicking the marker would display data from the previous result and clicking the location list item would throw an error.
* Fixed issues with Visible markers list setting and location list background colors and selection.
* Minor PHP formatting updates.

= 1.2.1 =
* Added ability to override lat/lng coordinates with 'latitude' and 'longitude' meta keys with default CPT.
* Added excerpt to output location data.
* Added featured image URL to output location data.
* Added filter bh_sl_featured_img for output featured image URL size.
* Added functionality to output any custom taxonomy values applied to the location data (this also fixed filtering with other custom taxonomies).
* Added functionality to insert coordinates into database when using the WordPress Importer plugin.
* Fixed issue where post data wasn't being reset in enqueue_scripts method.
* Fixed missing argument warning in bh_storelocator_check_db_table method.
* Fixed Postal typo in post meta label.
* Removed extra wp_clear_scheduled_hook from bh-store-locator-db.php that was left in from testing.

= 1.2.0 =
* Set up a new method for handling over 1,000 location posts with a custom, indexed database table.
* Set up functionality to migrate existing coordinates into the new table with wp_cron.
* Newly added or updated location posts will now send coordinates to the custom table.

= 1.1.1 =
* Fixed JS issue with new full map start location list limit where clicking on a marker that didn't have a list item
displayed caused an error.
* Fixed jQuery issue with settings combination of inline directions and default location.
* Reverted jQuery change to new list limit so that it's always applied with full map start enabled.

= 1.1.0 =
* Added new selected marker image options to highlight clicked marker under style settings.
* Added Google Places autocomplete option under primary settings.
* Added full map start location list limit setting under primary settings.
* Increased location data transient expiration.

= 1.0.2 =
* Added permalink to output location data for use in Handlebars templates.
* Switched Handlebars templates so that the name uses triple-stash because data is already escaped (special characters)

= 1.0.1 =
* Removed code that temporarily hid the map and results, when there are no results, in favor of just displaying the no
results message and empty map.

= 1.0.0 =
The first version

== Updates ==

Automatic updates are available with a valid license.
