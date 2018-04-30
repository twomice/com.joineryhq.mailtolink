/**
 * JavaScript code to replace email addresses with mailto: links in search results,
 * for MailToLink extension.
 */


CRM.$(document).ready(function($){
  var table = $('input#toggleSelect').closest('table')
  var emailColumnPositions = [];

  if (CRM.vars.mailtolink.emailHeaderLabels.length > 0) {
    for (var i in CRM.vars.mailtolink.emailHeaderLabels)
    $(table).find('thead th').each(function(idx, el){
      if($(el).children('a').text().trim() == CRM.vars.mailtolink.emailHeaderLabels[i]) {
        emailColumnPositions.push((idx + 1))
      }
    })
  }


  if (emailColumnPositions.length > 0) {
    if (CRM.vars.mailtolink.isProfileResults) {
      for (var i in emailColumnPositions) {
        $(table).find('tbody tr td:nth-child('+ emailColumnPositions[i] +')').each(function(idx, el){
          var emailElement = $(el)
          var email = emailElement.text().trim();
          if (email != '') {
            emailElement.html('<a href="mailto:'+ email +'">' + email + '</a>')
          }
        })
      }
    }
    else {
      for (var i in emailColumnPositions) {
        $(table).find('tbody tr td:nth-child('+ emailColumnPositions[i] +') span').each(function(idx, el){
          var emailElement = $(el)
          var doNotEmail = emailElement.find('span.do-not-email').length
          if (!doNotEmail) {
            var email = emailElement.prop('title').trim();
            var emailTruncated = emailElement.text().trim();
            if (email != '') {
              emailElement.html('<a href="mailto:'+ email +'">' + emailTruncated + '</a>')
            }
          }
        })
      }
    }
  }
})