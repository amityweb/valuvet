<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');
/*
 * Option generator class
 */

/**
 * Description of OPTIGEN
 *
 */
class TF_OPTIGEN extends TF_TFUSE {

    public $_the_class_name = 'OPTIGEN';

    function __construct() {
        parent::__construct();
    }

    function _auto($opts) {
        if (isset($opts['type']))
            return $this->{$opts['type']}($opts);
        else
            die('Option type not set in OPTIGEN.');
    }

    function text($opts) {
        $propstr = '';
        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        $opts['properties'] = $this->strip_props($opts['properties']);
        # set some defaults
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'].=' tfuse_option';
        #end set defaults
        $propstr = $this->propstr($opts['properties']);
        # properties
        $output = '<input ' . $propstr . ' name="' . esc_attr($opts['id']) . '" id="' . esc_attr($opts['id']) . '" type="text" value="' . esc_attr($opts['value']) . '" />';
        if (has_filter("tfuse_form_text_{$opts['id']}")) {
            return apply_filters("tfuse_form_text_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_text', $output, $opts);
    }

    function addable($opts) {
        $output = '<input type="hidden" name="' . esc_attr($opts['id']) . '" id="' . esc_attr($opts['id']) . '" value="' . esc_attr($opts['value']) . '"/>';
        foreach ($opts['options'] as $option) {
            $output .= '' . $this->_auto($option);
        }
        if (has_filter("tfuse_form_addable_{$opts['id']}")) {
            return apply_filters("tfuse_form_addable_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_addable', $output, $opts);
    }

    function raw($opts) {
        $output = '<input type="hidden" value=""/>';
        $output.='<span class="raw_option" id="' . $opts['id'] . '">' . $opts['html'] . '</span>';
        if (has_filter("tfuse_form_raw_{$opts['id']}")) {
            return apply_filters("tfuse_form_raw_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_raw', $output, $opts);
    }

    function colorpicker($opts) {
        $propstr = '';
        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        # set some defaults
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'].=' tf_color_select tfuse_option';
        #end set defaults
        $opts['properties'] = $this->strip_props($opts['properties']);
        $propstr = $this->propstr($opts['properties']);
        # /properties
        $output = '<input ' . $propstr . ' name="' . esc_attr($opts['id']) . '" id="' . esc_attr($opts['id']) . '" type="text" value="' . esc_attr($opts['value']) . '" />';
        if (has_filter("tfuse_form_colorpicker_{$opts['id']}")) {
            return apply_filters("tfuse_form_colorpicker_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_colorpicker', $output, $opts);
    }
    function textarray($opts) {
        $propstr = '';
        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        # set some defaults
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'].=' tfuse_option';
        #end set defaults
        $opts['properties'] = $this->strip_props($opts['properties']);
        $propstr = $this->propstr($opts['properties']);
        # properties
        $output = '<input ' . $propstr . ' name="' . esc_attr($opts['id']) . '[]" id="' . esc_attr($opts['id']) . '_w" type="text" value="' . esc_attr($opts['value'][0]) . '" />';
        $output .= ' X <input ' . $propstr . ' name="' . esc_attr($opts['id']) . '[]" id="' . esc_attr($opts['id']) . '_h" type="text" value="' . esc_attr($opts['value'][1]) . '" />';
        if (has_filter("tfuse_form_textarray_{$opts['id']}")) {
            return apply_filters("tfuse_form_textarray_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_textarray', $output, $opts);
    }

    function textarea($opts) {
        $propstr = '';
        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        $opts['properties'] = $this->strip_props($opts['properties']);
        # assign some default properties, if not implicitely set
        if (!isset($opts['properties']['cols']))
            $opts['properties']['cols'] = 5;
        if (!isset($opts['properties']['rows']))
            $opts['properties']['rows'] = 8;
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'].=' tfuse_option';
        $propstr = $this->propstr($opts['properties']);
        # /properties
        $output = '<textarea ' . $propstr . ' name="' . $opts['id'] . '" id="' . $opts['id'] . '">' . esc_attr($opts['value']) . '</textarea>';
        if (has_filter("tfuse_form_textarea_{$opts['id']}")) {
            return apply_filters("tfuse_form_textarea_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_textarea', $output, $opts);
    }

    function checkbox($opts) {
        $propstr = '';
        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        $opts['properties'] = $this->strip_props($opts['properties']);
        #set some default values
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'].=' single_checkbox tfuse_option';
        $propstr = $this->propstr($opts['properties']);
        # /properties
        $checked = (isset($opts['value']) && $opts['value'] == 'true') ? 'checked="checked"' : '';
        $on = $checked ? ' on' : '';
        if(!isset($opts['disabled'])) $opts['disabled'] = 'false';
        $disabled = ($opts['disabled'] == 'true') ? ' disabled' : '';
        $output = '<input ' . $propstr . ' type="checkbox" name="' . $opts['id'] . '" id="' . $opts['id'] . '" value="true" ' . $checked . ' />';
        if($disabled and $opts['value'] == 'true') $output = '<input type="hidden" name="' . $opts['id'] . '" value="'.$opts['value'].'" />';
        $output.='<label class="tf_checkbox_switch' . $on . $disabled . '" for="' . $opts['id'] . '"></label>';
        if (has_filter("tfuse_form_checkbox_{$opts['id']}")) {
            return apply_filters("tfuse_form_checkbox_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_checkbox', $output, $opts);
    }

    function radio($opts) {
        $propstr = '';
        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        $opts['properties'] = $this->strip_props($opts['properties']);
        #set some default values
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'].=' tfuse_option checkbox ' . $opts['id'];
        $propstr = $this->propstr($opts['properties']);
        # /properties
        $output = '';
        foreach ($opts['options'] as $key => $option) {
            if ($key === 0)
                continue;

            $checked = ($opts['value'] === (string) $key) ? 'checked="checked"' : '';

            $output .= '
            <div class="multicheckbox"><input ' . $propstr . ' type="radio" name="' . $opts['id'] . '"  value="' . $key . '" ' . $checked . ' />
            ' . $option . '</div>';
        }

        if (has_filter("tfuse_form_radio_{$opts['id']}")) {
            return apply_filters("tfuse_form_radio_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_radio', $output, $opts);
    }

    function select($opts) {
        $propstr = '';
        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        $opts['properties'] = $this->strip_props($opts['properties']);
        #set some default values
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'].=' tfuse_option';
        #end set defaults
        $propstr = $this->propstr($opts['properties']);
        # /properties
        $output = '<select ' . $propstr . ' name="' . $opts['id'] . '" id="' . $opts['id'] . '">';

        if(isset($opts['options']) && count($opts['options']) > 0)
            foreach ($opts['options'] as $key => $option) {
                $selected = ($opts['value'] == $key) ? ' selected="selected"' : '';

                $output .= '<option' . $selected . ' value="' . $key . '">';
                $output .= $option;
                $output .= '</option>';
            }

        $output .= '</select>';

        if (has_filter("tfuse_form_select_{$opts['id']}")) {
            return apply_filters("tfuse_form_select_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_select', $output, $opts);
    }

    function styles() {
        $styles = array();

        foreach (glob(TEMPLATEPATH . '/styles/*.css') as $style) {
            $style = basename($style);
            $styles[$style] = $style;
        }

        return apply_filters('tfuse_form_styles', $styles);
    }

    function category_template() {
        $templates = array();

        foreach (glob(TEMPLATE_CAT . '/*.php') as $template) {
            $templates[$template] = $template;
        }

        return apply_filters('tfuse_form_category_template', $templates);
    }

    function single_template() {
        $templates = array();

        foreach (glob(TEMPLATE_POST . '/*.php') as $template) {
            $templates[$template] = $template;
        }

        return apply_filters('tfuse_form_single_template', $templates);
    }

    function categories($args = array()) {
        if (!isset($args['hide_empty']))
            $args['hide_empty'] = 0;

        $tfuse_categories = array();
        $tfuse_categories[0] = __('Select a category:', 'tfuse');
        $tfuse_categories_obj = get_categories($args);

        if (is_array($tfuse_categories_obj)) {
            foreach ($tfuse_categories_obj as $tfuse_cat) {
                $tfuse_categories[$tfuse_cat->cat_ID] = $tfuse_cat->cat_name;
            }
        }

        return apply_filters('tfuse_form_categories', $tfuse_categories, $args);
    }

    function dropdown_categories($opts) {
        if (isset($opts['options']))
            $args = $opts['options'];
        $args['echo'] = 0;

        if (!isset($args['selected']))
            $args['selected'] = $opts['value'];

        if (!isset($args['show_option_none']))
            $args['show_option_none'] = __('Select a category:', 'tfuse');

        if (!isset($args['name']))
            $args['name'] = $opts['id'];

        if (!isset($args['id']))
            $args['id'] = $opts['id'];

        if (!isset($args['hide_empty']))
            $args['hide_empty'] = 0;

        if (!isset($args['hierarchical']))
            $args['hierarchical'] = 1;

        $tfuse_categories = wp_dropdown_categories($args);

        return apply_filters('tfuse_form_dropdown_categories', $tfuse_categories, $opts);
    }

    function pages($args = array()) {
        if ($args == '')
            $args = 'sort_column=post_parent,menu_order';
        $tfuse_pages = array();
        $tfuse_pages[0] = __('Select a page:', 'tfuse');
        $tfuse_pages_obj = get_pages($args);

        if (is_array($tfuse_pages_obj)) {
            foreach ($tfuse_pages_obj as $tfuse_page) {
                $tfuse_pages[$tfuse_page->ID] = $tfuse_page->post_title;
            }
        }

        return apply_filters('tfuse_form_pages', $tfuse_pages, $args);
    }

    function dropdown_pages($opts) {
        if (isset($opts['options']))
            $args = $opts['options'];
        $args ['echo'] = 0;

        if (!isset($args['selected']))
            $args['selected'] = $opts['value'];

        if (!isset($args['show_option_none']))
            $args['show_option_none'] = __('Select a page:', 'tfuse');

        if (!isset($args['name']))
            $args['name'] = $opts['id'];

        if (!isset($args['id']))
            $args['id'] = $opts['id'];

        if (!isset($args['hide_empty']))
            $args['hide_empty'] = 0;

        $tfuse_categories = wp_dropdown_pages($args);
        return apply_filters('tfuse_form_dropdown_pages', $tfuse_categories, $opts);
    }

    function posts($args = array(), $title = 'Select a post:') {
        if ($args == '')
            $args = 'numberposts=-1';
        $tfuse_posts = array();
        $tfuse_posts[0] = __($title, 'tfuse');
        $tfuse_posts_obj = get_posts($args);

        if (is_array($tfuse_posts_obj)) {
            foreach ($tfuse_posts_obj as $tfuse_post) {
                $tfuse_posts[$tfuse_post->ID] = $tfuse_post->post_title;
            }
        }
        return apply_filters('tfuse_form_posts', $tfuse_posts, $args);
    }

    function tags($args = array('get' => 'all')) {
        if (!isset($args ['get']))
            $args['get'] = 'all';

        $post_txt = 'posts';
        $images_txt = 'with images';

        if (isset($args['short'])) {
            $post_txt = $images_txt = '';
        }

        $all_post_tags = array();
        $all_post_tags = get_terms('post_tag', $args);
        $tfuse_tags [0] = __('Select a tag:', 'tfuse');

        if (isset($args['count_images']) or isset($args['count_posts'])) {
            //get nr of posts with images for each tag
            $posts_images_tag = array();
            foreach ($all_post_tags as $post_tags) {
                $counttagposts = get_posts('tag=' . $post_tags->slug);
                $i = 0;

                //The Loop
                foreach ($counttagposts as $post) {
                    setup_postdata($post);
                    $key = $args['imgsource'];
                    $this->load->helper('GET_IMAGE');
                    $im = new TF_GET_IMAGE;
                    $im = $im->id($post->ID)->key($key)->from_src()->get_src();
                    if ($im != '')
                        $i++;
                }

                $posts_images_tag[$post_tags->slug] = $i; //nr of posts with images for this tag

                $tfuse_tags[$post_tags->slug] = $post_tags->name . ' (' . $post_tags->count . " $post_txt/" . $posts_images_tag [$post_tags->slug] . " $images_txt)";
            }
        } //end count images
        else {
            //get nr of posts with images for each tag
            foreach ($all_post_tags as $post_tags) {
                $tfuse_tags[$post_tags->slug] = $post_tags->name;
            }
        }

        return apply_filters('tfuse_form_tags', $tfuse_tags, $args);
    }

    function multi($opts) {
        $subtypes   = array_map('trim', (array)explode(',', $opts['subtype']));
        $first_type = array_shift( $tmp = $subtypes ); unset($tmp);

        if (taxonomy_exists($first_type))
            $type = 'taxonomy';
        elseif (post_type_exists($first_type))
            $type = 'post';

        $saved_data         = trim( ( isset($opts['value']) && $opts['value'] ) ? $opts['value'] : '');
        $saved_data_array   = array_map('trim', (array)explode(',', $saved_data));

        $output_values = '';
        if ($saved_data) {
            $saved_data = (array) explode(',', $saved_data);

            if ($type == 'taxonomy') {
                foreach ($saved_data as $sid) {
                    $term = null;
                    foreach($subtypes as $key=>$subtype){
                        if(false !== ($term = get_term($sid, $subtype))){
                            break;
                        } else {
                            unset($saved_data_array[$key]);
                            continue;
                        }
                    }
                    if($term === null) continue;

                    $output_values .= '<span><a rel="' . $sid . '" title="' . __('Remove', 'tfuse') . '" class="remove_multi_items ntdelbutton">x</a>&nbsp ' . $term->name . '</span>';
                }
            } elseif ($type == 'post') {
                foreach ($saved_data as $sid) {
                    $output_values .= '<span><a rel="' . $sid . '" title="' . __('Remove', 'tfuse') . '" class="remove_multi_items ntdelbutton">x</a>&nbsp ' . get_the_title($sid) . '</span>';
                }
            }
        }

        $output = '<div class="multiple_box">';
        $output .= '<input type="hidden" name="' . $opts['id'] . '" id="' . $opts['id'] . '" class="' . $opts['id'] . ' tfuse_option" value="' . esc_attr( implode(',', $saved_data_array) ) . '" />';
        $output .= '<input type="text" id="' . $opts['id'] . '_entries" name="' . $opts['id'] . '_entries" class="tfuse_suggest_input tfuse_' . $type . '_type tfuse_input_help_text" rel="' . esc_attr($opts['subtype']) . '" value="' . esc_attr( __('Type here to search', 'tfuse') ) . '" />';

        $output .= '<div id="' . $opts['id'] . '_titles" class="multiple_box_selected_titles tagchecklist">';
        $output .= '<span style="display:none;"><a rel="0" title="' . __('Remove', 'tfuse') . '" class="remove_multi_items ntdelbutton">x</a>&nbsp </span>';

        $output  .= $output_values;

        $output .= '</div>';
        $output .= '</div>';

        return apply_filters('tfuse_form_multi', $output, $opts);
    }

    function boxes($opts) {
        $output = '';
        for ($i = 1; $i <= $opts['count']; $i++) {

            $divider = ( array_key_exists('divider', $opts) && $opts['divider'] === TRUE ) ? ' divider' : '';
            $output .= '<div class="option option-' . $opts['type'] . '">';
            $output .= '<div class="option-inner">';
            $output .= '<label class="titledesc">' . $opts['name'] . ' ' . $i . '</label>';
            $output .= '<div class="formcontainer">';

            $output .= '<div class="how_to_populate">';

            //select box
            $output .= '<select name="' . $opts['id'] . $i . '" class="postform selector tfuse_option">';
            $output .= '<option value="">HTML (simple placeholder text gets applied) </option>';

            $s1 = $s2 = $s3 = '';
            $box_type = isset($opts['value'][$opts['id'] . $i]) ? $opts['value'][$opts['id'] . $i] : '';
            if ($box_type == 'post')
                $s1 = 'selected="selected"';
            if ($box_type == 'page')
                $s2 = 'selected="selected"';
            if ($box_type == 'widget')
                $s3 = 'selected="selected"';

            $output .= '<option ' . $s1 . ' value="post">Post</option>';
            $output .= '<option ' . $s2 . ' value="page">Page</option>';
            $output .= '<option ' . $s3 . ' value="widget">Widget</option>';

            $output .= '</select><br/>';

            //categories
            $s1 = $s2 = $s3 = '';
            if ($box_type != 'post')
                $s1 = 'hidden';

            $output .= '<span class="selected_post ' . $s1 . '">';

            $params['id'] = $opts['id'] . $i . '_post';
            $params['subtype'] = apply_filters('tfuse_form_boxes_categories_subtype', 'category');
            if (isset($opts['value'][$params['id']]))
                $params['value'] = $opts['value'][$params['id']];
            $output .= $this->multi($params);

            $output .= '<br/></span>';

            //pages
            if ($box_type != "page")
                $s2 = "hidden";
            $output .= '<span class="selected_page ' . $s2 . '">';

            $params['id'] = $opts['id'] . $i . '_page';
            $params['subtype'] = apply_filters('tfuse_form_boxes_pages_subtype', 'page');
            if (isset($opts['value'][$params['id']]))
                $params['value'] = $opts['value'][$params['id']];
            $output .= $this->multi($params);

            $output .= '<br/></span>';

            //widgets
            if ($box_type != 'widget')
                $s3 = 'hidden';

            $output .= '<span class="selected_widget ' . $s3 . '">';
            $output .= 'Please save this page, then head over to the <a href="widgets.php">widget page</a> and add widgets to the <a href="widgets.php">"' . $opts['name'] . ' ' . $i . ' Widget Area"</a>';
            $output .= '</span></div><br/><br/>';
            $output .= '</div>';
            $output .= '<div class="desc">' . $opts['desc'] . ' ' . $i . '</div>';
            $output .= '<div class="clear"></div>';
            $output .= '</div></div>';
            $output .= '<div class="clear' . $divider . '"></div>' . "\n";
        }

        return apply_filters('tfuse_form_boxes', $output, $opts);
    }

    function images($opts) {
        $i = 0;
        $output = '';

        foreach ($opts['options'] as $key => $option) {
            $i++;
            $checked = $selected = '';

            if (empty($opts['value']) && $i == 1) {
                $checked = ' checked="checked"';
                $selected = 'tfuse-meta-radio-img-selected';
            } elseif ($opts['value'] == $key) {
                $checked = ' checked="checked"';
                $selected = 'tfuse-meta-radio-img-selected';
            }

            $output .= '<div class="tfuse-meta-radio-img-box">';
            $output .= '<div class="tfuse-meta-radio-img-label">';
            $output .= '<input type="radio" id="tfuse-meta-radio-img-' . $opts['id'] . $i . '" class="checkbox tfuse-meta-radio-img-radio tfuse_option" value="' . esc_attr($key) . '" name="' . esc_attr($opts['id']) . '" ' . $checked . ' />';
            $output .= '&nbsp;' . esc_html($key) . '<div class="tfuse_spacer"></div>';
            $output .= '</div>';
            $output .= '<div class="thumb_radio_over ' . $selected . '" title="' . esc_attr($option[1]) . '"></div><img title="' . esc_attr($option[1]) . '" src="' . esc_url($option[0]) . '" alt="" class="tfuse-meta-radio-img-img" optval="' . esc_attr($key) . '" />';
            $output .= '</div>';
        }

        return apply_filters('tfuse_form_images', $output, $opts);
    }

    function hidden($opts)
    {
        $output = '<input type="hidden" id="'.$opts['id'].'" name="'.$opts['id'].'" value="'.$opts['value'].'" />';

        return apply_filters('tfuse_form_hidden', $output, $opts);
    }

    function upload($opts) {
        global $post;
        $id = $opts['id'];
        $type = $opts['type'];
        $upload = isset($opts['value']) ? esc_attr($opts['value']) : '';
        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        $opts['properties'] = $this->strip_props($opts['properties']);
        # assign some default properties
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'] = ' upload-input-text tfuse_option';
        $propstr = $this->propstr($opts['properties']);
        # /properties
        $media = (!empty($opts['media']) ) ? $opts['media'] : 'image';
        $post_type = ($media == 'image') ? 'tfuse_gallery_group_post' : 'tfuse_download_group_post';
        if(isset($post) && $post->post_type == 'products')
        $group = (!empty($post->ID)) ? $post_type($id.'_'.$post->ID): $post_type($id);
        else $group = (!empty($post->ID)) ? $post->ID: $post_type($id);
        $val = (!empty($upload) && $type == 'upload' ) ? $upload : '';

        $output = '<input ' . $propstr . ' name="' . $id . '" id="' . $id . '" type="text" value="' . esc_attr($val) . '" rel="' . $media . '" />';
        $output .= '<div class="upload_button_div"><a href="#" class="button upload_button" id="' . $id . '_button" rel="' . $group . '">' . __('Upload') . '</a> </div>';

        return apply_filters('tfuse_form_upload', $output, $opts);
    }

    function callback($opts) {
        $output = $this->callbacks->execute($opts);
        return $output;
    }

    function strip_props($arr) {
        if (array_key_exists('type', $arr))
            unset($arr['type']);
        if (array_key_exists('value', $arr))
            unset($arr['value']);
        if (array_key_exists('id', $arr))
            unset($arr['id']);
        if (array_key_exists('name', $arr))
            unset($arr['name']);
        if (array_key_exists('checked', $arr))
            unset($arr['checked']);
        return $arr;
    }

    function propstr($arr) {
        $out = '';
        foreach ($arr as $name => $value) {
            $out.=' ' . $name . '="' . esc_attr($value) . '" ';
        }
        return $out;
    }

    protected function _common_properties(&$opts) {
        #Workout of common properties, such as the required property, etc
        $out = array();
        if (isset($opts['required']) && $opts['required'] === TRUE) {
            $out['required'] = 'true';
        }
        return $out;
    }

    function captcha($opts){
        $out='';
        $class=$opts['properties']['class'];
        $class.="tfuse_captcha_reload";
        $propstr = $this->propstr($opts['properties']);
        $out.="<img  src='".TFUSE_EXT_URI."/". strtolower($opts["_class_name"])."/library/".$opts['file_name']."' class='tfuse_captcha_img' >";
        $out .="<input type='button'   class='".$class."' style='border:1px solid;'/>";
        $opts['properties']['class']="tfuse_captcha_input";
        $out.=$this->text($opts);
        return apply_filters('tfuse_form_captcha', $out, $opts);
    }

    function button($opts){
        $propstr='';
        isset($opts['properties']['class'])?$opts['properties']['class']." button":'';
        if(isset($opts['properties'])){
            $propstr = $this->propstr($opts['properties']);
        }
        $out="<input ".$propstr." type='".$opts['subtype']."' id='".$opts['id']."' name='".$opts['name']."' value='".$opts['value']."'/>";
        return apply_filters('tfuse_form_button', $out, $opts);
    }

    function delete_row($opts){
        $out="<div class='".$opts['class']."'></div>";
        return apply_filters('tfuse_form_delete', $out, $opts);
    }

    function selectable_code($opts){
        $opts['properties']['class'] = isset($opts['properties']['class'])?$opts['properties']['class'].' tfuse_selectable_code':'tfuse_selectable_code';
        $propstr = $this->propstr($opts['properties']);
        $output ='<span class="raw_option" id="' . $opts['id'] . '"><code '.$propstr.'>'.$opts['value'].'</code></span>';
        if (has_filter("tfuse_form_selectable_code_{$opts['id']}")) {
            return apply_filters("tfuse_form_selectable_code_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_selectable_code', $output, $opts);
    }

    function datepicker($opts){
        $pluginfolder = get_bloginfo('url') . '/wp-includes/js/jquery/ui';
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-datepicker', $pluginfolder . '/jquery.ui.datepicker.min.js', array('jquery', 'jquery-ui-core') );
        if(!$this->include->type_is_registered('datepicker_framework_js')){
            $this->include->register_type('datepicker_framework_js', TFUSE . '/static/javascript');
            $this->include->js('datepicker', 'datepicker_framework_js','tf_footer',11);
            $this->include->register_type('datepicker_framework_css', TFUSE . '/static/css');
            $this->include->css('datepicker', 'datepicker_framework_css');
            $this->include->js('popbox.min', 'datepicker_framework_js','tf_footer',10);
        }
        $out = '';
        $inp_class = (isset($opts['properties']['class'])) ? $opts['properties']['class'] : '';
        $inp_class .= (!isset($opts['popbox']) || count($opts['popbox']) == 0)? ' tfuse_datepicker' : '';
        $opts['properties']['class'] = $inp_class;
        $out .=((isset($opts['inp_name']) && trim($opts['inp_name']) != '')? '<label class="titledesc">'.$opts['inp_name'].':</label>':''). $this->text($opts);
        if(isset($opts['popbox']) && count($opts['popbox']) > 0){
            $out .='<div class="popbox tfuse_datepicker_popbox">
                          <a class="open" href="#"><div class="open_button"></div></a>
                             <div class="collapse">
                             <div class="box">
                             <div class="arrow"></div>
                             <div class="arrow-border"></div>
                             <div class="box_content">';
            foreach($opts['popbox'] as $key=>$pop_inp){
                if(!in_array(trim($key),array('with_datepickers','dependancy'))){
                    $class = (isset($pop_inp['properties']['class'])) ? $pop_inp['properties']['class'] : '';
                    $class .= (in_array($pop_inp['id'],$opts['popbox']['with_datepickers']))?' tfuse_datepicker':'';
                    if(isset($opts['popbox']['dependancy']) && count($opts['popbox']['dependancy']) > 0){
                        foreach($opts['popbox']['dependancy'] as $Dkey => $value)
                            if(trim($value) == trim($pop_inp['id']))
                                $class .= ' '.$Dkey;
                    }
                    $pop_inp['properties']['class'] = $class;
                    $out .= '<label for="'.$pop_inp['id'].'">'.$pop_inp['name'].':</label>'.$this->$pop_inp['type']($pop_inp);
                }

            }
            $out .= '</div>
    <a href="#" class="close">close</a>
    <a href="#" class="excludedate_ok">Ok</a>
    </div>
    </div>
    </div>';
        }
        if (has_filter("tfuse_datepicker_{$opts['id']}")) {
            return apply_filters("tfuse_datepicker_{$opts['id']}", $out, $opts);
        }
        return apply_filters('tfuse_datepicker', $out, $opts);
    }

    function selectsearch($opts)
    {
        wp_enqueue_script('jquery');
        if(!$this->include->type_is_registered('chosen_js')){
            $this->include->register_type('chosen_js', TFUSE . '/static/javascript');
            $this->include->js('chosen.jquery.min', 'chosen_js', 'tf_head', 10, '0.9.8');
            $this->include->js('chosen_tfuse', 'chosen_js');
            $this->include->register_type('chosen_css', TFUSE . '/static/css');
            $this->include->css('chosen', 'chosen_css', 'tf_head', '0.9.8');
        }

        $class = ''; $style = '';
        if(isset($opts['properties']) && count($opts['properties']) > 0)
        {
            if(isset($opts['properties']['class'])) {
                if(!is_array($opts['properties']['class']))
                    $opts['properties']['class'] = array($opts['properties']['class']);
                $class = implode(' ', $opts['properties']['class']);
            }
            if(isset($opts['properties']['style']) and is_array($opts['properties']['style']) and count($opts['properties']['style']) > 0)
            {
                $styles = array();
                foreach($opts['properties']['style'] as $q=>$v)
                    $styles[] = $q.': '.$v;
                $style = 'style="'.implode('; ', $styles).'"';
            }
        }

        if(isset($opts['multiple']) and  $opts['multiple'] === true)
            $multiple = true;
        else $multiple = false;

        if(empty($opts['def_text']))
            $def_text = $opts['name'];
        else $def_text = $opts['def_text'];

        $out = '<select data-placeholder="'.$def_text.'" name="'.$opts['id'].'" id="'.$opts['id'].'" '.(($multiple === true)?'multiple':'').' class="tfuse_option tfuse-select'.((isset($opts['deselect']) && $opts['deselect'] === true)?'-deselect':'').' '.((isset($class))?$class:'').' '.((isset($opts['right']) and $opts['right'] == true)?'chzn-rtl':'').'" '.((isset($style))?$style:'').' '.((isset($opts['properties']['other']))?$opts['properties']['other']:'').'>'."\n";
        $out .= '<option value=""></option>'."\n";

        $value = array();
        if(isset($opts['value']) and !is_array($opts['value']))
            $value[] = $opts['value'];
        elseif(isset($opts['value'])) $value = $opts['value'];

        if(isset($opts['options']) and count($opts['options']) > 0)
            if(isset($opts['groups']) and $opts['groups'] === true)
            {
                foreach($opts['options'] as $q=>$v)
                {
                    $out .= '<optgroup label="'.$q.'">'."\n";
                    if(count($v) > 0)
                        foreach($v as $qq=>$vv)
                            $out .= '<option value="'.$qq.'" '.(count($value) > 0 && in_array($qq, $value)?'selected':'').'>'.$vv.'</option>'."\n";
                    $out .= '</optgroup>'."\n";
                }
            } else {
                foreach($opts['options'] as $q=>$v)
                    $out .= '<option value="'.$q.'" '.(count($value) > 0 && in_array($q, $value)?'selected':'').'>'.$v.'</option>'."\n";
            }

        $out .= '</select>'."\n";

        if (has_filter("tfuse_selectsearch_{$opts['id']}"))
            return apply_filters("tfuse_selectsearch_{$opts['id']}", $out, $opts);

        return apply_filters('tfuse_selectsearch', $out, $opts);
    }

    function maps($opts) {
        static $js_included = false;
        if(!$js_included){
            $js_included = true;
            $output = '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false"></script>';
        } else {
            $output = '';
        }

        wp_enqueue_script('jquery');
        if(!$this->include->type_is_registered('optigen_maps_js')){
            $this->include->register_type('optigen_maps_js', TFUSE . '/static/javascript');
            $this->include->js('googleMapsOptigen', 'optigen_maps_js', 'tf_footer', 10, '3');
        }

        $tmp    = explode(':', $opts['value']);
        $x      = ( is_numeric( ($x = (string)(@$tmp[0])) ) ? $x : '');
        $y      = ( is_numeric( ($y = (string)(@$tmp[1])) ) ? $y : '');
        if(trim($x) && trim($y)){
            $value = $x.':'.$y;
        } else {
            $value = $x = $y = '';
        }

        $output .= '<input id="'.esc_attr($opts['id']).'" name="'.esc_attr($opts['id']).'" type="hidden" value="' . esc_attr($value) . '" class="tf-optigen-input-maps" />';


        $output .= '<div><input id="'.esc_attr($opts['id']).'_x" type="text" value="' . esc_attr($x) . '" /></div>';
        $output .= '<div><input id="'.esc_attr($opts['id']).'_y" type="text" value="' . esc_attr($y) . '" /></div>';
        $output .=        '<div id="'.esc_attr($opts['id']).'_map" class="tf-optigen-input-maps-div' . (@$opts['desc'] ? '' : ' tf-optigen-input-maps-div-big') . '" ></div>';

        return $output;
    }
}