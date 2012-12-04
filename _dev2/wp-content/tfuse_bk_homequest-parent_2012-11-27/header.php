<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <title><?php wp_title(''); ?></title>
    <?php tfuse_meta(); ?>

    <link rel="profile" href="http://gmpg.org/xfn/11" />
	
	<link href='http://fonts.googleapis.com/css?family=Lato:400italic,400,700|Bitter' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_uri() ?>" />
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
						<?php echo tfuse_options('header_text_box'); ?>
					</div>
					<div class="clear"></div>
				</div>

                <?php tfuse_header_content('header'); ?>

				<div class="clear"></div>

			</div>
		</div>
	</div>
	<!--/ header -->
    <?php tfuse_header_content('before_content'); ?>
