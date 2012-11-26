<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
	
	function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  //$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
 
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  //$content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content); 
 //$content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}

function new_excerpt_length($length) {
return 150;
}
add_filter('excerpt_length', 'new_excerpt_length');






// Filter wp_nav_menu() to add additional links and other output
//function new_nav_menu_items($items) {
//	$homelink = '<li class="home"><a href="' . home_url( '/' ) . '">' . __('Home') . '</a></li>';
//	$items = $homelink . $items;
	//return $items;
//}
//add_filter( 'wp_nav_menu_items', 'new_nav_menu_items' );










add_filter( 'nav_menu_css_class', 'additional_active_item_classes', 10, 2 );

function additional_active_item_classes($classes = array(), $menu_item = false){

if(in_array('current_page_item', $menu_item->classes)){
$classes[] = 'current_page_item current';
}
if(in_array('current-menu-parent', $menu_item->classes)){
$classes[] = 'current-menu-parent current';
}
return $classes;
}


?>