<div class="header_bot">
    <?php
        global $search;
        $is_expanded = false;
        if (isset($search['type']) && $search['type'] == 'expanded') $is_expanded = true;
        if((isset($_GET['price']))) $is_expanded = true;
    ?>
    <div class="search_main<?php print ($is_expanded ? ' search_open' : '')?>">

        <?php TF_SEEK_HELPER::print_form('main_search'); ?>

    </div>

</div>