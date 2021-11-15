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
  static function days_till_event($event_date, $current_date) {
    return $interval = $current_date->diff($event_date)->format("%a");
  }

  // MAIN METHOD excepts date and returns the string to be displayed
  public function time_left_logic($date) {
    $event_date = $this->calculate_time($date);
    // $event_date = new DateTime(date("Y-m-d H:i:s", strtotime("2022-08-15 00:00")));

    date_default_timezone_set('Europe/Ljubljana');
    $current_date = new DateTime(date("Y-m-d H:i:s"));

    // preverimo ali je dogodek v prihodnosti in ni danes
    if ($event_date > $current_date && $this->days_till_event($event_date, $current_date) != "0" ) {
      return $this->days_till_event($event_date, $current_date) . " days left until event starts";
    // preverimo ali je dogodek danes
    } elseif ($event_date > $current_date && $this->days_till_event($event_date, $current_date) == "0" ) {
      return "This event is happening today";
    // sicer je dogodek mimo
    } else {
      return "This event already passed.";
    }

  }

  public function build() {
    
    $node = \Drupal::routeMatch()->getParameter('node');
    $value = $node->get('field_date')->getValue();
    $value = $value[0]["value"];
    
    $value = self::time_left_logic($value);
    
    return [
      '#markup' => $this->t($value),
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

}
