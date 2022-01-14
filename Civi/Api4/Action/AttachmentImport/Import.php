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
    // for now assume header looks like Attachment ID,Body,Created Date,File Name,Parent ID,Parent.ID
    while (($row = fgetcsv($fp)) !== FALSE) {
      // Locate the contact based on external_identifier
      $contact = \Civi\Api4\Contact::get()
        ->addSelect('id')
        ->addWhere('external_identifier', '=', $row[4])
        ->execute()->first();
      if (empty($contact['id'])) {
        \Civi::log()->error("Unable to find contact matching {$row[4]}.");
        continue;
      }

      $filename = $this->attachmentsfolder . $row[3];
      if (!file_exists($filename)) {
        \Civi::log()->error("File {$row[3]} not found.");
        continue;
      }

      // Copy the file into civi storage folder
      // Append a unique string - don't need to be cryptographically secure,
      // just if two files have the same name.
      $newFilename = $newFolder . $this->uniqifyFilename($row[3]);
      if (copy($filename, $newFilename) === FALSE) {
        \Civi::log()->error("Unable to copy {$row[3]} to {$newFilename}.");
        continue;
      }

      // guess mime type
      $mime = mime_content_type($newFilename) ?: 'application/octet-stream';

      // Create file record
      $fileResult = \Civi\Api4\File::create()
        ->addValue('mime_type', $mime)
        ->addValue('uri', basename($newFilename))
        ->addValue('description', $row[3])
        ->execute()->first();
      if (empty($fileResult['id'])) {
        \Civi::log()->error("Unable to create file record for {$row[3]}.");
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

  /**
   * e.g. myfile.docx => myfile_3287fd8d97.docx
   *
   * @param string $filename
   * @return string
   */
  private function uniqifyFilename(string $filename): string {
    $pos = strrpos($filename, '.');
    if ($pos === FALSE) {
      return $filename;
    }
    return substr($filename, 0, $pos) . '_' . uniqid('', TRUE) . substr($filename, $pos);
  }

}
