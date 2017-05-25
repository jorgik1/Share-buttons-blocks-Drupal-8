<?php

namespace Drupal\share_button_blocks\Plugin\Block;

use Drupal\Component\Utility\Html;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'SocialFollowButtons' block.
 *
 * @Block(
 *  id = "social_follow_buttons",
 *  admin_label = @Translation("Social follow buttons"),
 * )
 */
class SocialFollowButtons extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'big_social_follow' => [
        'big_social_follow_appearance' => [
          'big_social_follow_shape' => '',
          'ul_attributes' => '',
        ],
        'big_social_follow_pages' => [
          'facebook' => '',
          'youtube' => '',
          'twitter' => '',
          'linkedin' => '',
          'googleplus' => '',
          'pinterest' => '',
          'tumblr' => '',
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $form['big_social_follow'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => $this->t('Follow buttons'),
    ];

    $form['big_social_follow']['big_social_follow_appearance'] = [
      '#type' => 'details',
      '#open' => TRUE,
      '#title' => $this->t('Appearance'),
    ];

    $form['big_social_follow']['big_social_follow_appearance']['big_social_follow_shape'] = [
      '#type' => 'select',
      '#title' => $this->t('Follow button shape'),
      '#options' => [
        'big-social-media--default' => $this->t('No style'),
        'big-social-media--uniform' => $this->t('Uniform'),
        'big-social-media--space' => $this->t('Space'),
        'big-social-media--round' => $this->t('Round'),
      ],
      '#default_value' => $this->configuration['big_social_follow']['big_social_follow_appearance']['big_social_follow_shape'],
    ];

    $form['big_social_follow']['big_social_follow_appearance']['ul_attributes'] = [
      '#type' => 'textfield',
      '#title' => $this->t('CSS class to ul tag'),
      '#default_value' => $this->configuration['big_social_follow']['big_social_follow_appearance']['ul_attributes'],
    ];

    $form['big_social_follow']['big_social_follow_pages'] = [
      '#type' => 'details',
      '#open' => FALSE,
      '#title' => $this->t('Social media channels'),
    ];

    $form['big_social_follow']['big_social_follow_pages']['facebook'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Facebook page'),
      '#default_value' => $this->configuration['big_social_follow']['big_social_follow_pages']['facebook'],
    ];

    $form['big_social_follow']['big_social_follow_pages']['youtube'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Youtube page'),
      '#default_value' => $this->configuration['big_social_follow']['big_social_follow_pages']['youtube'],
    ];

    $form['big_social_follow']['big_social_follow_pages']['twitter'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Twitter page'),
      '#default_value' => $this->configuration['big_social_follow']['big_social_follow_pages']['twitter'],
    ];

    $form['big_social_follow']['big_social_follow_pages']['linkedin'] = [
      '#type' => 'textfield',
      '#title' => $this->t('LinkedIn page'),
      '#default_value' => $this->configuration['big_social_follow']['big_social_follow_pages']['linkedin'],
    ];

    $form['big_social_follow']['big_social_follow_pages']['googleplus'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Google+ page'),
      '#default_value' => $this->configuration['big_social_follow']['big_social_follow_pages']['googleplus'],
    ];

    $form['big_social_follow']['big_social_follow_pages']['pinterest'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Pinterest page'),
      '#default_value' => $this->configuration['big_social_follow']['big_social_follow_pages']['pinterest'],
    ];

    $form['big_social_follow']['big_social_follow_pages']['tumblr'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Tumblr page'),
      '#default_value' => $this->configuration['big_social_follow']['big_social_follow_pages']['tumblr'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   *
   * Most block plugins should not override this method. To add submission
   * handling for a specific block type, override BlockBase::blockSubmit().
   *
   * @see \Drupal\Core\Block\BlockBase::blockSubmit()
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['big_social_follow'] = $form_state->getValue('big_social_follow');
    parent::submitConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $ul_attributes = $config['big_social_follow']['big_social_follow_appearance']['ul_attributes'];
    $links = $config['big_social_follow']['big_social_follow_pages'];
    $wrapper_class = $config['big_social_follow']['big_social_follow_appearance']['big_social_follow_shape'] !== 'big-social-media--default' ? $config['big_social_follow']['big_social_follow_appearance']['big_social_follow_shape'] : '';
    return [
      '#theme' => 'share_follow_block',
      '#wrapper_class' => Html::cleanCssIdentifier($wrapper_class),
      '#ul_attributes' => Html::cleanCssIdentifier($ul_attributes),
      '#links' => $links,
      '#title' => $config['label_display'] ? $config['label'] : $this->t('Contact with us'),
      '#attached' => [
        'library' => ['share_button_blocks/share_follow'],
      ],
    ];
  }

}
