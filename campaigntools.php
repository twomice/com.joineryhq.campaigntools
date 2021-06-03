<?php

require_once 'campaigntools.civix.php';
use CRM_Campaigntools_ExtensionUtil as E;

/**
 * Implements hook_civicrm_pageRun().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_pageRun
 */
function campaigntools_civicrm_pageRun(&$page) {
  // Only take action on the Activities tab.
  if ($page->getVar('_name') == 'CRM_Activity_Page_Tab' && $page->_action == CRM_Core_Action::BROWSE) {
    CRM_Core_Resources::singleton()->addScriptFile('com.joineryhq.campaigntools', 'js/campaigntools.js');
  }
}

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
  if ($objectName == 'contribution' && !empty($rows)) {
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
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function campaigntools_civicrm_xmlMenu(&$files) {
  _campaigntools_civix_civicrm_xmlMenu($files);
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
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function campaigntools_civicrm_postInstall() {
  _campaigntools_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function campaigntools_civicrm_uninstall() {
  _campaigntools_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function campaigntools_civicrm_enable() {
  _campaigntools_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function campaigntools_civicrm_disable() {
  _campaigntools_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function campaigntools_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _campaigntools_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function campaigntools_civicrm_managed(&$entities) {
  _campaigntools_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function campaigntools_civicrm_caseTypes(&$caseTypes) {
  _campaigntools_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function campaigntools_civicrm_angularModules(&$angularModules) {
  _campaigntools_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function campaigntools_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _campaigntools_civix_civicrm_alterSettingsFolders($metaDataFolders);
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
// function campaigntools_civicrm_navigationMenu(&$menu) {
//   _campaigntools_civix_insert_navigation_menu($menu, NULL, array(
//     'label' => ts('The Page', array('domain' => 'com.joineryhq.campaigntools')),
//     'name' => 'the_page',
//     'url' => 'civicrm/the-page',
//     'permission' => 'access CiviReport,access CiviContribute',
//     'operator' => 'OR',
//     'separator' => 0,
//   ));
//   _campaigntools_civix_navigationMenu($menu);
// }
