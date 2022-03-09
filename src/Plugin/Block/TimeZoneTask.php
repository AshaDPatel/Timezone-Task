<?php

namespace Drupal\time_zone_task\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\time_zone_task\TimezoneTaskService;

/**
 * Provides a 'TimeZoneTask' block.
 *
 * @Block(
 *   id = "time_zone_task_block",
 *   admin_label = @Translation("Time Zone Task Block")
 * )
 */
class TimeZoneTask extends BlockBase implements ContainerFactoryPluginInterface {

   /**
   * @var \Drupal\time_zone_task\TimezoneTaskService
   */
    protected $timezoneTaskService;

    /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\time_zone_task\TimezoneTaskService $timezoneTaskService
   */
  public function __construct(array $configuration, $plugin_id, array $plugin_definition, TimeZoneTaskService $timezoneTaskService) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->timezoneTaskService = $timezoneTaskService;
  }
  
  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('time_zone_task.time_zone_task')
    );
  }
  
  /**
   * {@inheritdoc}
   */
  public function build()
  {
    
    $data = $this->timezoneTaskService->getAccurateData();
    $renderData = [
      '#theme' => 'time_zone_task',
      '#data' => $data,
    ];

    return $renderData;
  }

  public function getCacheMaxAge()
  {
    return 0;
  }
}