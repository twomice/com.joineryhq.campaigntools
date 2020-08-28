# CiviCRM: Joinery Campaign Tools

Collection of usability improvements for CiviCampaign:

* Adds a "campaign" column to the contact Activities tab; 
* Accepts a `campaign` URL parameter in contributions pages and event pages, causing the newly created entities (contributions, participants, activities) to be associated with the given campaign.

The extension is licensed under [GPL-3.0](LICENSE.txt).

## Usage
* No configuration is needed.
* This extension automatically adds a "campaign" column to the contact Activities tab, showing the campaign, if any, for each activity.
* For any online registration form or contribution page, you can force the campaign for all newly created entities (contributions, participants, activities) by appending a `campaign` parameter to the page URL, in the format https://example.org/civicrm/contribute/transact?reset=1&id=7&campaign=N, where N is any valid campaign ID.

## Support
![screenshot](/images/joinery-logo.png)

Joinery provides services for CiviCRM including custom extension development, training, data migrations, and more. We aim to keep this extension in good working order, and will do our best to respond appropriately to issues reported on its [github issue queue](https://github.com/twomice/com.joineryhq.campaigntools/issues). In addition, if you require urgent or highly customized improvements to this extension, we may suggest conducting a fee-based project under our standard commercial terms.  In any case, the place to start is the [github issue queue](https://github.com/twomice/com.joineryhq.campaigntools/issues) -- let us hear what you need and we'll be glad to help however we can.

And, if you need help with any other aspect of CiviCRM -- from hosting to custom development to strategic consultation and more -- please contact us directly via https://joineryhq.com

