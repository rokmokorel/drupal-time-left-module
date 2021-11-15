<?php

namespace Drupal\time_left\Plugin\Block;

use \DateTime;
use Drupal\Core\Block\BlockBase;
use Drupal\node\ContextProvider\NodeRouteContext;
// use Drupal\Core\Plugin\Context\ContextDefinition;
// use Drupal\Core\Annotation\ContextDefinition;
// use Drupal\Core\Annotation\Translation;

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
    // date_default_timezone_set('Europe/Ljubljana');
	  // $datum = "2022-3-1 00:00:00";
    // $date1 = new DateTime($datum);
    // $date2 = new DateTime(date("Y-m-d H:i:s"));
    // $izpis = $date1->diff($date2)->format('%d-%m-%y %h:%i:%s');
    
    // $entity = $this->getContextValue('node');
    // $izpis = var_dump($entity);
    return [
      '#markup' => $this->t('Test'),
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

}
