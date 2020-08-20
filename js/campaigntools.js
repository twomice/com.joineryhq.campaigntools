/**
 * JavaScript code for com.joineryhq.campaigntools extension.
 */
CRM.$(document).ready(function($){
  // On trable draw, get the campaign name for each activity.
  CRM.$('table.contact-activity-selector-activity').on( 'draw.dt', function (e, settings) {
    var t = CRM.$(this);
    var dt = t.DataTable();
    var data = dt.rows('*').data();
    var ids = [];
    CRM.$(data).each( function(key, val) {
      ids.push(val.DT_RowId);
    });
    CRM.api3('Activity', 'get', {
      "sequential": 0,
      "id": {"IN":ids},
      "return": ["campaign_id"],
      "options": {"limit":ids.length},
      "api.Campaign.getsingle": {"return":["title"]}
    }).done(function(result) {
      // Remove any existing  campaign labels.
      t.find('tr div.campaigntools-campaign').remove();
      for (var i in result.values) {
        key = i;
        val = result.values[i];
        // $(this).find('tr#' + trId + '>'+ tdSelector).append('<div class="relationshipjobtitle-jobtitle"><em>(' + jobTitles[i] + ')</em></div>')
        if (CRM._.has(val, 'campaign_id')) {
          console.log(key, val['api.Campaign.getsingle'].title);
          console.log('tr#' + key, t.find('tr#' + key + ' td:first-child'));
          t.find('tr#' + key + ' td:first-child').append('<div class="campaigntools-campaign"><em>(' +  val['api.Campaign.getsingle'].title + ')</em></div>');
        }
      }
    });
  });
});
