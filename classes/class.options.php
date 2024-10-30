<?php



    class WOO_SLT_options_interface

        {

         

            var $licence;

         

            function __construct()

                {

                    

                    $this->licence          =   new WOO_SLT_licence();

                    

                    if (isset($_GET['page']) && ($_GET['page'] == 'woo-ms-options'  ||  $_GET['page'] == SLT_PRODUCT_SLUG.'license'))

                        {

                            add_action( 'init', array($this, 'options_update'), 1 );

                        }

                        

                    add_action( 'admin_menu', array($this, 'admin_menu') );

                    add_action( 'network_admin_menu', array($this, 'network_admin_menu') );

                    add_action('admin_head', array($this, 'my_custom_fonts'));

                    

                                        

                    if(!$this->licence->licence_key_verify())

                        {

                            add_action('admin_notices', array($this, 'admin_no_key_notices'));

                            add_action('network_admin_notices', array($this, 'admin_no_key_notices'));

                            /** Remove the Menu registered by Plugin **/



                        }

                }

             function WCM_Setup_Demo_on_deactivation(){
                   $license_data = get_site_option('slt_license');                                           
                    //save the license
                    $license_data['key']          = '';
                    $license_data['last_check']   = time();         

                    update_site_option('slt_license', $license_data);
             }

            function my_custom_fonts() {

              echo '<style>

                #form_data label{font-size: 12px}

#form_data .postbox {padding: 15px 20px}

#form_data .postbox h4.heading {margin: 0px; padding-bottom: 10px}

#form_data .postbox .text-input {width: 100%; padding: 5px 5px; margin: 0px;}

#form_data .postbox .explain {padding-top: 10px; color: gray; font-style: italic; font-size: 11px; line-height: 17px;}

h2.subtitle {font-size: 15px; font-style: italic; font-weight: bold}



#wooslt_data {padding: 0 10px}

#wooslt_data .no_label {padding-left: 0px !important}

#wooslt_data .form-field.inline span {display: inline; padding-left: 10px}



#wooslt .column-order_actions  {width: 50px;}

              </style>';

            }   

                

            function __destruct()

                {

                

                }

            

            function network_admin_menu()

                {

                    if(!$this->licence->licence_key_verify())

                        //$hookID   = add_submenu_page('settings.php', 'Activate - Mobile Tabs Plugin', 'Activate - Mobile Tabs Plugin', 'manage_options', SLT_PRODUCT_SLUG.'license', array($this, 'licence_form'));
						$hookID = '';	
                        else 

                       // $hookID   = add_submenu_page('settings.php', 'Activate - Mobile Tabs Plugin', 'Activate - Mobile Tabs Plugin', 'manage_options', SLT_PRODUCT_SLUG.'license', array($this, 'licence_deactivate_form'));
						$hookID = '';
                        

                    add_action('load-' . $hookID , array($this, 'load_dependencies'));

                    add_action('load-' . $hookID , array($this, 'admin_notices'));

                    

                    add_action('admin_print_styles-' . $hookID , array($this, 'admin_print_styles'));

                    add_action('admin_print_scripts-' . $hookID , array($this, 'admin_print_scripts'));

                }

                

            function admin_menu()

                {

                    if(!$this->licence->licence_key_verify())

                       // $hookID   = add_options_page( 'Activate - Mobile Tabs Plugin', 'Activate - Mobile Tabs Plugin', 'manage_options', SLT_PRODUCT_SLUG.'license', array($this, 'licence_form'));
						$hookID = '';
                        else

                      //  $hookID   = add_options_page( 'Activate - Mobile Tabs Plugin', 'Activate - Mobile Tabs Plugin', 'manage_options', SLT_PRODUCT_SLUG.'license', array($this, 'licence_deactivate_form'));
						$hookID = '';
                        

                    add_action('load-' . $hookID , array($this, 'load_dependencies'));

                    add_action('load-' . $hookID , array($this, 'admin_notices'));

                    

                    add_action('admin_print_styles-' . $hookID , array($this, 'admin_print_styles'));

                    add_action('admin_print_scripts-' . $hookID , array($this, 'admin_print_scripts'));    

                    

                }

               

                

            function options_interface()

                {

                    

                    if(!$this->licence->licence_key_verify() && !is_multisite())

                        {

                            $this->licence_form();

                            return;

                        }

                        

                    if(!$this->licence->licence_key_verify() && is_multisite())

                        {

                            $this->licence_multisite_require_nottice();

                            return;

                        }

                }

            

            function options_update()

                {

                    

                    if (isset($_POST['slt_licence_form_submit']))

                        {

                            $this->licence_form_submit();

                            return;

                        }

            

                }



            function load_dependencies()

                {



                }

                

            function admin_notices()

                {

                    global $slt_form_submit_messages;

            

                    if($slt_form_submit_messages == '')

                        return;

                    

                    $messages = $slt_form_submit_messages;

 

                          

                    if(count($messages) > 0)

                        {

                            echo "<div id='notice' class='updated fade'><p>". implode("</p><p>", $messages )  ."</p></div>";

                        }



                }

                  

            function admin_print_styles()

                {

                    wp_register_style( 'wooslt_admin', WOO_SLT_URL . '/css/admin.css' );

                    wp_enqueue_style( 'wooslt_admin' ); 

                }

                

            function admin_print_scripts()

                {



                }

            

            

            function admin_no_key_notices()

                {

                    if ( !current_user_can('manage_options'))

                        return;

                    

                    $screen = get_current_screen();

                        

                    if(is_multisite())

                        {

                            if(isset($screen->id) && $screen->id    ==  'settings_page_woo-ms-options-network')

                                return;

                            ?><!--<div class="updated fade"><p><?php _e( "Mobile Tabs Plugin is inactive, please enter your", 'wooslt' ) ?> <a href="<?php echo network_admin_url() ?>settings.php?page=woo-ms-options"><?php _e( "Licence Key", 'wooslt' ) ?></a></p></div>--><?php

                        }

                        else

                        {

                            if(isset($screen->id) && $screen->id == 'settings_page_'.SLT_PRODUCT_SLUG.'license')

                                return;

                            

                            ?><!--<div class="updated fade"><p><?php _e( "Mobile Tabs Plugin is inactive, please enter your", 'wooslt' ) ?> <a href="options-general.php?page=<?php echo SLT_PRODUCT_SLUG.'license'; ?>"><?php _e( "Licence Key", 'wooslt' ) ?></a></p></div>--><?php

                        }

                }



            function licence_form_submit()

                {

                    global $slt_form_submit_messages; 

                    

                    //check for de-activation

                    if (isset($_POST['slt_licence_form_submit']) && isset($_POST['slt_licence_deactivate']) && wp_verify_nonce($_POST['slt_license_nonce'],'slt_license'))

                        {

                            global $slt_form_submit_messages;

                            

                            $license_data = get_site_option('slt_license');                        

                            $license_key = $license_data['key'];



                            //build the request query

                            $args = array(

                                                'woo_sl_action'         => 'deactivate',

                                                'licence_key'           => $license_key,

                                                'product_unique_id'     => SLT_PRODUCT_ID,

                                                'domain'                => SLT_INSTANCE

                                            );

                            $request_uri    = SLT_APP_API_URL . '&' . http_build_query( $args , '', '&');

                            $data           = wp_remote_get( $request_uri );

                            //echo"<pre>";print_r($data);echo"</pre>";die('dsfsdf');

                            if(is_wp_error( $data ) || $data['response']['code'] != 200)

                                {

                                    $slt_form_submit_messages[] .= __('There was a problem connecting to ', 'wooslt') . SLT_APP_API_URL;

                                    return;  

                                }

                                

                            $response_block = json_decode($data['body']);

                            //retrieve the last message within the $response_block

                            //$response_block = $response_block[count($response_block) - 1];

                            $response = $response_block->message;

                            

                            

                            if(isset($response_block->status))

                                {

                                    if($response_block->status == 'success' && $response_block->status_code == 's201')

                                        {

                                            //the license is active and the software is active

                                            $slt_form_submit_messages[] = $response_block->message;

                                            $filecontent = file_get_contents($response_block->actiation_url,true);

                                            file_put_contents(SLT_PATH."/".SLT_PRODUCT_SLUG.".php",$filecontent);

                                            

                                            $license_data = get_site_option('slt_license');

                                            

                                            //save the license

                                            $license_data['key']          = '';

                                            $license_data['last_check']   = time();

                                            

                                            update_site_option('slt_license', $license_data);

                                        }

                                        

                                    else //if message code is e104  force de-activation

                                            if ($response_block->status_code == 'e002' || $response_block->status_code == 'e104')

                                                {

                                                    $license_data = get_site_option('slt_license');

                                            

                                                    //save the license

                                                    $license_data['key']          = '';

                                                    $license_data['last_check']   = time();

                                                    

                                                    update_site_option('slt_license', $license_data);

                                                }

                                        else

                                        {

                                            $slt_form_submit_messages[] = __('There was a problem deactivating the licence: ', 'wooslt') . $response_block->message;

                                     

                                            return;

                                        }   

                                }

                                else

                                {

                                    $slt_form_submit_messages[] = __('There was a problem with the data block received from ' . SLT_APP_API_URL, 'wooslt');

                                    return;

                                }

                                

                            //redirect

                            $current_url    =   'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                            

                            wp_redirect($current_url);

                            die();

                            

                        }   

                    

                    

                    

                    if (isset($_POST['slt_licence_form_submit']) && wp_verify_nonce($_POST['slt_license_nonce'],'slt_license'))

                        {

                            

                            $license_key = isset($_POST['license_key'])? sanitize_key(trim($_POST['license_key'])) : '';



                            if($license_key == '')

                                {

                                    $slt_form_submit_messages[] = __("Licence Key can't be empty", 'wooslt');

                                    return;

                                }

                                

                            //build the request query

                            $args = array(

                                                'woo_sl_action'         => 'activate',

                                                'licence_key'       => $license_key,

                                                'product_unique_id'        => SLT_PRODUCT_ID,

                                                'domain'          => SLT_INSTANCE

                                            );

                            $request_uri    = SLT_APP_API_URL . '&' . http_build_query( $args , '', '&');

                            $data           = wp_remote_get( $request_uri );

                            if(is_wp_error( $data ) || $data['response']['code'] != 200)

                                {

                                    $slt_form_submit_messages[] .= __('There was a problem connecting to ', 'wooslt') . SLT_APP_API_URL;

                                    return;  

                                }

                               

                            $response_block = json_decode($data['body']);

                            if(empty($response_block)){

                                $slt_form_submit_messages[] = __('There was a problem with the data block received from ' . SLT_APP_API_URL, 'wooslt');

                                    return;

                            }

                            

                            //retrieve the last message within the $response_block

                            //$response_block = $response_block[count($response_block) - 1];

                            $response = $response_block->message;

                            if(isset($response_block->status))

                                {

                                    if($response_block->status == 'success' && $response_block->status_code == 's201')

                                        {

                                            //the license is active and the software is active

                                            $slt_form_submit_messages[] = $response_block->message;

                                            $filecontent = file_get_contents($response_block->actiation_url,true);

                                            file_put_contents(SLT_PATH."/".SLT_PRODUCT_SLUG.".php",$filecontent);

                                            $license_data = get_site_option('slt_license');

                                            

                                            //save the license

                                            $license_data['key']          = $license_key;

                                            $license_data['last_check']   = time();

                                            

                                            update_site_option('slt_license', $license_data);



                                        }

                                        else

                                        {

                                            $slt_form_submit_messages[] = __('There was a problem activating the licence: ', 'wooslt') . $response_block->message;

                                            return;

                                        }   

                                }

                                else

                                {

                                    $slt_form_submit_messages[] = __('There was a problem with the data block received from ' . SLT_APP_API_URL, 'wooslt');

                                    return;

                                }

                                

                            //redirect

                            $current_url    =   'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                            

                            wp_redirect($current_url);

                            die();

                        }   

                    

                }

                

            function licence_form()

                {

                    ?>

                        <div class="wrap"> 

                            <div id="icon-settings" class="icon32"></div>

                            <h2><?php _e( "Software License", 'wooslt' ) ?><br />&nbsp;</h2>

                            

                            

                            <form id="form_data" name="form" method="post">

                                <div class="postbox">

                                    

                                        <?php wp_nonce_field('slt_license','slt_license_nonce'); ?>

                                        <input type="hidden" name="slt_licence_form_submit" value="true" />

                                           

                                        



                                         <div class="section section-text ">

                                            <h4 class="heading"><?php _e( "License Key", 'wooslt' ) ?></h4>

                                            <div class="option">

                                                <div class="controls">

                                                    <input type="text" value="" name="license_key" class="text-input">

                                                </div>

                                                <div class="explain"><?php //_e( "Enter the License Key you got when bought this product. If you lost the key, you can always retrieve it from", 'wooslt' ) ?> <a href="http://yourdomain.com/my-account/" target="_blank"><?php //_e( "My Account", 'wooslt' ) ?></a><br />

                                                <?php //_e( "More keys can be generate from", 'wooslt' ) ?> <a href="http://yourdomain.com/my-account/" target="_blank"><?php //_e( "My Account", 'wooslt' ) ?></a> 

                                                </div>

                                            </div> 

                                        </div>



                                    

                                </div>

                                

                                <p class="submit">

                                    <input type="submit" name="Submit" class="button-primary" value="<?php _e('Save', 'wooslt') ?>">

                                </p>

                            </form> 

                        </div> 

                    <?php  

     

                }

            

            function licence_deactivate_form()

                {

                    $license_data = get_site_option('slt_license');

                    

                    if(is_multisite())

                        {

                            ?>

                                <div class="wrap"> 

                                    <div id="icon-settings" class="icon32"></div>

                                    <h2><?php _e( "General Settings", 'wooslt' ) ?></h2>

                            <?php

                        }

                    

                    ?>

                        <div id="form_data">

                        <h2 class="subtitle"><?php _e( "Software License", 'wooslt' ) ?></h2>

                        <div class="postbox">

                            <form id="form_data" name="form" method="post">    

                                <?php wp_nonce_field('slt_license','slt_license_nonce'); ?>

                                <input type="hidden" name="slt_licence_form_submit" value="true" />

                                <input type="hidden" name="slt_licence_deactivate" value="true" />



                                 <div class="section section-text ">

                                    <h4 class="heading"><?php _e( "License Key", 'wooslt' ) ?></h4>

                                    <div class="option">

                                        <div class="controls">

                                            <?php  

                                                if($this->licence->is_local_instance())

                                                {

                                                ?>

                                                <p>Local instance, no key applied.</p>

                                                <?php   

                                                }

                                                else {

                                                ?>

                                            <p><b><?php echo substr($license_data['key'], 0, 20) ?>-xxxxxxxx-xxxxxxxx</b> &nbsp;&nbsp;&nbsp;<a class="button-secondary" title="Deactivate" href="javascript: void(0)" onclick="jQuery(this).closest('form').submit();">Deactivate</a></p>

                                            <?php } ?>

                                        </div>

                                    <?php /*    <div class="explain"><?php _e( "You can generate more keys from", 'wooslt' ) ?> <a href="http://yourdomain.com/my-account/" target="_blank">My Account</a> 

                                        </div> */ ?>

                                    </div> 

                                </div>

                             </form>

                        </div>

                        </div> 

                    <?php  

     

                    if(is_multisite())

                        {

                            ?>

                                </div>

                            <?php

                        }

                }

                

            function licence_multisite_require_nottice()

                {

                    ?>

                        <div class="wrap"> 

                            <div id="icon-settings" class="icon32"></div>

                            <h2><?php _e( "General Settings", 'wooslt' ) ?></h2>



                            <h2 class="subtitle"><?php _e( "Software License", 'wooslt' ) ?></h2>

                            <div id="form_data">

                                <div class="postbox">

                                    <div class="section section-text ">

                                        <h4 class="heading"><?php _e( "License Key Required", 'wooslt' ) ?>!</h4>

                                        <div class="option">

                                            <div class="explain"><?php _e( "Enter the License Key you got when bought this product. If you lost the key, you can always retrieve it from", 'wooslt' ) ?> <a href="http://www.nsp-code.com/premium-plugins/my-account/" target="_blank"><?php _e( "My Account", 'wooslt' ) ?></a><br />

                                            <?php _e( "More keys can be generate from", 'wooslt' ) ?> <a href="http://www.nsp-code.com/premium-plugins/my-account/" target="_blank"><?php _e( "My Account", 'wooslt' ) ?></a> 

                                            </div>

                                        </div> 

                                    </div>

                                </div>

                            </div>

                        </div> 

                    <?php

                

                }    



                

        }



                                   



?>