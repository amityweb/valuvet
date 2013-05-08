<?php
$arr = get_defined_vars();
#dpm($arr); ?>
<div id="my-favourites"><span class='favourites-claim'>MY FAVOURITES</span><span class="favourites-number"><?php print l($arr['rows'], 'members-area/bookmarks', array('html'=>true));?></a></span></div>