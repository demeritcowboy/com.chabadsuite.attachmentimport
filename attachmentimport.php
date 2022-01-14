<?php

require_once 'attachmentimport.civix.php';
// phpcs:disable
use CRM_Attachmentimport_ExtensionUtil as E;
// phpcs:enable

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
  {
    "name": "fileses",
    "title": "fileses",
    "extends": "Contact",
    "style": "Tab with table",
    "is_multiple": true,
    "min_multiple": null,
    "max_multiple": null,
  }

  {
"name": "thefile",
    "custom_group_id": 13,
    "name": "thefile",
    "label": "thefile",
    "data_type": "File",
    "html_type": "File",
  },
  {
    "custom_group_id": 13,
    "name": "File_Description",
    "label": "File Description",
    "data_type": "String",
    "html_type": "Text",
  }
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

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function attachmentimport_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
//function attachmentimport_civicrm_navigationMenu(&$menu) {
//  _attachmentimport_civix_insert_navigation_menu($menu, 'Mailings', [
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ]);
//  _attachmentimport_civix_navigationMenu($menu);
//}
