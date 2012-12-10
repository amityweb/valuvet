<?php

if (!function_exists('mb_ucfirst')) {
    function mb_ucfirst($str, $encoding = "UTF-8", $lower_str_end = false) {
        $first_letter = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding);
        $str_end = "";
        if ($lower_str_end) {
            $str_end = mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encoding), $encoding), $encoding);
        }
        else {
            $str_end = mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
        }
        $str = $first_letter . $str_end;
        return $str;
    }
}


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

// ONLY Propery CUSTOM TYPE POSTS
add_filter('manage_property_posts_columns', 'tfuse_columns_head_only_properties', 10);
add_action('manage_property_posts_custom_column', 'tfuse_columns_content_only_properties', 10, 2);

function tfuse_columns_head_only_properties($defaults) {

    unset($defaults['date']);
    $defaults['prop_categories'] = 'Categories';
    $defaults['prop_locations'] = 'Locations';
    $defaults['prop_agents'] = 'Agents';
    $defaults['date'] = 'Date';
    return $defaults;
}
function tfuse_columns_content_only_properties($column_name, $post_ID) {
    switch($column_name)
    {
        case 'prop_categories' :
            $terms = wp_get_object_terms( $post_ID, 'property_category' );

            if(sizeof($terms))
            {
                $last_term = end($terms);
                reset($terms);
                $terms = array_slice($terms, 0, -1);
                if(sizeof($terms)) :
                    foreach($terms as $term)
                    {
                        echo '<a href="edit.php?post_type=property&property_category=' . $term->slug .'">'. $term->name .'</a>, ';

                    }
                endif;
                echo '<a href="edit.php?post_type=property&property_category=' . $last_term->slug .'">'. $last_term->name .'</a>';
            }
            else
                _e('No Category','tfuse');

            break;

        case 'prop_locations' :
            $terms = wp_get_object_terms( $post_ID, 'property_locations' );
            $terms1 = array();
            foreach($terms as $key => $term)
            {
                $terms1[$key]['parent'] = $term->parent;
                $terms1[$key]['name'] = $term->name;
                $terms1[$key]['slug'] = $term->slug;
            }

            $terms = tfuse_aasort($terms1,'parent');
            $terms = array_reverse($terms);
            if(sizeof($terms))
            {
                $last_term = end($terms);
                reset($terms);
                $terms = array_slice($terms, 0, -1);
                if(sizeof($terms)) :
                    foreach($terms as $term)
                    {
                        echo '<a href="edit.php?post_type=property&property_locations=' . $term['slug'] .'">'. $term['name'] .'</a>, ';

                    }
                endif;
                echo '<a href="edit.php?post_type=property&property_locations=' . $last_term['slug'] .'">'. $last_term['name'] .'</a>';
            }
            else
               _e('No Location','tfuse');

            break;

        case 'prop_agents' :
            $terms = wp_get_object_terms( $post_ID, 'property_agents' );

            if(sizeof($terms))
            {
                $last_term = end($terms);
                reset($terms);
                $terms = array_slice($terms, 0, -1);
                if(sizeof($terms)) :
                    foreach($terms as $term)
                    {
                        echo '<a href="edit.php?post_type=property&property_agents=' . $term->slug .'">'. $term->name .'</a>, ';

                    }
                endif;
                echo '<a href="edit.php?post_type=property&property_agents=' . $last_term->slug .'">'. $last_term->name .'</a>';
            }
            else
                _e('No Agent','tfuse');

            break;
    }
}

if (!function_exists('tfuse_get_term_parent')):

    /*
     * To override tfuse_get_term_parent() in a child theme, add your own tfuse_get_term_parent()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
    */

    function tfuse_get_term_parent( $term_id, $taxonomy ) {
        if ( ! taxonomy_exists($taxonomy) )
            return new WP_Error('invalid_taxonomy', __('Invalid taxonomy','tfuse'));

        $term_id = intval( $term_id );
        $parents = array();
        $term = get_term( $term_id, $taxonomy );
        $parent_id = $term->parent;
        $parents[] = $parent_id;
        while ( $parent_id != 0 )
        {
            $term = get_term( $parent_id, $taxonomy );
            $parent_id = $term->parent;
            $parents[] = $parent_id;
        }
        array_pop($parents);
        return $parents;
    }

endif;

if (!function_exists('tfuse_ajax_get_parents')) :
    /**
     *
     *
     * To override tfuse_ajax_get_parents() in a child theme, add your own tfuse_ajax_get_parents()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_ajax_get_parents ()
    {
        $id = intval($_POST['id']);
        $parents = tfuse_get_term_parent( $id,'property_locations');
        echo json_encode($parents);
        die();
    }

    add_action('wp_ajax_tfuse_ajax_get_parents','tfuse_ajax_get_parents');
    add_action('wp_ajax_nopriv_tfuse_ajax_get_parents','tfuse_ajax_get_parents');

endif;

if (!function_exists('tfuse_ajax_get_childs')) :
    /**
     *
     *
     * To override tfuse_ajax_get_childs() in a child theme, add your own tfuse_ajax_get_childs()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_ajax_get_childs ()
    {
        $id = intval($_POST['id']);
        $childs = get_term_children( $id,'property_locations');
        echo json_encode($childs);
        die();
    }

    add_action('wp_ajax_tfuse_ajax_get_childs','tfuse_ajax_get_childs');
    add_action('wp_ajax_nopriv_tfuse_ajax_get_childs','tfuse_ajax_get_childs');

endif;

if (!function_exists('tfuse_send_agent_email')) :
    /**
     *
     *
     * To override tfuse_send_agent_email() in a child theme, add your own tfuse_send_agent_email()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */
    function tfuse_send_agent_email()
    {
        $first_name = $_POST['first'];
        $last_name = $_POST['last'];
        $email = $_POST['email'];
        $message1 = $_POST['message'];
        $phone = $_POST['phone'];
        $contact = $_POST['contact'];
        $the_blogname       = esc_attr(get_bloginfo('name'));
        $contact_agent = tfuse_options('contact_agent',true);
        if($contact_agent)
        {
            $agent = get_the_terms(intval(@$_POST['prop_id']), TF_SEEK_HELPER::get_post_type() . '_agents');
            $the_myemail = '';
            if(!empty($agent[0]) && tfuse_options('agent_email',false,$agent[0]->term_id)) $the_myemail = tfuse_options('agent_email',false,$agent[0]->term_id);
            if (!filter_var($the_myemail, FILTER_VALIDATE_EMAIL)) $the_myemail 	= esc_attr(get_bloginfo('admin_email'));
        }
        else
        {
            $the_myemail 	= esc_attr(get_bloginfo('admin_email'));
        }

        $send_options = get_option(TF_THEME_PREFIX . '_tfuse_contact_form_general');

        $message = '';
        $message .= $message1 . "<br /><br />";
        if ($first_name != 'null' && $first_name != 'enter your first name') $message .= "<strong>".__('First Name:','tfuse')."</strong> " . $first_name . "<br />";
        if ($last_name != 'null' && $last_name != 'enter your last name') $message .= "<strong>".__('Last Name:','tfuse')."</strong> " . $last_name . "<br />";
        if ($phone != 'null') $message .= "<strong>".__('Phone:','tfuse')."</strong> " . $phone . "<br />";
        $message .= "<strong>".__('Email:','tfuse')."</strong> " . $email . "<br />";
        $message .= "<strong>".__('Property:','tfuse')."</strong> <a target=\"_blank\" href=\"" . get_permalink( intval(@$_POST['prop_id']) ) . "\">" . get_the_title( intval(@$_POST['prop_id']) ) . "</a> <br /><br />";
        if($contact == 'ct_email' ||$contact == 'ct_phone'/* || $contact == 'ct_both'*/)
        {
            $message .= __('I would prefer to be contacted by ','tfuse');
            switch($contact)
            {
                case 'ct_email' : $message .= 'email.';
                break;
                case 'ct_phone' : $message .= 'phone.';
                break;
            }


        }

        $headers = __('From:','tfuse') . $email;
        add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));

        if ($send_options['mail_type'] == 'wpmail')
        {
            if(wp_mail($the_myemail, 'From :' . $email . ' ' . $the_blogname, $message, $headers))
                echo 'true';
            else
                echo 'false';

            die();
        }
        elseif($send_options['mail_type'] == 'smtp')
        {
            require_once ABSPATH . WPINC . '/class-phpmailer.php';
            require_once ABSPATH . WPINC . '/class-smtp.php';
            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->IsHTML(true);
            $phpmailer->Port = $send_options['smtp_port'];
            $phpmailer->Host = $send_options['smtp_host'];
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPDebug = false;
            $phpmailer->SMTPSecure = ($send_options['secure_conn'] != 'no') ? $send_options['secure_conn'] : null;
            $phpmailer->Username = $send_options['smtp_user'];
            $phpmailer->Password = $send_options['smtp_pwd'];
            $phpmailer->From   = $email;
            $phpmailer->FromName   = $email;
            $phpmailer->Subject    = __('From :','tfuse') . $email . ' ' . $the_blogname;
            $phpmailer->Body       = $message;
            $phpmailer->AltBody    = __('To view the message, please use an HTML compatible email viewer!','tfuse');
            $phpmailer->WordWrap   = 50;
            $phpmailer->MsgHTML($message);
            $phpmailer->AddAddress($the_myemail);

            if(!$phpmailer->Send()) {
                echo "false" . $phpmailer->ErrorInfo;
            } else {
                echo "true";
            }
            die();
        }
        else
        {
            if(wp_mail($the_myemail, __('From :','tfuse') . $email . ' ' . $the_blogname, $message, $headers))
            {
                echo 'true';
                die();
            }
            else
            {
                echo 'false';
                die();
            }
        }
    }

endif;
    add_action('wp_ajax_tfuse_send_agent_email','tfuse_send_agent_email');
    add_action('wp_ajax_nopriv_tfuse_send_agent_email','tfuse_send_agent_email');
?>
