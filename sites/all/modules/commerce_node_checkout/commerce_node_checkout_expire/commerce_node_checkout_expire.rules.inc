<?php
/**
 * @file
 * Provides rules intergration for commerce_node_checkout_expire
 * @copyright Copyright(c) 2011 Rowlands Group
 * @license GPL v2 http://www.fsf.org/licensing/licenses/gpl.html
 * @author Lee Rowlands leerowlands at rowlandsgroup dot com
 */

/**
 * Implements hook_rules_action_info()
 */
function commerce_node_checkout_expire_rules_action_info() {
  $actions = array();
  $actions['commerce_node_checkout_expire_load_expiring_line_items'] = array(
    'label' => t('Load expiring line items'),
    'parameter' => array(
      'timestamp' => array(
        'type' => 'date',
        'label' => t('Expiration time'),
        'description' => t('Enter the time the node will expire. Enter date and time in format: <em>dd-mm-yyyy hh:mm:ss</em> or use relative time i.e. now, 1 day, 2 months, 1 year, 3 years.'),
      ),
    ),
    'provides' => array(
      'line_items' => array(
        'type' => 'list<commerce_line_item>',
        'label' => t('Expiring line items'),
        'description' => t('Expiring line items'),
      ),
    ),
    'group' => t('Commerce Node Checkout'),
  );

  $actions['commerce_node_checkout_expire_load_expiring_nodes'] = array(
    'label' => t('Load expiring nodes'),
    'parameter' => array(
      'line_items' => array(
        'type' => 'list<commerce_line_item>',
        'label' => t('Expiring line items'),
        'description' => t('Expiring line items'),
      ),
    ),
    'provides' => array(
      'nodes' => array(
        'type' => 'list<node>',
        'label' => t('Expiring Nodes'),
        'description' => t('The expiring nodes'),
      ),
    ),
    'group' => t('Commerce Node Checkout'),
  );
  return $actions;
}


/**
 * Rules action callback: Load line items
 */
function commerce_node_checkout_expire_load_expiring_line_items($time_string) {
  $query = new EntityFieldQuery();
  $query->entityCondition('entity_type', 'commerce_line_item');
  $query->entityCondition('bundle', 'commerce_node_checkout');
  $now = new DateObject($time_string);
  $query->fieldCondition('commerce_node_checkout_expires', 'value', $now->format('U'), '<=');
  $results = $query->execute();
  if (!empty($results['commerce_line_item'])) {
    return array('line_items' => commerce_line_item_load_multiple(array_keys($results['commerce_order'])));
  }
  return array('line_items' => array());
}


/**
 * Rules action callback: Unpublish associated nodes
 */
function commerce_node_checkout_expire_load_expiring_nodes($line_items) {
  $nodes = commerce_node_checkout_expire_nodes_from_line_items($line_items);
  return array('nodes' => $nodes);
}

/**
 * Util function to fetch nodes from line items
 *
 * @param array $line_items
 *   array of commerce_line_item objects
 *
 * @return array
 *   Array of node objects
 */
function commerce_node_checkout_expire_nodes_from_line_items($line_items) {
  $nodes = array();
  foreach ($line_items as $line_item) {
    $line_item_wrapper = entity_metadata_wrapper('commerce_line_item', $line_item);
    $node = $line_item_wrapper->commerce_node_checkout_node->value();
    $nodes[$node->nid] = $node;
  }
  return $nodes;
}
