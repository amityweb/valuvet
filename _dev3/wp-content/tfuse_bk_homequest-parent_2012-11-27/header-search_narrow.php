<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

?>
<div class="search_home">
    <p class="search_title"><strong><?php _e('SEARCH FOR HOMES', 'tfuse'); ?></strong></p>

    <?php TF_SEEK_HELPER::print_form('slider_search'); ?>

</div>
