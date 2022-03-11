<?php
namespace Civi\Api4\Action\AttachmentImport;

use CRM_Attachmentimport_ExtensionUtil as E;
use Civi\Api4\Generic\Result;

class Import extends \Civi\Api4\Generic\AbstractAction {

  /**
   * Full path to import csv file.
   *
   * @var string
   * @required
   */
  protected $importfile = '';

  /**
   * Full path to folder where the attachments to be imported are waiting.
   *
   * @var string
   * @required
   */
  protected $attachmentsfolder;

  /**
   * @param \Civi\Api4\Generic\Result $result
   */
  public function _run(Result $result) {
    $this->attachmentsfolder = rtrim($this->attachmentsfolder, "/\\") . '/';
    $newFolder = rtrim(\CRM_Core_Config::singleton()->customFileUploadDir, "/\\") . '/';
    $fp = fopen($this->importfile, 'r');
    $header = fgetcsv($fp);
    // for now assume header looks like Attachment ID,Body,File Name,Parent ID,Parent.ID
    while (($row = fgetcsv($fp)) !== FALSE) {
      // Locate the contact based on the custom field.
      $contact = \Civi\Api4\Contact::get()
        ->addSelect('id')
        ->addWhere('Legacy_ID.Salesforce_Account_ID', '=', $row[3])
        ->execute()->first();
      if (empty($contact['id'])) {
        \Civi::log()->error("Unable to find contact matching {$row[3]}.");
        continue;
      }

      // It's usually prefixed with the attachment ID, but sometimes not.
      $filename = $this->attachmentsfolder . $row[0] . '_' . $row[2];
      if (!file_exists($filename)) {
        $filename = $this->attachmentsfolder . $row[2];
        if (!file_exists($filename)) {
          \Civi::log()->error("File {$filename} not found.");
          continue;
        }
      }

      // Copy the file into civi storage folder.
      // We don't need to worry about uniqueness since salesforce handles that.
      $newFilename = $newFolder . basename($filename);
      if (copy($filename, $newFilename) === FALSE) {
        \Civi::log()->error("Unable to copy {$filename} to {$newFilename}.");
        continue;
      }

      // guess mime type
      $mime = mime_content_type($newFilename) ?: 'application/octet-stream';

      // Create file record
      $fileResult = \Civi\Api4\File::create()
        ->addValue('mime_type', $mime)
        ->addValue('uri', basename($newFilename))
        ->addValue('description', $row[2])
        ->execute()->first();
      if (empty($fileResult['id'])) {
        \Civi::log()->error("Unable to create file record for {$newFilename}.");
        continue;
      }

      // Create custom field record
      \Civi\Api4\CustomValue::create('CS_Attachments')
        ->addValue('cs_attachment_file', $fileResult['id'])
        ->addValue('cs_attachment_description', E::ts('Imported'))
        ->addValue('entity_id', $contact['id'])
        ->execute();
    }
    fclose($fp);
  }

}
