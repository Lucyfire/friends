<?php

namespace Drupal\friends\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;

/**
 * Defines dynamic local tasks.
 */
class DynamicLocalTasks extends DeriverBase {

  /**
   * A key => value pair of the allowed friends Types
   *
   * @var array
   */
  protected $friends_types;

  // protected

  public function __construct(){
    $this->friends_types = \Drupal::service('friends.default')->getAllowedTypes();
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    // Implement dynamic logic to provide values for the same keys as in example.links.task.yml.
    foreach ($this->friends_types as $key => $value) {
      $this->derivatives['friends.requests:' . $key] = $base_plugin_definition;
      $this->derivatives['friends.requests:' . $key]['title'] = t('Add as a @type', ['@type' => $value]);
      $this->derivatives['friends.requests:' . $key]['route_name'] = 'friends.friends_api_controller_request';
      $this->derivatives['friends.requests:' . $key]['route_parameters'] = [
        'user' => \Drupal::routeMatch()->getRawParameter('user'),
        'type' => $key
      ];
      $this->derivatives['friends.requests:' . $key]['options'] = [
        'attributes' => [
          'id' => 'friends-api-add-as--' . $key,
          'class' => [
            'use-ajax'
          ],
        ],
      ];
    }

    return $this->derivatives;
  }

}
