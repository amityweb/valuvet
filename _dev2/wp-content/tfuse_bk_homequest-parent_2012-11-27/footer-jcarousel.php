<?php
    global $post;
    $args = array(
        'post_type'     => TF_SEEK_HELPER::get_post_type(),
        'exclude'       =>$post->ID,
        'numberposts' => 8

    );
    $properties = get_posts($args);

    $slides = 0;
    foreach ($properties as $property) :
        if(!tfuse_page_options('title_for_slider', '', $property->ID)) continue;
        $slides++;
    endforeach;
    if($slides) :
    wp_enqueue_script( 'jquery.jcarousel' );
?>
<!-- carousel after content -->
<div class="before_content after_content">
    <div class="container_12">
        <strong class="carusel_title"><?php _e('SIMILAR PROPERTIES', 'tfuse'); ?></strong>

        <div class="carusel_list carusel_small">
            <ul id="similar_properties" class="jcarousel-skin-tango">
                <?php foreach ($properties as $property) : ?>
                        <?php
                            if(!tfuse_page_options('title_for_slider', '', $property->ID)) continue;
                            $img_out = '';
                            $title_out = tfuse_page_options('title_for_slider', '', $property->ID);
                            $image = new TF_GET_IMAGE();
                            $img_out .=  $image->width(218)->height(125)->src(tfuse_page_options('thumbnail_image',get_template_directory_uri() . '/images/dafault_image.jpg', $property->ID))->get_img();
                        ?>
                        <li>
                            <div class="item_image">
                                <a href="<?php print get_permalink($property->ID); ?>"><?php echo $img_out; ?></a>
                            </div>
                            <div class="item_name">
                                <a href="<?php print get_permalink($property->ID); ?>"><?php echo $title_out; ?></a>
                            </div>
                        </li>
                <?php endforeach; ?>
                <?php wp_reset_query(); ?>
            </ul>
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#similar_properties').jcarousel({
                    <?php
                        if($slides <=4 ) :
                            echo 'buttonNextHTML: null,';
                            echo 'buttonPrevHTML: null,';
                        endif;
                    ?>
                    easing: 'easeOutBack',
                    animation: 600,
                    scroll: 1
                });
            });
        </script>

    </div>
</div>
<!--/ carousel after content -->
<?php endif; ?>