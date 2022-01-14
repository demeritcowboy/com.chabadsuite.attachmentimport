<?php
namespace Civi\Api4;

use \CRM_Attachmentimport_ExtensionUtil as E;

class AttachmentImport extends Generic\AbstractEntity {
  public static function getFields($checkPermissions = TRUE) {
    return (new Generic\BasicGetFieldsAction(__CLASS__, __FUNCTION__, function($getFieldsAction) {
      return [
        [
          'name' => 'importfile',
          'label' => E::ts('Import File'),
          'title' => E::ts('Import File'),
          'data_type' => 'String',
          'description' => 'Full path to csv import file.',
          'required' => TRUE,
        ],
        [
          'name' => 'attachmentsfolder',
          'label' => E::ts('Attachments Folder'),
          'title' => E::ts('Attachments Folder'),
          'data_type' => 'String',
          'description' => 'Full path to folder where attachments to be imported are waiting.',
          'required' => TRUE,
        ],
      ];
    }))->setCheckPermissions($checkPermissions);
  }
}
