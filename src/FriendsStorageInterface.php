<?php

namespace Drupal\friends;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\user\UserInterface;

/**
 * Defines an interface for vote entity storage classes.
 */
interface FriendsStorageInterface extends EntityStorageInterface {

  /**
   *  Get friends of a user, optional paramater the type of friends to fetch
   *
   *  @param int|string $uid
   *  @param string $type_id
   *
   *  @return mixed
   */
  function getUserFriends($uid, $type_id = NULL);

  /**
   *  Gets the friendships between 2 users, with optional friendship type
   *
   *  @param int|string $uid
   *  @param string $type_id
   *  @param int|string $uid2
   *
   *  @return mixed
   */
  function getUserFriendship($uid, $uid2, $type_id = NULL);

  /**
   *  Delete all friend requests that user is involved in
   *
   *  @param int|string $uid
   *  @param int|string $uid2
   *  @param string $type_id
   */
  function deleteUsersFriends($uid);
}
