<?php
/**
 * @file
 * Provides rules integration for commerce_node_checkout
 * @copyright Copyright(c) 2011 Lee Rowlands
 * @license GPL v3 http://www.fsf.org/licensing/licenses/gpl.html
 * @author Lee Rowlands contact at rowlandsgroup dot com
 */

/**
 * Implements hook_rules_action_info
 */
function commerce_node_checkout_rules_action_info() {
  $actions = array();

  $actions['commerce_node_checkout_publish_associated_nodes'] = array(
    'label' => t('Publish associated nodes'),
    'parameter' => array(
      'order' => array(
        'type' => 'commerce_order',
        'label' => t('The completed order')
      ),
    ),
    'provides' => array(
      'line_items' => array(
        'type' => 'list<commerce_line_item>',
        'label' => t('Associated Line items'),
        'description' => t('All line items that had associated nodes'),
      ),
      'nodes' => array(
        'type' => 'list<node>',
        'label' => t('Associated Nodes'),
        'description' => t('The associated nodes'),
      ),
    ),
    'group' => t('Commerce Node Checkout'),
  );
  return $actions;
}

/**
 * Rules action callback
 */
function commerce_node_checkout_publish_associated_nodes($order) {
  $wrapper = entity_metadata_wrapper('commerce_order', $order);
  $line_items = $nodes = array();
  foreach ($wrapper->commerce_line_items as $delta => $line_item_wrapper) {
    // Load and validate the specified product ID.
    $product = $line_item_wrapper->commerce_product->value();
    if ($product->type != 'commerce_node_checkout') {
      // We don't need this item.
      continue;
    }
    $line_items[] = $line_item_wrapper;
    $node = $line_item_wrapper->commerce_node_checkout_node->value();
    $node->status = 1;
    node_save($node);
    $nodes[] = $node;
  }
  return array('line_items' => $line_items, 'nodes' => $nodes);
}
