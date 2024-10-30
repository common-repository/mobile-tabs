<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*

Plugin Name: Mobile Tabs

Plugin URI: https://www.mobile-tabs.com

Description: Mobile Tabs Plugin visible social media on mobile view

Version: 4.5

Author: Gico Tech

Author URI: https://www.mobile-tabs.com

License: GPL2

*/
define('SLT_PATH', plugin_dir_path(__FILE__));

define('WOO_SLT_URL', plugins_url('', __FILE__));

define('SLT_APP_API_URL', 'https://mobiletabs.co/index.php?option=com_license&task=license.activate_plugin');

register_deactivation_hook( __FILE__, array('WOO_SLT_options_interface','WCM_Setup_Demo_on_deactivation') );

define('SLT_VERSION', '4.5');

define('SLT_DB_VERSION', '1.0');

define('SLT_PRODUCT_ID', '1');

define('SLT_PRODUCT_SLUG', 'mobile_tabs');

define('SLT_INSTANCE', str_replace(array ("https://" , "http://"), "", network_site_url()));

include_once(SLT_PATH . 'classes/class.licence.php');

include_once(SLT_PATH . 'classes/class.options.php');

include_once(SLT_PATH . 'classes/class.wooslt.php');

include_once(SLT_PATH . 'classes/class.updater.php');

global $WOO_SLT;

$WOO_SLT = new WOO_SLT();

ini_set("display_errors", 1);
if(!class_exists('Mobile_Tabs')) {

	require_once(sprintf("%s/settings.php", dirname(__FILE__)));
	new Mobile_Tabs_Settings;

	class Mobile_Tabs {

		public function __construct() {
			
			
			
			
			//* TN - Remove Query String from Static Resources
			function remove_css_js_ver( $src ) {
			if( strpos( $src, '?ver=' ) )
			$src = remove_query_arg( 'ver', $src );
			return $src;
			}
			add_filter( 'style_loader_src', 'remove_css_js_ver', 10, 2 );
			add_filter( 'script_loader_src', 'remove_css_js_ver', 10, 2 ); 
			
			

			// Initialize Settings
			$plugin = plugin_basename(__FILE__);

			add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link' ));
			add_action( 'plugins_loaded', array($this,'load'));
			//add_action( 'wp_enqueue_scripts', array($this,'enqeue_script'), 1 );
			add_action( 'wp_footer', array($this,'enqeue_script'), 1 );
			add_action('init',array($this,'plugin_init'));
			
            
            
			add_filter( 'woocommerce_add_to_cart_fragments',  array($this,'cart_count_fragments'));
			register_activation_hook(__FILE__, array($this, 'activate'));
			register_deactivation_hook(__FILE__, array($this, 'deactivate'));

		} // END public function __construct

		public function load() {
			

	    	if( is_admin() && isset($_GET['page']) && $_GET['page'] == 'mobile_tabs' ) {

	    		add_action('admin_print_scripts', array($this,'my_admin_scripts'));
	            add_action('admin_print_styles',  array($this,'my_admin_styles'));
	        }
	    }
		public function plugin_init(){
			add_action( 'wp_head', array($this,'enqeue_script_head_script'));
		}

		public function cart_count_fragments( $fragments ) {
		    
		    $fragments['span.header-cart-count'] = '<span class="header-cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
		    
		    return $fragments;
		    
		}
        

		/** * Activate the plugin */
		public function activate() {

			global $wpdb;
			$sql = array();
		    $table_name = $wpdb->prefix . "mobile_tab_data"; 
		    $charset_collate = $wpdb->get_charset_collate();

			$sql[] = "CREATE TABLE $table_name (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`tab_option` varchar(22) NOT NULL,
			`type_of_tabs` varchar(255) NOT NULL,
			`row_text_name` text NOT NULL,
			`row_pop_img` varchar(255) NOT NULL,
			`row_text_link` text NOT NULL,
			`row_text_image_height` varchar(255) NOT NULL,
			`row_text_share_data` text NOT NULL,
			`row_text_optional` text NOT NULL,
			`row_text_shortcode` text NOT NULL,
			`row_text_time` text NOT NULL,
			`row_text_popup_time` text NOT NULL,
			`row_textarea` text NOT NULL,
			`row_text_timer` text NOT NULL,
			`row_text_product` text NOT NULL,
			`row_text_display` text NOT NULL,
			`pop_border_clr_check` varchar(255) NOT NULL,
			`pop_border_clr` varchar(255) NOT NULL,
			`row_text_mobile_display` text NOT NULL,
			`popup_field_daily` text NOT NULL,
			`product_field_daily` text NOT NULL,
			`row_text_pop_image` varchar(255) NOT NULL,
			`row_text_popup_image_time` varchar(255) NOT NULL,
			`row_pop_img_textarea` text NOT NULL,
			`popup_image_field_daily` varchar(255) NOT NULL,
			`row_text_pop_video` varchar(255) NOT NULL,
			`row_text_popup_video_time` varchar(255) NOT NULL,
			`row_pop_video_textarea` text NOT NULL,
			`popup_video_field_daily` varchar(255) NOT NULL,
			`row_text_share_data_text` text NOT NULL,
			`icon_back_clr` text NOT NULL,
			`remove_color` varchar(255) NOT NULL,
			PRIMARY KEY (`id`) ) $charset_collate;";

			$table_name = $wpdb->prefix . "mobile_tab"; 

		   	$charset_collate = $wpdb->get_charset_collate();

		   	$sql[] = "CREATE TABLE $table_name (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`background_type` varchar(255) NOT NULL,
			`background_color` varchar(255) NOT NULL,
			`background_image` varchar(255) NOT NULL,
			`margin_set` varchar(255) NOT NULL,
			`font_size` varchar(45) NOT NULL,
			`z_index` varchar(45) NOT NULL,
			`tracking` int(11) NOT NULL,
			`background_direction` int(11) NOT NULL,
			`excluded_pages` text NOT NULL,
			`top_left_radius` varchar(255) NOT NULL,
			`top_right_radius` varchar(255) NOT NULL,
			`bottom_left_radius` varchar(255) NOT NULL,
			`bottom_right_radius` varchar(255) NOT NULL,
			`round_button_desktop` varchar(255) NOT NULL,
			`round_button_mobile` varchar(255) NOT NULL,
			`round_column` varchar(255) NOT NULL,
			`one_icon_check` varchar(255) NOT NULL,
			`one_icon_back_clr` varchar(255) NOT NULL,
			`choose_icon_for_one_icon` varchar(255) NOT NULL,
			PRIMARY KEY (`id`)

			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

			foreach ($sql as $q) {
	            dbDelta( $q );
	        }
		} // END public static function activate

		/** * Deactivate the plugin */
		public function deactivate() {

			global $wpdb;
			$sql = array();
			$table_name = $wpdb->prefix . "mobile_tab"; 
			$sql[] = "DROP TABLE IF EXISTS $table_name;";
			$table_name = $wpdb->prefix . "mobile_tab_data"; 
			$sql[] = "DROP TABLE IF EXISTS $table_name;";
			
			foreach ($sql as $q) {
	            $wpdb->query($q);
	        }
		} // END public static function deactivate

		// Add the settings link to the plugins page

		

	    public function my_admin_scripts() {

	    	// jQuery
			wp_enqueue_script('jquery');

			// This will enqueue the Media Uploader script
			wp_enqueue_media();
            wp_enqueue_script(  'mtabs_admininall', plugins_url( '/assets/js/allindex.js', __FILE__ ), array( 'jquery' ) );
            

	    }

	    public function my_admin_styles()  { 

	    	wp_enqueue_style( 'mtabs_select_css', plugins_url( '/assets/css/select2.min.css', __FILE__ ) );
	    	wp_enqueue_style( 'mtabs_tooltip_css', plugins_url( '/assets/css/tipTip.css', __FILE__ ) );
	    	wp_enqueue_style( 'mtabs-font-awesome', plugins_url( '/assets/css/font-awesome/css/font-awesome.min.css', __FILE__ ) );
	    }

	    public function enqeue_script() {

	        //wp_enqueue_script("jquery");
	       // wp_enqueue_script( 'mtabs_index', plugins_url('assets/js/index.js', __FILE__), array( 'jquery' ) );
		   //	wp_enqueue_script( 'jquery' );
		   //	https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js
		   wp_enqueue_script( 'mtabs_index2', plugins_url('assets/js/index.js', __FILE__), array ( 'jquery' ), 1.1, true);
		   //	wp_enqueue_script( 'mtabs_index2', plugins_url('assets/js/index.js', __FILE__), array ( 'jquery' ), 1.1, true);
			//wp_register_script( 'mtabs_index', plugins_url('assets/js/index.js', __FILE__), false, NULL, false );
            //wp_enqueue_script( 'mtabs_index' );

	        wp_enqueue_style( 'mtabs_css', plugins_url('assets/css/style.css', __FILE__) );
	        wp_enqueue_style( 'mtabs_tooltip_css', plugins_url( '/assets/css/tipTip.css', __FILE__ ) );
	    }
		public function enqeue_script_head_script(){
			
			?>
			<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js'></script>
           <script type='text/javascript' src='<?php echo WOO_SLT_URL; ?>/assets/js/index.js'></script>
           
          <?php
		}

		public function plugin_settings_link($links) {

			$settings_link = '<a href="options-general.php?page=mobile_tabs">Settings</a>';
			array_unshift($links, $settings_link);
			return $links;
		}

	} // END class WP_Plugin_Template

	// instantiate the plugin class

	$mobile_tabs = new Mobile_Tabs();

} // END if(!class_exists('mobile_Tabs'))