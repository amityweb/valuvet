<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php
		if(tfuse_options('disable_tfuse_seo_tab'))  wp_title('');
		else {  wp_title( '|', true, 'right' );bloginfo( 'name' );
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
				echo " | $site_description";} ?>
	</title>
    <?php tfuse_meta(); ?>

    <link rel="profile" href="http://gmpg.org/xfn/11" />
	
	<link href='http://fonts.googleapis.com/css?family=Lato:400italic,400,700|Bitter' rel='stylesheet' type='text/css'>
    <link type="text/css" media="all" href="<?php echo get_stylesheet_uri(); ?>" rel="stylesheet">
    <link type="text/css" media="screen" href="<?php echo get_template_directory_uri() . '/screen.css'; ?>" rel="stylesheet">
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo tfuse_options('feedburner_url', get_bloginfo_rss('rss2_url')); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php
        tfuse_head();
        wp_head();

        TF_SEEK_HELPER::register_search_parameters(array(
            'form_id'   => 'tfseekfid',
            'page'      => 'tfseekpage',
            'orderby'   => 'tfseekorderby'
        ));
    ?>
    
</head>
<body <?php body_class(); ?>>
<div class="body_wrap">

	<div class="header" <?php tfuse_header_background(); ?>>
		<div class="header_inner">
			<div class="container_12">

				<div class="header_top">

					<div class="logo">
						<a href="<?php bloginfo('url'); ?>"><img src="<?php echo tfuse_logo(); ?>" alt="<?php bloginfo('name'); ?>"></a>
                        <strong><?php bloginfo('name'); ?></strong>
					</div>
					<!--/ .logo -->
					<?php tfuse_menu('default');  ?>
					<div class="header_phone">
					<ul id="header_phone_list"><li><?php echo tfuse_options('header_text_box'); ?></li>
					<li><span class="div_line" /></li>
					<li><a href="<?php echo site_url('?s=~&tfseekfid=main_search&favorites'); ?>" id="my_saved_offers"><?php _e('MY FAVOURITE OFFERS', 'tfuse'); ?> <em><?php if(!empty($_COOKIE['favorite_posts'])) echo sizeof(explode(',',$_COOKIE['favorite_posts'])); else echo '0'; ?></em></a>	</li>					
					<li><span class="div_line" /></li>
					<li>        <!-- search widget -->
        <span class="header_search" >
            <form method="get" id="searchform" action="<?php echo home_url( '/' ) ?>">
                <div>
                    <input id="searchsubmit" class="btn-arrow" value="<?php _e('Submit','tfuse');?>" type="submit">
                    <input class="inputField" name="s" id="s" value="<?php echo tfuse_options('search_box_text'); ?>" onfocus="if (this.value == '<?php echo tfuse_options('search_box_text'); ?>') {this.value = '';$(this).animate({ width: 100 }, 500);}" onblur="if (this.value == '') {this.value = '<?php echo tfuse_options('search_box_text'); ?>';$(this).animate({ width: 40 }, 500);}" type="text">
                    
                </div>
            </form>
        </span>
        <!--/ search widget --></li></ul>
					
					</div>
					<div class="clear"></div>
				</div>

                <?php tfuse_header_content('header'); ?>

				<div class="clear"></div>

			</div>
		</div>
	</div>
	<!--/ header -->
    <?php tfuse_header_content('before_content');
        global $is_tf_blog_page;
        if($is_tf_blog_page) tfuse_category_on_blog_page();
    ?>
