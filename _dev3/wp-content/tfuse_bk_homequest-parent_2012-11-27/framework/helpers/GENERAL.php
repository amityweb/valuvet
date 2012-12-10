<?php

function tf_only_options(&$options) {
    $out = array();
    foreach ($options['tabs'] as $tab) {
        $headings = $tab['headings'];
        unset($tab['headings']);
        foreach ($headings as $heading) {
            foreach ($heading['options'] as $option) {
                $out[$option['id']] = $option;
            }
        }
    }
    return $out;
}

if (!function_exists('tfuse_qtranslate')) :

//qTranslate for custom fields
    function tfuse_qtranslate($text) {
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

        if (function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage'))
            $text = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($text);

        return $text;
    }

endif;

function tf_print($output) {
    echo '<pre style="margin-top:30px">';
    print_r($output);
    echo "</pre>";
}

function tfuse_options($option_name, $default = NULL, $cat_id = NULL) {
    global $tfuse_options;

    // optiunile sunt slavate cu PREFIX in fata, dar extragem scrim fara PREFIX
    // pentru a obtine PREFIX_logo vom folosi tfuse_options('logo')
    $option_name = TF_THEME_PREFIX . '_' . $option_name;

    if ($cat_id !== NULL) {
        if (@isset($tfuse_options['taxonomy'][$cat_id][$option_name]))
            $value = $tfuse_options['taxonomy'][$cat_id][$option_name];
    }
    else {
        if (!isset($tfuse_options['framework']))
            $tfuse_options['framework'] = decode_tfuse_options(get_option(TF_THEME_PREFIX . '_tfuse_framework_options'));

        if (isset($tfuse_options['framework'][$option_name]))
            $value = $tfuse_options['framework'][$option_name];
    }

    if (isset($value) && $value !== '')
        return $value;
    else
        return $default;
}

function tfuse_page_options($option_name, $default = NULL, $post_id = NULL) {
    global $post, $tfuse_options;

    if (!isset($post_id) && isset($post))
        $post_id = $post->ID;
    if (!isset($post_id))
        return;

    // optiunile sunt slavate cu PREFIX in fata, dar extragem scrim fara PREFIX
    // pentru a obtine PREFIX_logo vom folosi tfuse_page_options('logo')
    $option_name = TF_THEME_PREFIX . '_' . $option_name;

    if (isset($tfuse_options['post'][$post_id][$option_name]))
        $value = $tfuse_options['post'][$post_id][$option_name];
    else {
        $_options = get_post_meta($post_id, TF_THEME_PREFIX . '_tfuse_post_options', true);
        $tfuse_options['post'][$post_id] = decode_tfuse_options($_options);
        if (isset($tfuse_options['post'][$post_id][$option_name]))
            $value = $tfuse_options['post'][$post_id][$option_name];
    }

    if (isset($value) && $value !== '')
        return $value;
    else
        return $default;
}

function decode_tfuse_options($tfuse_options) {
    if (!is_array($tfuse_options))
        return;
    array_walk_recursive($tfuse_options, 'tfuse_apply_qtranslate');
    return $tfuse_options;
}

function tfuse_apply_qtranslate(&$item) {
    if (strtolower($item) === 'true')
        $item = TRUE;
    elseif (strtolower($item) === 'false')
        $item = FALSE;
    else
        $item = tfuse_qtranslate($item);
}

function tfget(&$val) {
    if (isset($val))
        return $val;
    else
        return NULL;
}

/**
 * Obtine o pparte specifica din string
 *
 * @param string $str Stringul di ncare vrem sa opbtinem prescurtata ...
 * @param string $more Stringul di ncare vrem sa opbtinem prescurtata ...
 * @param int $length Stringul di ncare vrem sa opbtinem prescurtata ...
 * @param int $minword Stringul di ncare vrem sa opbtinem prescurtata ...

 * @return string The image link if one is located.
 */
function tfuse_substr($str, $length, $more = '...', $minword = 3) {
    $sub = '';
    $len = 0;

    foreach (explode(' ', $str) as $word) {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);

        if (strlen($word) > $minword && strlen($sub) >= $length)
            break;
    }

    return ( ($len < strlen($str)) ? $sub . ' ' . $more : $sub );
}

/**
 * Retrieve the uri of the highest priority file that exists.
 *
 * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
 * inherit from a parent theme can just overload one file.
 *
 * @since 2.0
 *
 * @param string $file File to search for, in order.

 * @return string The file link if one is located.
 */
function tfuse_get_file_uri($file) {
    $file = ltrim($file, '/');
    if (file_exists(STYLESHEETPATH . '/' . $file))
        return get_stylesheet_directory_uri() . '/' . $file;
    else if (file_exists(TEMPLATEPATH . '/' . $file))
        return get_template_directory_uri() . '/' . $file;
    else
        return $file;
}

function tfuse_logo($echo = FALSE) {
    $logo = tfuse_get_file_uri('/images/logo.png');
    return tfuse_options('logo', $logo);
}

function tfuse_logo_footer($echo = FALSE) {
    $logo_footer = tfuse_get_file_uri('/images/logo_footer.png');
    return tfuse_options('logo_footer', $logo_footer);
}

function tfuse_favicon_and_css() {
    // Favicon
    $favicon = tfuse_options('favicon');
    if (!empty($favicon))
        echo '<link rel="shortcut icon" href="' . $favicon . '"/>' . PHP_EOL;

    // Custom CSS block in header
    $custom_css = tfuse_options('custom_css');
    if (!empty($custom_css)) {
        $output = '<style type="text/css">' . PHP_EOL;
        $output .= esc_attr($custom_css) . PHP_EOL;
        $output .= '</style>' . PHP_EOL;
        echo $output;
    }
}

add_action('wp_head', 'tfuse_favicon_and_css');

function tfuse_analytics() {
    echo tfuse_options('google_analytics');
}

add_action('wp_footer', 'tfuse_analytics', 100);

function tf_extimage($extension_name, $image_name) {
    $extension_name = strtolower($extension_name);
    return TFUSE_EXT_URI . '/' . $extension_name . '/static/images/' . $image_name;
}

function tf_config_extimage($extension_name, $image_name) {
    $extension_name = strtolower($extension_name);
    return TFUSE_EXT_CONFIG_URI . '/' . $extension_name . '/static/images/' . $image_name;
}

function tfuse_formatter($content) {
    $new_content = '';
    $pattern_full = '{(\[raw\].*?\[/raw\])}is';
    $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
    $pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

    foreach ($pieces as $piece) {
        if (preg_match($pattern_contents, $piece, $matches)) {
            $new_content .= $matches[1];
        } else {
            $new_content .= wptexturize(wpautop($piece));
        }
    }
    return $new_content;
}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

add_filter('the_content', 'tfuse_formatter', 99);
add_filter('themefuse_shortcodes', 'tfuse_formatter', 99);

/**
 * JSON encodes the array, echoes it and dies.
 * Mainly used in AJAX returns
 * 
 * @param array $array
 */
function tfjecho($array) {
    die(json_encode($array));
}

function tfuse_pk($data) {
    return urlencode(serialize($data));
}

function tfuse_unpk($data) {
    return tfuse_mb_unserialize(urldecode($data));
}

function tfuse_mb_unserialize($serial_str) {
    $string = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str);   
    return @unserialize($string);
}

function thumb_link($url) {
    if (is_multisite()) {
        global $blog_id;
        if (isset($blog_id) && $blog_id > 0) {
            $imageParts = explode('/files/', $url);
            if (isset($imageParts[1]))
                $url = network_site_url() . '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
        }
    }
    return $url;
}

function tf_can_ajax() {
    if (!current_user_can('publish_pages'))
        tfjecho(array('status' => -1, 'message' => 'You do not have the required privileges for this action.'));
}

function is_tf_front_page() {
    global $is_tf_front_page;
    return (bool) $is_tf_front_page;
}
