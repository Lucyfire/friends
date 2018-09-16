<?php

namespace Drupal\friends;

/**
 * Interface FriendsServiceInterface.
 */
interface FriendsServiceInterface {


  /**
   *  @return array A key => value array pairs of the allowed friend types
   */
  public function getAllowedTypes();

  /**
   *  @param bool If the return array will include all allowed statuses
   *  or only statuses that are allowed to be applied to the firend request
   *
   *  @return array A key => value array pairs of the allowed friend status
   */
  public function getAllowedStatus($all = FALSE);


}
