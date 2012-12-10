<?php

if (!function_exists('tfuse_browser_body_class')):

    /* This Function Add the classes of body_class()  Function
     * To override tfuse_browser_body_class() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
    */

    add_filter('body_class', 'tfuse_browser_body_class');

    function tfuse_browser_body_class() {

        global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

        if ($is_lynx)
            $classes[] = 'lynx';
        elseif ($is_gecko)
            $classes[] = 'gecko';
        elseif ($is_opera)
            $classes[] = 'opera';
        elseif ($is_NS4)
            $classes[] = 'ns4';
        elseif ($is_safari)
            $classes[] = 'safari';
        elseif ($is_chrome)
            $classes[] = 'chrome';
        elseif ($is_IE) {
            $browser = $_SERVER['HTTP_USER_AGENT'];
            $browser = substr("$browser", 25, 8);
            if ($browser == "MSIE 7.0")
                $classes[] = 'ie7';
            elseif ($browser == "MSIE 6.0")
                $classes[] = 'ie6';
            elseif ($browser == "MSIE 8.0")
                $classes[] = 'ie8';
            else
                $classes[] = 'ie';
        }
        else
            $classes[] = 'unknown';

        if ($is_iphone)
            $classes[] = 'iphone';

        return $classes;
    } // End function tfuse_browser_body_class()
endif;


if (!function_exists('tfuse_class')) :
    /* This Function Add the classes for middle container
     * To override tfuse_class() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
    */

    function tfuse_class($param, $return = false) {
        $tfuse_class = '';
        $sidebar_position = tfuse_sidebar_position();
        if ($param == 'middle')
        {
            if ($sidebar_position == 'left' || $sidebar_position == 'right')
                $tfuse_class = ' class="middle"';
            else
                $tfuse_class = ' class="middle full_width"';
        }
        elseif ($param == 'content')
        {
            $tfuse_class = ( isset($sidebar_position) && $sidebar_position != 'full' ) ? ' class="grid_8 content"' : ' class="content"';
        }

        if ($return)
            return $tfuse_class;
        else
            echo $tfuse_class;
    }
endif;


if (!function_exists('tfuse_sidebar_position')):
    /* This Function Set sidebar position
     * To override tfuse_sidebar_position() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
    */
    function tfuse_sidebar_position() {
        global $TFUSE;

        $sidebar_position = $TFUSE->ext->sidebars->current_position;
        if ( empty($sidebar_position) ) $sidebar_position = 'full';

        return $sidebar_position;
    }

// End function tfuse_sidebar_position()
endif;


if (!function_exists('tfuse_count_post_visits')) :
    /**
     * tfuse_count_post_visits.
     *
     * To override tfuse_count_post_visits() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_count_post_visits()
    {
        if ( !is_single() ) return;

        global $post;

        $tfuse_count =  get_post_meta($post->ID, TF_THEME_PREFIX . '_post_viewed', true);
        if ( empty($tfuse_count) ) $tfuse_count = 0;

        $popularArr = ( !empty( $_COOKIE['popular']) ) ? explode(',', $_COOKIE['popular']) : array();

        if ( !in_array($post->ID, $popularArr) )
        {
            update_post_meta($post->ID, TF_THEME_PREFIX . '_post_viewed', ++$tfuse_count);
            $popularArr[] = $post->ID;
            @setcookie('popular', implode(',', $popularArr),0,'/');
        }
    }
    add_action('wp_head', 'tfuse_count_post_visits');

// End function tfuse_count_post_visits()
endif;


if (!function_exists('tfuse_custom_title')):

    function tfuse_custom_title($customID = false,$return = false) {
        global $post,$front_page;

        if (is_numeric($customID))
            $ID = $customID;
        else
            $ID = $post->ID;

        $tfuse_title_type = tfuse_page_options('page_title', '', $ID);
        if ( $front_page ){
            $page_id = tfuse_options('home_page');
            $tfuse_title_type = tfuse_page_options('page_title','',$page_id);
            $ID =$page_id;
        }

        if ($tfuse_title_type == 'hide_title')
            $title = '';
        elseif ($tfuse_title_type == 'custom_title')
            $title = tfuse_page_options('custom_title', '', $ID);
        else
            $title = get_the_title($ID);

        if( $return ) return $title;

        echo ( $title ) ? '<h1>' . $title . '</h1>' : '';
    }

endif;

if (!function_exists('tfuse_archive_custom_title')):
    /**
     *  Set the name of post archive.
     *
     * To override tfuse_archive_custom_title() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_archive_custom_title()
    {
        $cat_ID = 0;
        if ( is_category() )
        {
            $cat_ID = get_query_var('cat');
            $title = single_term_title( '', false );
        }
        elseif ( is_tax() )
        {
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $cat_ID = $term->term_id;
            $title = single_term_title( $term->name , false );
        }
        elseif ( is_post_type_archive() )
        {
            $title = post_type_archive_title('',false);
        }

        $tfuse_title_type = tfuse_options('page_title',null,$cat_ID);

        if ($tfuse_title_type == 'hide_title')
            $title = '';
        elseif ($tfuse_title_type == 'custom_title')
            $title = tfuse_options('custom_title',null,$cat_ID);

        echo !empty($title) ? '<h1>' . $title . '</h1>' : '';
    }

endif;



if (!function_exists('tfuse_user_profile')) :
    /**
     * Retrieve the requested data of the author of the current post.
     *
     * @param array $fields first_name,last_name,email,url,aim,yim,jabber,facebook,twitter etc.
     * @return null|array The author's spefified fields from the current author's DB object.
     */
    function tfuse_user_profile( $fields = array() )
    {
        $tfuse_meta = null;

        // Get stnadard user contact info
        $standard_meta = array(
            'first_name' => get_the_author_meta('first_name'),
            'last_name' => get_the_author_meta('last_name'),
            'email'     => get_the_author_meta('email'),
            'url'       => get_the_author_meta('url'),
            'aim'       => get_the_author_meta('aim'),
            'yim'       => get_the_author_meta('yim'),
            'jabber'    => get_the_author_meta('jabber')
        );

        // Get extended user info if exists
        $custom_meta = (array) get_the_author_meta('theme_fuse_extends_user_options');

        $_meta = array_merge($standard_meta,$custom_meta);

        foreach ($_meta as $key => $item) {
            if ( !empty($item) && in_array($key, $fields) ) $tfuse_meta[$key] = $item;
        }

        return apply_filters('tfuse_user_profile', $tfuse_meta, $fields);
    }

endif;


if (!function_exists('tfuse_action_comments')) :
    /**
     *  This function disable post commetns.
     *
     * To override tfuse_action_comments() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_action_comments() {
        global $post;
        if (!tfuse_page_options('disable_comments'))
            comments_template( '', true );
    }

    add_action('tfuse_comments', 'tfuse_action_comments');
endif;


if (!function_exists('tfuse_get_comments')):
    /**
     *  Get post comments for a specific post.
     *
     * To override tfuse_get_comments() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_get_comments($return = TRUE, $post_ID) {
        $num_comments = get_comments_number($post_ID);

        if (comments_open($post_ID)) {
            if ($num_comments == 0) {
                $comments = __('No Comments','tfuse');
            } elseif ($num_comments > 1) {
                $comments = $num_comments . __(' Comments','tfuse');
            } else {
                $comments = __('1 Comment','tfuse');
            }
            $write_comments = '<a class="link-comments" href="' . get_comments_link($post_ID) . '">' . $comments . '</a>';
        } else {
            $write_comments = __('Comments are off','tfuse');
        }
        if ($return)
            return $write_comments;
        else
            echo $write_comments;
    }

endif;


if (!function_exists('tfuse_shortcode_content')) :
    /**
     *  Get post comments for a specific post.
     *
     * To override tfuse_shortcode_content() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_shortcode_content($position = '', $return = false)
    {
        $page_shortcodes = '';
        global $is_tf_front_page,$is_tf_blog_page;
        $position = ( $position == 'before' ) ? 'content_top' : 'content_bottom';

        if ( $is_tf_blog_page ) {
            $position = $position.'_blog';
            $page_shortcodes = tfuse_options($position);
        }
        elseif ( $is_tf_front_page ) {
            if(tfuse_options('use_page_options') && tfuse_options('homepage_category')=='page'){
                $page_id = tfuse_options('home_page');
                $page_shortcodes = tfuse_page_options($position,'',$page_id);
            }
            else
                $page_shortcodes = tfuse_options($position);
        }
        elseif (is_singular()) {
            global $post;
            $page_shortcodes = tfuse_page_options($position);
        } elseif (is_category()) {
            $cat_ID = get_query_var('cat');
            $page_shortcodes = tfuse_options($position, '', $cat_ID);
        } elseif (is_tax()) {
            $taxonomy = get_query_var('taxonomy');
            $term = get_term_by('slug', get_query_var('term'), $taxonomy);
            $cat_ID = $term->term_id;
            $page_shortcodes = tfuse_options($position, '', $cat_ID);
        }

        $page_shortcodes = tfuse_qtranslate($page_shortcodes);

        $page_shortcodes = apply_filters('themefuse_shortcodes', $page_shortcodes);

        if ($return)
            return $page_shortcodes; else
            echo $page_shortcodes;
    }

// End function tfuse_shortcode_content()
endif;


if (!function_exists('tfuse_category_on_front_page')) :
    /**
     * Dsiplay homepage category
     *
     * To override tfuse_category_on_front_page() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_category_on_front_page()
    {
        if ( !is_front_page() ) return;

        global $is_tf_front_page,$homepage_categ;
        $is_tf_front_page = false;

        $homepage_category = tfuse_options('homepage_category');
        $homepage_category = explode(",",$homepage_category);
        foreach($homepage_category as $homepage)
        {
            $homepage_categ = $homepage;
        }

        if($homepage_categ == 'specific')
        {
            $is_tf_front_page = true;
            $archive = 'archive.php';
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $specific = tfuse_options('categories_select_categ');

            $items = get_option('posts_per_page');
            $ids = explode(",",$specific);
            $posts = array(); $num_post = 0;
            foreach ($ids as $id){
                $posts[] = get_posts(array('category' => $id));
            }
            foreach($posts as $post)
            {
                $num_posts = count($post);
                $num_post += $num_posts;
            }
            $max = $num_post/$items;
            if($num_posts%$items) $max++;

            $args = array(
                'cat' => $specific,
                'orderby' => 'date',
                'paged' => $paged
            );
            query_posts($args);


            wp_localize_script(
                'tf-load-posts',
                'nr_posts',
                array(
                    'max' => $max
                )
            );

            include_once(locate_template($archive));

            return;
        }
        elseif($homepage_categ == 'page')
        {
            global $front_page;
            $is_tf_front_page = true;
            $front_page = true;
            $archive = 'page.php';
            $page_id = tfuse_options('home_page');

            $args=array(
                'page_id' => $page_id,
                'post_type' => 'page',
                'post_status' => 'publish',
                'posts_per_page' => 1,
                'ignore_sticky_posts'=> 1
            );
            query_posts($args);
            include_once(locate_template($archive));
            wp_reset_query();
            return;
        }
        elseif($homepage_categ == 'all')
        {
            $archive = 'archive.php';

            $is_tf_front_page = true;
            wp_reset_postdata();
            include_once(locate_template($archive));
            return;
        }

    }

// End function tfuse_category_on_front_page()
endif;

if (!function_exists('tfuse_category_on_blog_page')) :
    /**
     * Dsiplay blogpage category
     *
     * To override tfuse_category_on_blog_page() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_category_on_blog_page()
    {
        global $is_tf_blog_page,$blogpage_categ;
        if ( !$is_tf_blog_page ) return;
        $is_tf_blog_page = false;

        $blogpage_category = tfuse_options('blogpage_category');
        $blogpage_category = explode(",",$blogpage_category);
        foreach($blogpage_category as $blogpage)
        {
            $blogpage_categ = $blogpage;
        }

        if($blogpage_categ == 'specific')
        {
            $is_tf_blog_page = true;
            $archive = 'archive.php';
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $specific = tfuse_options('categories_select_categ_blog');

            $items = get_option('posts_per_page');
            $ids = explode(",",$specific);
            $posts = array(); $num_post = 0;
            foreach ($ids as $id){
                $posts[] = get_posts(array('category' => $id));
            }
            foreach($posts as $post)
            {
                $num_posts = count($post);
                $num_post += $num_posts;
            }
            $max = $num_post/$items;
            if($num_posts%$items) $max++;

            $args = array(
                'cat' => $specific,
                'orderby' => 'date',
                'paged' => $paged
            );
            query_posts($args);
            wp_localize_script(
                'tf-load-posts',
                'nr_posts',
                array(
                    'max' => $max
                )
            );
            include_once(locate_template($archive));
            return;
        }
        elseif($blogpage_categ == 'all')
        {
            $is_tf_blog_page = true;
            $archive = 'archive.php';
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $categories = get_categories();

            $ids = array();
            foreach($categories as $cats){
                $ids[] = $cats -> term_id;
            }
            $items = get_option('posts_per_page');
            $posts = array(); $num_post = 0;

            foreach ($ids as $id){
                $posts[] = get_posts(array('category' => $id));
            }
            foreach($posts as $post)
            {
                $num_posts = count($post);
                $num_post += $num_posts;
            }
            $max = $num_post/$items;
            if($num_posts%$items) $max++;

            $args = array(
                'orderby' => 'date',
                'paged' => $paged
            );
            query_posts($args);
            wp_localize_script(
                'tf-load-posts',
                'nr_posts',
                array(
                    'max' => $max
                )
            );
            include_once(locate_template($archive));
            return;
        }
    }
// End function tfuse_category_on_blog_page()
endif;


if (!function_exists('tfuse_action_footer')) :
    /**
     * Dsiplay footer content
     *
     * To override tfuse_action_footer() in a child theme, add your own tfuse_action_footer()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_action_footer()
    {

        if ( !tfuse_options('enable_footer_shortcodes') )
        {
            ?>
        <div class="f_col_1">
            <?php dynamic_sidebar('footer-1'); ?>
        </div><!--/ f_col_1 -->

        <div class="f_col_2">
            <?php dynamic_sidebar('footer-2'); ?>
        </div><!--/ f_col_2 -->

        <div class="f_col_3">
            <?php dynamic_sidebar('footer-3'); ?>
        </div><!--/ f_col_3 -->

        <?php
        } else
        {
            $footer_shortcodes = tfuse_options('footer_shortcodes');
            echo $page_shortcodes = apply_filters('themefuse_shortcodes', $footer_shortcodes);
        } ?>

    <div class="f_col_4">
        <?php dynamic_sidebar('footer-4'); ?>

        <?php tfuse_social_footer(); ?>

        <div class="copyright">
            <?php echo tfuse_options('custom_copyright');?>
        </div>
    </div><!--/ f_col_4 -->
    <?php
    }

    add_action('tfuse_footer', 'tfuse_action_footer');
endif;


if (!function_exists('tfuse_social_footer')) :
    /**
     * Display social icons in footer
     *
     * To override tfuse_category_on_front_page() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_social_footer()
    {
        $template_directory = get_template_directory_uri() . '/';

        $rss_url = tfuse_options('feedburner_url',null);
        $fb_url = tfuse_options('facebook',null);
        $twitter_url = tfuse_options('twitter',null);

        if( ($rss_url == null) && ($fb_url == null) && ($twitter_url == null) ) return;

        ?>
    <div class="footer_social">
        <?php if ( $fb_url != null){?><a href="<?php echo $fb_url; ?>"><img src="<?php echo $template_directory ;?>images/icons/social_facebook_16.png" alt="" width="16" height="16"></a><?php } ?>
        <?php if ( $twitter_url != null){?><a href="<?php echo $twitter_url; ?>"><img src="<?php echo $template_directory ;?>images/icons/social_twitter_16.png" alt="" width="16" height="16"></a><?php } ?>
        <?php if ( $rss_url != null){?><a href="<?php echo $rss_url; ?>"><img src="<?php echo $template_directory ;?>images/icons/social_rss_16.png" alt="" width="16" height="16"></a><?php } ?>
        <div class="clear"></div>
    </div>
    <?php
    }

endif;




if (!function_exists('tfuse_shorten_string')) :
    /**
     *
     *
     * To override tfuse_shorten_string() in a child theme, add your own tfuse_shorten_string()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_shorten_string($string, $wordsreturned)

    {
        $retval = $string;

        $array = explode(" ", $string);
        if (count($array)<=$wordsreturned)

        {
            $retval = $string;
        }
        else

        {
            array_splice($array, $wordsreturned);
            $retval = implode(" ", $array)." ...";
        }
        return $retval;
    }

endif;


if (!function_exists('tfuse_header_background')) :
    /**
     * Display style for header
     *
     * To override tfuse_header_background() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_header_background()
    {
        $template_directory = get_template_directory_uri();

        $pattern = tfuse_options('custom_header_image',null);

        $default_pattern = tfuse_options('default_header_image',null);

        $color = tfuse_options('header_color',null);
        if(!preg_match('/^#[a-f0-9]{6}$/i', $color)){ $color = null;}

        if (!empty($_GET['image']))
        {
            $pattern = $template_directory . '/images/' . $_GET['image'];
            setcookie("themefuse_demo_homequest_image",  $_GET['image']);
        }
        else
        {
            if(!empty($_COOKIE['themefuse_demo_homequest_image'])) $pattern = $template_directory . '/images/' . $_COOKIE['themefuse_demo_homequest_image'];
        }

        if (!empty($_GET['color']) )
        {
            $color =  '#' . $_GET['color'];
            setcookie("themefuse_demo_homequest_color",  $_GET['image']);
        }
        {
            if(!empty($_COOKIE['themefuse_demo_homequest_color'])) $color =  '#' . $_COOKIE['themefuse_demo_homequest_color'];
        }

        $html = ' style="';
        if ( $pattern != null )
            $html .= 'background-image:url(' . $pattern . ');';
        else
            $html .= 'background-image:url(' . $template_directory. '/images/' . $default_pattern . ');';

        if ( $color != null )
            $html .= 'background-color:' . $color;
        $html .= '"';

        echo $html;
    }

endif;


if (!function_exists('encodeURIComponent')) :
    /**
     *
     *
     * To override encodeURIComponent() in a child theme, add your own encodeURIComponent()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function encodeURIComponent($str) {
        $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
        return strtr(rawurlencode($str), $revert);
    }

endif;


if (!function_exists('tfuse_pagination')) :
    /**
     * Display pagination to next/previous pages when applicable.
     *
     * To override tfuse_pagination() in a child theme, add your own tfuse_pagination()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */
    function tfuse_pagination($query = '', $args = array()){

        global $wp_rewrite, $wp_query;
        $template_directory = get_template_directory_uri() . '/';

        if ( $query ) {

            $wp_query = $query;

        } // End IF Statement


        /* If there's not more than one page, return nothing. */
        if ( 1 >= $wp_query->max_num_pages )
            return false;

        /* Get the current page. */
        $current = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );

        /* Get the max number of pages. */
        $max_num_pages = intval( $wp_query->max_num_pages );

        /* Set up some default arguments for the paginate_links() function. */
        $defaults = array(
            'base' => add_query_arg( 'paged', '%#%' ),
            'format' => '',
            'total' => $max_num_pages,
            'current' => $current,
            'prev_next' => false,
            'show_all' => false,
            'end_size' => 2,
            'mid_size' => 1,
            'add_fragment' => '',
            'type' => 'plain',
            'before' => '',
            'after' => '',
            'echo' => true,
        );

        /* Add the $base argument to the array if the user is using permalinks. */
        if( $wp_rewrite->using_permalinks() )
            $defaults['base'] = user_trailingslashit( trailingslashit( get_pagenum_link() ) . 'page/%#%' );

        /* If we're on a search results page, we need to change this up a bit. */
        if ( is_search() ) {
            $search_permastruct = $wp_rewrite->get_search_permastruct();
            if ( !empty( $search_permastruct ) )
                $defaults['base'] = user_trailingslashit( trailingslashit( get_search_link() ) . 'page/%#%' );
        }

        /* Merge the arguments input with the defaults. */
        $args = wp_parse_args( $args, $defaults );

        /* Don't allow the user to set this to an array. */
        if ( 'array' == $args['type'] )
            $args['type'] = 'plain';

        /* Get the paginated links. */
        $page_links = paginate_links( $args );

        /* Remove 'page/1' from the entire output since it's not needed. */
        $page_links = str_replace( array( '&#038;paged=1\'', '/page/1\'' ), '\'', $page_links );

        /* Wrap the paginated links with the $before and $after elements. */
        $page_links = $args['before'] . $page_links . $args['after'];

        /* Return the paginated links for use in themes. */
        if ( $args['echo'] )
        {
            ?>
        <!-- pagination -->
        <div class="block_hr tf_pagination">
            <div class="inner">
                <?php $prev_posts = get_previous_posts_link(__('<span>PREVIOUS</span>', 'tfuse')); ?>
                <?php $next_posts = get_next_posts_link(__('<span>NEXT</span>', 'tfuse')); ?>
                <?php if ($prev_posts != '') { echo $prev_posts;} else { echo '<a class="page_prev" href="javascript:void(0);"><span>'; _e('PREVIOUS', 'tfuse'); echo '</span></a>'; }?>
                <?php if ($next_posts != '') { echo $next_posts;} else { echo '<a class="page_next" href="javascript:void(0);"><span>'; _e('NEXT', 'tfuse'); echo '</span></a>'; } ?>
                <?php echo $page_links; ?>

            </div>
        </div>
        <!--/ pagination -->
        <?php
        }
        else
            return $page_links;

    }

endif; // tfuse_pagination


if (!function_exists('next_posts_link_css')) :
    /**
     * Display pagination to next/previous pages when applicable.
     *
     * To override next_posts_link_css() in a child theme, add your own next_posts_link_css()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */
    function next_posts_link_css() {

        return 'class="page_next"';
    }
    add_filter('next_posts_link_attributes', 'next_posts_link_css' );
endif;


if (!function_exists('previous_posts_link_css')) :
    /**
     * Display pagination to next/previous pages when applicable.
     *
     * To override previous_posts_link_css() in a child theme, add your own previous_posts_link_css()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */
    function previous_posts_link_css() {

        return 'class="page_prev"';
    }
    add_filter('previous_posts_link_attributes', 'previous_posts_link_css' );
endif; // tfuse_pagination


if (!function_exists('tfuse_enqueue_comment_reply')) :
    /**
     *
     * To override tfuse_enqueue_comment_reply() in a child theme, add your own tfuse_enqueue_comment_reply()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */
function tfuse_enqueue_comment_reply() {
    // on single blog post pages with comments open and threaded comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        // enqueue the javascript that performs in-link comment reply fanciness
        wp_enqueue_script( 'comment-reply' );
    }
}
// Hook into wp_enqueue_scripts
add_action( 'wp_head', 'tfuse_enqueue_comment_reply' );
endif;


if (!function_exists('tfuse_new_excerpt_more')) :
    /**
     *
     * To override tfuse_new_excerpt_more() in a child theme, add your own tfuse_new_excerpt_more()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */
function tfuse_new_excerpt_more() {
    return '...';
}

add_filter('excerpt_more', 'tfuse_new_excerpt_more' );
endif;


if (!function_exists('tfuse_custom_excerpt_length')) :
    /**
     *
     * To override tfuse_custom_excerpt_length() in a child theme, add your own tfuse_custom_excerpt_length()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */
    function tfuse_custom_excerpt_length( $length) {
        return 44;
    }
    add_filter( 'excerpt_length', 'tfuse_custom_excerpt_length', 99 );

endif;


if (!function_exists('tfuse_page_content')) :
    /**
     * Display post media.
     *
     * To override tfuse_page_content() in a child theme, add your own tfuse_page_content()
     * to your child theme's file.
     */
    function tfuse_page_content($arg ,$ID)
    {   global $front_page;
       if (!is_numeric($ID)) return false;
       if ($arg == 'before')
       {
           ?>
           <!-- page content -->
           <div class="entry">
                <?php if($front_page) {
                    if(tfuse_options('use_page_options') && tfuse_options('homepage_category')=='page'){
                        $page_id = tfuse_options('home_page');
                        echo apply_filters('themefuse_shortcodes', tfuse_page_options('before_page_content',null,$page_id));
                    }
                    else echo apply_filters('themefuse_shortcodes', tfuse_options('before_page_content'));
                }
                else echo apply_filters('themefuse_shortcodes', tfuse_page_options('before_page_content',null,$ID)); ?>
           </div>
           <!--/ page content -->
           <?php
       }

    }

endif;


if (!function_exists('tfuse_get_short_text')) :
    /**
     *
     *
     * To override tfuse_get_short_text() in a child theme, add your own tfuse_get_short_text()
     * to your child theme's file.
     */
    function tfuse_get_short_text($text,$limit=20)
    {
        if (mb_strlen($text, 'UTF-8') <= $limit or (!strpos($text, ' '))) return $text;
        $explode = explode(' ',$text);
        $string  = '';

        $dots = '...';
        if(count($explode) <= $limit){
            $dots = '';
        }
        for($i=0;$i<$limit;$i++){
            $string .= $explode[$i]." ";
        }
        if ($dots) {
            $string = substr($string, 0, mb_strlen($string, 'UTF-8'));
        }

        return $string.$dots;
    }

endif;


if (!function_exists('tfuse_get_main_attachement')) :
    /**
     *
     *
     * To override tfuse_get_main_attachement() in a child theme, add your own tfuse_get_main_attachement()
     * to your child theme's file.
     */
    function tfuse_get_main_attachement($ID)
    {
       $attachements = tfuse_get_gallery_images($ID,TF_THEME_PREFIX . '_slider_images');
       $main_img  = false;
       foreach($attachements as $attachement)
       {
           if (isset($attachement->image_options['imgmain_check']))
           {
               $main_img = $attachement->guid;
               break;
           }
       }
        if(!$main_img && sizeof($attachements)) $main_img = array_shift(array_values($attachements))->guid;
        return $main_img;
    }

endif;


if (!function_exists('tfuse_get_property_taxonomies')) :
    /**
     *
     *
     * To override tfuse_get_property_taxonomies() in a child theme, add your own tfuse_get_property_taxonomies()
     * to your child theme's file.
     */
    function tfuse_get_property_taxonomies($ID, $in_taxonomy = '')
    {
       if(empty($ID) || (!is_numeric($ID))) return false;
       if(!empty($in_taxonomy)) $in_taxonomy = TF_SEEK_HELPER::get_post_type() . '_' . $in_taxonomy;
       global $wpdb;

        $sql = "SELECT $wpdb->terms.term_id
                 , $wpdb->terms.name, $wpdb->terms.slug, $wpdb->term_taxonomy.taxonomy
                FROM
                  $wpdb->term_relationships
                INNER JOIN $wpdb->term_taxonomy
                ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id
                INNER JOIN $wpdb->terms
                ON $wpdb->terms.term_id = $wpdb->term_taxonomy.term_id
                WHERE
                  $wpdb->term_relationships.object_id = '" . $ID . "'
                AND $wpdb->term_taxonomy.taxonomy = '" . $in_taxonomy . "'";

      $result =  $wpdb->get_results($sql, ARRAY_A );
      return $result;
    }

endif;

if (!function_exists('tfuse_get_count_properties_by_taxonomy_id')) :
    /**
     *
     *
     * To override tfuse_get_count_properties_by_taxonomy_id() in a child theme, add your own tfuse_get_count_properties_by_taxonomy_id()
     * to your child theme's file.
     */
    function tfuse_get_count_properties_by_taxonomy_id($ID)
    {
        $term_id = intval($ID);
        if (!is_numeric($term_id)) return false;
        global $wpdb;
        $term_id = (string)$term_id;

        $sql = "SELECT COUNT(*) as count
FROM
  tf_homequest_seek_index_posts
WHERE
  tf_homequest_seek_index_posts._terms LIKE '%". $term_id . ",%'";

        $result =  $wpdb->get_results($sql, ARRAY_A );

        return $result;
    }

endif;


if (!function_exists('tfuse_get_properties_by_taxonomy_id')) :
    /**
     *
     *
     * To override tfuse_get_properties_by_taxonomy_id() in a child theme, add your own tfuse_get_properties_by_taxonomy_id()
     * to your child theme's file.
     */
    function tfuse_get_properties_by_taxonomy_id($ID,$order_desc, $start, $final)
    {
        $term_id = intval($ID);
        if (!is_numeric($term_id)) return false;
        global $wpdb;
        $term_id = (string)$term_id;
        if(!$order_desc)
        {
            $order = '';
        }
        else
        {
            $order = ' DESC';
        }
        $sql = "SELECT tf_homequest_seek_index_posts.post_id
     , tf_homequest_seek_index_posts.seek_property_price
     , $wpdb->posts.post_content
     , $wpdb->posts.post_title
FROM
  tf_homequest_seek_index_posts
  INNER JOIN wp_posts
ON tf_homequest_seek_index_posts.post_id = $wpdb->posts.ID
WHERE
  tf_homequest_seek_index_posts._terms LIKE '%". $term_id . ",%' ORDER BY
  tf_homequest_seek_index_posts.seek_property_price" . $order . ' LIMIT ' . $start . ', ' . $final;

        $result =  $wpdb->get_results($sql,ARRAY_A);

        return $result;
    }

endif;


if (!function_exists('tfuse_view_property_on_the_map')) :
    /**
     *
     *
     * To override tfuse_view_property_on_the_map() in a child theme, add your own tfuse_view_property_on_the_map()
     * to your child theme's file.
     */
    function tfuse_view_property_on_the_map($ID)
    {
        if(empty($ID) || (!is_numeric($ID))) return false;
        $before_content_element = tfuse_page_options('before_content_element', null, $ID);
        if ($before_content_element != 'map') return false;
        $output = '<a href="' . get_permalink($ID) . '" class="link-viewmap tooltip" title="'. __('View on Map', 'tfuse') . '">' . __('View on Map', 'tfuse') . '</a>';

        echo $output;
    }

endif;


if (!function_exists('tfuse_get_property_images')) :
    /**
     *
     *
     * To override tfuse_get_property_images() in a child theme, add your own tfuse_get_property_images()
     * to your child theme's file.
     */
    function tfuse_get_property_images($ID)
    {
        if(empty($ID) || (!is_numeric($ID))) return false;


        $attachments1 = tfuse_get_gallery_images($ID,TF_THEME_PREFIX . '_slider_images');
        $attachments = array();
        foreach ($attachments1 as $attachment)   :
            if( isset($attachment->image_options['imgexcludefromslider_check']) ) continue;
            $attachments[] = $attachment;
        endforeach;

        if (!count($attachments))
        {
            return false;
        }
        $output = '';
        $output .= '<a href="' . $attachments[0]->guid . '" data-rel="prettyPhoto['. $ID .']" class="link-viewimages tooltip" title="' . __("View Images", "tfuse") . '">' . __("View Images", "tfuse") . '</a>';

        array_shift($attachments);

        foreach ($attachments as $attachment)   :
            if( TF_SEEK_POST_ATTACHMENTS::img_is_excluded_from_slider($attachment->ID) ) continue;
            $output .= '<a href="' . $attachment->guid . '" data-rel="prettyPhoto['. $ID .']"></a>';
        endforeach;

        echo $output;
    }

endif;


if (!function_exists('tfuse_property_pagination')) :
    /**
     *
     *
     * To override tfuse_property_pagination() in a child theme, add your own tfuse_property_pagination()
     * to your child theme's file.
     */
    function tfuse_property_pagination($location = 'top')
    {
        $output = '';
        echo $output;
    }

endif;

if (!function_exists('tfuse_aasort')) :
    /**
     *
     *
     * To override tfuse_aasort() in a child theme, add your own tfuse_aasort()
     * to your child theme's file.
     */
    function tfuse_aasort ($array, $key) {
        $sorter=array();
        $ret=array();
        if (!$array){$array = array();}
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii]=$array[$ii];
        }
        return $ret;
    }
endif;


if (!function_exists('tfuse_get_property_thumbnail')) :
    /**
     *
     *
     * To override tfuse_get_property_thumbnail() in a child theme, add your own tfuse_get_property_thumbnail()
     * to your child theme's file.
     */
    function tfuse_get_property_thumbnail ($ID)
    {
        $src = tfuse_page_options('thumbnail_image', null, $ID);
        if(!$src) $src = tfuse_get_main_attachement($ID);
        if(!$src) $src = get_template_directory_uri() . '/images/dafault_image.jpg';
        return $src;
    }
endif;


function tfuse_get_page_template_name($page_id) {
    if (is_page()) {  // Currently displaying a Page?
        // Grab the template filename from Page metadata, but discard any .php extension.
        return str_replace('.php', '', get_post_meta($page_id, '_wp_page_template', true));
    }
    return '';
}

function tfuse_get_template_name(){
    if(tfuse_options('use_page_options') && tfuse_options('homepage_category')=='page'){
        $page_id = tfuse_options('home_page');
        $template_name = tfuse_get_page_template_name($page_id);
    }
    else $template_name='';
    return $template_name;
}
