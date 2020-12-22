<?php

require_once 'mailtolink.civix.php';
use CRM_Mailtolink_ExtensionUtil as E;

function mailtolink_civicrm_pageRun(&$page) {
  $supported_pages = array(
    'CRM_Contact_Page_View_Summary',
  );
  if (in_array($page->getVar('_name'), $supported_pages)) {
    CRM_Core_Resources::singleton()->addScriptFile('com.joineryhq.mailtolink', 'js/mailtolink_contactsummary.js');
  }
}

function mailtolink_civicrm_buildForm($formName, &$form) {
  $supported_forms = array(
    'CRM_Contact_Form_Search_Basic',
    'CRM_Contact_Form_Search_Advanced',
  );
  if (in_array($formName, $supported_forms)) {
    $js_vars = array(
      'isProfileResults' => FALSE,
      'emailHeaderLabels' => array(),
    );

    if ($ufGroupId = CRM_Utils_Array::value('uf_group_id', $form->_formValues, CRM_Utils_Array::value('uf_group_id', $form->_submitValues))) {
      $js_vars['isProfileResults'] = TRUE;
      $api_params = array(
        'uf_group_id' => $ufGroupId,
        'field_name' => 'email',
        'is_active' => 1,
      );
      $result = civicrm_api3('uf_field', 'get', $api_params);
      if (!empty($result['values'])) {
        foreach ($result['values'] as $value) {
          $js_vars['emailHeaderLabels'][] = $value['label'];
        }
      }
    }
    else {
      $js_vars['emailHeaderLabels'][] = E::ts('Email');
    }

    CRM_Core_Resources::singleton()->addVars('mailtolink', $js_vars);
    CRM_Core_Resources::singleton()->addScriptFile('com.joineryhq.mailtolink', 'js/mailtolink_searchresults.js');
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function mailtolink_civicrm_config(&$config) {
  _mailtolink_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function mailtolink_civicrm_xmlMenu(&$files) {
  _mailtolink_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function mailtolink_civicrm_install() {
  return _mailtolink_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function mailtolink_civicrm_uninstall() {
  return _mailtolink_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function mailtolink_civicrm_enable() {
  return _mailtolink_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function mailtolink_civicrm_disable() {
  return _mailtolink_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function mailtolink_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _mailtolink_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function mailtolink_civicrm_managed(&$entities) {
  return _mailtolink_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function mailtolink_civicrm_caseTypes(&$caseTypes) {
  _mailtolink_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function mailtolink_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _mailtolink_civix_civicrm_alterSettingsFolders($metaDataFolders);
}
