<?php

/*     SHORTCODES      */

// CLEAR SHORTCODE
function clear_code() {
return '<div class="clear"></div>';
}
add_shortcode('clear', 'clear_code');


// RAW SHORTCODE FOR DISABLING AUTO FORMATTING IN POSTS
function raw_formatter($content) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}
	return $new_content;
}
// Remove the 2 main auto-formatters
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
// Before displaying for viewing, apply this function
add_filter('the_content', 'raw_formatter', 99);
add_filter('widget_text', 'raw_formatter', 99);

//		DIVIDER SHORTCODE
function divider_code($atts, $content = null) {
	return '<hr />';
}
add_shortcode('divider', 'divider_code');


//     SHORTCODES FOR BUTTONS
function btn_code($atts, $content = null) {
	extract(shortcode_atts(array( "linkto" => '#' ), $atts));
	return '<div class="float_left button"><a href="' . $linkto . '" class="cufonroman">' . do_shortcode($content) . '</a></div>';
}
add_shortcode('btn', 'btn_code');


//		SUCESS SHORTCODE
function success_code( $atts, $content = null ) {
	return '<div class="alert_success">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('success', 'success_code');

//		ERROR SHORTCODE
function error_code( $atts, $content = null ) {
	return '<div class="alert_error">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('error', 'error_code');

//		INFO SHORTCODE
function info_code( $atts, $content = null ) {
	return '<div class="alert_info">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('info', 'info_code');

//		WARNING SHORTCODE
function warning_code( $atts, $content = null ) {
	return '<div class="alert_warning">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('warning', 'warning_code');


//PAGE CONTENTS SHORT CODE
//	FULL PAGE LEFT PANEL
function fullpage_left_code( $atts, $content = null ) {
	return '<div class="maincontent_left">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('fullpage_left', 'fullpage_left_code');
//	FULL PAGE RIGHT PANEL
function fullpage_right_code( $atts, $content = null ) {
	return '<div class="maincontent_right">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('fullpage_right', 'fullpage_right_code');




//	FULL PAGE PROPERTY LEFT PANEL
function fullpage_left_property_code( $atts, $content = null ) {
	return '<div class="maincontent_left_property_sales">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('fullpage_property_left', 'fullpage_left_property_code');
//	FULL PAGE PROPERTY RIGHT PANEL
function fullpage_right_property_code( $atts, $content = null ) {
	return '<div class="maincontent_right_property_sales">' . "\n" . do_shortcode($content) . "\n" . '</div>';
}
add_shortcode('fullpage_property_right', 'fullpage_right_property_code');




//	FANCYBOX EXAMPLE LINK
function fancybox_popup_link( $atts, $content = null ) {
	extract(shortcode_atts(array( "linkto" => '#', "id" => 'squeesid' ), $atts));
	return '<a href="' . $linkto . '" class="fancybox-iframe" id="'.$id.'" ><em>' . do_shortcode($content) . '</em></a>';
}
add_shortcode('fancybox_link', 'fancybox_popup_link');


//	FANCYBOX INLINE EXAMPLE LINK
function fancybox_inline_link( $atts, $content = null ) {
	extract(shortcode_atts(array( "data" => '#', "id" => 'squeesid', "text" => 'Undefined Text' ), $atts));
	$output = '<a href="#' . $data . '" class="fancybox-inline" id="'.$id.'" ><em>' . $text . '</em></a>';
	$output .= '<div style="display:none;"><div id="'.$data.'">'.do_shortcode($content).'</div></div>';
	return $output;
}
add_shortcode('fancybox_inline', 'fancybox_inline_link');


function property_map( $atts, $content = null ){
	$template_dir = get_bloginfo( 'template_directory'  ); 
	$overview = get_option('property_overview_page');
	$link = $overview . '?p=property?wpp_search[pagination]=on&amp;wpp_search[practice_state]=';
	$output = '<div id="state">
	            <form name="selectlistform" method="POST">
              	<p align="left"> 
                <select name="selectlist1" onChange="takemethere1()">
                  <option selected>View All</option>
                  <option>QLD</option>
                  <option>NSW</option>
                  <option>ACT</option>
                  <option>VIC</option>
                  <option>SA</option>
                  <option>WA</option>
                  <option>NT</option>
                  <option>TAS</option>
                </select>
              </p>
            </form>
			</div>
				<div id="location_map">
				<img name="aust_map" src="'. $template_dir .'/images/_map/aust_map.gif" width="336" height="283" border="0" usemap="#m_aust_map" alt="">
				<map name="m_aust_map">
				<area shape="poly" coords="196,253,195,283,271,283,263,255,196,253" href="'.$link.'TAS" alt="TAS" onMouseOut="MM_swapImage(\'aust_map\',\'\',\''. $template_dir .'/images/_map/aust_map.gif\',1);"  onMouseOver="MM_swapImage(\'aust_map\',\'\',\''. $template_dir .'/images/_map/aust_map_tas.gif\',1);"  >
				<area shape="poly" coords="199,198,196,253,264,255,264,233,199,198" href="'.$link.'VIC" alt="VIC" onMouseOut="MM_swapImage(\'aust_map\',\'\',\''. $template_dir .'/images/_map/aust_map.gif\',1);"  onMouseOver="MM_swapImage(\'aust_map\',\'\',\''. $template_dir .'/images/_map/aust_map_vic.gif\',1);"  >
				<area shape="poly" coords="201,198,263,233,309,163,203,154,201,198" href="'.$link.'NSW"  alt="NSW/ACT"  onMouseOut="MM_swapImage(\'aust_map\',\'\',\''. $template_dir .'/images/_map/aust_map.gif\',1);"  onMouseOver="MM_swapImage(\'aust_map\',\'\',\''. $template_dir .'/images/_map/aust_map_nsw_act.gif\',1);"  >
				<area shape="poly" coords="115,129,204,130,198,235,117,180,115,129" href="'.$link.'SA"  alt="SA"  onMouseOut="MM_swapImage(\'aust_map\',\'\',\''. $template_dir .'/images/_map/aust_map.gif\',1);"  onMouseOver="MM_swapImage(\'aust_map\',\'\',\''. $template_dir .'/images/_map/aust_map_sa.gif\',1);"  >
				<area shape="poly" coords="309,163,202,154,204,130,183,128,187,0,247,1,309,163"  href="'.$link.'QLD" alt="QLD" onMouseOut="MM_swapImage(\'aust_map\',\'\',\''. $template_dir .'/images/_map/aust_map.gif\',1);"  onMouseOver="MM_swapImage(\'aust_map\',\'\',\''. $template_dir .'/images/_map/aust_map_qld.gif\',1);"  >
				<area shape="poly" coords="111,0,116,128,183,129,187,0,111,0"  href="'.$link.'NT"  alt="NT"  onMouseOut="MM_swapImage(\'aust_map\',\'\',\''. $template_dir .'/images/_map/aust_map.gif\',1);"  onMouseOver="MM_swapImage(\'aust_map\',\'\',\''. $template_dir .'/images/_map/aust_map_nt.gif\',1);"  >
				<area shape="poly" coords="55,37,0,90,-1,219,42,219,117,178,113,23,55,37"   href="'.$link.'WA"  alt="WA"  onMouseOut="MM_swapImage(\'aust_map\',\'\',\''. $template_dir .'/images/_map/aust_map.gif\',1);"  onMouseOver="MM_swapImage(\'aust_map\',\'\',\''. $template_dir .'/images/_map/aust_map_wa.gif\',1);"  >
				</map>
				</div>
				<div class="clear"></div>
				';
	return $output;
}
add_shortcode('show_property_map', 'property_map');
?>