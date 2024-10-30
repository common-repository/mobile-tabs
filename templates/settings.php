<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wpdb;
$message = 0;

function mtabs_pr_pages($name,$value='') {

    global $post;
    $args = array( 'numberposts' => -1, 'post_type' => 'product' );
    $posts = get_posts($args);
    ?>
    <select name="<?php echo $name ?>" class="select2"> <?php foreach( $posts as $post ) : setup_postdata($post); ?> <option value="<? echo $post->ID; ?>" <?php echo  $post->ID == $value ?'selected':'' ?> ><?php the_title(); ?></option> <?php endforeach; ?> </select> <?php 
}

echo '<div class="wrap"><h2 style="background:url('.plugins_url('mtabs_logo.png', dirname(__FILE__) ).') no-repeat left;padding-left:50px;line-height:60px">Mobile Tabs - 4.0</h2><hr />';

if (isset($_REQUEST['delete_row']) && wp_verify_nonce($_REQUEST['delete_row'], 'delete_row'))  {        
    
    $Delete_Id= $_REQUEST["id"];

    if(!empty($Delete_Id)) {

        global $wpdb;
        $wpdb->delete( $wpdb->prefix.'mobile_tab_data', array( 'id' => $Delete_Id ), array( '%d' ) );
        $message =2;
    }
}

if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'mobile-tabs-save-nonce')) {

    $delete = $wpdb->query("TRUNCATE TABLE `".$wpdb->prefix."mobile_tab_data`");
    $delete1 = $wpdb->query("TRUNCATE TABLE `".$wpdb->prefix."mobile_tab`");
    $count = sanitize_text_field($_POST['count']);
	
    $mobile_tab_backgroundRadio = sanitize_text_field($_POST['mobile_tab_backgroundRadio']);

    if($mobile_tab_backgroundRadio =='color') {

        $mobile_tab_background_images = '';
        $mobile_tabs_background_color = sanitize_text_field($_POST['mobile_tabs_background_color']);
    } elseif ($mobile_tab_backgroundRadio =='image') {

        $mobile_tabs_background_color = '';
        $mobile_tab_background_images = sanitize_text_field($_POST['mobile_tab_background_images']);
    } elseif ($mobile_tab_backgroundRadio =='none') {

        $mobile_tab_background_images = '';
        $mobile_tabs_background_color = '';
    }

    $background_direction = sanitize_text_field($_POST['direction']);
	
	if(isset($_POST['top_left_radius'])) {
        $top_left_radius = sanitize_text_field($_POST['top_left_radius']);
    } else {
        $top_left_radius = '';
    }
	
	if(isset($_POST['top_right_radius'])) {
        $top_right_radius = sanitize_text_field($_POST['top_right_radius']);
    } else {
        $top_right_radius = '';
    }

	if(isset($_POST['bottom_left_radius'])) {
        $bottom_left_radius = sanitize_text_field($_POST['bottom_left_radius']);
    } else {
        $bottom_left_radius = '';
    }	
	
	if(isset($_POST['bottom_right_radius'])) {
        $bottom_right_radius = sanitize_text_field($_POST['bottom_right_radius']);
    } else {
        $bottom_right_radius = '';
    }
	
	if(isset($_POST['round_button_desktop'])) {
        $round_button_desktop = sanitize_text_field($_POST['round_button_desktop']);
    } else {
        $round_button_desktop = '';
    }
	
	if(isset($_POST['round_button_mobile'])) {
        $round_button_mobile = sanitize_text_field($_POST['round_button_mobile']);
    } else {
        $round_button_mobile = '';
    }
	
	if(isset($_POST['round_column'])) {
        $round_column = sanitize_text_field($_POST['round_column']);
    } else {
        $round_column = '';
    }
	
	
	if(isset($_POST['round_column'])) {
        $round_column = sanitize_text_field($_POST['round_column']);
    } else {
        $round_column = '';
    }
	
	
	if(isset($_POST['one_icon_check'])) {
        $one_icon_check = sanitize_text_field($_POST['one_icon_check']);
    } else {
        $one_icon_check = '';
    }
	
	if(isset($_POST['one_icon_back_clr'])) {
        $one_icon_back_clr = sanitize_text_field($_POST['one_icon_back_clr']);
    } else {
        $one_icon_back_clr = '';
    }
	
	if(isset($_POST['choose_icon_for_one_icon'])) {
        $choose_icon_for_one_icon = sanitize_text_field($_POST['choose_icon_for_one_icon']);
    } else {
        $choose_icon_for_one_icon = '';
    }
	
	
    /* Insert settings options into the DB */
    $wpdb->insert($wpdb->prefix.'mobile_tab', array('background_type' => $mobile_tab_backgroundRadio, 'background_color' => $mobile_tabs_background_color, 'background_image' => $mobile_tab_background_images, 'margin_set' => '10px', 'font_size' => '12px', 'z_index' => 999999, 'tracking' => 0, 'background_direction' => $background_direction, 'excluded_pages' => '', 'top_left_radius' => $top_left_radius, 'top_right_radius' => $top_right_radius, 'bottom_left_radius' => $bottom_left_radius, 'bottom_right_radius' => $bottom_right_radius, 'round_button_desktop' => $round_button_desktop, 'round_button_mobile' => $round_button_mobile, 'round_column' => $round_column, 'one_icon_check' => $one_icon_check, 'one_icon_back_clr' => $one_icon_back_clr, 'choose_icon_for_one_icon' => $choose_icon_for_one_icon ));

    if( isset($_POST['sortable_field']) && $_POST['sortable_field'] !='' ) {

        $sortable_field = sanitize_text_field($_POST['sortable_field']);
        $sortable = explode( ',', str_replace( 'row-', '', $sortable_field ) );

        foreach ($sortable as $i) {

            $tab_option = sanitize_text_field($_POST['tab_option_'.$i]);
            $type_of_tabs = sanitize_text_field($_POST['type_of_tabs_'.$i]);

            if(isset($_POST['mobile_tab_select_shareicon_'.$i])) {

                $mobile_tab_select_shareicon = $_POST['mobile_tab_select_shareicon_'.$i];
                array_walk($mobile_tab_select_shareicon, function($value, $key) {
                    $value = sanitize_text_field($value);
                });
            }
            
            if($tab_option!='' && $type_of_tabs!='') {

                if ($tab_option =='text') {

                    $row_text_name = sanitize_text_field($_POST['row_text_name_'.$i]);
                    $mobile_tab_images_height = '';
                } elseif ($tab_option =='icon'){

                    $row_text_name = sanitize_text_field($_POST['mobile_tab_select_icon_'.$i]);
                    $mobile_tab_images_height = sanitize_text_field($_POST['mobile_tab_images_height_'.$i]);
                } else {

                    $row_text_name = sanitize_text_field($_POST['row_text_icon_'.$i]);
                    $mobile_tab_images_height = sanitize_text_field($_POST['mobile_tab_images_height_'.$i]);
                }

                if ($mobile_tab_images_height!='') {

                    $mobile_tab_images_height = $mobile_tab_images_height;
                } else {

                    $mobile_tab_images_height = '30px';
                }
				//php for pop image ******************************************************
				if($type_of_tabs == 'image_popup'){
					$row_pop_img = sanitize_text_field($_POST['row_pop_img_'.$i]);
					//$row_pop_img1 = sanitize_text_field($_POST['mobile_tab_select_pop_image_'.$i]);
				}else{
					$row_pop_img = '';
				}	
				
				if(isset($_POST['row_text_pop_image_'.$i])) {
					$row_text_pop_image = sanitize_text_field($_POST['row_text_pop_image_'.$i]);
				}else{
					$row_text_pop_image = '';
				}
				
				if(isset($_POST['row_text_popup_image_time_'.$i])) {
					$row_text_popup_image_time = sanitize_text_field($_POST['row_text_popup_image_time_'.$i]);
				}else{
					$row_text_popup_image_time = '';
				}
				
				if(isset($_POST['row_pop_img_textarea_'.$i])) {
					$row_pop_img_textarea = sanitize_text_field($_POST['row_pop_img_textarea_'.$i]);
				}else{
					$row_pop_img_textarea = '';
				}
				
				
				if(isset($_POST['popup_image_field_daily_'.$i])) {
                    $popup_image_field_daily = 'yes';
                } else {
                    $popup_image_field_daily = 'no';
                }	
				
				
				
				//php for post video popup fields
				if(isset($_POST['row_text_pop_video_'.$i])) {
					$row_text_pop_video = sanitize_text_field($_POST['row_text_pop_video_'.$i]);
				}else{
					$row_text_pop_video = '';
				}
				
				if(isset($_POST['row_text_popup_video_time_'.$i])) {
					$row_text_popup_video_time = sanitize_text_field($_POST['row_text_popup_video_time_'.$i]);
				}else{
					$row_text_popup_video_time = '';
				}
				
				if(isset($_POST['row_pop_video_textarea_'.$i])) {
					$row_pop_video_textarea = sanitize_text_field($_POST['row_pop_video_textarea_'.$i]);
				}else{
					$row_pop_video_textarea = '';
				}
				
				
				if(isset($_POST['popup_video_field_daily_'.$i])) {
                    $popup_video_field_daily = 'yes';
                } else {
                    $popup_video_field_daily = 'no';
                }	
				
				
				//php for popup border color ******************************************************
				if($type_of_tabs == 'popup_form' || $type_of_tabs == 'product_popup' || $type_of_tabs == 'image_popup' || $type_of_tabs == 'video_popup'){
					$pop_border_clr_check = sanitize_text_field($_POST['pop_border_clr_check_'.$i]);
					$pop_border_clr = sanitize_text_field($_POST['pop_border_clr_'.$i]);
				}else{
					$pop_border_clr_check = '';
					$pop_border_clr = '';
				}	
				
				
				
                if ($type_of_tabs=='share') {

                    @$mobile_tab_select_shareicon_impload = implode(',', $mobile_tab_select_shareicon);
                    $mobile_tab_select_sharetext = sanitize_text_field($_POST['mobile_tab_select_sharetext_'.$i]);
                } else {

                    $mobile_tab_select_shareicon_impload = '';
                    $mobile_tab_select_sharetext = '';
                }

                if ($type_of_tabs=='link') {

                    $url = sanitize_text_field($_POST['row_text_link_'.$i]);

                    if (filter_var($url, FILTER_VALIDATE_URL)) {

                        $row_text_link = sanitize_text_field($_POST['row_text_link_'.$i]);

                    } else {

                        $row_text_link = 'http://'.sanitize_text_field($_POST['row_text_link_'.$i]);
                    }
                } else {

                    $row_text_link = sanitize_text_field($_POST['row_text_link_'.$i]);
					//echo"<pre>";print_r($row_text_link); echo"<br>"; die("die2");
                }
                if(isset($_POST['row_text_optional_'.$i])) {

                    $mobile_tab_optional = stripslashes( sanitize_text_field($_POST['row_text_optional_'.$i]) );
                } else {
                    $mobile_tab_optional = '';
                }
                if(isset($_POST['row_text_shortcode_'.$i])) {

                    $row_text_shortcode = stripslashes( sanitize_text_field($_POST['row_text_shortcode_'.$i]) );
                } else {
                    $row_text_shortcode = '';
                }
                if(isset($_POST['row_text_time_'.$i])) {

                    $row_text_time = sanitize_text_field($_POST['row_text_time_'.$i]);
                } else {
                    $row_text_time = '';
                }

                if(isset($_POST['row_text_popup_time_'.$i])) {

                    $row_text_popup_time = sanitize_text_field($_POST['row_text_popup_time_'.$i]);
                } else {
                    $row_text_popup_time = '';
                }

                if(isset($_POST['row_textarea_'.$i])) {

                    $row_textarea = sanitize_text_field($_POST['row_textarea_'.$i]);
                } else {
                    $row_textarea = '';
                }
                if(isset($_POST['row_text_product_'.$i])) {

                    $row_text_product = sanitize_text_field($_POST['row_text_product_'.$i]);
                } else {
                    $row_text_product = '';
                }
                if(isset($_POST['row_text_timer_'.$i])) {

                    $row_text_timer = sanitize_text_field($_POST['row_text_timer_'.$i]);
                    if( $_POST['row_text_timer_'.$i] != '' ) {
                        $time_cc = explode( ':',sanitize_text_field($_POST['row_text_timer_'.$i]));
                        $cc_text_timer = date('Y/m/d H:i:s',strtotime('+'.$time_cc[0].' hour +'.$time_cc[1].' minutes +'.$time_cc[2].' seconds',strtotime(date("Y/m/d H:i:s")  ) ));
                        update_option( 'mtab_cc_timer', $cc_text_timer );
                    }
                } else {
                    $row_text_timer = '';
                }
                if(isset($_POST['row_text_display_'.$i])) {

                    $row_text_display = 'yes';

                } else {
                    $row_text_display = 'no';
                }
				
				
				if(isset($_POST['row_text_mobile_display_'.$i])) {

                    $row_text_mobile_display = 'yes';

                } else {
                    $row_text_mobile_display = 'no';
                }
				
				
				
                if(isset($_POST['popup_field_daily_'.$i])) {

                    $popup_field_daily = 'yes';

                } else {
                    $popup_field_daily = 'no';
                }

                if(isset($_POST['product_field_daily_'.$i])) {

                    $product_field_daily = 'yes';

                } else {
                    $product_field_daily = 'no';
                }

                if(isset($_POST['product_field_daily_'.$i])) {

                    $product_field_daily = 'yes';

                } else {
                    $product_field_daily = 'no';
                }
				
				if(isset($_POST['icon_back_clr_'.$i])) {
                    $icon_back_clr = sanitize_text_field($_POST['icon_back_clr_'.$i]);
					} else {
						$icon_back_clr = '';
					}
				
				if(isset($_POST['remove_color_'.$i])) {
                    $remove_color = sanitize_text_field($_POST['remove_color_'.$i]);
                } else {
                    $remove_color = '';
                }
				
                $wpdb->insert($wpdb->prefix.'mobile_tab_data', array(
				'tab_option' => $tab_option,
				'type_of_tabs' => $type_of_tabs,
				'row_text_name' => $row_text_name,
				'row_pop_img' => $row_pop_img, 
				'row_text_link' => $row_text_link,
				'row_text_image_height' => $mobile_tab_images_height,
				'row_text_share_data' => $mobile_tab_select_shareicon_impload,
				'row_text_share_data_text' => $mobile_tab_select_sharetext,
				'row_text_shortcode' => $row_text_shortcode,
				'row_text_time' => $row_text_time,
				'row_text_popup_time' => $row_text_popup_time,
				'row_text_product' => $row_text_product,
				'row_text_timer' => $row_text_timer,
				'popup_field_daily' => $popup_field_daily, 
				'product_field_daily' => $product_field_daily,
				'row_text_pop_image' => $row_text_pop_image,
				'row_text_popup_image_time' => $row_text_popup_image_time,
				'row_pop_img_textarea' => $row_pop_img_textarea,
				'popup_image_field_daily' => $popup_image_field_daily,
				'row_text_pop_video' => $row_text_pop_video,
				'row_text_popup_video_time' => $row_text_popup_video_time,
				'row_pop_video_textarea' => $row_pop_video_textarea,
				'popup_video_field_daily' => $popup_video_field_daily,
				'row_text_display' => $row_text_display,
				'pop_border_clr_check' => $pop_border_clr_check,
				'pop_border_clr' => $pop_border_clr,
				'row_text_mobile_display' => $row_text_mobile_display, 
				'row_textarea' => $row_textarea,
				'row_text_optional' => $mobile_tab_optional,
				'icon_back_clr' => $icon_back_clr,
				'remove_color' => $remove_color
				));

                $message =1;
            } else {

                $message ='error';
            }
        }
    } else {

        for ($i=1; $i<=$count; $i++) {

            $tab_option = sanitize_text_field($_POST['tab_option_'.$i]);
            $type_of_tabs = sanitize_text_field($_POST['type_of_tabs_'.$i]);

            if(isset($_POST['mobile_tab_select_shareicon_'.$i])) {

                $mobile_tab_select_shareicon = $_POST['mobile_tab_select_shareicon_'.$i];
                array_walk($mobile_tab_select_shareicon, function($value, $key) {
                    $value = sanitize_text_field($value);
                });
            }
            
            if($tab_option!='' && $type_of_tabs!='') {

                if ($tab_option =='text') {

                    $row_text_name = sanitize_text_field($_POST['row_text_name_'.$i]);
                    $mobile_tab_images_height = '';
                } elseif ($tab_option =='icon'){

                    $row_text_name = sanitize_text_field($_POST['mobile_tab_select_icon_'.$i]);
                    $mobile_tab_images_height = sanitize_text_field($_POST['mobile_tab_images_height_'.$i]);
                } else {

                    $row_text_name = sanitize_text_field($_POST['row_text_icon_'.$i]);
                    $mobile_tab_images_height = sanitize_text_field($_POST['mobile_tab_images_height_'.$i]);
                }

                if ($mobile_tab_images_height!='') {

                    $mobile_tab_images_height = $mobile_tab_images_height;
                } else {

                    $mobile_tab_images_height = '30px';
                }
				//php for pop image ******************************************************
				if($type_of_tabs == 'image_popup'){
					$row_pop_img = sanitize_text_field($_POST['row_pop_img_'.$i]);
					//$row_pop_img1 = sanitize_text_field($_POST['mobile_tab_select_pop_image_'.$i]);
				}else{
					$row_pop_img = '';
				}	
				
				if(isset($_POST['row_text_pop_image_'.$i])) {
					$row_text_pop_image = sanitize_text_field($_POST['row_text_pop_image_'.$i]);
				}else{
					$row_text_pop_image = '';
				}
				
				if(isset($_POST['row_text_popup_image_time_'.$i])) {
					$row_text_popup_image_time = sanitize_text_field($_POST['row_text_popup_image_time_'.$i]);
				}else{
					$row_text_popup_image_time = '';
				}
				
				if(isset($_POST['row_pop_img_textarea_'.$i])) {
					$row_pop_img_textarea = sanitize_text_field($_POST['row_pop_img_textarea_'.$i]);
				}else{
					$row_pop_img_textarea = '';
				}
				
				
				if(isset($_POST['popup_image_field_daily_'.$i])) {
                    $popup_image_field_daily = 'yes';
                } else {
                    $popup_image_field_daily = 'no';
                }	
				
				
				
				//php for post video popup fields
				if(isset($_POST['row_text_pop_video_'.$i])) {
					$row_text_pop_video = sanitize_text_field($_POST['row_text_pop_video_'.$i]);
				}else{
					$row_text_pop_video = '';
				}
				
				if(isset($_POST['row_text_popup_video_time_'.$i])) {
					$row_text_popup_video_time = sanitize_text_field($_POST['row_text_popup_video_time_'.$i]);
				}else{
					$row_text_popup_video_time = '';
				}
				
				if(isset($_POST['row_pop_video_textarea_'.$i])) {
					$row_pop_video_textarea = sanitize_text_field($_POST['row_pop_video_textarea_'.$i]);
				}else{
					$row_pop_video_textarea = '';
				}
				
				
				if(isset($_POST['popup_video_field_daily_'.$i])) {
                    $popup_video_field_daily = 'yes';
                } else {
                    $popup_video_field_daily = 'no';
                }	
				
				
				//php for popup border color ******************************************************
				if($type_of_tabs == 'popup_form' || $type_of_tabs == 'product_popup' || $type_of_tabs == 'image_popup' || $type_of_tabs == 'video_popup'){
					$pop_border_clr_check = sanitize_text_field($_POST['pop_border_clr_check_'.$i]);
					$pop_border_clr = sanitize_text_field($_POST['pop_border_clr_'.$i]);
				}else{
					$pop_border_clr_check = '';
					$pop_border_clr = '';
				}	
				
				
				
                if ($type_of_tabs=='share') {

                    @$mobile_tab_select_shareicon_impload = implode(',', $mobile_tab_select_shareicon);
                    $mobile_tab_select_sharetext = sanitize_text_field($_POST['mobile_tab_select_sharetext_'.$i]);
                } else {

                    $mobile_tab_select_shareicon_impload = '';
                    $mobile_tab_select_sharetext = '';
                }

                if ($type_of_tabs=='link') {

                    $url = sanitize_text_field($_POST['row_text_link_'.$i]);

                    if (filter_var($url, FILTER_VALIDATE_URL)) {

                        $row_text_link = sanitize_text_field($_POST['row_text_link_'.$i]);

                    } else {

                        $row_text_link = 'http://'.sanitize_text_field($_POST['row_text_link_'.$i]);
                    }
                } else {

                    $row_text_link = sanitize_text_field($_POST['row_text_link_'.$i]);
					//echo"<pre>";print_r($row_text_link); echo"<br>"; die("die2");
                }
                if(isset($_POST['row_text_optional_'.$i])) {

                    $mobile_tab_optional = stripslashes( sanitize_text_field($_POST['row_text_optional_'.$i]) );
                } else {
                    $mobile_tab_optional = '';
                }
                if(isset($_POST['row_text_shortcode_'.$i])) {

                    $row_text_shortcode = stripslashes( sanitize_text_field($_POST['row_text_shortcode_'.$i]) );
                } else {
                    $row_text_shortcode = '';
                }
                if(isset($_POST['row_text_time_'.$i])) {

                    $row_text_time = sanitize_text_field($_POST['row_text_time_'.$i]);
                } else {
                    $row_text_time = '';
                }

                if(isset($_POST['row_text_popup_time_'.$i])) {

                    $row_text_popup_time = sanitize_text_field($_POST['row_text_popup_time_'.$i]);
                } else {
                    $row_text_popup_time = '';
                }

                if(isset($_POST['row_textarea_'.$i])) {

                    $row_textarea = sanitize_text_field($_POST['row_textarea_'.$i]);
                } else {
                    $row_textarea = '';
                }
                if(isset($_POST['row_text_product_'.$i])) {

                    $row_text_product = sanitize_text_field($_POST['row_text_product_'.$i]);
                } else {
                    $row_text_product = '';
                }
                if(isset($_POST['row_text_timer_'.$i])) {

                    $row_text_timer = sanitize_text_field($_POST['row_text_timer_'.$i]);
                    if( $_POST['row_text_timer_'.$i] != '' ) {
                        $time_cc = explode( ':',sanitize_text_field($_POST['row_text_timer_'.$i]));
                        $cc_text_timer = date('Y/m/d H:i:s',strtotime('+'.$time_cc[0].' hour +'.$time_cc[1].' minutes +'.$time_cc[2].' seconds',strtotime(date("Y/m/d H:i:s")  ) ));
                        update_option( 'mtab_cc_timer', $cc_text_timer );
                    }
                } else {
                    $row_text_timer = '';
                }
                if(isset($_POST['row_text_display_'.$i])) {

                    $row_text_display = 'yes';

                } else {
                    $row_text_display = 'no';
                }
				
				
				if(isset($_POST['row_text_mobile_display_'.$i])) {

                    $row_text_mobile_display = 'yes';

                } else {
                    $row_text_mobile_display = 'no';
                }
				
				
				
                if(isset($_POST['popup_field_daily_'.$i])) {

                    $popup_field_daily = 'yes';

                } else {
                    $popup_field_daily = 'no';
                }

                if(isset($_POST['product_field_daily_'.$i])) {

                    $product_field_daily = 'yes';

                } else {
                    $product_field_daily = 'no';
                }

                if(isset($_POST['product_field_daily_'.$i])) {

                    $product_field_daily = 'yes';

                } else {
                    $product_field_daily = 'no';
                }
				
				if(isset($_POST['icon_back_clr_'.$i])) {
                    $icon_back_clr = sanitize_text_field($_POST['icon_back_clr_'.$i]);
					} else {
						$icon_back_clr = '';
					}
				
				if(isset($_POST['remove_color_'.$i])) {
                    $remove_color = sanitize_text_field($_POST['remove_color_'.$i]);
                } else {
                    $remove_color = '';
                }
				
				
                $wpdb->insert($wpdb->prefix.'mobile_tab_data', array(
				'tab_option' => $tab_option,
				'type_of_tabs' => $type_of_tabs,
				'row_text_name' => $row_text_name,
				'row_pop_img' => $row_pop_img, 
				'row_text_link' => $row_text_link,
				'row_text_image_height' => $mobile_tab_images_height,
				'row_text_share_data' => $mobile_tab_select_shareicon_impload,
				'row_text_share_data_text' => $mobile_tab_select_sharetext,
				'row_text_shortcode' => $row_text_shortcode,
				'row_text_time' => $row_text_time,
				'row_text_popup_time' => $row_text_popup_time,
				'row_text_product' => $row_text_product,
				'row_text_timer' => $row_text_timer,
				'popup_field_daily' => $popup_field_daily, 
				'product_field_daily' => $product_field_daily,
				'row_text_pop_image' => $row_text_pop_image,
				'row_text_popup_image_time' => $row_text_popup_image_time,
				'row_pop_img_textarea' => $row_pop_img_textarea,
				'popup_image_field_daily' => $popup_image_field_daily,
				'row_text_pop_video' => $row_text_pop_video,
				'row_text_popup_video_time' => $row_text_popup_video_time,
				'row_pop_video_textarea' => $row_pop_video_textarea,
				'popup_video_field_daily' => $popup_video_field_daily,
				'row_text_display' => $row_text_display,
				'pop_border_clr_check' => $pop_border_clr_check,
				'pop_border_clr' => $pop_border_clr,
				'row_text_mobile_display' => $row_text_mobile_display, 
				'row_textarea' => $row_textarea,
				'row_text_optional' => $mobile_tab_optional,
				'icon_back_clr' => $icon_back_clr,
				'remove_color' => $remove_color
				));

                $message =1;
            } else {

                $message ='error';
            }
        }
    }   
} 

$get_mobile_tabs_datas = $wpdb->get_results('SELECT * from '.$wpdb->prefix.'mobile_tab_data ');
$get_mobile_tabs = $wpdb->get_results('SELECT * from '.$wpdb->prefix.'mobile_tab');

if(empty($get_mobile_tabs)) {
    
    $get_mobile_tabs[0] = (object) array();
    $get_mobile_tabs[0]->background_direction = '';
    $get_mobile_tabs[0]->background_type = '';
    $get_mobile_tabs[0]->background_color = '';
    $get_mobile_tabs[0]->background_image = '';
    $get_mobile_tabs[0]->display = ''; 
}
 // echo"<pre>";
 // print_r($get_mobile_tabs_datas);
$rcdCount = count($get_mobile_tabs_datas);

$dir = plugin_dir_path( dirname(__FILE__) ).'image';

//$scandirs = scandir($dir);
$scandirs = array_diff(scandir($dir), array('..', '.'));

//php code for left right position of sidebar******************
//echo"<pre>";print_r($_POST); 
if(isset($_POST['position']) && $_POST['position'] == 0 ){
	update_option( 'side_position', 0 );
}

?>

<style type="text/css">#wpwrap{background:#fff;}input[type="number"] {
    height: 23px !important;
  }select.tab_option{width:60% !important;} .help-tip{text-align: center; background-color: #ccc; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; line-height: 18px; cursor: default; display: inline-block; } .help-tip:before{content:'?'; font-weight: bold; color:#fff; } .select2-container {width:90% !important; } .alert {padding: 10px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; } .alert h4 {margin-top: 0; color: inherit; } .alert .alert-link {font-weight: bold; } .alert > p, .alert > ul {margin-bottom: 0; margin-top: 0; } .alert > p + p {margin-top: 5px; } .alert-dismissable, .alert-dismissible {padding-right: 35px; } .alert-dismissable .close, .alert-dismissible .close {position: relative; top: -2px; right: -21px; color: inherit; } .alert-success {color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6; } .alert-success hr {border-top-color: #c9e2b3; } .alert-success .alert-link {color: #2b542c; } .alert-info {color: #31708f; background-color: #d9edf7; border-color: #bce8f1; } .alert-info hr {border-top-color: #a6e1ec; } .alert-info .alert-link {color: #245269; } .alert-warning {color: #8a6d3b; background-color: #fcf8e3; border-color: #faebcc; } .alert-warning hr {border-top-color: #f7e1b5; } .alert-warning .alert-link {color: #66512c; } .alert-danger {color: #a94442; background-color: #f2dede; border-color: #ebccd1; } .alert-danger hr {border-top-color: #e4b9c0; } .alert-danger .alert-link {color: #843534; } .wp-admin select { width: 90%;} .main-site-wrapper div input[type="text"], .main-site-wrapper div select, .main-site-wrapper div textarea {

    width: 90%;
    border-radius: 4px;
    padding: 10px;
    min-height: 40px;

}
.select_icon_div img {
    height: 25px;
    width: 25px;
}
.main-site-wrapper div select{-webkit-appearance: button;

-webkit-border-radius: 2px;

-webkit-box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);

-webkit-padding-end: 20px;

-webkit-padding-start: 2px;

-webkit-user-select: none;

background-image: url(), -webkit-linear-gradient(#FAFAFA, #F4F4F4 40%, #E5E5E5);

background-position: 97% center;

background-repeat: no-repeat;

border: 1px solid #AAA;

color: #555;

font-size: inherit;

overflow: hidden;

padding: 5px 10px;

text-overflow: ellipsis;
}
white-space: nowrap;
 .main-site-wrapper div input[type="checkbox"], .main-site-wrapper div input[type="radio"] { width: 16px;} 
input[type="checkbox"]:checked::before { background: #044fb0; color: #fff; width:20px; border-radius: 4px;}input[type="checkbox"] { border-radius: 4px;}
 .main-site-wrapper div .icon_div { width: 50px;} .image_div { height: 15px; width: 15px; margin-top: 5px;} .background-color-div { display: inline-block; vertical-align: middle;} .background-label { display: inline-block; } .wp-picker-container { vertical-align: middle;} .select_icon_div img { height: 18px; width: 18px;} .row-column-row-text-share-field img { height: 20px; width: 20px;} .select_icon_div .img-item {background: #808080 none repeat scroll 0 0; padding: 2px; border: 2px solid #dcdcdc; } .row-column-row-text-share-field img { padding: 2px 0; } .main-site-wrapper .row-column-section .row-column-row-text-share-field label { display: inline-block; margin-bottom: ; padding-bottom: 0; padding: 0 7px;} .main-site-wrapper .row-column-section .row-column-row-text-share-field  input[type="checkbox"], .main-site-wrapper .row-column-section .row-column-row-text-share-field  input[type="radio"] { display: block;}.main-site-wrapper .row-column-section .row-column.row-column-row-text-share-field{display:none;width:12%;} .main-site-wrapper .row-column-section .row-column.row-column-popup-field,.main-site-wrapper .row-column-section .row-column.row-column-product-field,.main-site-wrapper .row-column-section .row-column.row-column-popup-image-field,.main-site-wrapper .row-column-section .row-column.row-column-popup-video-field{ display: none; width:100%;} .main-site-wrapper .row-column-section .row-column.row-column-row-text-shareText-field { display: none; width: 100%;} .select_icon_div .img-item.checked { border: 2px solid #0073aa; } .mobile_tabs_main-wrapper .button-success {color: #fff; background-color: #5cb85c; border-color: #4cae4c; } .mobile_tabs_main-wrapper .button-success:focus, .mobile_tabs_main-wrapper .button-success.focus {color: #fff; background-color: #449d44; border-color: #255625; } .mobile_tabs_main-wrapper .button-success:hover {color: #fff; background-color: #449d44; border-color: #398439; } .mobile_tabs_main-wrapper .button-success:active, .mobile_tabs_main-wrapper .button-success.active {color: #fff; background-color: #449d44; border-color: #398439; } .mobile_tabs_main-wrapper .button-danger {color: #fff; background-color: #d9534f; border-color: #d43f3a; padding: 10px; min-height: 40px; border-radius: 4px; line-height: 20px; } .mobile_tabs_main-wrapper .button-danger:focus, .mobile_tabs_main-wrapper .button-danger.focus {color: #fff; background-color: #c9302c; border-color: #761c19; } .mobile_tabs_main-wrapper .button-danger:hover {color: #fff; background-color: #c9302c; border-color: #ac2925; } .mobile_tabs_main-wrapper .button-danger:active, .mobile_tabs_main-wrapper .button-danger.active {color: #fff; background-color: #c9302c; border-color: #ac2925; } .background-set .background-color { margin-bottom: 10px;} .background-set .background-image { margin-bottom: 10px;} .background-set .background-none { margin-bottom: 10px;} .background-set .background-color .background-color-div {width: 17%} .main-site-wrapper { display: table; width: 100%} .main-site-wrapper .row-column-section { display: table; width: 100%; margin:20px auto;} .main-site-wrapper .row-column-section label{ font-weight: bold; padding-bottom: 20px;} .main-site-wrapper .row-column-section .row-column { display: inline-table; width: 16%; text-align: center;} <?php if ($get_mobile_tabs[0]->background_direction == '1') { ?> .main-site-wrapper .row-column-section .row-column { float: right; } .main-site-wrapper .row-column-section .row-column-row-delete-field {
    width: 5%;
    float: left;
} <?php } else { ?> .main-site-wrapper .row-column-section .row-column { float: left; } .main-site-wrapper .row-column-section .row-column-row-delete-field {
    width: 5%;
    float: right;
} <?php } ?> .main-site-wrapper .row-column-section .row-column-row-name-title {width: 15%;}f .main-site-wrapper .row-column-section .row-column-fa{width: 5%;} .main-site-wrapper .row-column-section .row-column-row-name-field {width: 24%;} .main-site-wrapper .row-column-section .row-column-row-delete-title {width: 10%; float: right;}  .main-site-wrapper .row-column-section .row-column-type-of-tab-field {width: 11%;} .main-site-wrapper .row-column-section .row-column-type-of-tab-title {width: 10%;} .main-site-wrapper .row-column-section .row-column-row-text-link-field {width: 12%;} .main-site-wrapper .row-column-section .row-column-row-text-link-title {width: 12%;} .main-site-wrapper .row-column-section .row-column-row-text-link-data_title {width: 11%;} .main-site-wrapper .row-column-section .row-column-image-height-field {width: 9%;} .main-site-wrapper .row-column-section .row-column-image-height-title {width: 8%;}
}
.main-site-wrapper .row-column-section .row-column.row-column-product-field, .main-site-wrapper .row-column-section .row-column.row-column-popup-field { width: 100%;} .main-site-wrapper .row-column-section .row-column .row-column-row-text-optional textarea{width:90%}
 .main-site-wrapper .row-column-section .row-column-row-text-optional{width: 10%;} .main-site-wrapper .row-column-section .row-column-row-text-optional, .main-site-wrapper .row-column-section .row-column-popup-field {width: 15%;} .main-site-wrapper .row-column-section .row-column-tab-option-title {width: 12%;} .main-site-wrapper .row-column-section .row-column-tab-option-field {width: 12%;} .main-site-wrapper .row-column-section .row-column-fa{width: 5%;} .main-site-wrapper .row-column-section .row-column-tab-option-field label { display: none;} .main-site-wrapper .row-column-section .row-column-type-of-tab-field label { display: none;} .main-site-wrapper .row-column-section .row-column-row-name-field label { display: none;} .main-site-wrapper .row-column-section .row-column-image-height-field label { display: none;} .main-site-wrapper .row-column-section .row-column-row-text-link-field label { display: none;} .main-site-wrapper .row-column-section .row-column-row-delete-field label { display: none;} .background-image .icon_div { height: 20px; width: 20px; } @media (max-width: 991px) {.main-site-wrapper .row-column-section .row-column-row-name-title {width: 34%;} .main-site-wrapper .row-column-section .row-column-row-name-field {width: 34%;} } @media (max-width: 767px) {.main-site-wrapper .row-column-section .row-column { height: 60px;} .main-site-wrapper .row-column-section .row-column-row-name-title {display: none;} .main-site-wrapper .row-column-section .row-column-row-name-field {width: 50%;} .main-site-wrapper .row-column-section .row-column-row-delete-title {display: none;} .main-site-wrapper .row-column-section .row-column-row-delete-field {width: 50%;} .main-site-wrapper .row-column-section .row-column-type-of-tab-field {width: 50%;} .main-site-wrapper .row-column-section .row-column-type-of-tab-title {display: none;} .main-site-wrapper .row-column-section .row-column-row-text-link-field {width: 50%;} .main-site-wrapper .row-column-section .row-column-row-text-link-title {display: none;} .main-site-wrapper .row-column-section .row-column-image-height-field {width: 50%;} .main-site-wrapper .row-column-section .row-column-image-height-title {display: none;} .main-site-wrapper .row-column-section .row-column-tab-option-field {width: 50%;} .main-site-wrapper .row-column-section .row-column-tab-option-title {display: none;} .main-site-wrapper .row-column-section .row-column-row-name-field .set_custom_images { margin-top: -30px;} .main-site-wrapper .row-column-section .row-column-tab-option-field label { display: block; padding-bottom: 10px;} .main-site-wrapper .row-column-section .row-column-type-of-tab-field label { display: block; padding-bottom: 10px;} .main-div .margin-div-set label { display: block;} } @media (max-width: 500px) {.background-set .background-color .background-color-div {width: 50%} } @media (max-width: 400px) {.main-site-wrapper .row-column-section .row-column-row-name-field {width: 100%;} .main-site-wrapper .row-column-section .row-column-row-delete-field {width: 100%;} .main-site-wrapper .row-column-section .row-column-type-of-tab-field {width: 100%; margin-bottom: 15px;} .main-site-wrapper .row-column-section .row-column-row-text-link-field {width: 100%;} .main-site-wrapper .row-column-section .row-column-image-height-field {width: 100%;} .main-site-wrapper .row-column-section .row-column-tab-option-field {width: 100%; margin-bottom: 15px;} } 
 
 .row-column.row-column-row-text-share-field input {
	margin: -4px 6px 0 9px !important;
}
 
 
 .mydrag {
  /* border:dashed 1px #aaaaaa; */
  padding: 6px 12px;
  font-size: 1.2em;
}
span.grippy {
  content: '....';
  width: 10px;
  height: 20px;
  display: inline-block;
  overflow: hidden;
  line-height: 5px;
  padding: 3px 4px;
  cursor: move;
  vertical-align: middle;
  margin-top: -.7em;
  margin-right: .3em;
  font-size: 12px;
  font-family: sans-serif;
  letter-spacing: 2px;
  color: #cccccc;
  text-shadow: 1px 0 1px black;
}
span.grippy::after {
  content: '... ... ... ...';
}

 .row-column-fa input {
    vertical-align: -webkit-baseline-middle !important;
}
</style>

 <link href="<?php echo plugins_url('assets/css/image.select.css', dirname(__FILE__)); ?>" type="text/css" />

<?php  
$license_data = get_site_option('slt_license'); 
if(!empty($license_data) && isset($license_data['key']) && !empty($license_data['key']) ){ $rowtab = 10; }else{ $rowtab = 2; } 
?>

<script type="text/javascript">

jQuery(document).ready(function(){
    jQuery('#backgroundRadioImageIcon').click(function () {
        jQuery("#backgroundRadioImage").attr('checked', 'checked');
     });

     jQuery('#backgroundRadioColorText').click(function () {
        jQuery("#backgroundRadioColor").attr('checked', 'checked');

     });
	 
    jQuery('.type_of_tabs').live('change', function() {

        var type_of_tabs_val = jQuery(this).val();

        var trid = jQuery(this).attr('trid');

        if(type_of_tabs_val =='share'){

            jQuery('#'+trid+' .row-column-row-text-share-field').show();

            jQuery('#'+trid+' .row-column-row-text-shareText-field').show();

            jQuery('#'+trid+' .row-column-row-text-link-field').hide();

        } else {

            jQuery('#'+trid+' .row-column-row-text-share-field').hide();

            jQuery('#'+trid+' .row-column-row-text-shareText-field').hide();

            jQuery('#'+trid+' .row-column-row-text-link-field').show();

        }
        if(type_of_tabs_val =='popup_form'){

            jQuery('#'+trid+' .row-column-popup-field').show();
            //jQuery('#'+trid+' .row-column-row-text-optional').hide();

        } else {

            jQuery('#'+trid+' .row-column-popup-field').hide();
            //jQuery('#'+trid+' .row-column-row-text-optional').show();

        }
        if(type_of_tabs_val =='product_popup'){

            jQuery('#'+trid+' .row-column-product-field').show();
            //jQuery('#'+trid+' .row-column-row-text-optional').hide();

        } else {

            jQuery('#'+trid+' .row-column-product-field').hide();
            //jQuery('#'+trid+' .row-column-row-text-optional').show();

        }
		
		//jquery for border color
		if(type_of_tabs_val == 'popup_form' || type_of_tabs_val == 'product_popup' || type_of_tabs_val == 'image_popup' || type_of_tabs_val == 'video_popup'){
			jQuery('#'+trid+' .row-column-background-color').show();
		}else{
			jQuery('#'+trid+' .row-column-background-color').hide();
		}
		

    });
	
    jQuery('.tab_option').live('change', function() {

        var tab_option_val = jQuery(this).val();

        var trid = jQuery(this).attr('trid');

        if(tab_option_val =='upload_icon'){

            var icon_div_value = jQuery('#'+trid+' .icon_div_value').val();

            jQuery('#'+trid+' .icon_div').hide();

            jQuery('#'+trid+' .button_icon').show();

            jQuery('#'+trid+' .icon_div_value').show();

            jQuery('#'+trid+' .image_height_div').show();

            jQuery('.row-column-section .row-column-image-height-title').show();
            //jQuery('.row-column-section .row-column-row-text-optional').show();
            //jQuery('.row-column-section .row-column-popup-field').show();

            jQuery('#'+trid+' .text_div').hide();

            jQuery('#'+trid+' .select_icon_div').hide();
			jQuery('#'+trid+' .row_text_optional').show();
        } else if(tab_option_val=='icon') {

            jQuery('#'+trid+' .select_icon_div').show();

            jQuery('#'+trid+' .icon_div').hide();

            jQuery('#'+trid+' .button_icon').hide();

            jQuery('#'+trid+' .icon_div_value').hide();

            jQuery('#'+trid+' .image_height_div').show();

            jQuery('.row-column-section .row-column-image-height-title').show();
            //jQuery('.row-column-section .row-column-row-text-optional').show();
            //jQuery('.row-column-section .row-column-popup-field').show();
			jQuery('#'+trid+' .row_text_optional').show();
            jQuery('#'+trid+' .text_div').hide();

        } else {
			jQuery('#'+trid+' .row_text_optional').hide();
            jQuery('#'+trid+' .select_icon_div').hide();
            jQuery('#'+trid+' .text_div').show();
            jQuery('#'+trid+' .icon_div').hide();
            jQuery('#'+trid+' .icon_div_value').hide();
            jQuery('#'+trid+' .button_icon').hide();
            jQuery('#'+trid+' .image_height_div').hide();
            jQuery('.row-column-section .row-column-image-height-title').hide();
           // jQuery('.row-column-section .row-column-row-text-optional').hide();
            //jQuery('.row-column-section .row-column-popup-field').hide();
        }

    });

        jQuery('.type_of_tabs').live('change', function() {

            var type_of_tabs_val = jQuery(this).val();
            var trid = jQuery(this).attr('trid');

            jQuery('#'+trid+'web').css("display","none");
            jQuery('#'+trid+'call').css("display","none");
            jQuery('#'+trid+'mail').css("display","none");
            jQuery('#'+trid+'sms').css("display","none");
            jQuery('#'+trid+'wsap').css("display","none");
            jQuery('#'+trid+'place').css("display","none");
            jQuery('#'+trid+'wiz').css("display","none");
            jQuery('#'+trid+'vibe').css("display","none");
            jQuery('#'+trid+'skype').css("display","none");
            jQuery('#'+trid+'share').css("display","none");
            jQuery('#'+trid+'telegram').css("display","none");
            jQuery('#'+trid+'fchat').css("display","none");
            jQuery('#'+trid+'basket').css("display","none");
            jQuery('#'+trid+'sale').css("display","none");
            jQuery('#'+trid+'form').css("display","none");
            jQuery('#'+trid+'popup-img').css("display","none");
            jQuery('#'+trid+'video-pop').css("display","none");
            jQuery('#'+trid+'line-app').css("display","none");
            jQuery('#'+trid+'kakaotalk').css("display","none");
            jQuery('#'+trid+'wechat').css("display","none");

            jQuery('#'+trid+'web2').css("display","none");
            jQuery('#'+trid+'call2').css("display","none");
            jQuery('#'+trid+'mail2').css("display","none");
            jQuery('#'+trid+'sms2').css("display","none");
            jQuery('#'+trid+'wsap2').css("display","none");
            jQuery('#'+trid+'place2').css("display","none");
            jQuery('#'+trid+'wiz2').css("display","none");
            jQuery('#'+trid+'vibe2').css("display","none");
            jQuery('#'+trid+'skype2').css("display","none");
            jQuery('#'+trid+'share2').css("display","none");
            jQuery('#'+trid+'telegram2').css("display","none");
            jQuery('#'+trid+'fchat2').css("display","none");
            jQuery('#'+trid+'basket2').css("display","none");
            jQuery('#'+trid+'sale2').css("display","none");
            jQuery('#'+trid+'form2').css("display","none");
            jQuery('#'+trid+'popup-img2').css("display","none");
            jQuery('#'+trid+'video-pop2').css("display","none");
            jQuery('#'+trid+'line-app2').css("display","none");
            jQuery('#'+trid+'kakaotalk2').css("display","none");
            jQuery('#'+trid+'wechat2').css("display","none");


            jQuery('#'+trid+'f').css("display","none");
            jQuery('#'+trid+'f2').css("display","none");
            jQuery('#'+trid+'gplus').css("display","none");
            jQuery('#'+trid+'gplus2').css("display","none");
            jQuery('#'+trid+'home').css("display","none");
            jQuery('#'+trid+'home2').css("display","none");
            jQuery('#'+trid+'in').css("display","none");
            jQuery('#'+trid+'in2').css("display","none");
            jQuery('#'+trid+'ins').css("display","none");
            jQuery('#'+trid+'ins2').css("display","none");
            jQuery('#'+trid+'pin').css("display","none");
            jQuery('#'+trid+'pin2').css("display","none");
            jQuery('#'+trid+'tube').css("display","none");
            jQuery('#'+trid+'tube2').css("display","none");
            jQuery('#'+trid+'video').css("display","none");
            jQuery('#'+trid+'video2').css("display","none");
            jQuery('#'+trid+'twit').css("display","none");
            jQuery('#'+trid+'twit2').css("display","none");


            if(type_of_tabs_val == 'link'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','Link');
                jQuery('#'+trid+'f').css("display","inline-block");
                jQuery('#'+trid+'f2').css("display","inline-block");
                jQuery('#'+trid+'gplus').css("display","inline-block");
                jQuery('#'+trid+'gplus2').css("display","inline-block");
                jQuery('#'+trid+'home').css("display","inline-block");
                jQuery('#'+trid+'home2').css("display","inline-block");
                jQuery('#'+trid+'in').css("display","inline-block");
                jQuery('#'+trid+'in2').css("display","inline-block");
                jQuery('#'+trid+'ins').css("display","inline-block");
                jQuery('#'+trid+'ins2').css("display","inline-block");
                jQuery('#'+trid+'pin').css("display","inline-block");
                jQuery('#'+trid+'pin2').css("display","inline-block");
                jQuery('#'+trid+'tube').css("display","inline-block");
                jQuery('#'+trid+'tube2').css("display","inline-block");
                jQuery('#'+trid+'video').css("display","inline-block");
                jQuery('#'+trid+'video2').css("display","inline-block");
                jQuery('#'+trid+'twit').css("display","inline-block");
                jQuery('#'+trid+'twit2').css("display","inline-block");

                jQuery('#'+trid+'web').css("display","inline-block");
                jQuery('#'+trid+'web2').css("display","inline-block");

            } else if(type_of_tabs_val == 'phone'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','Phone no.');
                jQuery('#'+trid+'call').css("display","inline-block");
                jQuery('#'+trid+'call2').css("display","inline-block");

            } else if(type_of_tabs_val =='mail'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','Email-id');
                jQuery('#'+trid+'mail').css("display","inline-block");
                jQuery('#'+trid+'mail2').css("display","inline-block");

            } else if(type_of_tabs_val =='sms'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','sms');
                jQuery('#'+trid+'sms').css("display","inline-block");
                jQuery('#'+trid+'sms2').css("display","inline-block");

            } else if(type_of_tabs_val =='whatsapp'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','Add Phone No. with country code.');
                jQuery('#'+trid+'wsap').css("display","inline-block");
                jQuery('#'+trid+'wsap2').css("display","inline-block");

            } else if(type_of_tabs_val =='location'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','Add Address');
                jQuery('#'+trid+'place').css("display","inline-block");
                jQuery('#'+trid+'place2').css("display","inline-block");

            } else if(type_of_tabs_val == 'waze'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','Waze');
                jQuery('#'+trid+'wiz').css("display","inline-block");
                jQuery('#'+trid+'wiz2').css("display","inline-block");

            } else if(type_of_tabs_val == 'viber'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','Viber');
                jQuery('#'+trid+'vibe').css("display","inline-block");
                jQuery('#'+trid+'vibe2').css("display","inline-block");

            } else if(type_of_tabs_val == 'skypechat'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','Put user name of skype');
                jQuery('#'+trid+'skype').css("display","inline-block");
                jQuery('#'+trid+'skype2').css("display","inline-block");

            } else if(type_of_tabs_val == 'skypecall'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','Put user name of skype');
                jQuery('#'+trid+'skype').css("display","inline-block");
                jQuery('#'+trid+'skype2').css("display","inline-block");

            } else if(type_of_tabs_val == 'share'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','Put user name of skype');
                jQuery('#'+trid+'share').css("display","inline-block");
                jQuery('#'+trid+'share2').css("display","inline-block");

            } else if(type_of_tabs_val == 'telegram'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','Put telegram username');
                jQuery('#'+trid+'telegram').css("display","inline-block");
                jQuery('#'+trid+'telegram2').css("display","inline-block");

            } else if(type_of_tabs_val == 'messenger'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','Put Facebook fanpage username');
                jQuery('#'+trid+'fchat').css("display","inline-block");
                jQuery('#'+trid+'fchat2').css("display","inline-block");

            } else if(type_of_tabs_val == 'cart'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','will automatic redirect to cart page');
                jQuery('#'+trid+'basket').css("display","inline-block");
                jQuery('#'+trid+'basket2').css("display","inline-block");

            } else if(type_of_tabs_val == 'popup_form'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','Enter headline');
                jQuery('#'+trid+'form').css("display","inline-block");
                jQuery('#'+trid+'form2').css("display","inline-block");

            } else if(type_of_tabs_val == 'product_popup'){

                jQuery('#'+trid+' .row_text_link').attr('placeholder','Enter headline');
                jQuery('#'+trid+'sale').css("display","inline-block");
                jQuery('#'+trid+'sale2').css("display","inline-block");
            }
			//add jquery for image popup **************************************************
			if(type_of_tabs_val == 'image_popup'){
				//jQuery('#'+trid+' .image-text').attr('placeholder','Image text');
				jQuery('#'+trid+' .row_text_link').attr('placeholder','Enter headline');
                // var img_pop_div_value = jQuery('#'+trid+' .img_pop_div_value').val();
				 jQuery('#'+trid+'popup-img').css("display","inline-block");
                 jQuery('#'+trid+'popup-img2').css("display","inline-block");
				// jQuery('#'+trid+' .img_pop_div').hide();
				 jQuery('#'+trid+' .button_image').show();
				jQuery('#'+trid+' .row-column-popup-image-field').show();
				 //jQuery('#'+trid+' .img_pop_div_value').show();
				 //jQuery('.row-column-section .row-column-image-height-title').show();
				 //jQuery('#'+trid+' .select_image_div').hide();
			}else{
				//jQuery('#'+trid+' .image-text').attr('placeholder','');
				jQuery('#'+trid+' .row-column-popup-image-field').hide();
			}
			//add jquery for video popup **************************************************
			if(type_of_tabs_val == 'video_popup'){ 
				//jQuery('#'+trid+' .image-text').attr('placeholder','Video text');
				jQuery('#'+trid+' .row_text_link').attr('placeholder','Headline');
                jQuery('#'+trid+'video-pop').css("display","inline-block");
                jQuery('#'+trid+'video-pop2').css("display","inline-block");
				jQuery('#'+trid+' .row-column-popup-video-field').show();
			}else{
				//jQuery('#'+trid+' .image-text').attr('placeholder','');
				jQuery('#'+trid+' .row-column-popup-video-field').hide();
			}
			//add jquery for line app**************************************************
			if(type_of_tabs_val == 'line'){
				jQuery('#'+trid+' .row_text_link').attr('placeholder','Line..');
                jQuery('#'+trid+'line-app').css("display","inline-block");
                jQuery('#'+trid+'line-app2').css("display","inline-block");
			}
			//add jquery for kakaotalk app**************************************************
			if(type_of_tabs_val == 'kakaotalk'){
				jQuery('#'+trid+' .row_text_link').attr('placeholder','Kakaotalk..');
                jQuery('#'+trid+'kakaotalk').css("display","inline-block");
                jQuery('#'+trid+'kakaotalk2').css("display","inline-block");
			}
			//add jquery for wechat app**************************************************
			if(type_of_tabs_val == 'wechat'){
				jQuery('#'+trid+' .row_text_link').attr('placeholder','Wechat..');
                jQuery('#'+trid+'wechat').css("display","inline-block");
                jQuery('#'+trid+'wechat2').css("display","inline-block");
			}
        });

        jQuery('input.imageSelect').imageSelect();
        <?php if(!empty($rcdCount)) { ?>
            var i = <?php echo $rcdCount; ?>;
        <?php } else {  ?>
            var i = 1;
        <?php } ?>

        jQuery('.insert_button').click(function () {
            i++;	
				jQuery("#row-2").show();	
            if(jQuery("#countt").val() == 0) {
				jQuery("#countt").val(1);
                 jQuery('input.'+i+'imageSelect').imageSelect();
				return false;
            }else{
				alert('You can add more tab in pro version.');
			}
			
			
			
			new jscolor(jQuery('.jscolor').last()[0]);
			new jscolor(jQuery('.newcolor').last()[0]);
        });

        <?php if(empty($get_mobile_tabs_datas)) { ?>

            jQuery('.icon_div').hide();
            jQuery('.button_icon').hide();
            jQuery('.image_height_div').hide();
            jQuery('.row-column-section .row-column-image-height-title').hide();
            //jQuery('.row-column-section .row-column-row-text-optional').hide();
            jQuery('.icon_div_value').hide();
            jQuery('.select_icon_div').hide();
        <?php } ?>

        /* UPLOAD ICON [START] */

         var $ = jQuery;
		 <!-- open image popup ******************************************* --->
		 if ($('.set_custom_pop_images').length > 0) {

            if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {

                $(document).on('click', '.set_custom_pop_images', function(e) {

                    /* ADD panchsoft  [start] */

                    var trid = jQuery(this).attr('trid');
					
                    /* ADD panchsoft [end]  */

                    e.preventDefault();

                    var button = $(this);

                    var id = button.prev();

                    wp.media.editor.send.attachment = function(props, attachment) {

                        console.log('Attachment : '+ JSON.stringify(attachment));

                        id.val(attachment.url);

                        /* ADD panchsoft  [start] */

                        if(attachment.url=='') {

                            jQuery('#'+trid+' .img_pop_div').hide();

                        } else {

                            jQuery('#'+trid+' .img_pop_div').show();

                        }

                        jQuery('#'+trid+' .img_pop_div').attr('src',attachment.url);

                        /* ADD panchsoft [end]  */

                    };

               

                    wp.media.editor.open(button);

                    return false;

                });

            }

        }
		 

        if ($('.set_custom_images').length > 0) {

            if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {

                $(document).on('click', '.set_custom_images', function(e) {

                    /* ADD panchsoft  [start] */

                    var trid = jQuery(this).attr('trid');
					
                    /* ADD panchsoft [end]  */

                    e.preventDefault();

                    var button = $(this);

                    var id = button.prev();

                    wp.media.editor.send.attachment = function(props, attachment) {

                        console.log('Attachment : '+ JSON.stringify(attachment));

                        id.val(attachment.url);

                        /* ADD panchsoft  [start] */

                        if(attachment.url=='') {

                            jQuery('#'+trid+' .icon_div').hide();

                        } else {

                            jQuery('#'+trid+' .icon_div').show();

                        }

                        jQuery('#'+trid+' .icon_div').attr('src',attachment.url);

                        /* ADD panchsoft [end]  */

                    };

               

                    wp.media.editor.open(button);

                    return false;

                });

            }

        }

        if ($('.set_custom_images_background').length > 0) {
            if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
                $(document).on('click', '.set_custom_images_background', function(e) {
                    e.preventDefault();
                    var button = $(this);
                    var id = button.prev();
                    wp.media.editor.send.attachment = function(props, attachment) {
                        console.log('Attachment : '+ JSON.stringify(attachment));
                        id.val(attachment.url);

                        /* ADD panchsoft  [start] */

                        if(attachment.url=='') {

                            jQuery('.background-image .icon_div').hide();
                        } else {

                            jQuery('.background-image .icon_div').show();
                        }
                        jQuery('.background-image .icon_div').attr('src',attachment.url);

                        /* ADD panchsoft [end]  */
                    };
                    wp.media.editor.open(button);
                    return false;
                });

            }

        }

        /* UPLOAD ICON [END] */

    });

</script>



<?php if ($message==1) { ?>

    <div class="alert alert-success notice is-dismissible" id="message">

        <p><strong>Data Saved Successfully </strong></p>

        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>

    </div>

<?php } ?>



<?php if ($message=='error') { ?>

    <div class="alert alert-info notice is-dismissible" id="message">

        <p><strong>Please Add Data </strong></p>

        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>

    </div>

<?php } ?>

<?php if ($message==2) { ?>

    <div class="alert alert-danger notice is-dismissible" id="message">

        <p><strong>Row Deleted Successfully </strong></p>

        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>

    </div>

<?php } ?>
<!--<h2 style="color:#2e69b6; line-height:40px; font-size: 26px; font-weight: normal;" >Thank you for Purchasing Mobile Tabs!</h2>-->
<div style="color:#919191">To get started with customizing your mobile tabs for your website. Please follow instructions to avoid getting stuck.<br />
Feel free to refer to Plugin documentation whenever you find anything confusing.</div>
<div style="margin:20px 0px;">
</div>

<div id="mobile_tabs_main-wrapper" class="mobile_tabs_main-wrapper">

    <div class="form-wrapper">

        <form method="post" enctype="multipart/form-data" action="<?php echo get_admin_url(); ?>options-general.php?page=mobile_tabs">

        <div class="main-div">

            <div class="row" style="width:100%; margin:20px 0px;overflow: hidden;">
                <div class="direction-setting" style="border: 1px solid #2e69b6;width: 20%; float:left;border-radius: 5px;">
                    <div style="background: #2e69b6;padding: 20px;text-align: left;color: #fff; font-weight: bold;padding-left: 50px;">Choose Direction Mode:</div>
                    <div style="padding: 46px;">
                        <div style="margin-bottom:10px;"><input type="radio" name="direction" value="0" <?php if ($get_mobile_tabs[0]->background_direction == '0') { ?> checked <?php } ?> <?php if($get_mobile_tabs[0]->background_direction == '') { ?> checked <?php } ?>> LTR
                        </div>
                        <div><input type="radio" name="direction" value="1" <?php if ($get_mobile_tabs[0]->background_direction == '1') { ?> checked <?php } ?>> RTL
                        </div>
                    </div>
                </div>
				

                <!--

                <div class="alert alert-info" style="display: table;">

                    Interface will change to RTL or LTR after save.

                </div>

                <hr/>

                <br/>
                !-->

                <div class="direction-setting" style="border: 1px solid #ccc;width: 38%; float:left; margin-left:10px;border-radius: 5px;">
                    <div style="background: #ccc;padding: 20px;text-align: left;color: #000; font-weight: bold; padding-left: 50px;">Set Background:</div>
                    <div style="padding: 40px;">
                        <div class="background-color" style="width: 50%;float: left;">

                        <input type="radio" name="mobile_tab_backgroundRadio" value="color" <?php if($get_mobile_tabs[0]->background_type =='color'){ ?> checked <?php } ?> id="backgroundRadioColor" /> (choose color)

                        <input type="text" style="width: 60px;" class="jscolor {hash:true} background-color-div" name="mobile_tabs_background_color" value="<?php echo esc_html($get_mobile_tabs[0]->background_color); ?>" id="backgroundRadioColorText">

                    </div>

                    <div class="background-image">

                        <input type="radio" name="mobile_tab_backgroundRadio" value="image" <?php if ($get_mobile_tabs[0]->background_type =='image'){ ?> checked <?php  } ?> id="backgroundRadioImage" />

                        <?php if ($get_mobile_tabs[0]->background_image !='') { ?>

                                <img src="<?php echo esc_url($get_mobile_tabs[0]->background_image); ?>" class="icon_div" name="mobile_tab_background_images"  id=""  />

                            <?php } else {  ?>

                                <img src="" class="icon_div" style="display: none;" />

                            <?php } ?>

                            <input class="image_div" name="mobile_tab_background_images" type="hidden" placeholder="Select Icon" value="<?php echo esc_html($get_mobile_tabs[0]->background_image); ?>"  />

                            <button class="set_custom_images_background button button_images background-color-div" id="backgroundRadioImageIcon">Select Background</button>

                    </div>

                    <div class="background-none">
                        <input type="radio" name="mobile_tab_backgroundRadio" value="none" <?php if ($get_mobile_tabs[0]->background_type =='none'){ ?> checked <?php } ?> <?php if($get_mobile_tabs[0]->background_type == '') { ?> checked <?php } ?> />None

                     </div>
                    </div>
                </div>
				
				<div class="direction-setting" style="border: 1px solid #2e69b6;width: 39%; float:left;border-radius: 5px; margin-left: 10px;">
                    <div style="background: #2e69b6;padding: 10px;text-align: left;color: #fff; font-weight: bold;padding-left: 50px;">Bar radius:</div>
                    <div class="radius-bar">
				<div class="radius-input">
				<label>Top left</label>
				<input type="number" name="top_left_radius" value="<?php echo $get_mobile_tabs[0]->top_left_radius; ?>">
				</div>

				<div class="radius-input">
				<label>Top right</label>
				<input type="number" name="top_right_radius" value="<?php echo $get_mobile_tabs[0]->top_right_radius; ?>">
				</div>

				<div class="radius-input">
				<label>Bottom left</label>
				<input type="number" name="bottom_left_radius" value="<?php echo $get_mobile_tabs[0]->bottom_left_radius; ?>">
				</div>

				<div class="radius-input">
				<label>Bottom right</label>
				<input type="number" name="bottom_right_radius" value="<?php echo $get_mobile_tabs[0]->bottom_right_radius; ?>">
				</div>
                    </div>
                </div>
		

							
				<div id="new_one" class="direction-setting" style="border: 1px solid #2e69b6;width: 19.5%; float:left;border-radius: 5px; margin-left: 10px; margin-top:5px;">
                    <div style="background: #2e69b6;padding: 10px;text-align: left;color: #fff; font-weight: bold;padding-left: 50px;">Bar radius:</div>
                    <div id="new_three" class="radius-bar" style="    padding-top: 3px;">


				<div id="new_two" class="round">
				<div class="radius-input" style="width: 43%;">
				<!--label></label--->
				<label>Round buttons</label>
				</div>

				<div class="radius-input" style="width: 30%;">
				<label>Desktop</label>
				<span>
				<input type="checkbox" name="round_button_desktop" value="round_button_desktop" <?php if($get_mobile_tabs[0]->round_button_desktop == 'round_button_desktop') { ?> checked <?php } ?>>
				</span>
				</div>

				<div class="radius-input" style="width: 26%;">
				<label>Mobile</label>
				<span>
				<input type="checkbox" name="round_button_mobile" value="round_button_mobile" <?php if($get_mobile_tabs[0]->round_button_mobile == 'round_button_mobile') { ?> checked <?php } ?>>
				</span></div>

				<div class="radius-input" style="clear: both;    width: 46%;">
				<label></label>
				<label>Vertical bar</label>
				</div>	

				<div id="vartical_bar" class="radius-input" style="width: 25%; float: right; margin-right: 0%; margin-top: 3%;">

				<span>
				<input style="margin: 7px 0 0 2px;" type="checkbox" name="round_column" value="round_column" <?php if($get_mobile_tabs[0]->round_column == 'round_column') { ?> checked <?php } ?>>
                  </span>  </div>

                    </div>

                    </div>
                </div>
		
		
		<div class="vinod_sce">
					
				<div id="mobile_scec" class="direction-setting" style="border: 1px solid #2e69b6;width: 18.5%; float:left;border-radius: 5px; margin-left: 10px; margin-top:5px;">
                    <div style="background: #2e69b6;padding: 10px;text-align: left;color: #fff; font-weight: bold;padding-left: 10px;">Minimize on mobile:</div>
                    <div id="demo_bar_ra" class="radius-bar">


				<div class="round">
				<div class="radius-input">
				<label  style="padding-top:0px;">one icon</label>
				</div>

				<div class="radius-input" style="width: 30%;">
				<span style="    width: 66%;text-align: right;float: right;">
				<input type="checkbox" style="" name="one_icon_check" value="one_icon_check" <?php if($get_mobile_tabs[0]->one_icon_check == 'one_icon_check') { ?> checked <?php } ?>>
				</span>
				</div>

				<div class="radius-input" style="width: 43%;">
				<label id="color_sce" style="width: unset;;padding-top: 0;vertical-align: top;padding-bottom: 0;">color</label>
				 <input type="text" style="width: 30px;" class="jscolor {hash:true} background-color-div" name="one_icon_back_clr" value="<?php if(!empty($get_mobile_tabs[0]->one_icon_back_clr )){ echo $get_mobile_tabs[0]->one_icon_back_clr; } ?>"></div>

				<div class="radius-input" style="clear: both;    width: 30%;">
				<label></label>
				<label>Choose icon</label>
				</div>	

				<div class="radius-input" style="width: 64%; float: right; margin-right: 0%; margin-top: 10%;">

				<span style="width:100% !important;">
				
				
                            <div class="select_icon_div">
                            <?php foreach ($scandirs as $scandir) { 
                                    
									$selected_values = plugins_url('image/'.$scandir, dirname(__FILE__) );
                                    $selected = $selected_values == $get_mobile_tabs[0]->choose_icon_for_one_icon ? 'checked' : '';

                                    if( $scandir == 'TextFull.png' || $scandir == 'TextRound.png')  {
										
										if($selected == '' &&  $scandir == 'TextFull.png' ){
											$selected = 'checked';
										}
                            ?>
                            <span style="width: 33% !important;float: left;">
							<input type="radio" name="choose_icon_for_one_icon"  value="<?php echo plugins_url('image/'.$scandir, dirname(__FILE__) ); ?>" <?php  echo $selected; ?>  class="imageSelect" data-image="<?php echo plugins_url('image/'.$scandir, dirname(__FILE__) ); ?>">
							</span>
							
                            <?php  } }?>
                            </div>	
				</span>	
				</div>

                    </div>

                    </div>
                </div>
				<style>
				.vinod_sce .round .radius-input span {
    float: left;
    width: 100%;
}

.radius-input .select_icon_div{
	display: block !important;
}
			</style>
		</div>
		
		
		
		
		
		
		
		

		
            </div>


            <hr/>

            <br/>

            <button type="button" class="button button-success insert_button "> <i class="fa fa-plus" style="padding-right: 10px;"></i> Add row</button>
			
			<input class="button button-primary button-large" style="background:#4476b8;color:#fff;font-weight: bold;" type="submit" name="submit" value="Submit">
            <br/>

            <br/>

            <div id="myTable" class="main-site-wrapper"  width="100%">
                <div class="row-column-section" style="background:#2e69b6;padding: 20px 0px; color:#fff">
				<div class="row-column row-column-fa">
                    <div class="mydrag">
					<span class="grippy"></span>
				</div>
            </div>
					<div class="row-column row-column-fa"><label>Color</label></div>
					<div class="row-column row-column-fa"><label></label></div>
                	<div class="row-column row-column-fa"><i class="fa fa-desktop" style=""></i></div>
					<div class="row-column row-column-fa"><i class="fa fa-mobile" style=" font-size: 22px;"></i></div>
                    <div class="row-column row-column-tab-option-title"><label>Tab option</label></div>
                    <div class="row-column row-column-type-of-tab-title"><label>Type of Tabs</label></div>
                    <div class="row-column row-column-row-name-title"><label>Choose Icon</label></div>
                    <div class="row-column row-column-image-height-title"><label>Height in px</label></div>
                    <div class="row-column row-column-row-text-link-title"><label>Tab info</label></div>
                    <div class="row-column row-column-row-text-link-data_title"><label>Tab Data</label></div>
                  <!--  <div class="row-column row-column-row-text-optional"><label>&nbsp;</label></div>-->
                    <div class="row-column row-column-row-delete-title"><label>Delete</label></div>
                </div>

                <?php

                    if(!empty($get_mobile_tabs_datas)) {

                    $j=1;

                    foreach ($get_mobile_tabs_datas as $get_data){
					//var_dump($get_data); die("dsf");
                ?>

                    <div id="row-<?php echo $j; ?>" class="row-column-section">
					
					
						<div class="row-column row-column-fa">
                            <div class="mydrag">
							  <span class="grippy"></span>
							</div>
                        </div>
						
						<div class="row-column row-column-fa">
						<input type="text" trid="row-<?php echo $j; ?>" style="width: 38px; min-height:25px; padding: 2px 6px;" class="jscolor newcolor {hash:true} background-color-div" name="icon_back_clr_<?php echo $j; ?>" value="<?php echo $get_data->icon_back_clr; ?>">
						
						<input type="hidden" class="removeColor" name="remove_color_<?php echo $j; ?>" trid="row-<?php echo $j; ?>" value="<?php echo $get_data->remove_color; ?>" />
						<a style="cursor: pointer; <?php if ($get_data->remove_color == 0){ ?> display:none; <?php } ?>" class="removeLink" trid="row-<?php echo $j; ?>">Remove</a>
						</div>


                        <div class="row-column row-column-fa">
                            <input onClick="divFunction(this)" type="checkbox" class="desktop-clss" name="row_text_display_<?php echo $j; ?>" value="1" <?php if ($get_data->row_text_display =='yes'){ ?> checked <?php  } echo $get_data->row_text_display; ?> />

                        </div>
						
						<div class="row-column row-column-fa">
                            <input onClick="divFunction1(this)" type="checkbox" class="mobile-clss" name="row_text_mobile_display_<?php echo $j; ?>" value="1" <?php if ($get_data->row_text_mobile_display =='yes'){ ?> checked <?php  } echo $get_data->row_text_mobile_display; ?> />

                        </div>
						
                        <div class="row-column row-column-tab-option-field">

                            <label>Tab option</label>
                            <select name="tab_option_<?php echo $j; ?>" trid="row-<?php echo $j; ?>" class="tab_option" >

                                <option value="">Tab option</option>

                                <option value="text" <?php if($get_data->tab_option == 'text') { ?> selected <?php } ?>>Text</option>

                                <option value="icon" <?php if($get_data->tab_option == 'icon') { ?> selected <?php } ?>>Icon</option>

                                <option value="upload_icon" <?php if($get_data->tab_option == 'upload_icon') { ?> selected <?php } ?>>Upload Icon</option>

                            </select>

                        </div>

                        <div class="row-column row-column-type-of-tab-field">

                            <label>Type of Tabs</label>

                            <select name="type_of_tabs_<?php echo $j; ?>" class="type_of_tabs" trid="row-<?php echo $j; ?>">

                                <option value="">Type of Tab</option>

                                <option value="phone" <?php if($get_data->type_of_tabs == 'phone') { ?> selected <?php } ?>>Phone</option>

                                <option value="mail" <?php if($get_data->type_of_tabs == 'mail') { ?> selected <?php } ?>>Mail</option>

                                <option value="waze" <?php if($get_data->type_of_tabs == 'waze') { ?> selected <?php } ?>>Waze</option>

                                <option value="link" <?php if($get_data->type_of_tabs == 'link') { ?> selected <?php } ?>>Link</option>

                                <option value="sms" <?php if($get_data->type_of_tabs == 'sms') { ?> selected <?php } ?>>Sms</option>

                                <option value="location" <?php if($get_data->type_of_tabs == 'location') { ?> selected <?php } ?>>Location</option>

                                <option value="whatsapp" <?php if($get_data->type_of_tabs == 'whatsapp') { ?> selected <?php } ?>>Whats app</option>

                                <option value="skypechat" <?php if($get_data->type_of_tabs == 'skypechat') { ?> selected <?php } ?>>Skype Chat</option>

                                <option value="skypecall" <?php if($get_data->type_of_tabs == 'skypecall') { ?> selected <?php } ?>>Skype Call</option>

                                <option value="viber" <?php if($get_data->type_of_tabs == 'viber') { ?>selected<?php } ?>>Viber</option>

                                <option value="share" <?php if($get_data->type_of_tabs == 'share') { ?> selected <?php } ?>>Share</option>
                                <option value="telegram" <?php if($get_data->type_of_tabs == 'telegram') { ?> selected <?php } ?>>Telegram</option>
                                <option value="messenger" <?php if($get_data->type_of_tabs == 'messenger') { ?> selected <?php } ?>>Facebook Messenger</option>
								<!--<option value="line" <?php if($get_data->type_of_tabs == 'line') { ?> selected <?php } ?>>Line</option><option value="kakaotalk" <?php if($get_data->type_of_tabs == 'kakaotalk') { ?> selected <?php } ?>>Kakaotalk</option>
								<option value="wechat" <?php if($get_data->type_of_tabs == 'wechat') { ?> selected <?php } ?>>Wechat</option>-->
                                <option value="cart" <?php if($get_data->type_of_tabs == 'cart') { ?> selected <?php } ?>>WooCommerce Cart</option>
                                <option value="popup_form" <?php if($get_data->type_of_tabs == 'popup_form') { ?> selected <?php } ?>>Popup Form</option>
                                <option value="product_popup" <?php if($get_data->type_of_tabs == 'product_popup') { ?> selected <?php } ?>>Product Popup</option>
								<option value="image_popup" <?php if($get_data->type_of_tabs == 'image_popup') { ?> selected <?php } ?>>Image Popup</option>
								<option value="video_popup" <?php if($get_data->type_of_tabs == 'video_popup') { ?> selected <?php } ?>>Video Popup</option>
                            </select>

                        </div>
	

                        <div class="row-column row-column-row-name-field">

                            <!-- TEXT PART [START] -->

                            <input type="text" name="row_text_name_<?php echo $j; ?>" value="<?php if($get_data->tab_option == 'icon' || $get_data->tab_option == 'upload_icon') { ?> <?php } else {  echo esc_html($get_data->row_text_name); }?>" trid="row-<?php echo $j; ?>" class="text_div" <?php if($get_data->tab_option == 'icon' || $get_data->tab_option == 'upload_icon') { ?> style="display: none" <?php } ?> />

                            <!-- TEXT PART [END] -->



                            <!-- IMAGE PART [START] -->

                                <img src="<?php echo esc_url($get_data->row_text_name); ?>" class="icon_div" trid="row-<?php echo $j; ?>" <?php if($get_data->tab_option == 'text' || $get_data->tab_option == 'icon') { ?> style="display: none;" <?php } ?> />

                                <input class="icon_div_value" id="" name="row_text_icon_<?php echo $j; ?>" type="hidden" value="<?php echo esc_html($get_data->row_text_name); ?>" />

                             

                            <button class="set_custom_images button button_icon" <?php if($get_data->tab_option == 'text' || $get_data->tab_option == 'icon') { ?> style="display: none;" <?php } ?> trid="row-<?php echo $j; ?>">Set Icon</button>

                            <!-- IMAGE PART [END] -->

                            <div class="select_icon_div" <?php if($get_data->tab_option == 'text' || $get_data->tab_option == 'upload_icon') { ?> style="display: none;" <?php } ?>>
                            <?php foreach ($scandirs as $scandir) { 

                                    $selected_values = plugins_url('image/'.$scandir, dirname(__FILE__) );
                                    $selected = $selected_values == $get_data->row_text_name ? 'checked' : '';
                                    //$display = $selected_values == $get_data->row_text_name ? 'block' : 'none';
                                    $s_array = explode( '.' , $scandir );
                                    $id = strtolower( $s_array[0] );

                                    $display = 'none';
                                    if( $get_data->type_of_tabs == 'location' && ( $scandir == 'Place.png' || $scandir == 'Place2.gif') ) {

                                    	$display = 'inline-block';
                                    }
                                    if( $get_data->type_of_tabs == 'mail' && ( $scandir == 'Mail.png' || $scandir == 'Mail2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }
                                    if( $get_data->type_of_tabs == 'phone' && ( $scandir == 'Call.png' || $scandir == 'Call2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }

                                    if( $get_data->type_of_tabs == 'waze' && ( $scandir == 'wiz.png' || $scandir == 'wiz2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }

                                    if( $get_data->type_of_tabs == 'link' && ( $scandir == 'Web.png' || $scandir == 'Web2.gif' || $scandir == 'f.png' || $scandir == 'f2.gif' || $scandir == 'gPlus.png' || $scandir == 'gPlus2.gif'  || $scandir == 'home.png' || $scandir == 'home2.gif' || $scandir == 'Web.png' || $scandir == 'Web2.gif' || $scandir == 'in.png' || $scandir == 'in2.gif' || $scandir == 'Ins.png' || $scandir == 'Ins2.gif' || $scandir == 'Pin.png' || $scandir == 'Pin2.gif' || $scandir == 'Tube.png' || $scandir == 'Tube2.gif' || $scandir == 'Video.png' || $scandir == 'Video2.gif' || $scandir == 'Twit.png' || $scandir == 'Twit2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }
                                    if( $get_data->type_of_tabs == 'sms' && ( $scandir == 'Sms.png' || $scandir == 'Sms2.gif') ) {

                                    	$display = 'inline-block';
                                    }
                                    if( $get_data->type_of_tabs == 'whatsapp' && ( $scandir == 'wsap.png' || $scandir == 'wsap2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }
                                    if( $get_data->type_of_tabs == 'skypechat' && ( $scandir == 'Skype.png' || $scandir == 'Skype2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }
                                    if( $get_data->type_of_tabs == 'skypecall' && ( $scandir == 'Skype.png' || $scandir == 'Skype2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }
                                    if( $get_data->type_of_tabs == 'viber' && ( $scandir == 'vibe.png' || $scandir == 'vibe2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }
                                    if( $get_data->type_of_tabs == 'share' && ( $scandir == 'Share.png' || $scandir == 'Share2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }
                                    if( $get_data->type_of_tabs == 'telegram' && ( $scandir == 'Telegram.png' || $scandir == 'Telegram2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }
                                    if( $get_data->type_of_tabs == 'messenger' && ( $scandir == 'Fchat.png'  || $scandir == 'Fchat2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }
                                    if( $get_data->type_of_tabs == 'cart' && ( $scandir == 'Basket.png' || $scandir == 'Basket2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }
                                    if( $get_data->type_of_tabs == 'popup_form' && ( $scandir == 'Form.png' || $scandir == 'Form2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }
                                    if( $get_data->type_of_tabs == 'product_popup' && ( $scandir == 'Sale.png' || $scandir == 'Sale2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }
									if( $get_data->type_of_tabs == 'image_popup' && ( $scandir == 'popup-img.png' || $scandir == 'popup-img2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }
									if( $get_data->type_of_tabs == 'video_popup' && ( $scandir == 'video-pop.png' || $scandir == 'video-pop2.gif' ) ) {

                                    	$display = 'inline-block';
                                    }
									if( $get_data->type_of_tabs == 'line' && ( $scandir == 'line-app.png' || $scandir == 'line-app2.png' ) ) {

                                    	$display = 'inline-block';
                                    }
									if( $get_data->type_of_tabs == 'kakaotalk' && ( $scandir == 'kakaotalk.png' || $scandir == 'kakaotalk2.png' ) ) {

                                    	$display = 'inline-block';  
                                    }
									if( $get_data->type_of_tabs == 'wechat' && ( $scandir == 'wechat.png' || $scandir == 'wechat2.png' ) ) {

                                    	$display = 'inline-block'; 
                                    }

                            ?>
                            <span id="row-<?php echo $j.$id ?>" style="display:<?php echo $display ?>"><input type="radio" name="mobile_tab_select_icon_<?php echo $j; ?>" trid="row-<?php echo $j; ?>" value="<?php echo plugins_url('image/'.$scandir, dirname(__FILE__) ); ?>" id="row-<?php echo $j.$id ?>" <?php echo $selected; ?>  class="imageSelect" data-image="<?php echo plugins_url('image/'.$scandir, dirname(__FILE__) ); ?>"></span>
							

                                    <!--<img src="" width="25px" />-->

                            <?php  } ?>
                            &nbsp;
                            </div>

                        </div>
						
                            <!-- IMAGE PART [END] -->	

                        <!-- IMAGE PART [START] -->

                        <div class="row-column row-column-image-height-field">

                            <input class="image_height_div" name="mobile_tab_images_height_<?php echo $j; ?>" type="text"  placeholder="Set Height(auto)" value="<?php echo esc_html($get_data->row_text_image_height); ?>" <?php if($get_data->tab_option == 'text') { ?> style="display: none;" <?php } ?> />

                        </div>



                        <!-- IMAGE PART [END] -->
                        <div class="row-column row-column-row-text-link-field" <?php if($get_data->type_of_tabs == 'share' ) { ?>style="display: none;"<?php } ?>>

                            <input type="text" name="row_text_link_<?php echo $j; ?>" value="<?php echo esc_html($get_data->row_text_link); ?>" class="row_text_link" placeholder="Tab info" trid="row-<?php echo $j; ?>" />

                        </div>
                        

                        <!--    SHARE LINK [START]  -->

                        <div class="row-column row-column-row-text-share-field" <?php if($get_data->type_of_tabs == 'share') { ?>style="display: block;"<?php } ?>>

                            <?php $exploadDatas = explode(',',$get_data->row_text_share_data); ?>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/facebook.png', dirname(__FILE__)); ?>" />

                                <input type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_<?php echo $j; ?>[]" trid="row-<?php echo $j; ?>" value="facebook" <?php if (in_array('facebook', $exploadDatas)) {?> checked <?php } ?>>

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/gplus.png', dirname(__FILE__)); ?>" />

                                <input type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_<?php echo $j; ?>[]" trid="row-<?php echo $j; ?>" value="gplus" <?php if (in_array('gplus', $exploadDatas)) {?> checked <?php } ?>>

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/twitter.png', dirname(__FILE__)); ?>" />

                                <input type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_<?php echo $j; ?>[]" trid="row-<?php echo $j; ?>" value="twitter" <?php if (in_array('twitter', $exploadDatas)) {?> checked <?php } ?>>

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/linkedin.png', dirname(__FILE__)); ?>" />

                                <input type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_<?php echo $j; ?>[]" trid="row-<?php echo $j; ?>" value="linkedin" <?php if (in_array('linkedin', $exploadDatas)) {?> checked <?php } ?>>

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/reddit.png', dirname(__FILE__)); ?>" />

                                <input type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_<?php echo $j; ?>[]" trid="row-<?php echo $j; ?>" value="reddit" <?php if (in_array('reddit', $exploadDatas)) {?> checked <?php } ?>>

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/pintrest.png', dirname(__FILE__)); ?>" />

                                <input type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_<?php echo $j; ?>[]" trid="row-<?php echo $j; ?>" value="pintrest" <?php if (in_array('pintrest', $exploadDatas)) {?> checked <?php } ?>>

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/sms.png', dirname(__FILE__)); ?>" />

                                <input type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_<?php echo $j; ?>[]" trid="row-<?php echo $j; ?>" value="sms" <?php if (in_array('sms', $exploadDatas)) {?> checked <?php } ?>>

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/mail.png', dirname(__FILE__)); ?>" />

                                <input type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_<?php echo $j; ?>[]" trid="row-<?php echo $j; ?>" value="mail" <?php if (in_array('mail', $exploadDatas)) {?> checked <?php } ?>>

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/viber.png', dirname(__FILE__)); ?>" />

                                <input type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_<?php echo $j; ?>[]" trid="row-<?php echo $j; ?>" value="viber" <?php if (in_array('viber', $exploadDatas)) {?> checked <?php } ?>>

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/whatsapp.png', dirname(__FILE__)); ?>" />

                                <input type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_<?php echo $j; ?>[]" trid="row-<?php echo $j; ?>" value="whatsapp" <?php if (in_array('whatsapp', $exploadDatas)) {?> checked <?php } ?>>

                            </label>

                            

                        </div>

                        <!--    SHARE LINK [END]    -->


                        <div class="row-column row-column-row-text-optional">
<?php if($get_data->tab_option != 'text') { 


 ?>
                            <input type="text" name="row_text_optional_<?php echo $j; ?>" value="<?php echo esc_html($get_data->row_text_optional); ?>" placeholder="Text optional" />
<?php } ?>


                            <span class="row-column row-column-popup-field" <?php if($get_data->type_of_tabs == 'popup_form') { ?>style="display: block;"<?php } ?>>
                            <input type="text" placeholder="shortcode" name="row_text_shortcode_<?php echo $j; ?>" value="<?php echo esc_html($get_data->row_text_shortcode); ?>" trid="row-<?php echo $j; ?>" />
                            <input type="text" name="row_text_popup_time_<?php echo $j; ?>" placeholder="time in seconds" value="<?php echo esc_html($get_data->row_text_popup_time); ?>" trid="row-<?php echo $j; ?>" />
                            <textarea class="" name="row_textarea_<?php echo $j; ?>" cols="14" trid="row-<?php echo $j; ?>" placeholder="text"><?php echo esc_html($get_data->row_textarea); ?></textarea>
                            <span style="width: 100%; float: left; text-align:left; padding: 0 12px;"><input type="checkbox" name="popup_field_daily_<?php echo $j; ?>" value="1" <?php if ($get_data->popup_field_daily =='yes'){ ?> checked <?php  } echo $get_data->popup_field_daily; ?> /> Show Once Daily</span></span>

                            <span class="row-column row-column-product-field" <?php if($get_data->type_of_tabs == 'product_popup') { ?>style="display: block;"<?php } ?>><?php mtabs_pr_pages( 'row_text_product_'.$j, $get_data->row_text_product ); ?><input type="text" name="row_text_timer_<?php echo $j; ?>" placeholder="Timer in minutes" value="<?php echo esc_html($get_data->row_text_timer); ?>" class="row_text_timer" trid="row-<?php echo $j; ?>" /><input type="text" name="row_text_time_<?php echo $j; ?>" placeholder="time" class="row_text_time" trid="row-<?php echo $j; ?>" value="<?php echo esc_html($get_data->row_text_time); ?>" />
                             <span style="width: 100%; float: left; text-align:left; padding: 0 12px;"><input type="checkbox" name="product_field_daily_<?php echo $j; ?>" value="1" <?php if ($get_data->product_field_daily =='yes'){ ?> checked <?php  } echo $get_data->popup_field_daily; ?> /> Show Once Daily</span></span>
							 
							
							
							<span class="row-column row-column-popup-image-field" <?php if($get_data->type_of_tabs == 'image_popup') { ?>style="display: block;"<?php } ?>>
							
							<!--- ******************* row popup image retrive ************---->					
                            <img src="<?php echo esc_url($get_data->row_pop_img); ?>" <?php if(esc_url($get_data->row_pop_img) == ''){?>  <?php } ?> name="row_pop_img_<?php echo $j; ?>" class="img_pop_div" trid="row-<?php echo $j; ?>" />

                            <input class="img_pop_div_value" id="" name="row_pop_img_<?php echo $j; ?>" type="hidden" value="<?php echo esc_html($get_data->row_pop_img); ?>" />

                            <button class="set_custom_pop_images button button_image" <?php if(esc_url($get_data->row_pop_img) == ''){?>  <?php } ?> trid="row-<?php echo $j; ?>">Set Image</button>
							<!--- ******************* row popup image retrive ************--->
							
                            <input type="text" class="row_text_pop_img_optional" placeholder="Image link" name="row_text_pop_image_<?php echo $j; ?>" value="<?php echo esc_html($get_data->row_text_pop_image); ?>" trid="row-<?php echo $j; ?>" />
                            <input type="text" name="row_text_popup_image_time_<?php echo $j; ?>" placeholder="time in seconds" value="<?php echo esc_html($get_data->row_text_popup_image_time); ?>" trid="row-<?php echo $j; ?>" />
                            <textarea class="" name="row_pop_img_textarea_<?php echo $j; ?>" cols="14" trid="row-<?php echo $j; ?>" placeholder="text"><?php echo esc_html($get_data->row_pop_img_textarea); ?></textarea>
                            <span style=" width: 100%; float: left; text-align:left; padding: 0 12px;"><input type="checkbox" name="popup_image_field_daily_<?php echo $j; ?>" value="1" <?php if ($get_data->popup_image_field_daily =='yes'){ ?> checked <?php  } echo $get_data->popup_image_field_daily; ?> /> Show Once Daily</span></span>
							

							<span class="row-column row-column-popup-video-field" <?php if($get_data->type_of_tabs == 'video_popup') { ?>style="display: block;"<?php } ?>>
							
                            <input type="text" class="row_text_pop_video_optional" placeholder="Link of video" name="row_text_pop_video_<?php echo $j; ?>" value="<?php echo esc_html($get_data->row_text_pop_video); ?>" trid="row-<?php echo $j; ?>" />
                            <input type="text" name="row_text_popup_video_time_<?php echo $j; ?>" placeholder="time in seconds" value="<?php echo esc_html($get_data->row_text_popup_video_time); ?>" trid="row-<?php echo $j; ?>" />
                            <textarea class="" name="row_pop_video_textarea_<?php echo $j; ?>" cols="14" trid="row-<?php echo $j; ?>" placeholder="text"><?php echo esc_html($get_data->row_pop_video_textarea); ?></textarea>
                            <span style="width: 100%; float: left; text-align:left; padding: 0 12px;"><input type="checkbox" name="popup_video_field_daily_<?php echo $j; ?>" value="1" <?php if ($get_data->popup_video_field_daily =='yes'){ ?> checked <?php  } echo $get_data->popup_video_field_daily; ?> /> Show Once Daily</span></span>		


				<div class="row-column row-column-background-color" style=<?php if($get_data->type_of_tabs == 'popup_form' || $get_data->type_of_tabs == 'product_popup' || $get_data->type_of_tabs == 'image_popup' || $get_data->type_of_tabs == 'video_popup'){ echo "display: inline-block !important;"; } else{ echo "display:none;"; }?>>
				<div class="clr-check">
				<input type="checkbox" trid="row-<?php echo $j; ?>" name="pop_border_clr_check_<?php echo $j; ?>" value="popup_border_color" <?php if($get_data->pop_border_clr_check =='popup_border_color'){ ?> checked <?php } ?> id="backgroundRadioColor2" /> 
				(choose border color)
				</div>
				<div>
				<input type="text" trid="row-<?php echo $j; ?>" style="width: 60px;" class="jscolor {hash:true} background-color-div" name="pop_border_clr_<?php echo $j; ?>" value="<?php echo esc_html($get_data->pop_border_clr); ?>" id="backgroundRadioColorText2">
				</div>
				</div>	

							
                            <!--    SHARE LINK Text[START]  -->

                            <div class="row-column row-column-row-text-shareText-field" <?php if($get_data->type_of_tabs == 'share') { ?>style="display: block;"<?php } ?>>

                                <textarea class="" name="mobile_tab_select_sharetext_<?php echo $j; ?>" trid="row-<?php echo $j; ?>" cols="14"><?php echo esc_html($get_data->row_text_share_data_text); ?></textarea>

                            </div>

                            <!--    SHARE LINK Text[END]    -->

                        </div>


                        
                        <div class="row-column row-column-row-delete-field">

                            <!--<button type="button" class="btn btn-small pull-right"><span class="icon-trash"></span>Delete</button>-->

                            <?php $complete_url = wp_nonce_url( admin_url().'options-general.php?page=mobile_tabs&id='.$get_data->id, 'delete_row', 'delete_row' ); ?>
                            
                            <!--<a href="options-general.php?page=mobile_tabs&delete_id=<?php echo $get_data->id; ?>" class="button button-danger">Delete</a>-->
                            <a href="<?php echo $complete_url; ?>" class="button button-danger"><i class="fa fa-trash" style="padding-right: 10px;"></i>Delete</a>

                        </div>

                        <div>

                            <input type="hidden" name="count" value="<?php echo $j; ?>" />

                        </div>

                    </div>
                <?php

                        $j++;

                        } ?>
						
						
						
					<?php if(!empty($get_mobile_tabs_datas) && count($get_mobile_tabs_datas) < 2 ){ ?>

				<div id="row-2" class="row-column-section" style="display:none">
					
					<div class="row-column row-column-fa">
                            <div class="mydrag">
							  <span class="grippy"></span>
							</div> 
                        </div>
					
					<div class="row-column row-column-fa">
					<input type="text" trid="row-2" style="width: 38px; min-height: 25px; padding: 2px 6px;" class="jscolor newcolor {hash:true} background-color-div" name="icon_back_clr_2" value="">
					
					<input type="hidden" class="removeColor" name="remove_color_2" trid="row-2" value="0" />
						<a style="cursor: pointer; display:none;" class="removeLink" trid="row-2">Remove</a>
					</div>
					
					
                    	<div class="row-column row-column-fa">
                    		<input onClick="divFunction(this)" checked="checked" type="checkbox" class="desktop-clss" name="row_text_display_2" value="1" />
                    	</div>
						
						<!-- add checkbox for mobile view -->
						<div class="row-column row-column-fa">
                    		<input onClick="divFunction1(this)" checked="checked" type="checkbox" class="mobile-clss" name="row_text_mobile_display_2" value="1" />
                    	</div>

                        <div class="row-column row-column-tab-option-field">

                            <label>Tab option</label>
                            <select name="tab_option_2" trid="row-2" class="tab_option">

                                <option value="">Tab option</option>

                                <option value="text">Text</option>

                                <option value="icon">Icon</option>

                                <option value="upload_icon">Upload Icon</option>

                            </select>

                        </div>

                        <div class="row-column row-column-type-of-tab-field">

                            <label>Type of Tabs</label>

                            <select name="type_of_tabs_2" class="type_of_tabs" trid="row-2">
                                <option value="">Type of Tab</option>
                                <option value="phone">Phone</option>
                                <option value="mail">Mail</option>
                                <option value="waze">Waze</option>
                                <option value="link">Link</option>
                                <option value="sms">Sms</option>
                                <option value="location">Location</option>
                                <option value="whatsapp">Whats app</option>
                                <option value="skypechat">Skype chat</option>
                                <option value="skypecall">Skype Call</option>
                                <option value="viber">Viber</option>
                                <option value="share">Share</option>
                                <option value="telegram">Telegram</option>
                                <option value="messenger">Facebook Messenger</option>
                                <option value="cart">WooCommerce Cart</option>
                                <option value="popup_form">Popup Form</option>
                                <option value="product_popup">Product Popup</option>
								<option value="image_popup">Image Popup</option>
								<option value="video_popup">Video Popup</option>
                            </select>

                        </div>		
						
						
                        <div class="row-column row-column-row-name-field">

                            <input type="text" name="row_text_name_2" placeholder="Row Name" trid="row-2" class="text_div" />

                            <!--<input class="icon_div" id="" name="row_text_name_1" type="text" placeholder="Select Icon" value="" trid="row-1" />-->

                            <img src="" class="icon_div" name="row_text_icon_2" trid="row-2" id=""  />

                            <input class="icon_div_value" name="row_text_icon_2" type="hidden" placeholder="Select Icon" value=""  />

                            <button style="display:none;" class="set_custom_images button button_icon" trid="row-2">Set Icon</button>

                            <div class="select_icon_div">
                                <?php foreach ($scandirs as $scandir) {
                                    $s_array = explode( '.' , $scandir );
                                    $id = strtolower( $s_array[0] );
                                    ?>
                                    <span id="row-2<?php echo $id ?>" style="display:none"><input type="radio" name="mobile_tab_select_icon_2" id="row-2<?php echo $id ?>" trid="row-2" value="<?php echo plugins_url('image/'.$scandir, dirname(__FILE__) ); ?>" class="imageSelect" data-image="<?php echo plugins_url('image/'.$scandir, dirname(__FILE__) ); ?>" ></span>
                                <?php } ?>
                                &nbsp;
                            </div>
                            </div>
						
						

                        <div class="row-column row-column-image-height-field">

                            <input class="image_height_div" name="mobile_tab_images_height_2" type="text" placeholder="Set Height(auto)" value="" />

                        </div>

                        <div class="row-column row-column-row-text-link-field">

                            <input type="text" name="row_text_link_2" placeholder="Tab info" class="row_text_link" trid="row-2" />

                        </div>

                        <!--    SHARE LINK [START]  -->

                        <div class="row-column row-column-row-text-share-field">

                            <label>

                                <img src="<?php echo plugins_url('assets/img/facebook.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="facebook">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/gplus.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="gplus">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/twitter.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="twitter">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/linkedin.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="linkedin">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/reddit.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="reddit">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/pintrest.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="pintrest">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/sms.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="sms">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/mail.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="mail">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/viber.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="viber">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/whatsapp.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="whatsapp">

                            </label>

                        </div>

                        <div class="row-column row-column-row-text-optional">

                            <input type="text" name="row_text_optional_2" class="row_text_optional image-text" trid="row-2" placeholder="Text optional" />

                            <span class="row-column row-column-popup-field"><input type="text" name="row_text_shortcode_2" placeholder="shortcode" class="row_text_optional" trid="row-2" /><input type="text" name="row_text_popup_time_2" placeholder="time in seconds" class="row_text_optional" trid="row-2" /><textarea class="" name="row_textarea_2" cols="14" trid="row-2" placeholder="text"></textarea><span style="width: 100%; float: left; text-align:left; padding: 0 12px;"><input type="checkbox" name="popup_field_daily_2" value="1" /> Show Once Daily</span></span>


	                        <span class="row-column row-column-product-field"><?php mtabs_pr_pages('	'); ?><input type="text" name="row_text_timer_2" placeholder="Timer in minutes" class="row_text_timer" trid="row-2" /><input type="text" name="row_text_time_2" placeholder="time" class="row_text_time" trid="row-2" />
	                        	<span style="width: 100%; float: left; text-align:left; padding: 0 12px;"><input type="checkbox" name="product_field_daily_2" value="1" /> Show Once Daily</span>
	                        </span>
							
							<span class="row-column row-column-popup-image-field">
							<!---  set upload image popup ------>
                            <img src="" class="img_pop_div" name="row_pop_img_2" trid="row-2" id="" />

                            <input class="img_pop_div_value" name="row_pop_img_2" type="hidden" placeholder="Select Image" value=""  />

                            <button class="set_custom_pop_images button button_image" trid="row-2">Set Image</button>
							<!---  end set upload image popup ------>
							<input type="text" name="row_text_pop_image_2" placeholder="Image link" class="row_text_pop_img_optional" trid="row-2" />
							<input type="text" name="row_text_popup_image_time_2" placeholder="time in seconds" class="row_text_optional2" trid="row-2" />
							<textarea class="" name="row_pop_img_textarea_2" cols="14" trid="row-2" placeholder="text"></textarea><span style="width: 100%; float: left; text-align:left; padding: 0 12px;">
							<input type="checkbox" name="popup_image_field_daily_2" value="1" /> Show Once Daily</span>
							</span>
							
							
							<span class="row-column row-column-popup-video-field">
							<input type="text" name="row_text_pop_video_2" placeholder="Link of video" class="row_text_pop_video_optional" trid="row-2" />
							<input type="text" name="row_text_popup_video_time_2" placeholder="time in seconds" class="row_text_optional2" trid="row-2" />
							<textarea class="" name="row_pop_video_textarea_2" cols="14" trid="row-2" placeholder="text"></textarea><span style="width: 100%; float: left; text-align:left; padding: 0 12px;">
							<input type="checkbox" name="popup_video_field_daily_2" value="1" /> Show Once Daily</span>
							</span>
							
								
							<div class="row-column row-column-background-color" style="display:none;">
							<div class="clr-check">
							<input type="checkbox" trid="row-2" name="pop_border_clr_check_2" value="popup_border_color" id="backgroundRadioColor2" /> (choose border color)
							</div>	
							<div>
							<input type="text" trid="row-2" style="width: 60px;" class="jscolor {hash:true} background-color-div" name="pop_border_clr_2" value="" id="backgroundRadioColorText2">
							</div>
							</div>
							
							
	                        <div class="row-column row-column-row-text-shareText-field">

                                <textarea class="" name="mobile_tab_select_sharetext_2" trid="row-2" cols="14"></textarea>

                            </div>

                        </div>

                        <!--    SHARE LINK Text[END]    -->
                        <input type="hidden" name="count" value="2" />
                        <input type="hidden" name="countt" id="countt" value="0" />
						
						
                    </div>	

			<?php } ?>	
						
						
						
						
						

                   <?php } else {

                ?>
				

                    <div id="row-1" class="row-column-section">
					
					<div class="row-column row-column-fa">
                            <div class="mydrag">
							  <span class="grippy"></span>
							</div> 
                        </div>
					
					<div class="row-column row-column-fa">
					<input type="text" trid="row-1" style="width: 38px; min-height: 25px; padding: 2px 6px;" class="jscolor newcolor {hash:true} background-color-div" name="icon_back_clr_1" value="">
					
					<input type="hidden" class="removeColor" name="remove_color_1" trid="row-1" value="0" />
						<a style="cursor: pointer; display:none;" class="removeLink" trid="row-1">Remove</a>
					</div>
					
					
                    	<div class="row-column row-column-fa">
                    		<input onClick="divFunction(this)" checked="checked" type="checkbox" class="desktop-clss" name="row_text_display_1" value="1" />
                    	</div>
						
						<!-- add checkbox for mobile view -->
						<div class="row-column row-column-fa">
                    		<input onClick="divFunction1(this)" checked="checked" type="checkbox" class="mobile-clss" name="row_text_mobile_display_1" value="1" />
                    	</div>

                        <div class="row-column row-column-tab-option-field">

                            <label>Tab option</label>
                            <select name="tab_option_1" trid="row-1" class="tab_option">

                                <option value="">Tab option</option>

                                <option value="text">Text</option>

                                <option value="icon">Icon</option>

                                <option value="upload_icon">Upload Icon</option>

                            </select>

                        </div>

                        <div class="row-column row-column-type-of-tab-field">

                            <label>Type of Tabs</label>

                            <select name="type_of_tabs_1" class="type_of_tabs" trid="row-1">
                                <option value="">Type of Tab</option>
                                <option value="phone">Phone</option>
                                <option value="mail">Mail</option>
                                <option value="waze">Waze</option>
                                <option value="link">Link</option>
                                <option value="sms">Sms</option>
                                <option value="location">Location</option>
                                <option value="whatsapp">Whats app</option>
                                <option value="skypechat">Skype chat</option>
                                <option value="skypecall">Skype Call</option>
                                <option value="viber">Viber</option>
                                <option value="share">Share</option>
                                <option value="telegram">Telegram</option>
                                <option value="messenger">Facebook Messenger</option>
                                <option value="cart">WooCommerce Cart</option>
                                <option value="popup_form">Popup Form</option>
                                <option value="product_popup">Product Popup</option>
								<option value="image_popup">Image Popup</option>
								<option value="video_popup">Video Popup</option>
                            </select>

                        </div>		
						
						
                        <div class="row-column row-column-row-name-field">

                            <input type="text" name="row_text_name_1" placeholder="Row Name" trid="row-1" class="text_div" />

                            <!--<input class="icon_div" id="" name="row_text_name_1" type="text" placeholder="Select Icon" value="" trid="row-1" />-->

                            <img src="" class="icon_div" name="row_text_icon_1" trid="row-1" id=""  />

                            <input class="icon_div_value" name="row_text_icon_1" type="hidden" placeholder="Select Icon" value=""  />

                            <button class="set_custom_images button button_icon" trid="row-1">Set Icon</button>

                            <div class="select_icon_div">
                                <?php foreach ($scandirs as $scandir) {
                                    $s_array = explode( '.' , $scandir );
                                    $id = strtolower( $s_array[0] );
                                    ?>
                                    <span id="row-1<?php echo $id ?>" style="display:none"><input type="radio" name="mobile_tab_select_icon_1" id="row-1<?php echo $id ?>" trid="row-1" value="<?php echo plugins_url('image/'.$scandir, dirname(__FILE__) ); ?>" class="imageSelect" data-image="<?php echo plugins_url('image/'.$scandir, dirname(__FILE__) ); ?>" ></span>
                                <?php } ?>
                                &nbsp;
                            </div>
                            </div>
						
						

                        <div class="row-column row-column-image-height-field">

                            <input class="image_height_div" name="mobile_tab_images_height_1" type="text" placeholder="Set Height(auto)" value="" />

                        </div>

                        <div class="row-column row-column-row-text-link-field">

                            <input type="text" name="row_text_link_1" placeholder="Tab info" class="row_text_link" trid="row-1" />

                        </div>

                        <!--    SHARE LINK [START]  -->

                        <div class="row-column row-column-row-text-share-field">

                            <label>

                                <img src="<?php echo plugins_url('assets/img/facebook.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_1[]" trid="row-1" value="facebook">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/gplus.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_1[]" trid="row-1" value="gplus">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/twitter.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_1[]" trid="row-1" value="twitter">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/linkedin.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_1[]" trid="row-1" value="linkedin">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/reddit.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_1[]" trid="row-1" value="reddit">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/pintrest.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_1[]" trid="row-1" value="pintrest">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/sms.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_1[]" trid="row-1" value="sms">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/mail.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_1[]" trid="row-1" value="mail">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/viber.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_1[]" trid="row-1" value="viber">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/whatsapp.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_1[]" trid="row-1" value="whatsapp">

                            </label>

                        </div>

                        <div class="row-column row-column-row-text-optional">

                            <input type="text" name="row_text_optional_1" class="row_text_optional image-text" trid="row-1" placeholder="Text optional" />

                            <span class="row-column row-column-popup-field"><input type="text" name="row_text_shortcode_1" placeholder="shortcode" class="row_text_optional" trid="row-1" /><input type="text" name="row_text_popup_time_1" placeholder="time in seconds" class="row_text_optional" trid="row-1" /><textarea class="" name="row_textarea_1" cols="14" trid="row-1" placeholder="text"></textarea><span style="width: 100%; float: left; text-align:left; padding: 0 12px;"><input type="checkbox" name="popup_field_daily_1" value="1" /> Show Once Daily</span></span>


	                        <span class="row-column row-column-product-field"><?php mtabs_pr_pages('	'); ?><input type="text" name="row_text_timer_1" placeholder="Timer in minutes" class="row_text_timer" trid="row-1" /><input type="text" name="row_text_time_1" placeholder="time" class="row_text_time" trid="row-1" />
	                        	<span style="width: 100%; float: left; text-align:left; padding: 0 12px;"><input type="checkbox" name="product_field_daily_1" value="1" /> Show Once Daily</span>
	                        </span>
							
							<span class="row-column row-column-popup-image-field">
							<!---  set upload image popup ------>
                            <img src="" class="img_pop_div" name="row_pop_img_1" trid="row-1" id="" />

                            <input class="img_pop_div_value" name="row_pop_img_1" type="hidden" placeholder="Select Image" value=""  />

                            <button class="set_custom_pop_images button button_image" trid="row-1">Set Image</button>
							<!---  end set upload image popup ------>
							<input type="text" name="row_text_pop_image_1" placeholder="Image link" class="row_text_pop_img_optional" trid="row-1" />
							<input type="text" name="row_text_popup_image_time_1" placeholder="time in seconds" class="row_text_optional2" trid="row-1" />
							<textarea class="" name="row_pop_img_textarea_1" cols="14" trid="row-1" placeholder="text"></textarea><span style="width: 100%; float: left; text-align:left; padding: 0 12px;">
							<input type="checkbox" name="popup_image_field_daily_1" value="1" /> Show Once Daily</span>
							</span>
							
							
							<span class="row-column row-column-popup-video-field">
							<input type="text" name="row_text_pop_video_1" placeholder="Link of video" class="row_text_pop_video_optional" trid="row-1" />
							<input type="text" name="row_text_popup_video_time_1" placeholder="time in seconds" class="row_text_optional2" trid="row-1" />
							<textarea class="" name="row_pop_video_textarea_1" cols="14" trid="row-1" placeholder="text"></textarea><span style="width: 100%; float: left; text-align:left; padding: 0 12px;">
							<input type="checkbox" name="popup_video_field_daily_1" value="1" /> Show Once Daily</span>
							</span>
							
								
							<div class="row-column row-column-background-color" style="display:none;">
							<div class="clr-check">
							<input type="checkbox" trid="row-1" name="pop_border_clr_check_1" value="popup_border_color" id="backgroundRadioColor1" /> (choose border color)
							</div>	
							<div>
							<input type="text" trid="row-1" style="width: 60px;" class="jscolor {hash:true} background-color-div" name="pop_border_clr_1" value="" id="backgroundRadioColorText1">
							</div>
							</div>
							
							
	                        <div class="row-column row-column-row-text-shareText-field">

                                <textarea class="" name="mobile_tab_select_sharetext_1" trid="row-1" cols="14"></textarea>

                            </div>

                        </div>

                        <!--    SHARE LINK Text[END]    -->
                        <input type="hidden" name="count" value="1" />
						
						
                    </div>
					
					
					
					<div id="row-2" class="row-column-section" style="display:none">
					
					<div class="row-column row-column-fa">
                            <div class="mydrag">
							  <span class="grippy"></span>
							</div> 
                        </div>
					
					<div class="row-column row-column-fa">
					<input type="text" trid="row-2" style="width: 38px; min-height: 25px; padding: 2px 6px;" class="jscolor newcolor {hash:true} background-color-div" name="icon_back_clr_2" value="">
					
					<input type="hidden" class="removeColor" name="remove_color_2" trid="row-2" value="0" />
						<a style="cursor: pointer; display:none;" class="removeLink" trid="row-2">Remove</a>
					</div>
					
					
                    	<div class="row-column row-column-fa">
                    		<input onClick="divFunction(this)" checked="checked" type="checkbox" class="desktop-clss" name="row_text_display_2" value="1" />
                    	</div>
						
						<!-- add checkbox for mobile view -->
						<div class="row-column row-column-fa">
                    		<input onClick="divFunction1(this)" checked="checked" type="checkbox" class="mobile-clss" name="row_text_mobile_display_2" value="1" />
                    	</div>

                        <div class="row-column row-column-tab-option-field">

                            <label>Tab option</label>
                            <select name="tab_option_2" trid="row-2" class="tab_option">

                                <option value="">Tab option</option>

                                <option value="text">Text</option>

                                <option value="icon">Icon</option>

                                <option value="upload_icon">Upload Icon</option>

                            </select>

                        </div>

                        <div class="row-column row-column-type-of-tab-field">

                            <label>Type of Tabs</label>

                            <select name="type_of_tabs_2" class="type_of_tabs" trid="row-2">
                                <option value="">Type of Tab</option>
                                <option value="phone">Phone</option>
                                <option value="mail">Mail</option>
                                <option value="waze">Waze</option>
                                <option value="link">Link</option>
                                <option value="sms">Sms</option>
                                <option value="location">Location</option>
                                <option value="whatsapp">Whats app</option>
                                <option value="skypechat">Skype chat</option>
                                <option value="skypecall">Skype Call</option>
                                <option value="viber">Viber</option>
                                <option value="share">Share</option>
                                <option value="telegram">Telegram</option>
                                <option value="messenger">Facebook Messenger</option>
                                <option value="cart">WooCommerce Cart</option>
                                <option value="popup_form">Popup Form</option>
                                <option value="product_popup">Product Popup</option>
								<option value="image_popup">Image Popup</option>
								<option value="video_popup">Video Popup</option>
                            </select>

                        </div>		
						
						
                        <div class="row-column row-column-row-name-field">

                            <input type="text" name="row_text_name_2" placeholder="Row Name" trid="row-2" class="text_div" />

                            <!--<input class="icon_div" id="" name="row_text_name_1" type="text" placeholder="Select Icon" value="" trid="row-1" />-->

                            <img src="" class="icon_div" name="row_text_icon_2" trid="row-2" id=""  />

                            <input class="icon_div_value" name="row_text_icon_2" type="hidden" placeholder="Select Icon" value=""  />

                            <button class="set_custom_images button button_icon" trid="row-2">Set Icon</button>

                            <div class="select_icon_div">
                                <?php foreach ($scandirs as $scandir) {
                                    $s_array = explode( '.' , $scandir );
                                    $id = strtolower( $s_array[0] );
                                    ?>
                                    <span id="row-2<?php echo $id ?>" style="display:none"><input type="radio" name="mobile_tab_select_icon_2" id="row-2<?php echo $id ?>" trid="row-2" value="<?php echo plugins_url('image/'.$scandir, dirname(__FILE__) ); ?>" class="imageSelect" data-image="<?php echo plugins_url('image/'.$scandir, dirname(__FILE__) ); ?>" ></span>
                                <?php } ?>
                                &nbsp;
                            </div>
                            </div>
						
						

                        <div class="row-column row-column-image-height-field">

                            <input class="image_height_div" name="mobile_tab_images_height_2" type="text" placeholder="Set Height(auto)" value="" />

                        </div>

                        <div class="row-column row-column-row-text-link-field">

                            <input type="text" name="row_text_link_2" placeholder="Tab info" class="row_text_link" trid="row-2" />

                        </div>

                        <!--    SHARE LINK [START]  -->

                        <div class="row-column row-column-row-text-share-field">

                            <label>

                                <img src="<?php echo plugins_url('assets/img/facebook.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="facebook">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/gplus.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="gplus">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/twitter.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="twitter">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/linkedin.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="linkedin">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/reddit.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="reddit">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/pintrest.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="pintrest">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/sms.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="sms">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/mail.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="mail">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/viber.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="viber">

                            </label>

                            <label>

                                <img src="<?php echo plugins_url('assets/img/whatsapp.png', dirname(__FILE__)); ?>" />

                                <input checked="checked" type="checkbox" class="share_checkbox" name="mobile_tab_select_shareicon_2[]" trid="row-2" value="whatsapp">

                            </label>

                        </div>

                        <div class="row-column row-column-row-text-optional">

                            <input type="text" name="row_text_optional_2" class="row_text_optional image-text" trid="row-2" placeholder="Text optional" />

                            <span class="row-column row-column-popup-field"><input type="text" name="row_text_shortcode_2" placeholder="shortcode" class="row_text_optional" trid="row-2" /><input type="text" name="row_text_popup_time_2" placeholder="time in seconds" class="row_text_optional" trid="row-2" /><textarea class="" name="row_textarea_2" cols="14" trid="row-2" placeholder="text"></textarea><span style="width: 100%; float: left; text-align:left; padding: 0 12px;"><input type="checkbox" name="popup_field_daily_2" value="1" /> Show Once Daily</span></span>


	                        <span class="row-column row-column-product-field"><?php mtabs_pr_pages('	'); ?><input type="text" name="row_text_timer_2" placeholder="Timer in minutes" class="row_text_timer" trid="row-2" /><input type="text" name="row_text_time_2" placeholder="time" class="row_text_time" trid="row-2" />
	                        	<span style="width: 100%; float: left; text-align:left; padding: 0 12px;"><input type="checkbox" name="product_field_daily_2" value="1" /> Show Once Daily</span>
	                        </span>
							
							<span class="row-column row-column-popup-image-field">
							<!---  set upload image popup ------>
                            <img src="" class="img_pop_div" name="row_pop_img_2" trid="row-2" id="" />

                            <input class="img_pop_div_value" name="row_pop_img_2" type="hidden" placeholder="Select Image" value=""  />

                            <button class="set_custom_pop_images button button_image" trid="row-2">Set Image</button>
							<!---  end set upload image popup ------>
							<input type="text" name="row_text_pop_image_2" placeholder="Image link" class="row_text_pop_img_optional" trid="row-2" />
							<input type="text" name="row_text_popup_image_time_2" placeholder="time in seconds" class="row_text_optional2" trid="row-2" />
							<textarea class="" name="row_pop_img_textarea_2" cols="14" trid="row-2" placeholder="text"></textarea><span style="width: 100%; float: left; text-align:left; padding: 0 12px;">
							<input type="checkbox" name="popup_image_field_daily_2" value="1" /> Show Once Daily</span>
							</span>
							
							
							<span class="row-column row-column-popup-video-field">
							<input type="text" name="row_text_pop_video_2" placeholder="Link of video" class="row_text_pop_video_optional" trid="row-2" />
							<input type="text" name="row_text_popup_video_time_2" placeholder="time in seconds" class="row_text_optional2" trid="row-2" />
							<textarea class="" name="row_pop_video_textarea_2" cols="14" trid="row-2" placeholder="text"></textarea><span style="width: 100%; float: left; text-align:left; padding: 0 12px;">
							<input type="checkbox" name="popup_video_field_daily_2" value="1" /> Show Once Daily</span>
							</span>
							
								
							<div class="row-column row-column-background-color" style="display:none;">
							<div class="clr-check">
							<input type="checkbox" trid="row-2" name="pop_border_clr_check_2" value="popup_border_color" id="backgroundRadioColor2" /> (choose border color)
							</div>	
							<div>
							<input type="text" trid="row-2" style="width: 60px;" class="jscolor {hash:true} background-color-div" name="pop_border_clr_2" value="" id="backgroundRadioColorText2">
							</div>
							</div>
							
							
	                        <div class="row-column row-column-row-text-shareText-field">

                                <textarea class="" name="mobile_tab_select_sharetext_2" trid="row-2" cols="14"></textarea>

                            </div>

                        </div>

                        <!--    SHARE LINK Text[END]    -->
                        <input type="hidden" name="count" value="2" />
                        <input type="hidden" name="countt" id="countt" value="0" />
						
						
                    </div>
					

                <?php 

                    }

                ?>



            </div>

            <br/>
			<span id="tool_bottom_part">
		            <div id="bottom_part" style="overflow:hidden;overflow: hidden; background: #f1f1f1; padding: 20px 20px 50px 20px;border-radius:4px; margin-bottom:30px">
            <div class="margin-div-set" style="width:43%;float:left">
				
				
				<!--------scroll html code --------->
                <label><b>Margin top and bottom, if you want top add - before the number e.g <span style="font-weight: bold;" class="range-value"></span>px : </b></label>

                   <div class="range-slider">
                        <input name="mobile_tab_margin_set" class="input-range" orient="horizontal" type="range" step="1" value="" min="-500" max="500">
                    </div> 
				<!--------scroll html code --------->
				
				
				<!-- left right button -->
				<div class="left-right">
				<b>Choose Position of desktop bar:</b>
				<input type="hidden" name="position2" id="position2">
                <div class="onoffswitch">
				<?php $position = get_option( 'side_position' ); ?>
				<input type="checkbox" name="position" class="onoffswitch-checkbox" karan="<?php echo $position; ?>" id="myonoffswitch" value="0" <?php echo (($position == 1) ? '' : 'checked') ; ?> >
				<label class="onoffswitch-label" for="myonoffswitch">
					<span class="onoffswitch-inner"></span>
					<span class="onoffswitch-switch"></span>
				</label>
				</div>
				</div>
				<!-- end left right button -->
				

            </div>
            
		
			

            <div class="excluded_div" style="width:19%;float:left">

                <label><b>Excluded pages Id : </b></label>

                <select multiple name="excluded_pages[]" id="mtabs_pages" class="select2" style="width:150px;">
                    <option value=""></option>
                 </select>

            </div>

            <table style="width:16%;float:left">

                <tr>

                    <td valign="top">

                        <b>Analytic : </b><a href="" class="tipclass" title="This will show up in the TipTip popup."><span class="help-tip"></span></a>
						
						
						 <table>

                            <tr>

                                <td>

                                    <input type="radio" name="tracking" value="3" /> Google site tag 

                                </td>

                            </tr>

                            <tr>

                                <td>

                                    <input type="radio" name="tracking" value="2" /> Universal Analytics 

                                </td>

                            </tr>

                            <tr>

                                <td>

                                     <input type="radio" name="tracking" value="1" /> Classic Analytics 

                                </td>

                            </tr>

                            <tr>

                                <td>

                                    <input type="radio" name="tracking" value="0" checked /> None 

                                </td>

                            </tr>

                        </table>

                    </td>

                   

                       

                   

                </tr>

            </table>

            <div style="width:10%;float:left">

                <label><b>Font Size : </b><a href="" class="tipclass" title="This will show up in the TipTip popup."><span class="help-tip"></span></a></label>

                <input type="number" min="1" step="1" name="mobile_tab_font_size" value="" placeholder="12" />

            </div>
			
			
            <div style="width:8%;float:right">

                <label><b>Z-Index : </b><a href="" class="tipclass" title="This will show up in the TipTip popup."><span class="help-tip"></span></a></label><br>

                <input type="text" name="mobile_tab_z_index" value="" placeholder="999999" style="width:50px;height:36px;" />
                <input type="hidden" id="sortable_field" name="sortable_field" />

            </div>
        </div></span>
        </div>		
		
		<button type="button" class="button button-success insert_button "> <i class="fa fa-plus" style="padding-right: 10px;"></i> Add row</button>
		
        <input class="button button-primary button-large" style="background:#4476b8;color:#fff;font-weight: bold;" type="submit" name="submit" value="Submit">
        
        <?php wp_nonce_field( 'mobile-tabs-save-nonce' ); ?>

        </form>

    </div>

</div>
</div>
<style>
.left-right{
	margin: 17px 0 0;
}
.onoffswitch {
    position: relative; width: 90px;
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
}
.onoffswitch-checkbox {
    display: none;
}
.onoffswitch-label {
    display: block; overflow: hidden; cursor: pointer;
    border: 2px solid #999999; border-radius: 20px;
}
.onoffswitch-inner {
    display: block; width: 200%; margin-left: -100%;
    transition: margin 0.3s ease-in 0s;
}
.onoffswitch-inner:before, .onoffswitch-inner:after {
    display: block; float: left; width: 50%; height: 30px; padding: 0; line-height: 30px;
    font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
    box-sizing: border-box;
}
.onoffswitch-inner:before {
	content: "Left";
    padding-left: 10px;
    background-color: #2e69b6; color: #FFFFFF;
}
.onoffswitch-inner:after {
    content: "Right";
    padding-left: 10px;
    background-color: #2e69b6; color: #FFFFFF;
    text-align: right;
	    padding-right: 10px;
}

.onoffswitch-switch {
    display: block; width: 18px; margin: 6px;
    background: #FFFFFF;
    position: absolute; top: 0; bottom: 0;
    right: 56px;
    border: 2px solid #999999; border-radius: 20px;
    transition: all 0.3s ease-in 0s; 
}

.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
    margin-left: 0;
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
    right: 8px; 
}

.onoffswitch input {
    display: none !important;
}



.main-site-wrapper .row-column-section .row-column-row-name-field {
    width: 13%;
}
.main-site-wrapper .row-column-section .row-column-row-name-field {
    margin: 0 0 -17px 0px;
}
.wp-core-ui .button, .wp-core-ui .button-secondary {
    height: 41px !important;
}
.main-site-wrapper div .img_pop_div {
        width: 50px;
    padding-left: 10px;
	margin: 4px 0 4px 0px;
    float: left;
}

.row-column-row-text-optional .row-column.row-column-background-color {
    padding: 4px 6px;
	width: 100%;
}

.row-column-background-color .clr-check {
    width: 50%;
    float: left;
}

button.set_custom_pop_images.button.button_image {
    margin: 5px 0 0 0;
}

button.set_custom_pop_images.button.button_image {
    margin: 5px 0 4px 0;
}


/*--------scroll css code ----------*/
::-moz-range-track {
    background: #ccc;
    border: 0;
}
input::-moz-focus-inner { 
  border: 0; 
}
.range-slider .input-range {
    -webkit-appearance: none;
    border-radius: 0px;
    background: #ccc;
    outline: none;
    writing-mode: bt-lr;
    -webkit-appearance: slider-horizontal;
    width: 100%;
    position: relative;
    bottom: 1px;
	height: inherit;
	left: -1px;
}
.range-slider {
    width: 93%;
    display: inline-block;
    border: 2px solid #959191;
    margin-top: 6px;
	height: 16px;
}
/*--------scroll css code ----------*/

.radius-bar {

    width: 100%;
    float: left;
	 padding: 7px 7px 6px;
}

.radius-input {
    width: 24%;
    float: left;
}
.radius-input label {
    padding: 5px;
	float: left;
	width: 100%;
}

.radius-input input {
    width: 52%;
    float: left;
    margin: 0 0 0 7px;
}
.round .radius-input span {
    float: left;
    width: 50%;
}

.round .radius-input input {
    height: 19px;
    width: 17px;
}

input.jscolor.backColor {
background-color: #FFFFFF !important;
}
.row-column.row-column-background-color {
    padding: 5px 12px !important;
}
.row-column-background-color .clr-check {
    text-align: left !important;
}

</style>
<script>
function divFunction(d){
	var langth = jQuery('input.desktop-clss:checked').length;
		if(langth > 10){
			var name = d.getAttribute("name");
			alert("You can select only 10 checkboxes for desktop");
			jQuery('[name="'+name+'"]').removeAttr('checked');
		}

}

function divFunction1(d){
	var langth = jQuery('input.mobile-clss:checked').length;
		if(langth > 5){
			var name = d.getAttribute("name");
			alert("You can select only 5 checkboxes for mobile");
			jQuery('[name="'+name+'"]').removeAttr('checked');
		}

}


/*--------scroll jquery code ----------*/
jQuery(document).ready(function($){  
var range = $('.input-range'),
    value = $('.range-value');
    
value.html(range.attr('value'));

range.on('input', function(){
    value.html(this.value);
}); 

$(".onoffswitch-label").click(function(){
	if($('input[name="position"]').is(':checked')){
		$("#position2").val(1);
	}
	else{
		$("#position2").val(0);
	}
});
});
/*--------scroll jquery code ----------*/
 
 
/* remove color js */ 
jQuery(document).ready(function($){
	$(".newcolor").live('change', function() { 
		var trid = $(this).attr('trid');
		$('#'+trid+' .newcolor').removeClass('backColor');
		$('#'+trid+' .removeColor').val(1);
		var colorCode = $(this).val();
		var getFirstChar = colorCode.charAt(0);
		if(getFirstChar == "#"){
			var NewColorCode = colorCode.replace("#","");
		}else{
			var NewColorCode = colorCode;
		}
		if(NewColorCode != 'FFFFFF' ){
			$('#'+trid+' .removeLink').show();
		}
	});
	
	$(".removeLink").live('click', function() { 
	var trid = $(this).attr('trid');
	$('#'+trid+' .newcolor').val('#FFFFFF');
	$('#'+trid+' .newcolor').addClass('backColor');
	$('#'+trid+' .removeColor').val(0);
	$('#'+trid+' .removeLink').hide();
	});
});
/* end remove color js */ 





function DoSomething() {
  // do something.
alert("This functionality will be available in pro version");
  jQuery("#tool_bottom_part").one('click', DoSomething);
}


/* start rtl js */ 
jQuery(document).ready(function($){
	
jQuery("#tool_bottom_part").one('click', DoSomething);
	
	
	var dir = $("html").attr("dir");
	if(dir == 'rtl'){ 
	$("html").addClass("rtlClass");
	}
});
/* end rtl js */ 
</script>


<!------- vinod cws 30-07-2019 rtl css  ---->
<style>

.rtlClass .radius-input input {
    float: right;
}
.rtlClass .direction-setting div {
    text-align: right !important;
}
.rtlClass #new_two .radius-input {
    width: 32% !important;
}
.rtlClass div#new_three {
    width: 95%;
    float: right;
}
.rtlClass #new_three .round .radius-input span {
    float: left;
    width: 100%;
}
.rtlClass  div#vartical_bar {
    margin-right: 5% !important;
}
.rtlClass div#demo_bar_ra {
    width: 97%;
}
.rtlClass label#color_sce {
    padding: 0 0 0 10px;
}
.rtlClass input[type="number"] {
    height: 23px !important;
    width: 87%;
}
.rtlClass .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
    margin-right: -45px;
	margin-left:unset !important;
}
.rtlClass .onoffswitch-inner {
    display: block;
    width: 200%;
	margin-left:unset!important;
    transition: margin 0.3s ease-in 0s;
}

#bottom_part {
    pointer-events: none;
    opacity: 0.4;
}

</style>