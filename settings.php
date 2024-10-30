<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!class_exists('Mobile_Tabs_Settings')) {

	class Mobile_Tabs_Settings {

		/**

		 * Construct the plugin object

		 */

		public function __construct() {

        	add_action('admin_menu', array(&$this, 'add_menu'));
            add_action( 'wp_footer', array($this,'enqeue_script21'), 1 );

		} // END public function __construct	

        public function add_menu() {

            // Add a page to manage this plugin's settings
        	add_options_page('Mobile Tabs Settings', 'Mobile Tabs', 'manage_options', 'mobile_tabs', array(&$this, 'plugin_settings_page') );
        } // END public function add_menu()

        public function plugin_settings_page() {

        	if(!current_user_can('manage_options')) {

        		wp_die(__('You do not have sufficient permissions to access this page.'));
        	}

        	include(sprintf("%s/templates/settings.php", dirname(__FILE__)));

        } // END public function plugin_settings_page()
        public function enqeue_script21() {

			wp_enqueue_script( 'mtabs_index21', 'https://cdnjs.cloudflare.com/ajax/libs/bPopup/0.11.0/jquery.bpopup.min.js', array( 'jquery' ) );
	    }

    } // END class WP_Plugin_Template_Settings

} // END if(!class_exists('WP_Plugin_Template_Settings'))

function mobile_tabs_func()  {


	global $wpdb;
	$get_all_mobile_tab_datas = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."mobile_tab_data`");
	$get_all_background_datas = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."mobile_tab`");
	
	$count_data = count($get_all_mobile_tab_datas);
	$pageId = get_the_ID();
	 $zindex = $get_all_background_datas[0]->z_index;
 if($zindex==''){
	$zindex = 999999; 
 }
?>
<style> 

div#mobilee {
   display: none;
}
</style> 
<?php
 //for side position
 $position = get_option( 'side_position' ); 

 if($position == '0' OR $position == '' ){
	 $leftRight = "left:0;"; 
	 ?>
	 <style>
	 .b-modal.__b-popup1__ {
        right: inherit !important;
	}
	 
	 @media (min-width: 768px) {
span.header-cart-count {
    position: absolute;
    right: -10px;
    top: 6px;
}
.mobile_show {
    position: relative;
}
.desktop_show.mobile_show {
    position: relative;
}
.mobile_tab_share_Alldata_bpopup {
    left: 0 !important;
}
	 

.mobilee {
	left: 10px !important;
	bottom: 10px !important;
}
	 
}
	 
	 
<?php if(!empty($get_all_background_datas[0]->round_column) && $get_all_background_datas[0]->round_column == 'round_column'){ ?>
@media (max-width: 767px){
.mobilee {
	left: 10px !important;
    border: unset !important;
    width: auto !IMPORTANT;
    MAX-WIDTH: max-content;
	position: fixed;
    bottom: 10px !important;
}
div#mobile-tab .mobile_show {
    float: inherit;
}
.mobile_show {
    width: 100% !important;
}


span.header-cart-count {
    top: 10px !important;
    left: unset !important;
    right: -10px !important;
}



}
<?php } ?>

 
	 </style>
	 <?php	 
	 }
	 else
		{
		$leftRight = "right:0;";
		
		 ?>
		 
	 <style>
	 .b-modal.__b-popup1__ {
    right: 0px !important;
}

	 
	 @media (min-width: 768px) {
span.header-cart-count {
    position: absolute !important;
    left: -11px;
	top:6px;
}
.mobile_tab_share_Alldata_bpopup .close_btn .close_btn_click {
    left: -10px;
	right: inherit !important;
}

.mobile_tab_share_Alldata_bpopup .mobile_tab_share_Alldata a {
    float: right !important;
}
.b-modal.__b-popup1__ {
    left: inherit !important;
}
.mobile_tab_share_Alldata_bpopup {
    left: inherit !important;
    right: 100px;
}

.mobilee {
right: 10px !important;
bottom:10px !important;
}

}
	 
	 


<?php if(!empty($get_all_background_datas[0]->round_column) && $get_all_background_datas[0]->round_column == 'round_column'){ ?>
@media (max-width: 767px){
.mobilee {
	right: 10px !important;
	left: inherit !important;
    bottom:10px !important;
    border: unset !important;
    width: auto !IMPORTANT;
    MAX-WIDTH: max-content;
}
div#mobile-tab .mobile_show {
    float: inherit;
}
.mobile_show {
    width: 100% !important;
}

span.header-cart-count {
    top: 10px !important;
    left: -10px !important;
    right: unset !important;
}

}
<?php } ?>

	 
	 </style>
	 <?php	
		}
?>

	<script>

		jQuery(document).ready(function(){  

			jQuery('.shareClose').click(function(){
			jQuery( ".close_btn_click" ).trigger( "click" );
			});
			
			jQuery('.share_icon_popup').click(function(){
			jQuery( ".mfp-close" ).trigger( "click" );
			});
			
		
			jQuery('.share_icon_popup').click(function () {
			
			var share_id = jQuery(this).attr('id');
			
			jQuery( '.mobile_tab_share_Alldata_bpopup a' ).each(function() {
				var icons_class =  jQuery( this ).attr('class');
				if(share_id == icons_class){
					jQuery('.'+icons_class).show();
					//alert(icons_class);
				}else{
					jQuery('.'+icons_class).hide();
				}
				
			});


				jQuery('.mobile_tab_share_Alldata_bpopup').bPopup({

					onOpen: function() { 

							jQuery('.mobile_tab_share_Alldata_bpopup').show();

							jQuery('.share_icon_close').show();

							jQuery('.share_icon_popup').hide();

						}, 

	        		onClose: function() { 

	        				jQuery('.mobile_tab_share_Alldata_bpopup').hide();

	        				jQuery('.share_icon_close').hide();

	        				jQuery('.share_icon_popup').show();

	        			},

				});

			});

			

			jQuery('.share_messenger_popup').click(function () {

//				var iframesrc = jQuery(this).attr('iframe-src');

				jQuery('.mobile_tab_share_messenger_popup').bPopup({

					onOpen: function() { 

							jQuery('.mobile_tab_share_messenger_popup .fb-page').show();

							jQuery('.mobile_tab_share_messenger_popup .close_btn').show();

						}, 

	        		onClose: function() { 

	        				jQuery('.mobile_tab_share_messenger_popup .fb-page').hide();

	        				jQuery('.mobile_tab_share_messenger_popup .close_btn').hide();

	        			},

				});

//					jQuery('.mobile_tab_share_messenger_popup .fb-page').attr('data-href',iframesrc);

			});



			jQuery('.mobile_tab_share_messenger_popup .fb-page').hide();



			jQuery('.share_icon_close').click(function () {

				jQuery('.share_icon_close').hide();

				jQuery('.share_icon_popup').show();

				var bPopup = jQuery('.mobile_tab_share_Alldata_bpopup').bPopup();

				bPopup.close();

			});



			jQuery('.share_icon_close').hide();

		});

	</script>
	<?php 
	
	$display = '0';
	foreach ($get_all_mobile_tab_datas as $get_all_data) {
		if( $get_all_data->row_text_display == 'yes' ) {

			$display = '1';
			break;
		}
	}
	?>
	<style type="text/css"> <?php if( $display == '0' ) { ?> .mobile-tab { display: none;}

 <?php } else {
 
 ?>

 	@media (min-width: 768px) {.mobilee { <?php echo $leftRight; ?>
position: fixed;
top: 30%;
width:auto;
z-index: <?php echo $zindex ; ?>;
max-width: 100px;
} 
<? 
		if($get_all_data->row_text_image_height!=''){
		if($get_all_data->row_text_image_height<70){
			$krheight=60;
		}else{
			$krheight=$get_all_data->row_text_image_height;
		}	
		}else{
			$krheight=60;
		}		?>
/* .header-cart-count{position:fixed;left: <?php //echo $krheight; ?>px;} */
.b-modal{width:400px;right: inherit !important;}
.mobile_tab_share_Alldata_bpopup {
    text-align: center;
    width: 300px !important;
    display: none;
    margin-left: 110px;
    float: left;
    left: 0px;
}



<?php $margin = $get_all_background_datas[0]->margin_set; $marginGet =  strstr($margin, '-'); if($marginGet){ $finelMargin = str_replace("-","",$margin); }else{ $finelMargin = "-".$get_all_background_datas[0]->margin_set; } ?> 
.mobile-tab {margin-top:<?php echo $finelMargin; ?>px;}\.mobile-tab .col-xs-1, .mobile-tab .col-xs-2, .mobile-tab .col-xs-3, .mobile-tab .col-xs-4, .mobile-tab .col-xs-5, .mobile-tab .col-xs-6, .mobile-tab .col-xs-7, .mobile-tab .col-xs-8, .mobile-tab .col-xs-9, .mobile-tab .col-xs-10, .mobile-tab .col-xs-11, .mobile-tab .col-xs-12, .mobile-tab .col-xs-15 {
    width: 100%;
}
.mobile-tab .data-link { clear: both; border-bottom:  }
.row { margin: 0px auto !important; } }
<?php } ?>



.mobile-tab .data-link .font {
    font-size:<?php echo $get_all_background_datas[0]->font_size; ?>px;
}

 	<?php if ($get_all_background_datas[0]->background_direction ==1) { ?> .mobile-tab { } <?php } else { ?> <?php } ?>  .mobile_tab_share_messenger_popup iframe { border: 0 none; height: 315px; width: 100%; background: #ffffff;} .mobile_tab_share_messenger_popup { width: 90%;} .mobile-tab * {-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; } .mobile-tab *:before, .mobile-tab *:after {-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; } .mobile-tab img { vertical-align: middle; } .mobile-tab .img-responsive { display: block; max-width: 100%; height: auto; } .mobile-tab .row {/*margin-left: -<?php echo $get_all_background_datas[0]->margin_set; ?>; margin-right: -<?php echo $get_all_background_datas[0]->margin_set; ?>;*/ } .mobile-tab .col-xs-1, .mobile-tab .col-xs-2, .mobile-tab .col-xs-3, .mobile-tab .col-xs-4, .mobile-tab .col-xs-5, .mobile-tab .col-xs-6, .mobile-tab .col-xs-7, .mobile-tab .col-xs-8, .mobile-tab .col-xs-9, .mobile-tab .col-xs-10, .mobile-tab .col-xs-11, .mobile-tab .col-xs-12, .mobile-tab .col-xs-15 {position: relative; min-height: 1px; /*padding-left: 15px; padding-right: 15px;*/ } .mobile-tab .data-link a {padding: <?php echo $get_all_background_datas[0]->margin_set; ?> 0px; display:block; } .mobile-tab .col-xs-1, .mobile-tab .col-xs-2, .mobile-tab .col-xs-3, .mobile-tab .col-xs-4, .mobile-tab .col-xs-5, .mobile-tab .col-xs-6, .mobile-tab .col-xs-7, .mobile-tab .col-xs-8, .mobile-tab .col-xs-9, .mobile-tab .col-xs-10, .mobile-tab .col-xs-11, .mobile-tab .col-xs-12, .mobile-tab .col-xs-15 {<?php if ($get_all_background_datas[0]->background_direction ==1) { ?> float: right; <?php } else { ?> float: left; <?php } ?> } .mobile-tab .data-link { text-align: center;} .mobile-tab .data-link .img-div { display: table; margin: 0 auto;} /* BACKGROUND-SET  */ <?php if ($get_all_background_datas[0]->background_type=='color') { ?> .mobile-tab { background: <?php echo $get_all_background_datas[0]->background_color; ?>; } .mobile-tab .data-link { border-right:} <?php } elseif ($get_all_background_datas[0]->background_type=='image'){ ?> .mobile-tab { background: url('<?php echo $get_all_background_datas[0]->background_image; ?>'); } .mobile-tab .data-link { border-right: } <?php } elseif ($get_all_background_datas[0]->background_type=='none'){ ?> .mobile-tab  { background: none;} .mobile-tab .data-link a { color: #000000;} .mobile-tab .data-link { border: none;} <?php } ?> .mobile-tab .data-link a { color: #FFFFFF;} .mobile-tab .data-link a { font-size: <?php echo $get_all_background_datas[0]->font_size; ?>;} .mobile_tab_share_Alldata_bpopup { text-align: center; width: 100%; display: none;} .mobile_tab_share_Alldata_bpopup .mobile_tab_share_Alldata a{ display: block; float: left;  padding: 11px 8px; width: 27% !important;} .mobile_tab_share_Alldata_bpopup .mobile_tab_share_Alldata .shareImg_div { width: 70px; background: #FFFFFF;} .mobile_tab_share_Alldata_bpopup .mobile_tab_share_Alldata { display: table; width: 100%; margin: 0 0 50px 0; padding-top: 30px;} .share_icon_close { display: none;} .mobile_tab_share_Alldata_bpopup .close_btn .close_btn_click{ display: table; float: right; position: absolute; right: 5px; top: 3px; background: #FF1C3A; line-height: 10px; border-radius: 16px; padding: 3px; border: 1px solid #FF1C3A; height: 30px; width: 30px;} .mobile_tab_share_messenger_popup .close_btn { display: none;} .mobile_tab_share_messenger_popup .close_btn .close_btn_click{ display: table; float: right; position: absolute; right: -8px; top: -25px; background: #FF1C3A; line-height: 10px; border-radius: 16px; padding: 3px; border: 1px solid #FF1C3A; height: 30px; width: 30px;} 
 	.header-cart-count{background-color: #900; border-radius: 100%; color: #ffffff; display: block; font-size: 1em; height: 1.5em; width: 1.5em; line-height: 1.5; float: left; },.mobile-tab .data-link{ padding:8px}

 	@media (max-width: 767px) {.mobile-tab .col-xs-15 {width: 20%; } .mobile-tab .col-xs-12 {width: 100%; } .mobile-tab .col-xs-11 {width: 91.66666667%; } .mobile-tab .col-xs-10 {width: 83.33333333%; } .mobile-tab .col-xs-9 {width: 75%; } .mobile-tab .col-xs-8 {width: 66.66666667%; } .mobile-tab .col-xs-7 {width: 58.33333333%; } .mobile-tab .col-xs-6 {width: 50%; } .mobile-tab .col-xs-5 {width: 41.66666667%; } .mobile-tab .col-xs-4 {width: 33.33333333%; } .mobile-tab .col-xs-3 {width: 25%; } .mobilee .col-xs-2 {width: 19.9999%; } .mobile-tab .col-xs-1 {width: 8.33333333%; } .mobile-tab { display: block;} .mobilee { margin-top: 30px;  position: fixed; bottom: 0; width: 100%; left: 0; z-index: <?php echo $zindex; ?>;} div.product div.images {width: 100%;} div.product div.summary {
    width: 100%;
}  } 


	@media (min-width: 768px) {
.mobile-tab{
   border-top-left-radius: <?php echo $get_all_background_datas[0]->top_left_radius; ?>px;
   border-top-right-radius: <?php echo $get_all_background_datas[0]->top_right_radius; ?>px;
   border-bottom-left-radius: <?php echo $get_all_background_datas[0]->bottom_left_radius; ?>px;
   border-bottom-right-radius: <?php echo $get_all_background_datas[0]->bottom_right_radius; ?>px;
}

<?php if(empty($get_all_background_datas[0]->round_button_desktop)){ ?>
#mobile-tab .data-link:first-child a{
   border-top-left-radius: <?php echo $get_all_background_datas[0]->top_left_radius; ?>px !important;
   border-top-right-radius: <?php echo $get_all_background_datas[0]->top_right_radius; ?>px !important;	
}
#mobile-tab .data-link:last-child a{
   border-bottom-left-radius: <?php echo $get_all_background_datas[0]->bottom_left_radius; ?>px !important;
   border-bottom-right-radius: <?php echo $get_all_background_datas[0]->bottom_right_radius; ?>px !important;	
}

#mobile-tab .show_cls a
{
   border-bottom-left-radius: <?php echo $get_all_background_datas[0]->bottom_left_radius; ?>px !important;
   border-bottom-right-radius: <?php echo $get_all_background_datas[0]->bottom_right_radius; ?>px !important;	
}
<?php } ?>

.mobile-tab .data-link:last-child {
    border-bottom: none !important;
}

.desktophideTextRow{display:  none;}

.desktop_hide{display:  none; } 

.mobile-tab{ float:left; } 
	
}
 	.mobile-tab span {

    font-size: 15px;

}


#countdowntimer{margin-bottom:20px;}

@media only screen and (max-width: 768px) {
	
	iframe {
	width: 100% !important;
	float: left;
	}

  .mobile_hide {
    display: none !important;
}

.mobilehideTextRow{ display: none; }

}


@media (min-width: 768px)
.b-modal {
    width: 400px !important;
    right: inherit !important;
}
.b-modal {
    width: 400px !important;
}

	iframe {
	float: left;
	}

	.mfp-auto-cursor .mfp-content {
	cursor: auto;

	}
	.mfp-close-btn-in .mfp-close {
	color: #ea1010 !important;
	}


.white-popup-block input, textarea, select {
    width: 100%;
}
input.wpcf7-form-control.wpcf7-submit {
    width: 36%;
}

@media (min-width: 768px) {	 
.white-popup-block {
    width: 600px !important;
}
}
@media (max-width: 767px) {	
.white-popup-block {
width: 100%;
overflow-y: scroll !important;
height: auto !important;
max-height: 520px !important;
}
}					
.mfp-content {
    vertical-align: top !important;
}
.white-popup-block {
	background: #FFF;
	max-width: 800px;
	position: inherit;
	top: 42px;
	left: 0;
/* 	transform: translateX(-50%)translateY(-50%); */
	width: auto;
	margin: 0 auto;
	right: 0;
}

@media (min-width:768px){
	
.white-popup-block {
	display: table;
		top: 92px !important;
}	
}

.counter_sc {
    margin: 0 !important;
}
.tiyle_sce.yhgdcshjcaj {
    margin: 0 !important;
}


.top_hading {
margin: 8px 0px -11px !important;
}
.tiyle_sce {
text-align: center !important;;
font-size: 35px !important;;
margin: 11px 0 0 !important;;
line-height: initial !important;
}
.content_sce {
text-align: center !important;;
text-align: center !important;;
margin: 0 0 9px 0 !important;;
font-size: medium !important;;
}



@media (max-width: 767px) {
span.header-cart-count {
    position: absolute;
    top: -18px;
    margin: 0 auto;
    left: 0;
    right: 0;
}
.mobile-tab {
    float: left;
    width: 100%;
}
.desktop_show.mobile_show {
    position: relative;
}


}

.mobile-tab .data-link a {
    padding: 6px !important;
}
<?php if(empty($get_all_background_datas[0]->round_button_mobile) && empty($get_all_background_datas[0]->round_column)){ ?>
	
@media (max-width: 767px){	
.mobile-tab .data-link a {
    line-height: 1 !important;
}
}
<?php } ?>
@media (max-width: 767px){	
 .mfp-wrap.mfp-close-btn-in.mfp-auto-cursor.mfp-ready {
    z-index: 9999999;
}

.mobile_tab_share_Alldata_bpopup {
    z-index: 9999999999 !important;
} 
}


<?php 
$get_all_mobile_tab_datass = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."mobile_tab_data` WHERE row_text_optional != ''");

$get_all_mobile_tab_datass1 = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."mobile_tab_data` WHERE tab_option = 'text'");


if(!empty($get_all_mobile_tab_datass) || !empty($get_all_mobile_tab_datass1) ) 
{ ?>

<?php if(!empty($get_all_background_datas[0]->round_button_mobile) && ($get_all_background_datas[0]->round_button_mobile == 'round_button_mobile')) { ?>

@media (max-width: 767px) {
.mobile_show a {
    border-radius: 50%;
}

#mobilee #mobile-tab .data-link a span {
    display: none !important;
}


.mobile-tab .data-link {
    padding: 2px 0 !important;
}

.mobile-tab .data-link a {
    margin: 0 auto;
    display: table;
}

<?php  if($get_all_background_datas[0]->background_type != 'none'){ ?>

<?php if(!empty($get_all_background_datas[0]->round_column) && $get_all_background_datas[0]->round_column == 'round_column'){ ?>

.mobile-tab .data-link {
    border-bottom: 1px solid rgba(255, 255, 255, 0.5) !important;
}


<?php }else{ ?>
	.mobile-tab .data-link {
    border-right: 1px solid rgba(255, 255, 255, 0.5) !important;
	}
<?php	
}
 }
 ?>
 } 
 <?php
 }else{?>
	/*  .mobile-tab .data-link a {
    padding: 2px 8px !important;
} */
 <?php } ?>



<?php if(!empty($get_all_background_datas[0]->round_button_desktop)) { ?>

@media (min-width: 768px) {
.desktop_show a {
    border-radius: 50%;
}

#mobilee #mobile-tab .data-link a span {
    display: none !important;
}

.mobile-tab .data-link {
    padding: 2px 0 !important;
}

.mobile-tab .data-link a {
    margin: 0 auto;
    display: table;
}

<?php  if($get_all_background_datas[0]->background_type != 'none'){ ?>

.mobile-tab .data-link {
    border-bottom: 1px solid rgba(255, 255, 255, 0.5) !important;
}

}
<?php
 }
 }
 ?>



/* @media (min-width: 768px) {
	#mobile-tab .data-link:first-child a{
   border-top-left-radius: <?php echo $get_all_background_datas[0]->top_left_radius; ?>px !important;
   border-top-right-radius: <?php echo $get_all_background_datas[0]->top_right_radius; ?>px !important;	
}
#mobile-tab .data-link:last-child a{
   border-bottom-left-radius: <?php echo $get_all_background_datas[0]->bottom_left_radius; ?>px !important;
   border-bottom-right-radius: <?php echo $get_all_background_datas[0]->bottom_right_radius; ?>px !important;	
}
} */
.mobile-tab {
     border: none !important;
}

.mobile-tab span {
    line-height: 14px;
    padding: 0 0 5px;
}
<?php }else{ ?>





<?php if(!empty($get_all_background_datas[0]->round_button_mobile) && ($get_all_background_datas[0]->round_button_mobile == 'round_button_mobile')) { ?>

@media (max-width: 767px) {
.mobile_show a {
    border-radius: 50%;
}

.mobile-tab .data-link {
    padding: 2px 0 !important;
}

.mobile-tab .data-link a {
    margin: 0 auto;
    display: table;
}

<?php  if($get_all_background_datas[0]->background_type != 'none'){ ?>

<?php if(!empty($get_all_background_datas[0]->round_column) && $get_all_background_datas[0]->round_column == 'round_column'){ ?>

.mobile-tab .data-link {
    border-bottom: 1px solid rgba(255, 255, 255, 0.5) !important;
}


<?php }else{ ?>
	.mobile-tab .data-link {
    border-right: 1px solid rgba(255, 255, 255, 0.5) !important;
	}
<?php	
}
 }
 ?>
 } 
 <?php
 }
 ?>




<?php if(!empty($get_all_background_datas[0]->round_button_desktop)) { ?>

@media (min-width: 768px) {
.desktop_show a {
    border-radius: 50%;
}

.mobile-tab .data-link {
    padding: 2px 0 !important;
}

.mobile-tab .data-link a {
    margin: 0 auto;
    display: table;
}

<?php  if($get_all_background_datas[0]->background_type != 'none'){ ?>

.mobile-tab .data-link {
    border-bottom: 1px solid rgba(255, 255, 255, 0.5) !important;
}

}
<?php
 }
 }
 ?>

<?php } ?>






.mobile-tab .data-link {
    <!--border-right: none !important;-->
}
.col-xs-3.data-link.mobile-tab-4.desktop_show.mobile_show:last-child {
    border-bottom: none;
}
.mobile-tab .data-link {
    padding: 0;
}


#mobile-tab .data-link a span {
    display: inherit !important;
    clear: both !important;

}


	 </style>






	 
	<?php	


		$excluded_pages = $get_all_background_datas[0]->excluded_pages;

		$excluded_pages_remove_space = str_replace(' ', '', $excluded_pages);

		$excluded_pagesArray = explode(',', $excluded_pages_remove_space);

		if (!in_array($pageId, $excluded_pagesArray)) {

	?>

	<div id="mobilee" class="mobilee">
	<div class="mobile-tab" id="mobile-tab">
		<div class="row">
		
		 <?php 
		//if(!empty($get_all_background_datas[0]->round_button_mobile)) { 
		// print_r($get_all_background_datas[0]->round_button_mobile); die("fdgsfd");
		// } 
		?>
		
			<?php
				$count = 0;
				$text_minus_mobile=0;
				$total_show_on_desk=0;
			
				
			foreach ($get_all_mobile_tab_datas as $get_all_data) {
				
				
				if($get_all_data->row_text_display == 'yes')
				{
					$total_show_on_desk++;
				}
	
				if($get_all_data->row_text_mobile_display == 'yes'){
					if($get_all_data->tab_option=='text')
					{
					$text_minus_mobile++;
					}
					$count++;	
				}
				
			}
			
				$j=1;

				$m=0;	
				$total_show_on_desk_check=0;
				if(!empty($get_all_background_datas[0]->round_button_mobile)){
						
						$count=$count-$text_minus_mobile;
					}
					
				foreach ($get_all_mobile_tab_datas as $get_all_data) {

					if($get_all_data->row_text_image_height!='') {

						$img_height = 'height: '.$get_all_data->row_text_image_height;

					} else {

						$img_height ='';

					}

					if($get_all_background_datas[0]->tracking == '1') {

						//$tracking = "onclick=\"_gaq.push(['_trackEvent', 'tab', 'click', '$get_all_data->type_of_tabs']);\""; 

						$tracking = "onclick=\"_gaq.push(['_trackEvent', '$get_all_data->type_of_tabs', 'click', 'tab']);\""; 

					} elseif($get_all_background_datas[0]->tracking == '2') {

						//$tracking = "onclick=\"ga('send', 'event', 'tab', 'click', '$get_all_data->type_of_tabs');\""; 

						$tracking = "onclick=\"ga('send', 'event', '$get_all_data->type_of_tabs', 'click', 'tab');\""; 

					} elseif($get_all_background_datas[0]->tracking == '3') {

						//$tracking = "onclick=\"ga('send', 'event', 'tab', 'click', '$get_all_data->type_of_tabs');\""; 

						$tracking = "onclick=\"gtag('event', '$get_all_data->type_of_tabs', {'event_category' : 'click','event_label' : 'tab'});\""; 

					} else {

						$tracking = "";

					}
					
					$mobilehideTextRow = "";
					if(!empty($get_all_background_datas[0]->round_button_mobile) && $get_all_data->tab_option == 'text'){
						$mobilehideTextRow = "mobilehideTextRow";
						
					}
					
					
					
					$desktophideTextRow = "";
					if(!empty($get_all_background_datas[0]->round_button_desktop) && $get_all_data->tab_option == 'text'){
						$desktophideTextRow = "desktophideTextRow";
					}
					
					
						
					if($count == 1){
						$colclass = 12;
					 }elseif($count == 2){
						 $colclass = 6;
					 }elseif($count == 3){
						 $colclass = 4;
					 }elseif($count == 4){
						 $colclass = 3;
					 }elseif($count == 5){
						 $colclass = 2;
					 }
			if($get_all_data->row_text_display == 'yes')
				{
					$total_show_on_desk_check++;
				}
$ccccc='';
				
if($total_show_on_desk==$total_show_on_desk_check)
{
	$ccccc="show_cls";
	$total_show_on_desk_check=50;
}
			?>

			<div class="col-xs-<?php echo $colclass." ".$ccccc; ?> data-link mobile-tab-<?php echo $j; ?> <?php echo $get_all_data->row_text_display == 'yes' ? 'desktop_show':'desktop_hide' ?> <?php echo $get_all_data->row_text_mobile_display == 'yes' ? 'mobile_show':'mobile_hide' ?> <?php echo $mobilehideTextRow; ?> <?php  echo $desktophideTextRow; ?>" data-mh="HeightConsistancy">
				<?php if($get_all_data->type_of_tabs == 'mail') { ?>	
					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="mailto:<?php echo $get_all_data->row_text_link; ?>" <?php echo $tracking; ?>>

						<?php if ($get_all_data->tab_option == 'text') { ?>

							<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>

				<?php } elseif ($get_all_data->type_of_tabs == 'link') { ?>

					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="<?php echo $get_all_data->row_text_link; ?>" <?php echo $tracking; ?>>

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>

				<?php } elseif ($get_all_data->type_of_tabs == 'waze') { ?>

					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="waze://?q=<?php echo $get_all_data->row_text_link; ?>" <?php echo $tracking; ?>>

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>

				<?php } elseif ($get_all_data->type_of_tabs == 'sms') { ?>

					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="sms:<?php echo $get_all_data->row_text_link; ?>" class="tipclass" title="<?php echo $get_all_data->row_text_link; ?>" <?php echo $tracking; ?>>

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>

				<?php } elseif ($get_all_data->type_of_tabs == 'phone') { ?>
					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="tel:<?php echo $get_all_data->row_text_link; ?>" class="tipclass" title="<?php echo $get_all_data->row_text_link; ?>"  <?php echo $tracking; ?> >

						<?php if ($get_all_data->tab_option == 'text') { ?>

							<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>

				<?php } elseif ($get_all_data->type_of_tabs == 'whatsapp') { ?>

					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="https://api.whatsapp.com/send?phone=<?php echo $get_all_data->row_text_link; ?>"  <?php echo $tracking; ?>>

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>

				<?php } elseif ($get_all_data->type_of_tabs == 'location') { ?>

					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="https://maps.google.com/?q=<?php echo $get_all_data->row_text_link; ?>"  <?php echo $tracking; ?>>

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>

				<?php } elseif ($get_all_data->type_of_tabs == 'skypecall') { ?>

					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="skype:<?php echo $get_all_data->row_text_link; ?>?call"  <?php echo $tracking; ?>>

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>

				<?php } elseif ($get_all_data->type_of_tabs == 'cart') {
					
					 if ($get_all_data->tab_option == 'text') { 

							$icon_html = '<span class="font" style="color:#fff;">'.esc_html($get_all_data->row_text_name).'</span>';

						 } else { 

							$icon_html = '<img src="'.esc_url($get_all_data->row_text_name).'" class="img-div" style="'.$img_height.'" />';

						 } 
						 if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { $icon_html .= '<span style="color:#fff;">'.$get_all_data->row_text_optional.'</span>'; } 
					

				//$icon_html = '<img src="'.esc_url($get_all_data->row_text_name).'" style=" '.$img_height.'" />';
//echo $icon_html;die('dsfsdf');
			    $cart_count = "";
			    if ( class_exists( "WooCommerce" ) ) {
			        $cart_count = WC()->cart->get_cart_contents_count();
			        $cart_total = WC()->cart->get_cart_total();
			       $cart_url   = wc_get_cart_url();
			        $shop_url   = wc_get_page_permalink( "cart" );
                    $five=5;
			        $cart_count_html = '<span style="left:'.$img_height.'px;" class="header-cart-count">'.WC()->cart->get_cart_contents_count().'</span>';
			        $cart_text_html = "";
			        $link_to_page = "";

			            $link_to_page = ' href="' . $shop_url . '"';
			        
			    }
				
				
				if($get_all_data->remove_color == 1){ $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {$cartback = $get_all_data->icon_back_clr;}else{$cartback = "#".$get_all_data->icon_back_clr;} }
				

			    $html  = "<a" . $link_to_page . "  style='background:".$cartback.";' ".$tracking.">";
			    $html .= $icon_html ."</a>". $cart_count_html."";
			    echo $html;
			     ?>
			     <?php //if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php //echo $get_all_data->row_text_optional; ?></span><?php //} ?>

				<?php } elseif ($get_all_data->type_of_tabs == 'skypechat') { ?>

					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="skype:<?php echo $get_all_data->row_text_link; ?>?chat"  <?php echo $tracking; ?>>

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>

				<?php } elseif ($get_all_data->type_of_tabs == 'viber') { ?>

					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="viber://forward?text=<?php echo $get_all_data->row_text_link; ?>"  <?php echo $tracking; ?>>

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>

				<?php } elseif ($get_all_data->type_of_tabs == 'telegram') { ?>

					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="tg://resolve?domain=<?php echo $get_all_data->row_text_link; ?>"  <?php echo $tracking; ?>>

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>

				<?php } elseif ($get_all_data->type_of_tabs == 'messenger') { ?>

					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="https://m.me/<?php echo $get_all_data->row_text_link; ?>"  <?php echo $tracking; ?>>

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>

				<?php } elseif ($get_all_data->type_of_tabs == 'messenger') { ?>

					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="javascript:void(0);" class="share_messenger_popup" <?php echo $tracking; ?> iframe-src="<?php echo $get_all_data->row_text_link; ?>">

						<?php if ($get_all_data->tab_option == 'text') {
						$fbb = str_replace('https://www.facebook.com/', '', esc_html($get_all_data->row_text_name) ); 
						?><span class="font" style="color:#fff;"><?php echo $fbb; ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>
			<?php } elseif ($get_all_data->type_of_tabs == 'line'){ ?>
					
					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="https://manager.line.biz/"  <?php echo $tracking; ?>>

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>
					
					
			<?php } elseif ($get_all_data->type_of_tabs == 'kakaotalk'){ ?>
					
					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="https://accounts.kakao.com/"  <?php echo $tracking; ?>>

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>
					
					
			<?php } elseif ($get_all_data->type_of_tabs == 'wechat'){ ?>
					
					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="https://web.wechat.com/"  <?php echo $tracking; ?>>

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>
			<?php } elseif ($get_all_data->type_of_tabs == 'product_popup') { ?>

					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> class="popup-with-product-<?php echo $get_all_data->id; ?> shareClose" href="#mtabs-product-form-<?php echo $get_all_data->id; ?>" <?php echo $tracking; ?> >

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>
					<div id="mtabs-product-form-<?php echo $get_all_data->id; ?>" class="white-popup-block mfp-hide" style="<?php if($get_all_data->pop_border_clr_check == 'popup_border_color'){  $color = strcspn($get_all_data->pop_border_clr,"#"); if($color == 0){ echo "border: 15px solid ".$get_all_data->pop_border_clr;}else{ echo "border: 15px solid #".$get_all_data->pop_border_clr;}  } ?>; padding: 20px 30px;margin: 0px auto;"> 
						<div class="counter_sc" style="text-align:center;" id="countdowntimer"><span id="hms_timer"><span></div>
				<?php if($get_all_data->row_text_link != ''){ ?>
				
					<div class="tiyle_sce" style="text-align:center;"><?php echo $get_all_data->row_text_link; ?></div>
					
					<?php } ?>						
							<?php  //echo date("Y/m/d H:i:s"); ?>
					    <div style="overflow:hidden"><?php
					    /*
					    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 1  );
					    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display' );
					    remove_action( 'woocommerce_after_single_product_summary', 'avia_woocommerce_output_related_products', 20 );
					    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
					    echo do_shortcode("[product_page id=\"$get_all_data->row_text_product\"]"); 
					    */
					    $args = array(
							'posts_per_page'      => 1,
							'post_type'           => 'product',
							'post_status'         => 'publish',
							'ignore_sticky_posts' => 1,
							'no_found_rows'       => 1,
							'p' 				  => absint( $get_all_data->row_text_product ),
						);
						$single_product = new WP_Query( $args );
						ob_start();

		global $wp_query;

		// Backup query object so following loops think this is a product page.
		$previous_wp_query = $wp_query;
		// @codingStandardsIgnoreStart
		$wp_query          = $single_product;
		// @codingStandardsIgnoreEnd

		wp_enqueue_script( 'wc-single-product' );

		while ( $single_product->have_posts() ) {
			$single_product->the_post()
			?>
			<div class="single-product" data-product-page-preselected-id="0">
				
				<div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>

					<?php
						/**
						 * Hook: woocommerce_before_single_product_summary.
						 *
						 * @hooked woocommerce_show_product_sale_flash - 10
						 * @hooked woocommerce_show_product_images - 20
						 */
						//do_action( 'woocommerce_before_single_product_summary' );
						wc_get_template( 'single-product/product-image.php' );
					?>

					<div class="summary entry-summary">
						<?php
							/**
							 * Hook: woocommerce_single_product_summary.
							 *
							 * @hooked woocommerce_template_single_title - 5
							 * @hooked woocommerce_template_single_rating - 10
							 * @hooked woocommerce_template_single_price - 10
							 * @hooked woocommerce_template_single_excerpt - 20
							 * @hooked woocommerce_template_single_add_to_cart - 30
							 * @hooked woocommerce_template_single_meta - 40
							 * @hooked woocommerce_template_single_sharing - 50
							 * @hooked WC_Structured_Data::generate_product_data() - 60
							 */
							do_action( 'woocommerce_single_product_summary' );
						?>
					</div>

				</div>
			</div>
			<?php
		}

		// Restore $previous_wp_query and reset post data.
		// @codingStandardsIgnoreStart
		$wp_query = $previous_wp_query;
		// @codingStandardsIgnoreEnd
		wp_reset_postdata();


		remove_filter( 'woocommerce_add_to_cart_form_action', '__return_empty_string' );

		echo '<div class="woocommerce">' . ob_get_clean() . '</div>';
					    ?>
					    	
					    </div>
    <?php if($get_all_data->row_text_timer != '') {

		 ?>
    <script>
    	jQuery.noConflict();

                                jQuery(function(){
                                    jQuery('#hms_timer').countdowntimer({
                                    	startDate : "<?php echo date("Y/m/d H:i:s") ?>",
                                        dateAndTime : "<?php echo get_option('mtab_cc_timer') ?>",
                                        size : "lg",
					pauseButton : "pauseBtnhms",
					stopButton : "stopBtnhms"
                                    });
                                });
                            </script>
	
		
	<?php } ?>

<?php
//echo"<pre>";print_r($get_all_data->row_text_timer);echo"</pre>";die('dsfds');
 if( $get_all_data->row_text_timer != '' ) {
    $time = $get_all_data->row_text_timer * 1000;
 if( $get_all_data->product_field_daily == 'yes' ) { 
	$time = $get_all_data->row_text_timer * 1000;?>
		<script>
		  $ = jQuery.noConflict();
			jQuery(window).on('load', function() {
			  var now, lastDatePopupShowed;
			  now = new Date();

			  if (localStorage.getItem('lastDatePopupShowed') !== null) {
			    lastDatePopupShowed = new Date(parseInt(localStorage.getItem('lastDatePopupShowed')));
			  }

			  if (((now - lastDatePopupShowed) >= (86400000)) || !lastDatePopupShowed) {

			  	jQuery(function () {

		          setTimeout(function () {
		              jQuery('a[href="#mtabs-product-form-<?php echo $get_all_data->id; ?>"]').click();
		              ;
		          }, <?php echo $time ?>);
		      });
			    
			    localStorage.setItem('lastDatePopupShowed', now);
			  }
			});

			jQuery('.popup-with-product-<?php echo $get_all_data->id; ?>').magnificPopup({
			        type: 'inline',
		    });
        </script>
    <?php }else{  ?>
    	<script>
		jQuery.noConflict();
			jQuery(function () {

		          setTimeout(function () {
		                jQuery('a[href="#mtabs-product-form-<?php echo $get_all_data->id; ?>"]').click();
		              //alert('<?php echo $time ?>');
		              ;
		          }, <?php echo $time ?>);
	      	});
        </script>
    <?php } ?>
<?php } ?>
<script>
	jQuery('.popup-with-product-<?php echo $get_all_data->id; ?>').magnificPopup({
			        type: 'inline',
		    });
        </script>
        </div>


				<?php } elseif ($get_all_data->type_of_tabs == 'popup_form') { ?>

					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> class="popup-with-contact-form-<?php echo $get_all_data->id; ?> shareClose" href="#mtabs-contact-form-<?php echo $get_all_data->id; ?>" <?php echo $tracking; ?> >

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>
					<div id="mtabs-contact-form-<?php echo $get_all_data->id; ?>" class="white-popup-block mfp-hide popup-form " style="<?php if($get_all_data->pop_border_clr_check == 'popup_border_color'){  $color = strcspn($get_all_data->pop_border_clr,"#"); if($color == 0){ echo "border: 15px solid ".$get_all_data->pop_border_clr;}else{ echo "border: 15px solid #".$get_all_data->pop_border_clr;}  } ?>; <?php if($get_all_data->row_text_link != '' || $get_all_data->row_textarea != ''){ ?> padding: 0 20px 15px; <?php }else{ ?> padding: 35px 20px; <?php } ?>"> 
					
					<?php if($get_all_data->row_text_link != '' || $get_all_data->row_textarea != ''){ ?>
					<!--<h4 class="top_hading" style="text-align:center; margin: 0px 0px -12px;"><?php echo $get_all_data->row_text_optional; ?></h4>-->
					<div class="tiyle_sce"  style="text-align:center;"><?php echo $get_all_data->row_text_link; ?></div>
					<div class="content_sce"  style="width: 95%;float: none;margin: 0 auto !important;text-align:center; text-align: center; margin: -10px 0 0 0; font-size: medium;"><?php echo $get_all_data->row_textarea; ?></div>
					<?php } ?>
    <div><?php echo do_shortcode(str_replace('\"','',$get_all_data->row_text_shortcode)); ?></div>
</div>

<script> 
   // setTimeout(function() {
   	jQuery.noConflict();
    	jQuery('.popup-with-contact-form-<?php echo $get_all_data->id; ?>').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',

        // When elemened is focused, some mobile browsers in some cases zoom in
        // It looks not nice, so we disable it:
        callbacks: {
            beforeOpen: function() {
                if(jQuery(window).width() < 700) {
                    this.st.focus = false;
                } else {
                    this.st.focus = '#name';
                }
            }
        }
    });


    </script>

    <?php
     $time = (int)$get_all_data->row_text_popup_time * 1000;
     //echo"<pre>";print_r($time);echo"</pre>";die;
    if( $get_all_data->row_text_popup_time != '' ) {
     if( $get_all_data->popup_field_daily == 'yes' ) {
    
    //  ?>
		<script>
			jQuery(window).on('load', function() {
			  var now, lastDateContactShowed;
			  now = new Date();

			  if (localStorage.getItem('lastDateContactShowed') !== null) {
			    lastDateContactShowed = new Date(parseInt(localStorage.getItem('lastDateContactShowed')));
			  }

			  if (((now - lastDateContactShowed) >= (86400000)) || !lastDateContactShowed) {

			  	jQuery(function () {

		          setTimeout(function () {
		              jQuery('a[href="#mtabs-contact-form-<?php echo $get_all_data->id; ?>"]').click();
		              ;
		          }, <?php echo $time ?>);
		      });
			    
			    localStorage.setItem('lastDateContactShowed', now);
			  }
			});

        </script>
    <?php }else{ ?>
    	<script>
			jQuery(function () {

		          setTimeout(function () {
		      
		              jQuery('a[href="#mtabs-contact-form-<?php echo $get_all_data->id; ?>"]').click();
		              ;
		          }, <?php echo $time ?>);
		      });

        </script>

	<?php } ?>
<?php } ?>

				<?php } elseif ($get_all_data->type_of_tabs == 'share') { ?>

					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> href="javascript:void(0);" class="share_icon_popup" id="all_icons_<?= $get_all_data->id ?>" <?php echo $tracking; ?>>

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>

					<a <?php if($get_all_data->remove_color == 1){ ?>style="display:none !important;background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> style="display:none !important;" href="javascript:void(0);" class="share_icon_close" >

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>

				<?php } elseif ($get_all_data->type_of_tabs == 'image_popup') { ?>
				
				<!-- start image popup form ---->		
				
				
					<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> class="mtabs-image-popup-form-<?php echo $get_all_data->id; ?> shareClose" href="#mtabs-image-popup-form-<?php echo $get_all_data->id; ?>" <?php echo $tracking; ?> >

						<?php if ($get_all_data->tab_option == 'text') { ?>

						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>

						<?php } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>
				<div id="mtabs-image-popup-form-<?php echo $get_all_data->id; ?>" class="white-popup-block mfp-hide popup-image" style="<?php if($get_all_data->pop_border_clr_check == 'popup_border_color'){  $color = strcspn($get_all_data->pop_border_clr,"#"); if($color == 0){ echo "border: 15px solid ".$get_all_data->pop_border_clr;}else{ echo "border: 15px solid #".$get_all_data->pop_border_clr;}  } ?>;">
					
					<?php if($get_all_data->row_text_link != '' || $get_all_data->row_pop_img_textarea != ''){ ?>
					<!--<h4 class="top_hading" style="text-align:center; margin: 0px 0px -12px;"><?php echo $get_all_data->row_text_optional; ?></h4>-->
					<div class="tiyle_sce" style="text-align:center;"><?php echo $get_all_data->row_text_link; ?></div>
					<div class="content_sce" style="width: 95%;float: none;margin: 0 auto !important;text-align:center; text-align: center; margin: -10px 0 0 0; font-size: medium;"><?php echo $get_all_data->row_pop_img_textarea; ?></div>
					<?php } ?>
					<div>
					<a href ="<?php echo $get_all_data->row_text_pop_image; ?>">	
					<img style="margin: 0 auto; display: table; max-width: 100%;" src="<?php echo esc_url($get_all_data->row_pop_img); ?>" />
					</a>
					</div>
				</div>

<script>
 
   // setTimeout(function() {
    	jQuery('.mtabs-image-popup-form-<?php echo $get_all_data->id; ?>').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',

        // When elemened is focused, some mobile browsers in some cases zoom in
        // It looks not nice, so we disable it:
        callbacks: {
            beforeOpen: function() {
                if(jQuery(window).width() < 700) {
                    this.st.focus = false;
                } else {
                    this.st.focus = '#name';
                }
            }
        }
    });

    </script>


<?php
 if( $get_all_data->row_text_popup_image_time != '' ) {
    $time = (int)$get_all_data->row_text_popup_image_time * 1000;
 if( $get_all_data->popup_image_field_daily == 'yes' ) { 
	?>
		<script>
			jQuery(window).on('load', function() {
			  var now, lastDateContactShowed;
			  now = new Date();

			  if (localStorage.getItem('lastDateContactShowed') !== null) {
			    lastDateContactShowed = new Date(parseInt(localStorage.getItem('lastDateContactShowed')));
			  }

			  if (((now - lastDateContactShowed) >= (86400000)) || !lastDateContactShowed) {

			  	jQuery(function () {

		          setTimeout(function () {
		              jQuery('a[href="#mtabs-image-popup-form-<?php echo $get_all_data->id; ?>"]').click();
		              ;
		          }, <?php echo $time ?>);
		      });
			    
			    localStorage.setItem('lastDateContactShowed', now);
			  }
			});

        </script>
    <?php }else{ ?>
    	<script>
			jQuery(function () {

		          setTimeout(function () {
		      
		              jQuery('a[href="#mtabs-image-popup-form-<?php echo $get_all_data->id; ?>"]').click();
		              ;
		          }, <?php echo $time ?>);
		      });

        </script>

	<?php } ?>
<?php } ?>
				
				
	<!-- end image popup form ---->		
		<?php } elseif ($get_all_data->type_of_tabs == 'video_popup') { ?>
				
			<a <?php if($get_all_data->remove_color == 1){ ?>style="background:<?php $background = strcspn($get_all_data->icon_back_clr,"#"); if($background == 0) {echo $get_all_data->icon_back_clr;}else{echo"#".$get_all_data->icon_back_clr;} ?>;" <?php } ?> class="mtabs-video-popup-form-<?php echo $get_all_data->id; ?> shareClose" href="#mtabs-video-popup-form-<?php echo $get_all_data->id;  ?>" <?php echo $tracking; ?> >

						<?php if ($get_all_data->tab_option == 'text') { ?>
						<span class="font" style="color:#fff;"><?php echo esc_html($get_all_data->row_text_name); ?></span>	<?php
						 } else { ?>

							<img src="<?php echo esc_url($get_all_data->row_text_name); ?>" class="img-div" style=" <?php echo $img_height; ?>" />

						<?php } ?>
						<?php if ($get_all_data->row_text_optional != '' && ($get_all_data->tab_option== 'icon' || $get_all_data->tab_option== 'upload_icon' ) ) { ?><span style="color:#fff;"><?php echo $get_all_data->row_text_optional; ?></span><?php } ?>

					</a>
					<div id="mtabs-video-popup-form-<?php echo $get_all_data->id;  ?>" class="white-popup-block mfp-hide video-popup" style="<?php if($get_all_data->pop_border_clr_check == 'popup_border_color'){  $color = strcspn($get_all_data->pop_border_clr,"#"); if($color == 0){ echo "border: 15px solid ".$get_all_data->pop_border_clr;}else{ echo "border: 15px solid #".$get_all_data->pop_border_clr;}  } ?>;">
					
					
					
					<?php if($get_all_data->row_text_link != '' || $get_all_data->row_pop_video_textarea != ''){ ?>
					
			
					<!--<h4 class="top_hading" style="text-align:center; margin: 0px 0px -12px;"><?php echo $get_all_data->row_text_optional; ?></h4>-->
					<div class="tiyle_sce" style="text-align:center;"><?php echo $get_all_data->row_text_link; ?></div>
					<div class="content_sce" style="width: 95%;float: none;margin: 0 auto !important;text-align:center; margin: -10px 0 0 0; padding-bottom:10px; font-size: medium; background: #fff;"><?php echo $get_all_data->row_pop_video_textarea; ?></div>
					<?php } ?>
					
					<?php 
				$url = $get_all_data->row_text_pop_video;
				if (strpos($url, 'youtube.com') !== false) { 
				if (strpos($url, 'watch?v=') !== false) { 
				$url_exp =	explode("watch?v=",$url);
					
				?>
				<iframe width="100%" height="350" src="https://www.youtube.com/embed/<?= $url_exp[1] ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>	
			<?php }else{ ?>
				<iframe width="640" height="350" src="<?= $url ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				<?php }
				}else{
					echo "Url is not valid";
				}
					?>


<script>
 
   // setTimeout(function() {
   	jQuery.noConflict();
    	jQuery('.mtabs-video-popup-form-<?php echo $get_all_data->id; ?>').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',

        // When elemened is focused, some mobile browsers in some cases zoom in
        // It looks not nice, so we disable it:
        callbacks: {
            beforeOpen: function() {
                if(jQuery(window).width() < 700) {
                    this.st.focus = false;
                } else {
                    this.st.focus = '#name';
                }
            }
        }
    });


    </script>


<?php
 if( $get_all_data->row_text_popup_video_time != '' ) {
    $time = (int)$get_all_data->row_text_popup_video_time * 1000;
 if( $get_all_data->popup_video_field_daily == 'yes' ) { 
	?>
		<script>
			jQuery(window).on('load', function() {
			  var now, lastDateContactShowed;
			  now = new Date();

			  if (localStorage.getItem('lastDateContactShowed') !== null) {
			    lastDateContactShowed = new Date(parseInt(localStorage.getItem('lastDateContactShowed')));
			  }

			  if (((now - lastDateContactShowed) >= (86400000)) || !lastDateContactShowed) {

			  	jQuery(function () {

		          setTimeout(function () {
		              jQuery('a[href="#mtabs-video-popup-form-<?php echo $get_all_data->id; ?>"]').click();
		              ;
		          }, <?php echo $time ?>);
		      });
			    
			    localStorage.setItem('lastDateContactShowed', now);
			  }
			});

        </script>
    <?php }else{ ?>
    	<script>
			jQuery(function () {

		          setTimeout(function () {
		      
		              jQuery('a[href="#mtabs-video-popup-form-<?php echo $get_all_data->id; ?>"]').click();
		              ;
		          }, <?php echo $time ?>);
		      });

        </script>

	<?php } ?>
<?php } ?>
        </div>
		<?php
				} ?>
				

			</div>

<?php

			$j++;

			$m++;

		}
?>




		</div>	<!-- end row -->
		
		
	</div> <!-- end mobile-tab -->
	
	<style>
	.main_icon{
	display:none;
	}
	</style>
<?php 
//css for one icon and one icon color 
if(!empty($get_all_background_datas[0]->one_icon_check) && !empty($get_all_background_datas[0]->round_column)){ ?>

		<!-- start one icon for tabbar -->	
<div class="main_icon">
<div class="sosial-links">
    <a id="one_icon" href="#" class="one-icon"><img style="<?php echo $img_height ?>" src="<?php echo $get_all_background_datas[0]->choose_icon_for_one_icon; ?>"></a>
    <a id="one_icon_close" class="one-icon-close" style="display:none;" href="#"><img style="<?php echo $img_height ?>" src="<?php echo plugins_url('assets/bar_close.png', __FILE__); ?>"></a>
</div>

<script>
jQuery(document).ready(function(){
	jQuery(".main_icon .one-icon").click(function(){
		jQuery(this).hide();
		jQuery(".one-icon-close").show();
		jQuery(".one-icon-close").addClass('icn-spinner');
		jQuery("div#mobile-tab ").show();
	});
	
	jQuery(".main_icon .one-icon-close").click(function(){
		jQuery(this).hide();
		jQuery(".one-icon").show();
		jQuery(".one-icon").addClass('icn-spinner');
		jQuery("div#mobile-tab ").hide();
	});
});
</script>

<style>
.sosial-links a {
    display: block;
    float: left;
    width: auto;
    height: auto;

    border-radius: 50%;
	box-shadow:0 0 11px #989898;
	margin-right: 7px;
	background:<?php echo $get_all_background_datas[0]->one_icon_back_clr; ?>
}
 
.sosial-links a img{
    font-size: 50px;
    color: #909090;
	width: auto;
		    display: table;
}


.main_icon a {
    margin: 0;
	padding: 6px;
}


.icn-spinner {
  animation: spin-animation 0.5s;
  display: inline-block;
}

@keyframes spin-animation {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(359deg);
  }
}

@media (max-width: 767px) {
.main_icon {
padding: 2px 0 !important;
}	
	
div.mobile-tab {
   display: none;
}
.main_icon {
   display: block; 
}
}
</style>
</div>
<?php }  ?>
<!-- end one icon for tabbar -->	
	
	
	
	</div>
	
	
	<!-- MOBILE_TAB_SHARE_MESSENGER_POPUP [START]-->

	<div class="mobile_tab_share_messenger_popup">

		<?php foreach ($get_all_mobile_tab_datas as $get_all_mobile_tab_data) { ?>

			<?php if ($get_all_mobile_tab_data->type_of_tabs == 'messenger') { ?>

			<div class="" data-remodal-id="fb-messenger">

				<div class="fb-page" data-tabs="messages" data-href="<?php echo $get_all_mobile_tab_data->row_text_link; ?>" data-width="290" data-height="290" data-tabs="messages" data-small-header="true" data-hide-cover="false" data-show-facepile="true" data-adapt-container-width="true">

					<div class="fb-xfbml-parse-ignore">

						<blockquote>Loading...</blockquote>

					</div>

				</div>

			</div>

			<?php } ?>

		<?php } ?>

		<div id="fb-root"></div>

		<script>

			(function(d, s, id) {

			  var js, fjs = d.getElementsByTagName(s)[0];

			  if (d.getElementById(id)) return;

			  js = d.createElement(s); js.id = id;

			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";

			  fjs.parentNode.insertBefore(js, fjs);

			}(document, 'script', 'facebook-jssdk'));

		</script>

	

		<div class="close_btn">

			<button class="button b-close close_btn_click">

				<img src="<?php echo plugins_url('assets/close.png', __FILE__); ?>" />

			</button>

		</div>

	</div>

	<!-- MOBILE_TAB_SHARE_MESSENGER_POPUP [END]-->

	

	<!-- MOBILE_TAB_SHARE_ALLDATA_BPOPUP [START]-->

	<div class="mobile_tab_share_Alldata_bpopup">

		<div class="mobile_tab_share_Alldata">

		<?php 

			foreach ($get_all_mobile_tab_datas as $get_all_mobile_tab_data) { 

				if (!empty($get_all_mobile_tab_data->row_text_share_data)) {

				$current_page_link = get_permalink();

				$current_page_title = get_the_title();

				$url=urlencode($current_page_link);

				$title=urlencode($current_page_title);

				

				$summary = $get_all_mobile_tab_data->row_text_share_data_text;

				

				$exploadDatas = explode(',',$get_all_mobile_tab_data->row_text_share_data);

					foreach ($exploadDatas as $exploadData) {

						

						if($get_all_background_datas[0]->tracking == '1') {

							$tracking = "onclick=\"_gaq.push(['_trackEvent', '$exploadData', 'click', 'tab']);\""; 

						} elseif($get_all_background_datas[0]->tracking == '2') {

							$tracking = "onclick=\"ga('send', 'event', '$exploadData', 'click', 'tab');\""; 

						} else {

							$tracking = "";

						}

		?>

						<?php if ($exploadData =='facebook') { ?>

							<a class="all_icons_<?= $get_all_mobile_tab_data->id; ?>" title="Share it on Facebook" href="http://www.facebook.com/sharer.php?u=<?php echo $url; ?>&p[title]=<?php echo $title; ?>&p[summary]=<?php echo $summary; ?>"  <?php echo $tracking; ?>>

								<img src="<?php echo plugins_url('assets/img/facebook.png', __FILE__); ?>" class="shareImg_div" alt="Share on Facebook" />

							</a>

						<?php } elseif ($exploadData =='gplus') { ?>

							<a class="all_icons_<?= $get_all_mobile_tab_data->id; ?>" href="https://plus.google.com/share?url=<?php echo $url; ?>"  <?php echo $tracking; ?>>

								<img src="<?php echo plugins_url('assets/img/gplus.png', __FILE__); ?>" class="shareImg_div" />

							</a>

						<?php } elseif ($exploadData =='twitter') { ?>

							<a class="all_icons_<?= $get_all_mobile_tab_data->id; ?>" href="http://twitter.com/share?text=<?php echo $summary; ?>&url=<?php echo $url; ?>"  <?php echo $tracking; ?>>

								<img src="<?php echo plugins_url('assets/img/twitter.png', __FILE__); ?>" class="shareImg_div" />

							</a>

						<?php } elseif ($exploadData =='linkedin') { ?>

							<a class="all_icons_<?= $get_all_mobile_tab_data->id; ?>" href="https://www.linkedin.com/shareArticle?url=<?php echo $url; ?>&title=<?php echo $summary; ?>"  <?php echo $tracking; ?>>

								<img src="<?php echo plugins_url('assets/img/linkedin.png', __FILE__); ?>" class="shareImg_div" />

							</a>
							
						<?php } elseif ($exploadData =='reddit') { ?>

							<a class="all_icons_<?= $get_all_mobile_tab_data->id; ?>" href="https://reddit.com/submit?url=<?php echo $url; ?>&title=<?php echo $summary; ?>"  <?php echo $tracking; ?>>

								<img src="<?php echo plugins_url('assets/img/reddit.png', __FILE__); ?>" class="shareImg_div" />

							</a>

						<?php } elseif ($exploadData =='pintrest') { ?>

							<a class="all_icons_<?= $get_all_mobile_tab_data->id; ?>" href="https://pinterest.com/pin/create/bookmarklet/?&url=<?php echo $url; ?>&description=<?php echo $summary; ?>"  <?php echo $tracking; ?>>

								<img src="<?php echo plugins_url('assets/img/pintrest.png', __FILE__); ?>" class="shareImg_div" />

							</a>

						<?php } elseif ($exploadData =='sms') { ?>

							<a class="all_icons_<?= $get_all_mobile_tab_data->id; ?>" href="sms:?body=<?php echo $summary.' '.$url; ?>"  <?php echo $tracking; ?>>

								<img src="<?php echo plugins_url('assets/img/sms.png', __FILE__); ?>" class="shareImg_div" />

							</a>

						<?php } elseif ($exploadData =='mail') { ?>

							<a class="all_icons_<?= $get_all_mobile_tab_data->id; ?>" href="mailto:?subject=<?php echo $summary; ?>&body=<?php echo $url; ?>"  <?php echo $tracking; ?>>

								<img src="<?php echo plugins_url('assets/img/mail.png', __FILE__); ?>" class="shareImg_div" />

							</a>

						<?php } elseif ($exploadData =='viber') { ?>

							<a class="all_icons_<?= $get_all_mobile_tab_data->id; ?>" href="viber://chat?number=<?php echo $summary.' '.$url; ?>"  <?php echo $tracking; ?>>

								<img src="<?php echo plugins_url('assets/img/viber.png', __FILE__); ?>" class="shareImg_div" />

							</a>

						<?php } elseif ($exploadData =='whatsapp') { ?>

							<a class="all_icons_<?= $get_all_mobile_tab_data->id; ?>" href="whatsapp://send?text=<?php echo $summary.' '.$url; ?>"  <?php echo $tracking; ?>>

								<img src="<?php echo plugins_url('assets/img/whatsapp.png', __FILE__); ?>" class="shareImg_div" />

							</a>

						<?php } ?>

		<?php

					}

				}

			}

		?>

		</div>

		<div class="close_btn">

			<button class="button b-close close_btn_click">

				<img src="<?php echo plugins_url('assets/close.png', __FILE__); ?>" />

			</button>

		</div>

	</div>
	
	<script>
		/*jQuery(".tipclass").tipTip({defaultPosition: "right"});*/
					jQuery(document).ready(function(){
					jQuery("#messenger").click(function(){	

					var my_window = window.open('https://www.facebook.com/','window','width=640,height=480,resizable,scrollbars,toolbar,menubar')
					
					
					//my_window.close ();
					//window.location.reload();	

					
					//my_window.close ();
					});
					});
	</script>



	<!-- MOBILE_TAB_SHARE_ALLDATA_BPOPUP [END] -->

	<?php } ?>
<?php
if(!empty($get_all_background_datas[0]->round_column) && $get_all_background_datas[0]->round_column == 'round_column'){
?>
<script>
document.addEventListener("DOMContentLoaded", readyy);
window.onresize = function(event) {
  if(screen.width > parseInt('767')){
   document.getElementById('mobilee').style.display='block';
   document.getElementById('mobile-tab').style.display='block';
	}else{
	document.getElementById('one_icon_close').style.display='none';
	document.getElementById('one_icon').style.display='block';	
	document.getElementById('mobilee').style.display='block';
    document.getElementById('mobile-tab').style.display='none';	
	}	
};

function readyy() {
	setTimeout(function(){
	if(screen.width > parseInt('767')){
   document.getElementById('mobilee').style.display='block';
   document.getElementById('mobile-tab').style.display='block';
	}else{
	document.getElementById('mobilee').style.display='block';	
	
	}	
	},1000);
 }
</script>	
<?php }else{ ?>	
<script>
document.addEventListener("DOMContentLoaded", readyy);
window.onresize = function(event) {
  if(screen.width > parseInt('767')){
   document.getElementById('mobilee').style.display='block';
   //document.getElementById('mobile-tab').style.display='block';
	}else{
	document.getElementById('one_icon_close').style.display='none';
	document.getElementById('one_icon').style.display='block';	
	document.getElementById('mobilee').style.display='block';		
	}	
};

function readyy() {
	setTimeout(function(){
	if(screen.width > parseInt('767')){
   document.getElementById('mobilee').style.display='block';
   document.getElementById('mobile-tab').style.display='block';
	}else{
	document.getElementById('mobilee').style.display='block';	
		
	}	
	},1000);
 }
</script>	
<?php } ?>	
<?php

}

add_shortcode( 'mobile_tabs', 'mobile_tabs_func' );

//mobile_tabs_func();

add_action('wp_footer', 'mobile_tabs_func');