<?php

namespace Drupal\specbee_time\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\specbee_time\TimeService;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides a 'Specbee Time' block.
 *
 * @Block(
 *  id = "specbee_time",
 *  admin_label = @Translation("SpecbeeTime"),
 * )
 */
class SpecbeeTimeBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * Stored Service SpecbeeTime.
   *
   * @var Drupal\specbee_time\TimeService
   */
  protected $specbeeTime;
  /**
   * Stored Service Config.
   *
   * @var Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $config;

  /**
   * Constructor.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, TimeService $time, ConfigFactoryInterface $configFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->specbeeTime = $time;
    $this->config = $configFactory->get('specbee_time.settings');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('specbee_time.custom_services'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $country = $this->config->get('country');
    $city = $this->config->get('city');
    $timezone = $this->config->get('timezone');

    $service = $this->specbeeTime;
    $dateTime = $service->getTimeOfZone($timezone);

    $build = [
      '#theme' => 'specbee_time_block',
      '#country' => $country,
      '#city' => $city,
      '#dateTime' => $dateTime,
      '#cache' => [
        'tags' => $this->config->getCacheTags(),
        'max-age' => $this->config->getCacheMaxAge(),
      ],
    ];
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
