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

    if ($ufGroupId = ($form->_formValues['uf_group_id'] ?? $form->_submitValues['uf_group_id'] ?? NULL)) {
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
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function mailtolink_civicrm_install() {
  return _mailtolink_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function mailtolink_civicrm_enable() {
  return _mailtolink_civix_civicrm_enable();
}
