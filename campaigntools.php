<?php

require_once 'campaigntools.civix.php';
use CRM_Campaigntools_ExtensionUtil as E;

/**
 * Implements hook_civicrm_pageRun().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_pageRun
 */

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function campaigntools_civicrm_buildForm($formName, &$form) {
  // Detect contribution page and contribution confirm page
  if (
      $formName === 'CRM_Contribute_Form_Contribution_Main'
      || $formName === 'CRM_Contribute_Form_Contribution_Confirm'
      || $formName === 'CRM_Event_Form_Registration_Register'
      || $formName === 'CRM_Event_Form_Registration_Confirm'
    ) {

    // Get the campaign id by the entryURL in the controler array
    $controller = $form->getVar('controller');
    // Process to get the campaign id in the parameter
    $params = explode('?', $controller->_entryURL);
    parse_str(end($params), $parseURL);

    // Remove amp; since it was not remove using parse_str
    foreach ($parseURL as $key => $value) {
      $newKey = str_replace('amp;', '', $key);

      // Check if campaign param exist
      if ($newKey === 'campaign') {
        // Check campaign param exist on database
        $campaignCount = civicrm_api3('Campaign', 'getcount', [
          'id' => $value,
        ]);

        // If campaign param exist on database, add campaign to values
        if ($campaignCount) {
          if (!empty($form->_values['event'])) {
            $form->_values['event']['campaign_id'] = $value;
          }
          else {
            $form->_values['campaign_id'] = $value;
          }
        }

        break;
      }
    }
  }
}

/**
 * Implements hook_civicrm_searchColumns().
 *
 */
function campaigntools_civicrm_searchColumns( $objectName, &$headers,  &$rows, &$selector ) {
  // Check if it is search contribution
  // !empty($rows) will prevent sql error if contact doesn't have contribution
  // campaigntools_show_campaign_in_contributions_tab setting is checked
  if (
    $objectName == 'contribution'
    && !empty($rows)
    && Civi::settings()->get('campaigntools_show_campaign_in_contributions_tab')
  ) {
    // Insert additional column header in the tab
    $insertedHeader = [
      'name' => E::ts('Campaign'),
      'field_name' => 'campaign',
      'direction' => CRM_Utils_Sort::DONTCARE,
      'weight' => 45,
    ];
    $headers[] = $insertedHeader;
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function campaigntools_civicrm_config(&$config) {
  _campaigntools_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function campaigntools_civicrm_install() {
  _campaigntools_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function campaigntools_civicrm_enable() {
  _campaigntools_civix_civicrm_enable();
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 */
// function campaigntools_civicrm_preProcess($formName, &$form) {

// } // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 */
function campaigntools_civicrm_navigationMenu(&$menu) {
  $pages = array(
    'settings_page' => array(
      'label' => E::ts('CampaignTools Settings'),
      'name' => 'CampaignTools Settings',
      'url' => 'civicrm/admin/campaigntools/settings?reset=1',
      'parent' => array('Administer', 'CiviCampaign'),
      'permission' => 'access CiviCRM',
    ),
  );

  foreach ($pages as $page) {
    // Check that our item doesn't already exist.
    $menu_item_properties = array('url' => $page['url']);
    $existing_menu_items = array();
    CRM_Core_BAO_Navigation::retrieve($menu_item_properties, $existing_menu_items);
    if (empty($existing_menu_items)) {
      // Now we're sure it doesn't exist; add it to the menu.
      $menuPath = implode('/', $page['parent']);
      unset($page['parent']);
      _campaigntools_civix_insert_navigation_menu($menu, $menuPath, $page);
    }
  }
}

/**
 * Log CiviCRM API errors to CiviCRM log.
 */
function _campaigntools_log_api_error(API_Exception $e, string $entity, string $action, array $params) {
  $logMessage = "CiviCRM API Error '{$entity}.{$action}': " . $e->getMessage() . '; ';
  $logMessage .= "API parameters when this error happened: " . json_encode($params) . '; ';
  $bt = debug_backtrace();
  $errorLocation = "{$bt[1]['file']}::{$bt[1]['line']}";
  $logMessage .= "Error API called from: $errorLocation";
  CRM_Core_Error::debug_log_message($logMessage);
}

/**
 * CiviCRM API wrapper. Wraps with try/catch, redirects errors to log, saves
 * typing.
 */
function _campaigntools_civicrmapi(string $entity, string $action, array $params, bool $silence_errors = TRUE) {
  try {
    $result = civicrm_api3($entity, $action, $params);
  }
  catch (API_Exception $e) {
    _campaigntools_log_api_error($e, $entity, $action, $params);
    if (!$silence_errors) {
      throw $e;
    }
  }

  return $result;
}
