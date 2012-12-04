<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AJAX
 *
 */
class TF_AJAX extends TF_TFUSE {

    public $_the_class_name = 'AJAX';
    protected $_ajax_actions = array();
    public $out_json = array();

    public function __construct() {
        parent::__construct();
    }

    public function __init() {
        add_action('init', array(&$this, 'init_action'), 99 );
    }

    public function init_action(){
        if ($this->input->is_ajax_request())
            $this->buffer->_no_signature = TRUE;
        $this->ajax_do();
        $this->include->js_enq('ajaxurl', admin_url('admin-ajax.php'));
    }

    public function ajax_do() {
        if (!$this->input->is_ajax_request())
            return;
        if (isset($_POST['action'])) {
            if (stripos($_POST['action'], 'tfuse_ajax') !== FALSE) {
                if (isset($_POST['tf_action'])) {
                    if (substr($_POST['tf_action'], 0, 1) == '_')
                        return 'Cannot access this action.';
                    $tf_ajax_action = strtolower($_POST['tf_action']);
                }
                else
                    return;
                if (method_exists($this, $tf_ajax_action)) {
                    $this->{$tf_ajax_action}();
                } else {
                    if (array_key_exists($_POST['action'], $this->_ajax_actions)) {
                        if (method_exists($this->_ajax_actions[$_POST['action']], $tf_ajax_action))
                            $this->_ajax_actions[$_POST['action']]->{$tf_ajax_action}();
                        else
                            die('There is no such ajax action: ' . $tf_ajax_action);
                    }
                }
            }
            else if (isset($_POST['tf_action'])) {
                if (substr($_POST['action'], 0, 9) == 'tf_action') {
                    if (function_exists($_POST['tf_action']))
                        $_POST['tf_action']();
                    else
                        die('This is not a valid ajax action: ' . $_POST['tf_action']);
                } else {
                    die('This is not a valid ajax action: ' . $_POST['tf_action']);
                }
            }
        }
    }

    public function ajax_finish() {
        if (count($this->out_json) > 0)
            echo json_encode($this->out_json);
        die();
    }

    function _verify_nonce($nonce) {
        if (!check_ajax_referer($nonce, '_ajax_nonce', FALSE))
            die(json_encode(array('status' => -1, 'message' => 'Troll detected.')));
    }

    function _add_action($action_name, &$instance) {
        $this->_ajax_actions[$action_name] = $instance;
    }

    public function __destruct() {
        die();
    }

}