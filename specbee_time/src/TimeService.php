<?php

namespace Drupal\specbee_time;

use Drupal\Component\Datetime\Time;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides a block.
 *
 * @Block(
 *   id = "specbee_time_block",
 *   admin_label = @Translation("Specbee Time Block"),
 * )
 */
class TimeService {


  /**
   * Configuration Factory.
   *
   * @var Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Time.
   *
   * @var Drupal\Component\Datetime\Time
   */
  protected $time;

  /**
   * Date Formatter.
   *
   * @var Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * Constructor.
   */
  public function __construct(ConfigFactoryInterface $configFactory, Time $time, DateFormatter $dateFormatter) {
    $this->config_factory = $config_factory;
    $this->time = $time;
    $this->dateFormatter = $dateFormatter;
  }

  /**
   * Returns the current time in formatted form as per the timezone.
   */
  public function getTimeOfZone($timezone) {
    $timezone = $this->dateFormatter->format($this->time->getCurrentTime(), 'custom', 'jS M Y h:i A', $timezone);

    return $timezone;
  }

}
