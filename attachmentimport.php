<?php

require_once 'attachmentimport.civix.php';
use CRM_Attachmentimport_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function attachmentimport_civicrm_config(&$config) {
  _attachmentimport_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function attachmentimport_civicrm_xmlMenu(&$files) {
  _attachmentimport_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function attachmentimport_civicrm_install() {
  _attachmentimport_civix_civicrm_install();
  _attachmentimport_create_custom_fields();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function attachmentimport_civicrm_postInstall() {
  _attachmentimport_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function attachmentimport_civicrm_uninstall() {
  _attachmentimport_delete_custom_fields();
  _attachmentimport_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function attachmentimport_civicrm_enable() {
  _attachmentimport_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function attachmentimport_civicrm_disable() {
  _attachmentimport_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function attachmentimport_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _attachmentimport_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function attachmentimport_civicrm_managed(&$entities) {
  _attachmentimport_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Add CiviCase types provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function attachmentimport_civicrm_caseTypes(&$caseTypes) {
  _attachmentimport_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Add Angular modules provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function attachmentimport_civicrm_angularModules(&$angularModules) {
  // Auto-add module files from ./ang/*.ang.php
  _attachmentimport_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function attachmentimport_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _attachmentimport_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function attachmentimport_civicrm_entityTypes(&$entityTypes) {
  _attachmentimport_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function attachmentimport_civicrm_themes(&$themes) {
  _attachmentimport_civix_civicrm_themes($themes);
}

function _attachmentimport_create_custom_fields() {
  $custom_group = \Civi\Api4\CustomGroup::get(FALSE)
    ->addWhere('name', '=', 'CS_Attachments')
    ->addSelect('id')
    ->execute()->first();
  if (empty($custom_group['id'])) {
    $custom_group = \Civi\Api4\CustomGroup::create(FALSE)
      ->addValue('name', 'CS_Attachments')
      ->addValue('title', E::ts('Attachments'))
      ->addValue('extends', 'Contact')
      ->addValue('style', 'Tab with table')
      ->addValue('is_multiple', TRUE)
      ->addValue('min_multiple', NULL)
      ->addValue('max_multiple', NULL)
      ->execute()->first();
  }
  if (!empty($custom_group['id'])) {
    $custom_field = \Civi\Api4\CustomField::get(FALSE)
      ->addWhere('name', '=', 'cs_attachment_file')
      ->addSelect('id')
      ->execute()->first();
    if (empty($custom_field['id'])) {
      \Civi\Api4\CustomField::create(FALSE)
        ->addValue('custom_group_id', $custom_group['id'])
        ->addValue('name', 'cs_attachment_file')
        ->addValue('label', E::ts('Attachment'))
        ->addValue('data_type', 'File')
        ->addValue('html_type', 'File')
        ->addValue('in_selector', TRUE)
        ->addValue('weight', 1)
        ->execute();
    }
    $custom_field = \Civi\Api4\CustomField::get(FALSE)
      ->addWhere('name', '=', 'cs_attachment_description')
      ->addSelect('id')
      ->execute()->first();
    if (empty($custom_field['id'])) {
      \Civi\Api4\CustomField::create(FALSE)
        ->addValue('custom_group_id', $custom_group['id'])
        ->addValue('name', 'cs_attachment_description')
        ->addValue('label', E::ts('Description'))
        ->addValue('data_type', 'String')
        ->addValue('html_type', 'Text')
        ->addValue('in_selector', TRUE)
        ->addValue('weight', 2)
        ->execute();
    }
  }
}

function _attachmentimport_delete_custom_fields() {
  // We don't really want to do this, since there's no reason to keep this
  // extension installed after you've imported, so leave the custom fields.

  //\Civi\Api4\CustomField::delete(FALSE)
  //  ->addWhere('custom_group_id:name', '=', 'CS_Attachments')
  //  ->execute();
  //\Civi\Api4\CustomGroup::delete(FALSE)
  //  ->addWhere('name', '=', 'CS_Attachments')
  //  ->execute();
}
