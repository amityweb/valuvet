<?php
/**
 * @file
 * Provides admin forms for commerce_node_checkout_expire
 * @copyright Copyright(c) 2011 Rowlands Group
 * @license GPL v2 http://www.fsf.org/licensing/licenses/gpl.html
 * @author Lee Rowlands leerowlands at rowlandsgroup dot com
 */

/**
 * Form builder
 */
function commerce_node_checkout_expire_admin_form($form, $form_state) {

  // Reminder emails.
  $form['commerce_node_checkout_expire_subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Expire reminder subject'),
    '#description' => t('Subject of email sent to user before their node is about to expire.'),
    '#default_value' => variable_get('commerce_node_checkout_expire_subject', 'Your listing is about to expire')
  );

  $form['commerce_node_checkout_expire_body'] = array(
    '#type' => 'textarea',
    '#title' => t('Expire reminder body'),
    '#description' => t('Body of email sent to user before their node is about to expire.'),
    '#default_value' => variable_get('commerce_node_checkout_expire_body', commerce_node_checkout_expire_default_expire_body())
  );

  // Display the list of available placeholders if token module is installed.
  if (module_exists('token')) {
    $form['token_help'] = array(
      '#theme' => 'token_tree',
      '#token_types' => array('node'),
    );
  }

  $form['commerce_node_checkout_expire_reminder'] = array(
    '#type' => 'select',
    '#field_suffix' => t(' days'),
    '#options' => drupal_map_assoc(range(0, 30)),
    '#title' => t('Expire reminder'),
    '#description' => t('Send email reminders to users this many days before their node is about to expire.'),
    '#default_value' => variable_get('commerce_node_checkout_expire_reminder', 2)
  );

  return system_settings_form($form);
}
