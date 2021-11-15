<?php

namespace Drupal\time_left\Plugin\Block;

use \DateTime;
use \DateInterval;
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

  static function calculate_time(string $date) {
    // pretvori string v Datetime class
    $date_val= strtotime(str_replace("T"," ", $date));
    $datetime = new DateTime(date("Y-m-d H:i:s", $date_val));
    // zamakni cas za 2 uri
    $datetime->add(new DateInterval('PT2H'));
    // vrni string
    return $datetime;
  }

  static function prettyprint_date(DateTime $date) {
    return $date->format('Y-m-d H:i');
  }

  static function prettyprint_difference($interval) {
    return $interval->y . " let " . $interval->m . " mesecev " . $interval->d . " dni";
    # return $date->format('Y-m-d H:i');
  }

  public function time_left_logic(string $date) {
    $even_date = $this->calculate_time($date);
    date_default_timezone_set('Europe/Ljubljana');
    $current_date = new DateTime(date("Y-m-d H:i:s"));

    // preverimo ali je dogodek v prihodnosti
    if ($even_date > $current_date) {
      $interval = $current_date->diff($event_date);
      return $interval;
    // preverimo ali je dogodek tocno v tem trenutku
    } elseif ($even_date == $current_date) {
      return "Dogodek je sedaj";
    // sicer je dogodek mimo
    } else {
      return "Dogodek je mimo";
    }

  }

  public function build() {
    
    $node = \Drupal::routeMatch()->getParameter('node');
    $value = $node->get('field_date')->getValue();
    $value = $value[0]["value"];
    
    $value = self::time_left_logic($value);
    #$value = self::calculate_time($value);
    return [
      '#markup' => $this->t($value),
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

}
