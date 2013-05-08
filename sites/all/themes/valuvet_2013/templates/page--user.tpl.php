<?php
  global $user;

?>
<header id="navbar" role="banner" class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="row header">
            <section class="span4">
              <?php if ($logo): ?>
                <a class="logo pull-left" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
                  <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
                </a>
              <?php endif; ?>

              <?php if ($site_name): ?>
                <h1 id="site-name">
                  <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" class="brand"><?php print $site_name; ?></a>
                </h1>
              <?php endif; ?>
          </section>
          <section class="span8">
              <?php if ($primary_nav || $secondary_nav || !empty($page['navigation'])): ?>
                <div class="nav-collapse">
                  <nav role="navigation">
                    <?php if (!empty($page['navigation'])): ?>
                      <?php print render($page['navigation']); ?>
                    <?php endif; ?>
                  </nav>
                </div>
              <?php endif; ?>
          </div>
        </div>
</div>
</header>
<div class="topblack">
      <div class="container">
        <section class="row">
            <div class="jcarousel span12"><?php print render($page['jcarousel']); ?></div>
        </section>
      </div>
</div>
<div class="container">
  <header role="banner" id="page-header">
    <?php if ( $site_slogan ): ?>
      <p class="lead"><?php print $site_slogan; ?></p>
    <?php endif; ?>

    <?php print render($page['header']); ?>
  </header> <!-- /#header -->

  <div class="row content">
    <section class="<?php print empty($page['sidebar_right']) ? 'span12' : 'span8'; ?>">
      <?php if ($page['highlighted']): ?>
        <div class="highlighted hero-unit"><?php print render($page['highlighted']); ?></div>
      <?php endif; ?>
      <?php if ($breadcrumb): print $breadcrumb; endif;?>
      <a id="main-content"></a>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
        <h1 class="page-header"><?php print $title; ?></h1>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php print $messages; ?>
      <?php if ($tabs): ?>
        <?php print render($tabs); ?>
      <?php endif; ?>
      <?php if ($page['help']): ?>
        <div class="well"><?php print render($page['help']); ?></div>
      <?php endif; ?>
      <?php if ($action_links): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
	  <div id="vv-userpage-container">
	  <div class="row">
		<?php if ($user->uid != 0) { ?>
		<!-- START CUSTOM MENU -->
		<div class="span4">
			<?php print theme('links', array('links' => menu_navigation_links('menu-user-menu-links-manage-cont'), 'attributes' => array('id' => 'user-custom-menu', 'class'=> array('links', 'site-menu')) ));?>
		</div>
		<!-- END CUSTOM MENU -->
		<?php } ?>
		<div class="span3">
		  <?php print render($page['content']); ?>
		</div>
	  </div> <!-- row -->
	  </div> <!-- #vv-userpage-container -->
    </section>

    <?php if ($page['sidebar_right']): ?>
      <aside class="span4" role="complementary">
        <?php print render($page['sidebar_right']); ?>
      </aside>  <!-- /#sidebar-right -->
    <?php endif; ?>
  </div>
  <div class="row">
    <section class="span4">
        <div class="preface_first"><?php print render($page['preface_first']); ?></div>
    </section>
    <section class="span4">
        <div class="preface_second"><?php print render($page['preface_second']); ?></div>
    </section>
    <section class="span4">
        <div class="preface_third"><?php print render($page['preface_third']); ?></div>
    </section>
  </div>
  </div>

  <div class="row footer">
    <div id="footer">

      <footer class="footer container">
        <?php print render($page['footer']); ?>
      </footer>
    </div>
  </div>