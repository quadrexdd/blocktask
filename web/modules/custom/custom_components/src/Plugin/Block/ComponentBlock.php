<?php

namespace Drupal\custom_components\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "custom_component_block",
 *   admin_label = @Translation("Custom block with different colors as bg"),
 *   category = @Translation("custom_components")
 * )
 */
class ComponentBlock extends BlockBase
{
  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $config = $this->getConfiguration();
    $background_color = $config['background']['color'];
    $block_text = $config['background']['text'];
    $data = [
      'text' => $block_text,
      'color' => $background_color
    ];
    return [
      '#theme' => 'component_block',
      '#data' => $data,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state)
  {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();
    $form['background']['color'] = [
      '#type' => 'select',
      '#title' => $this->t('Background color'),
      '#description' => $this->t('Which color should be applied?'),
      '#default_value' => $config['background']['color'] ?? '',
      '#options' => [
        'green' => $this->t('Green'),
        'yellow' => $this->t('Yellow'),
        'red' => $this->t('Red'),
      ],
    ];
    $form['background']['text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Enter your text'),
      '#description' => $this->t('Write your text here.'),
      '#default_value' => $config['background']['text'] ?? '',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state)
  {
    parent::blockSubmit($form, $form_state);
    $this->setConfigurationValue('background', $form_state->getValue('background'));
  }


  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state)
  {
    if (empty($form_state->getValue('background'))) {
      $form_state->setErrorByName('background', t('This field is required'));
    }
  }

  /**
   * {@inheritdoc}
   * return 0 If you want to disable caching for this block.
   */
  public function getCacheMaxAge()
  {
    return 0;
  }
}
