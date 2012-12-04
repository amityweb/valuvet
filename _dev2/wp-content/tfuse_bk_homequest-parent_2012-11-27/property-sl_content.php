<?php
/**
 * The template for displaying content in the single.php for doctor template.
 * To override this template in a child theme, copy this file
 * to your child theme's folder.
 *
 * @since HomeQuest 1.0
 */

    $args = array(
        'post_type'     => 'attachment',
        'numberposts'   => -1,
        'post_status'   => null,
        'post_parent'   => $post->ID,
    );
    $attachments = get_posts($args);

    $slider_images = array();
    if ($attachments) {
        foreach ($attachments as $attachment){
            if( TF_SEEK_POST_ATTACHMENTS::img_is_excluded_from_slider($attachment->ID) ) continue;

            $slider_images[] = array(
                'title'         => apply_filters('the_title', $attachment->post_title),
                'order'        =>$attachment->menu_order,
                'img_full'    => wp_get_attachment_image_src($attachment->ID, array(640,420))
                /*'img_mid'    => wp_get_attachment_image_src($attachment->ID, array(446,281))*/
            );
        }
    }
$slider_images = tfuse_aasort($slider_images,'order');
?>

        <div class="re-imageGallery">

            <?php if (sizeof($slider_images)): ?>

            <ul id="rePhoto" class="jcarousel-skin-pika">
                <?php foreach ($slider_images as $attachment): ?>
                <?php
                $image = new TF_GET_IMAGE();
                $slide_image_mid =  $image->removeSizeParams(true)->width(446)->height(281)->src($attachment['img_full'][0])->get_img();
                ?>
                    <li>
                        <a href="<?php print $attachment['img_full'][0]; ?>" title="<?php echo $attachment['title']; ?>"><?php print $slide_image_mid; ?></a>
                        <span><em><?php _e('click on image to enlarge', 'tfuse'); ?></em> <?php echo $attachment['title']; ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>

            <script>
                jQuery(document).ready(function($) {


                    function slideChanged(self){
                       var current = self.counter.html();
                       var position = current.indexOf('/');
                       current = current.substring(0,position);
                       jQuery('.property_attachement').attr("rel","prettyPhoto[property]");
                       jQuery('.property_attachement[counter="'+current+'"]').attr("rel","prettyPhoto");
                    }
                    $("#rePhoto").PikaChoose({ animationFinished: slideChanged,/*buildFinished:pfpc,*/ carousel:true, carouselVertical:true, transition:[0],autoPlay:false,animationSpeed:300});
                });
            </script>

            <?php endif; ?>

            <?php print( TF_SEEK_HELPER::print_zone('content') ); ?>
        </div>
        <?php if (sizeof($slider_images)): ?>
        <div style="display: none;">
            <?php foreach ($slider_images as $k=>$attachment): ?>
            <a href="<?php echo $attachment['img_full'][0];?>" rel="prettyPhoto[property]" title="<?php echo $attachment['title']; ?>" class="property_attachement" counter="<?php echo $k+1; ?>"></a>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>