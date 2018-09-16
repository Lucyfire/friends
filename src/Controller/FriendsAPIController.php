<?php

namespace Drupal\friends\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\mailsystem\MailsystemManager;
use Drupal\activity_creator\Plugin\ActivityActionManager;

use Drupal\user\UserInterface;
use Drupal\friends\Entity\Friends;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Ajax\RemoveCommand;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\friends\FriendsService;

/**
 * Class FriendsAPIController.
 */
class FriendsAPIController extends ControllerBase {

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;
  /**
   * Drupal\Core\Messenger\MessengerInterface definition.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;
  /**
   * Drupal\mailsystem\MailsystemManager definition.
   *
   * @var \Drupal\mailsystem\MailsystemManager
   */
  protected $mailManager;
  /**
   * Drupal\activity_creator\Plugin\ActivityActionManager definition.
   *
   * @var \Drupal\activity_creator\Plugin\ActivityActionManager
   */
  protected $activityManager;
  /**
   * Drupal\friends\FriendsStorage definition.
   *
   * @var \Drupal\friends\FriendsStorage
   */
  protected $friendsStorage;
  /**
   * Drupal\friends\FriendsService definition.
   *
   * @var \Drupal\friends\FriendsService
   */
  protected $friendsService;



  /**
   * Constructs a new FriendsAPIController object.
   */
  public function __construct(
    EntityTypeManagerInterface $entity_type_manager,
    MessengerInterface $messenger,
    MailsystemManager $plugin_manager_mail,
    ActivityActionManager $plugin_manager_activity_action_processor,
    FriendsService $friends_service
  ) {
    $this->entityTypeManager = $entity_type_manager;
    $this->messenger = $messenger;
    $this->mailManager = $plugin_manager_mail;
    $this->activityManager = $plugin_manager_activity_action_processor;
    $this->friendsStorage = $entity_type_manager->getStorage('friends');
    $this->friendsService = $friends_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('messenger'),
      $container->get('plugin.manager.mail'),
      $container->get('plugin.manager.activity_action.processor'),
      $container->get('friends.default')
    );
  }

  /**
   *  Creates a friend request of the specified type
   *
   * @return Drupal\Core\Ajax\AjaxResponse
   */
  public function request(UserInterface $user, string $type) {
    $response = new AjaxResponse();

    $allowed_types = $this->friendsService->getAllowedTypes();

    $friends = $this->friendsStorage->create([
      // 'user_id' => $this->currentUser()->id(),
      'recipient' => $user->id(),
      'friends_type' => $type
    ]);
    $friends->save();

    $content = [
      '#type' => 'item',
      '#markup' => $this->t('You have Requested to add this user as your @type', [
        '@type' => $allowed_types[$type]
      ]),
    ];
    $response->addCommand(new RemoveCommand('#friends-api-add-as--' . $type));

    $response->addCommand(new OpenModalDialogCommand($this->t('@type', [
        '@type' => $allowed_types[$type]
      ]),
      $content,
      ['width' => '50%']
    ));

    return $response;
  }

  /**
   *  Creates a friend request of the specified type
   *
   * @return Drupal\Core\Ajax\AjaxResponse
   */
  public function response(Friends $friends, string $status) {
    $response = new AjaxResponse();

    $allowed_status = $this->friendsService->getAllowedStatus();

    $friends->set('friends_status', $status)->save();
    $content = [
      '#type' => 'item',
      '#markup' => $this->t('You have accepted to @user as your @type', [
        '@user' => $friends->getOwner()->getUsername(),
        '@type' => $allowed_status[$status]
      ]),
    ];

    $response->addCommand(new RemoveCommand('.friends-api-response--' . $friends->id()));
    // $response->addCommand(new RemoveCommand('.api--' . $friends->id() . '--response'));
    $response->addCommand(new OpenModalDialogCommand($this->t('@type', [
        '@type' => $allowed_status[$status]
      ]),
      $content,
      ['width' => '50%']
    ));

    return $response;

  }

}
