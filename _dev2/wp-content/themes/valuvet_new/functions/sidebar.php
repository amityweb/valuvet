<?php
function valuvet_widgets_init() {

	// Header Right Widget Area
	// Location: Directly above the footer. you can add newsletter, featured property or any widget
	register_sidebar(array(
		'name'			=> 'Header Right Widget Area',
		'id' 			=> 'header-right-widget-area',
		'description'   => __( 'Header top right Widget Area'),
		'before_widget' => '<div id="header-phone">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	));
	
	register_sidebar(array(
		'name'			=> 'Header Middle Widget Area',
		'id' 			=> 'header-middle-widget-area',
		'description'   => __( 'Header top right Widget Area'),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
	
	
	// Homepage Widget Area
	// Location: at the center left of the page, right next to slider
	register_sidebar(array(
		'name'					=> 'Home Page content 1',
		'id' 						=> 'homepageone-widget-area',
		'description'   => __( 'Located at the center left of the page, right next to slider'),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
	
	// Homepage Widget Area
	// Location: at the center right of the page, right next to first home page content 
	register_sidebar(array(
		'name'					=> 'Home Page content 2',
		'id' 						=> 'homepagetwo-widget-area',
		'description'   => __( 'Located at the center right of the page, right next to first home page content '),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
	


	// Newsletter Widget Area
	// Location: Directly above the footer. you can add newsletter, featured property or any widget
	register_sidebar(array(
		'name'			=> 'Newsletter Widget Area widget area',
		'id' 			=> 'newsletter-widget-area',
		'description'   => __( 'Newsletter Widget Area'),
		'before_widget' => '<div class="col_bg col_padd">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	));



	// Featured Property Widget Area
	// Location: Featured Property Widget Area
	register_sidebar(array(
		'name'			=> 'Featured Property Widget Area',
		'id' 			=> 'featureproperty-widget-area',
		'description'   => __( 'Featured Property Widget Area'),
		'before_widget' => '<div class="col_bg col_padd">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	));





	// National schedule Widget Area
	// Location: National schedule Widget Area
	register_sidebar(array(
		'name'			=> 'National schedule Widget Area',
		'id' 			=> 'national-schedule-widget-area',
		'description'   => __( 'National schedule Widget Area'),
		'before_widget' => '<div class="col_bg">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	));


}
/** Register sidebars by running elegance_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'valuvet_widgets_init' );

?>