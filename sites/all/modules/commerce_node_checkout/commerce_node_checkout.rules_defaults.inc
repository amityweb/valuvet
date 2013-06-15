<?php
/**
 * @file
 * Provides default rules needed by the module
 * @copyright Copyright(c) 2011 Lee Rowlands
 * @license GPL v2 http://www.fsf.org/licensing/licenses/gpl.html
 * @author Lee Rowlands contact at rowlandsgroup dot com
 */

/**
 * Implementation of hook_default_rules_configuration().
 */
function commerce_node_checkout_default_rules_configuration() {
  $items = array();
  $items['commerce_node_checkout_publish_node'] = entity_import('rules_config', '{ "commerce_node_checkout_publish_node" : {
      "LABEL" : "Commerce Node Checkout Publish Node",
      "PLUGIN" : "reaction rule",
      "REQUIRES" : [ "commerce_node_checkout", "commerce_checkout" ],
      "ON" : [ "commerce_checkout_complete" ],
      "DO" : [
        { "commerce_node_checkout_publish_associated_nodes" : {
            "USING" : { "order" : [ "commerce-order" ] },
            "PROVIDE" : {
              "line_items" : { "line_items" : "Associated Line items" },
              "nodes" : { "nodes" : "Associated Nodes" }
            }
          }
        }
      ]
    }
  }');
  return $items;
}
