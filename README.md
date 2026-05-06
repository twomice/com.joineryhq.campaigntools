# CiviCRM: Joinery Campaign Tools

Collection of usability improvements for CiviCampaign:

* Adds a "campaign" column, to the contact Contributions tab; this column displays the name of the contribution campaign (if any);
* Appends the name of the activity campaign (if any) to the value of the "Type" column for each activity in the contact Contributions tab; 
* Accepts a `campaign` URL parameter in contributions pages and event pages, causing the newly created entities (contributions, participants, activities) to be associated with the given campaign.

The extension is licensed under [GPL-3.0](LICENSE.txt).

## Usage
* For any online registration form or contribution page, you can force the campaign for all newly created entities (contributions, participants, activities) by appending a `campaign` parameter to the page URL, in the format https://example.org/civicrm/contribute/transact?reset=1&id=7&campaign=N, where N is any valid campaign ID.
* On any contact's Activities tab, this extension displays the campaign, if any, for each activity, as a new line under the Type column.
* On any contact's Contributions tab, this extension adds a Campaign column, which displays the campaign, if any, of each contribution.
* Configuration is available under _Administer_ > _CiviCampaign_ > _CampainTools Settings_. Here you can specify whether or not to display Campaign on the Contributions and/or Activities tabs.

## Support

Support for this package is handled under Joinery's ["As-Is Support" policy](https://joineryhq.com/software-support-levels#as-is-support).

Public issue queue for this package: 
https://github.com/twomice/com.joineryhq.campaigntools/issues
