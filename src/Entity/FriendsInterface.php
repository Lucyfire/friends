<?php

namespace Drupal\friends\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Activity entities.
 *
 * @ingroup friends
 */
interface FriendsInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Activity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Activity.
   */
  public function getCreatedTime();

  /**
   * Sets the Activity creation timestamp.
   *
   * @param int $timestamp
   *   The Activity creation timestamp.
   *
   * @return \Drupal\friends\FriendsInterface
   *   The called Activity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Activity published status indicator.
   *
   * Unpublished Activity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Activity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Activity.
   *
   * @param bool $published
   *   TRUE to set this Activity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\friends\FriendsInterface
   *   The called Activity entity.
   */
  public function setPublished($published);

  /**
   * Get recipient user entity.
   *
   * @return \Drupal\user\UserInterface
   * Returns the user object of the recipient user
   */
  public function getRecipient();

  /**
   * Get recipient user id.
   *
   * @return integer
   * Returns the user id of the recipient user
   */
  public function getRecipientId();

  /**
   * Get the user entity of the user who last updated the entity.
   *
   * @return \Drupal\user\UserInterface
   */
  public function getUpdater();

  /**
   * Get the user id of the user who last updated the entity.
   *
   * @return integer
   */
  public function getUpdaterId();

  /**
   * Returns the friend request status.
   *
   * @return string
   */
  public function getStatus();

  /**
   * Returns the friend request type.
   *
   * @return string
   */
  public function getType();

  /**
   *  Returns url for responding to the friend request.
   *
   *  Ex: getStatusUrl('accepted') will return a url
   *  to accept this friend request
   *
   *  @param string $status
   *  The maching name of the status
   *
   *  @param array The Url options
   *
   * @return \Drupal\Core\Url
   */
  public function getStatusUrl(string $status, $options = []);



}
