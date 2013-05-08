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
   drupal_add_css(drupal_get_path('theme', 'valuvet_2013') . '/css/base.css');
}
?>