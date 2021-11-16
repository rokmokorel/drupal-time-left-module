<?php

namespace Drupal\time_left\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\ContextProvider\NodeRouteContext;

/**
 * Provides a 'Time Left' Block.
 *
 * @Block(
 *   id = "time_left",
 *   admin_label = @Translation("Time Left"),
 *   category = @Translation("Time Left"),
 * )
 */
class TimeLeft extends BlockBase {

  /**
   * {@inheritdoc}
   */
  
  public function build() {
    
    // ustvarimo service in zahtevamo podatek
    $date_raw = \Drupal::service('time_left.get_date')->get_raw_date();
    
    // ustvarimo service in naredimo dependancy injection podatkov
    $days_left_service = \Drupal::service('time_left.calculate_days_left');
    $days_left_service->set_date($date_raw);

    return [
      '#markup' => $days_left_service->get_days_left(),
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

}
