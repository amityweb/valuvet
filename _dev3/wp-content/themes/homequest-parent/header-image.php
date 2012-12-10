<?php
    /**
    * if selected image in header, function is located in
    * theme_config/theme_includes/THEME_HEADER_CONTENT.php
    * $header_image is global variable
    */
    global $header_image;
    if ( !empty($header_image) ) :
?>

    <!-- header image/slider -->
    <div class="header_bot header_image">
        <div class="container">
            <?php
                $image = new TF_GET_IMAGE();
                echo $image->width(960)->height(142)->src($header_image)->get_img();
            ?>
        </div>
    </div>
    <!--/ header image/slider -->

<?php else: ?>

    <div class="header_bot"></div>

<?php endif; ?>
