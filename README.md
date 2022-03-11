# com.chabadsuite.attachmentimport

Import attachments into a multivalued custom field for Contacts.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Getting Started

1. Contacts need to be imported first, with the Salesforce Account ID field containing the id that will be used in the import file to link attachments to contacts.
1. Put the csv import file on the server somewhere. It's currently expected to have a header: Attachment ID,Body,File Name,Parent ID,Parent.ID
1. Put the attachment files to be imported on the server somewhere. They will be copied by the import into the correct Civi storage location.
1. Either using Api4 Explorer, or the command line, run AttachmentImport.Import:
    `cv --user=admin api4 AttachmentImport.Import importfile=/path/to/importfile.csv attachmentsfolder=/path/to/temporary/location/of/attachment/files`
1. Optionally change the labels of the custom field group or fields as usual in the UI.

Note: Unlike most extensions where uninstalling will delete its custom fields, this extension will leave the fields when uninstalled, since there's not really any point keeping this extension installed once the import is complete.

## Requirements

* PHP v7.2+
* CiviCRM 5.36+

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl com.chabadsuite.attachmentimport@https://github.com/FIXME/com.chabadsuite.attachmentimport/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/FIXME/com.chabadsuite.attachmentimport.git
cv en attachmentimport
```
