function followAction(userID, youtuberID, youtuberUsername, action, event) {
  event.preventDefault();
  var dataString = 'userID=' + userID + '&youtuberID=' + youtuberID + '&action=' + action;

  $.ajax({
    type: "POST",
    url: "https://www.watchify.io/followAction.php",
    data: dataString,
    success: function() {
      if (action == 1) {
        Materialize.toast('You\'re now following ' + youtuberUsername, 3000);
        $('.add-button-' + youtuberID).fadeIn(200).hide();
        $('.del-button-' + youtuberID).fadeIn(200).show();
      } else if (action == 2) {
        Materialize.toast('You unfollowed ' + youtuberUsername, 3000);
        $('.hover-del-button-' + youtuberID).fadeIn(200).hide();
        $('.hover-add-button-' + youtuberID).fadeIn(200).hide();
      }
    }
  });
}

function markVideo(id, userID, youtuberID, videoID, action, event) {
  event.preventDefault();
  var dataString = 'userID=' + userID + '&youtuberID=' + youtuberID + '&videoID=' + videoID + '&action=' + action;

  $.ajax({
    type: "POST",
    url: "https://www.watchify.io/markVideo.php",
    data: dataString,
    success: function() {
      Materialize.toast('Video marked as ' + (action == 1 ? 'read' : 'unread'), 3000);
      var iframeID = '#iframe-id-' + id;
      var linkID = '#link-mark-id-' + id;
      if (action == 1) {
        $(iframeID).fadeTo( "slow" , 0.1, function() {
          $(linkID).attr('onclick', 'markVideo(' + id + ',' + userID + ',' + youtuberID + ', "' + videoID + '", 2, event)');
          $(linkID).text('Mark video as unread');
        });
      } else if (action == 2) {
        $(iframeID).fadeTo( "slow" , 1, function() {
          $(linkID).attr('onclick', 'markVideo(' + id + ',' + userID + ',' + youtuberID + ', "' + videoID + '", 1, event)');
          $(linkID).text('Mark video as read');
        });
      }
    }
  });
}

function flagVideo(id, userID, youtuberID, videoID, action, event) {
  event.preventDefault();
  var dataString = 'userID=' + userID + '&youtuberID=' + youtuberID + '&videoID=' + videoID + '&action=' + action;

  $.ajax({
    type: "POST",
    url: "https://www.watchify.io/flagVideo.php",
    data: dataString,
    success: function() {
      Materialize.toast('Video ' + (action == 1 ? 'unflaged' : 'flaged'), 3000);
      var linkID = '#link-flag-id-' + id;
      if (action == 1) {
        $(linkID).attr('onclick', 'flagVideo(' + id + ',' + userID + ',' + youtuberID + ', "' + videoID + '", 2, event)');
        $(linkID).text('Flag video');
      } else if (action == 2) {
        $(linkID).attr('onclick', 'flagVideo(' + id + ',' + userID + ',' + youtuberID + ', "' + videoID + '", 1, event)');
        $(linkID).text('Unflag video');
      }
    }
  });
}