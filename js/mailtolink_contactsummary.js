/**
 * JavaScript code to replace email addresses with mailto: links in contact summary,
 * for MailToLink extension.
 */

var mailtolink = {
  replaceLinks: function() {
    CRM.$('.crm-contact_email a.crm-popup').each(function() {
      var email = CRM.$(this).text().trim();
      var emailLink = CRM.$('<a/>', {
        class: 'mailto-link',
        href: 'mailto:' + email,
        title: ts('Send an email outside of CiviCRM'),
        html: email
      });
      CRM.$(this).after(emailLink);
      CRM.$(this).remove();
    });
  }
};

CRM.$(document).ready(function(){
  mailtolink.replaceLinks();
  CRM.$('div#email-block').on('crmLoad', function(e, data) {
    mailtolink.replaceLinks();
  });
});
