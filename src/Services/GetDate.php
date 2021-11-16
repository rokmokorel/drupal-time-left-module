<?php

namespace Drupal\time_left\Services;

use Drupal\node\ContextProvider\NodeRouteContext;

/**
 * Class GetDate.
 */
class GetDate {

  private $date;
  
  public function __construct() {
  }
  
  // Obdelava podatkov in vracanje podatka.
  public function get_raw_date() {
    $node_value = \Drupal::routeMatch()->getParameter('node')->get('field_date')->getValue();
    $date = $node_value[0]["value"];
    return $date;
  }
}
