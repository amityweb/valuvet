<?php
/**
 * @file
 * Provides default rules needed by the module
 */

/**
 * Implementation of hook_default_rules_configuration().
 */
function commerce_node_checkout_expire_default_rules_configuration() {
  $items = array();
  $items['commerce_node_checkout_unpublish_node'] = entity_import('rules_config', '{ "commerce_node_checkout_unpublish_node" : {
      "LABEL" : "Commerce Node Checkout Unpublish Node",
      "PLUGIN" : "reaction rule",
      "REQUIRES" : [ "rules", "commerce_node_checkout_expire" ],
      "ON" : [ "cron" ],
      "DO" : [
        { "commerce_node_checkout_expire_load_expiring_line_items" : {
            "USING" : { "timestamp" : "now" },
            "PROVIDE" : { "line_items" : { "line_items" : "Expiring line items" } }
          }
        },
        { "commerce_node_checkout_expire_load_expiring_nodes" : {
            "USING" : { "line_items" : [ "line_items" ] },
            "PROVIDE" : { "nodes" : { "nodes" : "Unpublished Nodes" } }
          }
        },
        { "LOOP" : {
            "USING" : { "list" : [ "nodes" ] },
            "ITEM" : { "node" : "Expired node" },
            "DO" : [ { "node_unpublish" : { "node" : [ "node" ] } } ]
          }
        }
      ]
    }
  }');
  $items['commerce_node_checkout_reminder'] = entity_import('rules_config', '{ "rules_commerce_node_checkout_reminder" : {
      "LABEL" : "Commerce Node Checkout Reminder",
      "PLUGIN" : "reaction rule",
      "ACTIVE" : false,
      "REQUIRES" : [ "rules", "commerce_node_checkout_expire" ],
      "ON" : [ "cron" ],
      "DO" : [
        { "commerce_node_checkout_expire_load_expiring_line_items" : {
            "USING" : { "timestamp" : "-10 days" },
            "PROVIDE" : { "line_items" : { "line_items" : "Expiring line items" } }
          }
        },
        { "commerce_node_checkout_expire_load_expiring_nodes" : {
            "USING" : { "line_items" : [ "line-items" ] },
            "PROVIDE" : { "nodes" : { "nodes" : "Expiring Nodes" } }
          }
        },
        { "LOOP" : {
            "USING" : { "list" : [ "nodes" ] },
            "ITEM" : { "node" : "Expiring node" },
            "DO" : [
              { "mail" : {
                  "to" : [ "node:author:mail" ],
                  "subject" : "Your node is expiring in 10 days",
                  "message" : "Hi [node:author:name],\u000D\u000A\u000D\u000AThe node [node:title] you bought is expiring in 10 days ([node:url]).\u000D\u000A\u000D\u000AKind regards",
                  "language" : [ "" ]
                }
              }
            ]
          }
        }
      ]
    }
  }');
  return $items;
}
