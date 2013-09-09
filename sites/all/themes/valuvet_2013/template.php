<?php
function valuvet_2013_preprocess_html(&$variables) {
	drupal_add_css('http://fonts.googleapis.com/css?family=Lato', array('type' => 'external'));
    drupal_add_css('http://fonts.googleapis.com/css?family=Mako', array('type' => 'external'));
    drupal_add_css('http://fonts.googleapis.com/css?family=Bitter', array('type' => 'external'));
}
?>


<?php
function valuvet_2013_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
    $form['search_block_form']['#title_display'] = 'invisible'; // Toggle label visibilty
    $form['search_block_form']['#size'] = 8;  // define size of the textfield
    $form['actions']['submit'] = array('#type' => 'image_button', '#src' => base_path() . path_to_theme() . '/images/arrow_search.png');

    $form['search_block_form']['#attributes']['placeholder'] = t('Search...');
    // // // Add extra attributes to the text box
    //  $form['search_block_form']['#attributes']['onblur'] = "if (this.value == '') {this.value = 'Search';}";
    //  $form['search_block_form']['#attributes']['onfocus'] = "if (this.value == 'Search') {this.value = '';}";
    // // Prevent user from searching the default text
    // $form['#attributes']['onsubmit'] = "if(this.search_block_form.value=='Search'){ alert('Please enter a search'); return false; }";
  }
}
?>

<?php
function valuvet_2013_preprocess_page(&$variables) {
   drupal_add_js(drupal_get_path('theme', 'valuvet_2013') . '/js/jquery.jcarousel.min.js');
   drupal_add_js(drupal_get_path('theme', 'valuvet_2013') . '/js/jquery.pikachoose.js');
   drupal_add_css(drupal_get_path('theme', 'valuvet_2013') . '/css/pikachoose.css');
   
   
    if(strpos($_SERVER["REQUEST_URI"],'/page/advertise-property') !== FALSE){  
      $library = libraries_detect('colorbox');  
      drupal_add_css($library['library path'] .'/example3/colorbox.css', 'file');         
    }
    if (isset($variables['node']) && $variables['node']->type === 'property') {
	# Template personalized for property content type
        $suggest = "page__node__{$variables['node']->type}";
        $variables['theme_hook_suggestions'][] = $suggest;

	# I add the necessary files to render the map
	
    
	drupal_add_js('https://maps.googleapis.com/maps/api/js?key=AIzaSyBtwWD71zNuUA3Q95WY7YkO900uDI51VTc&sensor=false', 'external');

    }


}
?>


<?php

function valuvet_2013_form_user_login_alter(&$form) {
  unset($form['links']);
  $form['actions']['#weight'] = 5;

  // Shorter, inline request new password link.
  $form['actions']['request_password'] = array(
	'#markup' => '<div class="row btn-user"><div class="offset5 span4">'.l(t('Lost password'), 'user/password', array('attributes' => array('class' => 'btn', 'title' => t('Request new password via e-mail.')))), 
	'#weight' => 10
  ); 
  if (variable_get('user_register', USER_REGISTER_VISITORS_ADMINISTRATIVE_APPROVAL)) {
    $form['signup'] = array(
	'#markup' => l(t('Register'), 'user/register', array('attributes' => array('class' => 'btn', 'id' => 'create-new-account', 'title' => t('Create a new user account.')))).'</div></div>', 
	'#weight' => 15,
    ); 
  }
}

function valuvet_2013_css_alter(&$css) {  
  if(strpos($_SERVER["REQUEST_URI"],'/page/advertise-property') !== FALSE){  
    $exclude = array(
      'sites/all/modules/colorbox/styles/default/colorbox_style.css' => FALSE,
    );
    $css = array_diff_key($css, $exclude);    
    }
  }

?>