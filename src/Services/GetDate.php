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
  public function postServiceData() {
    $node = \Drupal::routeMatch()->getParameter('node');
    $node_value = $node->get('field_date')->getValue();
    $date = $node_value[0]["value"];
    return $date;
  }
}
