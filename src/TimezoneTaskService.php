<?php

namespace Drupal\time_zone_task;

use Drupal\Core\Config\ConfigFactoryInterface;


/**
 * Class TimeZoneTaskService
 * @package Drupal\time_zone_task\Services
 */
class TimezoneTaskService
{
  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->config = $configFactory->get('time_zone_task.settings');
  }

  public function getAccurateData()
  {
    $country = $this->config->get('country');
    $city = $this->config->get('city');
    $timezone = $this->config->get('timezone');

    date_default_timezone_set($timezone);
    $current_time = \Drupal::time()->getCurrentTime();
    $request_time = date('jS M Y - h:i A', $current_time);

    return array('country' => $country, 'city' => $city, 'timezone' => $timezone, 'time_zone_time' => $request_time);
  }

}