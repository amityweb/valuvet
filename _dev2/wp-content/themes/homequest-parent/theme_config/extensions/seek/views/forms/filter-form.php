<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

    TF_SEEK_HELPER::print_all_not_form_hidden($form_id, array( TF_SEEK_HELPER::get_search_parameter('page'), TF_SEEK_HELPER::get_search_parameter('orderby'), TF_SEEK_HELPER::get_post_type() ));
?>

<?php
    TF_SEEK_HELPER::print_form_item('price_filter');
?>

<?php
    TF_SEEK_HELPER::print_form_item('tax_ids_category');
?>



<?php
    TF_SEEK_HELPER::print_form_item('baths_checkboxes');
?>

<?php
    TF_SEEK_HELPER::print_form_item('squares_checkboxes');
?>

<?php
    TF_SEEK_HELPER::print_form_item('filter_location_select');
?>

<?php
    TF_SEEK_HELPER::print_form_item('favorites');
?>

<div class="row rowSubmit">
    <input type="submit" value="<?php _e('FILTER RESULTS', 'tfuse'); ?>" class="btn-submit">
</div>
<?php
    TF_SEEK_HELPER::print_form_item('bedrooms_checkboxes');
?>