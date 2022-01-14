<?php

namespace Civi\Api4\Action\AttachmentImport;

use Civi\Api4\Generic\Result;

class Import extends \Civi\Api4\Generic\AbstractAction {

  /**
   * Full path to import csv file.
   *
   * @required
   * @var string
   */
  protected $importfile = '';

  /**
   * Full path to folder where the attachments to be imported are waiting.
   *
   * @required
   * @var string
   */
  protected $attachmentsfolder;

  /**
   * @param Result $result
   */
  public function _run(Result $result) {
    $this->attachmentsfolder = rtrim('/\\', $this->attachmentsfolder) . '/';
    $fp = fopen($this->importfile, 'r');
    $header = fgetcsv($fp);
    // for now assume header looks like Attachment ID,Body,Created Date,File Name,Parent ID,Parent.ID
    while (($row = fgetcsv($fp)) !== FALSE) {
      $contact = \Civi\Api4\Contact::get()
        ->addSelect('id')
        ->addWhere('external_identifier', '=', $row[4]);
      if (empty($contact['id'])) {
        \Civi::log()->error("Unable to find contact matching {$row[4]}.");
      }
      else {
        $filename = $this->attachmentsfolder . $row[3];
        if (file_exists($filename)) {
          \Civi\Api4\CustomValue::create('fileses')
            ->addValue('thefile', $filename)
            ->addValue('File_Description', 'Imported')
            ->addValue('entity_id', $contact['id'])
            ->execute();
        }
        else {
          \Civi::log()->error("File {$row[3]} not found.");
        }
      }
    }
    fclose($fp);
  }

}
