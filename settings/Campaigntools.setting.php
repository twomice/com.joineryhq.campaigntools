<?php

use CRM_Campaigntools_ExtensionUtil as E;

return array(
  'campaigntools_show_campaign_in_activities_tab' => array(
    'group_name' => 'Campaigntools',
    'group' => 'campaigntools',
    'name' => 'campaigntools_show_campaign_in_activities_tab',
    'add' => '5.0',
    'is_domain' => 1,
    'is_contact' => 0,
    'default' => 1,
    'description' => '',
    'title' => E::ts('Show campaign on Activities tab'),
    'type' => 'Boolean',
    'quick_form_type' => 'YesNo',
    'html_type' => 'Checkbox',
  ),
  'campaigntools_show_campaign_in_contributions_tab' => array(
    'group_name' => 'Campaigntools',
    'group' => 'campaigntools',
    'name' => 'campaigntools_show_campaign_in_contributions_tab',
    'add' => '5.0',
    'is_domain' => 1,
    'is_contact' => 0,
    'default' => 1,
    'description' => '',
    'title' => E::ts('Show campaign on Contributions tab'),
    'type' => 'Boolean',
    'quick_form_type' => 'YesNo',
    'html_type' => 'Checkbox',
  ),
);
