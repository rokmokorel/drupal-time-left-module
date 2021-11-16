<?php

namespace Drupal\time_left\Services;

use \DateTime;
use \DateInterval;

/**
 * Class CalculateDaysLeft.
 */
class CalculateDaysLeft {

  private $date;
  
  public function __construct() {
  }
  
  // Dependancy injection podatkov v service.
  public function get_date(string $value) {
    $this->date = $value;
  }

  
  // Obdelava podatkov in vracanje podatka.
  public function post_days_left() {
    // $event_date = $this->calculate_time($date);
    $event_date = $this->calculate_time($this->date);
    
    date_default_timezone_set('Europe/Ljubljana');
    $current_date = new DateTime(date("Y-m-d H:i:s"));
    
    // preverimo ali je dogodek v prihodnosti in ni danes
    if ($event_date > $current_date && $this->na_isti_dan($event_date, $current_date)) {
      return "This event is happening today";
      // preverimo ali je dogodek danes
    } elseif ($event_date > $current_date) {
      return $this->days_difference($event_date, $current_date) . " days left until event starts";
      // sicer je dogodek mimo
    } else {
      return "This event already passed.";
    }
  }

  private static function na_isti_dan(DateTime $date1, DateTime $date2)
  {
    return $date1->format('Y-m-d') == $date2->format('Y-m-d');
  }

  private static function calculate_time(string $date) {
    // pretvori string v Datetime class
    $unix_timestap = strtotime(str_replace("T"," ", $date));
    $datetime = new DateTime(date("Y-m-d H:i:s", $unix_timestap));
    // zamakni cas za 2 uri
    $datetime->add(new DateInterval('PT1H'));
    // vrni Datetime
    return $datetime;
  }
  
  private static function days_difference($event_date, $current_date) {
    $interval = $current_date->diff($event_date)->format("%a");
    // ce je do dogodka manj kot 24 ur, vrnemo 1 dan, sicer razliko dni
    return ($interval == "0") ? "1" : $interval;
  }
}