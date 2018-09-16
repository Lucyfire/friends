<?php

namespace Drupal\friends;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\friends\Entity\FriendsInterface;

/**
 * Class FriendsService.
 */
class FriendsService implements FriendsServiceInterface {

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;
  /**
   * Drupal\Core\Entity\EntityFieldManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a new FriendsService object.
   */
  public function __construct(
    EntityTypeManagerInterface $entity_type_manager,
    EntityFieldManagerInterface $entity_field_manager,
    ConfigFactoryInterface $config_factory
  ) {
    $this->entityTypeManager = $entity_type_manager;
    $this->entityFieldManager = $entity_field_manager;
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public function getAllowedTypes() {
    return $this->entityFieldManager->getFieldDefinitions('friends', 'friends')['friends_type']->getSetting('allowed_values');
  }

  /**
   * {@inheritdoc}
   */
  public function getAllowedStatus($all = FALSE) {
    $statuses = $this->entityFieldManager->getFieldDefinitions('friends', 'friends')['friends_status']->getSetting('allowed_values');
    if(!$all) {
      unset($statuses['pending']);
    }

    return $statuses;
  }

  public function getMessage(string $message, FriendsInterface $friends){
    $config = $this->configFactory->get('friends.settings');

    return $this->processTokens($config->get($message), $friends);
  }

  /**
   * {@inheritdoc}
   */
  protected function processTokens(string $str, FriendsInterface $friends) {
    return \Drupal::token()->replace($str, ['friends' => $friends], []);
  }

}
