<?php if($post_thumb) :
    $image = new TF_GET_IMAGE();
    $slide_image_mid =  $image->width(98)->height(56)->src(esc_attr($post_thumb))->get_img();
    echo $slide_image_mid;
endif; ?>
<p><a href="#" class="link-re"><?php print esc_attr($post_title); ?></a></p>
<p><span class="map-re-prop"><?php print $seek_property_bedrooms; ?> <?php print( mb_strtolower( TF_SEEK_HELPER::get_property_pluralization_name( 'seek_property_bedrooms', $seek_property_bedrooms, true), 'UTF-8') ); ?> | <?php print $seek_property_baths; ?> <?php print( mb_strtolower( TF_SEEK_HELPER::get_property_pluralization_name( 'seek_property_baths', $seek_property_baths, true), 'UTF-8') ); ?> | <?php print( number_format($seek_property_square) ); ?> <?php print( mb_strtolower( TF_SEEK_HELPER::get_property_pluralization_name( 'seek_property_square', $seek_property_square, true), 'UTF-8') ); ?></span></p>
<p><span class="map-re-prop"><?php print TF_SEEK_HELPER::get_property_pluralization_name( 'seek_property_price' ); ?>: <span class="re-price"><?php print( TF_SEEK_HELPER::get_option('seek_property_currency_symbol','$')); ?><?php $seek_property_price = TF_SEEK_HELPER::get_post_option(TF_SEEK_HELPER::get_post_type() . '_price', '-', $post_id);
    if(is_numeric($seek_property_price))
    {
        print( number_format( $seek_property_price) );
    } elseif(($seek_property_price != '-') && (!empty($seek_property_price)))
    {
        echo number_format(intval($seek_property_price));
        $stored_price = TF_SEEK_HELPER::get_post_option(TF_SEEK_HELPER::get_post_type() . '_price', null, $post_id);
        $int_price = (string)intval($seek_property_price);
        echo str_replace($int_price,'',$stored_price);
    }
    else
    {
        echo '-';
    }
    ?></span></span></p>
