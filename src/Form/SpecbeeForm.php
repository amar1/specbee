<?php

namespace Drupal\specbee\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Timezone configuration form.
 */
class SpecbeeForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'specbee_configuration_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('specbee.adminsettings');
    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#description_display' => 'after',
      '#default_value' => ($config->get('country') ? $config->get('country') : ''),
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#description_display' => 'after',
      '#default_value' => ($config->get('city') ? $config->get('city') : ''),
    ];

    $timezone = [
      "America/Chicago" => $this->t("America/Chicago"),
      "America/New_York" => $this->t("America/New_York"),
      "Asia/Tokyo" => $this->t("Asia/Tokyo"),
      "Asia/Dubai" => $this->t("Asia/Dubai"),
      "Asia/Kolkata" => $this->t("Asia/Kolkata"),
      "Europe/Amsterdam" => $this->t("Europe/Amsterdam"),
      "Europe/Oslo" => $this->t("Europe/Oslo"),
      "Europe/London" => $this->t("Europe/London"),
    ];

    $form['timezone'] = [
      '#type' => 'select',
      '#options' => $timezone,
      '#title' => $this->t('Timezone'),
      '#required' => TRUE,
      '#default_value' => ($config->get('timezone') ? $config->get('timezone') : ''),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $country = $form_state->getValue('country');
    $city = $form_state->getValue('city');
    $timezone = $form_state->getValue('timezone');

    parent::submitForm($form, $form_state);
    $this->config('specbee.adminsettings')
      ->set('country', $country)
      ->set('city', $city)
      ->set('timezone', $timezone)
      ->save();
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'specbee.adminsettings',
    ];
  }

}
