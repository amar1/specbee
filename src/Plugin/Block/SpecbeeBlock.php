<?php

namespace Drupal\specbee\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Provides a 'Specbee' Block.
 *
 * @Block(
 *   id = "specbee_block",
 *   admin_label = @Translation("Specbee Block"),
 *   category = @Translation("Specbee Block"),
 * )
 */
class SpecbeeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */

  protected $configFactory;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $configFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $configFactory;
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
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configFactory->getEditable('specbee.adminsettings');
    $timezone = $config->get('timezone');
    $datetime = new DrupalDateTime();
    $datetime->setTimezone(new \DateTimeZone($timezone));
    $date = $datetime->format('jS M Y H:i A');
    return [
      '#theme' => 'specbee_timezone',
      '#date' => $date,
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

}
