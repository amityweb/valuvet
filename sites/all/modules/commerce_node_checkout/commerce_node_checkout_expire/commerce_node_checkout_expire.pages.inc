<?php
/**
 * @file
 * Provides pages for commerce_node_checkout_expire
 * @copyright Copyright(c) 2011 Rowlands Group
 * @license GPL v2 http://www.fsf.org/licensing/licenses/gpl.html
 * @author Lee Rowlands leerowlands at rowlandsgroup dot com
 */

/**
 * Provides form to enable a user to relist an expired/expiring node
 */
function commerce_node_checkout_expire_relist_form($form, $form_state, $node) {
  $form['node'] = array(
    '#value' => $node,
    '#type' => 'value'
  );
  $products = commerce_node_checkout_get_products_by_type($type);
  if (count($products) > 1) {
    $form['product'] = array(
      '#type' => 'select',
      '#title' => t('Listing option'),
      '#options' => $products,
      '#description' => t('Select your desired listing option.'),
    );
  }
  else {
    $form['product'] = array(
      '#type' => 'value',
      '#value' => array_shift(array_keys($products))
    );
  }
  $form = array(
    '#markup' => t('Relist form goes here')
  );
  return $form();
}

/**
 * Submit handler for commerce_node_checkout_expire_relist_form
 * @see commerce_node_checkout_expire_relist_form_validate
 */
function commerce_node_checkout_expire_relist_form_submit($form, &$form_state) {
  $product_id = $form_state['values']['product'];
  $product = commerce_product_load($product_id);
  commerce_node_checkout_add_node($form_state['values']['node'], $product);
  $form_state['redirect'] = 'checkout';
}
