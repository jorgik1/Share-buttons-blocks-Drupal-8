<?php

namespace Drupal\share_button_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\layout_plugin\Plugin\Layout\LayoutPluginManager;
use Drupal\metatag\MetatagToken;
use Drupal\node\Entity\Node;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'SocialSharingButtons' block.
 *
 * @Block(
 *  id = "social_sharing_buttons",
 *  admin_label = @Translation("Social sharing buttons"),
 * )
 */
class SocialSharingButtons extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Current Route.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  public $currentRouteMatch;

  /**
   * MetatagToken.
   *
   * @var \Drupal\metatag\MetatagToken
   */
  public $tokenService;

  /**
   * Layout manager.
   *
   * @var LayoutPluginManager
   */
  public $layoutPluginManager;

  /**
   * Chosen links.
   *
   * @var array
   */
  private $chosen;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, CurrentRouteMatch $currentRouteMatch, MetatagToken $tokenService, LayoutPluginManager $layoutPluginManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentRouteMatch = $currentRouteMatch;
    $this->tokenService = $tokenService;
    $this->layoutPluginManager = $layoutPluginManager;
    $this->chosen = [];
    // Get all templates, based on this module.
    $definitions = $this->layoutPluginManager->getDefinitions();
    foreach ($definitions as $item => $value) {
      if ($value['provider'] === 'share_button_blocks') {
        $this->chosen[$item] = $item;
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'big_social_share' => [
        'general' => [
          'big_social_style' => '',
          'ul_attributes' => '',
          'enable_attribute' => '',
          'rel_attributes' => '',
          'id_attribute' => '',
          'tokens' => [
            'enable' => '',
            'title' => '',
            'description' => '',
            'url' => '',
            'image_uri' => '',
          ],
        ],
        'big_social_facebook_appid' => '',
        'big_social_chosen' => $this->chosen,
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $defaults_chosen = $this->defaultConfiguration();

    $form['big_social_share'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => $this->t('Share buttons'),
    ];

    $form += $this->tokenService->tokenBrowser(['node', 'user']);
    $form['big_social_share']['general'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => $this->t('Settings'),
    ];

    $form['big_social_share']['general']['big_social_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Social button style'),
      '#options' => [
        'big-social-media--none' => $this->t('None'),
        'big-social-media--fixed' => $this->t('Fixed'),
        'big-social-media--inline' => $this->t('Static'),
      ],
      '#default_value' => $this->configuration['big_social_share']['general']['big_social_style'],
    ];

    $form['big_social_share']['general']['ul_attributes'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CSS class to ul tag'),
      '#default_value' => $this->configuration['big_social_share']['general']['ul_attributes'],
    ];

    $form['big_social_share']['general']['enable_attribute'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable attributes for links'),
      '#default_value' => $this->configuration['big_social_share']['general']['enable_attribute'],
    ];

    $form['big_social_share']['general']['rel_attributes'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Rel attribute'),
      '#default_value' => $this->configuration['big_social_share']['general']['rel_attributes'],
      '#states' => [
        'invisible' => [
          ':input[name="settings[big_social_share][general][enable_attribute]"]' => ['checked' => FALSE],
        ],
      ],
    ];

    $form['big_social_share']['general']['id_attribute'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Id attribute'),
      '#default_value' => $this->configuration['big_social_share']['general']['id_attribute'],
      '#states' => [
        'invisible' => [
          ':input[name="settings[big_social_share][general][enable_attribute]"]' => ['checked' => FALSE],
        ],
      ],
    ];

    $form['big_social_share']['general']['tokens'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => $this->t('Manage tokens for getting node-fields for sharing links'),
    ];

    $form['big_social_share']['general']['tokens']['enable'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable tokens'),
      '#default_value' => $this->configuration['big_social_share']['general']['tokens']['enable'],
    ];

    $form['big_social_share']['general']['tokens']['description'] = [
      '#type' => 'textfield',
      '#title' => $this->t('description'),
      '#default_value' => $this->configuration['big_social_share']['general']['tokens']['description'],
      '#states' => [
        'invisible' => [
          ':input[name="settings[big_social_share][general][tokens][enable]"]' => ['checked' => FALSE],
        ],
      ],
    ];

    $form['big_social_share']['general']['tokens']['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('title'),
      '#default_value' => $this->configuration['big_social_share']['general']['tokens']['title'],
      '#states' => [
        'invisible' => [
          ':input[name="settings[big_social_share][general][tokens][enable]"]' => ['checked' => FALSE],
        ],
      ],
    ];

    $form['big_social_share']['general']['tokens']['url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('url'),
      '#default_value' => $this->configuration['big_social_share']['general']['tokens']['url'],
      '#states' => [
        'invisible' => [
          ':input[name="settings[big_social_share][general][tokens][enable]"]' => ['checked' => FALSE],
        ],
      ],
    ];

    $form['big_social_share']['general']['tokens']['image_uri'] = [
      '#type' => 'textfield',
      '#title' => $this->t('image_uri'),
      '#default_value' => $this->configuration['big_social_share']['general']['tokens']['image_uri'],
      '#states' => [
        'invisible' => [
          ':input[name="settings[big_social_share][general][tokens][enable]"]' => ['checked' => FALSE],
        ],
      ],
    ];

    $form['big_social_share']['big_social_chosen'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Which buttons would you like to enable?'),
      '#options' => $defaults_chosen['big_social_share']['big_social_chosen'],
      '#default_value' => $this->configuration['big_social_share']['big_social_chosen'],
    ];

    $form['big_social_share']['big_social_facebook_appid'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Facebook app id'),
      '#description' => $this->t('Enter your Facebook app id.'),
      '#default_value' => $this->configuration['big_social_share']['big_social_facebook_appid'],
      '#states' => [
        'invisible' => [
          ':input[name="settings[big_social_share][big_social_chosen][facebook]"]' => ['checked' => FALSE],
        ],
      ],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['big_social_share'] = $form_state->getValue('big_social_share');
    parent::submitConfigurationForm($form, $form_state);
  }

  /**
   * Helping method for getting Node obj.
   */
  public function getNode() {
    /** @var \Drupal\node\NodeInterface $node */
    $node = $this->currentRouteMatch->getParameter('node');
    if ($node instanceof Node && $this->configuration['big_social_share']['general']['tokens']['enable']) {
      return [
        'url' => $this->tokenService->replace($this->configuration['big_social_share']['general']['tokens']['url'], ['node' => $node]),
        'title' => $this->tokenService->replace($this->configuration['big_social_share']['general']['tokens']['title'], ['node' => $node]),
        'image_uri' => $this->tokenService->replace($this->configuration['big_social_share']['general']['tokens']['image_uri'], ['node' => $node]),
        'description' => $this->tokenService->replace($this->configuration['big_social_share']['general']['tokens']['description'], ['node' => $node]),
      ];
    }
    return [
      // TODO: Need to figure out which of the fields will be using.
      // For now it's just tile fields.
      'url' => $node->toUrl()->setAbsolute(TRUE)->toString(),
      'title' => $node->getTitle(),
      'image_uri' => $node->hasField('field_tile_image') ? $node->get('field_tile_image')
        ->getValue() : '',
      'description' => $node->hasField('field_tile_text') ? $node->get('field_tile_text')->value : '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $facebook_id = $config['big_social_share']['big_social_facebook_appid'];
    foreach ($config['big_social_share']['big_social_chosen'] as $link => $value) {
      if (isset($value) && !empty($value)) {
        // Get instance of each layout.
        /** @var \Drupal\layout_plugin\Plugin\Layout\LayoutBase $layout */
        $layout = $this->layoutPluginManager->createInstance($link);
        // Pass to each layout variables.
        // This is very strange solution, but it works.
        $layout->setConfiguration([
          'link' => $this->getNode(),
          'link_class' => $link,
          'links_rel' => $config['big_social_share']['general']['enable_attribute'] ? $config['big_social_share']['general']['rel_attributes'] : '',
          'link_id' => $config['big_social_share']['general']['enable_attribute'] ? $config['big_social_share']['general']['id_attribute'] : '',
          'facebook_id' => (!empty($facebook_id) && $value === 'facebook') ? $facebook_id : NULL,
        ]);
        // Create renderable array for each template.
        $layouts[$link] = $layout->build([]);
      }
    }
    $build = [
      '#theme' => 'sharing_block',
      '#style' => $config['big_social_share']['general']['big_social_style'],
      '#ul_attributes' => $config['big_social_share']['general']['ul_attributes'],
      '#title' => $config['label_display'] ? $config['label'] : $this->t('Share this'),
      '#layouts' => $layouts,
    ];

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($configuration, $plugin_id, $plugin_definition, $container->get('current_route_match'), $container->get('metatag.token'), $container->get('plugin.manager.layout_plugin'), $container->get('twig'));
  }

}
